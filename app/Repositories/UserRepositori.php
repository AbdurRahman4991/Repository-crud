<?php

namespace App\Repositories;
use App\Models\User;
use App\Contracts\UserInterface;

class UserRepositori implements UserInterface{
    
    public function all()
    {
       return $user = User::orderBy('id','desc')->paginate(10);         
    }

    public function store(array $data)
    {
        return User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'phone'=>$data['phone'],
        ]);
    }
}