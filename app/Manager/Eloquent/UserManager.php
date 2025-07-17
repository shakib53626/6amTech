<?php

namespace App\Manager\Eloquent;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Manager\UserManagerInterface;
use Illuminate\Support\Facades\Storage;

class UserManager implements UserManagerInterface
{
    public function index($request)
    {
        $paginateSize = $request->input('paginate_size') ?? 50;

        $query = User::query();

        if ($request->filled('search_key')) {
            $query->where('name', 'like', '%' . $request->input('search_key') . '%');
        }

        return  $query->orderBy('created_at', 'desc')->paginate($paginateSize);
    }

    public function store($request){

        $user = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->phone    = $request->phone;
        $user->role     = $request->role;
        $user->status   = $request->status;
        $user->password = Hash::make($request->password);

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

        return $user;

    }

    public function update($id, $request)
    {
        $user = User::findOrFail($id);
        $user->name    = $request->name;
        $user->email   = $request->email;
        $user->phone   = $request->phone;
        $user->role    = $request->role;
        $user->status  = $request->status;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('users')) {
                Storage::disk('public')->makeDirectory('users');
            }

            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            $image->storeAs('users', $filename, 'public');
            $user->image = '/storage/users/' . $filename;
        }

        $user->save();

        return $user;

    }

    public function destroy($id){

        $user = User::findOrFail( $id);

        if ($user->image && Storage::disk('public')->exists(str_replace('/storage/', '', $user->image))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $user->image));
        }

        $user->delete();

        return $user;
    }

}
