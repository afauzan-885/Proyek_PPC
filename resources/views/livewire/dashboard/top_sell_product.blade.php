<div>
    <div class="card-header text-center border-0">
        <h5 class="card-title">Top Penjualan Produk</h5>
    </div>
    <div style="max-height: 360px; overflow-y: auto;">
        <table class="table">
            <thead style="position: sticky; top: 0; background-color: #fff;">
                <tr>
                    <th>Rank</th>
                    <th>Kode Barang</th>
                    <th>Total Pesanan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topProducts as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->kode_barang }}</td>
                        <td>{{ number_format(intval($product->total_pesanan), 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
