<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];

        // Add customer-specific validation if user is a customer
        if ($this->user()->isCustomer() && $this->has('customer_info')) {
            $rules['customer_info.nm_pelanggan'] = ['required', 'string', 'max:100'];
            $rules['customer_info.alamat'] = ['required', 'string', 'max:255'];
            $rules['customer_info.kota'] = ['required', 'string', 'max:50'];
            $rules['customer_info.telpon'] = ['required', 'string', 'max:20'];
            $rules['customer_info.email'] = ['nullable', 'email', 'max:100'];
            $rules['customer_info.tanggal_lahir'] = ['nullable', 'date', 'before:today'];
            $rules['customer_info.jenis_kelamin'] = ['nullable', 'in:L,P'];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already taken.',
            'customer_info.nm_pelanggan.required' => 'Customer name is required.',
            'customer_info.alamat.required' => 'Address is required.',
            'customer_info.kota.required' => 'City is required.',
            'customer_info.telpon.required' => 'Phone number is required.',
            'customer_info.email.email' => 'Please enter a valid customer email address.',
            'customer_info.tanggal_lahir.date' => 'Please enter a valid birth date.',
            'customer_info.tanggal_lahir.before' => 'Birth date must be in the past.',
            'customer_info.jenis_kelamin.in' => 'Please select a valid gender.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'customer_info.nm_pelanggan' => 'customer name',
            'customer_info.alamat' => 'address',
            'customer_info.kota' => 'city',
            'customer_info.telpon' => 'phone number',
            'customer_info.email' => 'customer email',
            'customer_info.tanggal_lahir' => 'birth date',
            'customer_info.jenis_kelamin' => 'gender',
        ];
    }
}
