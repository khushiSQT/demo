<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    use HasFactory;
    protected $fillable = [
        'fname',
        'lname',
        'detail',
        'created_at',
        'updated_at'

    ];

    public function product_data()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
