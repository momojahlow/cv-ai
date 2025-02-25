<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
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
            'level' => $this->level,
            'type' => $this->type,
            'status' => $this->status,
            'start_date' => $this->start_date?->format('Y-m-d'),
            'end_date' => $this->end_date?->format('Y-m-d'),
            'school' => $this->school,
            'diploma' => $this->diploma,
            'description' => $this->description,
            'city' => $this->city,
            'country' => $this->country,
            'curriculum_id' => $this->curriculum_id,
        ];
    }
}
