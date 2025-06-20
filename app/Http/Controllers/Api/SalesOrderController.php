<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SalesOrderController extends Controller
{
    public function getSalesOrder($id)
    {
        $data = SalesOrder::with('items.product:id')->where('id',$id)->get();

        return response()->json([
            'success' => true,
            'order' => $data??'Order not available for this id.',
        ]);
    }

    public function storeSalesOrder(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'is_confirmed' => 'required',
        ]);

        // dd($data);

        $total = 0;

        DB::beginTransaction();

        try {
            $order = SalesOrder::create([
                'customer_name' => $data['customer_name'],
                'total' => 0,
                'is_confirmed' => $data['is_confirmed'],
            ]);

            foreach ($data['products'] as $item) {
                $product = Product::findOrFail($item['id']);

                if ($product->quantity < $item['quantity']) {
                    throw new \Exception("Not enough stock for {$product->name}");
                }

                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;

                SalesOrderItem::create([
                    'sales_order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                // Reduce inventory if order is confirmed
                if($data['is_confirmed'] == 1)
                    $product->decrement('quantity', $item['quantity']);
            }

            // Reduce inventory if order is confirmed
            if($data['is_confirmed'] == 1)
                $order->update(['total' => $total]);

            DB::commit();

            if($data['is_confirmed'] == 1)
                return response()->json([ 'success' => true, 'Sales order is save and confirmed.']);
            else
                return response()->json([ 'success' => true, 'Sales order is saved.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
