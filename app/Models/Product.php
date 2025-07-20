<?php

namespace App\Models;

use App\Services\CurrencyService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price', 'is_admin'];


    public function getPriceEurAttribute()
    {
        return (new CurrencyService())->convert($this->price, 'usd', 'eur');
    }
}
