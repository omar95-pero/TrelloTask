<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
// models
use App\Models\User;


class ClientAuthController extends Controller
{

    public $UserWith = [];

    public function final_response($data = null, $message = '', $code = 200, $in_two_response = 'yes')
    {
        $postman_code = 200;
        if ($in_two_response == 'yes') {
            $postman_code = $code;
        }
        return response()->json([
            'data'    => $data,
            'message' => $message,
            'status'  => intval($code)
        ], $postman_code);
    }

    // ===============================================================================
    public function login()
    {
        $credentials['email']      =  request()->email;
        $credentials['password']        =  request()->passord;
        if (Auth::attempt($credentials)) {
            return $this->final_response(null, 'Your account Is blocked', 409, 'no');
            $user                = Auth::user();
            $data_user           = User::where('id',  $user->id)->with($this->UserWith)->first();
            return $this->final_response($data_user, 'success', 200);
        }
        return $this->final_response(null, 'Unauthorized', 401, 'no');
    }
    // ===============================================================================

    // ===============================================================================
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'           => 'required|email|unique:users',
            'name'            => 'required|max:150',
            'password'        => 'required|min:6',

        ], [
            'email.unique'           => '406',
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors) && $errors == 406) {
                $code = collect($validator->errors())->flatten(1)[0];
                return $this->final_response(null, 'failed , emial Must be Unique ', 406, 'no');
            }
            return $this->final_response(collect($validator->errors())->flatten(1), 'failed', 422, 'yes');
        }

        $data = collect($validator->validated())->toArray();
        $data['password']    =  Hash::make($request->password);

        $user = User::create($data);
        return $this->final_response($data, 'success', 200, 'yes');
    }
    // ===============================================================================




}
