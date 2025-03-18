<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Curriculum;
use GuzzleHttp\Exception\RequestException;
use Carbon\Carbon;
use App\Models\Language;
use Illuminate\Support\Facades\Storage;
use App\Services\GeminiAiService;
use App\Http\Requests\CurriculumProfileRequest;
use App\Http\Requests\LanguageRequest;

class CurriculumController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load([
            'curriculum.languages',
            'curriculum.educations',
            'curriculum.experiences',
            
        ]);

        $educations = $user->curriculum?->educations->map(function ($education) {
            return [
                'id' => $education->id,
                'level' => $education->level,
                'type' => $education->type,
                'status' => $education->status,
                'school' => $education->school,
                'diploma' => $education->diploma,
                'start_date' => $education->start_date?->format('Y-m-d'),
                'end_date' => $education->end_date?->format('Y-m-d'),
                'description' => $education->description,
                'city' => $education->city,
                'country' => $education->country,
            ];
        });

        $experiences = $user->curriculum?->experiences->map(function ($experience) {
            return [
                'id' => $experience->id,
                'title' => $experience->title,
                'company' => $experience->company,
                'location' => $experience->location,
                'start_date' => $experience->start_date?->format('Y-m-d'),
                'end_date' => $experience->end_date?->format('Y-m-d'),
                'description' => $experience->description,
                'city' => $experience->city,
                'country' => $experience->country,
            ];
        });
        // dd( $user->curriculum?->title);
        
        return Inertia::render('Curriculum/Index', [
            'profileNumber' => $user->id,
            'userInfo' => [
                'name' => $user->name,
                'profile_photo_url' => $user->profile_photo_url,
                'isAdmin' => $user->isAdmin(),
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
                'educations' => $educations ?? [],
                'experiences' => $experiences ?? [],
                'languages' => $user->curriculum?->languages ?? [],
                'avatar' => $user->curriculum?->avatar ?? null,
                'summary' => $user->curriculum?->resume ?? 'Développeur web passionné avec une expertise en développement full-stack. Spécialisé dans les technologies modernes comme Laravel, Vue.js et React.'
            ],
            'auth' => [
                'user' => $user
            ]
        ]);
    }

    public function correctResume(Request $request, GeminiAiService $geminiAiService)
    {
        $validated = $request->validate([
            'resume' => 'required|string|min:10',
            'category' => 'nullable|string|in:education,experience',
        ]);        

        $prompts = [
            'education' => "Sans commentaire corrige et reformule ce texte pour une section Éducation d'un CV professionnel :",
            'experience' => "Sans commentaire corrige et reformule ce texte pour une section Expérience professionnelle d'un CV :",
            'default' => "Sans commentaire corrige moi ce texte :"
        ];
        // $prompt = $prompts[$validated['category']] ?? $prompts['default'];
        $prompt = $prompts['default'];

        try {
            $correctedResume = $geminiAiService->correct($validated['resume'], $prompt);

            return response()->json([
                'success' => true,
                'resume' => $correctedResume
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateResume(Request $request)
    {        
        $validated = $request->validate([
            'resume' => 'required|string|min:10|max:255',
        ], [
            'resume.required' => 'Le résumé est obligatoire.',
            'resume.string' => 'Le résumé doit être une chaîne de caractères.',
            'resume.min' => 'Le résumé doit contenir au moins :min caractères.',
            'resume.max' => 'Le résumé ne peut pas dépasser :max caractères.',
        ]);        
        $user = auth()->user();

        $curriculum = $user->curriculum()->firstOrCreate([]);
        $curriculum->update($validated);    
        
        return back()->with('success', 'Resume updated successfully');
    }


    public function addLanguage(LanguageRequest $request)
    {
        $validated = $request->validated();

        $user = auth()->user();
        $curriculum = $user->curriculum ?? $user->curriculum()->firstOrCreate([]);
        $curriculum->languages()->create($validated);
    

        return redirect()->back()->with('success', 'Language ajoutée avec succès');
    }

    public function updateLanguages(LanguageRequest $request, Language $language)
    {
        $validated = $request->validated();

        // if ($language->curriculum->user_id !== auth()->id()) {
        //     abort(403, 'Action non autorisée.');
        // }

        $language->update( $validated );
        return redirect()->back()->with('success', 'Language modifiée avec succès');
    }

    public function deleteLanguage(Language $language)
    {
        $language->delete();
        return redirect()->back()->with('success', 'Language supprimée avec succès');
    }

    public function updateProfile(CurriculumProfileRequest $request)
    { 
        $validated = $request->validated();
        
        $user = auth()->user();
        $curriculum = $user->curriculum ?? $user->curriculum()->create();

        // $validated['date_of_birth'] = Carbon::parse($validated['date_of_birth'])->format('Y-m-d');       
        if ($request->hasFile('avatar')) {
            if ($curriculum->avatar && Storage::disk('public')->exists($curriculum->avatar)) {
                Storage::disk('public')->delete($curriculum->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } else {
            unset($validated['avatar']); 
        }

        $curriculum->update($validated);
        return redirect()->back()->with('success', 'Profil mis à jour avec succès !');
    }

}
