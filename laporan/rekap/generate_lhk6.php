<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap LHK dan LPB Indarung 6</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <h2 class="text-center"> Rekap LHK dan LPB Indarung 6 </h2>
    <div class="container mt-5">
        <label> Rekap LHK Indarung 6</label>
        <form method="post">
            <button type="submit" class="btn btn-primary">Generate</button>
        </form>
        
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Buat query SQL untuk memindahkan data dari data_qc ke rekap_ind5
            $query = "
            INSERT INTO rekap_ind6.lhk_2024 (ID, TANGGAL, JAM, SiO2_lstg, Al2O3_lstg, Fe2O3_lstg, CaO_lstg, MgO_lstg, SO3_lstg, H2O_lstg) 
			SELECT ID, TANGGAL, JAM, SiO2, Al2O3, Fe2O3, CaO, MgO, SO3, H2O
			FROM data_qc.lstg_6
			ON DUPLICATE KEY UPDATE
			    SiO2_lstg = VALUES(SiO2_lstg),
			    Al2O3_lstg = VALUES(Al2O3_lstg),
			    Fe2O3_lstg = VALUES(Fe2O3_lstg),
			    CaO_lstg = VALUES(CaO_lstg),
			    MgO_lstg = VALUES(MgO_lstg),
			    SO3_lstg = VALUES(SO3_lstg),
			    H2O_lstg = VALUES(H2O_lstg);
            ";


            // Detail koneksi database
            $hostname = "localhost";
            $username = "root";
            $password = "";
            $database1 = "rekap_ind6"; 
            $database2 = "data_qc";    

            // Buat koneksi
            $conn = new mysqli($hostname, $username, $password, $database1);

            // Periksa koneksi
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Pilih database kedua
            if (!$conn->select_db($database2)) {
                die("Selection of database $database2 failed: " . $conn->error);
            }

            // Eksekusi query
            if ($conn->query($query) === TRUE) {
                echo "Query executed successfully";
            } else {
                echo "Error: " . $conn->error;
            }

            // Tutup koneksi
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
