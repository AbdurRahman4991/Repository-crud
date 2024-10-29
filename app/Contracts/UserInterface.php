<?php

namespace App\Contracts;

interface UserInterface{

    /** User crud method */

    public function all();
    public function store(array $data);
    public function show(string $id);
    public function update(array $data, int $id);
    public function delete($id);
}



