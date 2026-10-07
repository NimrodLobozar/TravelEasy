<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent; // ✅ Importeer Jenssegers/Agent

class HuggingFaceService
{
    protected $apiUrl = 'https://api-inference.huggingface.co/models/google/flan-t5-large';

    public function generateResponse($prompt, $language = null)
    {
        $apiKey = config('services.huggingface.api_key');
    
        // Voeg context toe aan de prompt
        if ($language === 'nl') {
            $prompt = "Je bent een behulpzame reisassistent. Beantwoord de volgende vraag duidelijk en beknopt in het Nederlands:\n\nVraag: " . $prompt . "\nAntwoord:";
        } else {
            $prompt = "You are a helpful travel assistant. Answer the following question clearly and concisely in English:\n\nQuestion: " . $prompt . "\nAnswer:";
        }
    
        // Stuur de prompt naar het FLAN-T5-large model
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])
        ->timeout(60)
        ->withoutVerifying()
        ->post($this->apiUrl, [
            'inputs' => $prompt,
            'parameters' => [
                'max_length' => 100,
                'temperature' => 0.7,
                'top_p' => 0.9,
            ]
        ]);
    
        if ($response->failed()) {
            \Log::error('Hugging Face API-fout', ['response' => $response->body()]);
            return 'Excuses, er is een fout opgetreden. Probeer het later opnieuw.';
        }
    
        $data = $response->json();
        $generatedText = $data[0]['generated_text'] ?? 'Geen reactie';
    
        // Verwijder eventuele herhaling van de prompt uit het antwoord
        $generatedText = str_replace($prompt, '', $generatedText);
    
        // Controleer of het antwoord nuttig is
        if (empty($generatedText) || strlen($generatedText) < 10) {
            $generatedText = 'Excuses, ik begrijp de vraag niet helemaal. Kun je het anders formuleren?';
        }
    
        return $generatedText;
    }
}