<?php

namespace App\Http\Resources;

use App\Helpers\WhatsappFormat;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonationResource extends JsonResource
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
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'video' => $this->video,
            'whatsapp_number' => $faq->value ?? null,
            'whatsapp_url' => $faq->value ? WhatsappFormat::format($faq->value) : null,
            'images' => DonationImageResource::collection($this->donationImages),
            'created_at' => $this->created_at,
        ];
    }
}
