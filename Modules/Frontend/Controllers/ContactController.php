<?php

namespace Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display the contact page
     */
    public function index(Request $request)
    {
        // Extract auto-fill data from URL parameters
        $autoFillData = [
            'package' => $request->get('package'),
            'location' => $request->get('location'),
            'price' => $request->get('price'),
            'duration' => $request->get('duration'),
            'request_type' => $request->get('request'),
            'mood' => $request->get('mood'),
            'distance' => $request->get('distance'),
            'category' => $request->get('category'),
        ];

        // Filter out null/empty values
        $autoFillData = array_filter($autoFillData, function($value) {
            return !is_null($value) && $value !== '';
        });

        return view('contact', compact('autoFillData'));
    }

    /**
     * Handle contact form submission
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        try {
            // Send email to admin
            Mail::send('emails.contact-inquiry', ['data' => $validatedData], function ($message) use ($validatedData) {
                $message->to(config('mail.company_email', 'cholo.bondhu.noreply@gmail.com'))
                       ->subject('New Contact Inquiry: ' . $validatedData['subject']);
            });

            return back()->with('success', 'Thank you for your message! We will get back to you soon.');
        } catch (\Exception $e) {
            return back()->with('error', 'Sorry, there was an error sending your message. Please try again.');
        }
    }
}
