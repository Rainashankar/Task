<?php 
use App\Models\Author;
use App\Services\AuthorService;

if (!function_exists('getAuthorName')) {
    function getAuthorName($author_id)
    {
        $authorService = app(AuthorService::class); 
        $data = $authorService->getSingleAuthor($author_id);
        
        if ($data && isset($data['first_name'], $data['last_name'])) {
            return "{$data['first_name']} {$data['last_name']}";
        }

        return null;
    }
}
