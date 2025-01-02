<?php
session_start();

$conn = mysqli_connect("localhost","root","","stockbarang1");


if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $cekuser = mysqli_query($conn, "SELECT * FROM login where username='$username' and password='$password'");
    $hitung = mysqli_num_rows($cekuser);

    if($hitung){
        $ambildatarole = mysqli_fetch_array($cekuser);
        $role = $ambildatarole['role'];

        if($role=='admin'){
            $_SESSION['log'] = 'Logged';
            $_SESSION['role'] = 'admin';
            header('location:index.php');
        }else{
            $_SESSION['log'] = 'Logged';
            $_SESSION['role'] = 'scaner';
            header('location:scaner.php');
        }
    }
};

if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    $addtotable = mysqli_query($conn,"INSERT INTO stock (namabarang, deskripsi, stock) VALUES('$namabarang','$deskripsi','$stock')");
    if($addtotable){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
};


if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];
    
    $cekstocksekarang = mysqli_query($conn,"SELECT * FROM stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;

    $addtomasuk = mysqli_query($conn,"INSERT INTO masuk (idbarang, penerima, qty) VALUES('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn,"UPDATE stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if($addtomasuk&&$updatestockmasuk){
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}

if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];
    
    $cekstocksekarang = mysqli_query($conn,"SELECT * FROM stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;

    $addtokeluar = mysqli_query($conn,"INSERT INTO keluar (idbarang, penerima, qty) VALUES('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn,"UPDATE stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if($addtokeluar&&$updatestockmasuk){
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}

if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    $update = mysqli_query($conn,"UPDATE stock set namabarang='$namabarang', deskripsi='$deskripsi' where idbarang='$idb'");
    if($update){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];
   
    $hapus = mysqli_query($conn,"DELETE from stock where idbarang='$idb'");
    if($hapus){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}
?>