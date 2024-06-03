<?php

namespace App\Http\Resources;

use App\Helpers\WhatsappFormat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowroomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'showroom_name' => $this->showroom_name,
            'whatsapp_number' => $this->whatsapp_number,
            'whatsapp_url' => WhatsappFormat::format($this->whatsapp_number),
            'video' => $this->video,
            'city' => $this->city->city_name,
            'province' => $this->city->province->province_name,
            'images' => ShowroomImageResource::collection($this->showroomImages),
            'cars' => ShowroomCarResource::collection($this->cars),
        ];
    }
}
