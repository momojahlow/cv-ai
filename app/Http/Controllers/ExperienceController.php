<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        $curriculum = $user->curriculum ?? $user->curriculum()->create();
        $user->refresh();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date |before:end_date',
            'end_date' => 'nullable|date|after:start_date',
            'city' => 'nullable|string |max:255 |min:2',
            'country' => 'nullable|string |max:255 |min:2 ',
            'description' => 'required|string |max:255|min:10'
        ]);

        $curriculum->experiences()->create($validated);

        return redirect()->back()->with('success', 'Experience ajoutée avec succès !');
    }

    public function update(Request $request, Experience $experience)
    {
        $user = Auth::user();

        $curriculum = $user->curriculum ?? $user->curriculum()->create();
        $user->refresh();
    
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'company'     => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'start_date'  => 'required|date |before:end_date',
            'end_date'    => 'nullable|date|after:start_date',
            'city'        => 'nullable|string |max:255|min:2',
            'country'     => 'nullable|string |max:255|min:2',
            'description' => 'required|string |max:255|min:10',
        ]);
    
        $validated['curriculum_id'] = $curriculum->id;
        $experience->update($validated);
        return redirect()->back()->with('success', 'Experience modifiée avec succès !');
    
        return response()->json();
    }

    public function destroy(Experience $experience)
    {
        if (!Gate::allows('delete', $experience)) {
            return back()->withErrors([
                'message' => 'Vous ne pouvez pas supprimer cette experience.',
            ]);
        }

        $experience->delete();

        return redirect()->back()->with('success', 'Experience supprimée avec succès !');
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
