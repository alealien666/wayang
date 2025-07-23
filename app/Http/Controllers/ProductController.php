<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $validate = $request->validate([
            'product_name' => 'required|string',
            'product_price' => 'required|numeric',
            'promo' => 'nullable|numeric',
            'short_description' => 'required|string',
            'full_description' => 'required|string',
            'product_status' => 'nullable|string',
            'marketplaces' => 'nullable|array',
            'marketplaces.*.name' => 'nullable|string',
            'marketplaces.*.link' => 'nullable|url',
            'special_order_link' => 'nullable|string',
            'whatsapp_number' => 'nullable|string',
            'special_payment_method' => 'nullable|array',
            'special_payment_method.*' => 'nullable|string',
            'product_photo' => 'required|array',
            'product_photo.*' => 'required|string|url',
        ]);

        try {
            $data = $validate;

            $data['marketplaces'] = $request->input('marketplaces');
            $data['special_payment_method'] = $request->input('special_payment_method');
            $data['product_photo'] = $request->input('product_photo');

            $html = '
            <div class="gambar-produk">
                <div class="gambar-slide">';

            foreach ($data['product_photo'] as $index => $photo) {
                $html .= '<img alt="Gambar Produk ' . ($index + 1) . '" src="' . $photo . '"/>';
            }

            $html .= '
                </div>
                <div class="status-produk">
                    <div class="info-produk">' . ($data['product_status'] ?? '') . '</div>
                </div>
            </div>
            
            <div class="detail-produk">
                <div class="harga-produk">';

            if (!empty($data['promo'])) {
                $html .= '<s>Rp ' . number_format($data['product_price'], 0, ',', '.') . '</s> Rp ' . number_format($data['promo'], 0, ',', '.');
            } else {
                $html .= 'Rp ' . number_format($data['product_price'], 0, ',', '.');
            }

            $html .= '</div>
            </div>
            
            <div class="deskripsi-produk">' . $data['short_description'] . '</div>
            
            <div class="deskripsi-produk-panjang">' . $data['full_description'] . '</div>
            
            <meta content="' . $data['product_price'] . '" itemprop="price"/>
            
            <div class="link-marketplace">';
            $marketClassMap = [
                'Tokopedia' => 'link-tokopedia',
                'Shopee' => 'link-shopee',
                'Bukalapak' => 'link-bukalapak',
                'Blibli' => 'link-blibli',
                'Lazada' => 'link-lazada',
            ];
            if (!empty($data['marketplaces'])) {
                foreach ($data['marketplaces'] as $market) {
                    $name = $market['name'] ?? 'Marketplace';
                    $link = $market['link'] ?? '#';
                    $class = $marketClassMap[$name] ?? 'link-market';
                    $html .= '<a rel="nofollow" target="_blank" class="' . $class . '" href="' . $link . '">' . $name . '</a>';
                }
            }
            $html .= '</div>
            
            <script>';
            if (!empty($data['special_payment_method'])) {
                $html .= 'themeSetting.rekbank = [';
                foreach ($data['special_payment_method'] as $method) {
                    $html .= '"' . addslashes($method) . '",';
                }
                $html .= '];';
            }
            if (!empty($data['special_order_link'])) {
                $html .= "themeSetting.checkoutLinkUrl = '" . $data['special_order_link'] . "';";
            }
            if (!empty($data['whatsapp_number'])) {
                $html .= "themeSetting.nomorWa = '" . $data['whatsapp_number'] . "';";
            }
            $html .= '</script>';


            $data['response_output'] = $html;

            Product::create($data);
            return response($html, 200)
                ->header('Content-Type', 'text/html');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
