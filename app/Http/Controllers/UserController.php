<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manager\UserManagerInterface;

class UserController extends Controller
{

    protected $manager;

    public function __construct(UserManagerInterface $manager)
    {
        $this->manager = $manager;
    }
}
