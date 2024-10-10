<div>
    <div class="card-header text-center border-0">
        <h5 class="card-title">Permintaan Produk</h5>
    </div>
    <div style="max-height: 360px; overflow-y: auto;">
        <table class="table">
            <thead style="position: sticky; top: 0; background-color: #fff;">
                <tr>
                    <th>Rank</th>
                    <th>Kode Barang</th>
                    <th>Total Pesanan</th>
                    <th>Status</th>
                    <th>No. PO</th>
                    <th>Kode Customer</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
                @foreach ($topProducts as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->kode_barang }}</td>
                        <td>
                            {{ number_format(intval($product->total_pesanan), 0, ',', '.') }}
                            /
                            {{ number_format(intval($product->stok_material), 0, ',', '.') }}
                        </td>
                        <td>
                            @if ($product->stok_material == 0)
                                <span class="text-danger">Stok Tidak Ada</span>
                            @elseif ($product->stok_material < $product->total_pesanan)
                                <span class="text-warning">Stok Terisi
                                    {{ round(($product->stok_material / $product->total_pesanan) * 100) }}%</span>
                            @else
                                <span class="text-success">Surplus
                                    {{ round((($product->stok_material - $product->total_pesanan) / $product->total_pesanan) * 100) }}%</span>
                            @endif
                        </td>
                        <td>{{ $product->no_po }}</td>
                        <td>{{ $product->kode_customer }}</td>
                    </tr>
                @endforeach
            </tbody>
            </tbody>
        </table>
    </div>
</div>
