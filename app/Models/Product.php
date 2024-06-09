<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Product extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
    ];

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }
}
