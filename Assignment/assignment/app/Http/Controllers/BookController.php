<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Services\AuthorService;
use App\Services\BookService;

class BookController extends Controller
{
    protected $authorService;

    public function __construct(AuthorService $authorService, BookService $bookService)
    {
        $this->authorService = $authorService;
        $this->bookService = $bookService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['books'] = Book::get();
        // $data = $this->bookService->getBooks();
        // $data['books'] = $data['items'];
        return view('book.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->authorService->getAuthors();
        $authors = $data['items'];
        return view('book.create', compact('authors'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'author_id' => 'required',
        ], [
            'author_id.required' => 'Please select author.'
        ]);
    
        $post_data = $request->all();
        unset($post_data['_token']);
        Book::create($post_data);
        return redirect()->route('book.index')->with('success', 'Book added successfully!');
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
        $book = Book::find($id);
        if (!$book) {
            return redirect()->back()->with('error', 'Book not found.');
        }
        $book->delete();
        return redirect()->back()->with('success', 'Book deleted successfully!');
    }
}
