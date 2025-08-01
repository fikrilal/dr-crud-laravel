<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDrugRequest extends FormRequest
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
        $drugId = $this->route('drug')->kd_obat;

        return [
            'nama_obat' => [
                'required',
                'string',
                'max:255',
                Rule::unique('drugs', 'nm_obat')->ignore($drugId, 'kd_obat')
            ],
            'kategori' => 'required|string|max:100',
            'bentuk_obat' => 'required|string|max:50',
            'harga_beli' => 'required|numeric|min:0|max:999999999.99',
            'harga_jual' => 'required|numeric|min:0|max:999999999.99|gt:harga_beli',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0|lte:stok',
            'tanggal_kadaluarsa' => 'nullable|date|after_or_equal:today',
            'deskripsi' => 'nullable|string|max:1000',
            'efek_samping' => 'nullable|string|max:1000',
            'kontraindikasi' => 'nullable|string|max:1000',
            'dosis_dewasa' => 'nullable|string|max:255',
            'dosis_anak' => 'nullable|string|max:255',
            'supplier_id' => 'required|exists:suppliers,kd_supplier',
            'status' => 'required|in:active,inactive',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nama_obat.unique' => 'A drug with this name already exists.',
            'harga_jual.gt' => 'Selling price must be greater than buying price.',
            'stok_minimum.lte' => 'Minimum stock cannot be greater than current stock.',
            'tanggal_kadaluarsa.after' => 'Expiry date must be in the future.',
            'supplier_id.exists' => 'Selected supplier does not exist.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nama_obat' => 'drug name',
            'kategori' => 'category',
            'bentuk_obat' => 'drug form',
            'harga_beli' => 'buying price',
            'harga_jual' => 'selling price',
            'stok' => 'stock',
            'stok_minimum' => 'minimum stock',
            'tanggal_kadaluarsa' => 'expiry date',
            'supplier_id' => 'supplier',
        ];
    }
}
