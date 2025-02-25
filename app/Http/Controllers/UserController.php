<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use App\Http\Resources\UserResource;
use App\Http\Resources\EducationResource;
use App\Http\Resources\ExperienceResource;
use App\Http\Resources\LanguageResource;
use App\Http\Resources\CurriculumResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;
    public function show(User $user)
    {
        $this->authorize('view', $user);
        $user->load([
            'curriculum.languages',
            'curriculum.educations',
            'curriculum.experiences',
        ]);
        $userInfo = [
            'id' => $user->id,
            'profile_photo_url' => $user->profile_photo_url,
            'isAdmin' => $user->isAdmin(),
            'name' => $user->name,
            'email' => $user->email,
            'title' => $user->curriculum?->title ?? 'Aucun titre défini',
            'categories' => ['Web', 'Mobile', 'Backend'],
            'date_of_birth' => $user->curriculum?->date_of_birth?->format('Y-m-d'),
            'nationality' => $user->curriculum?->nationality,
            'civility' => $user->curriculum?->civility,
            'phone' => $user->curriculum?->phone,
            'country' => $user->curriculum?->country,
            'family_status' => $user->curriculum?->family_status,
            'study_level' => $user->curriculum?->study_level,
            'address' => $user->curriculum?->address,
            'educations' => EducationResource::collection($user->curriculum?->educations) ?? [],
            'experiences' => ExperienceResource::collection($user->curriculum?->experiences) ?? [],
            'languages' => LanguageResource::collection($user->curriculum?->languages) ?? [],
            'avatar' => $user->curriculum?->avatar ?? null,
            'summary' => $user->curriculum?->resume ?? 'Développeur web passionné avec une expertise en développement full-stack. Spécialisé dans les technologies modernes comme Laravel, Vue.js et React.'

        ];
        
        return  Inertia::render(
            'Admin/UserShow',
            [
                'userInfo' => $userInfo
            ]
        );
    }

    public function destroy(User $user)
    {
        if (!Gate::allows('delete', $user)) {
            return back()->withErrors([
                'message' => 'Vous ne pouvez pas supprimer cet utilisateur.',
            ]);
        }
        $user->delete();

        return redirect()->back()->with('success', 'Utilisateur  avec succès !');
    }
}
