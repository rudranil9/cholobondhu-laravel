<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactInquiry;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactInquiryMail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $destinations = [
            'Darjeeling', 'Sikkim', 'Sundarbans', 'Digha', 'Bakkhali',
            'Goa', 'Kerala', 'Rajasthan', 'Himachal Pradesh', 'Ladakh',
            'Andaman', 'Northeast India', 'South India', 'Golden Triangle', 'Custom Package'
        ];

        $selectedPackage = null;
        if ($request->has('request') && $request->get('request') === 'booking') {
            $selectedPackage = [
                'name' => $request->get('tour') ?? $request->get('package') ?? $request->get('destination'),
                'location' => $request->get('location'),
                'price' => $request->get('price'),
                'duration' => $request->get('duration'),
                'mood' => $request->get('mood'),
                'distance' => $request->get('distance'),
                'category' => $request->get('category')
            ];
        }

        return view('contact', compact('destinations', 'selectedPackage'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|regex:/^[\d\s\-\+\(\)]+$/',
            'destination' => 'nullable|string|max:255',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
            'number_of_travelers' => 'required|integer|min:1|max:50',
            'budget_range' => 'nullable|string|max:255',
            'message' => 'required|string|min:10|max:1000',
            'inquiry_type' => 'in:general,booking,custom-quote'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $inquiry = ContactInquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'destination' => $request->destination,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'number_of_travelers' => $request->number_of_travelers,
            'budget_range' => $request->budget_range,
            'message' => $request->message,
            'inquiry_type' => $request->inquiry_type ?? 'general'
        ]);

        // Send email notification
        $emailSent = false;
        try {
            Mail::to(config('mail.company_email', 'cholo.bondhu.noreply@gmail.com'))
                ->send(new ContactInquiryMail($inquiry));
            $emailSent = true;
            \Log::info('Contact inquiry email sent successfully for inquiry ID: ' . $inquiry->id);
        } catch (\Exception $e) {
            \Log::error('Failed to send contact email: ' . $e->getMessage(), [
                'inquiry_id' => $inquiry->id,
                'email' => $inquiry->email,
                'error' => $e->getTraceAsString()
            ]);
        }

        if ($request->expectsJson()) {
            if ($emailSent) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for your inquiry! We will get back to you within 24 hours.'
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Your inquiry has been saved. We will contact you soon via phone if email delivery fails.'
                ]);
            }
        }

        $message = $emailSent ? 
            'Thank you for your inquiry! We will get back to you within 24 hours.' : 
            'Your inquiry has been saved. We will contact you soon via phone if email delivery fails.';
            
        return redirect()->back()->with('success', $message);
    }

    /**
     * Admin method to display all contact inquiries
     */
    public function adminIndex(Request $request)
    {
        $query = ContactInquiry::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('destination', 'LIKE', "%{$search}%")
                  ->orWhere('message', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by inquiry type
        if ($request->has('inquiry_type') && $request->inquiry_type !== '') {
            $query->where('inquiry_type', $request->inquiry_type);
        }

        $inquiries = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.contact-inquiries.index', compact('inquiries'));
    }

    /**
     * Admin method to show a specific contact inquiry
     */
    public function adminShow(ContactInquiry $contactInquiry)
    {
        return view('admin.contact-inquiries.show', compact('contactInquiry'));
    }

    /**
     * Admin method to update contact inquiry status
     */
    public function updateStatus(Request $request, ContactInquiry $contactInquiry)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,closed'
        ]);

        $contactInquiry->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Inquiry status updated successfully!'
        ]);
    }

    /**
     * Delete a contact inquiry
     */
    public function destroy(ContactInquiry $contactInquiry)
    {
        try {
            $customerName = $contactInquiry->name;
            $customerEmail = $contactInquiry->email;
            $inquiryType = $contactInquiry->inquiry_type;
            
            // Delete the contact inquiry
            $contactInquiry->delete();
            
            \Illuminate\Support\Facades\Log::info("Contact inquiry deleted by admin: ID {$contactInquiry->id}, Customer: {$customerName}, Email: {$customerEmail}, Type: {$inquiryType}");
            
            return redirect()->route('admin.contact-inquiries.index')->with('success', "Contact inquiry deleted successfully! Customer: {$customerName}, Email: {$customerEmail}");
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to delete contact inquiry: ' . $e->getMessage());
            
            return redirect()->route('admin.contact-inquiries.index')->with('error', 'Failed to delete contact inquiry. Please try again.');
        }
    }
}
