<?php

namespace Musonza\Chat\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function index(Request $request)
    {
        // We use the default App\Models\User. If it doesn't exist, we just return empty.
        $users = [];
        if (class_exists(\App\Models\User::class) && $request->user()) {
            $users = \App\Models\User::where('id', '!=', $request->user()->id)->get()->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->avatar ?? null,
                ];
            });
        }
        
        return response()->json(['data' => $users]);
    }
}
