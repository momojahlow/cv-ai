<?php

namespace App\Services;

use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;
use Exception;

class GeminiAiService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client(env('GEMINI_API_KEY'));
    }

    public function correct(string $resume, string $promptTemplate = null): string
    {
        $promptTemplate = $promptTemplate ?? "Sans commentaire corrige moi ce texte : ";

        $prompts = $promptTemplate . $resume;

        try {
            $response = $this->client->geminiPro()->generateContent(new TextPart($prompts));
            return trim($response->text());
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la correction: " . $e->getMessage());
        }
    }
}
