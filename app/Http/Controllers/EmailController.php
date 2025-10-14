<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    public function store(Request $request) {

        $request->validate([
        'email' => ['required','email']
        ]);

        Email::create($request->all());

        return response()->json(['success' => true, 'message' => 'Thank you for subscribing to our newsletter!']);
    }
}
