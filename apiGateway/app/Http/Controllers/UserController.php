<?php

namespace App\Http\Controllers;
use App\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
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
     * Return users list
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $this->validResponse($users);
    }

    /**
     * Create an instance of author
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name'    => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:15|confirmed',
        ];

       $this->validate($request, $rules);

       $user = User::create($request->all());
       return $this->validResponse($user, Response::HTTP_CREATED); 
    }

    /**
     * Return an especific author
     * @return Illuminate\Http\Response
     */
    public function show($user)
    {
        $user = User::findOrFail($user);

        return $this->validResponse($user);
    }

    /**
     * Update the information of an existing author
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {
        $rules = [
            'name'    => 'max:255',
            'email' => 'email|unique:users,email',
            'password' => 'min:6|max:15|confirmed',
        ];

        $this->validate($request, $rules);

        $user = User::findOrFail($user);

        $user->fill($request->all());

        if($user->isClean()){
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();

        return $this->validResponse($user);
    }

    /**
     * Removes an existing author
     * @return Illuminate\Http\Response
     */
    public function destroy($user)
    {  
        $user = User::findOrFail($user);
        $user->delete();

        return $this->validResponse($user);
    }

    /**
     * Identifies the current user
     * @return Illuminate\Http\Response
     */

    public function me(Request $request)
    {  
        return $this->validResponse($request->user());
    }
}