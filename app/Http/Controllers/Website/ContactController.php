<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Services\EmailService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Handle contact form submission.
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Prepare data for email
        $emailData = [
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ];

        // Send email
        $result = $this->emailService->sendContactFormEmail($emailData);

        if ($result['success']) {
            return redirect()->route('contact')
                ->with('success', 'Thank you for contacting us! We will get back to you shortly.');
        }

        return redirect()->route('contact')
            ->with('error', 'Sorry, there was an issue sending your message. Please try again later or contact us directly by phone.')
            ->withInput();
    }
}
