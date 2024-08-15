<?php 
  include "config.php";

  //Dri pemesanan 

  $berat =floatval($_POST["berat"]); 
  $alamat = $_POST["alamat"];
  $metode_pembayaran = $_POST["metode-pembayaran"];
  $id_pelayanan = "PEL0000001";
  $bank = $_POST["bank-options"];
  $promo = $_POST["promo"];
  $nomor_rekdit = $_POST["nomor-rekdit"];

  //Menginput ke database

  //Mendapatkan id_pemesanan terakhir
  $kode_last_id_pemesanan = "SELECT id_pemesanan FROM pemesanan ORDER BY id_pemesanan DESC LIMIT 1";
  $result_last_id_pemesanan = mysqli_query($conn, $kode_last_id_pemesanan);
  if($result_last_id_pemesanan){
    $row_last_id_pemesanan = @mysqli_fetch_assoc($result_last_id_pemesanan);
    
    
    //Id pemesanan baru
    if($row_last_id_pemesanan == 0){
      //Bila kosong maka default
      $id_pemesanan_baru = "PEM0000001";
    }else{

      //Mengambil nilai terakhir
      $nilai_last_id_pemesanan = $row_last_id_pemesanan["id_pemesanan"];
      //Mengekstrak bagian numerik dari id
      $bagian_numerik = substr($nilai_last_id_pemesanan, 3);

      //Diubah ke ke dalam numerik
      $nilai_numerik = intval($bagian_numerik);
      $tambah_nilai = $nilai_numerik + 1;
      $id_pemesanan_baru = "PEM" . str_pad($tambah_nilai, strlen($bagian_numerik), "0", STR_PAD_LEFT);
    }
  }

  



  //Harga pelayanan
  $kode_harga_pelayanan = "SELECT harga FROM pelayanan WHERE id_pelayanan='$id_pelayanan'";
  $result_harga_pelayanan = mysqli_query($conn, $kode_harga_pelayanan);

  if($result_harga_pelayanan){
    $row_harga_pelayanan = mysqli_fetch_assoc($result_harga_pelayanan);
    $nilai_harga_pelayanan = $row_harga_pelayanan["harga"];
  }

  //Total biaya
  $total_biaya = intval($berat) * $nilai_harga_pelayanan;


  //Dimasukkan ke dalam database
  $username = "Hadi"; //Nanti diubah berdasarkan login kalau bisa
  $insert_pemesanan_baru = mysqli_query($conn, "INSERT INTO pemesanan VALUES('$id_pemesanan_baru', '$username', '$id_pelayanan', '$alamat', 'Dicuci', NOW(), '$berat', '$nomor_rekdit')");


  
  


  //Untuk struk

  //Mendapatkan id pemesanan
  $kode_id_pemesanan = "SELECT id_pemesanan FROM pemesanan WHERE id_pemesanan='$id_pemesanan_baru'";
  $result_id_pemesanan = mysqli_query($conn, $kode_id_pemesanan);

  if($result_id_pemesanan){
    $row_id_pemesanan = mysqli_fetch_assoc($result_id_pemesanan);
    $nilai_id_pemesanan = $row_id_pemesanan["id_pemesanan"];
  }

  //Mendapatkan username dari id_pemesanan_baru
  $kode_username = "SELECT username FROM pemesanan WHERE id_pemesanan='$id_pemesanan_baru'";
  $result_username = mysqli_query($conn, $kode_username);
  if($result_id_pemesanan){
    $row_username = mysqli_fetch_assoc($result_username);
    $nilai_username = $row_username["username"];
  }


  //Mendapatkan nama lengkap

  $kode_nama_pelanggan = "SELECT nama_pelanggan FROM pelanggan WHERE username = '$nilai_username'";
  $result_nama_pelanggan = mysqli_query($conn, $kode_nama_pelanggan);

  if($result_nama_pelanggan){
    $row_nama_pelanggan = mysqli_fetch_assoc($result_nama_pelanggan);
    $nilai_nama_pelanggan = $row_nama_pelanggan["nama_pelanggan"];
  }

  //Mendapatkan nomor telepon
  $kode_nomor_telepon = "SELECT no_telp FROM pelanggan WHERE username = '$username'";
  $result_nomor_telepon = mysqli_query($conn, $kode_nomor_telepon);

  if($result_nomor_telepon){
    $row_nomor_telepon = mysqli_fetch_assoc($result_nomor_telepon);
    $nilai_nomor_telepon = $row_nomor_telepon["no_telp"];
  }


  

  //Mendapatkan nama jenis pelayanan
  $kode_nama_pelayanan = "SELECT nama FROM pelayanan WHERE id_pelayanan = '$id_pelayanan'";
  $result_nama_pelayanan = mysqli_query($conn, $kode_nama_pelayanan);

  if($result_nama_pelayanan){
    $row_nama_pelayanan= mysqli_fetch_assoc($result_nama_pelayanan);
    $nilai_nama_pelayanan = $row_nama_pelayanan["nama"];
  }
  

  //Mendapatkan jumlah atau berat
  $kode_kuantitas = "SELECT kuantitas FROM pemesanan WHERE username = '$username'";
  $result_kuantitas = mysqli_query($conn, $kode_kuantitas);

  if($result_kuantitas){
    $row_kuantitas = mysqli_fetch_assoc($result_kuantitas);
    $nilai_kuantitas = $row_kuantitas["kuantitas"];
  }


  //Mendapatkan promo ada atau tidak, bila ada maka aktif atau tidak
  $kode_cari_promo = "SELECT * FROM promo WHERE kode='$promo' AND masih_berlaku=1";
  $result_cari_promo = mysqli_query($conn, $kode_cari_promo);

  if($result_cari_promo){
    $row_cari_promo = mysqli_fetch_assoc($result_cari_promo);
    
    if($row_cari_promo == null){
      $nilai_cari_promo = 0;
    }else{
      $nilai_cari_promo = $row_cari_promo["persentase_diskon"];
    }
  }


   //Mendapatkan total biaya
   $total_biaya_setelah_diskon = ($total_biaya - ($nilai_cari_promo * $total_biaya));
   //Membuat id_metode pembayaran terakhir
  $kode_last_id_pembayaran = "SELECT id_pembayaran FROM pembayaran ORDER BY id_pembayaran DESC LIMIT 1";
  $result_last_id_pembayaran = mysqli_query($conn, $kode_last_id_pembayaran);
  if($result_last_id_pembayaran){
    $row_last_id_pembayaran = @mysqli_fetch_assoc($result_last_id_pembayaran);
    
    
    //Id pemesanan baru
    if($row_last_id_pembayaran == 0){
      //Bila kosong maka default
      $id_pembayaran_baru = "PBY0000001";
    }else{

      //Mengambil nilai terakhir
      $nilai_last_id_pembayaran = $row_last_id_pembayaran["id_pembayaran"];
      //Mengekstrak bagian numerik dari id
      $bagian_numerik = substr($nilai_last_id_pembayaran, 3);

      //Diubah ke ke dalam numerik
      $nilai_numerik = intval($bagian_numerik);
      $tambah_nilai = $nilai_numerik + 1;
      $id_pembayaran_baru = "PBY" . str_pad($tambah_nilai, strlen($bagian_numerik), "0", STR_PAD_LEFT);
    }
  }


  $kode_insert_pembayaran = "INSERT INTO pembayaran VALUES('$id_pembayaran_baru', '$id_pemesanan_baru', '$bank', '$metode_pembayaran', '$total_biaya_setelah_diskon')";
  $insert_pembayaran = mysqli_query($conn, $kode_insert_pembayaran);



  


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Struk Kiloan/strukstyle_kiloan.css">
  <title>Struk Pembayaran</title>
