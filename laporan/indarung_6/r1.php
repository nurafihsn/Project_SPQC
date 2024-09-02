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
	    $rm90u_e = isset($_GET['rm90u_e']) && $_GET['rm90u_e'] !== '' ? $_GET['rm90u_e'] : NULL;
	    $rm180u_e = isset($_GET['rm180u_e']) && $_GET['rm180u_e'] !== '' ? $_GET['rm180u_e'] : NULL;
	    $H2O_e = isset($_GET['H2O_e']) && $_GET['H2O_e'] !== '' ? $_GET['H2O_e'] : NULL;
	    $LS_act_e = isset($_GET['LS_act_e']) && $_GET['LS_act_e'] !== '' ? $_GET['LS_act_e'] : NULL;
	    $SS_act_e = isset($_GET['SS_act_e']) && $_GET['SS_act_e'] !== '' ? $_GET['SS_act_e'] : NULL;
	    $CL_act_e = isset($_GET['CL_act_e']) && $_GET['CL_act_e'] !== '' ? $_GET['CL_act_e'] : NULL;
	    $IS_act_e = isset($_GET['IS_act_e']) && $_GET['IS_act_e'] !== '' ? $_GET['IS_act_e'] : NULL;
	    $TON_dry_e = isset($_GET['TON_dry_e']) && $_GET['TON_dry_e'] !== '' ? $_GET['TON_dry_e'] : NULL;
	    $LS_qcx_e = isset($_GET['LS_qcx_e']) && $_GET['LS_qcx_e'] !== '' ? $_GET['LS_qcx_e'] : NULL;
	    $SS_qcx_e = isset($_GET['SS_qcx_e']) && $_GET['SS_qcx_e'] !== '' ? $_GET['SS_qcx_e'] : NULL;
	    $CL_qcx_e = isset($_GET['CL_qcx_e']) && $_GET['CL_qcx_e'] !== '' ? $_GET['CL_qcx_e'] : NULL;
	    $IS_qcx_e = isset($_GET['IS_qcx_e']) && $_GET['IS_qcx_e'] !== '' ? $_GET['IS_qcx_e'] : NULL;
	    $LS_set_e = isset($_GET['LS_set_e']) && $_GET['LS_set_e'] !== '' ? $_GET['LS_set_e'] : NULL;
	    $SS_set_e = isset($_GET['SS_set_e']) && $_GET['SS_set_e'] !== '' ? $_GET['SS_set_e'] : NULL;
	    $CL_set_e = isset($_GET['CL_set_e']) && $_GET['CL_set_e'] !== '' ? $_GET['CL_set_e'] : NULL;
	    $IS_set_e = isset($_GET['IS_set_e']) && $_GET['IS_set_e'] !== '' ? $_GET['IS_set_e'] : NULL;
	    $SiO2_e = isset($_GET['SiO2_e']) && $_GET['SiO2_e'] !== '' ? $_GET['SiO2_e'] : NULL;
	    $Al2O3_e = isset($_GET['Al2O3_e']) && $_GET['Al2O3_e'] !== '' ? $_GET['Al2O3_e'] : NULL;
	    $Fe2O3_e = isset($_GET['Fe2O3_e']) && $_GET['Fe2O3_e'] !== '' ? $_GET['Fe2O3_e'] : NULL;
	    $CaO_e = isset($_GET['CaO_e']) && $_GET['CaO_e'] !== '' ? $_GET['CaO_e'] : NULL;
	    $MgO_e = isset($_GET['MgO_e']) && $_GET['MgO_e'] !== '' ? $_GET['MgO_e'] : NULL;
	    $SO3_e = isset($_GET['SO3_e']) && $_GET['SO3_e'] !== '' ? $_GET['SO3_e'] : NULL;
	    $K2O_e = isset($_GET['K2O_e']) && $_GET['K2O_e'] !== '' ? $_GET['K2O_e'] : NULL;
	    $Na2O_e = isset($_GET['Na2O_e']) && $_GET['Na2O_e'] !== '' ? $_GET['Na2O_e'] : NULL;
	    $Cl2_e = isset($_GET['Cl2_e']) && $_GET['Cl2_e'] !== '' ? $_GET['Cl2_e'] : NULL;
	    $LSToPZ_e = isset($_GET['LSToPZ_e']) && $_GET['LSToPZ_e'] !== '' ? $_GET['LSToPZ_e'] : NULL;
	    $id_e = isset($_GET['id_e']) && $_GET['id_e'] !== '' ? $_GET['id_e'] : NULL;

	    $sql = "UPDATE r1_6 SET JAM=?, rm90u=?, rm180u=?, H2O=?, LS_act=?, SS_act=?, CL_act=?, IS_act=?, TON_dry=?, LS_qcx=?, SS_qcx=?, CL_qcx=?, IS_qcx=?, LS_set=?, SS_set=?, CL_set=?, IS_set=?, SiO2=?, Al2O3=?, Fe2O3=?, CaO=?, MgO=?, SO3=?, K2O=?, Na2O=?, Cl2=?, LSToPZ=? WHERE id=?";
	    $stmt = mysqli_prepare($conn, $sql);

	    if ($stmt === false) {
	        die("Error preparing the SQL statement: " . mysqli_error($conn));
	    }

	    mysqli_stmt_bind_param($stmt, "sdddddddddddddddddddddddddsi", $JAM_e, $rm90u_e, $rm180u_e, $H2O_e, $LS_act_e, $SS_act_e, $CL_act_e, $IS_act_e, $TON_dry_e, $LS_qcx_e, $SS_qcx_e, $CL_qcx_e, $IS_qcx_e, $LS_set_e, $SS_set_e, $CL_set_e, $IS_set_e, $SiO2_e, $Al2O3_e, $Fe2O3_e, $CaO_e, $MgO_e, $SO3_e, $K2O_e, $Na2O_e, $Cl2_e, $LSToPZ_e, $id_e);

	    if (mysqli_stmt_execute($stmt)) {
	        echo "<script>window.location = 'r1.php'</script>";
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
    $sql_filtered = "SELECT * FROM r1_6 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'";
} elseif (isset($_GET['kemarin'])) {
    $sql_filtered = "SELECT * FROM r1_6 WHERE TANGGAL = CURDATE() - INTERVAL 1 DAY";
}
 else {
    $sql_filtered = "SELECT * FROM r1_6 WHERE TANGGAL = CURDATE()";
}

