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
        $this->user->store($request->all());
        // User::create($request->all());
        return 'thank you for insert data';
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if(!$user){
            return abort('404');
        }
        return $user;
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
        $user = User::find($id);
    
        if (!$user) {
            return abort(404);
        }
    
        // Merge existing user data with the request data, keeping existing values if request is null
        $data = array_merge($user->toArray(), $request->all());
    
        $user->update($data);
    
        return back();
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if(!$user){
            return abort('404');
        }
         $user->delete();
         return back();
    }
}
