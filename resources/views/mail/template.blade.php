<h1>Konfirmasi Pemesanan</h1>
<p>Terima kasih telah melakukan pemesanan!</p>

<h3>Detail Pemesanan</h3>
<ul>
    <li><strong>Tanggal Pemesanan:</strong> {{ $order->date_buy }}</li>
    <li><strong>Status:</strong> {{ ucfirst($order->status) }}</li>
    <li><strong>Total Bayar:</strong> Rp{{ number_format($order->total_amount, 0, ',', '.') }}</li>
</ul>

<h3>Item Pesanan</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Nama Lapangan</th>
            <th>Harga</th>
            <th>Tanggal Booking</th>
            <th>Jam</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order_items as $item)
            <tr>
                <td>{{ $item->field->name }}</td>
                <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                <td>{{ $item->day->name }}</td>
                <td>{{ $item->schedule->start . "-" . $item->schedule->end}}</td>
                <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
