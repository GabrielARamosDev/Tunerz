<?php

namespace App\Http\Controllers\Auth;

use App\Base\Constants\Roles;
use App\Base\Services\Wordpress\Wordpress;
use App\Http\Controllers\Controller;
use App\Models\v1\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required', /* 'confirmed', */
                // Rules\Password::defaults()
            ],
        ]);

        // check if email is up on WP as teacher and if password matches

        $wp = Wordpress::getInstance();
        $response = $wp->client->login($request->email, $request->password);

        if (!isset($response['token']) || 'teacher' !== $response['profile']['perfil']) {
            return abort(401, 'Usuário inválido');
        }

        $is_manager = $response['profile']['is_manager'];

        $roleId = $is_manager
            ? Roles::SCHOOL_MANAGER
            : Roles::TEACHER;

        /** @var User */
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->sync([$roleId]);

        $user->teacher_id = $response['profile']['id'];
        $user->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
