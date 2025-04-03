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
    
    public function userRoleValidation() {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            return true;
        } else {
            return false;
        }
    }

    public function index(): Response
    {
        if (self::userRoleValidation()) {
            $users = User::with('roles')->paginate(10);
            return Inertia::render('Users/Index', [
                'users' => $users,
            ]);
        }
        
        return Inertia::render('Dashboard');
    }

    public function create(): Response
    {
        if (self::userRoleValidation()) {
            return Inertia::render('Users/Create');
        }
        
        return Inertia::render('Dashboard');
    }

    public function store(Request $request): RedirectResponse
    {
        if (self::userRoleValidation()) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|lowercase|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'phone' => ['string', 'max:20', 'regex:' . self::PHONE_REGEX],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
            ]);

            $user->assignRole('user');

            return Redirect::route('users.index');
        }
        
        return Redirect::route('dashboard');
    }

    public function update (Request $request, $id): RedirectResponse
    {
        if (self::userRoleValidation()) {
            $user = User::findOrFail($id);
            /* dd($request->all()); */
            $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|string|lowercase|email|max:255|unique:users,email',
                'password' => 'nullable|string|min:8',
                'phone' => 'string|max:20|regex:' . self::PHONE_REGEX,
            ]);

            $user->update([
                'name' => $request->name ? $request->name : $user->name,
                'email' => $request->email ? $request->email : $user->email,
                'password' => $request->password ? bcrypt($request->password) : $user->password,
                'phone' => $request->phone ? $request->phone : $user->phone,
            ]);

            return Redirect::route('users.index');
        }
        
        return Redirect::route('dashboard');
    }

    public function destroy($id): RedirectResponse
    {
        if (self::userRoleValidation()) {
            $user = User::findOrFail($id);
            $user->delete();

            return Redirect::route('users.index');
        }
        
        return Redirect::route('dashboard');
    }
}
