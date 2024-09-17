<?php 
if (isset($_POST['barangkeluar'])) {
    // Pastikan data POST ada dan tidak kosong
    if (isset($_POST['barangnya']) && isset($_POST['penerima']) && isset($_POST['tanggal']) && isset($_POST['qty'])) {
        $barangnya = $_POST['barangnya'];
        $penerima = $_POST['penerima'];
        $tanggal = $_POST['tanggal'];
        $qty = $_POST['qty'];
    
        // Cek stok barang di database
        $cekstockbarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
        $ambildatanya = mysqli_fetch_array($cekstockbarang);
    
        $stocksekarang = $ambildatanya['stock'];
    
        // Cek apakah stok mencukupi
        if ($stocksekarang >= $qty) {
            $kurangstocksekarangdenganquantity = $stocksekarang - $qty;
    
            // Proses pengurangan stok dan penambahan data ke tabel 'keluar'
            $addtokeluar = mysqli_query($conn, "INSERT INTO keluar (idbarang, penerima, tanggal, qty) VALUES ('$barangnya', '$penerima', '$tanggal', '$qty')");
            $updatestockkeluar = mysqli_query($conn, "UPDATE stock SET stock='$kurangstocksekarangdenganquantity' WHERE idbarang='$barangnya'");
    
            if ($addtokeluar && $updatestockkeluar) {
                echo "<script>alert('Data Berhasil Dikeluarkan'); window.location.href = 'keluar.php';</script>";
                exit(); // Pastikan script berhenti setelah redirect
            } else {
                echo "<script>alert('Data Gagal Dikeluarkan: " . mysqli_error($conn) . "'); window.location.href = 'keluar.php';</script>";
            }
        } else {
            // Jika stok tidak mencukupi, tampilkan alert
            echo "<script>alert('Stok barang tidak mencukupi! Stok saat ini: $stocksekarang'); window.location.href = 'keluar.php';</script>";
        }
    } else {
        echo "<script>alert('Data tidak lengkap!'); window.location.href = 'keluar.php';</script>";
    }
}
?>