<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OfferController extends Controller
{
   public function store(OfferRequest $request)
    {
        try {
            // Log the incoming request data for debugging
            Log::info('Offer submission attempt:', $request->all());
            
            $offer = Offer::create([
                'name'=> $request->mao_name,
                'phone' => $request->mao_phone,
                'email' => $request->mao_email,
                'price' => $request->mao_price,
                'car_id' => $request->mao_car_id,
                'remark' => $request->mao_comments,
            ]);
            
            Log::info('Offer created successfully:', ['offer_id' => $offer->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Offer submitted successfully!'
            ], 200);
            
        } catch (\Throwable $th) {
            Log::error('Error creating offer:', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
                'error' => $th->getMessage() // Include actual error for debugging
            ], 500);
        }
    }

}