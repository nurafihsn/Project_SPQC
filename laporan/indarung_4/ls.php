<?php
session_start();
$level = strtoupper($_SESSION['level']);
if ($level == NULL) {
    echo "<script>window.location = '../index.php'</script>";
}
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    include "../../include/database.php";
     require_once "../../lib/library.php";
}
$stmt = $conn->query('SELECT * FROM tb_config');
    if (!$stmt) {
        die("Query error: " . mysqli_error($conn));
    }
    
    $configs = [];
    while ($row = mysqli_fetch_assoc($stmt)) {
        $configs[$row['nama_config']] = [
            'max' => $row['max'],
            'min' => $row['min']
        ];
    }

?>


<!doctype html>
<!-- <html lang="en-US" xmlns:fb="https://www.facebook.com/2008/fbml" xmlns:addthis="https://www.addthis.com/help/api-spec" prefix="og: http://ogp.me/ns#" class="no-js"> -->

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title></title>

	<link rel="shortcut icon" href="https://demo.learncodeweb.com/favicon.ico">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" type="text/css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	
</head>

<body>
	<?php
	$xkey = '';
	if (isset($_GET['submit'])) {
		$xkey = $_GET['xkey'];
		$_SESSION['xkey'] = $xkey;
	} else {
		if (isset($_GET['halaman']) || isset($_REQUEST['xkey']) || isset($_REQUEST['update'])) {
			$xkey = $_SESSION['xkey'];
		} else {
			$xkey = '';
			$_SESSION['xkey'] = '';
		}
	}

	if (isset($_REQUEST['update'])) {
    $fields = ['SiO2r1', 'Al2O3r1', 'Fe2O3r1', 'CaOr1', 'MgOr1', 'SO3r1', 'K2Or1', 'Na2Or1', 'H2Or1', 'PILEr1', 'TIANGr1', 'JAMr1', 'SiO2r2', 'Al2O3r2', 'Fe2O3r2', 'CaOr2', 'MgOr2', 'SO3r2', 'K2Or2', 'Na2Or2', 'H2Or2', 'PILEr2', 'TIANGr2', 'JAMr2'];
    $values = array_map(function($field) {
        return isset($_GET[$field . '_e']) && $_GET[$field . '_e'] !== '' ? $_GET[$field . '_e'] : NULL;
    }, $fields);

    $id_e = isset($_GET['id_e']) && $_GET['id_e'] !== '' ? $_GET['id_e'] : NULL;

    if ($id_e) {
        $setClause = implode(' = ?, ', $fields) . ' = ?';
        $sql = "UPDATE ls_4 SET $setClause WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            $types = str_repeat('s', count($fields)) . 'i';
            mysqli_stmt_bind_param($stmt, $types, ...array_merge($values, [$id_e]));

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>window.location = 'ls.php'</script>";
            }
            mysqli_stmt_close($stmt);
        }
    }
}





$jumlahDataPerhalaman = 3;

$halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;

if (isset($_GET['awal']) && isset($_GET['akhir'])) {
    $awal = $_GET['awal'];
    $akhir = $_GET['akhir'];
    $sql_filtered = "SELECT * FROM ls_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'";
} elseif (isset($_GET['kemarin'])) {
    $sql_filtered = "SELECT * FROM ls_4 WHERE TANGGAL = CURDATE() - INTERVAL 1 DAY";
}
else {
    $sql_filtered = "SELECT * FROM ls_4 WHERE TANGGAL = CURDATE()";
}

$result_filtered = mysqli_query($conn, $sql_filtered);
$jumlahData = mysqli_num_rows($result_filtered);

$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

