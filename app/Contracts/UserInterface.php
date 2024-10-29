<?php

namespace App\Contracts;

interface UserInterface{

    public function all();
    public function store(array $data);
    public function show(string $id);
    public function update(array $data, int $id);
}



