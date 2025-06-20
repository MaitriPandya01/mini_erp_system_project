<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesOrderController extends Controller
{
    public function index()
    {
        $orders = SalesOrder::all();
        return view('sales_order.index',compact('orders'));
    }

    public function create()
    {
        $products = Product::all();
        return view('sales_order.add_order',compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'is_confirmed' => 'required',
        ]);

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
                return redirect()->route('orders.index')->with('success', 'Sales order confirmed!');
            else
                return redirect()->route('orders.index')->with('success', 'Sales order saved successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function invoice($id)
    {
        $order = SalesOrder::with('items.product')->findOrFail($id);
        return view('sales_order.view_invoice', compact('order'));
    }

    public function downloadPdf($id)
    {
        $order = SalesOrder::with('items.product')->findOrFail($id);
        $pdf = Pdf::loadView('sales_order.invoice_pdf', compact('order'));

        return $pdf->download('invoice_'.$order->id.'.pdf');
    }

    public function confirmation($id)
    {
        DB::beginTransaction();

        try {
            $order = SalesOrder::with('items')->where('id',$id)->first();

            $order_data = !empty($order)?$order->toArray():[];
            $total = 0;

            foreach ($order_data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->quantity < $item['quantity']) {
                    throw new \Exception("Not enough stock for {$product->name}");
                }

                $total += $item['subtotal'];

                // Reduce inventory if order is confirmed
                $product->decrement('quantity', $item['quantity']);
            }

            // Reduce inventory if order is confirmed
            $order->update(['total' => $total,'is_confirmed' => 1]);

            DB::commit();

            return response()->json(['message' => 'Sales order is confirmed!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(SalesOrder $order)
    {
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }

}
