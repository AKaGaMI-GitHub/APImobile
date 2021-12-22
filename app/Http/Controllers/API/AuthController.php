<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        $validate = Validator::make($request->all(), [
            //'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        // if ($validate->fails()){
        //     $response = [
        //         'status' => 'error',
        //         'msg' => 'validator error',
        //         'errors' => $validate->errors(),
        //         'content' => null,
        //     ];
        //     return response()->json($response, 200);
        // } else {
        //     $credentials = request(['email','password']);
        //     //$credentials = Arr::add($credentials, 'status', 'aktif');
        //     if (!Auth::attempt($credentials)) {
        //         $response = [
        //             'status' => 'error',
        //             'msg' => 'Unathorized',
        //             'errors' => null,
        //             'content' => null,
        //         ];
        //         return response()->json($response, 401);
        //     }
        //$user = User::where('email', $request->email)->first();

        // if(!$user || !Hash::check($request->password, $user->password)){
        //     return response()->json(
        //         [
        //             'success' => false,
        //             'message' => 'Email or Password invalid',
        //         ], 401);
        // }
        // $token = $user->createToken('token')->plainTextToken;
        // return response()->json(
        //     [
        //         'success' => true,
        //         'message' => 'Success',
        //         'user' => $user,
        //         'token' => $token,
        //     ], 200);

            $user = User::where('email', $request->email)->first();
            if (! Hash::check($request->password, $user->password, [])) {
                return response()->json(
                            [
                                'success' => false,
                                'message' => 'Email or Password invalid',
                            ], 401);
            }

            $toketresult = $user->createToken('token-auth')->plainTextToken;
            $response = [
                'success' => true,
                'message' => 'Login Berhasil',
                'content' => [
                        'status_code' => 200,
                        'access_token' => $toketresult,
                        'token_type' => 'Bearer',
                ]
            ];
            return response()->json($response, 200);
        
    }
}
