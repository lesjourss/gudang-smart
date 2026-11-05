<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBarangRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kode_barang' => ['required', 'string', 'max:10', 'unique:barang,kode_barang'],
            'nama_barang' => ['required', 'string', 'min:3', 'max:255'],
            'kategori_id' => ['required', 'exists:kategori_barang,id'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'stok' => ['required', 'numeric', 'min:0'],
            'harga_satuan' => ['required', 'numeric', 'min:0'],
        ];
    }

    /**
     * Pesan validasi kustom dalam Bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'kode_barang.required' => 'Kode barang wajib diisi.',
            'kode_barang.unique' => 'Kode barang sudah terdaftar, gunakan kode lain.',
            'kode_barang.max' => 'Kode barang tidak boleh lebih dari 10 karakter.',
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'nama_barang.min' => 'Nama barang minimal 3 karakter.',
            'kategori_id.required' => 'Kategori barang wajib dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'supplier_id.required' => 'Supplier wajib dipilih.',
            'supplier_id.exists' => 'Supplier yang dipilih tidak valid.',
            'stok.required' => 'Jumlah stok wajib diisi.',
            'stok.numeric' => 'Stok harus berupa angka numerik.',
            'stok.min' => 'Stok tidak boleh bernilai negatif (minimal 0).',
            'harga_satuan.required' => 'Harga satuan wajib diisi.',
            'harga_satuan.numeric' => 'Harga satuan harus berupa angka numerik.',
            'harga_satuan.min' => 'Harga satuan tidak boleh negatif.',
        ];
    }
}

