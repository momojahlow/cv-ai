<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;
use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;
use Inertia\Inertia;

class ExperienceController extends Controller
{
    public function create()
    {
        return Inertia::render('Experience/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'description' => 'required|string',
        ]);

        Experience::create($validated);

        return redirect()->route('dashboard')->with('success', 'Expérience ajoutée avec succès.');
    }

    public function destroy($id)
    {
        $experience = Experience::findOrFail($id);
        $experience->delete();
        
        return redirect()->route('experiences')->with('success', 'Expérience supprimée avec succès');
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
