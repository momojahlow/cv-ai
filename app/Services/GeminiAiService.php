<?php

namespace App\Services;

use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;
use GeminiAPI\Resources\ModelName;

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
            // $response = $this->client->geminiPro()->generateContent(new TextPart($prompts));
            $response = $this->client->generativeModel(ModelName::GEMINI_1_5_FLASH)->generateContent(
                new TextPart($prompts),
            );
            return trim($response->text());
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la correction: " . $e->getMessage());
        }
    }
}
