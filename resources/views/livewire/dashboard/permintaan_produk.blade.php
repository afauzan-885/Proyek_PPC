<div>
    <div class="card-header text-center border-0">
        <h5 class="card-title">Jadwal Pengiriman Produk</h5>
    </div>
    <div style="max-height: 355px; overflow-y: auto;">
        <table class="table">
            <thead style="position: sticky; top: 0; background-color: #fff;">
                <tr>
                    <th>No.</th>
                    <th>Nama Customer</th>
                    <th>Tanggal Pengiriman</th>
                    <th>Total Pesanan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permintaan_produk as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->nama_customer }}
                            {{-- Logika Badge --}}
                            <hr class="my-0" style="visibility: hidden">
                            @php
                                $tanggalPengiriman = \Carbon\Carbon::parse($product->tanggal_pengiriman)->startOfDay();
                                $hariIni = \Carbon\Carbon::now()->startOfDay();
                                $selisihHari = $tanggalPengiriman->diffInDays($hariIni);

                                if ($selisihHari == 0) {
                                    $badgeClass = 'bg-danger';
                                    $badgeText = 'Hari ini';
                                } elseif ($selisihHari < 0 && $selisihHari > -1) {
                                    $badgeClass = 'bg-warning';
                                    $selisihHari = abs($selisihHari);
                                    $badgeText = 'Besok';
                                } elseif ($selisihHari < 0 && $selisihHari > -4) {
                                    $badgeClass = 'bg-warning';
                                    $selisihHari = abs($selisihHari);
                                    $badgeText = "$selisihHari hari lagi";
                                } elseif ($selisihHari < 0 && $selisihHari > -8) {
                                    $badgeClass = 'bg-info';
                                    $selisihHari = abs($selisihHari);
                                    $badgeText = "$selisihHari hari lagi";
                                } elseif ($tanggalPengiriman->isPast()) {
                                    $badgeClass = 'bg-secondary';
                                    $badgeText = 'Sudah lewat';
                                } else {
                                    $badgeClass = 'bg-success';
                                    $selisihHari = abs($selisihHari);
                                    $badgeText = "$selisihHari hari lagi";
                                }

                            @endphp

                            <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                        </td>
                        <td>{{ $tanggalPengiriman->format('d/m/Y') }}</td>
                        <td>
                            {{ number_format(intval($product->qty), 0, ',', '.') }}
                            <hr class="my-0">
                            {{ $product->kode_barang }}
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
