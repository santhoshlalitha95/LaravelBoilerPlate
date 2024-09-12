<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'stock_no',
        'var',
        'amount',
        'mrp_amount',
        'product_description',
        'category',
        'sub_category',
        'material_type',
        'finish',
        'tool_size',
        'minimum_order_quantity',
    ];

    protected static function booted(): void
    {
        static::saved(function ($product) {
            app('Elasticsearch')->index([
                'index' => 'products',
                'id' => $product->id,
                'body' => $product->toArray(),
            ]);
        });
        static::deleted(function ($product) {
            app('Elasticsearch')->delete([
                'index' => 'products',
                'id' => $product->id,
            ]);
        });
    }

    public function toArray()
    {
        return [
            'name' => $this->product_id,
            'description' => $this->product_description,
            'price' => $this->amount,
        ];
    }
}
