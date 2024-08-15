<?php 
    $host = "localhost"; //Alamat server
    $user = "root"; //Home user
    $pass = ""; //Password
    $dbnm = "laundry"; //Nama database
    $conn = new mysqli($host, $user, $pass, $dbnm); //Koneksi ke dalam database

    if($conn->connect_error){
        die("Koneksi gagal!!" . $conn->connect_error);
    }



?>