<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->user_type, ['admin', 'pharmacist']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'nullable|exists:customers,id',
            'metode_pembayaran' => 'required|in:cash,credit_card,debit_card,transfer,insurance',
            'items' => 'required|array|min:1',
            'items.*.drug_id' => 'required|exists:drugs,id',
            'items.*.jumlah' => 'required|integer|min:1|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'customer_id.exists' => 'Selected customer does not exist.',
            'metode_pembayaran.required' => 'Payment method is required.',
            'metode_pembayaran.in' => 'Invalid payment method selected.',
            'items.required' => 'At least one item must be added to the cart.',
            'items.min' => 'Cart cannot be empty.',
            'items.*.drug_id.required' => 'Drug selection is required for each item.',
            'items.*.drug_id.exists' => 'One or more selected drugs do not exist.',
            'items.*.jumlah.required' => 'Quantity is required for each item.',
            'items.*.jumlah.min' => 'Quantity must be at least 1.',
            'items.*.jumlah.max' => 'Quantity cannot exceed 1000 per item.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'customer_id' => 'customer',
            'metode_pembayaran' => 'payment method',
            'items.*.drug_id' => 'drug',
            'items.*.jumlah' => 'quantity',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Additional validation for stock availability
            if ($this->has('items')) {
                foreach ($this->items as $index => $item) {
                    if (isset($item['drug_id']) && isset($item['jumlah'])) {
                        $drug = \App\Models\Drug::find($item['drug_id']);
                        if ($drug) {
                            if ($drug->status !== 'active') {
                                $validator->errors()->add("items.{$index}.drug_id", "Drug {$drug->nama_obat} is not active.");
                            }
                            if ($drug->stok < $item['jumlah']) {
                                $validator->errors()->add("items.{$index}.jumlah", "Insufficient stock for {$drug->nama_obat}. Available: {$drug->stok}");
                            }
                            if ($drug->stok <= 0) {
                                $validator->errors()->add("items.{$index}.drug_id", "Drug {$drug->nama_obat} is out of stock.");
                            }
                        }
                    }
                }
            }
        });
    }
}
