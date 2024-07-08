<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class PushNotificationController extends Controller
{
    public function index()
    {
        return view('notification.index');
    }

    public function sendPushNotification(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ];

        $messages = [
            'title.required' => 'Judul wajib diisi',
            'description.required' => 'Deskripsi wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $firebase = (new Factory)
            ->withServiceAccount(__DIR__.'/../../../config/firebase_credentials.json');

        $messaging = $firebase->createMessaging();

        $message = CloudMessage::fromArray([
            'notification' => [
                'title' => $request->title,
                'body' => $request->description,
            ],
            'topic' => 'global',
        ]);

        $messaging->send($message);

        return redirect()->route('notification.index')->with('success', 'Notifikasi berhasil dikirim.');
    }
}
