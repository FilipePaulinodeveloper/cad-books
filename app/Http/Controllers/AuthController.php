<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request)
    {
        $request->validate([            
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|regex:(^[a-zA-Z0-9 _-]+[a-zA-Z0-9-14\-[a-zA-Z0-9-.]+$)',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),            
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}


// namespace App\Http\Controllers;

// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Validator;


// class AuthController extends Controller
// {       

//     public function create(Request $request){

//         $array = ['error' => ''];
        
//         $rules = [
//             'email' => 'required|email|unique:users,email',
//             'password' => 'required',
//             'name' => 'required',
//         ];
        
//         $validator = Validator::make($request->all(), $rules);

//         // dd($validator);

//         if($validator->fails()) {
//             $array['error'] = $validator->messages();
//             return  $array;
//         }

//         $name = $request->input('name');
//         $email = $request->input('email');
//         $password = $request->input('password');
       
//         $newUser = new User();

//         $newUser->name = $name;
//         $newUser->email = $email;
//         $newUser->password = password_hash($password , PASSWORD_DEFAULT);
//         $newUser->token = '';

//         $newUser->save();

//         return $array;

//     }

//     public function login(Request $request) {
//         $array = ['error' => ''];

//             $creds = $request->only('email', 'password');

//             $token = Auth::attempt([$creds]);
            
//             if($token){
//                 $array['token'] = $token;
//             }else{
//                 $array['error'] = 'E-mail e/ou senha ou email incorretos.';
//             }

//         return $array;
//     }
// }
