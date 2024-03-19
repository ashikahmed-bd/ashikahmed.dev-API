<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LicenseResource extends JsonResource
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
            'user' => $this->whenLoaded('user'),
            'product' => $this->whenLoaded('product'),
            'domain' => $this->domain,
            'license_key' => $this->license_key,
            'active' => $this->active == 0 ? false : true,
            'expiration_date' => $this->expiration_date,
            'is_trial' => $this->is_trial,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->created_at->diffForHumans(),
        ];
    }
}
