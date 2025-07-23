<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $product_name }}</title>
</head>

<body>
    <h1>{{ $product_name }}</h1>

    <p>Harga: Rp{{ number_format($product_price, 0, ',', '.') }}</p>

    @if (!empty($promo))
        <p>Harga Promo: Rp{{ number_format($promo, 0, ',', '.') }}</p>
    @endif

    <p>Status: {{ $product_status ?? '-' }}</p>

    <h3>Deskripsi Singkat</h3>
    <p>{{ $short_description }}</p>

    <h3>Deskripsi Lengkap</h3>
    <p>{{ $full_description }}</p>

    @if (!empty($marketplaces))
        <h3>Marketplace</h3>
        <ul>
            @foreach ($marketplaces as $market)
                <li>{{ $market['name'] ?? '-' }} - <a
                        href="{{ $market['link'] ?? '#' }}">{{ $market['link'] ?? 'Link tidak tersedia' }}</a></li>
            @endforeach
        </ul>
    @endif

    @if (!empty($special_payment_method))
        <h3>Metode Pembayaran Khusus</h3>
        <ul>
            @foreach ($special_payment_method as $method)
                <li>{{ $method }}</li>
            @endforeach
        </ul>
    @endif

    @if (!empty($product_photo))
        <h3>Foto Produk</h3>
        <ul>
            @foreach ($product_photo as $photo)
                <li><img src="{{ $photo }}" alt="Foto Produk" width="150"></li>
            @endforeach
        </ul>
    @endif

    @if (!empty($special_order_link))
        <p>Link Pesan Langsung: <a href="{{ $special_order_link }}">{{ $special_order_link }}</a></p>
    @endif

    @if (!empty($whatsapp_number))
        <p>Nomor WhatsApp: <a href="https://wa.me/{{ $whatsapp_number }}">{{ $whatsapp_number }}</a></p>
    @endif
</body>

</html>
