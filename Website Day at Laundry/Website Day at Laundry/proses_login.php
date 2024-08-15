<?php 
    //Hubung ke database
    include "config.php";

    //Menyimpan variabel inputan dari halaman login
    $username = $_POST["username"];
    
    $password = $_POST["password"];


    

    //Menyiapakan dan menjalankan sebuah query SQL
    $sql = "SELECT * FROM pelanggan WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);


    //Mengecek apakah user ada di database
    if(mysqli_num_rows($result) == 1){
        echo "Login berhasil";

        //Link ke main page
        header("Location: main.html");
    }else{
        //Jika salah maka akan restart kembali ke halaman login
        echo '<script>alert("Username atau password anda salah!!!!!")</script>';
        echo '<script>window.location.href = "login.html";</script>';
        
    }


?>
