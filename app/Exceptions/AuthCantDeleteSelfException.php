<?php

namespace App\Exceptions;

use Exception;

class AuthCantDeleteSelfException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json(["error" => [
            "message" => "Failed to delete own account",
        ]], 500);
    }
}
