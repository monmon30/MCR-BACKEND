<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserResetPasswordController extends Controller
{
    public function __invoke(UserResetPasswordRequest $request, User $user)
    {
        $user->update($request->validated());

        return new UserResource(User::find($user->id));
    }
}