$result_filtered = mysqli_query($conn, $sql_filtered);
$jumlahData = mysqli_num_rows($result_filtered);

$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

$sql = "$sql_filtered LIMIT $awalData, $jumlahDataPerhalaman";
$q = mysqli_query($conn, $sql);
?>
		<center style="font-family: Arial, sans-serif; font-size: 24px; font-weight: bold; color: #333333; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
		    <label>RAW MIX Indarung 6</label>
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
			            <th rowspan="1"></th><th  colspan="6">6R1</th><th  colspan="4">Proposi Actual</th><th colspan="1">TON</th><th colspan="4">Setpoint QCX, %Wet</th><th colspan="4">Proporsi SET POINT</th> <th colspan="11">OKSIDA</th><th colspan="1">TON</th>
			        </tr>

				<tr bgcolor="#8080FF" style="color:#FFFFFF">
			        <th></th>
			        <th>LSF</th>
			        <th>SIM</th>
			        <th>ALM</th>
			        <th>90u</th>
			        <th>180u</th>
			        <th>H2O</th>
			        <th>LS</th>
			        <th>SS</th>
			        <th>CL</th>
			        <th>IS</th>
			        <th>dry</th>
			        <th>LS</th>
			        <th>SS</th>
			        <th>CL</th>
			        <th>IS</th>
			        <th>LS</th>
			        <th>SS</th>
			        <th>CL</th>
			        <th>IS</th>
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
			        <th>Emisi CO2</th>

			    </tr> 
			    
				</thead>
			    

			     <tr bgcolor="YELLOW" style="color:BLACK">
				    <th>COUNT</th>
				    <?php
				    // Periksa apakah variabel $_GET['TANGGAL'] terdefinisi
				    if(isset($_GET['awal']) && isset($_GET['akhir'])){
				        $awal = $_GET['awal'];
			        	$akhir = $_GET['akhir'];
				        // Lakukan query untuk menghitung jumlah setiap kolom berdasarkan tanggal yang dipilih
				       $count_query = mysqli_query($conn, "SELECT COUNT(LSF) AS count_lsf, COUNT(SIM) AS count_sim, COUNT(ALM) AS count_alm, COUNT(rm90u) AS count_rm90u, COUNT(rm180u) AS count_rm180u, COUNT(H2O) AS count_h2o, COUNT(LS_act) AS count_ls_act, COUNT(SS_act) AS count_ss_act, COUNT(CL_act) AS count_cl_act, COUNT(IS_act) AS count_is_act, COUNT(TON_dry) AS count_ton_dry, COUNT(LS_qcx) AS count_ls_qcx, COUNT(SS_qcx) AS count_ss_qcx, COUNT(CL_qcx) AS count_cl_qcx, COUNT(IS_qcx) AS count_is_qcx, COUNT(LS_set) AS count_ls_set, COUNT(SS_set) AS count_ss_set, COUNT(CL_set) AS count_cl_set, COUNT(IS_set) AS count_is_set, COUNT(SiO2) AS count_sio2, COUNT(Al2O3) AS count_al2o3, COUNT(Fe2O3) AS count_fe2o3, COUNT(CaO) AS count_cao, COUNT(MgO) AS count_mgo, COUNT(SO3) AS count_so3, COUNT(K2O) AS count_k2o, COUNT(Na2O) AS count_na2o, COUNT(Cl2) AS count_cl2, COUNT(SUM) AS count_sum, COUNT(ALKALI) AS count_alkali, COUNT(TON_emisi) AS count_ton_emisi  FROM r1_6 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
				       
				        $count_result = mysqli_fetch_assoc($count_query);
				        foreach ($count_result as $count) {
				            echo "<td>".$count."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM r1_6");
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
			       $min_query = mysqli_query($conn, "SELECT MIN(LSF) AS min_lsf, MIN(SIM) AS min_sim, MIN(ALM) AS min_alm, MIN(rm90u) AS min_rm90u, MIN(rm180u) AS min_rm180u, MIN(H2O) AS min_h2o, MIN(LS_act) AS min_ls_act, MIN(SS_act) AS min_ss_act, MIN(CL_act) AS min_cl_act, MIN(IS_act) AS min_is_act, MIN(TON_dry) AS min_ton_dry, MIN(LS_qcx) AS min_ls_qcx, MIN(SS_qcx) AS min_ss_qcx, MIN(CL_qcx) AS min_cl_qcx, MIN(IS_qcx) AS min_is_qcx, MIN(LS_set) AS min_ls_set, MIN(SS_set) AS min_ss_set, MIN(CL_set) AS min_cl_set, MIN(IS_set) AS min_is_set, MIN(SiO2) AS min_sio2, MIN(Al2O3) AS min_al2o3, MIN(Fe2O3) AS min_fe2o3, MIN(CaO) AS min_cao, MIN(MgO) AS min_mgo, MIN(SO3) AS min_so3, MIN(K2O) AS min_k2o, MIN(Na2O) AS min_na2o, MIN(Cl2) AS min_cl2, MIN(SUM) AS min_sum, MIN(ALKALI) AS min_alkali, MIN(TON_emisi) AS min_ton_emisi FROM r1_6 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
			       $min_result = mysqli_fetch_assoc($min_query);
				        foreach ($min_result as $min) {
				            echo "<td>".$min."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM r1_6");
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
			      $average_query = mysqli_query($conn, "SELECT AVG(LSF) AS avg_lsf, AVG(SIM) AS avg_sim, AVG(ALM) AS avg_alm, AVG(rm90u) AS avg_rm90u, AVG(rm180u) AS avg_rm180u, AVG(H2O) AS avg_h2o, AVG(LS_act) AS avg_ls_act, AVG(SS_act) AS avg_ss_act, AVG(CL_act) AS avg_cl_act, AVG(IS_act) AS avg_is_act, AVG(TON_dry) AS avg_ton_dry, AVG(LS_qcx) AS avg_ls_qcx, AVG(SS_qcx) AS avg_ss_qcx, AVG(CL_qcx) AS avg_cl_qcx, AVG(IS_qcx) AS avg_is_qcx, AVG(LS_set) AS avg_ls_set, AVG(SS_set) AS avg_ss_set, AVG(CL_set) AS avg_cl_set, AVG(IS_set) AS avg_is_set, AVG(SiO2) AS avg_sio2, AVG(Al2O3) AS avg_al2o3, AVG(Fe2O3) AS avg_fe2o3, AVG(CaO) AS avg_cao, AVG(MgO) AS avg_mgo, AVG(SO3) AS avg_so3, AVG(K2O) AS avg_k2o, AVG(Na2O) AS avg_na2o, AVG(Cl2) AS avg_cl2, AVG(SUM) AS avg_sum, AVG(ALKALI) AS avg_alkali, AVG(TON_emisi) AS avg_ton_emisi FROM r1_6 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

			        $average_result = mysqli_fetch_assoc($average_query);
				        foreach ($average_result as $average) {
				            echo "<td>".number_format($average, 2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM r1_6");
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
			        $max_query = mysqli_query($conn, "SELECT MAX(LSF) AS max_lsf, MAX(SIM) AS max_sim, MAX(ALM) AS max_alm, MAX(rm90u) AS max_rm90u, MAX(rm180u) AS max_rm180u, MAX(H2O) AS max_h2o, MAX(LS_act) AS max_ls_act, MAX(SS_act) AS max_ss_act, MAX(CL_act) AS max_cl_act, MAX(IS_act) AS max_is_act, MAX(TON_dry) AS max_ton_dry, MAX(LS_qcx) AS max_ls_qcx, MAX(SS_qcx) AS max_ss_qcx, MAX(CL_qcx) AS max_cl_qcx, MAX(IS_qcx) AS max_is_qcx, MAX(LS_set) AS max_ls_set, MAX(SS_set) AS max_ss_set, MAX(CL_set) AS max_cl_set, MAX(IS_set) AS max_is_set, MAX(SiO2) AS max_sio2, MAX(Al2O3) AS max_al2o3, MAX(Fe2O3) AS max_fe2o3, MAX(CaO) AS max_cao, MAX(MgO) AS max_mgo,MAX(SO3) AS max_so3, MAX(K2O) AS max_k2o, MAX(Na2O) AS max_na2o, MAX(Cl2) AS max_cl2, MAX(SUM) AS max_sum, MAX(ALKALI) AS max_alkali, MAX(TON_emisi) AS max_ton_emisi FROM r1_6 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
			         $max_result = mysqli_fetch_assoc($max_query);
				        foreach ($max_result as $max) {
				            echo "<td>".$max."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM r1_6");
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
			       $sd_query = mysqli_query($conn, "SELECT STDDEV(LSF) AS stddev_lsf, STDDEV(SIM) AS stddev_sim, STDDEV(ALM) AS stddev_alm, STDDEV(rm90u) AS stddev_rm90u, STDDEV(rm180u) AS stddev_rm180u, STDDEV(H2O) AS stddev_h2o, STDDEV(LS_act) AS stddev_ls_act, STDDEV(SS_act) AS stddev_ss_act, STDDEV(CL_act) AS stddev_cl_act, STDDEV(IS_act) AS stddev_is_act, STDDEV(TON_dry) AS stddev_ton_dry, STDDEV(LS_qcx) AS stddev_ls_qcx, STDDEV(SS_qcx) AS stddev_ss_qcx, STDDEV(CL_qcx) AS stddev_cl_qcx, STDDEV(IS_qcx) AS stddev_is_qcx, STDDEV(LS_set) AS stddev_ls_set, STDDEV(SS_set) AS stddev_ss_set, STDDEV(CL_set) AS stddev_cl_set, STDDEV(IS_set) AS stddev_is_set, STDDEV(SiO2) AS stddev_sio2, STDDEV(Al2O3) AS stddev_al2o3, STDDEV(Fe2O3) AS stddev_fe2o3, STDDEV(CaO) AS stddev_cao, STDDEV(MgO) AS stddev_mgo, STDDEV(SO3) AS stddev_so3, STDDEV(K2O) AS stddev_k2o, STDDEV(Na2O) AS stddev_na2o, STDDEV(Cl2) AS stddev_cl2, STDDEV(SUM) AS stddev_sum, STDDEV(ALKALI) AS stddev_alkali, STDDEV(TON_emisi) AS stddev_ton_emisi FROM r1_6 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

			        $sd_result = mysqli_fetch_assoc($sd_query);
				        foreach ($sd_result as $sd) {
				            echo "<td>".number_format($sd, 2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM r1_6");
				        while($data = mysqli_fetch_array($sql)){
				        }
				    }
				    ?>
			    </tr>  
			</table>
			<table class="adminlist mb-3" border="1" width="500" cellpadding="5">
		    <tr bgcolor="#8080FF" style="color:#FFFFFF">
			    <th></th>
			    <th>LSF</th>
			    <th>SIM</th>
			    <th>ALM</th>
			    <th>90u</th>
			    <th>180u</th>
			</tr>
			<tr bgcolor="YELLOW" style="color:BLACK">
			    <th>DATA IN</th>
				<?php
				if (isset($_GET['awal']) && isset($_GET['akhir'])) {
				    $awal = $_GET['awal'];
				    $akhir = $_GET['akhir'];

				    $datain_query = mysqli_query($conn, "SELECT 
				        COUNT(IF(LSF < 91, 1, NULL)) AS datain_lsfmax,
				        COUNT(IF(LSF > 107, 1, NULL)) AS datain_lsfmin,
				        COUNT(IF(SIM < 2 , 1, NULL)) AS datain_simmax,
				        COUNT(IF(SIM > 2.6, 1, NULL)) AS datain_simmin,
				        COUNT(IF(ALM < 1.3 , 1, NULL)) AS datain_almmax,
				        COUNT(IF(ALM > 1.9, 1, NULL)) AS datain_almmin,
				        COUNT(IF(rm90u > 20, 1, NULL)) AS datain_90u,
				        COUNT(IF(rm180u > 3, 1, NULL)) AS datain_180u
				        FROM r1_6 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

				    $datain_result = mysqli_fetch_assoc($datain_query);
				    $kolom = array("LSF", "SIM", "ALM", "rm90u", "rm180u");
				    foreach ($kolom as $nama_kolom) {
				        $count = $count_result["count_" . strtolower($nama_kolom)];
				        $datain_lsfmax = isset($datain_result["datain_lsfmax"]) ? $datain_result["datain_lsfmax"] : 0;
				        $datain_lsfmin = isset($datain_result["datain_lsfmin"]) ? $datain_result["datain_lsfmin"] : 0;
				        $datain_simmax = isset($datain_result["datain_simmax"]) ? $datain_result["datain_simmax"] : 0;
				        $datain_simmin = isset($datain_result["datain_simmin"]) ? $datain_result["datain_simmin"] : 0;
				        $datain_almmax = isset($datain_result["datain_almmax"]) ? $datain_result["datain_almmax"] : 0;
				        $datain_almmin = isset($datain_result["datain_almmin"]) ? $datain_result["datain_almmin"] : 0;
				        $datain_90u = isset($datain_result["datain_90u"]) ? $datain_result["datain_90u"] : 0;
				        $datain_180u = isset($datain_result["datain_180u"]) ? $datain_result["datain_180u"] : 0;
				        if ($nama_kolom == "LSF") {
				            $hasil = $count - $datain_lsfmax - $datain_lsfmin;
				        } elseif ($nama_kolom == "SIM") {
				            $hasil = $count - $datain_simmax - $datain_simmin;
				        } elseif ($nama_kolom == "ALM") {
				            $hasil = $count - $datain_almmax - $datain_almmin;
				        } elseif ($nama_kolom == "rm90u") {
				            $hasil = $count - $datain_90u;
				        } elseif ($nama_kolom == "rm180u") {
				            $hasil = $count - $datain_180u;
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
			            COUNT(IF(LSF < 91, 1, NULL)) AS datain_lsfmax,
			            COUNT(IF(LSF > 107, 1, NULL)) AS datain_lsfmin,
			            COUNT(IF(SIM < 2 , 1, NULL)) AS datain_simmax,
			            COUNT(IF(SIM > 2.6, 1, NULL)) AS datain_simmin,
			            COUNT(IF(ALM < 1.3 , 1, NULL)) AS datain_almmax,
			            COUNT(IF(ALM > 1.9, 1, NULL)) AS datain_almmin,
				        SUM(IF(rm90u > 20, 1, 0)) AS datain_90u,
				        SUM(IF(rm180u > 3, 1, 0)) AS datain_180u
			            FROM r1_6 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
 
			        $datain_result = mysqli_fetch_assoc($datain_query);
			        $kolom = array("LSF", "SIM", "ALM", "rm90u", "rm180u");
			        foreach ($kolom as $nama_kolom) {
			            $count = $count_result["count_" . strtolower($nama_kolom)];
			            $datain_lsfmax = isset($datain_result["datain_lsfmax"]) ? $datain_result["datain_lsfmax"] : 0;
			            $datain_lsfmin = isset($datain_result["datain_lsfmin"]) ? $datain_result["datain_lsfmin"] : 0;
			            $datain_simmax = isset($datain_result["datain_simmax"]) ? $datain_result["datain_simmax"] : 0;
			            $datain_simmin = isset($datain_result["datain_simmin"]) ? $datain_result["datain_simmin"] : 0;
			            $datain_almmax = isset($datain_result["datain_almmax"]) ? $datain_result["datain_almmax"] : 0;
			            $datain_almmin = isset($datain_result["datain_almmin"]) ? $datain_result["datain_almmin"] : 0;
			            $datain = isset($datain_result["datain_" . strtolower($nama_kolom)]) ? $datain_result["datain_" . strtolower($nama_kolom)] : 0;
			            if ($nama_kolom == "LSF") {
			                $hasil = $count - $datain_lsfmax - $datain_lsfmin;
			            } elseif ($nama_kolom == "SIM") {
			                $hasil = $count - $datain_simmax - $datain_simmin;
			            } elseif ($nama_kolom == "ALM") {
			                $hasil = $count - $datain_almmax - $datain_almmin;
			            } elseif ($nama_kolom == "rm90u") {
				            $hasil = $count - $datain_90u;
				        } elseif ($nama_kolom == "rm180u") {
				            $hasil = $count - $datain_180u;
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
	                <a href="exportr1.php" class="btn btn-primary" > Download </a>
	            </div>
	        </div>        
	    </div>
	</div>
	    


		<div>
			 <table class="table table-striped table-bordered table-hover">
				<thead>

					<tr class="text-center" >
			            <th colspan="2"></th><th  colspan="6">6R1</th><th  colspan="4">Proposi Actual</th><th colspan="1">TON</th><th colspan="4">Setpoint QCX, %Wet</th><th colspan="4">Proporsi SET POINT</th> <th colspan="12">OKSIDA</th><th colspan="1">TON</th><th colspan="4">LS BACK</th>
			        </tr>

					<tr class="bg-primary text-white">
						
					<th>Tanggal</th><th>Jam</th><th>LSF</th> <th>SIM</th> <th>ALM</th> <th>90u</th><th>180u</th> <th>H2O</th><th>LS</th> <th>SS</th> <th>CL</th> <th>IS</th><th>dry</th><th>LS</th><th>SS</th><th>CL</th> <th>IS</th><th>LS</th> <th>SS</th> <th>CL</th> <th>IS</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th> <th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>LST/PZ</th><th>SUM</th><th>Alkali</th><th>Emisi CO2</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>Report</th>

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
							$sum = library::calculateSum($d);
							$alkali = library::calculateAlkali($d);
							$sio2_back = library::calculateSio2($d);
							$al2o3_back = library::calculateAl2o3($d);
							$fe2o3_back = library::calculateFe2o3($d);
							$cao_back = library::calculateCao($d);

							$is_act = null;
							if (!empty($d['LS_act'])) {
							    $is_act =  100 - $d['LS_act'] - $d['SS_act'] - $d['CL_act'];
							    $is_act = !is_null($is_act) ? number_format((float)$is_act, 2, '.', '') : null;
							}

							$is_qcx = null;
							if (!empty($d['LS_qcx'])) {
							    $is_qcx =  100 - $d['LS_qcx'] - $d['SS_qcx'] - $d['CL_qcx'];
							    $is_qcx = !is_null($is_qcx) ? number_format((float)$is_qcx, 2, '.', '') : null;
							}

							$is_set = null;
							if (!empty($d['LS_set'])) {
							    $is_set =  100 - $d['LS_set'] - $d['SS_set'] - $d['CL_set'];
							    $is_set = !is_null($is_set) ? number_format((float)$is_set, 2, '.', '') : null;
							}


							$ton_emisi = null;
							if (!empty($d['CaO'])) {
							    $ton_emisi = ($d['CaO'] * 0.786 + $d['MgO'] * 1.1) / 100 * $d['TON_dry'];
							    $ton_emisi = !is_null($ton_emisi) ? number_format((float)$ton_emisi, 2, '.', '') : null;
							}

							


					       $update_query = "UPDATE r1_6 SET LSF=?, SIM=?, ALM=?,IS_act=?,IS_qcx=?,IS_set=?, SUM=?, ALKALI=?, TON_emisi=?, SiO2_back=?, Al2O3_back=?, Fe2O3_back=?, CaO_back=? WHERE id=?";

						$stmt = mysqli_prepare($conn, $update_query);

						mysqli_stmt_bind_param($stmt, "sssssssssssssi", $lsf, $sim, $alm, $is_act,$is_qcx, $is_set, $sum, $alkali, $ton_emisi, $sio2_back, $al2o3_back, $fe2o3_back, $cao_back, $d['id']);

						if (mysqli_stmt_execute($stmt)) {
						    echo " ";
						} else {
						    echo "Error: " . mysqli_error($conn);
						}

						mysqli_stmt_close($stmt);

							$w_180u = '';
					        if ($d['rm180u'] > $configs['rm180u6']['max'] ) {
					            $w_180u = 'text-danger';
					        }
					        $w_90u = '';
					        if ($d['rm90u'] > $configs['rm90u6']['max'] ) {
					            $w_90u = 'text-danger';
					        }
					        $w_alkali  = '';
							if ($alkali > 0.35) {
							    $w_alkali = 'text-danger';
							}
							$w_pz = '';
							if (stripos($d['LSToPZ'], 'pz') !== false) {
							    $w_pz = 'color:red;';
							}
					        $w_h2o = '';
							if ($d['H2O'] < $configs['H2Orm6']['min'] || $d['H2O'] > $configs['H2Orm6']['max']) {
							    $w_h2o = 'text-danger';
							}
							$w_alm = '';
							if ($alm < $configs['ALMrm6']['min'] || $alm > $configs['ALMrm6']['max']) {
							    $w_alm = 'text-danger';
							}
					        $w_lsf = '';
							if ($lsf < $configs['LSFrm6']['min'] || $lsf > $configs['LSFrm6']['max']) {
							    $w_lsf = 'text-danger';
							}
							$w_sim = '';
							if ($sim < $configs['SIMrm6']['min'] || $sim > $configs['SIMrm6']['max']) {
							    $w_sim = 'text-danger';
							}
					      
					    ?>

					        	<td><?php echo htmlspecialchars($d['TANGGAL']); ?></td>
					            <td><?php echo htmlspecialchars($d['JAM']); ?></td>
					            <td class="<?php echo $w_lsf; ?>"><?php echo htmlspecialchars($lsf); ?></td>
					            <td class="<?php echo $w_sim; ?>"><?php echo htmlspecialchars($sim); ?></td>
					            <td class="<?php echo $w_alm; ?>"><?php echo htmlspecialchars($alm); ?></td>
					            <td class="<?php echo $w_90u; ?>"><?php echo htmlspecialchars($d['rm90u']); ?></td>
					            <td class="<?php echo $w_180u; ?>"><?php echo htmlspecialchars($d['rm180u']); ?></td>
					            <td class="<?php echo $w_h2o; ?>"><?php echo htmlspecialchars($d['H2O']); ?></td>
					            <td><?php echo htmlspecialchars($d['LS_act']); ?></td>
					            <td><?php echo htmlspecialchars($d['SS_act']); ?></td>
					            <td><?php echo htmlspecialchars($d['CL_act']); ?></td>
					            <td><?php echo htmlspecialchars($d['IS_act']); ?></td>
					            <td><?php echo htmlspecialchars($d['TON_dry']); ?></td>
					            <td><?php echo htmlspecialchars($d['LS_qcx']); ?></td>
					            <td><?php echo htmlspecialchars($d['SS_qcx']); ?></td>
					            <td><?php echo htmlspecialchars($d['CL_qcx']); ?></td>
					            <td><?php echo htmlspecialchars($d['IS_qcx']); ?></td>
					            <td><?php echo htmlspecialchars($d['LS_set']); ?></td>
					            <td><?php echo htmlspecialchars($d['SS_set']); ?></td>
					            <td><?php echo htmlspecialchars($d['CL_set']); ?></td>
					            <td><?php echo htmlspecialchars($d['IS_set']); ?></td>
					            <td><?php echo htmlspecialchars($d['SiO2']); ?></td>
					            <td><?php echo htmlspecialchars($d['Al2O3']); ?></td>
					            <td><?php echo htmlspecialchars($d['Fe2O3']); ?></td>
					            <td><?php echo htmlspecialchars($d['CaO']); ?></td>
					            <td><?php echo htmlspecialchars($d['MgO']); ?></td>
					            <td><?php echo htmlspecialchars($d['SO3']); ?></td>
					            <td><?php echo htmlspecialchars($d['K2O']); ?></td>
					            <td><?php echo htmlspecialchars($d['Na2O']); ?></td>
					            <td><?php echo htmlspecialchars($d['Cl2']); ?></td>
					            <td class="<?php echo $w_pz; ?>"><?php echo htmlspecialchars($d['LSToPZ']); ?></td>
					            <td><?php echo htmlspecialchars($sum); ?></td>
					            <td class="<?php echo $w_alkali; ?>"><?php echo htmlspecialchars($alkali); ?></td>
					            <td><?php echo htmlspecialchars($ton_emisi); ?></td>
					            <td><?php echo htmlspecialchars($sio2_back); ?></td>
					            <td><?php echo htmlspecialchars($al2o3_back); ?></td>
					            <td><?php echo htmlspecialchars($fe2o3_back); ?></td>
					            <td><?php echo htmlspecialchars($cao_back); ?></td>
					            <td><?php echo htmlspecialchars($d['waktu']); ?> <a><?php echo htmlspecialchars($d['iduser']); ?></a></td>

					            
					            <td align="center">
					                <a href="#" type="button" style="height:34px" class="btn btn-success btn-md  pl-4 pr-4" data-toggle="modal" data-target="#myModal<?php echo $d['id']; ?>"><i class="fa fa-fw fa-edit"></i>Edit</a>
					                <a href="del-r1.php?delId=<?php echo $d['id']; ?>" type="button" class="btn btn-danger" style="height:34px" onClick="return confirm('Are you sure to delete this data?');"><i class="fa fa-fw fa-trash"></i> Delete</a>
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
											$sql = "SELECT * FROM r1_6 where id ='$id' order by id";
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
													<label for="rm90u" class="col-sm-4 col-form-label">90u</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="rm90u_e" name="rm90u_e" value="<?= $row['rm90u']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="rm180u" class="col-sm-4 col-form-label">180u</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="rm180u_e" name="rm180u_e" value="<?= $row['rm180u']; ?>">
													</div>
												</div>
												<div class="form-group row my-0">
												    <label for="H2O" class="col-sm-4 col-form-label">H2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="H2O_e" name="H2O_e" value="<?= $row['H2O']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
													<label for="LS_act" class="col-sm-4 col-form-label">LS actual</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="LS_act_e" name="LS_act_e" value="<?= $row['LS_act']; ?>">
													</div>
												</div>
												<div class="form-group row my-0">
													<label for="SS_act" class="col-sm-4 col-form-label">SS actual</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="SS_act_e" name="SS_act_e" value="<?= $row['SS_act']; ?>">
													</div>
												</div>
												<div class="form-group row my-0">
													<label for="CL_act" class="col-sm-4 col-form-label">CL actual</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="CL_act_e" name="CL_act_e" value="<?= $row['CL_act']; ?>">
													</div>
												</div>
												<div class="form-group row my-0">
													<label for="TON_dry" class="col-sm-4 col-form-label">TON dry</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="TON_dry_e" name="TON_dry_e" value="<?= $row['TON_dry']; ?>">
													</div>
												</div>
												<div class="form-group row my-0">
													<label for="LS_qcx" class="col-sm-4 col-form-label">LS QCX</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="LS_qcx_e" name="LS_qcx_e" value="<?= $row['LS_qcx']; ?>">
													</div>
												</div>
												<div class="form-group row my-0">
													<label for="SS_qcx" class="col-sm-4 col-form-label">SS QCX</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="SS_qcx_e" name="SS_qcx_e" value="<?= $row['SS_qcx']; ?>">
													</div>
												</div>
												<div class="form-group row my-0">
													<label for="CL_qcx" class="col-sm-4 col-form-label">CL QCX</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="CL_qcx_e" name="CL_qcx_e" value="<?= $row['CL_qcx']; ?>">
													</div>
												</div>
												<div class="form-group row my-0">
													<label for="LS_set" class="col-sm-4 col-form-label">LS setpoint</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="LS_set_e" name="LS_set_e" value="<?= $row['LS_set']; ?>">
													</div>
												</div>
												<div class="form-group row my-0">
													<label for="SS_set" class="col-sm-4 col-form-label">SS setpoint</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="SS_set_e" name="SS_set_e" value="<?= $row['SS_set']; ?>">
													</div>
												</div>
												<div class="form-group row my-0">
													<label for="CL_set" class="col-sm-4 col-form-label">CL setpoint</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="CL_set_e" name="CL_set_e" value="<?= $row['CL_set']; ?>">
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
												    <label for="LSToPZ" class="col-sm-4 col-form-label">LST/PZ</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="LSToPZ_e" name="LSToPZ_e" value="<?= $row['LSToPZ']; ?>">
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
	$rm90u = !empty($_POST['rm90u']) ? $_POST['rm90u'] : NULL;
	$rm180u = !empty($_POST['rm180u']) ? $_POST['rm180u'] : NULL;
	$H2O = !empty($_POST['H2O']) ? $_POST['H2O'] : NULL;
	$LS_act = !empty($_POST['LS_act']) ? $_POST['LS_act'] : NULL;
	$SS_act = !empty($_POST['SS_act']) ? $_POST['SS_act'] : NULL;
	$CL_act = !empty($_POST['CL_act']) ? $_POST['CL_act'] : NULL;
	$TON_dry = !empty($_POST['TON_dry']) ? $_POST['TON_dry'] : NULL;
	$LS_qcx = !empty($_POST['LS_qcx']) ? $_POST['LS_qcx'] : NULL;
	$SS_qcx = !empty($_POST['SS_qcx']) ? $_POST['SS_qcx'] : NULL;
	$CL_qcx = !empty($_POST['CL_qcx']) ? $_POST['CL_qcx'] : NULL;
	$LS_set = !empty($_POST['LS_set']) ? $_POST['LS_set'] : NULL;
	$SS_set = !empty($_POST['SS_set']) ? $_POST['SS_set'] : NULL;
	$CL_set = !empty($_POST['CL_set']) ? $_POST['CL_set'] : NULL;
	$SiO2 = !empty($_POST['SiO2']) ? $_POST['SiO2'] : NULL;
	$Al2O3 = !empty($_POST['Al2O3']) ? $_POST['Al2O3'] : NULL;
	$Fe2O3 = !empty($_POST['Fe2O3']) ? $_POST['Fe2O3'] : NULL;
	$CaO = !empty($_POST['CaO']) ? $_POST['CaO'] : NULL;
	$MgO = !empty($_POST['MgO']) ? $_POST['MgO'] : NULL;
	$SO3 = !empty($_POST['SO3']) ? $_POST['SO3'] : NULL;
	$K2O = !empty($_POST['K2O']) ? $_POST['K2O'] : NULL;
	$Na2O = !empty($_POST['Na2O']) ? $_POST['Na2O'] : NULL;
	$Cl2 = !empty($_POST['Cl2']) ? $_POST['Cl2'] : NULL;
	$LSToPZ = !empty($_POST['LSToPZ']) ? $_POST['LSToPZ'] : NULL;



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
					    $sql = "INSERT INTO r1_6 (TANGGAL, JAM, rm90u, rm180u, H2O, LS_act, SS_act, CL_act, TON_dry, LS_qcx, SS_qcx, CL_qcx, LS_set, SS_set, CL_set, SiO2, Al2O3, Fe2O3, CaO, MgO, SO3, K2O, Na2O, Cl2, LSToPZ, waktu, iduser) 
					            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

					    $stmt = mysqli_prepare($conn, $sql);

					  if ($stmt) {
					    mysqli_stmt_bind_param($stmt, "sssssssssssssssssssssssssss", $tanggal, $JAM, $rm90u, $rm180u, $H2O, $LS_act, $SS_act, $CL_act, $TON_dry, $LS_qcx, $SS_qcx, $CL_qcx, $LS_set, $SS_set, $CL_set, $SiO2, $Al2O3, $Fe2O3, $CaO, $MgO, $SO3, $K2O, $Na2O, $Cl2, $LSToPZ, $waktu, $username);

					        if (mysqli_stmt_execute($stmt)) {
					            echo "<script>window.location = 'r1.php'</script>";
					        } else {
					            echo "Error: " . mysqli_stmt_error($stmt);
					        }
					        mysqli_stmt_close($stmt);
					    } else {
					        echo "Error: " . mysqli_error($conn);
					    }
					}

					$sql = "SELECT * FROM r1_6 WHERE TANGGAL = CURDATE()";
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
								<label for="rm90u" class="col-sm-4 col-form-label">90u</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="rm90u" name="rm90u" placeholder="Enter 90u" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="rm180u" class="col-sm-4 col-form-label">180u</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="rm180u" name="rm180u" placeholder="Enter 180u">
								</div>
							</div>
							<div class="form-group row my-0">
							    <label for="H2O" class="col-sm-4 col-form-label">H2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="H2O" name="H2O" placeholder="Enter H2O" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="LS_act" class="col-sm-4 col-form-label">LS actual</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="LS_act" name="LS_act" placeholder="Enter LS" >
							    </div>
							</div>
							<div class="form-group row my-0">
								<label for="SS_act" class="col-sm-4 col-form-label">SS actual</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="SS_act" name="SS_act" placeholder="Enter SS" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="CL_act" class="col-sm-4 col-form-label">CL actual</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="CL_act" name="CL_act" placeholder="Enter CL" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="TON_dry" class="col-sm-4 col-form-label">TON dry</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="TON_dry" name="TON_dry" placeholder="Enter TON dry" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="LS_qcx" class="col-sm-4 col-form-label">LS QCX</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="LS_qcx" name="LS_qcx" placeholder="Enter LS" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="SS_qcx" class="col-sm-4 col-form-label">SS QCX</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="SS_qcx" name="SS_qcx" placeholder="Enter SS_qcx" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="CL_qcx" class="col-sm-4 col-form-label">CL QCX</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="CL_qcx" name="CL_qcx" placeholder="Enter CL" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="LS_set" class="col-sm-4 col-form-label">LS setpoint</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="LS_set" name="LS_set" placeholder="Enter LS" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="SS_set" class="col-sm-4 col-form-label">SS setpoint</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="SS_set" name="SS_set" placeholder="Enter SS" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="CL_set" class="col-sm-4 col-form-label">CL setpoint</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="CL_set" name="CL_set" placeholder="Enter CL" >
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
							    <label for="LSToPZ" class="col-sm-4 col-form-label">LST/PZ</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="LSToPZ" name="LSToPZ" placeholder="Enter LST/PZ" >
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
	    	var rm90u = document.getElementById("rm90u").value;
	        var rm180u = document.getElementById("rm180u").value;
	        var H2O = document.getElementById("H2O").value;
	        var LS_act = document.getElementById("LS_act").value;
	        var SS_act = document.getElementById("SS_act").value;
	        var CL_act = document.getElementById("CL_act").value;
	        var TON_dry = document.getElementById("TON_dry").value;
	        var LS_qcx = document.getElementById("LS_qcx").value;
	        var SS_qcx = document.getElementById("SS_qcx").value;
	        var CL_qcx = document.getElementById("CL_qcx").value;
	        var LS_set = document.getElementById("LS_set").value;
	        var SS_set = document.getElementById("SS_set").value;
	        var CL_set = document.getElementById("CL_set").value;
	        var SiO2 = document.getElementById("SiO2").value;
	        var Al2O3 = document.getElementById("Al2O3").value;
	        var Fe2O3 = document.getElementById("Fe2O3").value;
	        var CaO = document.getElementById("CaO").value;
	        var MgO = document.getElementById("MgO").value;
	        var SO3 = document.getElementById("SO3").value;
	        var K2O = document.getElementById("K2O").value;
	        var Na2O = document.getElementById("Na2O").value;
	        var Cl2 = document.getElementById("Cl2").value;

	        var inputs = [rm90u, rm180u, LS_act,SS_act, CL_act, LS_qcx,SS_qcx,CL_qcx, LS_set, SS_set,CL_set,SiO2, Al2O3, Fe2O3, CaO, MgO, SO3, K2O, Na2O, Cl2, H2O];

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