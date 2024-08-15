<?php 
    include "config.php";
    
    $nama_lengkap = $_POST["nama_lengkap"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $nomor_hp = $_POST["no_hp"];
    $email = $_POST["email"];
    $password_ulang = $_POST["password_ulang"];

    if($password !== $password_ulang){
        echo '<script>alert("Username atau password anda tidak sama!!!")</script>';
        echo '<script>window.location.href = "sign_up.html";</script>';
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo '<script>alert("Email anda salah!!!")</script>';
        echo '<script>window.location.href = "sign_up.html";</script>';
    }


    $check = mysqli_query($conn, "SELECT * FROM pelanggan WHERE username='$username'");
    if(mysqli_num_rows($check) > 0){
        echo '<script>alert("Username sudah ada yang pakai!!!")</script>';
        echo '<script>window.location.href = "sign_up.html";</script>';    
    }
    $insert = mysqli_query($conn, "INSERT INTO pelanggan VALUES('$username', '$password', '$nama_lengkap', '$nomor_hp', '$email')");
    
    echo '<script>alert("Sign up berhasil!! Silahkan login kembali")</script>';
    echo '<script>window.location.href = "login.html";</script>';    



    


?>
