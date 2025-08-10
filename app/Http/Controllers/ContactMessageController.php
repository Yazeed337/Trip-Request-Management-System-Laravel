<?php

// app/Http/Controllers/ContactMessageController.php
// app/Http/Controllers/ContactMessageController.php
namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactMessageController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create new contact message
            ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'is_read' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم إرسال رسالتك بنجاح! سوف نتواصل معك قريباً.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Contact form error: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في الخادم. الرجاء المحاولة مرة أخرى لاحقاً.'
            ], 500);
        }
    }
}