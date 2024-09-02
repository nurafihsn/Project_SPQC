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
		$JAM_e = isset($_GET['JAM_e']) && $_GET['JAM_e'] !== '' ? $_GET['JAM_e'] : NULL;
		$LTW_e = isset($_GET['LTW_e']) && $_GET['LTW_e'] !== '' ? $_GET['LTW_e'] : NULL;
		$TEMP_e = isset($_GET['TEMP_e']) && $_GET['TEMP_e'] !== '' ? $_GET['TEMP_e'] : NULL;
		$SiO2_e = isset($_GET['SiO2_e']) && $_GET['SiO2_e'] !== '' ? $_GET['SiO2_e'] : NULL;
		$Al2O3_e = isset($_GET['Al2O3_e']) && $_GET['Al2O3_e'] !== '' ? $_GET['Al2O3_e'] : NULL;
		$Fe2O3_e = isset($_GET['Fe2O3_e']) && $_GET['Fe2O3_e'] !== '' ? $_GET['Fe2O3_e'] : NULL;
		$CaO_e = isset($_GET['CaO_e']) && $_GET['CaO_e'] !== '' ? $_GET['CaO_e'] : NULL;
		$MgO_e = isset($_GET['MgO_e']) && $_GET['MgO_e'] !== '' ? $_GET['MgO_e'] : NULL;
		$SO3_e = isset($_GET['SO3_e']) && $_GET['SO3_e'] !== '' ? $_GET['SO3_e'] : NULL;
		$K2O_e = isset($_GET['K2O_e']) && $_GET['K2O_e'] !== '' ? $_GET['K2O_e'] : NULL;
		$Na2O_e = isset($_GET['Na2O_e']) && $_GET['Na2O_e'] !== '' ? $_GET['Na2O_e'] : NULL;
		$Cl2_e = isset($_GET['Cl2_e']) && $_GET['Cl2_e'] !== '' ? $_GET['Cl2_e'] : NULL;
		$FCaO_e = isset($_GET['FCaO_e']) && $_GET['FCaO_e'] !== '' ? $_GET['FCaO_e'] : NULL;
		$WARNA_e = isset($_GET['WARNA_e']) && $_GET['WARNA_e'] !== '' ? $_GET['WARNA_e'] : NULL;
		$FISIK_e = isset($_GET['FISIK_e']) && $_GET['FISIK_e'] !== '' ? $_GET['FISIK_e'] : NULL;
		$SILO_e = isset($_GET['SILO_e']) && $_GET['SILO_e'] !== '' ? $_GET['SILO_e'] : NULL;
		$TUJUAN_e = isset($_GET['TUJUAN_e']) && $_GET['TUJUAN_e'] !== '' ? $_GET['TUJUAN_e'] : NULL;
		$BERAT_sampel_e = isset($_GET['BERAT_sampel_e']) && $_GET['BERAT_sampel_e'] !== '' ? $_GET['BERAT_sampel_e'] : NULL;
		$LOLOS_ayakan_e = isset($_GET['LOLOS_ayakan_e']) && $_GET['LOLOS_ayakan_e'] !== '' ? $_GET['LOLOS_ayakan_e'] : NULL;
		$id_e = isset($_GET['id_e']) ? $_GET['id_e'] : NULL;

		$sql = "UPDATE cr_4 SET JAM=?, LTW=?, TEMP=?, WARNA=?, FISIK=?, SILO=?, TUJUAN=?, BERAT_sampel=?, LOLOS_ayakan=?, SiO2=?, Al2O3=?, Fe2O3=?, CaO=?, MgO=?, SO3=?, K2O=?, Na2O=?, Cl2=?, FCaO=? WHERE id=?";
		$stmt = mysqli_prepare($conn, $sql);

		if ($stmt === false) {
		    die("Error preparing the SQL statement: " . mysqli_error($conn));
		} 

		mysqli_stmt_bind_param($stmt,"sssssssddddddddddddi",  $JAM_e, $LTW_e, $TEMP_e,$WARNA_e, $FISIK_e, $SILO_e, $TUJUAN_e, $BERAT_sampel_e, $LOLOS_ayakan_e, $SiO2_e, $Al2O3_e, $Fe2O3_e, $CaO_e, $MgO_e, $SO3_e, $K2O_e, $Na2O_e, $Cl2_e, $FCaO_e, $id_e);

		if (mysqli_stmt_execute($stmt)) {
		    echo "<script>window.location = 'cr.php'</script>";
		} else {
		    echo "Failed to update the record. Error: " . mysqli_stmt_error($stmt);
		}

		mysqli_stmt_close($stmt);
}



	
$jumlahDataPerhalaman = 24;

$halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;

if (isset($_GET['awal']) && isset($_GET['akhir'])) {
    $awal = $_GET['awal'];
    $akhir = $_GET['akhir'];
    $sql_filtered = "SELECT * FROM cr_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'";
} elseif (isset($_GET['kemarin'])) {
    $sql_filtered = "SELECT * FROM cr_4 WHERE TANGGAL = CURDATE() - INTERVAL 1 DAY";
}
else {
    $sql_filtered = "SELECT * FROM cr_4 WHERE TANGGAL = CURDATE()";
}

$result_filtered = mysqli_query($conn, $sql_filtered);
$jumlahData = mysqli_num_rows($result_filtered);

$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

