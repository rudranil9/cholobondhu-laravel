<?php

namespace Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Show the booking page with auto-fill data
     */
    public function booking(Request $request)
    {
        // Extract auto-fill data from URL parameters
        $autoFillData = [
            'package_name' => $request->get('package_name'),
            'destination' => $request->get('destination'),
            'price' => $request->get('price'),
            'duration' => $request->get('duration'),
            'package_type' => $request->get('package_type'),
        ];

        // Filter out null/empty values
        $autoFillData = array_filter($autoFillData, function($value) {
            return !is_null($value) && $value !== '';
        });

        return view('booking::create', compact('autoFillData'));
    }

    /**
     * Handle contact page with auto-fill data
     */
    public function contact(Request $request)
    {
        // Extract auto-fill data from URL parameters
        $autoFillData = [
            'package' => $request->get('package'),
            'location' => $request->get('location'),
            'price' => $request->get('price'),
            'duration' => $request->get('duration'),
            'request_type' => $request->get('request'),
        ];

        // Filter out null/empty values
        $autoFillData = array_filter($autoFillData, function($value) {
            return !is_null($value) && $value !== '';
        });

        return view('contact', compact('autoFillData'));
    }

    /**
     * Handle login redirect with intended booking
     */
    public function loginRedirect(Request $request)
    {
        // Check if there's an intended booking in session
        if ($request->session()->has('intended_booking')) {
            $bookingData = $request->session()->get('intended_booking');
            $request->session()->forget('intended_booking');
            
            // Redirect to booking page with the intended package data
            $params = http_build_query([
                'package_name' => $bookingData['name'] ?? '',
                'destination' => $bookingData['location'] ?? '',
                'price' => $bookingData['price'] ?? '',
                'duration' => $bookingData['duration'] ?? '',
                'package_type' => $bookingData['package_type'] ?? 'tour'
            ]);
            
            return redirect('/booking?' . $params);
        }
        
        // Default redirect after login
        return redirect()->intended('/');
    }
}
