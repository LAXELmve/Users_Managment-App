<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class UsersController extends Controller
{
    private const PHONE_REGEX = '/^(\+\d{1,3}[-.\s]?)?' .
                            '\(?(\d{3})\)?[-.\s]?(\d{3})[-.\s]?(\d{4})' .
                            '(( ?(x|ext|ext.)\d+)?)$/i';

    public function index(): Response
    {
        $users = User::all();
        return Inertia::render('Users/Index', [
            'users' => $users,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Users/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'string|max:20|regex:' . self::PHONE_REGEX,
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
        ]);

        return Redirect::route('users.index');
    }

    public function update (Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'password' => 'string|min:8',
            'phone' => 'string|max:20|regex:' . self::PHONE_REGEX,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'phone' => $request->phone,
        ]);

        return Redirect::route('users.index');
    }

    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return Redirect::route('users.index');
    }
}
