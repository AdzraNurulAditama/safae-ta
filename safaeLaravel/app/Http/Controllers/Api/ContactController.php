<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Submit contact message
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        $contact = ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return ResponseHelper::success($contact, 'Message sent successfully', 201);
    }

    /**
     * Get all contact messages (Admin only)
     */
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->get();

        return ResponseHelper::success($messages, 'Contact messages retrieved successfully');
    }

    /**
     * Get contact message by ID (Admin only)
     */
    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);

        return ResponseHelper::success($message, 'Contact message retrieved successfully');
    }

    /**
     * Delete contact message (Admin only)
     */
    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return ResponseHelper::success(null, 'Contact message deleted successfully');
    }
}
