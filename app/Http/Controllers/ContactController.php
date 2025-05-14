<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Prepare the data for the email
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'userMessage' => $request->message, // Rename 'message' to 'userMessage'
        ];

        // Send the email
        Mail::send('emails.contact', $data, function ($mail) use ($data) {
            $mail->to('abassibrahim333@gmail.com') // Replace with your assigned email
                ->subject('New Contact Us Message')
                ->from($data['email'], $data['name']); // Use the sender's email and name
        });

        // Redirect back with a success message
        return back()->with('success', 'Your message has been sent successfully!');
    }
}
