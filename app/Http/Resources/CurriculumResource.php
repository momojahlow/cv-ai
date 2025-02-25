<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurriculumResource extends JsonResource
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
            'title' => $this->title,
            'date_of_birth' => $this->date_of_birth?->format('Y-m-d'),
            'nationality' => $this->nationality,
            'civility' => $this->civility,
            'phone' => $this->phone,
            'country' => $this->country,
            'family_status' => $this->family_status,
            'study_level' => $this->study_level,
            'address' => $this->address,
            'educations' => EducationResource::collection($this->whenLoaded('educations')),
            'languages' => LanguageResource::collection($this->whenLoaded('languages')),
            'experience' => ExperienceResource::collection($this->whenLoaded('experiences')),
            'resume' => $this->resume,
            'city' => $this->city,
            'country' => $this->country,
            'avatar' => $this->avatar,
        ];
    }
}
