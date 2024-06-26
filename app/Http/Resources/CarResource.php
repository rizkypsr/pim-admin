<?php

namespace App\Http\Resources;

use App\Helpers\WhatsappFormat;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $faq = Faq::where('name', 'wa')->first();

        return [
            'id' => $this->id,
            'car_name' => $this->car_name,
            'brand_name' => $this->brand_name,
            'video' => $this->video,
            'year' => $this->year,
            'price' => $this->price,
            'description' => $this->description,
            'whatsapp_number' => $faq->value ?? null,
            'whatsapp_url' => $faq->value ? WhatsappFormat::format($faq->value) : null,
            'showroom' => new ShowroomResource($this->showroom),
            'city' => $this->city ? $this->city->city_name : null,
            'province' => $this->city ? $this->city->province->province_name : null,
            'images' => CarImageResource::collection($this->carImages),
        ];
    }
}
