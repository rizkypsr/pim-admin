<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use YorCreative\UrlShortener\Services\UrlService;

class ShareCarController extends Controller
{
    public function index(Request $request)
    {
        $cars = collect();

        if ($request->has('data')) {
            $encodedParams = $request->input('data');
            $encryptedParams = base64_decode($encodedParams);

            try {
                $decryptedParams = Crypt::decryptString($encryptedParams);
                $params = json_decode($decryptedParams, true);

                $cars = Car::with(['city', 'carImages'])->where('share', 1)->filter($params)->get();
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                abort(400, 'Invalid data');
            }
        }

        $faq = Faq::where('name', 'wa')->first();

        $currentUrl = request()->fullUrl();

        try {
            $shortURL = UrlService::shorten($currentUrl)->build();
        } catch (\Exception $e) {
            $url = UrlService::findByPlainText($currentUrl);
            $shortURL = getenv('APP_URL').'/share/car/'.$url->identifier;
        }

        return view('share.index', compact('cars', 'faq', 'shortURL'));
    }

    public function encrypt(Request $request)
    {
        $params = [
            'price' => [
                '$gte' => $request->min_price,
                '$lte' => $request->max_price,
            ],
            'car_name' => ['$contains' => $request->car_name],
            'brand_name' => ['$contains' => $request->brand_name],
        ];

        if ($request->year) {
            $params['year'] = ['$eq' => $request->year];
        }

        if ($request->city_id) {
            $params['city_id'] = ['$eq' => $request->city_id];
        }

        $encryptedParams = Crypt::encryptString(json_encode($params));
        $encodedParams = base64_encode($encryptedParams);

        $url = route('share.index', ['data' => $encodedParams]);

        return redirect($url);
    }

    public function show($id)
    {

        $car = Car::with(['city', 'carImages'])->findOrFail($id);

        return view('share.show', compact('car'));
    }
}
