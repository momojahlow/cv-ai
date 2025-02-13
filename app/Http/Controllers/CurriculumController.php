<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CurriculumController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user->load('curriculum');
        return Inertia::render('Curriculum/Index', [
            'profileNumber' => $user->id,
            'userInfo' => [
                'name' => $user->name,
                'title' => $user->curriculum?->title ?? 'Développeur web',
                'categories' => ['Développement', 'Web', 'Mobile'],
                'birthDate' => $user->curriculum?->birth_date ?? '01/01/1990',
                'nationality' => $user->curriculum?->nationality ?? 'Sénégalaise',
                'familyStatus' => $user->curriculum?->family_status ?? 'Célibataire',
                'educationLevel' => $user->curriculum?->education_level ?? 'Bac +5 et plus',
                'address' => $user->curriculum?->address ?? 'Dakar, Sénégal',
                'education' => [
                    [
                        'level' => 'Bac +5 et plus',
                        'type' => 'Université',
                        'status' => 'completed',
                        'startDate' => '2018',
                        'endDate' => '2023',
                        'school' => 'Université Cheikh Anta Diop de Dakar',
                        'diploma' => 'Master en Informatique',
                        'description' => 'Spécialisation en développement web et mobile'
                    ],
                    [
                        'level' => 'Bac +3',
                        'type' => 'Université',
                        'status' => 'completed',
                        'startDate' => '2015',
                        'endDate' => '2018',
                        'school' => 'Université Cheikh Anta Diop de Dakar',
                        'diploma' => 'Licence en Informatique',
                        'description' => 'Formation générale en informatique'
                    ]
                ],
                'summary' => $user->curriculum?->summary ?? 'Développeur web passionné avec une expertise en développement full-stack. Spécialisé dans les technologies modernes comme Laravel, Vue.js et React.'
            ],
            'auth' => [
                'user' => $user
            ]
        ]);
    }

    public function correctSummary(Request $request)
    {
        $validated = $request->validate([
            'summary' => 'required|string',
        ]);

        $client = new Client(env('GEMINI_API_KEY'));
        $prompts = "corrige moi ce texte et améliore le de manière professionnelle :" . $validated['summary'];
        
        try {
            $response = $client->get('correct', [
                'text' => $prompts,
                'lang' => 'fr',
            ]);
            
            $responseData = json_decode($response->getBody()->getContents());
            
            if (isset($responseData->text)) {
                $correctedText = trim($responseData->text);
                return response()->json([
                    'success' => true,
                    'summary' => $correctedText
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'La correction n\'a pas pu être effectuée'
            ], 422);
            
        } catch (RequestException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la correction: ' . $e->getMessage()
            ], 500);
        }
    }
}
