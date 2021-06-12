<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Cart extends Model
{
    protected $table = 'carts';

    protected $fillable = [
        'count',
        'total'
    ];

    /**
     * Подсчитывает сумму заказа.
     */
    public function calculate()
    {
        $items = CartItem::query()
            ->where(['cartId' => $this->id])
            ->get();

        $total = 0;
        $count = 0;

        foreach ($items as $item) {
            $product = Product::query()
                ->where(['id' => $item->productId])
                ->first();

            $count += $item->count;
            $total += $item->count * (double)$product->price;
        }

        $this->count = $count;
        $this->total = $total;
        $this->save();
    }

    public function toArray()
    {
        return [
            'count' => $this->count,
            'total' => $this->total,
        ];
    }

    public function add_sum()
    {

    }
}
