<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    /**
    *Kolom yang boleh diisi secara massal.
        *Sesuaikan dengan field di migrasi tadi.
     */
    protected $fillable = [
        'name',
        'sku',
        'description',
        'price',
        'stock',
        'image',
        'is_active',
        'is_featured',
    ];

    /**
     * Casting tipe data (Opsional tapi disarankan)
     * Agar laravel otomatis mengubah string dari db menjadi tipe data yang benar.
     */

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'integer',
        'stock' => 'integer',
    ];
}