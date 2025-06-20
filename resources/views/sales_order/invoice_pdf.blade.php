<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #eee; }
        .text-end { text-align: right; }
        .header { margin-bottom: 10px; }
    </style>
</head>
<body>

    <h2>Sales Invoice</h2>

    <div class="header">
        <strong>Invoice #: </strong>INV-{{ $order->id }}<br>
        <strong>Customer:</strong> {{ $order->customer_name }}<br>
        <strong>Date:</strong> {{ $order->created_at->format('d M, Y') }}<br>
        <strong>Status:</strong> {{ $order->is_confirmed ? 'Confirmed' : 'Pending' }}
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>SKU</th>
                <th class="text-end">Price</th>
                <th class="text-end">Qty</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->product->sku }}</td>
                    <td class="text-end">Rs. {{ number_format($item->price, 2) }}</td>
                    <td class="text-end">{{ $item->quantity }}</td>
                    <td class="text-end">Rs. {{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-end"><strong>Total</strong></td>
                <td class="text-end"><strong>Rs. {{ number_format($order->total, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
