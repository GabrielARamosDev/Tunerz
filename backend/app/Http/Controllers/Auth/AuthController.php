<?php

namespace App\Http\Controllers\Auth;

use App\Constants\Roles;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\RentalListing;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

use Carbon\Carbon;

class AuthController extends Controller
{
    public function me()
    {
        $user = [
            'id' => null,
            'name' => 'Guest #' . time() . rand(1, 999),
            'email' => null,
            'roles' => [['id' => Roles::GUEST, 'name' => 'Guest']],
            'status' => 'unauthenticated'
        ];

        if (Auth::check()) {

            $user = Auth::user();

            if ($user) {
                $user = User::find($user->id);
                $user = array_merge($user->toArray(), [ 'status' => 'authenticated' ]);
            }
        }
        // dd($user);

        return response()->json($user, 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'remember_me' => 'boolean',
        ]);

        $credentials = $request->only(['email', 'password']);

        $user = null;

        if (Auth::check()) {
            $user = Auth::user();
        } else {
            $user = User::where('email', $request->email)->first();
        }
        // dd($user);

        if ($user && Hash::check($request->password, $user->password)) {

            $token = $user->createToken('auth_token')->plainTextToken;

            $user_roles = array_column($user->roles->toArray(), 'name');

            return response()->json([
                'data' => [
                    'user' => array_merge($user->toArray(), [ 'status' => 'authenticated' ]),
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ],
                'message' => 'Login realizado com sucesso!'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Usuário não encontrado ou credenciais inválidas'
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {

            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'message' => 'Erro ao validar dados do usuário.',
                ], 400);
            }

            Auth::logout();
        }

        return redirect('/login');
    }

    public function register(Request $request)
    {
        Validator::extend('name', function ($attribute, $value, $parameters, $validator) {
            return str_word_count($value) > 1;
        });

        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => Password::min(8)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
                ->rules([
                    'required',
                    'confirmed',
                ]),
            // 'phone' => 'required',
        ];

        $messages = [
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O nome não deve ter mais de 255 caracteres.',
            'name.name' => 'O campo nome deve conter nome e sobrenome.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Digite um endereço de e-mail válido.',
            'email.unique' => 'Este e-mail já está registrado.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.confirmed' => 'As senhas não coincidem.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.mixedCase' => 'A senha deve conter ao menos 1 letra maiúscula e 1 letra minúscula.',
            'password.numbers' => 'A senha deve conter ao menos 1 número.',
            'password.symbols' => 'A senha deve conter ao menos 1 caracter especial.',
            'password.uncompromised' => 'Sua senha é muito fraca!',
            // 'phone.required' => 'O campo telefone é obrigatório.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Erro na validação dos dados.'
            ], 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                // 'phone' => $request->phone,
            ]);

            if ($user) {
                $user->roles()->sync([Roles::USER]);

                return response()->json([
                    'data' => [
                        'user' => array_merge($user->toArray(), [ 'status' => 'authenticated' ]),
                    ],
                    'message' => 'Registrado com sucesso. Faça login para continuar.'
                ], 201);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao registrar usuário: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Erro ao registrar usuário. Tente novamente.'
        ], 500);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Digite um endereço de e-mail válido.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'E-mail não encontrado.'
            ], 404);
        }

        $resetToken = Str::random(60);
        $user->reset_token = $resetToken;
        $user->reset_token_expires_at = Carbon::now()->addMinutes(60);
        $user->save();

        $resetUrl = env('APP_URL') . "/reset-password?token=$resetToken&email=" . urlencode($user->email);

        try {
            Mail::send('emails.reset-password', ['url' => $resetUrl, 'name' => $user->name], function ($message) use ($user) {
                $message->to($user->email)->subject('Redefinir Senha');
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao enviar e-mail: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'E-mail de redefinição de senha enviado com sucesso.'
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => Password::min(8)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
                ->rules([
                    'required',
                    'confirmed',
                ]),
        ], [
            'token.required' => 'Token inválido.',
            'email.required' => 'E-mail é obrigatório.',
            'email.email' => 'E-mail inválido.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.confirmed' => 'As senhas não coincidem.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.mixedCase' => 'A senha deve conter ao menos 1 letra maiúscula e 1 letra minúscula.',
            'password.numbers' => 'A senha deve conter ao menos 1 número.',
            'password.symbols' => 'A senha deve conter ao menos 1 caracter especial.',
            'password.uncompromised' => 'Sua senha é muito fraca!',
        ]);

        $user = User::where('email', $request->email)
            ->where('reset_token', $request->token)
            ->first();

        if (!$user) {
            return response()->json([
                'message' => 'Token ou e-mail inválido.'
            ], 401);
        }

        if (Carbon::now()->isAfter($user->reset_token_expires_at)) {
            return response()->json([
                'message' => 'Token expirado. Solicite uma nova redefinição de senha.'
            ], 401);
        }

        $user->password = bcrypt($request->password);
        $user->reset_token = null;
        $user->reset_token_expires_at = null;
        $user->save();

        return response()->json([
            'message' => 'Senha redefinida com sucesso. Faça login com sua nova senha.'
        ], 200);
    }

    public function confirmEmail(Request $request)
    {
        $token = $request->token;
        $email = $request->email;

        $user = User::where('email', $email)->first();

        if ($user->verification_code === $token) {
            $user->email_verified_at = now();
            $user->save();
            return redirect('/')->with('success', 'E-mail confirmado com sucesso.');
        }

        return redirect('/')->with('error', 'Erro ao confirmar e-mail.');
    }

    public function sendConfirmEmail()
    {
        $email = Auth::user()->email;
        $name = Auth::user()->name;
        $token = Str::random(10);

        $url = env('APP_URL') . "/confirm-email?token=$token&email=$email";

        Mail::send('emails.confirm-email', ['url' => $url, 'name' => $name], function ($message) use ($email) {
            $message->to($email)->subject('Confirmação de Email');
        });

        $user = User::where('email', $email)->first();
        $user->verification_code = $token;
        $user->save();

        return redirect('/user-info')->with('success', 'E-mail de confirmação enviado com sucesso.');
    }

}
