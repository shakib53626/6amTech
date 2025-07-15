<?php

namespace Shakib\UserModule\Manager\Eloquent;


use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Manager\UserManagerInterface;
use Illuminate\Support\Facades\Storage;

class UserManager implements UserManagerInterface
{
    public function index($request)
    {
        try {
            $paginateSize = $request->input('paginate_size') ?? 50;

            $roles = Role::orderBy("name", "ASC")->get();
            $query = User::query();

            if ($request->filled('search_key')) {
                $query->where('name', 'like', '%' . $request->input('search_key') . '%');
            }

            if ($request->input('is_trashed') === 'only') {
                $query->onlyTrashed();
            } elseif ($request->input('is_trashed') === 'with') {
                $query->withTrashed();
            }

            return [
                "users" => $query->orderBy('created_at', 'desc')->with('roles', 'deletedBy:id,name')->paginate($paginateSize),
                "roles" => $roles
            ];

        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function store($request){
        try {
            $user = new User();
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->phone    = $request->phone;
            $user->address  = $request->address;
            $user->password = Hash::make($request->password);

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                if (!Storage::disk('public')->exists('users')) {
                    Storage::disk('public')->makeDirectory('users');
                }

                $image->storeAs('users', $filename, 'public');
                $user->image = '/storage/users/' . $filename;
            }

            $user->save();

            $user->syncRoles($request->role_ids ?? []);

            return $user;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function update($id, $request){
        try {
            $user = User::findOrFail($id);
            $user->name    = $request->name;
            $user->email   = $request->email;
            $user->phone   = $request->phone;
            $user->address = $request->address;

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            // Handle image update
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Ensure folder exists
                if (!Storage::disk('public')->exists('users')) {
                    Storage::disk('public')->makeDirectory('users');
                }

                // Delete old image if exists
                if ($user->image && Storage::disk('public')->exists($user->image)) {
                    Storage::disk('public')->delete($user->image);
                }

                // Store new image
                $image->storeAs('users', $filename, 'public');
                $user->image = '/storage/users/' . $filename;
            }

            $user->save();

            $user->syncRoles($request->role_ids ?? []);

            return $user;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function destroy($id){
        try {
            $user = User::findOrFail( $id);

            $user->deleted_by = auth()->id();
            $user->save();

            $user->delete();

            return $user;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

}
