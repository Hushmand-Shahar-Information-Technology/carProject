<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;

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
