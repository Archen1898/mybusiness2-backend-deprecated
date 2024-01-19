<?php

namespace App\Interfaces;

interface CrudInterface {
    public function viewAll();

    public function viewById($id);

    public function create(array $request):object|null|array;

    public function update($id, array $request):object|null|array;

    public function delete($id):object|null;
}
