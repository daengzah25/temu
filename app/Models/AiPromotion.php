<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiPromotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'product_id',
        'platform',
        'prompt',
        'result',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
