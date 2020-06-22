<?php

namespace App\Http\Controllers;
use App\Book;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class BookController extends Controller
{
    use ApiResponse;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Return book list
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();

        return $this->successResponse($books);
    }

    /**
     * Create an instance of Book
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title'         => 'required|max:255',
            'description'   => 'required|max:255',
            'price'         => 'required|min:1',
            'author_id'     => 'required|min:1',
        ];

        $this->validate($request, $rules);

        $book = Book::create($request->all());

        return $this->successResponse($book, Response::HTTP_CREATED);
    }

    /**
     * Return an specific book
     * @return Illuminate\Http\Response
     */

    public function show($book)
    {
        $book = Book::findOrFail($book);

        return $this->successResponse($book);
    }
    
    /**
     * update the information of an existing book
     * @return Illuminate\Http\Response
     */

    public function update(Request $request, $book)
    {
        $rules = [

            'title'         => 'max:255',
            'description'   => 'max:255',
            'price'         => 'min:1',
            'author_id'     => 'min:1',
        ];

        $this -> validate ($request, $rules);

        $book = Book::findOrFail($book);

        $book->fill($request->all());

        if($book->isClean()){
            return $this->errorResponse('debe efectuar alguna modificación para guardar cambios', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $book->save();

        return  $this->successResponse($book);
    }

    /**
     * Removes an existing book
     * @return Illuminate\Http\Response
     */

    public function destroy($book)
    {  
       // return 5/0;
        $book = Book::findOrFail($book);
        $book->delete(); //borra físicamente, con softdelete cambia estado
        return $this->successResponse($book);
    }
}