$sql = "$sql_filtered LIMIT $awalData, $jumlahDataPerhalaman";
$q = mysqli_query($conn, $sql);
?>
		<center style="font-family: Arial, sans-serif; font-size: 24px; font-weight: bold; color: #333333; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
		    <label>CLINKER Indarung 4</label>
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
		

	<table class="adminlist mb-3 " border="1" width="500" cellpadding="5"  >
		<thead>

					<tr class="text-center" >
			            <th rowspan="1"></th><th colspan="9">CLINKER</th><th  colspan="11">OKSIDA</th><th colspan="1"></th><th colspan="8"></th>
			        </tr>

				<tr bgcolor="#8080FF" style="color:#FFFFFF">
			        <th></th>
			        <th>LTW</th><th>TEMP</th> <th>LSF</th><th>SIM</th><th>ALM</th><th>C3S</th><th>C2S</th><th>C3A</th><th>C4AF</th><th>SiO2</th><th>Al2O3</th><th>Fe2O3</th><th>CaO</th><th>MgO</th><th>SO3</th><th>K2O</th><th>Na2O</th><th>Cl2</th><th>FCaO</th><th>SUM</th><th>ALKALI</th><th>LP</th><th>CI</th><th>GI</th><th>BF</th><th>BI</th><th>ASR</th><th>DoS</th><th>Est.BZT</th>
			        
			    </tr> 
			    
				</thead>
			    

			     <tr bgcolor="YELLOW" style="color:BLACK">
				    <th>COUNT</th>
				    <?php
				    // Periksa apakah variabel $_GET['TANGGAL'] terdefinisi
				    if(isset($_GET['awal']) && isset($_GET['akhir'])){
				        $awal = $_GET['awal'];
			        	$akhir = $_GET['akhir'];

				      $count_query = mysqli_query($conn, "SELECT COUNT(LTW) AS count_LTW, COUNT(TEMP) AS count_TEMP, COUNT(LSF) AS count_lsf, COUNT(SIM) AS count_sim, COUNT(ALM) AS count_alm, COUNT(C3S) AS count_c3s, COUNT(C2S) AS count_c2s, COUNT(C3A) AS count_c3a, COUNT(C4AF) AS count_c4af, COUNT(SiO2) AS count_sio2, COUNT(Al2O3) AS count_al2o3, COUNT(Fe2O3) AS count_fe2o3, COUNT(CaO) AS count_cao, COUNT(MgO) AS count_mgo, COUNT(SO3) AS count_so3, COUNT(K2O) AS count_k2o, COUNT(Na2O) AS count_na2o, COUNT(Cl2) AS count_cl2, COUNT(FCaO) AS count_fcao, COUNT(SUM) AS count_sum, COUNT(ALKALI) AS count_alkali, COUNT(LP) AS count_lp, COUNT(CI) AS count_ci, COUNT(GI) AS count_gi, COUNT(BF) AS count_bf, COUNT(BI) AS count_bi, COUNT(ASR) AS count_asr, COUNT(DoS) AS count_dos, COUNT(EstBZT) AS count_est FROM cr_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
				       
				        $count_result = mysqli_fetch_assoc($count_query);

				        foreach ($count_result as $count) {
				            echo "<td>".$count."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM cr_4");
				        while($data = mysqli_fetch_array($sql)){
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
			       $min_query = mysqli_query($conn, "SELECT MIN(LTW) AS min_LTW, MIN(TEMP) AS min_TEMP, MIN(LSF) AS min_lsf, MIN(SIM) AS min_sim, MIN(ALM) AS min_alm, MIN(C3S) AS min_c3s, MIN(C2S) AS min_c2s, MIN(C3A) AS min_c3a, MIN(C4AF) AS min_c4af, MIN(SiO2) AS min_sio2, MIN(Al2O3) AS min_al2o3, MIN(Fe2O3) AS min_fe2o3, MIN(CaO) AS min_cao, MIN(MgO) AS min_mgo, MIN(SO3) AS min_so3, MIN(K2O) AS min_k2o, MIN(Na2O) AS min_na2o, MIN(Cl2) AS min_cl2, MIN(FCaO) AS min_fcao, MIN(SUM) AS min_sum, MIN(ALKALI) AS min_alkali, MIN(LP) AS min_lp, MIN(CI) AS min_ci, MIN(GI) AS min_gi, MIN(BF) AS min_bf, MIN(BI) AS min_bi, MIN(ASR) AS min_asr, MIN(DoS) AS min_dos, MIN(EstBZT) AS min_est FROM cr_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

			       $min_result = mysqli_fetch_assoc($min_query);

				        foreach ($min_result as $min) {
				            echo "<td>".$min."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM cr_4");
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
			        $average_query = mysqli_query($conn, "SELECT AVG(LTW) AS avg_LTW, AVG(TEMP) AS avg_TEMP, AVG(LSF) AS avg_lsf, AVG(SIM) AS avg_sim, AVG(ALM) AS avg_alm, AVG(C3S) AS avg_c3s, AVG(C2S) AS avg_c2s, AVG(C3A) AS avg_c3a, AVG(C4AF) AS avg_c4af, AVG(SiO2) AS avg_sio2, AVG(Al2O3) AS avg_al2o3, AVG(Fe2O3) AS avg_fe2o3, AVG(CaO) AS avg_cao, AVG(MgO) AS avg_mgo, AVG(SO3) AS avg_so3, AVG(K2O) AS avg_k2o, AVG(Na2O) AS avg_na2o, AVG(Cl2) AS avg_cl2, AVG(FCaO) AS avg_fcao, AVG(SUM) AS avg_sum, AVG(ALKALI) AS avg_alkali, AVG(LP) AS avg_lp, AVG(CI) AS avg_ci, AVG(GI) AS avg_gi, AVG(BF) AS avg_bf, AVG(BI) AS avg_bi, AVG(ASR) AS avg_asr, AVG(DoS) AS avg_dos, AVG(EstBZT) AS avg_est FROM cr_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

			        $average_result = mysqli_fetch_assoc($average_query);

				        foreach ($average_result as $average) {
				            echo "<td>".number_format($average, 2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM cr_4");
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
			        $max_query = mysqli_query($conn, "SELECT MAX(LTW) AS max_LTW, MAX(TEMP) AS max_TEMP, MAX(LSF) AS max_lsf, MAX(SIM) AS max_sim, MAX(ALM) AS max_alm, MAX(C3S) AS max_c3s, MAX(C2S) AS max_c2s, MAX(C3A) AS max_c3a, MAX(C4AF) AS max_c4af, MAX(SiO2) AS max_sio2, MAX(Al2O3) AS max_al2o3, MAX(Fe2O3) AS max_fe2o3, MAX(CaO) AS max_cao, MAX(MgO) AS max_mgo, MAX(SO3) AS max_so3, MAX(K2O) AS max_k2o, MAX(Na2O) AS max_na2o, MAX(Cl2) AS max_cl2, MAX(FCaO) AS max_fcao, MAX(SUM) AS max_sum, MAX(ALKALI) AS max_alkali, MAX(LP) AS max_lp, MAX(CI) AS max_ci, MAX(GI) AS max_gi, MAX(BF) AS max_bf, MAX(BI) AS max_bi, MAX(ASR) AS max_asr, MAX(DoS) AS max_dos, MAX(EstBZT) AS max_est FROM cr_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
			         $max_result = mysqli_fetch_assoc($max_query);
				        foreach ($max_result as $max) {
				            echo "<td>".$max."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM cr_4");
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
			       $sd_query = mysqli_query($conn, "SELECT STDDEV(LTW) AS stddev_LTW, STDDEV(TEMP) AS stddev_TEMP, STDDEV(LSF) AS stddev_lsf, STDDEV(SIM) AS stddev_sim, STDDEV(ALM) AS stddev_alm, STDDEV(C3S) AS stddev_c3s, STDDEV(C2S) AS stddev_c2s, STDDEV(C3A) AS stddev_c3a, STDDEV(C4AF) AS stddev_c4af, STDDEV(SiO2) AS stddev_sio2, STDDEV(Al2O3) AS stddev_al2o3, STDDEV(Fe2O3) AS stddev_fe2o3, STDDEV(CaO) AS stddev_cao, STDDEV(MgO) AS stddev_mgo, STDDEV(SO3) AS stddev_so3, STDDEV(K2O) AS stddev_k2o, STDDEV(Na2O) AS stddev_na2o, STDDEV(Cl2) AS stddev_cl2, STDDEV(FCaO) AS stddev_fcao, STDDEV(SUM) AS stddev_sum, STDDEV(ALKALI) AS stddev_alkali, STDDEV(LP) AS stddev_lp, STDDEV(CI) AS stddev_ci, STDDEV(GI) AS stddev_gi, STDDEV(BF) AS stddev_bf, STDDEV(BI) AS stddev_bi, STDDEV(ASR) AS stddev_asr, STDDEV(DoS) AS stddev_dos, STDDEV(EstBZT) AS stddev_est FROM cr_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");


			        $sd_result = mysqli_fetch_assoc($sd_query);
				        foreach ($sd_result as $sd) {
				            echo "<td>".number_format($sd, 2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM cr_4");
				        while($data = mysqli_fetch_array($sql)){
				        }
				    }
				    ?>
			    </tr>  
			</table>
			<table class="adminlist mb-3" border="1" width="500" cellpadding="5">
			    <tr bgcolor="#8080FF" style="color:#FFFFFF">
				    <th></th>
				    <th>FCaO</th>
				    <th>LSF</th>
				    <th>C3S</th>
				    <th>C3A</th>
				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>DATA IN</th>
					<?php
					if (isset($_GET['awal']) && isset($_GET['akhir'])) {
					    $awal = $_GET['awal'];
					    $akhir = $_GET['akhir'];

					   $datain_query = mysqli_query($conn, "SELECT 
				            COUNT(IF(FCaO > 1.8, 1, NULL)) AS datain_fcao,
				            COUNT(IF(LSF > 96.9, 1, NULL)) AS datain_lsfmax,
				            COUNT(IF(LSF < 95, 1, NULL)) AS datain_lsfmin,
				            COUNT(IF(C3S < 56, 1, NULL)) AS datain_c3s,
				            COUNT(IF(C3A < 7, 1, NULL)) AS datain_c3amin,
				            COUNT(IF(C3A > 11, 1, NULL)) AS datain_c3amax
				            FROM cr_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

				        $datain_result = mysqli_fetch_assoc($datain_query);
				        $kolom = array("FCaO", "LSF", "C3S", "C3A");
				        foreach ($kolom as $nama_kolom) {
				            $count = $count_result["count_" . strtolower($nama_kolom)];
				            $datain_lsfmax = isset($datain_result["datain_lsfmax"]) ? $datain_result["datain_lsfmax"] : 0;
				            $datain_lsfmin = isset($datain_result["datain_lsfmin"]) ? $datain_result["datain_lsfmin"] : 0;
				            $datain_c3amax = isset($datain_result["datain_c3amax"]) ? $datain_result["datain_c3amax"] : 0;
				            $datain_c3amin = isset($datain_result["datain_c3amin"]) ? $datain_result["datain_c3amin"] : 0;
				            $datain = isset($datain_result["datain_" . strtolower($nama_kolom)]) ? $datain_result["datain_" . strtolower($nama_kolom)] : 0;
				            if ($nama_kolom == "LSF") {
				                $hasil = $count - $datain_lsfmax - $datain_lsfmin;
				            } else if ($nama_kolom == "C3A") {
				                $hasil = $count - $datain_c3amax - $datain_c3amin;
				            } else {
				                $hasil = $count - $datain;
				            }
					        echo "<td>" . $hasil . "</td>";
					    }
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
				            COUNT(IF(FCaO > 1.8, 1, NULL)) AS datain_fcao,
				            COUNT(IF(LSF > 96.9, 1, NULL)) AS datain_lsfmax,
				            COUNT(IF(LSF < 95, 1, NULL)) AS datain_lsfmin,
				            COUNT(IF(C3S < 56, 1, NULL)) AS datain_c3s,
				            COUNT(IF(C3A < 7, 1, NULL)) AS datain_c3amin,
				            COUNT(IF(C3A > 11, 1, NULL)) AS datain_c3amax
				            FROM cr_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

				        $datain_result = mysqli_fetch_assoc($datain_query);
				        $kolom = array("FCaO", "LSF", "C3S", "C3A");
				        foreach ($kolom as $nama_kolom) {
				            $count = $count_result["count_" . strtolower($nama_kolom)];
				            $datain_lsfmax = isset($datain_result["datain_lsfmax"]) ? $datain_result["datain_lsfmax"] : 0;
				            $datain_lsfmin = isset($datain_result["datain_lsfmin"]) ? $datain_result["datain_lsfmin"] : 0;
				            $datain_c3amax = isset($datain_result["datain_c3amax"]) ? $datain_result["datain_c3amax"] : 0;
				            $datain_c3amin = isset($datain_result["datain_c3amin"]) ? $datain_result["datain_c3amin"] : 0;
				            $datain = isset($datain_result["datain_" . strtolower($nama_kolom)]) ? $datain_result["datain_" . strtolower($nama_kolom)] : 0;
				            if ($nama_kolom == "LSF") {
				                $hasil = $count - $datain_lsfmax - $datain_lsfmin;
				            } else if ($nama_kolom == "C3A") {
				                $hasil = $count - $datain_c3amax - $datain_c3amin;
				            } else {
				                $hasil = $count - $datain;
				            }
				            if ($count != 0) {
							  $persentase = ($hasil / $count) * 100;
							} else {
							   $persentase = 0; 
							}				            
						echo "<td>" . number_format($persentase, 2) . "%</td>";
				        }
				    }
				    ?>
				</tr>
			</table>



						



	<div class="container">
	    <div class="row">
	        <div class="col-sm-3">
	            <div class="form-group">
	                <a href="" class="btn btn-primary" data-toggle="modal" data-target="#addData"><i class="fa fa-fw fa-plus-circle"></i> Add Data</a>
	            </div>
	            <div class="form-group">
	                <a href="exportcr.php" class="btn btn-primary" > Download </a>
	            </div>
	        </div>        
	    </div>
	</div>
	    


		<div>
			 <table class="table table-striped table-bordered table-hover">
				<thead>

					<tr class="text-center" >
			            <th colspan="2"></th><th  colspan="9">CLINKER</th><th  colspan="11">OKISDA</th><th colspan="1"></th><th colspan="8"></th><th colspan="2">VISUAL</th> <th colspan="2">PENGISIAN</th><th colspan="3">SIEVE 1.18mm</th>
			        </tr>

					<tr class="bg-primary text-white">
						
					<th>Tanggal</th><th>Jam</th><th>LTW</th><th>TEMP</th> <th>LSF</th> <th>SIM</th> <th>ALM</th> <th>C3S</th><th>C2S</th> <th>C3A</th> <th>C4AF</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th> <th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>FCaO</th><th>SUM</th><th>Alkali</th> <th>LP</th><th>CI</th><th>GI</th><th>BF</th><th>BI</th> <th>ASR</th><th>DoS</th> <th>Est.BZT</th> <th>WARNA</th> <th>FISIK</th><th>SILO</th><th>TUJUAN</th> <th>BERAT</th> <th>LOLOS</th> <th>% LOLOS</th><th>KETERANGAN</th> <th>Report</th>

						<th class="text-center">Action</th>
					</tr>
				</thead>

				<tbody>
					    <?php
					    $n = $awalData;
					    while ($d = mysqli_fetch_array($q)) {
					    	
					   $lsf = library::calculateLsf($d);
							$sim = library::calculateSim($d);
							$alm = library::calculateAlm($d);
							$alkali = library::calculateAlkali($d);
							$c3s = library::calculateC3s($d);
							$c3a = library::calculateC3a($d);



						$c2s = null;
						if (!empty($d['SiO2'])) {
						    $c2s = 2.867 * $d['SiO2'] - 0.754 * $c3s;
						}
						$c2s = !is_null($c2s) ? number_format((float)$c2s, 2, '.', '') : null;

						$c4af = null;
						if (!empty($d['Fe2O3'])) {
						    $c4af = 3.043 * $d['Fe2O3'];
						}
						$c4af = !is_null($c4af) ? number_format((float)$c4af, 2, '.', '') : null;

						$sum = null;
						if (!empty($d['SiO2'])) {
						    $sum = $d['SiO2'] + $d['Al2O3'] + $d['Fe2O3'] + $d['CaO']  + $d['MgO']  + $d['SO3'] + $d['K2O']  + $d['Na2O'] + $d['Cl2'];
						}
						$sum = !is_null($sum) ? number_format((float)$sum, 2, '.', '') : null;
						

						$lp = null;
						if (!empty($alm)) {
						    if ($alm >= 1.38) {
						        $lp = 3 * $d['Al2O3'] + 2.2 * $d['Fe2O3'] + $d['MgO'] + $d['K2O'] + $d['Na2O'];
						    } else {
						        $lp = 8.5 * $d['Al2O3'] - 5.22 * $d['Fe2O3'] + $d['MgO'] + $d['K2O'] + $d['Na2O'];
						    }
						    $lp = !is_null($lp) ? number_format((float)$lp, 2, '.', '') : null;
						}

						$ci = null;
						if (!empty($c3a)) {
						    $ci = $c3a + $c4af + 0.2 * $c2s + 2 * $d['Fe2O3'];
						}
						$ci = !is_null($ci) ? number_format((float)$ci, 2, '.', '') : null;

						$gi = null;
						if (!empty($c3s)) {
						    $gi = $c3s / 4.7 + $c2s / 1.8 + $c3a / 2.9 + $c4af / 2;
						}
						$gi = !is_null($gi) ? number_format((float)$gi, 2, '.', '') : null;

						$bf = null;
						if (!empty($lsf)) {
						    $bf = $lsf + (10 * $sim) - (3 * ($d['MgO'] + ($d['K2O'] * (61.98 / 94.2))));
						}
						$bf = !is_null($bf) ? number_format((float)$bf, 2, '.', '') : null;

						$bi = null;
						if (!empty($c3s)) {
						    $bi = $c3s / ($c3a + $c4af);
						}
						$bi = !is_null($bi) ? number_format((float)$bi, 2, '.', '') : null;

						$asr = null;
						if (!empty($d['K2O'])) {
						    $asr = (($d['K2O'] / 94) + ($d['Na2O'] / 62) - ($d['Cl2'] / 71)) / ($d['SO3'] / 80);
						}
						$asr = !is_null($asr) ? number_format((float)$asr, 2, '.', '') : null;

						$dos = null;
						if (!empty($d['K2O'])) {
						    $denominator = (1.292 * $d['Na2O']) + (0.85 * $d['K2O']);
						    if ($denominator != 0) {
						        $dos = $d['SO3'] / $denominator;
						    }
						}
						$dos = !is_null($dos) ? number_format((float)$dos, 2, '.', '') : null;

						$est = null;
						if (!empty($d['K2O'])) {
						    $est = 1300 + (4.51 * $c3s) - ((3.74 * $c3a) + (12.64 * $c4af));
						}
						$est = !is_null($est) ? number_format((float)$est, 2, '.', '') : null;

						$persen = null;
						if (!empty($d['LOLOS_ayakan']) && !empty($d['BERAT_sampel'])) {
						    $persen = ($d['LOLOS_ayakan'] / $d['BERAT_sampel']) * 0.9695 - 0.0092;
						}
						$persen = !is_null($persen) ? number_format($persen * 100, 2) . '%' : null;

					    $update_query = "UPDATE cr_4 SET LSF=" . (!is_null($lsf) ? "'$lsf'" : "NULL") . ", SIM=" . (!is_null($sim) ? "'$sim'" : "NULL") . ", ALM=" . (!is_null($alm) ? "'$alm'" : "NULL") . ", SUM=" . (!is_null($sum) ? "'$sum'" : "NULL") . ", ALKALI=" . (!is_null($alkali) ? "'$alkali'" : "NULL") . ", C3S=" . (!is_null($c3s) ? "'$c3s'" : "NULL") . ", C2S=" . (!is_null($c2s) ? "'$c2s'" : "NULL") . ", C3A=" . (!is_null($c3a) ? "'$c3a'" : "NULL") . ", C4AF=" . (!is_null($c4af) ? "'$c4af'" : "NULL") . ", LP=" . (!is_null($lp) ? "'$lp'" : "NULL") . ", CI=" . (!is_null($ci) ? "'$ci'" : "NULL") . ", GI=" . (!is_null($gi) ? "'$gi'" : "NULL") . ", BF=" . (!is_null($bf) ? "'$bf'" : "NULL") . ", BI=" . (!is_null($bi) ? "'$bi'" : "NULL") . ", ASR=" . (!is_null($asr) ? "'$asr'" : "NULL") . ", DoS=" . (!is_null($dos) ? "'$dos'" : "NULL") . ", EstBZT=" . (!is_null($est) ? "'$est'" : "NULL") . ", PERSEN_lolos=" . (!is_null($persen) ? "'$persen'" : "NULL") . " WHERE id=" . $d['id'];


					        if (mysqli_query($conn, $update_query)) {
							        echo " ";
							    } else {
							        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
							    }
					      
					        $w_fcao = '';
					        if ($d['FCaO'] > $configs['FCaOcr4']['max']  ) {
					            $w_fcao = 'text-danger';
					        }
					        $w_bi = '';
					        if ($bi > 3 ) {
					            $w_bi = 'text-danger';
					        }
					        $w_est = '';
							if ($est < 1350 || $est > 1450) {
							    $w_est = 'text-danger';
							}
							$w_dos = '';
							if ($dos < 0.8 || $dos > 0.9) {
							    $w_dos = 'text-danger';
							}
							$w_gi = '';
					        if ($gi > 25 ) {
					            $w_gi = 'text-danger';
					        }
					        $w_bf = '';
					        if ($bf > 120 ) {
					            $w_bf = 'text-danger';
					        }
					        $w_ci = '';
							if ($ci < 25 || $ci > 30) {
							    $w_ci = 'text-danger';
							}
							$w_lp = '';
							if ($lp < 25 || $lp > 27) {
							    $w_lp = 'text-danger';
							}
							$w_alkali = '';
					        if ($alkali > $configs['ALKALIcr4']['max']  ) {
					            $w_alkali = 'text-danger';
					        }
					        $w_c3s = '';
							if ($c3s < $configs['C3Scr4']['min']  || $c3s > $configs['C3Scr4']['max'] ) {
							    $w_c3s = 'text-danger';
							}
							$w_alm = '';
							if ($alm < $configs['ALMcr4']['min']  || $alm > $configs['ALMcr4']['max'] ) {
							    $w_alm = 'text-danger';
							}
					        $w_sim = '';
							if ($sim < $configs['SIMcr4']['min']  || $sim > $configs['SIMcr4']['max'] ) {
							    $w_sim = 'text-danger';
							}
							$w_lsf = '';
							if ($lsf < $configs['LSFcr4']['min']  || $lsf > $configs['LSFcr4']['max'] ) {
							    $w_lsf = 'text-danger';
							}
							$w_ltw = '';
							if ($d['LTW'] < $configs['LTWcr4']['min'] || $d['LTW'] > $configs['LTWcr4']['max']) {
							    $w_ltw = 'text-danger';
							}
							$w_c3a = '';
							if ($c3a < $configs['C3Acr4']['min'] || $c3a > $configs['C3Acr4']['max']) {
							    $w_c3a = 'text-danger';
							}

 
					    ?>

					        	<td><?php echo htmlspecialchars($d['TANGGAL']); ?></td>
					            <td><?php echo htmlspecialchars($d['JAM']); ?></td>
					            <td class="<?php echo $w_ltw; ?>"><?php echo htmlspecialchars($d['LTW']); ?></td>
					            <td><?php echo htmlspecialchars($d['TEMP']); ?></td>
					            <td class="<?php echo $w_lsf; ?>"><?php echo htmlspecialchars($lsf); ?></td>
					            <td class="<?php echo $w_sim; ?>"><?php echo htmlspecialchars($sim); ?></td>
					            <td class="<?php echo $w_alm; ?>"><?php echo htmlspecialchars($alm); ?></td>
					            <td class="<?php echo $w_c3s; ?>"><?php echo htmlspecialchars($c3s); ?></td>
					            <td><?php echo htmlspecialchars($c2s); ?></td>
					            <td class="<?php echo $w_c3a; ?>"><?php echo htmlspecialchars($c3a); ?></td>
					            <td><?php echo htmlspecialchars($c4af); ?></td>
					            <td><?php echo htmlspecialchars($d['SiO2']); ?></td>
					            <td><?php echo htmlspecialchars($d['Al2O3']); ?></td>
					            <td><?php echo htmlspecialchars($d['Fe2O3']); ?></td>
					            <td><?php echo htmlspecialchars($d['CaO']); ?></td>
					            <td><?php echo htmlspecialchars($d['MgO']); ?></td>
					            <td><?php echo htmlspecialchars($d['SO3']); ?></td>
					            <td><?php echo htmlspecialchars($d['K2O']); ?></td>
					            <td><?php echo htmlspecialchars($d['Na2O']); ?></td>
					            <td><?php echo htmlspecialchars($d['Cl2']); ?></td>
					            <td class="<?php echo $w_fcao; ?>"><?php echo htmlspecialchars($d['FCaO']); ?></td>
					            <td><?php echo htmlspecialchars($sum); ?></td>
					            <td class="<?php echo $w_alkali; ?>"><?php echo htmlspecialchars($alkali); ?></td>
					            <td class="<?php echo $w_lp; ?>"><?php echo htmlspecialchars($lp); ?></td>
					            <td class="<?php echo $w_ci; ?>"><?php echo htmlspecialchars($ci); ?></td>
					            <td class="<?php echo $w_gi; ?>"><?php echo htmlspecialchars($gi); ?></td>
					            <td class="<?php echo $w_bf; ?>"><?php echo htmlspecialchars($bf); ?></td>
					            <td class="<?php echo $w_bi; ?>"><?php echo htmlspecialchars($bi); ?></td>
					            <td><?php echo htmlspecialchars($asr); ?></td>
					            <td class="<?php echo $w_dos; ?>"><?php echo htmlspecialchars($dos); ?></td>
					            <td class="<?php echo $w_est; ?>"><?php echo htmlspecialchars($est); ?></td>
					            <td><?php echo htmlspecialchars($d['WARNA']); ?></td>
					            <td><?php echo htmlspecialchars($d['FISIK']); ?></td>
					            <td class="<?php echo $w_silo; ?>"><?php echo htmlspecialchars($d['SILO']); ?></td>
					            <td><?php echo htmlspecialchars($d['TUJUAN']); ?></td>
					            <td><?php echo htmlspecialchars($d['BERAT_sampel']); ?></td>
					            <td><?php echo htmlspecialchars($d['LOLOS_ayakan']); ?></td>
					            <td><?php echo htmlspecialchars($persen); ?></td>
					            <td><?php echo htmlspecialchars($d['KETERANGAN']); ?></td>
					            <td><?php echo htmlspecialchars($d['waktu']); ?> <a><?php echo htmlspecialchars($d['iduser']); ?></a></td>

					            
					            <td align="center">
					                <a href="#" type="button" style="height:34px" class="btn btn-success btn-md  pl-4 pr-4" data-toggle="modal" data-target="#myModal<?php echo $d['id']; ?>"><i class="fa fa-fw fa-edit"></i>Edit</a>
					                <a href="del-cr.php?delId=<?php echo $d['id']; ?>" type="button" class="btn btn-danger" style="height:34px" onClick="return confirm('Are you sure to delete this data?');"><i class="fa fa-fw fa-trash"></i> Delete</a>
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
											$sql = "SELECT * FROM cr_4 where id ='$id' order by id";
											$qr = mysqli_query($conn, $sql);

											//$result = mysqli_query($conn, $query);
											while ($row = mysqli_fetch_array($qr)) {
											?>
 

												<input type="hidden" name="id_e" value="<?php echo $row['id']; ?>">

												<div class="form-group row my-0">
													<label for="JAM" class="col-sm-4 col-form-label">Jam Ke-</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="JAM_e" name="JAM_e" value="<?= $row['JAM']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="LTW" class="col-sm-4 col-form-label">LTW</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="LTW_e" name="LTW_e" value="<?= $row['LTW']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="TEMP" class="col-sm-4 col-form-label">TEMP</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="TEMP_e" name="TEMP_e" value="<?= $row['TEMP']; ?>">
													</div>
												</div>
												
												<div class="form-group row my-0">
													<label for="SiO2" class="col-sm-4 col-form-label">SiO2</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="SiO2_e" name="SiO2_e" value="<?= $row['SiO2']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Al2O3" class="col-sm-4 col-form-label">Al2O3</label>
													<div class="col-sm-8">
														<input type="Al2O3" style="height:30px" class="form-control" id="Al2O3_e" name="Al2O3_e" value="<?= $row['Al2O3']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Fe2O3" class="col-sm-4 col-form-label">Fe2O3</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="Fe2O3_e" name="Fe2O3_e" value="<?= $row['Fe2O3']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="CaO" class="col-sm-4 col-form-label">CaO</label>
													<div class="col-sm-8">
														<input type="CaO" style="height:30px" class="form-control" id="CaO_e" name="CaO_e" value="<?= $row['CaO']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
												    <label for="MgO" class="col-sm-4 col-form-label">MgO</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="MgO_e" name="MgO_e" value="<?= $row['MgO']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="SO3" class="col-sm-4 col-form-label">SO3</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="SO3_e" name="SO3_e" value="<?= $row['SO3']; ?>">
												    </div>
												</div>
												
												<div class="form-group row my-0">
												    <label for="K2O" class="col-sm-4 col-form-label">K2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="K2O_e" name="K2O_e" value="<?= $row['K2O']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="Na2O" class="col-sm-4 col-form-label">Na2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="Na2O_e" name="Na2O_e" value="<?= $row['Na2O']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="Cl2" class="col-sm-4 col-form-label">Cl2</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="Cl2_e" name="Cl2_e" value="<?= $row['Cl2']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="FCaO" class="col-sm-4 col-form-label">FCaO</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="FCaO_e" name="FCaO_e" value="<?= $row['FCaO']; ?>">
												    </div>
												</div>

												<div class="form-group row my-0">
												    <label for="WARNA" class="col-sm-4 col-form-label">WARNA</label>
												    <div class="col-sm-8">
												        <select name="WARNA_e" id="WARNA_e" style="height:30px" class="form-control">
												            <option value=""></option> 
												            <option value="HITAM" <?= ($row['WARNA'] == 'HITAM') ? 'selected' : '' ?>>HITAM</option>
												            <option value="KECOKLATAN" <?= ($row['WARNA'] == 'KECOKLATAN') ? 'selected' : '' ?>>KECOKLATAN</option>
												            <option value="KEKUNINGAN" <?= ($row['WARNA'] == 'KEKUNINGAN') ? 'selected' : '' ?>>KEKUNINGAN</option>
												           
												        </select>
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="FISIK" class="col-sm-4 col-form-label">FISIK</label>
												    <div class="col-sm-8">
												        <select name="FISIK_e" id="FISIK_e" style="height:30px" class="form-control">
												            <option value=""></option> 
												            <option value="BAGUS" <?= ($row['FISIK'] == 'BAGUS') ? 'selected' : '' ?>>BAGUS</option>
												            <option value="BERCOATING" <?= ($row['FISIK'] == 'BERCOATING') ? 'selected' : '' ?>>BERCOATING</option>
												            <option value="MENTAH" <?= ($row['FISIK'] == 'MENTAH') ? 'selected' : '' ?>>MENTAH</option>
												           
												        </select>
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="SILO" class="col-sm-4 col-form-label">SILO</label>
												    <div class="col-sm-8">
												        <select name="SILO_e" id="SILO_e" style="height:30px" class="form-control">
												            <option value=""></option> 
												            <option value="3B" <?= ($row['SILO'] == '3B') ? 'selected' : '' ?>>3B</option>
												            <option value="3C" <?= ($row['SILO'] == '3C') ? 'selected' : '' ?>>3C</option>
												            <option value="INT" <?= ($row['SILO'] == 'INT') ? 'selected' : '' ?>>INT</option>
												            <option value="3B+INT" <?= ($row['SILO'] == '3B+INT') ? 'selected' : '' ?>>3B+INT</option>
												            <option value="3C+INT" <?= ($row['SILO'] == '3C+INT') ? 'selected' : '' ?>>3C+INT</option>
												           
												        </select>
												    </div>
												 </div>
												 <div class="form-group row my-0">
												    <label for="TUJUAN" class="col-sm-4 col-form-label">TUJUAN</label>
												    <div class="col-sm-8">
												        <select name="TUJUAN_e" id="TUJUAN_e" style="height:30px" class="form-control">
												            <option value=""></option> 
												            <option value="CM" <?= ($row['TUJUAN'] == 'CM') ? 'selected' : '' ?>>CM</option>
												            <option value="EXPORT" <?= ($row['TUJUAN'] == 'EXPORT') ? 'selected' : '' ?>>EXPORT</option>
												            <option value="DUMAI" <?= ($row['TUJUAN'] == 'DUMAI') ? 'selected' : '' ?>>DUMAI</option>
												            <option value="IND2&3" <?= ($row['TUJUAN'] == 'IND2&3') ? 'selected' : '' ?>>IND2&3</option>
												            <option value="IND5" <?= ($row['TUJUAN'] == 'IND5') ? 'selected' : '' ?>>IND5</option>
												            <option value="IND6" <?= ($row['TUJUAN'] == 'IND6') ? 'selected' : '' ?>>IND6</option>
												            <option value="TPA/STG" <?= ($row['TUJUAN'] == 'TPA/STG') ? 'selected' : '' ?>>TPA/STG</option>
												        </select>
												    </div>
												</div>
											
												<div class="form-group row my-0">
													<label for="BERAT_sampel" class="col-sm-4 col-form-label">BERAT SAMPEL</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="BERAT_sampel_e" name="BERAT_sampel_e" value="<?= $row['BERAT_sampel']; ?>">
													</div>
												</div>
												<div class="form-group row my-0">
													<label for="LOLOS_ayakan" class="col-sm-4 col-form-label">LOLOS AYAKAN</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="LOLOS_ayakan_e" name="LOLOS_ayakan_e" value="<?= $row['LOLOS_ayakan']; ?>">
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
	$JAM = !empty($_POST['JAM']) ? $_POST['JAM'] : NULL;
	$LTW = !empty($_POST['LTW']) ? $_POST['LTW'] : NULL;
	$TEMP = !empty($_POST['TEMP']) ? $_POST['TEMP'] : NULL;
	$SiO2 = !empty($_POST['SiO2']) ? $_POST['SiO2'] : NULL;
	$Al2O3 = !empty($_POST['Al2O3']) ? $_POST['Al2O3'] : NULL;
	$Fe2O3 = !empty($_POST['Fe2O3']) ? $_POST['Fe2O3'] : NULL;
	$CaO = !empty($_POST['CaO']) ? $_POST['CaO'] : NULL;
	$MgO = !empty($_POST['MgO']) ? $_POST['MgO'] : NULL;
	$SO3 = !empty($_POST['SO3']) ? $_POST['SO3'] : NULL;
	$K2O = !empty($_POST['K2O']) ? $_POST['K2O'] : NULL;
	$Na2O = !empty($_POST['Na2O']) ? $_POST['Na2O'] : NULL;
	$Cl2 = !empty($_POST['Cl2']) ? $_POST['Cl2'] : NULL;
	$FCaO = !empty($_POST['FCaO']) ? $_POST['FCaO'] : NULL;
	$WARNA = !empty($_POST['WARNA']) ? $_POST['WARNA'] : NULL;
	$FISIK = !empty($_POST['FISIK']) ? $_POST['FISIK'] : NULL;
	$SILO = !empty($_POST['SILO']) ? $_POST['SILO'] : NULL;
	$TUJUAN = !empty($_POST['TUJUAN']) ? $_POST['TUJUAN'] : NULL;
	$BERAT_sampel = !empty($_POST['BERAT_sampel']) ? $_POST['BERAT_sampel'] : NULL;
	$LOLOS_ayakan = !empty($_POST['LOLOS_ayakan']) ? $_POST['LOLOS_ayakan'] : NULL;

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
	                      
	                        $tanggal = mysqli_real_escape_string($conn, $tanggal);
	                        $JAM = mysqli_real_escape_string($conn, $JAM);
	                       
	                       $sql = "INSERT INTO cr_4 (TANGGAL, JAM, LTW, TEMP, SiO2, Al2O3, Fe2O3, CaO, MgO, SO3, K2O, Na2O, Cl2, FCaO, WARNA, FISIK, SILO, TUJUAN, BERAT_sampel, LOLOS_ayakan, waktu, iduser) 
        						VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
					    $stmt = mysqli_prepare($conn, $sql);

					    if ($stmt) {
					       mysqli_stmt_bind_param($stmt, "ssssddddddddddssssddss", $tanggal, $JAM, $LTW, $TEMP, $SiO2, $Al2O3, $Fe2O3, $CaO, $MgO, $SO3, $K2O, $Na2O, $Cl2, $FCaO, $WARNA, $FISIK, $SILO, $TUJUAN, $BERAT_sampel, $LOLOS_ayakan, $waktu, $username);

					        mysqli_stmt_execute($stmt);

					        mysqli_stmt_close($stmt);

					        echo "<script>window.location = 'cr.php'</script>";
					    } else {
					        echo "Error: " . mysqli_error($conn);
					    }
					}

	                    $sql = "SELECT * FROM cr_4 WHERE TANGGAL = CURDATE()";
	                    $q = mysqli_query($conn, $sql);
	                ?>


					<div class="container">
						<form method="POST" onsubmit="return validateForm()">

							<div class="form-group row my-0">
								<label for="JAM" class="col-sm-4 col-form-label">Jam Ke-</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="JAM" name="JAM" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="LTW" class="col-sm-4 col-form-label">LTW</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="LTW" name="LTW" placeholder="Enter LTW" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="TEMP" class="col-sm-4 col-form-label">TEMP</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="TEMP" name="TEMP" placeholder="Enter TEMP">
								</div>
							</div>
							
							<div class="form-group row my-0">
								<label for="SiO2" class="col-sm-4 col-form-label">SiO2</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="SiO2" name="SiO2" placeholder="Enter SiO2" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="Al2O3" class="col-sm-4 col-form-label">Al2O3</label>
								<div class="col-sm-8">
									<input type="Al2O3" style="height:30px" class="form-control" id="Al2O3" name="Al2O3" placeholder="Enter Al2O3" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="Fe2O3" class=" col-sm-4 col-form-label">Fe2O3</label>
								<div class="col-sm-8">
									<input type="Fe2O3" style="height:30px" class="form-control" id="Fe2O3" name="Fe2O3" placeholder="Enter Fe2O3" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="CaO" class="col-sm-4 col-form-label">CaO</label>
								<div class="col-sm-8">
									<input type="CaO" style="height:30px" class="form-control" id="CaO" name="CaO" placeholder="Enter CaO" >
								</div>
							</div>
						
							<div class="form-group row my-0">
							    <label for="MgO" class="col-sm-4 col-form-label">MgO</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="MgO" name="MgO" placeholder="Enter MgO" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="SO3" class="col-sm-4 col-form-label">SO3</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="SO3" name="SO3" placeholder="Enter SO3" >
							    </div>
							</div>
							
							<div class="form-group row my-0">
							    <label for="K2O" class="col-sm-4 col-form-label">K2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="K2O" name="K2O" placeholder="Enter K2O" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="Na2O" class="col-sm-4 col-form-label">Na2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="Na2O" name="Na2O" placeholder="Enter Na2O" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="Cl2" class="col-sm-4 col-form-label">Cl2</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="Cl2" name="Cl2" placeholder="Enter Cl2" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="FCaO" class="col-sm-4 col-form-label">FCaO</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="FCaO" name="FCaO" placeholder="Enter FCaO" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="WARNA" class="col-sm-4 col-form-label">WARNA</label>
							    <div class="col-sm-8">
							        <select name="WARNA" id="WARNA" style="height:30px" class="form-control">
			                            <option value="" ></option>
			                            <option value="HITAM">HITAM</option>
			                            <option value="KECOKLATAN">KECOKLATAN</option>
			                            <option value="KEKUNINGAN">KEKUNINGAN</option>
			                        </select>
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="FISIK" class="col-sm-4 col-form-label">FISIK</label>
							    <div class="col-sm-8">
							        <select name="FISIK" id="FISIK" style="height:30px" class="form-control">
			                            <option value="" ></option>
			                            <option value="BAGUS">BAGUS</option>
			                            <option value="BERCOATING">BERCOATING</option>
			                            <option value="MENTAH">MENTAH</option>
			                        </select>
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="SILO" class="col-sm-4 col-form-label">SILO</label>
							    <div class="col-sm-8">
							        <select name="SILO" id="SILO" style="height:30px" class="form-control">
			                            <option value="" ></option>
			                            <option value="3B">3B</option>
			                            <option value="3C">3C</option>
			                            <option value="INT">INT</option>
			                            <option value="3B+INT">3B+INT</option>
			                            <option value="3C+INT">3C+INT</option>
			                        </select>
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="TUJUAN" class="col-sm-4 col-form-label">TUJUAN</label>
							    <div class="col-sm-8">
							        <select name="TUJUAN" id="TUJUAN" style="height:30px" class="form-control">
			                            <option value="" ></option>
			                            <option value="CM">CM</option>
			                            <option value="EXPORT">EXPORT</option>
			                            <option value="DUMAI">DUMAI</option>
			                            <option value="IND2&3">IND 2&3</option>
			                            <option value="IND5">IND 5</option>
			                            <option value="IND6">IND 6</option>
			                            <option value="TPA/STG">TPA/STG</option>
			                        </select>
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="BERAT_sampel" class="col-sm-4 col-form-label">BERAT SAMPEL</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="BERAT_sampel" name="BERAT_sampel" placeholder="Enter BERAT sampel" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="LOLOS_ayakan" class="col-sm-4 col-form-label">LOLOS AYAKAN</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="LOLOS_ayakan" name="LOLOS_ayakan" placeholder="Enter LOLOS ayakan" >
							    </div>
							</div>
							<div class="form-group mt-4">
								<button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary  pl-4 pr-4"> Save </button>
								<button type="button" class="btn btn-danger pl-4 pr-4" data-dismiss="modal">Close</button>
							</div>
				    </form>
				 </div>
            </div>
        </div>
    </div>
</div>

	<script>
	    function validateForm() {
	    	var LTW = document.getElementById("LTW").value;
	        var TEMP = document.getElementById("TEMP").value;
	        var LOLOS_ayakan = document.getElementById("LOLOS_ayakan").value;
	        var BERAT_sampel = document.getElementById("BERAT_sampel").value;
	        var SiO2 = document.getElementById("SiO2").value;
	        var Al2O3 = document.getElementById("Al2O3").value;
	        var Fe2O3 = document.getElementById("Fe2O3").value;
	        var CaO = document.getElementById("CaO").value;
	        var MgO = document.getElementById("MgO").value;
	        var SO3 = document.getElementById("SO3").value;
	        var K2O = document.getElementById("K2O").value;
	        var Na2O = document.getElementById("Na2O").value;
	        var Cl2 = document.getElementById("Cl2").value;
	         var FCaO = document.getElementById("FCaO").value;

	        var inputs = [LTW, TEMP,SiO2, Al2O3, Fe2O3, CaO, MgO, SO3, K2O, Na2O, Cl2,FCaO, LOLOS_ayakan, BERAT_sampel];

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