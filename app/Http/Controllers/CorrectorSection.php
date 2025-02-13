<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CorrectorSection extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $client = new Client(env('GEMINI_API_KEY'));
        $prompts = "corrige moi ce texte :".$request->question;
        try {
            $response = $client->get('correct', [
                'text' => $prompts,
                'lang' => 'fr',
            ]);
            $response = json_decode($response->getBody()->getContents());
            return response()->json($response);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
