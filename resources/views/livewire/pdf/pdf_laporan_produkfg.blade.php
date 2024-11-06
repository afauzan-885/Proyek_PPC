<!DOCTYPE html>
<html>
@inject('carbon', 'Carbon\Carbon')

<head>
  <title>Laporan Finish Goods</title>
  <style>
    body {
      font-family: sans-serif;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    .header {
      text-align: center;
      margin-bottom: 20px;
    }

    .info {
      margin-bottom: 20px;
    }

    .info-table td {
      border: none;
    }
  </style>
</head>

<body>

  <div class="header">
    <h2>Laporan Pemakaian Material</h2>
    <p>Periode: {{ date('d F Y', strtotime('-1 month')) }} - {{ date('d F Y') }}</p>
  </div>

  <div class="info">
    <table>
      <tr>
        <td>Kode Produk:</td>
        <td>{{ $laporan->kode_produk }}</td>
      </tr>
      <tr>
        <td>Nama Produk:</td>
        <td>{{ $laporan->nama_produk }}</td>
      </tr>
    </table>
  </div>

  <table>
    <thead>
      <tr>
        <th>Shift kerja</th>
        <th>Stok Awal</th>
        <th>Jumlah Pemakaian</th>
        <th>Pertambahan Stok</th>
        <th>No. PO</th>
        {{-- <th>Keterangan</th> --}}
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ $laporan->shift_produksi }}</td>
        <td>{{ $laporan->qty_awal }}</td>
        <td>{{ $laporan->jumlah_pengeluaran_material }}</td>
        <td>{{ $laporan->qty_awal - $laporan->qty_in }}</td>
        <td>{{ $laporan->no_po}}</td>
        {{-- <td>{{ $laporan->keterangan }}</td> --}}
      </tr>
    </tbody>
  </table>

  <p>Dicetak pada: {{ date('d F Y') }}</p>

</body>

</html>