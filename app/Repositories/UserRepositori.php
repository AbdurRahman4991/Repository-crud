<?php

namespace App\Repositories;
use App\Models\User;
use App\Contracts\UserInterface;

class UserRepositori implements UserInterface{

    // Display data //

    public function all($search = null, $start = 0, $length = 10)
    {
        $query = User::query();

        // Apply search filters if provided
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('phone', 'LIKE', "%$search%")
                ->orWhere('status', 'LIKE', "%$search%");
            });
        }

        // Apply pagination
        $users = $query->orderBy('id', 'desc')->skip($start)->take($length)->get();

        return [
            'data' => $users,
            'recordsTotal' => User::count(), // Total records in the database
            'recordsFiltered' => $query->count(), // Total records after applying filters
        ];
    }

    // Store data //

    public function store(array $data)
    {
        return User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'phone'=>$data['phone'],
        ]);
    }

    // Single user data //

    public function show(string $id)
    {
        $user = User::find($id);
        if(!$user){
            return abort('404');
        }
        return $user;
    }

    // Update user //

    public function update(array $data, int $id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return abort(404);
        }
    
        $user->update([
            'name'=> $data['name'],
            'email'=> $data['email'],
            'phone'=> $data['phone'],
        ]);
        return $user;
    }
}