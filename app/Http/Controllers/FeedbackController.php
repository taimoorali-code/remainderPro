<?php
namespace App\Http\Controllers;


use App\Models\Feedback; // Make sure to import the Feedback model
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'dial_code' => 'required|string',
            'country' => 'required|string',
            'mobile_number' => 'required|string',
            'feedback' => 'required|string',
        ]);

        $feedback = Feedback::create([
            'name' => $request->name,
            'email' => $request->email,
            'dial_code' => $request->dial_code,
            'country' => $request->country,
            'mobile_number' => $request->mobile_number,
            'feedback' => $request->feedback,
        ]);

        return response()->json([
            'message' => 'Feedback stored successfully',
            'feedback' => $feedback,
        ]);
    }
}
