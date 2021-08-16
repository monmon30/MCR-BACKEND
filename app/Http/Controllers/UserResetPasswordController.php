<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserResetPasswordRequest;
use App\Models\User;

class UserResetPasswordController extends Controller
{
    public function __invoke(UserResetPasswordRequest $request, User $user)
    {
        $user->update($request->validated());
    }
}
