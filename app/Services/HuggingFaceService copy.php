<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HuggingFaceService
{
    protected $apiToken;
    protected $model;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiToken = config('services.huggingface.token');
        $this->model = config('services.huggingface.model');
        $this->apiUrl = "https://router.huggingface.co/chat/completions";
    }

    /**
     * Generate konten promosi
     */
    public function generatePromotion($data)
    {
        $prompt = $this->buildPrompt($data);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Content-Type' => 'application/json',
            ])


                ->timeout(60)
                ->retry(3, 2000) // Retry 3x jika model loading
                ->post($this->apiUrl, [
                    'model' => $this->model,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt,
                        ]
                    ],
                    'max_tokens' => 600,
                    'temperature' => 0.7,
                    'top_p' => 0.9,
                ]);

            // Handle different error codes
            if ($response->status() === 503) {
                return [
                    'success' => false,
                    'error' => 'Model sedang loading. Tunggu 20 detik dan coba lagi.',
                ];
            }

            if ($response->status() === 410) {
                return [
                    'success' => false,
                    'error' => 'Model tidak tersedia. Silakan hubungi admin untuk update model.',
                ];
            }

            if ($response->failed()) {
                Log::error('HuggingFace API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [
                    'success' => false,
                    'error' => 'API error: ' . $response->status() . ' - ' . $response->body(),
                ];
            }

            $result = $response->json();
            $generatedText = $result['choices'][0]['message']['content'] ?? '';


            // Parse hasil ke 3 platform
            $parsed = $this->parseResponse($generatedText, $data);

            return [
                'success' => true,
                'data' => $parsed,
            ];
        } catch (\Exception $e) {
            Log::error('HuggingFace Exception', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => 'Error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Build prompt untuk AI
     */
    private function buildPrompt($data)
    {
        $prompt = <<<PROMPT
Buatkan 3 konten promosi menarik untuk produk berikut:

Produk: {$data['product_name']}
Harga: Rp {$data['price']}
Target: {$data['target_audience']}
Keunggulan: {$data['description']}

Tulis dalam format berikut:

[INSTAGRAM]
(Caption menarik dengan emoji, maksimal 150 kata, sertakan hashtag relevan)

[WHATSAPP]
(Pesan broadcast personal dan singkat, maksimal 100 kata)

[FACEBOOK]
(Post engaging dengan call-to-action, maksimal 200 kata)

Gunakan Bahasa Indonesia yang persuasif dan menarik!
PROMPT;

        return $prompt;
    }

    /**
     * Parse response AI ke 3 platform
     */
    private function parseResponse($text, $originalData)
    {
        // Default fallback dengan template sederhana
        $result = [
            'instagram' => $this->generateInstagramFallback($originalData),
            'whatsapp' => $this->generateWhatsAppFallback($originalData),
            'facebook' => $this->generateFacebookFallback($originalData),
        ];

        try {
            // Extract Instagram
            if (preg_match('/\[INSTAGRAM\](.*?)(?=\[WHATSAPP\]|$)/s', $text, $matches)) {
                $result['instagram'] = trim($matches[1]);
            }

            // Extract WhatsApp
            if (preg_match('/\[WHATSAPP\](.*?)(?=\[FACEBOOK\]|$)/s', $text, $matches)) {
                $result['whatsapp'] = trim($matches[1]);
            }

            // Extract Facebook
            if (preg_match('/\[FACEBOOK\](.*?)$/s', $text, $matches)) {
                $result['facebook'] = trim($matches[1]);
            }
        } catch (\Exception $e) {
            Log::error('Parse Response Error', ['error' => $e->getMessage()]);
        }

        return $result;
    }

    /**
     * Fallback template Instagram
     */
    private function generateInstagramFallback($data)
    {
        return "✨ {$data['product_name']} ✨\n\n" .
            "{$data['description']}\n\n" .
            "💰 Hanya Rp " . number_format($data['price'], 0, ',', '.') . "\n\n" .
            "Cocok untuk {$data['target_audience']}! 🎯\n\n" .
            "Order sekarang! 📲\n\n" .
            "#UMKM #Lokal #KualitasTerbaik #BeliLokal";
    }

    /**
     * Fallback template WhatsApp
     */
    private function generateWhatsAppFallback($data)
    {
        return "Halo! 👋\n\n" .
            "Ada produk spesial nih: *{$data['product_name']}*\n\n" .
            "{$data['description']}\n\n" .
            "Harga: Rp " . number_format($data['price'], 0, ',', '.') . "\n\n" .
            "Minat? Chat langsung ya! 😊";
    }

    /**
     * Fallback template Facebook
     */
    private function generateFacebookFallback($data)
    {
        return "🌟 PROMO SPESIAL! 🌟\n\n" .
            "{$data['product_name']}\n\n" .
            "{$data['description']}\n\n" .
            "💰 Harga: Rp " . number_format($data['price'], 0, ',', '.') . "\n\n" .
            "Cocok banget untuk {$data['target_audience']}!\n\n" .
            "Jangan sampai kehabisan, order sekarang juga!\n\n" .
            "📲 Hubungi kami untuk info lebih lanjut.";
    }
}
