<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookService
{
    private $baseUrl;
    private $email;
    private $password;

    public function __construct()
    {
        $this->baseUrl = env('API_BASE_URL');
        $this->email = env('API_USERNAME');
        $this->password = env('API_PASSWORD');
    }

    // Get API Token
    public function authenticate()
    {
        $response = Http::post("{$this->baseUrl}/api/v2/token", [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        // Log the response for debugging
        Log::info('Authentication Response', ['body' => $response->json()]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['token_key'] ?? null; 
        }

        Log::error('API Authentication Failed', ['status' => $response->status(), 'response' => $response->body()]);
        return null;
    }

    // Fetch Books from the API
    public function getBooks()
    {
        $token = $this->authenticate(); 

        if (!$token) {
            return ['error' => 'Authentication failed'];
        }

        $response = Http::withToken($token)->get("{$this->baseUrl}/api/v2/books");

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Failed to fetch books', ['response' => $response->body()]);
        return ['error' => 'Failed to fetch books'];
    }
}
