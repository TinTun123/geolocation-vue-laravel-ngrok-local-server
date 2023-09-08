<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getActivity(Request $request) {

        $useractivities = User::with('locations')->get()->toArray();

        return response()->json(['activities' => $useractivities]);
        
    }
}
