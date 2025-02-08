<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Book;

class AuthorService
{
    private $baseUrl;
    private $email;
    private $password;
    private $apiToken;

    public function __construct()
    {
        $this->baseUrl = env('API_BASE_URL');
        $this->email = env('API_USERNAME');
        $this->password = env('API_PASSWORD');
        $this->apiToken = env('API_ACCESS_TOKEN');
    }

    /**
     * Authenticate and get API token
     */
    public function authenticate()
    {
        $response = Http::post("{$this->baseUrl}/api/v2/token", [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $token = $data['token_key'] ?? null;

            if ($token) {
                // Store token in .env dynamically
                $this->updateEnvFile('API_ACCESS_TOKEN', $token);
                $this->apiToken = $token;
            }

            return $token;
        }
        return null;
    }

    /**
     * Update .env file dynamically
     */
    private function updateEnvFile($key, $value)
    {
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            file_put_contents($envPath, preg_replace("/^{$key}=.*/m", "{$key}={$value}", file_get_contents($envPath)));
        }
    }

    /**
     * Get API token, refresh if expired
     */
    private function getValidToken()
    {
        if (!$this->apiToken) {
            return $this->authenticate();
        }
        return $this->apiToken;
    }

    /**
     * Fetch all authors from API
     */
    public function getAuthors()
    {
        $token = $this->getValidToken();
        if (!$token) {
            return ['error' => 'Authentication failed'];
        }

        $response = Http::withToken($token)->get("{$this->baseUrl}/api/v2/authors");
        return $response->successful() ? $response->json() : ['error' => 'Failed to fetch authors'];
    }

    /**
     * Fetch single author details
     */
    public function getSingleAuthor($author_id)
    {
        $token = $this->getValidToken();
        if (!$token) {
            return null;
        }

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->get("{$this->baseUrl}/api/v2/authors/{$author_id}");

        return $response->successful() ? $response->json() : null;
    }

    /**
     * Delete an author
     */
    public function deleteAuthor($id)
    {
        // Check if the author has books
        if (Book::where('author_id', $id)->exists()) {
            return ['error' => 'Cannot delete author. They have associated books.'];
        }

        $token = $this->getValidToken();
        if (!$token) {
            return ['error' => 'Authentication failed'];
        }

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
        ])->delete("{$this->baseUrl}/api/v2/authors/{$id}");

        return $response->status() === 204 ? ['success' => true] : ['error' => 'Failed to delete the author. Status: ' . $response->status()];
    }
}
