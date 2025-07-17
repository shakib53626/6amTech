<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
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

    public function store(UserRequest $request)
    {
        try {
            $user = $this->manager->store($request);

            return redirect()->back()->with('success', 'User created successfully');
        } catch (\Exception $exception) {
            return handleException('User creation failed', $exception);
        }
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $user = $this->manager->update($id, $request);

            return redirect()->back()->with('success', 'User updated successfully');
        } catch (\Exception $exception) {
            return handleException('User update failed', $exception);
        }
    }

    public function destroy($id)
    {
        try {
            $this->manager->destroy($id);

            return redirect()->back()->with('success', 'User deleted successfully');
        } catch (\Exception $exception) {
            return handleException('User deletion failed', $exception);
        }
    }
}
