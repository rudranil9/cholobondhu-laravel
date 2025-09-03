<?php

namespace Modules\Booking\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'tour_package_id' => ['nullable', 'exists:tour_packages,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:15'],
            'destination' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date', 'after:today'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'number_of_travelers' => ['required', 'integer', 'min:1', 'max:50'],
            'budget_range' => ['nullable', 'string', 'max:100'],
            'special_requirements' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'customer_name.required' => 'Full name is required.',
            'customer_email.required' => 'Email address is required.',
            'customer_email.email' => 'Please enter a valid email address.',
            'customer_phone.required' => 'Phone number is required.',
            'destination.required' => 'Destination is required.',
            'start_date.required' => 'Start date is required.',
            'start_date.after' => 'Start date must be after today.',
            'end_date.after' => 'End date must be after start date.',
            'number_of_travelers.required' => 'Number of travelers is required.',
            'number_of_travelers.min' => 'At least 1 traveler is required.',
            'number_of_travelers.max' => 'Maximum 50 travelers allowed.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (auth()->check()) {
            $user = auth()->user();
            $this->merge([
                'customer_name' => $this->customer_name ?: $user->name,
                'customer_email' => $this->customer_email ?: $user->email,
                'customer_phone' => $this->customer_phone ?: $user->phone,
            ]);
        }
    }
}
