<?php

namespace App\Repositories;
use App\Models\User;
use App\Contracts\UserInterface;

class UserRepositori implements UserInterface{

    // public function all()
    // {
    //    return $user = User::orderBy('id','desc')->paginate(10);         
    // }

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

    public function store(array $data)
    {
        return User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'phone'=>$data['phone'],
        ]);
    }

    public function show(string $id)
    {
        $user = User::find($id);
        if(!$user){
            return abort('404');
        }
        return $user;
    }
}