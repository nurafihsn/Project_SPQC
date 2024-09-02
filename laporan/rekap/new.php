<?php
include "database_lhk6.php";

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Definisikan query SQL
$sql = "SELECT TANGGAL, LSF_lstg FROM 2024_01";
$result = $conn->query($sql);

// Periksa apakah query berhasil dijalankan
if (!$result) {
    die("Query failed: " . $conn->error);
}

$data = array();
$data[] = array('TANGGAL', 'LSF_lstg');

// Periksa apakah hasil query bukan null
if ($result->num_rows > 0) {
    // Output data dari setiap baris
    while($row = $result->fetch_assoc()) {
        $data[] = array($row['TANGGAL'], (int)$row['LSF_lstg']);
    }
} else {
    echo "0 results";
}
$conn->close();

echo json_encode($data);
?>
