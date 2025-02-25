<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'profile_photo_url' => $this->profile_photo_url,            
            'isAdmin' => $this->isAdmin(),
            'curriculum' => new CurriculumResource($this->whenLoaded('curriculum')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            $this->mergeWhen($this->isAdmin(), ['type' => $this->type]),
        ];
    }
}
