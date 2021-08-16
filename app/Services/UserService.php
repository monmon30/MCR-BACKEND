<?php

namespace App\Services;

use App\Exceptions\AuthCantDeleteSelfException;

class UserService
{
    public function deleteUser($user)
    {
        if (auth()->user()->id == $user->id) {
            throw new AuthCantDeleteSelfException();
        }
        $user->delete();
        return response()->json([], 204);
    }
}
