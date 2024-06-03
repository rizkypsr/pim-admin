<?php

namespace App\Http\Resources;

use App\Helpers\WhatsappFormat;
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
        return [
            'id' => $this->id,
            'car_name' => $this->car_name,
            'brand_name' => $this->brand_name,
            'video' => $this->video,
            'year' => $this->year,
            'price' => $this->price,
            'description' => $this->description,
            'whatsapp_number' => $this->whatsapp_number,
            'whatsapp_url' => WhatsappFormat::format($this->whatsapp_number),
            'showroom' => new ShowroomResource($this->showroom),
            'city' => new CityResource($this->city),
            'images' => CarImageResource::collection($this->carImages),
        ];
    }
}
