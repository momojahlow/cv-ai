<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Curriculum;
use GuzzleHttp\Exception\RequestException;
use Carbon\Carbon;
use GeminiAPI\Client;
use App\Models\Language;
use GeminiAPI\Resources\Parts\TextPart;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Services\GeminiAiService;

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
        
        return Inertia::render('Curriculum/Index', [
            'profileNumber' => $user->id,
            'userInfo' => [
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

    // public function correctResume(Request $request)
    // {
    //     $validated = $request->validate([
    //         'resume' => 'required|string|min:10',
    //     ]);

    //     $client = new Client(env('GEMINI_API_KEY'));
    //     $prompts = "Sans commentaire corrige moi ce texte et reformule le de manière professionnelle en 100 mots :" . $validated['resume'];

    //     try {
    //         $response = $client->geminiPro()->generateContent(
    //             new TextPart($prompts)
    //         );

    //         $correctedResume = trim($response->text());

    //         return response()->json([
    //             'success' => true,
    //             'resume' => $correctedResume
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Une erreur est survenue lors de la correction: ' . $e->getMessage()
    //         ], 500);
    //     }       
    // }

    public function correctResume(Request $request, GeminiAiService $geminiAiService)
    {
        $validated = $request->validate([
            'resume' => 'required|string|min:10',
            'category' => 'nullable|string|in:education,experience',
        ]);

        $prompts = [
            'education' => "Corrige et reformule ce texte pour une section Éducation d'un CV professionnel :",
            'experience' => "Corrige et reformule ce texte pour une section Expérience professionnelle d'un CV :",
            'default' => "Adapte ce texte pour un CV professionnel :"
        ];
        $prompt = $prompts[$validated['category']] ?? $prompts['default'];

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
        $request->validate([
            'resume' => 'required|string|min:10',
        ]);

        $curriculum = auth()->user()->curriculum;
        if (!$curriculum) {
            $curriculum = auth()->user()->curriculum()->create([
                'resume' => $request->resume,
            ]);
        } else {
            $curriculum->update([
                'resume' => $request->resume
            ]);
        }

        return back()->with('success', 'Resume updated successfully');
    }


    public function addLanguage(Request $request)
    {
        $data = $request->validate([
            'language' => 'required|string|min:2|max:25',
            'level' => 'required|string|min:2|max:25',
        ]);

        $curriculum = auth()->user()->curriculum ?? auth()->user()->curriculum()->create();

        $language = $curriculum->languages()->create([
            'name' => $data['language'],  // Changed to use 'name'
            'level' => $data['level'],
        ]);

        return response()->json($language);
    }

    public function updateLanguages(Request $request, Language $language)
    {
        $data = $request->validate([
            'language' => 'required|string|min:2|max:25',
            'level' => 'required|string|min:2|max:25',
        ]);

        $language->update([
            'name' => $data['language'],  // Changed to use 'name'
            'level' => $data['level'],
        ]);

        return response()->json($language);
    }

    public function deleteLanguage(Language $language)
    {
        $language->delete();
        return response()->json(['success' => true]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $curriculum = $user->curriculum ?? $user->curriculum()->create();

        $validated = $request->validate([
            'civility' => 'required|string',
            'title' => 'required|string|min:2|max:255',
            'date_of_birth' => 'required|date',
            'phone' => 'required|string|min:10|max:20',
            'address' => 'nullable|string|min:2|max:255',
            'nationality' => 'nullable|string|min:2|max:255',
            'study_level' => 'required|string|min:2|max:255',
            'country' => 'nullable|string|min:2|max:255',
            'family_status' => 'nullable|string|min:2|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        $validated['date_of_birth'] = Carbon::parse($validated['date_of_birth'])->format('Y-m-d');
        $curriculum->update($validated);

        if ($request->hasFile('avatar')) {
            Storage::disk('public')->delete($curriculum->avatar);
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } else {
            unset($validated['avatar']); 
        }

        $curriculum->update($validated);
        return response()->json($curriculum);
    }


}
