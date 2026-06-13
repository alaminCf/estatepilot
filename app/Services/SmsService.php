<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected string $apiUrl = 'https://sms.lpeek.com/API/sendSMS';
    protected string $acode = '30000108';
    protected string $apiKey = 'c3978f19b6ce9189f003d24ae4b3662aa544caf3acc87bdc9e7c43d97d0c49f6';
    protected string $masking = 'LONDNABASON';

    /**
     * Send SMS to a phone number
     *
     * @param string $phone Phone number (with or without country code)
     * @param string $message SMS message content
     * @param string $transactionType 'T' for transactional, 'C' for OTP code
     * @param string|null $requestId Custom request ID (auto-generated if null)
     * @return array
     */
    public function send(string $phone, string $message, string $transactionType = 'T', ?string $requestId = null): array
    {
        // Format phone number (ensure it starts with 88)
        $phone = $this->formatPhoneNumber($phone);
        
        // Generate request ID if not provided
        $requestId = $requestId ?? $this->generateRequestId();

        $payload = [
            'auth' => [
                'acode' => $this->acode,
                'apiKey' => $this->apiKey,
            ],
            'smsInfo' => [
                'requestID' => $requestId,
                'message' => $message,
                'is_unicode' => 0,
                'masking' => $this->masking,
                'msisdn' => $phone,
                'transactionType' => $transactionType,
                'contentID' => '',
            ],
        ];

        try {
            // Log the payload being sent
            Log::channel('daily')->info('SMS Payload', [
                'payload' => $payload,
                'json' => json_encode($payload),
            ]);
            
            $response = Http::timeout(30)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->withoutVerifying() // Bypass SSL verification
                ->post($this->apiUrl, $payload);
            
            $result = [
                'success' => $response->successful(),
                'status_code' => $response->status(),
                'response' => $response->json() ?? $response->body(),
                'request_id' => $requestId,
            ];

            Log::channel('daily')->info('SMS Response', [
                'phone' => $phone,
                'message' => $message,
                'result' => $result,
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::channel('daily')->error('SMS Send Failed', [
                'phone' => $phone,
                'message' => $message,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'request_id' => $requestId,
            ];
        }
    }

    /**
     * Send OTP verification code
     *
     * @param string $phone
     * @param string $code
     * @param string $email
     * @return array
     */
    public function sendOtp(string $phone, string $code, string $email = ''): array
    {
        $message = "Welcome London Abason Ltd. Your verification code is {$code} for user email: {$email}";
        return $this->send($phone, $message, 'T');
    }

    /**
     * Send password reset OTP
     *
     * @param string $phone
     * @param string $code
     * @return array
     */
    public function sendPasswordResetOtp(string $phone, string $code): array
    {
        $message = "Your password reset code is {$code}";
        return $this->send($phone, $message, 'T');
    }

    /**
     * Send booking approval notification
     *
     * @param string $phone
     * @param string $bookingId
     * @param string $plotNo
     * @return array
     */
    public function sendBookingApproval(string $phone, string $bookingId, string $plotNo): array
    {
        $message = "Congratulations! Your booking ID #{$bookingId} for plot {$plotNo} has been approved. Thank you for choosing London Abason Ltd.";
        return $this->send($phone, $message, 'T');
    }

    /**
     * Send payment confirmation
     *
     * @param string $phone
     * @param string $amount
     * @param string $plotNo
     * @return array
     */
    public function sendPaymentConfirmation(string $phone, string $amount, string $plotNo): array
    {
        $message = "Received payment Tk. {$amount} against booking of Plot #{$plotNo}, Thank you.";
        return $this->send($phone, $message, 'T');
    }

    /**
     * Format phone number to include country code
     *
     * @param string $phone
     * @return string
     */
    protected function formatPhoneNumber(string $phone): string
    {
        // Remove any spaces, dashes, or special characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If starts with 01, add 88
        if (str_starts_with($phone, '01') && strlen($phone) === 11) {
            return '88' . $phone;
        }
        
        // If already has country code
        if (str_starts_with($phone, '88') && strlen($phone) === 13) {
            return $phone;
        }
        
        return $phone;
    }

    /**
     * Generate unique request ID
     *
     * @return string
     */
    protected function generateRequestId(): string
    {
        return 'REQ' . time() . rand(1000, 9999);
    }

    /**
     * Generate OTP code
     *
     * @param int $length
     * @return string
     */
    public static function generateOtpCode(int $length = 4): string
    {
        return str_pad(rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    }
}
