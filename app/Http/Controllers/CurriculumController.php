<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Curriculum;
use GuzzleHttp\Exception\RequestException;
use Carbon\Carbon;
use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;

class CurriculumController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user->load('curriculum.educations');
        $user->load('curriculum.experiences');

        $birthDate = $user->curriculum?->date_of_birth;
        if ($birthDate) {
            $birthDate = Carbon::parse($birthDate)->format('Y-m-d');
        }

        return Inertia::render('Curriculum/Index', [
            'profileNumber' => $user->id,
            'userInfo' => [
                'name' => $user->name,
                'email' => $user->email,
                'title' => 'Développeur Full Stack',
                'categories' => ['Web', 'Mobile', 'Backend'],
                'birthDate' => $birthDate,
                'nationality' => $user->curriculum?->nationality,
                'civility' => $user->curriculum?->civility,
                'phone' => $user->curriculum?->phone,
                'country' => $user->curriculum?->country,
                'familyStatus' => $user->curriculum?->family_status,
                'educationLevel' => $user->curriculum?->study_level,
                'address' => $user->curriculum?->address,
                'educations' => $user->curriculum?->educations ?? [],
                'experiences' => $user->curriculum?->experiences ?? [],
                'summary' => $user->curriculum?->resume ?? 'Développeur web passionné avec une expertise en développement full-stack. Spécialisé dans les technologies modernes comme Laravel, Vue.js et React.'
            ],
            'auth' => [
                'user' => $user
            ]
        ]);
    }

    public function correctResume(Request $request)
    {
        $validated = $request->validate([
            'resume' => 'required|string',
        ]);

        $client = new Client(env('GEMINI_API_KEY'));
        $prompts = "Sans commentaire corrige moi ce texte et améliore le de manière professionnelle :" . $validated['resume'];
        
        try {
            $response = $client->geminiPro()->generateContent(
                new TextPart($prompts)
            );

            $correctedResume = trim($response->text());

            return response()->json([
                'success' => true,
                'resume' => $correctedResume
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la correction: ' . $e->getMessage()
            ], 500);
        }
        
        // try {
        //     $response = $client->get('correct', [
        //         'text' => $prompts,
        //         'lang' => 'fr',
        //     ]);
            
        //     $responseData = json_decode($response->getBody()->getContents());
            
        //     if (isset($responseData->text)) {
        //         $correctedText = trim($responseData->text);
        //         return response()->json([
        //             'success' => true,
        //             'summary' => $correctedText
        //         ]);
        //     }
            
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'La correction n\'a pas pu être effectuée'
        //     ], 422);
            
        // } catch (RequestException $e) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Erreur lors de la correction: ' . $e->getMessage()
        //     ], 500);
        // }
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


    public function updateLanguages(Request $request)
    {
        $data = $request->validate([
            'language' => 'required|string',
            'level' => 'required|string',
        ]);

        $curriculum = auth()->user()->curriculum ?? auth()->user()->curriculum()->create([
            'user_id' => auth()->user()->id,
        ]);

        $existingLanguages = $curriculum->languages ?? [];
        $existingLanguages[] = [
            'language' => $data['language'],
            'level' => $data['level'],
        ];

        $curriculum->languages = $existingLanguages;
    $curriculum->save();

        return back()->with('success', 'Resume updated successfully');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'civility' => 'required|string',
            'date_of_birth' => 'required|date',
            'phone' => 'required|string',
            'address' => 'nullable|string',
            'nationality' => 'nullable|string',
            'study_level' => 'required|string',
            'country' => 'nullable|string',
            'family_status' => 'nullable|string',
            'avatar' => 'nullable|image|max:1024', // 1MB max
        ]);

        $data = $request->only([
            'civility',
            'phone',
            'address',
            'nationality',
            'study_level',
            'country',
            'family_status'
        ]);
        
        // Format the date before saving
        $data['date_of_birth'] = Carbon::parse($request->date_of_birth)->format('Y-m-d');

        $curriculum = auth()->user()->curriculum;
        if (!$curriculum) {
            $curriculum = auth()->user()->curriculum()->create($data);
        } else {
            $curriculum->update($data);
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $curriculum->update(['avatar' => $path]);
        }

        return back()->with('success', 'Profile updated successfully');
    }
}
