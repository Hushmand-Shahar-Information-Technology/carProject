<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
   public function store(OfferRequest $request)
    {
        try {
            $offer = Offer::create([
                'name'=> $request->mao_name,
                'phone' => $request->mao_phone,
                'email' => $request->mao_email,
                'price' => $request->mao_price,
                'car_id' => $request->mao_car_id,
                'remark' => $request->mao_comments,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Offer submitted successfully.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

}