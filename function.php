<?php
session_start();
//koneksi
$conn = mysqli_connect("localhost", "root", "", "stockbarang");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

    if(isset($_POST['addnewbarang'])){
        $namabarang = $_POST ['namabarang'];
        $deskripsi = $_POST ['deskripsi'];
        $stock = $_POST ['stock'];
        
        $addtotable = mysqli_query($conn, "insert into stock (namabarang, deskripsi, stock) values ('$namabarang', '$deskripsi', '$stock')");
        
        if($addtotable){
            echo "Data Berhasil Ditambahkan";
            header('location:index.php');
            }else{
                echo "Data Gagal Ditambahkan";
                header('location:index.php');
                }
                }
// menambah barang

if (isset($_POST['barangmasuk'])) {
    // Pastikan data POST ada dan tidak kosong
    if (isset($_POST['barangnya']) && isset($_POST['penerima']) && isset($_POST['tanggal'])) {
        $barangnya = $_POST['barangnya'];
        $penerima = $_POST['penerima'];
        $tanggal = $_POST['tanggal'];
        $qty = $_POST['qty'];

        $cekstockbarang = mysqli_query($conn,"SELECT * FROM stock WHERE idbarang='$barangnya'");
        $ambildatanya = mysqli_fetch_array($cekstockbarang);

        $stocksekarang = $ambildatanya['stock'];
        $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;

        // Validasi: Pastikan $barangnya adalah angka
        if (is_numeric($barangnya)) {
            // Eksekusi query
            $addtomasuk = mysqli_query($conn, "INSERT INTO masuk (idbarang, keterangan, tanggal, qty) VALUES ('$barangnya', '$penerima', '$tanggal', '$qty')");
            $updatestockmasuk = mysqli_query($conn,"UPDATE stock SET stock='$tambahkanstocksekarangdenganquantity' WHERE idbarang='$barangnya' ");
            if ($addtomasuk&&$updatestockmasuk) {
                echo "Data Berhasil Ditambahkan";
                header('location:masuk.php');
                exit(); // pastikan script berhenti setelah redirect
            } else {
                echo "Data Gagal Ditambahkan: " . mysqli_error($conn);
            }
        } else {
            echo "ID Barang tidak valid.";
        }
    } else {
        echo "Data barangmasuk tidak lengkap.";
    }



    
// barang keluar

}
?>