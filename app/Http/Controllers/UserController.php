<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function signin(Request $request) : Response
    {
        $payload = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        $existantToken = $request->header('Authorization');

        if(isset($existantToken) && $existantToken != null)
        {
            return response(['message' => 'connected'], 200, ['Content-Type: application/json', 'Authorization: '.$existantToken .'']);
        }

        if(!isset($payload['email']) || $payload['email'] == null)
        {
            return response(['message' => 'missing email', 400, ['Content-Type: application/json']]);
        }

        if(!isset($payload['password']) || $payload['password'] == null)
        {
            return response(['message' => 'missing password', 400, ['Content-Type: application/json']]);
        }

        if($token = auth('api')->attempt($payload))
        {
            return response(['message' => 'connected'], 200, ['Content-Type: application/json', 'Authorization: '.$token .'']);
        }

        return response(['message' => 'invalid credentials'], 401, ['Content-Type: application/json']);
    }

    public function index()
    {
        $user_data = DB::table('users')->get();
        return response(['message' => $user_data], 200, ['Content-Type: application/json']);
    }

    public function getById(string $id) : Response
    {
        if(!isset($id))
        {
            
            return response(['message' => 'invalid id'], 400, ['Content-Type: application/json']);
        }
        $user_data = DB::table('users')->where('id', intval($id))->get();
        return response(['message' => $user_data], 200, ['Content-Type: application/json']);
    }

    public function create(Request $request) : Response
    {
        $payload = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'created_at' => now('America/Sao_Paulo')
        ];
        if(!isset($payload['name']) || $payload['name'] == null)
        {
            return response(['message' => 'missing name'], 400, ['Content-Type: application/json']);
        }
        if(!isset($payload['email']) || $payload['email'] == null)
        {
            return response(['message' => 'missing email'], 400, ['Content-Type: application/json']);
        }
        if(!isset($payload['password']) || $payload['password'] == null)
        {
            return response(['message' => 'missing password'], 400, ['Content-Type: application/json']);
        }
        DB::table('users')->insert($payload);
        return response(['message' => 'created'], 201, ['Content-Type: application/json']);
    }

    public function update(Request $request)
    {
        $payload = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'updated_at' => now('America/Sao_Paulo')
        ];

        return response(['message' => 'updated'], 200, ['Content-Type: application/json']);
    }

    public function delete(string $id)
    {
        return response(['message' => 'deleted'], 200, ['Content-Type: application/json']);
    }
}