$sql = "$sql_filtered LIMIT $awalData, $jumlahDataPerhalaman";
$q = mysqli_query($conn, $sql);
?>

		<center style="font-family: Arial, sans-serif; font-size: 24px; font-weight: bold; color: #333333; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
		    <label>LIMESTONE Indarung 4</label>
		</center>

		<form method="get" class="mb-3">
			<label>PILIH TANGGAL : </label>
			<input type="date" name="awal">
			<input type="date" name="akhir">

			<input class="btn btn-primary" type="submit" value="FILTER">

		</form>
		<form method="get" class="mb-3" >
	  		<button type="submit" class="btn btn-primary btn-sm" name="kemarin" value="1">Data Kemarin</button>
		</form>
		<center>
			<?php
			    if(isset($_GET['awal']) && isset($_GET['akhir'])){
			        $awal = $_GET['awal'];
			        $akhir = $_GET['akhir'];
			        echo "<label>Data : $awal Sampai $akhir</label>";
			    }
			    ?>
		</center>
		

	<table class="adminlist mb-3" border="1" width="500" cellpadding="5" >
					<tr class="text-center" >
			            <th colspan="1"></th><th colspan="15">LS R1</th><th colspan="15">LS R2</th>
			        </tr>
			    <tr bgcolor="#8080FF" style="color:#FFFFFF">
			        <th></th>
			        <th>LSF</th>
			        <th>SIM</th>
			        <th>ALM</th>
			        <th>SiO2</th>
			        <th>Al2O3</th>
			        <th>Fe2O3</th>
			        <th>CaO</th>
			        <th>MgO</th>
			        <th>SO3</th>
			        <th>K2O</th>
			        <th>Na2O</th>
			        <th>Cl2</th>
			        <th>SUM</th>
			        <th>ALKALI</th>
			        <th>H2O</th>
			        <th>LSF</th>
			        <th>SIM</th>
			        <th>ALM</th>
			        <th>SiO2</th>
			        <th>Al2O3</th>
			        <th>Fe2O3</th>
			        <th>CaO</th>
			        <th>MgO</th>
			        <th>SO3</th>
			        <th>K2O</th>
			        <th>Na2O</th>
			        <th>Cl2</th>
			        <th>SUM</th>
			        <th>ALKALI</th>
			        <th>H2O</th>
			    </tr> 
			    

			     <tr bgcolor="YELLOW" style="color:BLACK">
				    <th>COUNT</th>
				    <?php
				    // Periksa apakah variabel $_GET['TANGGAL'] terdefinisi
				    if(isset($_GET['awal']) && isset($_GET['akhir'])){
				        $awal = $_GET['awal'];
			        	$akhir = $_GET['akhir'];
				        // Lakukan query untuk menghitung jumlah setiap kolom berdasarkan tanggal yang dipilih
				      $count_query = mysqli_query($conn, "SELECT COUNT(LSFr1) AS count_lsfr1, COUNT(SIMr1) AS count_simr1, COUNT(ALMr1) AS count_almr1, COUNT(SiO2r1) AS count_sio2r1, COUNT(Al2O3r1) AS count_al2o3r1, COUNT(Fe2O3r1) AS count_Fe2O3r1, COUNT(CaOr1) AS count_caor1, COUNT(MgOr1) AS count_MgOr1, COUNT(SO3r1) AS count_SO3r1, COUNT(K2Or1) AS count_K2Or1, COUNT(Na2Or1) AS count_Na2Or1, COUNT(Cl2r1) AS count_Cl2r1, COUNT(SUMr1) AS count_sumr1, COUNT(ALKALIr1) AS count_alkalir1, COUNT(H2Or1) AS count_H2Or1, COUNT(LSFr2) AS count_lsfr2, COUNT(SIMr2) AS count_simr2, COUNT(ALMr2) AS count_almr2, COUNT(SiO2r2) AS count_sio2r2, COUNT(Al2O3r2) AS count_al2o3r2, COUNT(Fe2O3r2) AS count_Fe2O3r2, COUNT(CaOr2) AS count_caor2, COUNT(MgOr2) AS count_MgOr2, COUNT(SO3r2) AS count_SO3r2, COUNT(K2Or2) AS count_K2Or2, COUNT(Na2Or2) AS count_Na2Or2, COUNT(Cl2r2) AS count_Cl2r2, COUNT(SUMr2) AS count_sumr2, COUNT(ALKALIr2) AS count_alkalir2, COUNT(H2Or2) AS count_H2Or2 FROM ls_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

				        // Ambil hasil dari query count
				        $count_result = mysqli_fetch_assoc($count_query);
				        // Tampilkan hasil count dalam baris tabel
				        foreach ($count_result as $count) {
				            echo "<td>".$count."</td>";
				        }
				    } else {
				        // Jika tanggal tidak terdefinisi, tampilkan semua data
				        $sql = mysqli_query($conn,"SELECT * FROM ls_4");
				        while($data = mysqli_fetch_array($sql)){
				            // Di sini Anda dapat menampilkan data sesuai kebutuhan
				        }
				    }
				    ?>
				</tr>
			      <tr bgcolor="YELLOW" style="color:BLACK">
			        <th>MIN</th>
			        <?php
			        if(isset($_GET['awal']) && isset($_GET['akhir'])){
				        $awal = $_GET['awal'];
			        	$akhir = $_GET['akhir'];
			       $min_query = mysqli_query($conn, "SELECT MIN(LSFr1) AS min_lsfr1, MIN(SIMr1) AS min_simr1, MIN(ALMr1) AS min_almr1, MIN(SiO2r1) AS min_SiO2r1, MIN(Al2O3r1) AS min_Al2O3r1, MIN(Fe2O3r1) AS min_Fe2O3r1, MIN(CaOr1) AS min_CaOr1, MIN(MgOr1) AS min_MgOr1, MIN(SO3r1) AS min_SO3r1, MIN(K2Or1) AS min_K2Or1, MIN(Na2Or1) AS min_Na2Or1, MIN(Cl2r1) AS min_Cl2r1, MIN(SUMr1) AS min_sumr1, MIN(ALKALIr1) AS min_alkalir1, MIN(H2Or1) AS min_H2Or1, MIN(LSFr2) AS min_lsfr2, MIN(SIMr2) AS min_simr2, MIN(ALMr2) AS min_almr2, MIN(SiO2r2) AS min_SiO2r2, MIN(Al2O3r2) AS min_Al2O3r2, MIN(Fe2O3r2) AS min_Fe2O3r2, MIN(CaOr2) AS min_CaOr2, MIN(MgOr2) AS min_MgOr2, MIN(SO3r2) AS min_SO3r2, MIN(K2Or2) AS min_K2Or2, MIN(Na2Or2) AS min_Na2Or2, MIN(Cl2r2) AS min_Cl2r2, MIN(SUMr2) AS min_sumr2, MIN(ALKALIr2) AS min_alkalir2, MIN(H2Or2) AS min_H2Or2 FROM ls_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

			       $min_result = mysqli_fetch_assoc($min_query);
				        foreach ($min_result as $min) {
				            echo "<td>".number_format($min, 2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM ls_4");
				        while($data = mysqli_fetch_array($sql)){
				        }
				    }
				    ?>
			    </tr>
			    <tr bgcolor="YELLOW" style="color:BLACK">
			        <th>AVERAGE</th>
			        <?php
			        if(isset($_GET['awal']) && isset($_GET['akhir'])){
				        $awal = $_GET['awal'];
			        	$akhir = $_GET['akhir'];
			     $average_query = mysqli_query($conn, "SELECT AVG(LSFr1) AS avg_lsfr1, AVG(SIMr1) AS avg_simr1, AVG(ALMr1) AS avg_almr1, AVG(SiO2r1) AS avg_SiO2r1, AVG(Al2O3r1) AS avg_Al2O3r1, AVG(Fe2O3r1) AS avg_Fe2O3r1, AVG(CaOr1) AS avg_CaOr1, AVG(MgOr1) AS avg_MgOr1, AVG(SO3r1) AS avg_SO3r1, AVG(K2Or1) AS avg_K2Or1, AVG(Na2Or1) AS avg_Na2Or1, AVG(Cl2r1) AS avg_Cl2r1, AVG(SUMr1) AS avg_sumr1, AVG(ALKALIr1) AS avg_alkalir1, AVG(H2Or1) AS avg_H2Or1, AVG(LSFr2) AS avg_lsfr2, AVG(SIMr2) AS avg_simr2, AVG(ALMr2) AS avg_almr2, AVG(SiO2r2) AS avg_SiO2r2, AVG(Al2O3r2) AS avg_Al2O3r2, AVG(Fe2O3r2) AS avg_Fe2O3r2, AVG(CaOr2) AS avg_CaOr2, AVG(MgOr2) AS avg_MgOr2, AVG(SO3r2) AS avg_SO3r2, AVG(K2Or2) AS avg_K2Or2, AVG(Na2Or2) AS avg_Na2Or2, AVG(Cl2r2) AS avg_Cl2r2, AVG(SUMr2) AS avg_sumr2, AVG(ALKALIr2) AS avg_alkalir2, AVG(H2Or2) AS avg_H2Or2 FROM ls_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

			        $average_result = mysqli_fetch_assoc($average_query);
				        foreach ($average_result as $average) {
				            echo "<td>".number_format($average, 2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM ls_4");
				        while($data = mysqli_fetch_array($sql)){
				        }
				    }
				    ?>
			    </tr>
			    <tr bgcolor="YELLOW" style="color:BLACK">
			        <th>MAX</th>
			        <?php
			        if(isset($_GET['awal']) && isset($_GET['akhir'])){
				        $awal = $_GET['awal'];
			        	$akhir = $_GET['akhir'];
			        $max_query = mysqli_query($conn, "SELECT MAX(LSFr1) AS max_lsfr1, MAX(SIMr1) AS max_simr1, MAX(ALMr1) AS max_almr1, MAX(SiO2r1) AS max_SiO2r1, MAX(Al2O3r1) AS max_Al2O3r1, MAX(Fe2O3r1) AS max_Fe2O3r1, MAX(CaOr1) AS max_CaOr1, MAX(MgOr1) AS max_MgOr1, MAX(SO3r1) AS max_SO3r1, MAX(K2Or1) AS max_K2Or1, MAX(Na2Or1) AS max_Na2Or1, MAX(Cl2r1) AS max_Cl2r1, MAX(SUMr1) AS max_sumr1, MAX(ALKALIr1) AS max_alkalir1, MAX(H2Or1) AS max_H2Or1, MAX(LSFr2) AS max_lsfr2, MAX(SIMr2) AS max_simr2, MAX(ALMr2) AS max_almr2, MAX(SiO2r2) AS max_SiO2r2, MAX(Al2O3r2) AS max_Al2O3r2, MAX(Fe2O3r2) AS max_Fe2O3r2, MAX(CaOr2) AS max_CaOr2, MAX(MgOr2) AS max_MgOr2, MAX(SO3r2) AS max_SO3r2, MAX(K2Or2) AS max_K2Or2, MAX(Na2Or2) AS max_Na2Or2, MAX(Cl2r2) AS max_Cl2r2, MAX(SUMr2) AS max_sumr2, MAX(ALKALIr2) AS max_alkalir2, MAX(H2Or2) AS max_H2Or2 FROM ls_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
			         $max_result = mysqli_fetch_assoc($max_query);
				        foreach ($max_result as $max) {
				            echo "<td>".$max."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM ls_4");
				        while($data = mysqli_fetch_array($sql)){
				        }
				    }
				    ?>
			    </tr>
			    <tr bgcolor="YELLOW" style="color:BLACK">
			        <th>SD</th>
			        <?php
			        if(isset($_GET['awal']) && isset($_GET['akhir'])){
				        $awal = $_GET['awal'];
			        	$akhir = $_GET['akhir'];
			       $sd_query = mysqli_query($conn, "SELECT STDDEV(LSFr1) AS sd_lsfr1, STDDEV(SIMr1) AS sd_simr1, STDDEV(ALMr1) AS sd_almr1, STDDEV(SiO2r1) AS sd_SiO2r1, STDDEV(Al2O3r1) AS sd_Al2O3r1, STDDEV(Fe2O3r1) AS sd_Fe2O3r1, STDDEV(CaOr1) AS sd_CaOr1, STDDEV(MgOr1) AS sd_MgOr1, STDDEV(SO3r1) AS sd_SO3r1, STDDEV(K2Or1) AS sd_K2Or1, STDDEV(Na2Or1) AS sd_Na2Or1, STDDEV(Cl2r1) AS sd_Cl2r1, STDDEV(SUMr1) AS sd_sumr1, STDDEV(ALKALIr1) AS sd_alkalir1, STDDEV(H2Or1) AS sd_H2Or1, STDDEV(LSFr2) AS sd_lsfr2, STDDEV(SIMr2) AS sd_simr2, STDDEV(ALMr2) AS sd_almr2, STDDEV(SiO2r2) AS sd_SiO2r2, STDDEV(Al2O3r2) AS sd_Al2O3r2, STDDEV(Fe2O3r2) AS sd_Fe2O3r2, STDDEV(CaOr2) AS sd_CaOr2, STDDEV(MgOr2) AS sd_MgOr2, STDDEV(SO3r2) AS sd_SO3r2, STDDEV(K2Or2) AS sd_K2Or2, STDDEV(Na2Or2) AS sd_Na2Or2, STDDEV(Cl2r2) AS sd_Cl2r2, STDDEV(SUMr2) AS sd_sumr2, STDDEV(ALKALIr2) AS sd_alkalir2, STDDEV(H2Or2) AS sd_H2Or2 FROM ls_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

			        $sd_result = mysqli_fetch_assoc($sd_query);
				        foreach ($sd_result as $sd) {
				            echo "<td>".number_format($sd, 2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM ls_4");
				        while($data = mysqli_fetch_array($sql)){
				        }
				    }
				    ?>
			    </tr>  
			</table>
			<table class="adminlist mb-3" border="1" width="500" cellpadding="5" >
				<tr class="text-center" >
			            <th colspan="1"></th><th colspan="3">LS R1</th><th colspan="3">LS R2</th>
			        </tr>
			    <tr bgcolor="#8080FF" style="color:#FFFFFF">
			        <th></th>
			        <th>SiO2</th>
			        <th>Al2O3</th>
			        <th>CaO</th>
			        <th>SiO2</th>
			        <th>Al2O3</th>
			        <th>CaO</th>
			    </tr>
			    <tr bgcolor="YELLOW" style="color:BLACK">
				    <th>DATA IN</th>
				    <?php
					if (isset($_GET['awal']) && isset($_GET['akhir'])) {
					    $awal = $_GET['awal'];
					    $akhir = $_GET['akhir'];
					    
					    $datain_query = mysqli_query($conn, "SELECT 
					        COUNT(IF(SiO2r1 > 10, 1, NULL)) AS datain_sio2r1,
					        COUNT(IF(Al2O3r1 > 1.7, 1, NULL)) AS datain_al2o3r1,
					        COUNT(IF(CaOr1 < 46, 1, NULL)) AS datain_caor1,
					        COUNT(IF(SiO2r2 > 10, 1, NULL)) AS datain_sio2r2,
					        COUNT(IF(Al2O3r2 > 1.7, 1, NULL)) AS datain_al2o3r2,
					        COUNT(IF(CaOr2 < 46, 1, NULL)) AS datain_caor2
					        FROM ls_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
					    
					    $datain_result = mysqli_fetch_assoc($datain_query);
					    $kolom = array("SiO2r1", "Al2O3r1", "CaOr1", "SiO2r2", "Al2O3r2", "CaOr2");
					    foreach ($kolom as $nama_kolom) {
					        $count = $count_result["count_" . strtolower($nama_kolom)];
					        $datain = $datain_result["datain_" . strtolower($nama_kolom)];
					        $hasil = $count - $datain;
					        echo "<td>" . $hasil . "</td>";
					    }
					} else {
					}
					?>

				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>%DATA IN</th>
				    <?php
					if (isset($_GET['awal']) && isset($_GET['akhir'])) {
					    $awal = $_GET['awal'];
					    $akhir = $_GET['akhir'];
					    
					    $datain_query = mysqli_query($conn, "SELECT 
					         COUNT(IF(SiO2r1 > 10, 1, NULL)) AS datain_sio2r1,
					        COUNT(IF(Al2O3r1 > 1.7, 1, NULL)) AS datain_al2o3r1,
					        COUNT(IF(CaOr1 < 46, 1, NULL)) AS datain_caor1,
					        COUNT(IF(SiO2r2 > 10, 1, NULL)) AS datain_sio2r2,
					        COUNT(IF(Al2O3r2 > 1.7, 1, NULL)) AS datain_al2o3r2,
					        COUNT(IF(CaOr2 < 46, 1, NULL)) AS datain_caor2
					        FROM ls_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
					    
					    $datain_result = mysqli_fetch_assoc($datain_query);
					    $kolom = array("SiO2r1", "Al2O3r1", "CaOr1", "SiO2r2", "Al2O3r2", "CaOr2");
					    foreach ($kolom as $nama_kolom) {
					        $count = $count_result["count_" . strtolower($nama_kolom)];
					        $datain = $datain_result["datain_" . strtolower($nama_kolom)];
					        $hasil = $count - $datain;
					        if ($count != 0) {
							  $persentase = ($hasil / $count) * 100;
							} else {
							   $persentase = 0; 
							}
					         echo "<td>" . number_format($persentase, 2) . "%</td>";
					    }
					} else {
					}
					?>

				</tr>
			</table>


	<div class="container">
	    <div class="row">
	        <div class="col-sm-3">
	            <div class="form-group">
	                <a href="" class="btn btn-primary" data-toggle="modal" data-target="#addData"><i class="fa fa-fw fa-plus-circle"></i>Add Data</a>
	            </div>
	            <div class="form-group">
	                <a href="exportls.php" class="btn btn-primary" > Download </a>
	            </div>
	        </div>        
	    </div>
	</div>
	    


		<div>
			 <table class="table table-striped table-bordered table-hover m">
				<thead>

					<tr class="text-center" >
			            <th colspan="2"></th><th colspan="15">LS R1</th><th colspan="15">LS R2</th>
			        </tr>
					<tr class="text-center" >
			             <th  colspan="1" ></th><th colspan="3">LIMESTONE</th><th colspan="10">OKSIDA</th> <th colspan="4"></th> <th colspan="1"></th><th colspan="3">LIMESTONE</th><th colspan="10">OKSIDA</th> <th colspan="4"></th> <th colspan="1"></th><th colspan="3"></th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>Tanggal</th><th>LSF</th> <th>SIM</th> <th>ALM</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th> <th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>SUM</th><th>Alkali</th><th>H2O</th> <th>PILE</th> <th>TIANG</th><th>JAM SAMPLING</th><th>LSF</th> <th>SIM</th> <th>ALM</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th> <th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>SUM</th><th>Alkali</th><th>H2O</th> <th>PILE</th> <th>TIANG</th><th>JAM SAMPLING</th><th>KETERANGAN</th> <th>Report</th>

						<th class="text-center">Action</th>
					</tr>
				</thead>

				<tbody>
					    <?php
					    $n = $awalData;
					    while ($d = mysqli_fetch_array($q)) {
					        
							$lsfr1 = null;
							if (!empty($d['SiO2_r1']) && ($d['SiO2_r1'] != 0 || $d['Al2O3_r1'] != 0 || $d['Fe2O3_r1'] != 0)) {
							    $lsfr1 = ($d['CaO_r1'] * $configs['lsf_1']) / ($configs['lsf_2']* $d['SiO2_r1'] + $configs['lsf_3']* $d['Al2O3_r1'] + $configs['lsf_4'] * $d['Fe2O3_r1']);
							}
							$lsfr1 = !is_null($lsfr1) ? number_format((float)$lsfr1, 2, '.', '') : null;

							$simr1 = null;
							if (!empty($d['SiO2_r1']) && ($d['Al2O3_r1'] + $d['Fe2O3_r1'] != 0)) {
							    $simr1 =  $d['SiO2_r1'] / ($d['Al2O3_r1'] + $d['Fe2O3_r1']);
							}
							$simr1 = !is_null($simr1) ? number_format((float)$simr1, 2, '.', '') : null;

							$almr1 = null;
							if (!empty($d['Al2O3_r1']) && $d['Fe2O3_r1'] != 0) {
							    $almr1 =  $d['Al2O3_r1'] / $d['Fe2O3_r1'];
							}
							$almr1 = !is_null($almr1) ? number_format((float)$almr1, 2, '.', '') : null;

							$c3sr1 = null;
							if (!empty($d['SiO2_r1'])) {
							    $c3sr1 = 4.071 * ($d['CaO_r1'] - $d['FCaO_r1']) - 7.6 * $d['SiO2_r1'] - 6.718 * $d['Al2O3_r1'] - 1.43 * $d['Fe2O3_r1'];
							}
							$c3sr1 = !is_null($c3sr1) ? number_format((float)$c3sr1, 2, '.', '') : null;

							$c3ar1 = null;
							if (!empty($d['Al2O3_r1'])) {
							    $c3ar1 = 2.65 * $d['Al2O3_r1'] - 1.692 * $d['Fe2O3_r1'];
							}
							$c3ar1 = !is_null($c3ar1) ? number_format((float)$c3ar1, 2, '.', '') : null;

							$sumr1 = null;
							if (!empty($d['SiO2_r1'])) {
							    $sumr1 = $d['SiO2_r1'] + $d['Al2O3_r1'] + $d['Fe2O3_r1'] + $d['CaO_r1'] + $d['MgO_r1'] + $d['SO3_r1'] + $d['K2O_r1'] + $d['Na2O_r1'] + $d['K2O_r1'];
							}
							$sumr1 = !is_null($sumr1) ? number_format((float)$sumr1, 2, '.', '') : null;

							$alkalir1 = null;
							if (!empty($d['Na2O_r1']) || !empty($d['K2O_r1'])) {
							    $alkalir1 =  $d['Na2O_r1'] + ($d['K2O_r1'] * $configs['alkali']);
							}
							$alkalir1 = !is_null($alkalir1) ? number_format((float)$alkalir1, 2, '.', '') : null;

							$lsfr2 = null;
							if (!empty($d['SiO2_r2']) && ($d['SiO2_r2'] != 0 || $d['Al2O3_r2'] != 0 || $d['Fe2O3_r2'] != 0)) {
							    $lsfr2 = ($d['CaO_r2'] * $configs['lsf_1']) / ($configs['lsf_2']* $d['SiO2_r2'] + $configs['lsf_3']* $d['Al2O3_r2'] + $configs['lsf_4'] * $d['Fe2O3_r2']);
							}
							$lsfr2 = !is_null($lsfr2) ? number_format((float)$lsfr2, 2, '.', '') : null;

							$simr2 = null;
							if (!empty($d['SiO2_r2']) && ($d['Al2O3_r2'] + $d['Fe2O3_r2'] != 0)) {
							    $simr2 =  $d['SiO2_r2'] / ($d['Al2O3_r2'] + $d['Fe2O3_r2']);
							}
							$simr2 = !is_null($simr2) ? number_format((float)$simr2, 2, '.', '') : null;

							$almr2 = null;
							if (!empty($d['Al2O3_r2']) && $d['Fe2O3_r2'] != 0) {
							    $almr2 =  $d['Al2O3_r2'] / $d['Fe2O3_r2'];
							}
							$almr2 = !is_null($almr2) ? number_format((float)$almr2, 2, '.', '') : null;

							$c3sr2 = null;
							if (!empty($d['SiO2_r2'])) {
							    $c3sr2 = 4.071 * ($d['CaO_r2'] - $d['FCaO_r2']) - 7.6 * $d['SiO2_r2'] - 6.718 * $d['Al2O3_r2'] - 1.43 * $d['Fe2O3_r2'];
							}
							$c3sr2 = !is_null($c3sr2) ? number_format((float)$c3sr2, 2, '.', '') : null;

							$c3ar2 = null;
							if (!empty($d['Al2O3_r2'])) {
							    $c3ar2 = 2.65 * $d['Al2O3_r2'] - 1.692 * $d['Fe2O3_r2'];
							}
							$c3ar2 = !is_null($c3ar2) ? number_format((float)$c3ar2, 2, '.', '') : null;

							$sumr2 = null;
							if (!empty($d['SiO2_r2'])) {
							    $sumr2 = $d['SiO2_r2'] + $d['Al2O3_r2'] + $d['Fe2O3_r2'] + $d['CaO_r2'] + $d['MgO_r2'] + $d['SO3_r2'] + $d['K2O_r2'] + $d['Na2O_r2'] + $d['K2O_r2'];
							}
							$sumr2 = !is_null($sumr2) ? number_format((float)$sumr2, 2, '.', '') : null;

							$alkalir2 = null;
							if (!empty($d['Na2O_r2']) || !empty($d['K2O_r2'])) {
							    $alkalir2 =  $d['Na2O_r2'] + ($d['K2O_r2'] * $configs['alkali']);
							}
							$alkalir2 = !is_null($alkalir2) ? number_format((float)$alkalir2, 2, '.', '') : null;

					       $update_query = "UPDATE ls_4 SET LSFr1=?, SIMr1=?, ALMr1=?, SUMr1=?, ALKALIr1=?, LSFr2=?, SIMr2=?, ALMr2=?, SUMr2=?, ALKALIr2=? WHERE id=?";
							$stmt = mysqli_prepare($conn, $update_query);

							mysqli_stmt_bind_param($stmt, "sssssssssss", $lsfr1, $simr1, $almr1, $sumr1, $alkalir1, $lsfr2, $simr2, $almr2, $sumr2, $alkalir2, $d['id']);

							if (mysqli_stmt_execute($stmt)) {
							    echo "";
							} else {
							    echo "Error: " . mysqli_error($conn);
							}
							mysqli_stmt_close($stmt);


							$w_Al2O3r1 = '';
							if ($d['Al2O3r1'] < $configs['Al2O3qc']['min']  || $d['Al2O3r1'] >= $configs['Al2O3qc']['max'] ) {
							    $w_Al2O3r1 = 'text-danger';
							}
							$w_alkalir1 = '';
					        if ($alkalir1 > $configs['ALKALIqc']['max']  ) {
					            $w_alkalir1 = 'text-danger';
					        }
					        $w_SiO2r1 = '';
							if ($d['SiO2r1'] < $configs['SiO2qc']['min']  || $d['SiO2r1'] > $configs['SiO2qc']['max'] ) {
							    $w_SiO2r1 = 'text-danger';
							}
							$w_CaOr1 = '';
					        if ($d['CaOr1'] < $configs['CaOqc']['min']  ) {
					            $w_CaOr1 = 'text-danger';
					        }
					        $w_H2Or1 = '';
					        if ($d['H2Or1'] > 6 ) {
					            $w_H2Or1 = 'text-danger';
					        }
					        $w_Al2O3r2 = '';
							if ($d['Al2O3r2'] < $configs['Al2O3qc']['min']  || $d['Al2O3r2'] >= $configs['Al2O3qc']['max'] ) {
							    $w_Al2O3r2 = 'text-danger';
							}
							$w_alkalir2 = '';
					        if ($alkalir2 > $configs['ALKALIqc']['max'] ) {
					            $w_alkalir2 = 'text-danger';
					        }
					        $w_SiO2r2 = '';
							if ($d['SiO2r2'] < $configs['SiO2qc']['min']  || $d['SiO2r2'] > $configs['SiO2qc']['max'] ) {
							    $w_SiO2r2 = 'text-danger';
							}
							$w_CaOr2 = '';
					        if ($d['CaOr2'] < $configs['CaOqc']['min']  ) {
					            $w_CaOr2 = 'text-danger';
					        }
					        $w_H2Or2 = '';
					        if ($d['H2Or2'] > 6 ) {
					            $w_H2Or2 = 'text-danger';
					        }
							
					      

					    ?>

					        <tr>
					        	<td><?php echo $d['TANGGAL']; ?></td>
					            <td><?php echo $lsfr1; ?></td>
					            <td><?php echo $simr1; ?></td>
					            <td><?php echo $almr1; ?></td>
					            <td class="<?php echo $w_SiO2r1; ?>"><?php echo $d['SiO2r1']; ?></td>
					            <td class="<?php echo $w_Al2O3r1; ?>"><?php echo $d['Al2O3r1']; ?></td>
					            <td><?php echo $d['Fe2O3r1']; ?></td>
					            <td class="<?php echo $w_CaOr1; ?>"><?php echo $d['CaOr1']; ?></td>
					            <td><?php echo $d['MgOr1']; ?></td>
					            <td><?php echo $d['SO3r1']; ?></td>
					            <td><?php echo $d['K2Or1']; ?></td>
					            <td><?php echo $d['Na2Or1']; ?></td>
					            <td><?php echo $d['Cl2r1']; ?></td>
					            <td><?php echo $sumr1; ?></td>
					            <td class="<?php echo $w_alkalir1; ?>" ><?php echo $alkalir1; ?></td>
					            <td class="<?php echo $w_H2Or1; ?>"><?php echo $d['H2Or1']; ?></td>
					            <td><?php echo $d['PILEr1']; ?></td>
					            <td><?php echo $d['TIANGr1']; ?></td>            
					            <td><?php echo $d['JAMr1']; ?></td> 
					            <td><?php echo $lsfr2; ?></td>
					            <td><?php echo $simr2; ?></td>
					            <td><?php echo $almr2; ?></td>
					            <td class="<?php echo $w_SiO2r2; ?>"><?php echo $d['SiO2r2']; ?></td>
					            <td class="<?php echo $w_Al2O3r2; ?>"><?php echo $d['Al2O3r2']; ?></td>
					            <td><?php echo $d['Fe2O3r2']; ?></td>
					            <td class="<?php echo $w_CaOr2; ?>"><?php echo $d['CaOr2']; ?></td>
					            <td><?php echo $d['MgOr2']; ?></td>
					            <td><?php echo $d['SO3r2']; ?></td>
					            <td><?php echo $d['K2Or2']; ?></td>
					            <td><?php echo $d['Na2Or2']; ?></td>
					            <td><?php echo $d['Cl2r2']; ?></td>
					            <td><?php echo $sumr2; ?></td>
					            <td class="<?php echo $w_alkalir2; ?>" ><?php echo $alkalir2; ?></td>
					            <td class="<?php echo $w_H2Or2; ?>"><?php echo $d['H2Or2']; ?></td>
					            <td><?php echo $d['PILEr2']; ?></td>
					            <td><?php echo $d['TIANGr2']; ?></td>            
					            <td><?php echo $d['JAMr2']; ?></td>            
					            <td><?php echo $d['KETERANGAN']; ?></td>
					            <td><?php echo $d['waktu'] ; ?> <a> <?php echo $d['iduser'] ; ?></a></td>
					            
					            
					            <td align="center">
					                <a href="#" type="button" style="height:34px" class="btn btn-success btn-md  pl-4 pr-4" data-toggle="modal" data-target="#myModal<?php echo $d['id']; ?>"><i class="fa fa-fw fa-edit"></i>Edit</a>
					                <a href="del-ls.php?delId=<?php echo $d['id']; ?>" type="button" class="btn btn-danger" style="height:34px" onClick="return confirm('Are you sure to delete this data?');"><i class="fa fa-fw fa-trash"></i> Delete</a>
					            </td>
					        </tr>

					        
					        
					        <!-- Edit data -->
					        <div class="modal fade" id="myModal<?php echo $d['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					            <div class="modal-dialog">
					                <div class="modal-content">
					                    <div class="modal-header bg-primary text-white">
										<h5 class="modal-title " id="exampleModalLabel">Edit Data</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>

									<div class="modal-body">
										<form role="form" action="" method="get">

											<?php
											$id = $d['id'];
											$sql = "SELECT * FROM ls_4 where id ='$id' ";
											$qr = mysqli_query($conn, $sql);

											//$result = mysqli_query($conn, $query);
											while ($row = mysqli_fetch_array($qr)) {
											?>
 

												<input type="hidden" name="id_e" value="<?php echo $row['id']; ?>">

												<br>
													<center>LS R1</center>
												</br>
												<div class="form-group row my-0">
													<label for="SiO2r1" class="col-sm-4 col-form-label">SiO2</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="SiO2r1_e" name="SiO2r1_e" value="<?= $row['SiO2r1']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Al2O3r1" class="col-sm-4 col-form-label">Al2O3</label>
													<div class="col-sm-8">
														<input type="Al2O3r1" style="height:30px" class="form-control" id="Al2O3r1_e" name="Al2O3r1_e" value="<?= $row['Al2O3r1']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Fe2O3r1" class="col-sm-4 col-form-label">Fe2O3</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="Fe2O3r1_e" name="Fe2O3r1_e" value="<?= $row['Fe2O3r1']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="CaOr1" class="col-sm-4 col-form-label">CaO</label>
													<div class="col-sm-8">
														<input type="CaOr1" style="height:30px" class="form-control" id="CaOr1_e" name="CaOr1_e" value="<?= $row['CaOr1']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
												    <label for="MgOr1" class="col-sm-4 col-form-label">MgO</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="MgOr1_e" name="MgOr1_e" value="<?= $row['MgOr1']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="SO3r1" class="col-sm-4 col-form-label">SO3</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="SO3r1_e" name="SO3r1_e" value="<?= $row['SO3r1']; ?>">
												    </div>
												</div>
												
												<div class="form-group row my-0">
												    <label for="K2Or1" class="col-sm-4 col-form-label">K2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="K2Or1_e" name="K2Or1_e" value="<?= $row['K2Or1']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="Na2Or1" class="col-sm-4 col-form-label">Na2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="Na2Or1_e" name="Na2Or1_e" value="<?= $row['Na2Or1']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="Cl2r1" class="col-sm-4 col-form-label">Cl2</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="Cl2r1_e" name="Cl2r1_e" value="<?= $row['Cl2r1']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="H2Or1" class="col-sm-4 col-form-label">H2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="H2Or1_e" name="H2Or1_e" value="<?= $row['H2Or1']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="PILEr1" class="col-sm-4 col-form-label">PILE</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="PILEr1_e" name="PILEr1_e" value="<?= $row['PILEr1']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="TIANGr1" class="col-sm-4 col-form-label">TIANG</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="TIANGr1_e" name="TIANGr1_e" value="<?= $row['TIANGr1']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="JAMr1" class="col-sm-4 col-form-label">JAM SAMPLING</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="JAMr1_e" name="JAMr1_e" value="<?= $row['JAMr1']; ?>">
												    </div>
												</div>
												<br>
													<center>LS R2</center>
												</br>
												<div class="form-group row my-0">
													<label for="SiO2r2" class="col-sm-4 col-form-label">SiO2</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="SiO2r2_e" name="SiO2r2_e" value="<?= $row['SiO2r2']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Al2O3r2" class="col-sm-4 col-form-label">Al2O3</label>
													<div class="col-sm-8">
														<input type="Al2O3r2" style="height:30px" class="form-control" id="Al2O3r2_e" name="Al2O3r2_e" value="<?= $row['Al2O3r2']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Fe2O3r2" class="col-sm-4 col-form-label">Fe2O3</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="Fe2O3r2_e" name="Fe2O3r2_e" value="<?= $row['Fe2O3r2']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="CaOr2" class="col-sm-4 col-form-label">CaO</label>
													<div class="col-sm-8">
														<input type="CaOr2" style="height:30px" class="form-control" id="CaOr2_e" name="CaOr2_e" value="<?= $row['CaOr2']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
												    <label for="MgOr2" class="col-sm-4 col-form-label">MgO</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="MgOr2_e" name="MgOr2_e" value="<?= $row['MgOr2']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="SO3r2" class="col-sm-4 col-form-label">SO3</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="SO3r2_e" name="SO3r2_e" value="<?= $row['SO3r2']; ?>">
												    </div>
												</div>
												
												<div class="form-group row my-0">
												    <label for="K2Or2" class="col-sm-4 col-form-label">K2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="K2Or2_e" name="K2Or2_e" value="<?= $row['K2Or2']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="Na2Or2" class="col-sm-4 col-form-label">Na2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="Na2Or2_e" name="Na2Or2_e" value="<?= $row['Na2Or2']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="Cl2r2" class="col-sm-4 col-form-label">Cl2</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="Cl2r2_e" name="Cl2r2_e" value="<?= $row['Cl2r2']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="H2Or2" class="col-sm-4 col-form-label">H2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="H2Or2_e" name="H2Or2_e" value="<?= $row['H2Or2']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="PILEr2" class="col-sm-4 col-form-label">PILE</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="PILEr2_e" name="PILEr2_e" value="<?= $row['PILEr2']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="TIANGr2" class="col-sm-4 col-form-label">TIANG</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="TIANGr2_e" name="TIANGr2_e" value="<?= $row['TIANGr2']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="JAMr2" class="col-sm-4 col-form-label">JAM SAMPLING</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="JAMr2_e" name="JAMr2_e" value="<?= $row['JAMr2']; ?>">
												    </div>
												</div>
												<div class="form-group mt-4">

													<button type="submit" name="update" value="update" id="update" class="btn btn-primary"> Update </button>
													<button type="button" class="btn btn-danger pl-4 pr-4" data-dismiss="modal">Close</button>

												</div>


											<?php
											}
											?>
										</form>
									</div>
								</div>

							</div>
						</div>

						<!-- end edit data -->




					<?php
					}
					?>
				</tbody>
			</table>
			<div class="mt-2">
			    <nav aria-label="Page navigation example">
			        <ul class="pagination">
			            <?php if ($halamanAktif > 1) : ?>
			                <li class="page-item">
			                    <a class="page-link" href="?halaman=<?= $halamanAktif - 1; ?>&awal=<?= $awal; ?>&akhir=<?= $akhir; ?>">Previous</a>
			                </li>
			            <?php endif; ?>
			            <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
			                <?php if ($i == $halamanAktif) : ?>
			                    <li class="page-item active"><a class="page-link" href="?halaman=<?= $i; ?>&awal=<?= $awal; ?>&akhir=<?= $akhir; ?>"><?= $i; ?></a></li>
			                <?php else : ?>
			                    <li class="page-item"><a class="page-link" href="?halaman=<?= $i; ?>&awal=<?= $awal; ?>&akhir=<?= $akhir; ?>"><?= $i; ?></a></li>
			                <?php endif; ?>
			            <?php endfor; ?>
			            <?php if ($halamanAktif < $jumlahHalaman) : ?>
			                <li class="page-item"><a class="page-link" href="?halaman=<?= $halamanAktif + 1; ?>&awal=<?= $awal; ?>&akhir=<?= $akhir; ?>">Next</a></li>
			            <?php endif; ?>
			        </ul>
			    </nav>
			</div>
		</div> <!--/.col-sm-12-->

	</div>

	<!-- add data  -->

	<?php

	$SiO2r1 = !empty($_POST['SiO2r1']) ? $_POST['SiO2r1'] : NULL;
	$Al2O3r1 = !empty($_POST['Al2O3r1']) ? $_POST['Al2O3r1'] : NULL;
	$Fe2O3r1 = !empty($_POST['Fe2O3r1']) ? $_POST['Fe2O3r1'] : NULL;
	$CaOr1 = !empty($_POST['CaOr1']) ? $_POST['CaOr1'] : NULL;
	$MgOr1 = !empty($_POST['MgOr1']) ? $_POST['MgOr1'] : NULL;
	$SO3r1 = !empty($_POST['SO3r1']) ? $_POST['SO3r1'] : NULL;
	$K2Or1 = !empty($_POST['K2Or1']) ? $_POST['K2Or1'] : NULL;
	$Na2Or1 = !empty($_POST['Na2Or1']) ? $_POST['Na2Or1'] : NULL;
	$Cl2r1 = !empty($_POST['Cl2r1']) ? $_POST['Cl2r1'] : NULL;
	$H2Or1 = !empty($_POST['H2Or1']) ? $_POST['H2Or1'] : NULL;
	$PILEr1 = !empty($_POST['PILEr1']) ? $_POST['PILEr1'] : NULL;
	$TIANGr1 = !empty($_POST['TIANGr1']) ? $_POST['TIANGr1'] : NULL;
	$JAMr1 = !empty($_POST['JAMr1']) ? $_POST['JAMr1'] : NULL;
	$SiO2r2 = !empty($_POST['SiO2r2']) ? $_POST['SiO2r2'] : NULL;
	$Al2O3r2 = !empty($_POST['Al2O3r2']) ? $_POST['Al2O3r2'] : NULL;
	$Fe2O3r2 = !empty($_POST['Fe2O3r2']) ? $_POST['Fe2O3r2'] : NULL;
	$CaOr2 = !empty($_POST['CaOr2']) ? $_POST['CaOr2'] : NULL;
	$MgOr2 = !empty($_POST['MgOr2']) ? $_POST['MgOr2'] : NULL;
	$SO3r2 = !empty($_POST['SO3r2']) ? $_POST['SO3r2'] : NULL;
	$K2Or2 = !empty($_POST['K2Or2']) ? $_POST['K2Or2'] : NULL;
	$Na2Or2 = !empty($_POST['Na2Or2']) ? $_POST['Na2Or2'] : NULL;
	$Cl2r2 = !empty($_POST['Cl2r2']) ? $_POST['Cl2r2'] : NULL;
	$H2Or2 = !empty($_POST['H2Or2']) ? $_POST['H2Or2'] : NULL;
	$PILEr2 = !empty($_POST['PILEr2']) ? $_POST['PILEr2'] : NULL;
	$TIANGr2 = !empty($_POST['TIANGr2']) ? $_POST['TIANGr2'] : NULL;
	$JAMr2 = !empty($_POST['JAMr2']) ? $_POST['JAMr2'] : NULL;

	?>


	<div class="modal fade" id="addData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h5 class="modal-title " id="exampleModalLabel">Add Data</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<div class="modal-body">
					<?php

					date_default_timezone_set('Asia/Jakarta');

					if (isset($_POST['submit'])) {
					    $waktu = date("H:i:s");
					    $tanggal = date("Y-m-d");

					    // Bind parameter dengan prepared statement
					    $sql = "INSERT INTO ls_4 (TANGGAL, SiO2r1, Al2O3r1, Fe2O3r1, CaOr1, MgOr1, SO3r1, K2Or1, Na2Or1, Cl2r1, H2Or1, PILEr1, TIANGr1, JAMr1,SiO2r2, Al2O3r2, Fe2O3r2, CaOr2, MgOr2, SO3r2, K2Or2, Na2Or2, Cl2r2, H2Or2, PILEr2, TIANGr2, JAMr2, waktu, iduser) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
					    $stmt = mysqli_prepare($conn, $sql);
					    mysqli_stmt_bind_param($stmt, "sssssssssssssssssssssssssssss", $tanggal, $SiO2r1, $Al2O3r1, $Fe2O3r1, $CaOr1, $MgOr1, $SO3r1, $K2Or1, $Na2Or1, $Cl2r1, $H2Or1, $PILEr1, $TIANGr1, $JAMr1,$SiO2r2, $Al2O3r2, $Fe2O3r2, $CaOr2, $MgOr2, $SO3r2, $K2Or2, $Na2Or2, $Cl2r2, $H2Or2, $PILEr2, $TIANGr2, $JAMr2, $waktu, $username);

					    if (mysqli_stmt_execute($stmt)) {
					        echo "<script>window.location = 'ls.php'</script>";
					    } else {
					        echo "Error: " . mysqli_error($conn);
					    }

					    // Tutup statement
					    mysqli_stmt_close($stmt);
					}

					$sql = "SELECT * FROM ls_4 ORDER BY TANGGAL DESC";
					$q = mysqli_query($conn, $sql);
					?>

					<div class="container">
						<form method="POST" onsubmit="return validateForm()">
							<br>
								<center>LS R1</center>
							</br>
							<div class="form-group row my-0">
								<label for="SiO2r1" class="col-sm-4 col-form-label">SiO2</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="SiO2r1" name="SiO2r1" placeholder="Enter SiO2r1" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="Al2O3r1" class="col-sm-4 col-form-label">Al2O3</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="Al2O3r1" name="Al2O3r1" placeholder="Enter Al2O3r1" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="Fe2O3r1" class=" col-sm-4 col-form-label">Fe2O3</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="Fe2O3r1" name="Fe2O3r1" placeholder="Enter Fe2O3r1" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="CaOr1" class="col-sm-4 col-form-label">CaO</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="CaOr1" name="CaOr1" placeholder="Enter CaOr1" >
								</div>
							</div>
						
							<div class="form-group row my-0">
							    <label for="MgOr1" class="col-sm-4 col-form-label">MgO</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="MgOr1" name="MgOr1" placeholder="Enter MgOr1" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="SO3r1" class="col-sm-4 col-form-label">SO3</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="SO3r1" name="SO3r1" placeholder="Enter SO3r1" >
							    </div>
							</div>
							
							<div class="form-group row my-0">
							    <label for="K2Or1" class="col-sm-4 col-form-label">K2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="K2Or1" name="K2Or1" placeholder="Enter K2Or1" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="Na2Or1" class="col-sm-4 col-form-label">Na2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="Na2Or1" name="Na2Or1" placeholder="Enter Na2Or1" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="Cl2r1" class="col-sm-4 col-form-label">Cl2</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="Cl2r1" name="Cl2r1" placeholder="Enter Cl2r1" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="H2Or1" class="col-sm-4 col-form-label">H2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="H2Or1" name="H2Or1" placeholder="Enter H2Or1" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="PILEr1" class="col-sm-4 col-form-label">PILE</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="PILEr1" name="PILEr1" placeholder="Enter PILEr1" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="TIANGr1" class="col-sm-4 col-form-label">TIANG</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="TIANGr1" name="TIANGr1" placeholder="Enter TIANGr1" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="JAMr1" class="col-sm-4 col-form-label">JAM SAMPLING</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="JAMr1" name="JAMr1" placeholder="Enter JAMr1 SAMPLING" >
							    </div>
							</div>
							<br>
								<center>LS R2</center>
							</br>
							<div class="form-group row my-0">
								<label for="SiO2r2" class="col-sm-4 col-form-label">SiO2</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="SiO2r2" name="SiO2r2" placeholder="Enter SiO2r2" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="Al2O3r2" class="col-sm-4 col-form-label">Al2O3</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="Al2O3r2" name="Al2O3r2" placeholder="Enter Al2O3r2" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="Fe2O3r2" class=" col-sm-4 col-form-label">Fe2O3</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="Fe2O3r2" name="Fe2O3r2" placeholder="Enter Fe2O3r2" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="CaOr2" class="col-sm-4 col-form-label">CaO</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="CaOr2" name="CaOr2" placeholder="Enter CaOr2" >
								</div>
							</div>
						
							<div class="form-group row my-0">
							    <label for="MgOr2" class="col-sm-4 col-form-label">MgO</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="MgOr2" name="MgOr2" placeholder="Enter MgOr2" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="SO3r2" class="col-sm-4 col-form-label">SO3</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="SO3r2" name="SO3r2" placeholder="Enter SO3r2" >
							    </div>
							</div>
							
							<div class="form-group row my-0">
							    <label for="K2Or2" class="col-sm-4 col-form-label">K2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="K2Or2" name="K2Or2" placeholder="Enter K2Or2" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="Na2Or2" class="col-sm-4 col-form-label">Na2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="Na2Or2" name="Na2Or2" placeholder="Enter Na2Or2" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="Cl2r2" class="col-sm-4 col-form-label">Cl2</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="Cl2r2" name="Cl2r2" placeholder="Enter Cl2r2" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="H2Or2" class="col-sm-4 col-form-label">H2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="H2Or2" name="H2Or2" placeholder="Enter H2Or2" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="PILEr2" class="col-sm-4 col-form-label">PILE</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="PILEr2" name="PILEr2" placeholder="Enter PILEr2" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="TIANGr2" class="col-sm-4 col-form-label">TIANG</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="TIANGr2" name="TIANGr2" placeholder="Enter TIANGr2" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="JAMr2" class="col-sm-4 col-form-label">JAM SAMPLING</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="JAMr2" name="JAMr2" placeholder="Enter JAMr2 SAMPLING" >
							    </div>
							</div>
							
							<div class="form-group mt-4">
							<div class="form-group mt-4">

								<button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary  pl-4 pr-4"> Save </button>
								<button type="button" class="btn btn-danger pl-4 pr-4" data-dismiss="modal">Close</button>
							</div>
					</div>

				</div>

			</div>
		</div>
	</div>

	<script>
	    function validateForm() {
	        var SiO2r1 = document.getElementById("SiO2r1").value;
	        var Al2O3r1 = document.getElementById("Al2O3r1").value;
	        var Fe2O3r1 = document.getElementById("Fe2O3r1").value;
	        var CaOr1 = document.getElementById("CaOr1").value;
	        var MgOr1 = document.getElementById("MgOr1").value;
	        var SO3r1 = document.getElementById("SO3r1").value;
	        var K2Or1 = document.getElementById("K2Or1").value;
	        var Na2Or1 = document.getElementById("Na2Or1").value;
	        var Cl2r1 = document.getElementById("Cl2r1").value;
	        var H2Or1 = document.getElementById("H2Or1").value;
	        var SiO2r2 = document.getElementById("SiO2r2").value;
	        var Al2O3r2 = document.getElementById("Al2O3r2").value;
	        var Fe2O3r2 = document.getElementById("Fe2O3r2").value;
	        var CaOr2 = document.getElementById("CaOr2").value;
	        var MgOr2 = document.getElementById("MgOr2").value;
	        var SO3r2 = document.getElementById("SO3r2").value;
	        var K2Or2 = document.getElementById("K2Or2").value;
	        var Na2Or2 = document.getElementById("Na2Or2").value;
	        var Cl2r2 = document.getElementById("Cl2r2").value;
	        var H2Or2 = document.getElementById("H2Or2").value;

	        var inputs = [SiO2r1, Al2O3r1, Fe2O3r1, CaOr1, MgOr1, SO3r1, K2Or1, Na2Or1, Cl2r1, H2Or1, SiO2r2, Al2O3r2, Fe2O3r2, CaOr2, MgOr2, SO3r2, K2Or2, Na2Or2, Cl2r2, H2Or2];

	        for (var i = 0; i < inputs.length; i++) {
	            if (inputs[i].includes(",")) {
	                alert("untuk bilangan desimal gunakan titik(.)");
	                return false;
	            }
	        }
	        return true;
	    }
	</script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/jquery.caret/0.1/jquery.caret.js"></script>
	<script src="https://www.solodev.com/_/assets/phone/jquery.mobilePhoneNumber.js"></script>
	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
</body>

</html>