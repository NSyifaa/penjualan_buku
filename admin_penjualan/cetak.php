<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>58mm Thermal Printer</title>
    
    <style>
        /* Set width to 58mm */
        body, html {
            width: 58mm;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .receipt {
            width: 100%;
            padding: 10px;
            text-align: center;
        }

        .receipt h2, .receipt h4 {
            margin: 0;
            padding: 0;
        }

        .receipt p {
            margin: 5px 0;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .total {
            font-weight: bold;
        }

        @media print {
            /* Remove margins when printing */
            @page {
                margin: 0;
            }

            body {
                margin: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>
<?php
require_once '../database/koneksi.php';



$id = $_GET['id'];
$sql_stok = mysqli_query($koneksi, "SELECT nomor, tgl, nama_pel FROM tbl_penjualan WHERE id='$id'") or die(mysqli_error($koneksi));
$data = mysqli_fetch_assoc($sql_stok);
$nomor = $data['nomor'];
$tanggal = $data['tgl'];
$nama_pel = $data['nama_pel'];


$sql_panggilpj = mysqli_query($koneksi, "SELECT * FROM tbl_detail_penjualan WHERE nomor='$nomor'") or die(mysqli_error($koneksi));
$total = 0;
?>


<body onload="window.print();">
    <div class="receipt">
       <div class="row">
        <div class="col-12">
         <center>
         <div class="header">
        <img src="../auth/assets/img/logobk.png" width="150px" height="100px">
            <h3>Toko Buku Mayang</h3>
            <p>Alamat: Jl. Contoh No. 123, Kota</p>
            <p><strong>Nomor Nota: <?= $nomor; ?></strong></p>
            <p>Tanggal: <?= $tanggal; ?></p>
            <p>Pelanggan: <?= $nama_pel; ?></p>
        </div>
        <br><font style="font-size: 13px;"><b> - - - - - - - - - - - - - - - - - - - - - - - - - -</b></font>
        </center>
        </div>
       </div>


       <div class="row">
        <div class="col-12">
        <table>
        <thead>
        <tr>
          <th width="60%"><font style="font-size: 13px;">Nama Buku</font></th>
          <th width="2%"><font style="font-size: 13px;">Qty</font></th>
          <th width="2%"><font style="font-size: 13px;">Harga </font></th>
          <th width="70%"><font style="font-size: 13px;">Subtotal</font></th>
        </tr>
      </thead>
      <tbody>
      <?php
       while ($data_pj = mysqli_fetch_array($sql_panggilpj)) {
        $kd_buku = $data_pj['kd_buku'];
        $ambilnomor = mysqli_query($koneksi, "SELECT judul_buku FROM tbl_buku WHERE kd_buku='$kd_buku'") or die(mysqli_error($koneksi));
        $data_buku = mysqli_fetch_array($ambilnomor);
        $buku = $data_buku['judul_buku'];
        $qty = $data_pj['qty'];
        $harga = $data_pj['harga'];
        $subtotal = $qty * $harga;
        $total += $subtotal;
          
      ?>
        <tr>
          <td><font style="font-size: 13px;"><?= $buku; ?></font></td>
          <td><font style="font-size: 13px;"><?= $qty; ?></font></td>
          <td><font style="font-size: 13px;">Rp <?= number_format($harga, 0, ',', '.'); ?></font></td>
          <td><font style="font-size: 13px;">Rp.<?=number_format($subtotal,0,",",".");?>,-</font></td>
        </tr>
        
      <?php
        }
      ?>
      </tbody>
           <tr>
            <td colspan="4"> - - - - - - - - - - - - - - - - - - - - - </td>
           </tr>
        </table>
        <div class="row">
            <div class="col-lg-12">
            <table class="table">
            <tr>
                <th width="48%"><font style="font-size: 13px;">Total</font></th>
                <th width="8%"><font style="font-size: 13px;">:</font></th>
                <td width="90%"><font style="font-size: 13px;">Rp. <?=number_format($total,0,",",".");?>,-</font></td>
            </tr>
            <tr>
                <td colspan="3"> - - - - - - - - - - - - - - - - - - - - - </td>
            </tr>
            </table>
            </div>
            <div class="footer">
                Terima kasih atas kunjungan Anda!<br>
               Toko Buku Mayang
            </div>

        </div>
        </div>
       </div>
    </div>
</body>
</html>
