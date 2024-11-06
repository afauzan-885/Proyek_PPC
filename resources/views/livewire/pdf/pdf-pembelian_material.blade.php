<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Purchase Order</title>
  @inject('carbon', 'Carbon\Carbon')
  <?php \Carbon\Carbon::setLocale('id'); ?>

  <style>
    /* CSS umum untuk mengatur ukuran font dan layout */
    body {
      font-family: Arial, sans-serif;
      font-size: 10px;
      margin: 0;
      padding: 0;
    }

    @page {
      margin: 10px 20px;
    }

    .container {
      width: 100%;
    }

    .header-table {
      width: 100%;
      border-collapse: collapse;
      /* Beri jarak di bagian bawah header */
    }

    .header-table td {
      border: 1px solid black;
      padding: 5px;
    }
    
    .section-title {
      font-size: 25px;
      font-weight: bold;
      text-align: center;
      margin: 10px 0;
    }

    /* Tabel item dan summary */
    .items-table,
    .summary-table {
      width: 100%;
      border-collapse: collapse;
      margin: 10px 0;
    }

    .items-table th,
    .items-table td {
      border: 1px solid black;
      padding: 5px;
      font-size: 9px;
      /* Ukuran font dalam tabel item */
    }

    .items-table th {
      background-color: #f2f2f2;
    }

    /* Tabel total */
    .summary-table td {
      border: 1px solid black;
      padding: 5px;
      font-size: 9px;
      /* Ukuran font untuk tabel summary */
    }

    /* Bagian catatan dan tanda tangan */
    .note-section {
      border: 1px solid black;
      padding: 10px;
      font-size: 9px;
      /* Ukuran font catatan */
      height: 80px;
      margin-bottom: 10px;
      /* Tambahkan margin bawah agar lebih rapi */
    }

    .approval-section div {
      display: inline-block;
      width: 100%;
      max-width: 100px;
      margin-right: 7%;
      margin-left: 12%;
      text-align: center;
      margin-top: 5%;

    }



    .approval-signature {
      height: 60px;
      width: 100px;
      border: 1px solid black;
    }

    footer {
      text-align: right;
      font-size: 9px;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2 class="section-title">Purchase Order</h2>
    <a href=""></a>
    <table class="header-table">
      <tr>
        <td width="50%" style="text-align: center; vertical-align: top; padding-top: 0;">
          <strong>SUPPLIER</strong><br style="margin-bottom: 4%; font-size: 14px; margin-top: 5%;">
          {{ $laporan[0]->Supplier->nama_supplier }}<br>
          {{ $laporan[0]->Supplier->alamat_supplier }}<br>
          {{ $laporan[0]->Supplier->kontak_supplier ?? '[None]' }}<br>
          {{ $laporan[0]->Supplier->no_telepon_pt }}<br>
        </td>
        <td width="50%" style="text-align: center; vertical-align: top; padding-top: 0;">
          <strong>PENERIMA</strong><br style="margin-bottom: 4%; font-size: 14px; margin-top: 5%">
          PT. PERSADA WULAN TECHNIK<br>
          Jl. Siliwangi Km 3 Pamis B-5 Gembor 15133 Banten Banten<br>
          0215927050<br>
        </td>
      </tr>
      <tr>
        <td>
          <strong>No. PO</strong>
          <br style="margin-top: 1%"> {{ $laporan[0]->no_po }}
        </td>
        <td>
          <strong>Term of Payment</strong>
          <br style="margin-top: 1%">
        </td>
      </tr>
      <tr>
        <td><strong>Tanggal PO</strong>
          <br style="margin-top: 1%">
          {{-- {{ $carbon::parse($laporan[0]->tanggal_pengiriman)->translatedFormat('l, d F Y') }} --}}
        </td>

        <td><strong>Shipment By</strong>
          <br style="margin-top: 1%">
        </td>
      </tr>
    </table>

    <table class="items-table">
      <tr>
        <th>No</th>
        <th>Deskripsi Item</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Amount</th>
      </tr>
      @foreach ($laporan as $item)
      <tr>
        <td style="text-align: center;">{{ $loop->iteration }}</td>
        <td>
          <span style="display: inline-block; width: 33.3%; margin-top: 2%">{{ $item->kode_material }}</span>
          <span style="display: inline-block; width: 33.3%; margin-top: 2%">{{ $item->ukuran}}</span>
          <span style="display: inline-block; margin-top: 2%">{{ $item->Warehouse->deskripsi}}</span>
        </td>
        <td style="text-align: right;">{{ number_format($item['qty'], 0, ',', '.') }}</td>
        <td style="text-align: right;">Rp. {{ number_format($item['harga_material'], 0, ',', '.') }}</td>
        <td style="text-align: right;">Rp. {{ number_format($item['total_amount'], 0, ',', '.') }}</td>
      </tr>
      @endforeach
    </table>

    {{-- Bagian Perhitungan --}}
    <?php
    $totalAmount = 0; 
    foreach ($laporan as $item) {
        $totalAmount += $item['total_amount'];  
    }
    $tax = $totalAmount * 0.11;  
    $grandTotal = $totalAmount + $tax;
    ?>
    {{-- End perhitungan --}}

    <table class="summary-table" style="width: 30%; float: right;">
      <tr>
        <td width="35%">Amount</td>
        <td style="text-align: right;">Rp. {{ number_format($totalAmount, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td>Discount</td>
        <td style="text-align: right;">0</td>
      </tr>
      <tr>
        <td>Tax 11%</td>
        <td style="text-align: right;">Rp. {{ number_format($tax, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td><strong>Grand Total</strong></td>
        <td style="text-align: right;"><strong>Rp. {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
      </tr>
    </table>

    <div style="clear: both;"></div>
    <table class="header-table">
      <tr>
        <td width="20%">P/R No.</td>
        <td colspan="3"></td>
      </tr>
      <tr>
        <td>Delivery Date</td>
        <td colspan="3"></td>
      </tr>
      <tr>
        <td>Note</td>
        <td colspan="3"></td>
      </tr>
    </table>
    <p>Please sign and return to us after receiving this PO.</p>
    <p>In two days, if we have not got any confirmation, it's meant this PO is agreed.</p>
  </div>

  <div class="approval-section">
    <div class="text-center me-3">
      <p>Approve</p>
      <div class="approval-signature"></div>
      <p>GM/Direktur</p>
      <p style="text-align: left;">Date: ___________________</p>
    </div>
    <div class="text-center me-3">
      <p>Checked</p>
      <div class="approval-signature"></div>
      <p>Purch Dept. Head</p>
      <p style="text-align: left;">Date: ___________________</p>
    </div>
    <div class="text-center me-3">
      <p>Confirm</p>
      <div class="approval-signature"></div>
      <p>Penerima</p>
      <p style="text-align: left;">Date: ___________________</p>
    </div>
  </div>

  <footer>
    <p>Revisi 01 | Tanggal Efektif: 1 Juni 2017</p>
  </footer>
  </div>

</body>

</html>