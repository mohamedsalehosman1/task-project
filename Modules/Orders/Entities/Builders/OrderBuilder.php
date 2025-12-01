<?php

namespace Modules\Orders\Entities\Builders;


use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Carts\Entities\CartItem;
use Modules\Orders\Entities\Order;
use Modules\Orders\Entities\OrderTax;
use Modules\Orders\Entities\OrderVendor;
use Modules\Orders\Entities\OrderVendorItem;
use Modules\Products\Entities\ProductVariance;
use Modules\Taxes\Entities\Tax;

class OrderBuilder
{
    protected $user;
    protected $cartItems;
    protected $order;
    protected $subtotal;
    protected $tax;
    protected $total;

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function setCartItems($productIds)
    {
        $this->cartItems = CartItem::where('cart_id', $this->user->cart->id)
                                    ->where('product_id', $productIds)
                                    ->get();

        if ($this->cartItems->isEmpty()) {
            throw new Exception('Selected items are not in your cart.');
        }

        return $this;
    }

    public function calculateTotals()
    {
        $this->subtotal = $this->cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $activeTaxes = Tax::active()->get();
        $this->tax = $activeTaxes->sum(fn($tax) => $this->subtotal * ($tax->percentage / 100));
        $this->total = $this->subtotal + $this->tax;
        return $this;
    }

    public function buildOrder($data)
    {
        $this->order = Order::create([
            'user_id'    => $this->user->id,
            // 'address_id' => $['address_id'],
            'subtotal'   => $this->subtotal,
            'tax'        => 10,
            'total'      => $this->total,
        ]);

        return $this;
    }

    public function attachTaxes()
    {
        $activeTaxes = Tax::active()->get();

        foreach ($activeTaxes as $tax) {
            OrderTax::create([
                'order_id'   => $this->order->id,
                'tax_id'     => $tax->id,
                'percentage' => $tax->percentage,
                'total'      => $this->subtotal * ($tax->percentage / 100),
            ]);
        }

        return $this;
    }

    public function attachVendorsAndItems()
    {
        $activeTaxes = Tax::active()->get();
        $vendorItems = $this->cartItems->groupBy(fn($item) => $item->product->vendor_id);

        $orderVendors = [];
        foreach ($vendorItems as $vendorId => $items) {
            $vendorSubtotal = $items->sum(fn($item) => $item->product->price * $item->quantity);
            $vendorTaxAmount = $activeTaxes->sum(fn($tax) => $vendorSubtotal * ($tax->percentage / 100));
            $vendorTotal = $vendorSubtotal + $vendorTaxAmount;

            $orderVendors[] = [
                'order_id'  => $this->order->id,
                'vendor_id' => $vendorId,
                'subtotal'  => $vendorSubtotal,
                'tax'       => $vendorTaxAmount,
                'total'     => $vendorTotal,
            ];
        }

        OrderVendor::insert($orderVendors);
        $insertedVendors = OrderVendor::where('order_id', $this->order->id)->get()->keyBy('vendor_id');

        $orderVendorItems = [];
        foreach ($this->cartItems as $item) {
            $vendorId = $item->product->vendor_id;
            // $item->product->increment('count_of_sold', $item->quantity);
            $item->product->decrement('max_amount', $item->quantity);

            $orderVendorItems[] = [
                'order_id'            => $this->order->id,
                'order_vendor_id'     => $insertedVendors[$vendorId]->id,
                'product_id'          => $item->product->id,

                'quantity'            => $item->quantity,
                'price'               => $item->product->price,
            ];
        }

        OrderVendorItem::insert($orderVendorItems);
        return $this;
    }

    public function build()
    {
        // $this->cartItems->each->delete();
        return $this->order;
    }
}
