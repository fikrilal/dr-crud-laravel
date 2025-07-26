<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
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
            'kd_supplier' => 'required|exists:suppliers,kd_supplier',
            'tgl_nota' => 'required|date',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.drug_id' => 'required|exists:drugs,kd_obat',
            'items.*.jumlah' => 'required|integer|min:1|max:10000',
            'items.*.harga_satuan' => 'required|numeric|min:0.01|max:999999.99',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'kd_supplier.required' => 'Supplier selection is required.',
            'kd_supplier.exists' => 'Selected supplier does not exist.',
            'tgl_nota.required' => 'Purchase date is required.',
            'tgl_nota.date' => 'Purchase date must be a valid date.',
            'items.required' => 'At least one item must be added to the purchase.',
            'items.min' => 'Purchase order cannot be empty.',
            'items.*.drug_id.required' => 'Drug selection is required for each item.',
            'items.*.drug_id.exists' => 'One or more selected drugs do not exist.',
            'items.*.jumlah.required' => 'Quantity is required for each item.',
            'items.*.jumlah.min' => 'Quantity must be at least 1.',
            'items.*.jumlah.max' => 'Quantity cannot exceed 10,000 per item.',
            'items.*.harga_satuan.required' => 'Unit price is required for each item.',
            'items.*.harga_satuan.min' => 'Unit price must be greater than 0.',
            'items.*.harga_satuan.max' => 'Unit price cannot exceed 999,999.99.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'kd_supplier' => 'supplier',
            'tgl_nota' => 'purchase date',
            'items.*.drug_id' => 'drug',
            'items.*.jumlah' => 'quantity',
            'items.*.harga_satuan' => 'unit price',
        ];
    }
}
