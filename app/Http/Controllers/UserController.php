<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Contracts\UserInterface;
class UserController extends Controller
{
    public $user;
    public function __construct(UserInterface $interface) {
        $this->user = $interface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->user->all(); // Call the repository method

        return response()->json([
            'data' => $users->items(), // Get the actual items
            'recordsTotal' => $users->total(), // Total records in the database
            'recordsFiltered' => $users->total(), // Total records after filtering
        ]);
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
