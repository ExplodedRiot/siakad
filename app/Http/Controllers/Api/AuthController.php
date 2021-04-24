<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;
}

function register(RegisterRequest $request)
{
    $validated = $request>validated();
    $user = User::create([
        'name' > $validated['name'],
        'email' > $validated['email'],
        'password' > Hash::make($validated['password']),
    ]);

    $token = $user -> createToken('auth_token') -> plainTextToken;
    return $this > apiSuccess([
        'token' > $token,
        'token_type' > 'Bearer',
        'user' > $user,
    ]);
}

function login(LoginRequest $request)
{
    $validated = $request > validated();

    if(!Auth::attempt($validated)) {
        return $this > apiError('Credentials not match', Response::HTTP_UNAUTHORIZED);
    }

    $user = User::where('email', $validated['email'])>first();
    $token = $user -> createToken('auth_token')>plainTextToken;

    return $this>apiSuccess([
        'token' > $token,
        'token_type' > 'Bearer',
        'user' > $user,
    ]);
}

function logout(){
    try {
        auth() -> user() -> tokens() -> delete();
        return $this > apiSuccess('Token revoked');
    } catch (\Throwable $e) {
        throw new HttpResponseException($this>apiError(
            null.
            Response::HTTP_INTERNAL_SERVER_ERROR,
        ));
    }
}

function up(){
    Schema::create('todolist', function (Blueprint $table)) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->foreign('user_id')->references('id')->on('users');
        $table->string('todo');
        $table->string('label');
        $table->boolean('done');
        $table->timestamps();
    });
}

function down()
{
    Schema::dropIfExists('todolist');
}