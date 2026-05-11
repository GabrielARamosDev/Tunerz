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

        if (($user && Hash::check($request->password, $user->password)) && Auth::attempt($credentials)) {

            $token = $user->createToken('auth_token')->plainTextToken;

            $remember_me = $request->remember_me ?? false;

            Auth::login($user, $remember_me);

            session()->flash('success', 'Autenticado com sucesso!');

            if ($user->role === 'ADMIN') {
                $request->session()->put('isAdmin', 1);
                $request->session()->put('adminId', Auth::id());
            }

            return response()->json([
                'data' => [
                    'user' => $user,
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
        if ($request->session()->pull('isAdmin', 0)) {
            $adminId = $request->session()->pull('adminId', 0);

            Auth::logout();

            if ($adminId && Auth::loginUsingId($adminId)) {
                return redirect('/adm');
            }
        } else {
            Auth::logout();
        }

        return redirect('/login');
    }

    public function register(Request $request)
    {
        Validator::extend('name', function ($attribute, $value, $parameters, $validator) {
            return str_word_count($value) > 1;
        });

        // if ($request->cpf) {
        //     $request['cpf'] = (int) preg_replace('/[^0-9]/', '', $request->cpf);
        // }

        $rules = [
            'name' => 'required|max:255',
            // 'username' => 'required|max:30|unique:users',
            'email' => 'required|email|unique:users',
            'password' => Password::min(8)
                ->mixedCase()     // allows both uppercase and lowercase
                ->letters()       // accepts letter
                ->numbers()       // accepts numbers
                ->symbols()       // accepts special character
                ->uncompromised() // check to be sure that there is no data leak
                ->rules([         // additional rules
                    'required',
                    'confirmed',
                ]),
            // 'cpf' => 'required|min:11|max:14|unique:users',
            'phone' => 'required',
            // 'birthday' => 'required|date|before:-18 years',
        ];

        $messages = array_merge([
            // 'username.required' => 'O campo nome de usuário é obrigatório.',
            // 'username.max' => 'O campo nome de usuário deve ter no máximo 30 caracteres',
            // 'username.unique' => 'Este nome de usuário já está registrado.',
            //
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Digite um endereço de e-mail válido.',
            'email.unique' => 'Este e-mail já está registrado.',
            //
            'password.required' => 'O campo senha é obrigatório.',
            'password.confirmed' => 'As senhas não coincidem.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.mixedCase' => 'A senha deve conter ao menos 1 letra maiúscula e 1 letra minúscula.',
            'password.numbers' => 'A senha deve conter ao menos 1 número.',
            'password.symbols' => 'A senha deve conter ao menos 1 caracter especial.',
            'password.uncompromised' => 'Sua senha é muito fraca!',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O nome não deve ter mais de 255 caracteres.',
            'name.name' => 'O campo nome deve conter nome e sobrenome.',
            // 'cpf.required' => 'O campo CPF é obrigatório.',
            // 'cpf.unique' => 'Este CPF já está registrado.',
            'phone.required' => 'O campo telefone é obrigatório.',
            // 'birthday.required' => 'O campo data de nascimento é obrigatório.',
            // 'birthday.date' => 'Digite uma data de nascimento válida.',
            // 'birthday.before' => 'Você deve ter mais de 18 anos para se cadastrar.',
        ]);

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else if ($validator->validate()) {
            $user = User::create([
                'name' => $request->name,
                // 'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
                // 'birthday' => $request->birthday,
                // 'cpf' => $request->cpf,
                // 'profession' => $request->profession,
                // 'instagram' => $request->instagram,
                // 'token' => Str::random(60),
            ]);

            if ($user) {

                $user->roles()->sync([Roles::USER]);

                // $rules = [
                //     'street_address' => 'required',
                //     'number' => 'required',
                //     'complement' => 'nullable',
                //     'city' => 'required',
                //     'neighborhood' => 'required',
                //     'state' => 'required',
                //     'postal_code' => 'required',
                // ];

                // $messages = [
                //     'street_address.required' => 'O campo endereço é obrigatório.',
                //     'number.required' => 'O campo número é obrigatório.',
                //     'city.required' => 'O campo cidade é obrigatório.',
                //     'neighborhood.required' => 'O campo bairro é obrigatório.',
                //     'state.required' => 'O campo estado é obrigatório.',
                //     'postal_code.required' => 'O campo CEP é obrigatório.',
                // ];

                // $validator = Validator::make($request->all(), $rules, $messages);

                // $address = new UserAddress();
                // $address->user_id = auth()->user()->id;
                // $address->street_address = $request->street_address;
                // $address->number = $request->number;
                // $address->complement = $request->complement;
                // $address->city = $request->city;
                // $address->neighborhood = $request->neighborhood;
                // $address->state = $request->state;
                // $address->postal_code = $request->postal_code;
                // $address->save();

                // $address = UserAddress::create([
                //     'user_id' => $user->id,
                //     'street_address' => $request->street_address,
                //     'number' => $request->number,
                //     'complement' => $request->complement,
                //     'city' => $request->city,
                //     'neighborhood' => $request->neighborhood,
                //     'state' => $request->state,
                //     'postal_code' => $request->postal_code,
                // ]);

                // if ($address) {
                return redirect()->route('login')->with('success', 'Registrado com sucesso.');
                // }

                // return redirect()->route('register')->with('error', 'Erro ao registrar endereço de usuário. Tente novamente.');
            }

            return redirect()->route('register')->with('error', 'Erro ao registrar usuário. Tente novamente.');
        }
    }

    // public static function orderCheckoutValidation(Request $request, $payment_type)
    // {
    //     // dd($request->all());

    //     $requestData = $request->data;

    //     $userId = $requestData['userId'];
    //     $user = User::find($userId);

    //     if (!$user) {
    //         return [ 'error' => 'Usuário não encontrado', 'status_code' => 404 ];
    //     }

    //     $isGuest = $user && $user->isGuest;

    //     $requestData['cpf'] = str_replace(['.', '-'], ['', ''], $requestData['cpf']);

    //     $rules = [
    //         'name' => 'required|max:255',
    //         'nationality' => 'required',
    //         'cpf' => 'required|min:11|max:14',
    //         'email' => 'required|email',
    //         'userAddress' => 'required',
    //         'postal_code' => 'required|min:8|max:9',
    //         'city' => 'required',
    //         'birthday' => 'required',
    //         'telefoneContato' => 'required',
    //         'hasSkied' => 'required',
    //         'trip_date' => 'required',
    //         'destination' => 'required',
    //     ];
    //     $messages = [
    //         'name.required' => 'O campo nome é obrigatório.',
    //         'nationality.required' => 'O campo nacionalidade é obrigatório.',
    //         'cpf.required' => 'O campo CPF é obrigatório.',
    //         'email.required' => 'O campo email é obrigatório.',
    //         'userAddress.required' => 'O campo endereço é obrigatório.',
    //         'postal_code.required' => 'O campo CEP é obrigatório.',
    //         'city.required' => 'O campo cidade é obrigatório.',
    //         'birthday.required' => 'O campo data de nascimento é obrigatório.',
    //         'telefoneContato.required' => 'O campo telefone de contato é obrigatório.',
    //         'hasSkied.required' => 'O campo tem skied é obrigatório.',
    //         'trip_date.required' => 'O campo data de viagem é obrigatório.',
    //         'destination.required' => 'O campo destino é obrigatório.',
    //     ];

    //     if ($isGuest) {
    //         $rules = array_merge($rules, [
    //             'username' => 'required|max:30|unique:users,username',
    //             'password' => Password::min(8)
    //                 ->mixedCase()     // allows both uppercase and lowercase
    //                 ->letters()       // accepts letter
    //                 ->numbers()       // accepts numbers
    //                 ->symbols()       // accepts special character
    //                 ->uncompromised() // check to be sure that there is no data leak
    //                 ->rules([         // additional rules
    //                     'required',
    //                     'confirmed',
    //                 ]),
    //             'cpf' => 'required|min:11|max:14|unique:users,cpf',
    //             'email' => 'required|email|unique:users,email',
    //         ]);
    //         $messages = array_merge($messages, [
    //             'username.required' => 'O campo nome de usuário é obrigatório.',
    //             'username.unique' => 'O nome de usuário informado já está registrado.',
    //             // normal password rules
    //             'password.required' => 'O campo senha é obrigatório.',
    //             'password.confirmed' => 'As senhas não coincidem.',
    //             // facade password rules (must use ONLY 'password' as prefix attribute)
    //             'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
    //             'password.mixedCase' => 'A senha deve conter ao menos 1 letra maiúscula e 1 letra minúscula.',
    //             'password.numbers' => 'A senha deve conter ao menos 1 número.',
    //             'password.symbols' => 'A senha deve conter ao menos 1 caracter especial.',
    //             'password.uncompromised' => 'Sua senha é muito fraca!',
    //             //
    //             'cpf.unique' => 'O CPF informado ja está registrado.',
    //             'email.unique' => 'O email informado já está registrado.',
    //         ]);
    //     }

    //     $validator = Validator::make($requestData, $rules, $messages);

    //     if ($validator->fails()) {
    //         $errors = [];
    //         foreach ($validator->errors()->all() as $error) {
    //             $errors[] = $error;
    //         }

    //         return [
    //             'error' => $errors,
    //             'status_code' => 422,
    //         ];
    //     }

    //     // dd('Validation:', [
    //     //     'rules' => $rules,
    //     //     'messages' => $messages,
    //     //     'validator' => $validator,
    //     // ]);

    //     switch ($payment_type) {
    //         case 'pix': {
    //             $request->validate([
    //                 'cardFormData.payer.email' => 'required',
    //                 'cardFormData.payment_method_id' => 'required',
    //                 'cardFormData.transaction_amount' => 'required',
    //             ], [
    //                 'cardFormData.payer.email.required' => 'O campo email do pagador é obrigatório.',
    //                 'cardFormData.payment_method_id.required' => 'Erro ao validar forma de pagamento.',
    //                 'cardFormData.transaction_amount.required' => 'Erro ao validar valor da transação.',
    //             ]);

    //             break;
    //         }
    //         case 'credit-card': {
    //             $request->validate([
    //                 'cardFormData.token' => 'required',
    //                 'cardFormData.issuer_id' => 'required',
    //                 'cardFormData.payer.email' => 'required',
    //                 'cardFormData.payer.identification.type' => 'required',
    //                 'cardFormData.payer.identification.number' => 'required',
    //                 'cardFormData.payment_method_id' => 'required',
    //                 'cardFormData.transaction_amount' => 'required',
    //                 'cardFormData.installments' => 'required',
    //             ], [
    //                 'cardFormData.token.required' => 'O campo token é obrigatório.',
    //                 'cardFormData.issuer_id.required' => 'O campo issuer é obrigatório.',
    //                 'cardFormData.payer.email.required' => 'O campo email do pagador é obrigatório.',
    //                 'cardFormData.payer.identification.type.required' => 'O campo tipo de documento do pagador é obrigatório.',
    //                 'cardFormData.payer.identification.number.required' => 'O campo documento do pagador é obrigatório.',
    //                 'cardFormData.payment_method_id.required' => 'Erro ao validar forma de pagamento.',
    //                 'cardFormData.transaction_amount.required' => 'Erro ao validar valor da transação.',
    //                 'cardFormData.installments.required' => 'Erro ao validar quantidade de parcelas.',
    //             ]);

    //             break;
    //         }
    //     }

    //     $name = $requestData['name'];
    //     $nationality = $requestData['nationality'];
    //     $profession = $requestData['profession'];
    //     $cpf = $requestData['cpf'];
    //     $email = $requestData['email'];
    //     $userAddress = $requestData['userAddress'];
    //     $cep = $requestData['postal_code'];
    //     $city = $requestData['city'];
    //     $birthday = $requestData['birthday'];
    //     $telefoneContato = $requestData['telefoneContato'];
    //     $instagram = $requestData['instagram'];
    //     $has_skied = boolval($requestData['hasSkied']);
    //     $trip_date = $requestData['trip_date'];
    //     $destination = $requestData['destination'];

    //     $address = intval($userAddress) 
    //         ? UserAddress::find($userAddress) 
    //         : null;

    //     $quantity = $requestData['quantity'];
    //     $amount = $requestData['amount'];

    //     if ($isGuest) { // will create new user, based on guest auth and fetched data
    //         try {
    //             DB::beginTransaction();

    //             $userName = $requestData['username'];

    //             $username_exists = User::where('username', $userName)->first();
    //             if ($username_exists) {
    //                 return [ 'error' => 'Já existe um cadastro com este nome de usuário!', 'status_code' => 400 ];
    //             }

    //             $email_exists = User::where('email', $email)->first();
    //             if ($email_exists) {
    //                 return [ 'error' => 'Já existe um cadastro com este email!', 'status_code' => 400 ];
    //             }

    //             $cpf_exists = User::where('cpf', $cpf)->first();
    //             if ($cpf_exists) {
    //                 return [ 'error' => 'Já existe um cadastro com este CPF!', 'status_code' => 400 ];
    //             }

    //             $user->update([
    //                 'name' => $name,
    //                 'username' => $userName,
    //                 'email' => $email,
    //                 'password' => bcrypt($requestData['password']),
    //                 'phone' => $telefoneContato,
    //                 'birthday' => $birthday,
    //                 'cpf' => $cpf,
    //                 'nationality' => $nationality,
    //                 'profession' => $profession,
    //                 'instagram' => $instagram,
    //                 'role' => 'USER',
    //                 'token' => Str::random(60),
    //             ]);
    //             $createdUser = $user->save();

    //             if (!$createdUser) {
    //                 return [ 'error' => 'Erro ao criar usuário', 'status_code' => 500 ];
    //             }

    //             $address = UserAddress::create([
    //                 'user_id' => $user->id,
    //                 'street_address' => $requestData['userAddress'],
    //                 'number' => $requestData['number'],
    //                 'complement' => $requestData['complement'],
    //                 'city' => $requestData['city'],
    //                 'neighborhood' => $requestData['neighborhood'],
    //                 'state' => $requestData['state'],
    //                 'postal_code' => $requestData['postal_code'],
    //             ]);
    //             $createdAddress = $address->save();

    //             if (!$createdAddress) {
    //                 return [ 'error' => 'Erro ao criar endereço', 'status_code' => 500 ];
    //             }

    //             $userAddress = $address->id;

    //             // DB::commit();
    //         } catch (\Exception $e) {
    //             DB::rollBack();

    //             return [ 'error' => $e->getMessage(), 'status_code' => 500 ];
    //         }
    //     }

    //     if (!empty($telefoneContato)) {
    //         $user->phone = $telefoneContato;
    //         $user->save();
    //     }
    //     if (!empty($profession)) {
    //         $user->profession = $profession;
    //         $user->save();
    //     }
    //     if (!empty($instagram)) {
    //         $user->instagram = $instagram;
    //         $user->save();
    //     }
    //     if ($has_skied) {
    //         $user->has_skied = 1;
    //         $user->save();
    //     }

    //     $cart = Cart::where('user_id', $userId)->get();

    //     if ($user && !$user->isGuest && $address) {

    //         $uniqId = uniqid();

    //         try {
    //             DB::beginTransaction();

    //             $itemOrder = [
    //                 'user_id' => $userId,
    //                 'total_price' => $amount,
    //                 'delivery_method' => 'correios',
    //                 'user_address_id' => intval($userAddress),
    //                 'trip_date' => Carbon::parse($trip_date),
    //                 'destination' => $destination,
    //                 'receiver_name' => $name,
    //                 'receiver_phone' => $telefoneContato,
    //                 'collector_id' => $uniqId,
    //                 'payment_type' => $payment_type,
    //                 'created_at' => now(),
    //             ];

    //             $order = Order::create($itemOrder);
    //             $order_id = $order->id;

    //             foreach ($cart as $item) {
    //                 $size = ProductVariant::where('product_id', $item->product_id)
    //                     ->where('size', $item->size)
    //                     ->first();

    //                 $itemRental = [
    //                     'user_id' => $userId,
    //                     'product_id' => $item->product_id,
    //                     'id_size' => $size->id,
    //                     'quantity' => $item->quantity,
    //                     'start_date' => $item->start_date,
    //                     'end_date' => $item->end_date,
    //                     'status' => 'pendente',
    //                     'order_id' => $order_id,
    //                     'created_at' => now(),
    //                 ];
    //                 RentalListing::insert($itemRental);

    //                 $orderItems = [
    //                     'order_id' => $order_id,
    //                     'product_id' => $item->product_id,
    //                     'quantity_sold' => $item->quantity,
    //                     'created_at' => now(),
    //                 ];
    //                 OrderItem::insert($orderItems);
    //             }

    //             DB::commit();

    //             return [ // ALL GOOD - return data and start transaction
    //                 'user' => $user,
    //                 'user_address' => $address,
    //                 'uniq_id' => $uniqId,
    //                 'order_id' => $order_id,
    //                 'order' => $order,
    //             ];
    //         } catch (\Exception $e) {
    //             DB::rollBack();

    //             return [ 'error' => 'Erro ao inserir pedido ou itens do pedido: ' . $e->getMessage(), 'status_code' => 500 ];
    //         }
    //     }

    //     return [ 'error' => 'Erro ao validar usuário ou endereço', 'status_code' => 500 ];
    // }

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

    // public function loginInUser(Request $request, $user_id)
    // {
    //     $user = User::find($user_id);

    //     if (!$user) {
    //         return redirect()->back()->with('error', 'Usuário não encontrado.');
    //     }

    //     if (Auth::check() && Auth::user()->role === 'ADMIN') {
    //         $request->session()->put('isAdmin', 1);
    //         $request->session()->put('adminId', Auth::id());

    //         if (Auth::loginUsingId($user_id)) {
    //             return redirect('/')->with('success', 'Autenticado com sucesso como usuário!');
    //         }
    //     }

    //     return redirect()->back()->with('error', 'Acesso não autorizado.');
    // }


    // public function verifySeller($reffer)
    // {
    //     $etsCorpUrl = "https://painel.etscorp.com.br/api/verify-seller?seller=" . $reffer;
    //     $response = Http::withHeaders([
    //         'token' => '$2a$12$oJfJbngVcNSu78CqEbxFjOTYyqpHvtVmeKE1R4smDwl2.AYgZAHf2'
    //     ])->get($etsCorpUrl);

    //     if ($response->failed()) {
    //         return false;
    //     }

    //     $data = $response->json();

    //     if (is_array($data)) {
    //         $data = (object) $data;
    //     }

    //     if ($data && property_exists($data, 'username')) {
    //         return $data;
    //     }

    //     return false;
    // }


    // public function changeProfile(Request $request)
    // {
    //     $data = $request->except('_token');

    //     Validator::extend('name', function ($attribute, $value, $parameters, $validator) {
    //         return str_word_count($value) > 1;
    //     });

    //     if (isset($data['name'])) {
    //         $rules = [
    //             'name' => ['required', 'max:255', 'name'],
    //         ];

    //         $messages = [
    //             'name.required' => 'O campo nome é obrigatório.',
    //             'name.max' => 'O nome não deve ter mais de 255 caracteres.',
    //             'name.name' => 'O campo nome deve conter nome e sobrenome.',
    //         ];

    //         $validator = Validator::make($data, $rules, $messages);

    //         if ($validator->fails()) {
    //             foreach ($validator->errors()->all() as $error) {
    //                 noty()->error($error);
    //             }
    //             return redirect()->back()->withInput();
    //         }
    //     }

    //     if (isset($data['username'])) {
    //         $rules = [
    //             'username' => 'required|max:30|unique:users,username,' . Auth::id(),
    //         ];

    //         $messages = [
    //             'username.required' => 'O campo nome de usuário é obrigatório.',
    //             'username.max' => 'O campo nome de usuário deve ter no máximo 30 caracteres.',
    //             'username.unique' => 'Este nome de usuário já está registrado.',
    //         ];

    //         $validator = Validator::make($data, $rules, $messages);

    //         if ($validator->fails()) {
    //             foreach ($validator->errors()->all() as $error) {
    //                 noty()->error($error);
    //             }
    //             return redirect()->back()->withInput();
    //         }
    //     }

    //     if (isset($data['email'])) {
    //         $rules = [
    //             'email' => 'required|email|unique:users,email,' . Auth::id(),
    //         ];

    //         $messages = [
    //             'email.required' => 'O campo e-mail é obrigatório.',
    //             'email.email' => 'Digite um endereço de e-mail válido.',
    //             'email.unique' => 'Este e-mail já está registrado.',
    //         ];

    //         $validator = Validator::make($data, $rules, $messages);

    //         if ($validator->fails()) {
    //             foreach ($validator->errors()->all() as $error) {
    //                 noty()->error($error);
    //             }
    //             return redirect()->back()->withInput();
    //         }
    //     }

    //     if (isset($data['cpf'])) {
    //         $rules = [
    //             'cpf' => 'required|unique:users,document_number,' . Auth::id(),
    //         ];

    //         $messages = [
    //             'cpf.required' => 'O campo CPF é obrigatório.',
    //             'cpf.unique' => 'Este CPF já está registrado.',
    //         ];

    //         $validator = Validator::make($data, $rules, $messages);

    //         if ($validator->fails()) {
    //             foreach ($validator->errors()->all() as $error) {
    //                 noty()->error($error);
    //             }
    //             return redirect()->back()->withInput();
    //         }
    //     }

    //     if (isset($data['cnpj'])) {
    //         $rules = [
    //             'cnpj' => 'required|unique:users,document_number,' . Auth::id(),
    //         ];

    //         $messages = [
    //             'cnpj.required' => 'O campo CNPJ é obrigatório.',
    //             'cnpj.unique' => 'Este CNPJ já está registrado.',
    //         ];

    //         $validator = Validator::make($data, $rules, $messages);

    //         if ($validator->fails()) {
    //             foreach ($validator->errors()->all() as $error) {
    //                 noty()->error($error);
    //             }
    //             return redirect()->back()->withInput();
    //         }
    //     }

    //     if (isset($data['rg'])) {
    //         $rules = [
    //             'rg' => 'required|unique:users,rg,' . Auth::id(),
    //         ];

    //         $messages = [
    //             'rg.required' => 'O campo RG é obrigatório.',
    //             'rg.unique' => 'Este RG já está registrado.',
    //         ];

    //         $validator = Validator::make($data, $rules, $messages);

    //         if ($validator->fails()) {
    //             foreach ($validator->errors()->all() as $error) {
    //                 noty()->error($error);
    //             }
    //             return redirect()->back()->withInput();
    //         }
    //     }

    //     User::where('id', Auth::id())->update($data);

    //     return redirect()->route('profile')->with('success', 'Perfil atualizado com sucesso.');
    // }


    // public function changeAvatar(Request $request)
    // {
    //     $user = User::find(Auth::id());

    //     $validator = Validator::make($request->all(), [
    //         'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    //     ], [
    //         'avatar.required' => 'O campo avatar é obrigatório.',
    //         'avatar.image' => 'O arquivo deve ser uma imagem.',
    //         'avatar.mimes' => 'O arquivo deve ser do tipo: jpeg, png, jpg.',
    //         'avatar.max' => 'O arquivo deve ter no máximo 2MB.',

    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 400);
    //     }

    //     $avatar = $request->file('avatar');

    //     if ($avatar) {
    //         if ($user->avatar) {
    //             Storage::disk('public')->delete($user->avatar);
    //         }

    //         $filename = time() . '.' . $avatar->getClientOriginalExtension();
    //         $path = $avatar->storeAs('avatars', $filename, 'public');

    //         $user->avatar = $path;
    //         $user->save();

    //         return response()->json(['success' => 'Avatar atualizado com sucesso.'], 200);
    //     }

    //     return response()->json(['error' => 'Erro ao atualizar avatar.'], 400);
    // }


    // public function changeAddress(Request $request)
    // {
    //     $data = $request->except('_token');

    //     $rules = [
    //         'street' => 'required|max:255',
    //         'city' => 'required|max:255',
    //         'state' => 'required|max:255',
    //         'zip_code' => 'required|max:255',
    //     ];

    //     $messages = [
    //         'street.required' => 'O campo rua é obrigatório.',
    //         'street.max' => 'O campo rua deve ter no máximo 255 caracteres.',
    //         'city.required' => 'O campo cidade é obrigatório.',
    //         'city.max' => 'O campo cidade deve ter no máximo 255 caracteres.',
    //         'state.required' => 'O campo estado é obrigatório.',
    //         'state.max' => 'O campo estado deve ter no máximo 255 caracteres.',
    //         'zip_code.required' => 'O campo CEP é obrigatório.',
    //         'zip_code.max' => 'O campo CEP deve ter no máximo 255 caracteres.',
    //     ];

    //     $validator = Validator::make($data, $rules, $messages);

    //     if ($validator->fails()) {
    //         foreach ($validator->errors()->all() as $error) {
    //             noty()->error($error);
    //         }
    //         return redirect()->back()->withInput();
    //     }

    //     $address = Auth::user()->address;

    //     if ($address) {
    //         $address->update($data);
    //     } else {
    //         $data['user_id'] = Auth::id();
    //         $address = UserAddress::create($data);
    //     }

    //     return redirect()->route('profile')->with('success', 'Endereço atualizado com sucesso.');
    // }
}
