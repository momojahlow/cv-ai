<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    public function create()
    {
        return Inertia::render('Experience/Create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Check if user has a curriculum, if not create one
        if (!$user->curriculum) {
            $curriculum = Curriculum::create([
                'user_id' => $user->id
            ]);
            $user->refresh();
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'description' => 'required|string'
        ]);

        // Convert snake_case to camelCase for database
        $data = [
            'title' => $validated['title'],
            'company' => $validated['company'],
            'location' => $validated['location'],
            'startDate' => $validated['start_date'],
            'endDate' => $validated['end_date'],
            'description' => $validated['description'],
            'curriculum_id' => $user->curriculum->id
        ];

        $experience = Experience::create($data);

        return response()->json($experience);
    }

    public function update(Request $request, Experience $experience)
    {
        $user = Auth::user();
        
        // Check if user has a curriculum, if not create one
        if (!$user->curriculum) {
            $curriculum = Curriculum::create([
                'user_id' => $user->id
            ]);
            $user->refresh();
        }

        $this->authorize('update', $experience);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'description' => 'required|string'
        ]);

        // Convert snake_case to camelCase for database
        $data = [
            'title' => $validated['title'],
            'company' => $validated['company'],
            'location' => $validated['location'],
            'startDate' => $validated['start_date'],
            'endDate' => $validated['end_date'],
            'description' => $validated['description']
        ];

        $experience->update($data);

        return response()->json($experience);
    }

    public function destroy(Experience $experience)
    {
        $user = Auth::user();
        
        // Check if user has a curriculum, if not create one
        if (!$user->curriculum) {
            $curriculum = Curriculum::create([
                'user_id' => $user->id
            ]);
            $user->refresh();
        }

        $this->authorize('delete', $experience);
        
        $experience->delete();

        return response()->json(['message' => 'Experience deleted successfully']);
    }

    /**
     * Correct the experience description using AI.
     */
    public function correctDescription(Request $request)
    {
        $request->validate([
            'description' => 'required|string'
        ]);
        $client = new Client(env('GEMINI_API_KEY'));
        $prompts = "corrige moi ce texte :" . $request->description;


        try {
            $response = $client->geminiPro()->generateContent(
                new TextPart($prompts)
            );

            $correctedDescription = trim($response->text());

            return response()->json([
                'success' => true,
                'description' => $correctedDescription
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la correction: ' . $e->getMessage()
            ], 500);
        }
    }
}
