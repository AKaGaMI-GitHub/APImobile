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
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validate->fails()){
            $response = [
                'status' => 'error',
                'msg' => 'validator error',
                'errors' => $validate->errors(),
                'content' => null,
            ];
            return response()->json($response, 200);
        } else {
            $credentials = request(['name','email','password']);
            //$credentials = Arr::add($credentials, 'status', 'aktif');
            if (!Auth::attempt($credentials)) {
                $response = [
                    'status' => 'error',
                    'msg' => 'Unathorized',
                    'errors' => null,
                    'content' => null,
                ];
                return response()->json($response, 401);
            }

            $user = User::where('name', $request->name)->first();
            if (! Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Error pada login');
            }

            $toketresult = $user->createToken('token-auth')->plainTextToken;
            $response = [
                'status' => 'success',
                'msg' => 'Login Berhasil',
                'errors' => null,
                'content' => [
                        'status_code' => 200,
                        'access_token' => $toketresult,
                        'token_type' => 'Bearer',
                ]
            ];
            return response()->json($response, 401);
        }
    }
}
