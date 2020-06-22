<?php

namespace App\Http\Controllers;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\BookService;

class BookController extends Controller
{
    use ApiResponse;
    /**
     * The service to consume the book service
     * @var BookService
     */
    protected $bookService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /** A CONTINUCIÓN SE CREAN TODOS LOS MÉDODOS DEL CRUD, 
    * ESTA ES LA API GATEWAY QUE CONSUMIRÁ LOS SERVICIOS DE AUTHOR Y BOOKS CREADOS ANTERIORMENTE
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
