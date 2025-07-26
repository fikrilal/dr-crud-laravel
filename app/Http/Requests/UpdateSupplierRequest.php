<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends FormRequest
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
        $supplierId = $this->route('supplier')->kd_supplier;

        return [
            'nama_supplier' => [
                'required',
                'string',
                'max:255',
                Rule::unique('suppliers', 'nm_supplier')->ignore($supplierId, 'kd_supplier')
            ],
            'alamat' => 'required|string|max:500',
            'kota' => 'required|string|max:100',
            'nomor_telepon' => [
                'required',
                'string',
                'max:20',
                Rule::unique('suppliers', 'telpon')->ignore($supplierId, 'kd_supplier')
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('suppliers', 'email')->ignore($supplierId, 'kd_supplier')
            ],
            'contact_person' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nama_supplier.required' => 'Supplier name is required.',
            'nama_supplier.unique' => 'A supplier with this name already exists.',
            'nomor_telepon.unique' => 'A supplier with this phone number already exists.',
            'email.unique' => 'A supplier with this email already exists.',
            'email.email' => 'Please enter a valid email address.',
            'alamat.required' => 'Supplier address is required.',
            'kota.required' => 'City is required.',
            'contact_person.required' => 'Contact person is required.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be either active or inactive.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nama_supplier' => 'supplier name',
            'nomor_telepon' => 'phone number',
            'contact_person' => 'contact person',
        ];
    }
}
