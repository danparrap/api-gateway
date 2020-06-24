<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Services\BookService;
use App\Services\AuthorService;
use Illuminate\Http\Response;

class BookController extends Controller
{
    use ApiResponse;
    /**
     * The service to consume the book service
     * @var BookService 
     */
    protected $bookService;

    /**
     * The service to consume the author service
     * @var AuthorService
     */
    protected $authorService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(BookService $bookService, AuthorService $authorService)
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    /** A CONTINUCIÓN SE CREAN TODOS LOS MÉDODOS DEL CRUD, 
    * ESTA ES LA API GATEWAY QUE CONSUMIRÁ LOS SERVICIOS BOOKS CREADOS ANTERIORMENTE
    */
     
    /**
     * Return Books list
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successResponse($this->bookService->obtainBooks());
    }

    /**
     * Create an instance of Book
     * @return Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        //validamos que el id de autor exista
        $this->authorService->obtainAuthor($request->author_id); //si esto da satisfactorio se ejecuta la línea sgte
        return $this->successResponse($this->bookService->createBook($request->all()), Response::HTTP_CREATED);
    }

    /**
     * Return an especific Book
     * @return Illuminate\Http\Response
     */

    public function show($book)
    {
        return $this->successResponse($this->bookService->obtainBook($book));
    }

    /**
     * Update the information of an existing Book
     * @return Illuminate\Http\Response
     */

    public function update(Request $request, $book)
    { 
        $this->authorService->obtainAuthor($request->author_id);
        return $this->successResponse($this->bookService->editBook($request->all(), $book));
    }

    /**
     * Removes an existing Book
     * @return Illuminate\Http\Response
     */

    public function destroy($book)
    {
        return $this->successResponse($this->bookService->deleteBook($book));
    }
}
