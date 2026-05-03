<?php 

namespace App\Actions\Auth;

use Illuminate\Http\Request;

class LogoutAction
{
    public function handle(Request $request): void
    {
        $token = $request->user()->token();
        // dd($token);
        $token->revoke();
    }
}