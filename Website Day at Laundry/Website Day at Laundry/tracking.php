<?php 
    include "config.php";


    $id_pemesanan = $_POST["order_number"];
    
    $sql = "SELECT * FROM pemesanan WHERE id_pemesanan = '$id_pemesanan'";
    $check = mysqli_query($conn, $sql);

    if(mysqli_num_rows($check) == 1){
        //Kode mendapatkan nama pelanggan
        $kode_nama_pelanggan = "SELECT pelanggan.nama_pelanggan FROM pelanggan INNER JOIN pemesanan ON pemesanan.username = pelanggan.username WHERE id_pemesanan='$id_pemesanan'";
        $result_nama_pelanggan = mysqli_query($conn, $kode_nama_pelanggan);

        //Kode mendapatkan tanggal pemesanan
        $kode_tanggal_pemesanan = "SELECT tanggal_pemesanan FROM pemesanan WHERE id_pemesanan = '$id_pemesanan'";
        $result_tanggal_pemesanan = mysqli_query($conn, $kode_tanggal_pemesanan);


        //Kode mendapatkan status
        $kode_status = "SELECT status FROM pemesanan WHERE id_pemesanan = '$id_pemesanan'";
        $result_status = mysqli_query($conn, $kode_status);



         if($result_nama_pelanggan){
            $row_nama_pelanggan = mysqli_fetch_assoc($result_nama_pelanggan);
            $nilai_nama_pelanggan = $row_nama_pelanggan["nama_pelanggan"];
          
         }

         if($result_tanggal_pemesanan){
          $row_tanggal_pemesanan = mysqli_fetch_assoc($result_tanggal_pemesanan);
          $nilai_tanggal_pemesanan = $row_tanggal_pemesanan["tanggal_pemesanan"];
         }

         if($result_status){
          $row_status = mysqli_fetch_assoc($result_status);
          $nilai_status = $row_status["status"];
         }

         //Untuk ganti warna status
         $item_color_dicuci = $item_color_dikeringkan = $item_color_digosok = $item_color_siap_diambil = "#ccc";
         switch($nilai_status){
            case "Dicuci":
            $item_color_dicuci = "rgba(37, 122, 166, 1)";
            break;

            case "Dikeringkan":
            $item_color_dikeringkan = "rgba(37, 122, 166, 1)";
            break;

            case "Digosok":
            $item_color_digosok = "rgba(37, 122, 166, 1)";
            break;

            case "Siap Diambil":
            $item_color_siap_diambil = "rgba(37, 122, 166, 1)";
            break;
            
         }




    }else{
      echo '<script>alert("Id pemesanan anda tidak ada atau salah!!!!!")</script>';
      echo '<script>window.location.href = "verif.html";</script>';
    }
    
       

    
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Tracking/trackingstyle.css">
  <title>Tracking Pesanan</title>
  <style>
    .status-item-dicuci{
      display: inline-block;
      padding: 8px 12px;
      background-color: <?php echo $item_color_dicuci?>;
      margin-right: 10px;
      border-radius: 4px;
    }
    .status-item-dikeringkan{
      display: inline-block;
      padding: 8px 12px;
      background-color: <?php echo $item_color_dikeringkan?>;
      margin-right: 10px;
      border-radius: 4px;
    }
    .status-item-digosok{
      display: inline-block;
      padding: 8px 12px;
      background-color: <?php echo $item_color_digosok?>;
      margin-right: 10px;
      border-radius: 4px;
    }

    .status-item-siap-diambil{
      display: inline-block;
      padding: 8px 12px;
      background-color: <?php echo $item_color_siap_diambil?>;
      margin-right: 10px;
      border-radius: 4px;
    }
  
    .status-item-active{
      background-color: rgba(37, 122, 166, 1);
     color: #fff;
    }
  </style>
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
  <main>
    <section class="tracking-section">
      <h2>Informasi Pesanan</h2>
      <div class="tracking-card">
        <div class="tracking-details">
          <p><span>Nomor Pesanan :</span> <?php echo $id_pemesanan?></p>
          <p><span>Nama Pemesan :</span> <?php echo $nilai_nama_pelanggan?></p>
          <p><span>Tanggal Pemesanan :</span> <?php echo $nilai_tanggal_pemesanan?></p>
        </div>
        <div class="tracking-status">
          <p><span>Status Pemesanan:</span></p>
          <ul>
            <li class="status-item-dicuci">Dicuci</li>
            <li class="status-item-dikeringkan">Dikeringkan</li>
            <li class="status-item-digosok">Digosok</li>
            <li class="status-item-siap-diambil">Siap Diambil</li>
          </ul>
        </div>
      </div>
    </section>
  </main>
</body>
</html>


