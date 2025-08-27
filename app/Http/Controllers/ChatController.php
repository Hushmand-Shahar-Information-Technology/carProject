<?php

namespace App\Http\Controllers;
use App\Models\Car;
use Chatify\Facades\ChatifyMessenger;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{

    public function sendProductMessage($user_id, $car_id)
    {
        $vendor = User::findOrFail($user_id);
        $product = Car::findOrFail($car_id);
        $user = Auth::user();

        // Ensure the user is not messaging themselves
        if ($user->id == $vendor->id) {
            return redirect()->route('home.index')->with('error', 'Cannot message yourself.');
        }

        // Prepare product image and info for the message
        $productImage = $product->image ? asset('storage/' . $product->image) : asset('images/default-car.png');
        $message = '<div style="display:flex;align-items:center;gap:10px;">'
            . '<a href="' . 'testing' . '" target="_blank">'
            . '<img src="' . $productImage . '" alt="Product Image" style="width:80px;height:60px;object-fit:cover;border-radius:6px;">'
            . '</a>'
            . '<div>'
            . '<a href="' . 'testing' . '" target="_blank" style="font-weight:bold;text-decoration:none;color:#333;">' . $product->name . '</a><br>'
            . '<span style="color:#666;">' . e(Str::limit($product->description, 60)) . '</span>'
            . '</div>'
            . '</div>';

        // Send message
        ChatifyMessenger::newMessage([
            'from_id' => $user->id,
            'to_id' => $vendor->id,
            'body' => $message,
            'attachment' => null,
        ]);

        // Redirect to chatify chat with vendor
        return redirect()->route('chatify', ['id' => $vendor->id]);
    }

}