</head>
<body>
<div class="group-container">
        <div class="group-2">
            <img class="image-7" src="Logo.jpeg" alt="image 7" />
            <div class="navbar">
                <div class="navbar-link-place navbar-link"><a href="main.html">Home</a></div>
                <div class="navbar-link-services navbar-link"><a href="Services.html">Services</a></div>
                <div class="navbar-link-promotions navbar-link"><a href="promosi.html">Promotions</a></div>
                <div class="navbar-link-about-us navbar-link"><a href="AboutUs.html">About Us</a></div>
                <div class="navbar-link-log-in navbar-link"><a href="login.html">Log In</a></div>
            </div>
        </div>
    </div>
  <header>
    <h1>Struk Pembayaran Laundry Kiloan</h1>
  </header>
  
  <main>
    <section class="payment-section">
      <h2>Informasi Pembayaran</h2>
      <div class="payment-card">
        <p><span>Nomor Pesanan:</span> <?php echo $id_pemesanan_baru?></p>
        <p><span>Nama:</span> <?php echo $nilai_nama_pelanggan?></p>
        <p><span>Nomor Telepon:</span> <?php echo $nilai_nomor_telepon?></p>
        <p><span>Jumlah/Berat:</span> <?php echo $nilai_kuantitas?></p>
        <p><span>Promo :</span> <?php echo $nilai_cari_promo?></p>
        <p><span>Total Biaya:</span> <?php echo $total_biaya?></p>
        <p><span>Jenis Layanan:</span> <?php echo $nilai_nama_pelayanan?></p>
        <p><span>Total Biaya Setelah Diskon:</span> <?php echo $total_biaya_setelah_diskon?></p>
        <p><span>Metode Pembayaran:</span> <?php echo $metode_pembayaran?></p>
        <p><span>Bank:</span> <?php echo $bank?></p>
        <p><span>Status Pembayaran:</span> 
          <span class="status paid">Sudah Dibayar</span>
        </p>
        <p class="verification-link"><a href="verif.html">Verifikasi Nomor Pesanan</a></p>
      </div>
    </section>
  </main>
</body>
</html>