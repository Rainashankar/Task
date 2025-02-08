<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthorService;
use App\Models\Book;

class AuthorController extends Controller
{
    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->authorService->getAuthors();
        $authors = $data['items'];
        return view('author.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->authorService->deleteAuthor($id);
        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }
        return redirect()->back()->with('success', 'Author deleted successfully.');
    }

    public function view_books($author_id)
    {
        $books = Book::where('author_id', $author_id)->get();
        return view('author.view_books', compact('books', 'author_id'));
    }
}
