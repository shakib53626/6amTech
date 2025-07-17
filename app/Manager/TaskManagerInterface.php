<?php

namespace App\Manager;

interface TaskManagerInterface
{
    public function index($request);
    public function store($request);
    public function update($id, $request);
    public function destroy($id);
}
