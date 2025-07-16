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

    public function index(Request $request)
    {
        try {
            $users = $this->manager->index($request);

            return inertia("Adminend/Users", [
                "users"   => $users,
                'filters' => $request->only(['search_key', 'paginate_size', 'page' => request('page')]),
            ]);
        } catch (\Exception $exception) {
            return handleException('User fetching failed', $exception);
        }
    }
}
