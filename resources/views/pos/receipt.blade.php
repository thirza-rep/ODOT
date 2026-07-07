<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $order->invoice_number }}</title>
    <style>
        /* CSS reset & base settings for thermal print */
        @page { margin: 0; }
        body {
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 10px;
            color: #000;
            background: #fff;
            font-size: 12px;
            line-height: 1.2;
            width: 58mm; /* Default to 58mm */
            margin: 0 auto;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-4 { margin-bottom: 16px; }
        .mt-2 { margin-top: 8px; }
        
        .divider {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        table { width: 100%; border-collapse: collapse; }
        td { vertical-align: top; padding: 2px 0; }
        
        .item-name { padding-bottom: 2px; }

        @media print {
            body { width: 100%; padding: 0; margin-left: 2px; }
            .no-print { display: none; }
        }

        /* Basic Action Bar for Web View */
        .action-bar {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            background: #f8fafc;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            border: 1px solid #e2e8f0;
            font-family: system-ui, -apple-system, sans-serif;
        }
        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
        }
        .btn-primary { background: #4F7DF3; color: white; }
        .btn-primary:hover { background: #3d63d2; }
        .btn-secondary { background: #e2e8f0; color: #334155; }
        .btn-secondary:hover { background: #cbd5e1; }
    </style>
</head>
<body>
    <div class="action-bar no-print">
        <button onclick="window.print()" class="btn btn-primary">Cetak Struk (Thermal)</button>
        <a href="{{ route('pos.index') }}" class="btn btn-secondary">Kembali ke POS</a>
    </div>

    <!-- Receipt Content -->
    <div class="receipt">
        <div class="text-center mb-4">
            <h2 style="margin: 0; font-size: 16px;">ODOT ERP</h2>
            @if($order->branch)
                <div>{{ $order->branch->name }}</div>
                <div>{{ $order->branch->address }}</div>
            @endif
        </div>

        <div class="mb-2">
            <div>No  : {{ $order->invoice_number }}</div>
            <div>Tgl : {{ $order->created_at->format('d/m/Y H:i') }}</div>
            <div>Opr : {{ $order->user->name }}</div>
        </div>

        <div class="divider"></div>

        <table>
            @foreach($order->items as $item)
                <tr>
                    <td colspan="3" class="item-name">{{ $item->product_name }}</td>
                </tr>
                <tr>
                    <td style="width: 25%">{{ $item->quantity }}x</td>
                    <td style="width: 35%">{{ number_format($item->sell_price * 1000, 0, ',', '.') }}</td>
                    <td class="text-right" style="width: 40%">{{ $item->formatted_subtotal }}</td>
                </tr>
            @endforeach
        </table>

        <div class="divider"></div>

        <table>
            <tr>
                <td class="font-bold">Total</td>
                <td class="text-right font-bold">{{ $order->formatted_total }}</td>
            </tr>
            <tr>
                <td>Tunai</td>
                <td class="text-right">{{ $order->formatted_amount_paid }}</td>
            </tr>
            <tr>
                <td>Kembali</td>
                <td class="text-right">{{ $order->formatted_change_amount }}</td>
            </tr>
        </table>

        <div class="divider"></div>
        
        <div class="text-center mt-2 mb-4">
            <p style="margin: 0;">Terima Kasih</p>
            <p style="margin: 0;">Barang yang sudah dibeli</p>
            <p style="margin: 0;">tidak dapat ditukar/dikembalikan</p>
        </div>
    </div>

    <script>
        // Auto print prompt when opened
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>
