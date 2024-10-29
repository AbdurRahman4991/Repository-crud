<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Contracts\UserInterface;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public $user;
    public function __construct(UserInterface $interface) {
        $this->user = $interface;
    }
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
{
    $search = $request->get('search')['value']; // Get the search input
    $start = $request->get('start', 0); // Get the start index for pagination
    $length = $request->get('length', 10); // Get the number of records per page

    $users = $this->user->all($search, $start, $length); // Pass parameters to repository

    return response()->json($users); // Return the entire response
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
    public function store(UserRequest $request)
    {
        // Use validated data from the request
        $this->user->store($request->validated()); // Now validated data is used
    
        return response()->json(['message' => 'Thank you for insert user']);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $users = $this->user->show($id);
        return response()->json($users);
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
        $this->user->update($request->all(), $id); 
    
        return response()->json(['message' => 'Thank you for updating user']);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $user = User::find($id);
        // if(!$user){
        //     return abort('404');
        // }
        //  $user->delete();
        $this->user->delete($id);
        return response()->json(['message' => 'Delete user success']);
    }
}
