<?php
session_start();
$level = strtoupper($_SESSION['level']);
if ($level == NULL) {
    echo "<script>window.location = '../index.php'</script>";
}
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    include "../../include/database.php";
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

	<style>
	.freeze1 {
        left: 0;
        z-index: 4; 
        position: sticky;
        background-color: #f2f2f2;
    }
    .freeze2 {
        left: 100px; 
        z-index: 3;
        position: sticky;
        background-color: #f2f2f2;
    }
    .freeze3 {
        left: 158.5px;
        z-index: 2; 
        position: sticky;
        background-color: #f2f2f2;
    }
    .freeze4 {
        left: 215px; 
        z-index: 1;
        position: sticky;
        background-color: #f2f2f2;
    }
   
</style>
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
    $fields = [
        'JAM', 'FEED', 'BLAINE_opc', 'SO3_opc', 'z145u_opc', 'z130u_opc', 'H2O_opc', 
        'LOI_opc', 'SiO2_opc', 'Al2O3_opc', 'Fe2O3_opc', 'CaO_opc', 'MgO_opc', 'K2O_opc', 
        'Na2O_opc', 'Cl2_opc', 'FCaO_opc', 'GYPS_opc', 'LS_opc', 'PZ_opc', 'FA_opc', 
        'TYPE_opc', 'SILO_opc', 'BLAINE_pcc', 'SO3_pcc', 'z145u_pcc', 'LOI_pcc', 
        'SiO2_pcc', 'Al2O3_pcc', 'Fe2O3_pcc', 'CaO_pcc', 'MgO_pcc', 'K2O_pcc', 
        'Na2O_pcc', 'Cl2_pcc', 'FCaO_pcc', 'GYPS_pcc', 'LS_pcc', 'PZ_pcc', 'FA_pcc', 
        'SILO_pcc', 'BLAINE_pcp', 'SO3_pcp', 'z145u_pcp', 'LOI_pcp', 'SiO2_pcp', 
        'Al2O3_pcp', 'Fe2O3_pcp', 'CaO_pcp', 'MgO_pcp', 'K2O_pcp', 'Na2O_pcp', 
        'Cl2_pcp', 'FCaO_pcp', 'GYPS_pcp', 'LS_pcp', 'PZ_pcp', 'FA_pcp', 'SILO_pcp'
    ];

    $params = [];
    $placeholders = [];

    foreach ($fields as $field) {
        $param = isset($_GET[$field . '_e']) && $_GET[$field . '_e'] !== '' ? $_GET[$field . '_e'] : NULL;
        $params[$field] = $param;
        $placeholders[] = "$field=?";
    }

    $id_e = isset($_GET['id_e']) && $_GET['id_e'] !== '' ? $_GET['id_e'] : NULL;
    $params['id'] = $id_e;

    $sql = "UPDATE z1_3 SET " . implode(", ", $placeholders) . " WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        die("Error preparing the SQL statement: " . mysqli_error($conn));
    }

    $types = str_repeat("s", count($params) - 1) . "i";
    $values = array_values($params);

    mysqli_stmt_bind_param($stmt, $types, ...$values);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>window.location = 'z1.php'</script>";
    } 

    mysqli_stmt_close($stmt);
}


	
$jumlahDataPerhalaman = 24;

$halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;

if (isset($_GET['awal']) && isset($_GET['akhir'])) {
    $awal = $_GET['awal'];
    $akhir = $_GET['akhir'];
    $sql_filtered = "SELECT * FROM z1_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'";
} elseif (isset($_GET['kemarin'])) {
    $sql_filtered = "SELECT * FROM z1_3 WHERE TANGGAL = CURDATE() - INTERVAL 1 DAY";
}
else {
    $sql_filtered = "SELECT * FROM z1_3 WHERE TANGGAL = CURDATE()";
}

$result_filtered = mysqli_query($conn, $sql_filtered);
$jumlahData = mysqli_num_rows($result_filtered);

$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

$sql = "$sql_filtered LIMIT $awalData, $jumlahDataPerhalaman";
$q = mysqli_query($conn, $sql);
?>
		<center style="font-family: Arial, sans-serif; font-size: 24px; font-weight: bold; color: #333333; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
		    <label>SEMEN 1 Indarung 2&3</label>
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
			            <th rowspan="1"></th> <th rowspan="2">TOTAL FEED</th><th colspan="6">OPC(UltraPro)</th><th  colspan="9">OKSIDA</th><th colspan="4">PROPORSI</th><th colspan="2">ESTIMASI</th><th rowspan="2" >ALKALI OPC</th> <th colspan="4">PCC(EzPro)</th><th colspan="9">OKSIDA</th><th colspan="4">PROPORSI</th><th colspan="2">ESTIMASI</th><th colspan="4">PCC+(PwrPro)</th><th colspan="9">OKSIDA</th><th colspan="4">PROPORSI</th><th colspan="2">ESTIMASI</th>
			        </tr>

				<tr bgcolor="#8080FF" style="color:#FFFFFF">
			        <th></th>
			        <th>BLAINE</th><th>SO3</th><th>45u</th><th>30u</th><th>H2O</th><th>LOI</th><th>SiO2</th><th>Al2O3</th><th>Fe2O3</th><th>CaO</th><th>MgO</th><th>K2O</th><th>Na2O</th><th>Cl2</th><th>FCaO</th><th>GYPS</th><th>LS</th><th>PZ</th><th>FA</th><th>CR</th><th>BTL</th><th>BLAINE</th><th>SO3</th><th>45u</th><th>LOI</th><th>SiO2</th><th>Al2O3</th><th>Fe2O3</th><th>CaO</th><th>MgO</th><th>K2O</th><th>Na2O</th><th>Cl2</th><th>FCaO</th><th>GYPS</th><th>LS</th><th>PZ</th><th>FA</th><th>CR</th><th>BTL</th><th>BLAINE</th><th>SO3</th><th>45u</th><th>LOI</th><th>SiO2</th><th>Al2O3</th><th>Fe2O3</th><th>CaO</th><th>MgO</th><th>K2O</th><th>Na2O</th><th>Cl2</th><th>FCaO</th><th>GYPS</th><th>LS</th><th>PZ</th><th>FA</th><th>CR</th><th>BTL</th>
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
			     $count_query = mysqli_query($conn, "SELECT COUNT(FEED) AS count_feed,COUNT(BLAINE_opc) AS count_blaine_opc,COUNT(SO3_opc) AS count_so3_opc,COUNT(z145u_opc) AS count_z145u_opc,COUNT(z130u_opc) AS count_z130u_opc,COUNT(H2O_opc) AS count_h2o_opc,COUNT(LOI_opc) AS count_loi_opc,COUNT(SiO2_opc) AS count_sio2_opc,COUNT(Al2O3_opc) AS count_al2o3_opc,COUNT(Fe2O3_opc) AS count_fe2o3_opc,COUNT(CaO_opc) AS count_cao_opc,COUNT(MgO_opc) AS count_mgo_opc,COUNT(K2O_opc) AS count_k2o_opc,COUNT(Na2O_opc) AS count_na2o_opc,COUNT(Cl2_opc) AS count_cl2_opc,COUNT(FCaO_opc) AS count_fcao_opc,COUNT(GYPS_opc) AS count_gyps_opc,COUNT(LS_opc) AS count_ls_opc,COUNT(PZ_opc) AS count_pz_opc,COUNT(FA_opc) AS count_fa_opc,COUNT(CR_opc) AS count_cr_opc,COUNT(BTL_opc) AS count_btl_opc,COUNT(ALKALI_opc) AS count_alkali_opc,COUNT(BLAINE_pcc) AS count_blaine_pcc,COUNT(SO3_pcc) AS count_so3_pcc,COUNT(z145u_pcc) AS count_z145u_pcc,COUNT(LOI_pcc) AS count_loi_pcc,COUNT(SiO2_pcc) AS count_sio2_pcc,COUNT(Al2O3_pcc) AS count_al2o3_pcc,COUNT(Fe2O3_pcc) AS count_fe2o3_pcc,COUNT(CaO_pcc) AS count_cao_pcc,COUNT(MgO_pcc) AS count_mgo_pcc,COUNT(K2O_pcc) AS count_k2o_pcc,COUNT(Na2O_pcc) AS count_na2o_pcc,COUNT(Cl2_pcc) AS count_cl2_pcc,COUNT(FCaO_pcc) AS count_fcao_pcc,COUNT(GYPS_pcc) AS count_gyps_pcc,COUNT(LS_pcc) AS count_ls_pcc,COUNT(PZ_pcc) AS count_pz_pcc,COUNT(FA_pcc) AS count_fa_pcc,COUNT(CR_pcc) AS count_cr_pcc,COUNT(BTL_pcc) AS count_btl_pcc,COUNT(BLAINE_pcp) AS count_blaine_pcp,COUNT(SO3_pcp) AS count_so3_pcp,COUNT(z145u_pcp) AS count_z145u_pcp,COUNT(LOI_pcp) AS count_loi_pcp,COUNT(SiO2_pcp) AS count_sio2_pcp,COUNT(Al2O3_pcp) AS count_al2o3_pcp,COUNT(Fe2O3_pcp) AS count_fe2o3_pcp,COUNT(CaO_pcp) AS count_cao_pcp,COUNT(MgO_pcp) AS count_mgo_pcp,COUNT(K2O_pcp) AS count_k2o_pcp,COUNT(Na2O_pcp) AS count_na2o_pcp,COUNT(Cl2_pcp) AS count_cl2_pcp,COUNT(FCaO_pcp) AS count_fcao_pcp,COUNT(GYPS_pcp) AS count_gyps_pcp,COUNT(LS_pcp) AS count_ls_pcp,COUNT(PZ_pcp) AS count_pz_pcp,COUNT(FA_pcp) AS count_fa_pcp,COUNT(CR_pcp) AS count_cr_pcp,COUNT(BTL_pcp) AS count_btl_pcp FROM z1_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

			        $count_result = mysqli_fetch_assoc($count_query);

			        foreach ($count_result as $count) {
			            echo "<td>".$count."</td>";
			        }
			    } else {
			        // Jika tidak ada tanggal yang dipilih, tampilkan seluruh data
			        $sql = mysqli_query($conn,"SELECT * FROM z1_3");
			        // Lakukan iterasi hanya untuk memperoleh jumlah kolom
			        $num_columns = mysqli_num_fields($sql);
			        for ($i = 0; $i < $num_columns; $i++) {
			            echo "<td>0</td>";
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
			        $min_query = mysqli_query($conn, "SELECT MIN(FEED) AS min_feed, MIN(BLAINE_opc) AS min_blaine_opc, MIN(SO3_opc) AS min_so3_opc, MIN(z145u_opc) AS min_z145u_opc, MIN(z130u_opc) AS min_z130u_opc, MIN(H2O_opc) AS min_h2o_opc, MIN(LOI_opc) AS min_loi_opc, MIN(SiO2_opc) AS min_sio2_opc, MIN(Al2O3_opc) AS min_al2o3_opc, MIN(Fe2O3_opc) AS min_fe2o3_opc, MIN(CaO_opc) AS min_cao_opc, MIN(MgO_opc) AS min_mgo_opc, MIN(K2O_opc) AS min_k2o_opc, MIN(Na2O_opc) AS min_na2o_opc, MIN(Cl2_opc) AS min_cl2_opc, MIN(FCaO_opc) AS min_fcao_opc, MIN(GYPS_opc) AS min_gyps_opc, MIN(LS_opc) AS min_ls_opc, MIN(PZ_opc) AS min_pz_opc, MIN(FA_opc) AS min_fa_opc, MIN(CR_opc) AS min_cr_opc, MIN(BTL_opc) AS min_btl_opc, MIN(ALKALI_opc) AS min_alkali_opc, MIN(BLAINE_pcc) AS min_blaine_pcc, MIN(SO3_pcc) AS min_so3_pcc, MIN(z145u_pcc) AS min_z145u_pcc, MIN(LOI_pcc) AS min_loi_pcc, MIN(SiO2_pcc) AS min_sio2_pcc, MIN(Al2O3_pcc) AS min_al2o3_pcc, MIN(Fe2O3_pcc) AS min_fe2o3_pcc, MIN(CaO_pcc) AS min_cao_pcc, MIN(MgO_pcc) AS min_mgo_pcc, MIN(K2O_pcc) AS min_k2o_pcc, MIN(Na2O_pcc) AS min_na2o_pcc, MIN(Cl2_pcc) AS min_cl2_pcc, MIN(FCaO_pcc) AS min_fcao_pcc, MIN(GYPS_pcc) AS min_gyps_pcc, MIN(LS_pcc) AS min_ls_pcc, MIN(PZ_pcc) AS min_pz_pcc, MIN(FA_pcc) AS min_fa_pcc, MIN(CR_pcc) AS min_cr_pcc, MIN(BTL_pcc) AS min_btl_pcc, MIN(BLAINE_pcp) AS min_blaine_pcp, MIN(SO3_pcp) AS min_so3_pcp, MIN(z145u_pcp) AS min_z145u_pcp, MIN(LOI_pcp) AS min_loi_pcp, MIN(SiO2_pcp) AS min_sio2_pcp, MIN(Al2O3_pcp) AS min_al2o3_pcp, MIN(Fe2O3_pcp) AS min_fe2o3_pcp, MIN(CaO_pcp) AS min_cao_pcp, MIN(MgO_pcp) AS min_mgo_pcp, MIN(K2O_pcp) AS min_k2o_pcp, MIN(Na2O_pcp) AS min_na2o_pcp, MIN(Cl2_pcp) AS min_cl2_pcp, MIN(FCaO_pcp) AS min_fcao_pcp, MIN(GYPS_pcp) AS min_gyps_pcp, MIN(LS_pcp) AS min_ls_pcp, MIN(PZ_pcp) AS min_pz_pcp, MIN(FA_pcp) AS min_fa_pcp, MIN(CR_pcp) AS min_cr_pcp, MIN(BTL_pcp) AS min_btl_pcp FROM z1_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");


			       $min_result = mysqli_fetch_assoc($min_query);
				        foreach ($min_result as $min) {
				            echo "<td>".number_format($min, 2 )."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM z1_3");
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
			       $average_query = mysqli_query($conn, "SELECT AVG(FEED) AS avg_feed, AVG(BLAINE_opc) AS avg_blaine_opc, AVG(SO3_opc) AS avg_so3_opc, AVG(z145u_opc) AS avg_z145u_opc, AVG(z130u_opc) AS avg_z130u_opc, AVG(H2O_opc) AS avg_h2o_opc, AVG(LOI_opc) AS avg_loi_opc, AVG(SiO2_opc) AS avg_sio2_opc, AVG(Al2O3_opc) AS avg_al2o3_opc, AVG(Fe2O3_opc) AS avg_fe2o3_opc, AVG(CaO_opc) AS avg_cao_opc, AVG(MgO_opc) AS avg_mgo_opc, AVG(K2O_opc) AS avg_k2o_opc, AVG(Na2O_opc) AS avg_na2o_opc, AVG(Cl2_opc) AS avg_cl2_opc, AVG(FCaO_opc) AS avg_fcao_opc, AVG(GYPS_opc) AS avg_gyps_opc, AVG(LS_opc) AS avg_ls_opc, AVG(PZ_opc) AS avg_pz_opc, AVG(FA_opc) AS avg_fa_opc, AVG(CR_opc) AS avg_cr_opc, AVG(BTL_opc) AS avg_btl_opc, AVG(ALKALI_opc) AS avg_alkali_opc, AVG(BLAINE_pcc) AS avg_blaine_pcc, AVG(SO3_pcc) AS avg_so3_pcc, AVG(z145u_pcc) AS avg_z145u_pcc, AVG(LOI_pcc) AS avg_loi_pcc, AVG(SiO2_pcc) AS avg_sio2_pcc, AVG(Al2O3_pcc) AS avg_al2o3_pcc, AVG(Fe2O3_pcc) AS avg_fe2o3_pcc, AVG(CaO_pcc) AS avg_cao_pcc, AVG(MgO_pcc) AS avg_mgo_pcc, AVG(K2O_pcc) AS avg_k2o_pcc, AVG(Na2O_pcc) AS avg_na2o_pcc, AVG(Cl2_pcc) AS avg_cl2_pcc, AVG(FCaO_pcc) AS avg_fcao_pcc, AVG(GYPS_pcc) AS avg_gyps_pcc, AVG(LS_pcc) AS avg_ls_pcc, AVG(PZ_pcc) AS avg_pz_pcc, AVG(FA_pcc) AS avg_fa_pcc, AVG(CR_pcc) AS avg_cr_pcc, AVG(BTL_pcc) AS avg_btl_pcc, AVG(BLAINE_pcp) AS avg_blaine_pcp, AVG(SO3_pcp) AS avg_so3_pcp, AVG(z145u_pcp) AS avg_z145u_pcp, AVG(LOI_pcp) AS avg_loi_pcp, AVG(SiO2_pcp) AS avg_sio2_pcp, AVG(Al2O3_pcp) AS avg_al2o3_pcp, AVG(Fe2O3_pcp) AS avg_fe2o3_pcp, AVG(CaO_pcp) AS avg_cao_pcp, AVG(MgO_pcp) AS avg_mgo_pcp, AVG(K2O_pcp) AS avg_k2o_pcp, AVG(Na2O_pcp) AS avg_na2o_pcp, AVG(Cl2_pcp) AS avg_cl2_pcp, AVG(FCaO_pcp) AS avg_fcao_pcp, AVG(GYPS_pcp) AS avg_gyps_pcp, AVG(LS_pcp) AS avg_ls_pcp, AVG(PZ_pcp) AS avg_pz_pcp, AVG(FA_pcp) AS avg_fa_pcp, AVG(CR_pcp) AS avg_cr_pcp, AVG(BTL_pcp) AS avg_btl_pcp FROM z1_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");


			        $average_result = mysqli_fetch_assoc($average_query);
				        foreach ($average_result as $average) {
				            echo "<td>".number_format($average, 2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM z1_3");
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
			        $max_query = mysqli_query($conn, "SELECT MAX(FEED) AS max_feed, MAX(BLAINE_opc) AS max_blaine_opc, MAX(SO3_opc) AS max_so3_opc, MAX(z145u_opc) AS max_z145u_opc, MAX(z130u_opc) AS max_z130u_opc, MAX(H2O_opc) AS max_h2o_opc, MAX(LOI_opc) AS max_loi_opc, MAX(SiO2_opc) AS max_sio2_opc, MAX(Al2O3_opc) AS max_al2o3_opc, MAX(Fe2O3_opc) AS max_fe2o3_opc, MAX(CaO_opc) AS max_cao_opc, MAX(MgO_opc) AS max_mgo_opc, MAX(K2O_opc) AS max_k2o_opc, MAX(Na2O_opc) AS max_na2o_opc, MAX(Cl2_opc) AS max_cl2_opc, MAX(FCaO_opc) AS max_fcao_opc, MAX(GYPS_opc) AS max_gyps_opc, MAX(LS_opc) AS max_ls_opc, MAX(PZ_opc) AS max_pz_opc, MAX(FA_opc) AS max_fa_opc, MAX(CR_opc) AS max_cr_opc, MAX(BTL_opc) AS max_btl_opc, MAX(ALKALI_opc) AS max_alkali_opc, MAX(BLAINE_pcc) AS max_blaine_pcc, MAX(SO3_pcc) AS max_so3_pcc, MAX(z145u_pcc) AS max_z145u_pcc, MAX(LOI_pcc) AS max_loi_pcc, MAX(SiO2_pcc) AS max_sio2_pcc, MAX(Al2O3_pcc) AS max_al2o3_pcc, MAX(Fe2O3_pcc) AS max_fe2o3_pcc, MAX(CaO_pcc) AS max_cao_pcc, MAX(MgO_pcc) AS max_mgo_pcc, MAX(K2O_pcc) AS max_k2o_pcc, MAX(Na2O_pcc) AS max_na2o_pcc, MAX(Cl2_pcc) AS max_cl2_pcc, MAX(FCaO_pcc) AS max_fcao_pcc, MAX(GYPS_pcc) AS max_gyps_pcc, MAX(LS_pcc) AS max_ls_pcc, MAX(PZ_pcc) AS max_pz_pcc, MAX(FA_pcc) AS max_fa_pcc, MAX(CR_pcc) AS max_cr_pcc, MAX(BTL_pcc) AS max_btl_pcc, MAX(BLAINE_pcp) AS max_blaine_pcp, MAX(SO3_pcp) AS max_so3_pcp, MAX(z145u_pcp) AS max_z145u_pcp, MAX(LOI_pcp) AS max_loi_pcp, MAX(SiO2_pcp) AS max_sio2_pcp, MAX(Al2O3_pcp) AS max_al2o3_pcp, MAX(Fe2O3_pcp) AS max_fe2o3_pcp, MAX(CaO_pcp) AS max_cao_pcp, MAX(MgO_pcp) AS max_mgo_pcp, MAX(K2O_pcp) AS max_k2o_pcp, MAX(Na2O_pcp) AS max_na2o_pcp, MAX(Cl2_pcp) AS max_cl2_pcp, MAX(FCaO_pcp) AS max_fcao_pcp, MAX(GYPS_pcp) AS max_gyps_pcp, MAX(LS_pcp) AS max_ls_pcp, MAX(PZ_pcp) AS max_pz_pcp, MAX(FA_pcp) AS max_fa_pcp, MAX(CR_pcp) AS max_cr_pcp, MAX(BTL_pcp) AS max_btl_pcp FROM z1_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

			         $max_result = mysqli_fetch_assoc($max_query);
				        foreach ($max_result as $max) {
				            echo "<td>".$max."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM z1_3");
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
			       $sd_query = mysqli_query($conn, "SELECT STDDEV(FEED) AS stddev_feed, STDDEV(BLAINE_opc) AS stddev_blaine_opc, STDDEV(SO3_opc) AS stddev_so3_opc, STDDEV(z145u_opc) AS stddev_z145u_opc, STDDEV(z130u_opc) AS stddev_z130u_opc, STDDEV(H2O_opc) AS stddev_h2o_opc, STDDEV(LOI_opc) AS stddev_loi_opc, STDDEV(SiO2_opc) AS stddev_sio2_opc, STDDEV(Al2O3_opc) AS stddev_al2o3_opc, STDDEV(Fe2O3_opc) AS stddev_fe2o3_opc, STDDEV(CaO_opc) AS stddev_cao_opc, STDDEV(MgO_opc) AS stddev_mgo_opc, STDDEV(K2O_opc) AS stddev_k2o_opc, STDDEV(Na2O_opc) AS stddev_na2o_opc, STDDEV(Cl2_opc) AS stddev_cl2_opc, STDDEV(FCaO_opc) AS stddev_fcao_opc, STDDEV(GYPS_opc) AS stddev_gyps_opc, STDDEV(LS_opc) AS stddev_ls_opc, STDDEV(PZ_opc) AS stddev_pz_opc, STDDEV(FA_opc) AS stddev_fa_opc, STDDEV(CR_opc) AS stddev_cr_opc, STDDEV(BTL_opc) AS stddev_btl_opc, STDDEV(ALKALI_opc) AS stddev_alkali_opc, STDDEV(BLAINE_pcc) AS stddev_blaine_pcc, STDDEV(SO3_pcc) AS stddev_so3_pcc, STDDEV(z145u_pcc) AS stddev_z145u_pcc, STDDEV(LOI_pcc) AS stddev_loi_pcc, STDDEV(SiO2_pcc) AS stddev_sio2_pcc, STDDEV(Al2O3_pcc) AS stddev_al2o3_pcc, STDDEV(Fe2O3_pcc) AS stddev_fe2o3_pcc, STDDEV(CaO_pcc) AS stddev_cao_pcc, STDDEV(MgO_pcc) AS stddev_mgo_pcc, STDDEV(K2O_pcc) AS stddev_k2o_pcc, STDDEV(Na2O_pcc) AS stddev_na2o_pcc, STDDEV(Cl2_pcc) AS stddev_cl2_pcc, STDDEV(FCaO_pcc) AS stddev_fcao_pcc, STDDEV(GYPS_pcc) AS stddev_gyps_pcc, STDDEV(LS_pcc) AS stddev_ls_pcc, STDDEV(PZ_pcc) AS stddev_pz_pcc, STDDEV(FA_pcc) AS stddev_fa_pcc, STDDEV(CR_pcc) AS stddev_cr_pcc, STDDEV(BTL_pcc) AS stddev_btl_pcc, STDDEV(BLAINE_pcp) AS stddev_blaine_pcp, STDDEV(SO3_pcp) AS stddev_so3_pcp, STDDEV(z145u_pcp) AS stddev_z145u_pcp, STDDEV(LOI_pcp) AS stddev_loi_pcp, STDDEV(SiO2_pcp) AS stddev_sio2_pcp, STDDEV(Al2O3_pcp) AS stddev_al2o3_pcp, STDDEV(Fe2O3_pcp) AS stddev_fe2o3_pcp, STDDEV(CaO_pcp) AS stddev_cao_pcp, STDDEV(MgO_pcp) AS stddev_mgo_pcp, STDDEV(K2O_pcp) AS stddev_k2o_pcp, STDDEV(Na2O_pcp) AS stddev_na2o_pcp, STDDEV(Cl2_pcp) AS stddev_cl2_pcp, STDDEV(FCaO_pcp) AS stddev_fcao_pcp, STDDEV(GYPS_pcp) AS stddev_gyps_pcp, STDDEV(LS_pcp) AS stddev_ls_pcp, STDDEV(PZ_pcp) AS stddev_pz_pcp, STDDEV(FA_pcp) AS stddev_fa_pcp, STDDEV(CR_pcp) AS stddev_cr_pcp, STDDEV(BTL_pcp) AS stddev_btl_pcp FROM z1_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");


			        $sd_result = mysqli_fetch_assoc($sd_query);
				        foreach ($sd_result as $sd) {
				            echo "<td>".number_format($sd, 2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM z1_3");
				        while($data = mysqli_fetch_array($sql)){
				        }
				    }
				    ?>
			    </tr>  
			</table>
			<table class="adminlist mb-3" border="1" width="500" cellpadding="5">
				<tr class="text-center" >
			           <th colspan="1"></th><th colspan="1"></th> <th colspan="8" > OPC </th> <th colspan="5">PCC </th><th colspan="5">PCC + Z1</th>
			        </tr>

		    <tr bgcolor="#8080FF" style="color:#FFFFFF">
			    <th></th>
			    <th>Total Feed</th>
			    <th>Blaine</th>
			    <th>SO3 </th>
			    <th>45u </th>
			    <th>LOI </th>
			    <th>FCaO</th>
			    <th>CR </th>
			    <th>BTL </th>
			    <th>Alkali </th>
			    <th>Blaine</th>
			    <th>SO3 </th>
			    <th>45u </th>
			    <th>FCaO</th>
			    <th>CR </th>
			    <th>Blaine</th>
			    <th>SO3 </th>
			    <th>45u </th>
			    <th>FCaO</th>
			    <th>CR </th>
			</tr>
			<tr bgcolor="YELLOW" style="color:BLACK">
    <th>DATA IN</th>
	     <?php
				if (isset($_GET['awal']) && isset($_GET['akhir'])) {
				    $awal = $_GET['awal'];
				    $akhir = $_GET['akhir'];

				    $datain_query = mysqli_query($conn, "SELECT 
				        COUNT(IF(FEED < 340, 1, NULL)) AS datain_feedmax,
				        COUNT(IF(FEED > 380, 1, NULL)) AS datain_feedmin,
				        COUNT(IF(BLAINE_opc < 360, 1, NULL)) AS datain_bopcmax,
				        COUNT(IF(BLAINE_opc > 400, 1, NULL)) AS datain_bopcmin,
				        COUNT(IF(SO3_opc < 1, 1, NULL)) AS datain_sopcmax,
				        COUNT(IF(SO3_opc > 1.8, 1, NULL)) AS datain_sopcmin,
				        COUNT(IF(z145u_opc > 8 , 1, NULL)) AS datain_45uopc,
				        COUNT(IF(LOI_opc > 5, 1, NULL)) AS datain_loiopc,
				        COUNT(IF(FCaO_opc > 1.3, 1, NULL)) AS datain_fcaoopc,
				        COUNT(IF(CR_opc < 0.84, 1, NULL)) AS datain_cropcmax,
				        COUNT(IF(CR_opc > 0.88, 1, NULL)) AS datain_cropcmin,
				        COUNT(IF(BTL_opc > 2.7, 1, NULL)) AS datain_btlopc,
				        COUNT(IF(ALKALI_opc > 0.6, 1, NULL)) AS datain_alkaliopc,
				        COUNT(IF(BLAINE_pcc < 430, 1, NULL)) AS datain_bpccmax,
				        COUNT(IF(BLAINE_pcc > 500, 1, NULL)) AS datain_bpccmin,
				        COUNT(IF(SO3_pcc < 1, 1, NULL)) AS datain_spccmax,
				        COUNT(IF(SO3_pcc > 1.8, 1, NULL)) AS datain_spccmin,
				        COUNT(IF(z145u_pcc > 7 , 1, NULL)) AS datain_45upcc,
				        COUNT(IF(FCaO_pcc > 1.1, 1, NULL)) AS datain_fcaopcc,
				        COUNT(IF(CR_pcc < 0.62, 1, NULL)) AS datain_crpccmax,
				        COUNT(IF(CR_pcc > 0.66, 1, NULL)) AS datain_crpccmin,
				        COUNT(IF(BLAINE_pcp < 380, 1, NULL)) AS datain_bpcp,
				        COUNT(IF(SO3_pcp < 1.2, 1, NULL)) AS datain_spcpmax,
				        COUNT(IF(SO3_pcp > 2.4, 1, NULL)) AS datain_spcpmin,
				        COUNT(IF(z145u_pcp > 10 , 1, NULL)) AS datain_45upcp,
				        COUNT(IF(FCaO_pcp > 1.1, 1, NULL)) AS datain_fcaopcp,
				        COUNT(IF(CR_pcp < 0.67, 1, NULL)) AS datain_crpcpmax,
				        COUNT(IF(CR_pcp > 0.71, 1, NULL)) AS datain_crpcpmin
				        FROM z1_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

				    $datain_result = mysqli_fetch_assoc($datain_query);
				    $kolom = array("FEED", "BLAINE_opc", "SO3_opc", "z145u_opc", "LOI_opc","FCaO_opc", "CR_opc", "BTL_opc", "ALKALI_opc","BLAINE_pcc", "SO3_pcc", "z145u_pcc", "FCaO_pcc", "CR_pcc", "BLAINE_pcp", "SO3_pcp", "z145u_pcp", "FCaO_pcp", "CR_pcp");
				    foreach ($kolom as $nama_kolom) {
				        $count = $count_result["count_" . strtolower($nama_kolom)];
				        $datain_feedmax = isset($datain_result["datain_feedmax"]) ? $datain_result["datain_feedmax"] : 0;
				        $datain_feedmin = isset($datain_result["datain_feedmin"]) ? $datain_result["datain_feedmin"] : 0;
				        $datain_bopcmax = isset($datain_result["datain_bopcmax"]) ? $datain_result["datain_bopcmax"] : 0;
				        $datain_bopcmin = isset($datain_result["datain_bopcmin"]) ? $datain_result["datain_bopcmin"] : 0;
				        $datain_sopcmax = isset($datain_result["datain_sopcmax"]) ? $datain_result["datain_sopcmax"] : 0;
				        $datain_sopcmin = isset($datain_result["datain_sopcmin"]) ? $datain_result["datain_sopcmin"] : 0;
				        $datain_45uopc = isset($datain_result["datain_45uopc"]) ? $datain_result["datain_45uopc"] : 0;
				        $datain_loiopc = isset($datain_result["datain_loiopc"]) ? $datain_result["datain_loiopc"] : 0;
				        $datain_fcaoopc = isset($datain_result["datain_fcaoopc"]) ? $datain_result["datain_fcaoopc"] : 0;
				        $datain_cropcmax = isset($datain_result["datain_cropcmax"]) ? $datain_result["datain_cropcmax"] : 0;
				        $datain_cropcmin = isset($datain_result["datain_cropcmin"]) ? $datain_result["datain_cropcmin"] : 0;
				        $datain_btlopc = isset($datain_result["datain_btlopc"]) ? $datain_result["datain_btlopc"] : 0;
				        $datain_alkaliopc = isset($datain_result["datain_alkaliopc"]) ? $datain_result["datain_alkaliopc"] : 0;
				        $datain_bpccmax = isset($datain_result["datain_bpccmax"]) ? $datain_result["datain_bpccmax"] : 0;
				        $datain_bpccmin = isset($datain_result["datain_bpccmin"]) ? $datain_result["datain_bpccmin"] : 0;
				        $datain_spccmax = isset($datain_result["datain_spccmax"]) ? $datain_result["datain_spccmax"] : 0;
				        $datain_spccmin = isset($datain_result["datain_spccmin"]) ? $datain_result["datain_spccmin"] : 0;
				        $datain_45upcc = isset($datain_result["datain_45upcc"]) ? $datain_result["datain_45upcc"] : 0;
				        $datain_fcaopcc = isset($datain_result["datain_fcaopcc"]) ? $datain_result["datain_fcaopcc"] : 0;
				        $datain_crpccmax = isset($datain_result["datain_crpccmax"]) ? $datain_result["datain_crpccmax"] : 0;
				        $datain_crpccmin = isset($datain_result["datain_crpccmin"]) ? $datain_result["datain_crpccmin"] : 0;
				        $datain_bpcp = isset($datain_result["datain_bpcp"]) ? $datain_result["datain_bpcp"] : 0;
				        $datain_spcpmax = isset($datain_result["datain_spcpmax"]) ? $datain_result["datain_spcpmax"] : 0;
				        $datain_spcpmin = isset($datain_result["datain_spcpmin"]) ? $datain_result["datain_spcpmin"] : 0;
				        $datain_45upcp = isset($datain_result["datain_45upcp"]) ? $datain_result["datain_45upcp"] : 0;
				        $datain_fcaopcp = isset($datain_result["datain_fcaopcp"]) ? $datain_result["datain_fcaopcp"] : 0;
				        $datain_crpcpmax = isset($datain_result["datain_crpcpmax"]) ? $datain_result["datain_crpcpmax"] : 0;
				        $datain_crpcpmin = isset($datain_result["datain_crpcpmin"]) ? $datain_result["datain_crpcpmin"] : 0;
				        if ($nama_kolom == "FEED") {
				            $hasil = $count - $datain_feedmax - $datain_feedmin;
				        } elseif ($nama_kolom == "BLAINE_opc") {
				            $hasil = $count - $datain_bopcmax - $datain_bopcmin;
				        } elseif ($nama_kolom == "SO3_opc") {
				            $hasil = $count - $datain_sopcmax - $datain_sopcmin;
				        } elseif ($nama_kolom == "z145u_opc") {
				            $hasil = $count - $datain_45uopc;
				        } elseif ($nama_kolom == "LOI_opc") {
				            $hasil = $count - $datain_loiopc;
				        } elseif ($nama_kolom == "FCaO_opc") {
				            $hasil = $count - $datain_fcaoopc;
				        } elseif ($nama_kolom == "CR_opc") {
				            $hasil = $count - $datain_cropcmax - $datain_cropcmin;
				        } elseif ($nama_kolom == "BTL_opc") {
				            $hasil = $count - $datain_btlopc;
				        } elseif ($nama_kolom == "ALKALI_opc") {
				            $hasil = $count - $datain_alkaliopc;
				        } elseif ($nama_kolom == "BLAINE_pcc") {
				            $hasil = $count - $datain_bpccmax - $datain_bpccmin;
				        } elseif ($nama_kolom == "SO3_pcc") {
				            $hasil = $count - $datain_spccmax - $datain_spccmin;
				        } elseif ($nama_kolom == "z145u_pcc") {
				            $hasil = $count - $datain_45upcc;
				        } elseif ($nama_kolom == "FCaO_pcc") {
				            $hasil = $count - $datain_fcaopcc;
				        } elseif ($nama_kolom == "CR_pcc") {
				            $hasil = $count - $datain_crpccmax - $datain_crpccmin;
				        } elseif ($nama_kolom == "BLAINE_pcp") {
				            $hasil = $count - $datain_bpcp ;
				        } elseif ($nama_kolom == "SO3_pcp") {
				            $hasil = $count - $datain_spcpmax - $datain_spcpmin;
				        } elseif ($nama_kolom == "z145u_pcp") {
				            $hasil = $count - $datain_45upcp;
				        } elseif ($nama_kolom == "FCaO_pcp") {
				            $hasil = $count - $datain_fcaopcp;
				        } elseif ($nama_kolom == "CR_pcp") {
				            $hasil = $count - $datain_crpcpmax - $datain_crpcpmin;
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
				        COUNT(IF(FEED < 340, 1, NULL)) AS datain_feedmax,
				        COUNT(IF(FEED > 380, 1, NULL)) AS datain_feedmin,
				        COUNT(IF(BLAINE_opc < 360, 1, NULL)) AS datain_bopcmax,
				        COUNT(IF(BLAINE_opc > 400, 1, NULL)) AS datain_bopcmin,
				        COUNT(IF(SO3_opc < 1, 1, NULL)) AS datain_sopcmax,
				        COUNT(IF(SO3_opc > 1.8, 1, NULL)) AS datain_sopcmin,
				        COUNT(IF(z145u_opc > 8 , 1, NULL)) AS datain_45uopc,
				        COUNT(IF(LOI_opc > 5, 1, NULL)) AS datain_loiopc,
				        COUNT(IF(FCaO_opc > 1.3, 1, NULL)) AS datain_fcaoopc,
				        COUNT(IF(CR_opc < 0.84, 1, NULL)) AS datain_cropcmax,
				        COUNT(IF(CR_opc > 0.88, 1, NULL)) AS datain_cropcmin,
				        COUNT(IF(BTL_opc > 2.7, 1, NULL)) AS datain_btlopc,
				        COUNT(IF(ALKALI_opc > 0.6, 1, NULL)) AS datain_alkaliopc,
				        COUNT(IF(BLAINE_pcc < 430, 1, NULL)) AS datain_bpccmax,
				        COUNT(IF(BLAINE_pcc > 500, 1, NULL)) AS datain_bpccmin,
				        COUNT(IF(SO3_pcc < 1, 1, NULL)) AS datain_spccmax,
				        COUNT(IF(SO3_pcc > 1.8, 1, NULL)) AS datain_spccmin,
				        COUNT(IF(z145u_pcc > 7 , 1, NULL)) AS datain_45upcc,
				        COUNT(IF(FCaO_pcc > 1.1, 1, NULL)) AS datain_fcaopcc,
				        COUNT(IF(CR_pcc < 0.62, 1, NULL)) AS datain_crpccmax,
				        COUNT(IF(CR_pcc > 0.66, 1, NULL)) AS datain_crpccmin,
				        COUNT(IF(BLAINE_pcp < 380, 1, NULL)) AS datain_bpcp,
				        COUNT(IF(SO3_pcp < 1.2, 1, NULL)) AS datain_spcpmax,
				        COUNT(IF(SO3_pcp > 2.4, 1, NULL)) AS datain_spcpmin,
				        COUNT(IF(z145u_pcp > 10 , 1, NULL)) AS datain_45upcp,
				        COUNT(IF(FCaO_pcp > 1.1, 1, NULL)) AS datain_fcaopcp,
				        COUNT(IF(CR_pcp < 0.67, 1, NULL)) AS datain_crpcpmax,
				        COUNT(IF(CR_pcp > 0.71, 1, NULL)) AS datain_crpcpmin
				        FROM z1_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

				    $datain_result = mysqli_fetch_assoc($datain_query);
				    $kolom = array("FEED", "BLAINE_opc", "SO3_opc", "z145u_opc", "LOI_opc","FCaO_opc", "CR_opc", "BTL_opc", "ALKALI_opc", "BLAINE_pcc", "SO3_pcc", "z145u_pcc", "FCaO_pcc", "CR_pcc", "BLAINE_pcp", "SO3_pcp", "z145u_pcp", "FCaO_pcp", "CR_pcp");
				    foreach ($kolom as $nama_kolom) {
				        $count = $count_result["count_" . strtolower($nama_kolom)];
				        $datain_feedmax = isset($datain_result["datain_feedmax"]) ? $datain_result["datain_feedmax"] : 0;
				        $datain_feedmin = isset($datain_result["datain_feedmin"]) ? $datain_result["datain_feedmin"] : 0;
				        $datain_bopcmax = isset($datain_result["datain_bopcmax"]) ? $datain_result["datain_bopcmax"] : 0;
				        $datain_bopcmin = isset($datain_result["datain_bopcmin"]) ? $datain_result["datain_bopcmin"] : 0;
				        $datain_sopcmax = isset($datain_result["datain_sopcmax"]) ? $datain_result["datain_sopcmax"] : 0;
				        $datain_sopcmin = isset($datain_result["datain_sopcmin"]) ? $datain_result["datain_sopcmin"] : 0;
				        $datain_45uopc = isset($datain_result["datain_45uopc"]) ? $datain_result["datain_45uopc"] : 0;
				        $datain_loiopc = isset($datain_result["datain_loiopc"]) ? $datain_result["datain_loiopc"] : 0;
				        $datain_fcaoopc = isset($datain_result["datain_fcaoopc"]) ? $datain_result["datain_fcaoopc"] : 0;
				        $datain_cropcmax = isset($datain_result["datain_cropcmax"]) ? $datain_result["datain_cropcmax"] : 0;
				        $datain_cropcmin = isset($datain_result["datain_cropcmin"]) ? $datain_result["datain_cropcmin"] : 0;
				        $datain_btlopc = isset($datain_result["datain_btlopc"]) ? $datain_result["datain_btlopc"] : 0;
				        $datain_alkaliopc = isset($datain_result["datain_alkaliopc"]) ? $datain_result["datain_alkaliopc"] : 0;
				        $datain_bpccmax = isset($datain_result["datain_bpccmax"]) ? $datain_result["datain_bpccmax"] : 0;
				        $datain_bpccmin = isset($datain_result["datain_bpccmin"]) ? $datain_result["datain_bpccmin"] : 0;
				        $datain_spccmax = isset($datain_result["datain_spccmax"]) ? $datain_result["datain_spccmax"] : 0;
				        $datain_spccmin = isset($datain_result["datain_spccmin"]) ? $datain_result["datain_spccmin"] : 0;
				        $datain_45upcc = isset($datain_result["datain_45upcc"]) ? $datain_result["datain_45upcc"] : 0;
				        $datain_fcaopcc = isset($datain_result["datain_fcaopcc"]) ? $datain_result["datain_fcaopcc"] : 0;
				        $datain_crpccmax = isset($datain_result["datain_crpccmax"]) ? $datain_result["datain_crpccmax"] : 0;
				        $datain_crpccmin = isset($datain_result["datain_crpccmin"]) ? $datain_result["datain_crpccmin"] : 0;
				        $datain_bpcp = isset($datain_result["datain_bpcp"]) ? $datain_result["datain_bpcp"] : 0;
				        $datain_spcpmax = isset($datain_result["datain_spcpmax"]) ? $datain_result["datain_spcpmax"] : 0;
				        $datain_spcpmin = isset($datain_result["datain_spcpmin"]) ? $datain_result["datain_spcpmin"] : 0;
				        $datain_45upcp = isset($datain_result["datain_45upcp"]) ? $datain_result["datain_45upcp"] : 0;
				        $datain_fcaopcp = isset($datain_result["datain_fcaopcp"]) ? $datain_result["datain_fcaopcp"] : 0;
				        $datain_crpcpmax = isset($datain_result["datain_crpcpmax"]) ? $datain_result["datain_crpcpmax"] : 0;
				        $datain_crpcpmin = isset($datain_result["datain_crpcpmin"]) ? $datain_result["datain_crpcpmin"] : 0;
				        if ($nama_kolom == "FEED") {
				            $hasil = $count - $datain_feedmax - $datain_feedmin;
				        } elseif ($nama_kolom == "BLAINE_opc") {
				            $hasil = $count - $datain_bopcmax - $datain_bopcmin;
				        } elseif ($nama_kolom == "SO3_opc") {
				            $hasil = $count - $datain_sopcmax - $datain_sopcmin;
				        } elseif ($nama_kolom == "z145u_opc") {
				            $hasil = $count - $datain_45uopc;
				        } elseif ($nama_kolom == "LOI_opc") {
				            $hasil = $count - $datain_loiopc;
				        } elseif ($nama_kolom == "FCaO_opc") {
				            $hasil = $count - $datain_fcaoopc;
				        } elseif ($nama_kolom == "CR_opc") {
				            $hasil = $count - $datain_cropcmax - $datain_cropcmin;
				        } elseif ($nama_kolom == "BTL_opc") {
				            $hasil = $count - $datain_btlopc;
				        } elseif ($nama_kolom == "ALKALI_opc") {
				            $hasil = $count - $datain_alkaliopc;
				        } elseif ($nama_kolom == "BLAINE_pcc") {
				            $hasil = $count - $datain_bpccmax - $datain_bpccmin;
				        } elseif ($nama_kolom == "SO3_pcc") {
				            $hasil = $count - $datain_spccmax - $datain_spccmin;
				        } elseif ($nama_kolom == "z145u_pcc") {
				            $hasil = $count - $datain_45upcc;
				        } elseif ($nama_kolom == "FCaO_pcc") {
				            $hasil = $count - $datain_fcaopcc;
				        } elseif ($nama_kolom == "CR_pcc") {
				            $hasil = $count - $datain_crpccmax - $datain_crpccmin;
				        } elseif ($nama_kolom == "BLAINE_pcp") {
				            $hasil = $count - $datain_bpcp ;
				        } elseif ($nama_kolom == "SO3_pcp") {
				            $hasil = $count - $datain_spcpmax - $datain_spcpmin;
				        } elseif ($nama_kolom == "z145u_pcp") {
				            $hasil = $count - $datain_45upcp;
				        } elseif ($nama_kolom == "FCaO_pcp") {
				            $hasil = $count - $datain_fcaopcp;
				        } elseif ($nama_kolom == "CR_pcp") {
				            $hasil = $count - $datain_crpcpmax - $datain_crpcpmin;
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
	                <a href="exportz1.php" class="btn btn-primary" > Download </a>
	            </div>
	        </div>        
	    </div>
	</div>
	    


		<div>
			 <table class="table table-striped table-bordered table-hover">
				<thead>

					<tr class="text-center" >
			             <th rowspan="2" class="freeze1">TANGGAL</th><th rowspan="2" class="freeze2">JAM</th><th rowspan="2" class="freeze3">EMISI CO2 (TON)</th> <th rowspan="2" class="freeze4">TOTAL FEED</th> <th colspan="5">OPC(UltraPro)</th><th  colspan="9">OKSIDA</th><th colspan="4">PROPORSI</th><th colspan="3">ESTIMASI</th><th rowspan="2" >ALKALI OPC</th><th rowspan="2" >TYPE</th> <th rowspan="2" >SILO</th><th colspan="3">PCC(EzPro)</th><th colspan="9">OKSIDA</th><th colspan="4">PROPORSI</th><th colspan="3">ESTIMASI</th><th rowspan="2" >SILO</th><th colspan="3">PCC+(PwrPro)</th><th colspan="9">OKSIDA</th><th colspan="4">PROPORSI</th><th colspan="3">ESTIMASI</th><th rowspan="2" >SILO</th>
			        </tr>

					<tr class="bg-primary text-white">
						
					<th>BLAINE</th><th>SO3</th><th>45u</th><th>30u</th><th>H2O</th><th>SiO2</th><th>Al2O3</th><th>Fe2O3</th><th>CaO</th><th>MgO</th><th>K2O</th><th>Na2O</th><th>Cl2</th><th>FCaO</th><th>GYPS</th><th>LS</th><th>PZ</th><th>FA</th><th>CR</th><th>LOI</th><th>BTL</th><th>BLAINE</th><th>SO3</th><th>45u</th><th>SiO2</th><th>Al2O3</th><th>Fe2O3</th><th>CaO</th><th>MgO</th><th>K2O</th><th>Na2O</th><th>Cl2</th><th>FCaO</th><th>GYPS</th><th>LS</th><th>PZ</th><th>FA</th><th>CR</th><th>LOI</th><th>BTL</th><th>BLAINE</th><th>SO3</th><th>45u</th><th>SiO2</th><th>Al2O3</th><th>Fe2O3</th><th>CaO</th><th>MgO</th><th>K2O</th><th>Na2O</th><th>Cl2</th><th>FCaO</th><th>GYPS</th><th>LS</th><th>PZ</th><th>FA</th><th>CR</th><th>LOI</th><th>BTL</th><th>REPORT</th>

						<th class="text-center">Action</th>
					</tr>
				</thead>

				<tbody>
					    <?php
					    $n = $awalData;
					    $stmt = $conn->query('SELECT * FROM tbconfig');
						$configs = [];
						while ($row = mysqli_fetch_assoc($stmt)) {
						    $configs[$row['nama_config']] = $row['nilai'];
						}

					    while ($d = mysqli_fetch_array($q)) {
						$btl_opc = null;
						$prev_loi_opc = isset($prev_loi_opc) ? $prev_loi_opc : 4; 
						$first_opc = true;

						if (!empty($d['LOI_opc'])) {
						    $loi_opc = $d['LOI_opc'];
						    $prev_loi_opc = $loi_opc; 
						} else {
						    $loi_opc = $prev_loi_opc; 
						}

					    if (!empty($d['SO3_opc'])) {
					        if ($d['Fe2O3_opc'] >= 3.6 && $d['FA_opc'] > 0) {
					            $btl_opc = $configs['int2'] + $configs['loi2'] * $loi_opc + $configs['s2'] * $d['SO3_opc'] + $configs['ca2'] * $d['CaO_opc'] + $configs['fe2'] * $d['Fe2O3_opc'] + $configs['al2'] * $d['Al2O3_opc'] + $configs['si2']* $d['SiO2_opc'] - 1.2;
					        } else {
					            $btl_opc = $configs['int2'] + $configs['loi2'] * $loi_opc + $d['SO3_opc'] * $configs['s2'] + $configs['ca2'] * $d['CaO_opc'] + $configs['fe2'] * $d['Fe2O3_opc'] + $configs['al2'] * $d['Al2O3_opc'] + $configs['si2'] * $d['SiO2_opc'] - 2;
					        }
					    }
					    $btl_opc = !empty($btl_opc) ? number_format((float)$btl_opc, 2, '.', '') : null; 

					     $cr_opc = null;
					    if (!empty($d['SO3_opc'])) {
					        if ($d['Fe2O3_opc'] >= 3.2 && $d['FA_opc'] > 0) {
					            $cr_opc = 1.007 - 0.011 * $btl_opc - 0.012 * $d['SO3_opc'] - 0.023 * $loi_opc - 0.01;
					        } else {
					            $cr_opc = 1.007 - 0.011 * $btl_opc - 0.012 * $d['SO3_opc'] - 0.023 * $loi_opc;
					        }
					    }
					    $cr_opc = !empty($cr_opc) ? number_format((float)$cr_opc, 2, '.', '') : null;

					    $first_opc = false; 


						$alkali_opc = null;
							if (!empty($d['Na2O_opc']) || !empty($d['K2O_opc'])) {
							    $alkali_opc =  $d['Na2O_opc'] + ($d['K2O_opc'] * 0.658);
							}
							$alkali_opc = !is_null($alkali_opc) ? number_format((float)$alkali_opc, 2, '.', '') : null;

						$btl_pcc = null;
						$prev_loi_pcc = isset($prev_loi_pcc) ? $prev_loi_pcc : 9; 
						$first_pcc = true;

						if (!empty($d['LOI_pcc'])) {
						    $loi_pcc = $d['LOI_pcc'];
						    $prev_loi_pcc = $loi_pcc; 
						} else {
						    $loi_pcc = $prev_loi_pcc; 
						}
					    if (!empty($d['SO3_pcc'])) {
					        if ($d['Fe2O3_pcc'] >= 3.15 && $d['FA_pcc'] > 0) {
					            $btl_pcc = $configs['int2'] + $configs['loi2'] * $loi_pcc + $configs['s2'] * $d['SO3_pcc'] + $configs['ca2'] * $d['CaO_pcc'] + $configs['fe2'] * $d['Fe2O3_pcc'] + $configs['al2'] * $d['Al2O3_pcc'] + $configs['si2'] * $d['SiO2_pcc'] - 1;
					        } else {
					            $btl_pcc = $configs['int2'] + $configs['loi2'] * $loi_pcc + $d['SO3_pcc'] * $configs['s2'] + $configs['ca2'] * $d['CaO_pcc'] + $configs['fe2'] * $d['Fe2O3_pcc'] + $configs['al2'] * $d['Al2O3_pcc'] + $configs['si2'] * $d['SiO2_pcc'] - 1;
					        }
					    }
					    $btl_pcc = !empty($btl_pcc) ? number_format((float)$btl_pcc, 2, '.', '') : null; 

					    $cr_pcc = null;
					    if (!empty($d['SO3_pcc'])) {
					        if ($d['Fe2O3_pcc'] >= 3.2 && $d['FA_pcc'] > 0) {
					            $cr_pcc = 1.007 - 0.011 * $btl_pcc - 0.012 * $d['SO3_pcc'] - 0.023 * $loi_pcc - 0.01;
					        } else {
					            $cr_pcc = 1.007 - 0.011 * $btl_pcc - 0.012 * $d['SO3_pcc'] - 0.023 * $loi_pcc;
					        }
					    }
					    $cr_pcc = !empty($cr_pcc) ? number_format((float)$cr_pcc, 2, '.', '') : null;

					    $first_pcc = false; 

						$btl_pcp = null;
						$prev_loi_pcp = isset($prev_loi_pcp) ? $prev_loi_pcp : 7; 
						$first_pcp = true;

						if (!empty($d['LOI_pcp'])) {
						    $loi_pcp = $d['LOI_pcp'];
						    $prev_loi_pcp = $loi_pcp; 
						} else {
						    $loi_pcp = $prev_loi_pcp; 
						}
					    if (!empty($d['SO3_pcp'])) {
					        if ($d['Fe2O3_pcp'] >= 3.15 && $d['FA_pcp'] > 0) {
					            $btl_pcp = $configs['int2'] + $configs['loi2'] * $loi_pcp + $configs['s2'] * $d['SO3_pcp'] + $configs['ca2'] * $d['CaO_pcp'] + $configs['fe2'] * $d['Fe2O3_pcp'] + $configs['al2'] * $d['Al2O3_pcp'] + $configs['si2'] * $d['SiO2_pcp'] - 1;
					        } else {
					            $btl_pcp = $configs['int2'] + $configs['loi2'] * $loi_pcp + $d['SO3_pcp'] * $configs['s2'] + $configs['ca2'] * $d['CaO_pcp'] + $configs['fe2'] * $d['Fe2O3_pcp'] + $configs['al2'] * $d['Al2O3_pcp'] + $configs['si2'] * $d['SiO2_pcp'] - 1;
					        }
					    }
					    $btl_pcp = !empty($btl_pcp) ? number_format((float)$btl_pcp, 2, '.', '') : null; 

					    $cr_pcp= null;
					    if (!empty($d['SO3_pcp'])) {
					        if ($d['Fe2O3_pcp'] >= 3.2 && $d['FA_pcp'] > 0) {
					            $cr_pcp= 1.007 - 0.011 * $btl_pcp- 0.012 * $d['SO3_pcp'] - 0.023 * $loi_pcp- 0.01;
					        } else {
					            $cr_pcp= 1.007 - 0.011 * $btl_pcp- 0.012 * $d['SO3_pcp'] - 0.023 * $loi_pcp;
					        }
					    }
					    $cr_pcp= !empty($cr_pcp) ? number_format((float)$cr_pcp, 2, '.', '') : null;
 
					    $first_pcp = false; 


						$ton_emisi = null;
						if (!empty($cr_opc)) {
						    $ton_emisi = 0.525 * $cr_opc;
						} elseif (!empty($cr_pcc)) {
						    $ton_emisi = 0.525 * $cr_pcc;
						} elseif (!empty($cr_pcp)) {
						    $ton_emisi = 0.525 * $cr_pcp * $d['FEED'];
						}
						$ton_emisi = !empty($ton_emisi) ? number_format((float)$ton_emisi, 2, '.', '') : null;


						$update_query = "UPDATE z1_3 SET EMISI=?, CR_opc=?, BTL_opc=?, ALKALI_opc=?, CR_pcc=?, BTL_pcc=?, CR_pcp=?, BTL_pcp=? WHERE id=?";

						if ($stmt = mysqli_prepare($conn, $update_query)) {
						    mysqli_stmt_bind_param($stmt, "dddddddsi", $ton_emisi, $cr_opc, $btl_opc, $alkali_opc, $cr_pcc, $btl_pcc, $cr_pcp, $btl_pcp, $d['id']);

						    if (mysqli_stmt_execute($stmt)) {
						        echo " ";
						    } else {
						        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						    }

						    mysqli_stmt_close($stmt);
						} else {
						    echo "Error: Unable to prepare statement.";
						}

						$stmt = $conn->query('SELECT * FROM tb_config');
						if (!$stmt) {
						    die("Query error: " . mysqli_error($conn));
						}

						while ($row = mysqli_fetch_assoc($stmt)) {
						    $configs[$row['nama_config']] = [
						        'max' => $row['max'],
						        'min' => $row['min']
						    ];
						}

							$w_fcaopcc = '';
					        if ($d['FCaO_pcc'] > $configs['FCaOpcc']['max'] ) {
					            $w_fcaopcc = 'text-danger';
					        }
					        $w_fcaopcp = '';
					        if ($d['FCaO_pcp'] > $configs['FCaOppc']['max'] ) {
					            $w_fcaopcp = 'text-danger';
					        }
					        $w_fcaoopc = '';
					        if ($d['FCaO_opc'] > $configs['FCaOopc']['max'] ) {
					            $w_fcaoopc = 'text-danger';
					        }
					        $w_alkali = '';
					        if ($d['ALKALI_opc'] > $configs['ALKALIopc']['max'] ) {
					            $w_alkali = 'text-danger';
					        }
					        $w_loipcp = '';
					        if ($d['LOI_pcp'] > $configs['LOIppc']['max'] ) {
					            $w_loipcp = 'text-danger';
					        }$w_loiopc = '';
					        if ($d['LOI_opc'] > $configs['LOIopc']['max'] ) {
					            $w_loiopc = 'text-danger';
					        }$w_45upcp = '';
					        if ($d['z145u_pcp'] > $configs['z145uppc']['max'] ) {
					            $w_45upcp = 'text-danger';
					        }
					        $w_45upcc = '';
					        if ($d['z145u_pcc'] > $configs['z145upcc']['max'] ) {
					            $w_45upcc = 'text-danger';
					        }$w_45uopc = '';
					        if ($d['z145u_opc'] > $configs['z145uopc']['max'] ) {
					            $w_45uopc = 'text-danger';
					        }
					        $w_so3pcp = '';
							if ($d['SO3_pcp'] < $configs['SO3ppc']['min'] || $d['SO3_pcp'] > $configs['SO3ppc']['max']) {
							    $w_so3pcp = 'text-danger';
							}
							$w_so3pcc = '';
							if ($d['SO3_pcc'] < $configs['SO3pcc']['min'] || $d['SO3_pcc'] > $configs['SO3pcc']['max']) {
							    $w_so3pcc = 'text-danger';
							}
							$w_so3opc = '';
							if ($d['SO3_opc'] < $configs['SO3opc']['min'] || $d['SO3_opc'] > $configs['SO3opc']['max']) {
							    $w_so3opc = 'text-danger';
							}
					        $w_blainepcp = '';
					        if ($d['BLAINE_pcp'] < $configs['BLAINEppc']['min']  ) {
					            $w_blainepcp = 'text-danger';
					        }
					        $w_blainepcc = '';
					        if ($d['BLAINE_pcc'] < $configs['BLAINEpcc']['min'] || $d['BLAINE_pcc'] > $configs['BLAINEpcc']['max']) {
					            $w_blainepcc = 'text-danger';
					        }
					         $w_blaineopc = '';
					        if ($d['BLAINE_opc'] < $configs['BLAINEopc']['min'] ) {
					            $w_blaineopc = 'text-danger';
					        }
					        $w_btlpcp  = '';
							if ($btl_pcp > $configs['BTLppc']['max']) {
							    $w_btlpcp = 'text-danger';
							}
					        $w_btlpcc  = '';
							if ($btl_pcc > $configs['BTLpcc']['max']) {
							    $w_btlpcc = 'text-danger';
							}
							$w_btlopc  = '';
							if ($btl_opc > $configs['BTLopc']['max']) {
							    $w_btlopc = 'text-danger';
							}
							$w_crpcp = '';
							if ($cr_pcp < 0.67 || $cr_pcp > 0.71) {
							    $w_crpcp = 'text-danger';
							}
							$w_crpcc = '';
							if ($cr_pcc < 0.6 || $cr_pcc > 0.63) {
							    $w_crpcc = 'text-danger';
							}
							$w_cropc = '';
							if ($cr_opc < 0.84 || $cr_opc > 0.88) {
							    $w_cropc = 'text-danger';
							}

					    ?>

					        	<td class="freeze1"><?php echo htmlspecialchars($d['TANGGAL']); ?></td>
					            <td class="freeze2"><?php echo htmlspecialchars($d['JAM']); ?></td>
					            <td class="freeze3"><?php echo htmlspecialchars($ton_emisi); ?></td>
					            <td class="freeze4"><?php echo htmlspecialchars($d['FEED']); ?></td>
					            <td class="<?php echo $w_blaineopc; ?>"><?php echo htmlspecialchars($d['BLAINE_opc']); ?></td> 
					            <td class="<?php echo $w_so3opc; ?>"><?php echo htmlspecialchars($d['SO3_opc']); ?></td>
					            <td class="<?php echo $w_45uopc; ?>"><?php echo htmlspecialchars($d['z145u_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['z130u_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['H2O_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['SiO2_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['Al2O3_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['Fe2O3_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['CaO_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['MgO_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['K2O_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['Na2O_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['Cl2_opc']); ?></td>
					            <td class="<?php echo $w_fcaoopc; ?>"><?php echo htmlspecialchars($d['FCaO_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['GYPS_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['LS_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['PZ_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['FA_opc']* 100, 2) . '%'; ?></td>
					            <td class="<?php echo $w_cropc; ?>"><?php echo htmlspecialchars($cr_opc * 100, 2) . '%'; ?></td>
					            <td class="<?php echo $w_loiopc; ?>"><?php echo htmlspecialchars($d['LOI_opc']); ?></td>
					            <td class="<?php echo $w_btlopc; ?>"><?php echo htmlspecialchars($btl_opc); ?></td>
					            <td class="<?php echo $w_alkali; ?>"><?php echo htmlspecialchars($alkali_opc); ?></td> 
					            <td><?php echo htmlspecialchars($d['TYPE_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['SILO_opc']); ?></td>
					            <td class="<?php echo $w_blainepcc; ?>"><?php echo htmlspecialchars($d['BLAINE_pcc']); ?></td> 
					            <td class="<?php echo $w_so3pcc; ?>"><?php echo htmlspecialchars($d['SO3_pcc']); ?></td>
					            <td class="<?php echo $w_45upcc; ?>"><?php echo htmlspecialchars($d['z145u_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['SiO2_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['Al2O3_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['Fe2O3_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['CaO_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['MgO_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['K2O_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['Na2O_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['Cl2_pcc']); ?></td>
					            <td class="<?php echo $w_fcaopcc; ?>"><?php echo htmlspecialchars($d['FCaO_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['GYPS_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['LS_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['PZ_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['FA_pcc']* 100, 2) . '%'; ?></td>
					            <td class="<?php echo $w_crpcc; ?>"><?php echo htmlspecialchars($cr_pcc * 100, 2) . '%'; ?></td>
					            <td><?php echo htmlspecialchars($d['LOI_pcc']); ?></td>
					            <td class="<?php echo $w_btlpcc; ?>"><?php echo htmlspecialchars($btl_pcc); ?></td>
					            <td><?php echo htmlspecialchars($d['SILO_pcc']); ?></td>
					            <td class="<?php echo $w_blainepcp; ?>"><?php echo htmlspecialchars($d['BLAINE_pcp']); ?></td> 
					            <td class="<?php echo $w_so3pcp; ?>"><?php echo htmlspecialchars($d['SO3_pcp']); ?></td>
					            <td class="<?php echo $w_45upcp; ?>"><?php echo htmlspecialchars($d['z145u_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['SiO2_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['Al2O3_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['Fe2O3_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['CaO_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['MgO_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['K2O_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['Na2O_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['Cl2_pcp']); ?></td>
					            <td class="<?php echo $w_fcaopcp; ?>"><?php echo htmlspecialchars($d['FCaO_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['GYPS_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['LS_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['PZ_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['FA_pcp']* 100, 2) . '%'; ?></td>
					            <td class="<?php echo $w_crpcp; ?>"><?php echo htmlspecialchars($cr_pcc * 100, 2) . '%'; ?></td>
					            <td class="<?php echo $w_loipcp; ?>"><?php echo htmlspecialchars($d['LOI_pcp']); ?></td>
					            <td class="<?php echo $w_btlpcp; ?>"><?php echo htmlspecialchars($btl_pcp); ?></td>
					            <td><?php echo htmlspecialchars($d['SILO_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['waktu']); ?> <a><?php echo htmlspecialchars($d['iduser']); ?></a></td>

					            
					            <td align="center">
					                <a href="#" type="button" style="height:34px" class="btn btn-success btn-md  pl-4 pr-4" data-toggle="modal" data-target="#myModal<?php echo $d['id']; ?>"><i class="fa fa-fw fa-edit"></i>Edit</a>
					                <a href="del-z1.php?delId=<?php echo $d['id']; ?>" type="button" class="btn btn-danger" style="height:34px" onClick="return confirm('Are you sure to delete this data?');"><i class="fa fa-fw fa-trash"></i> Delete</a>
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
											$sql = "SELECT * FROM z1_3 where id ='$id' order by id";
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
													<label for="FEED" class="col-sm-4 col-form-label">TOTAL FEED</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="FEED_e" name="FEED_e" value="<?= $row['FEED']; ?>">
													</div>
												</div>
												<br></br>
												<div class="text-center"> 
												    <label class="text-center">OPC Z1</label>
												</div>
												<div class="form-group row my-0">
												    <label for="BLAINE_opc" class="col-sm-4 col-form-label">BLAIN</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="BLAINE_opc_e" name="BLAINE_opc_e" value="<?= $row['BLAINE_opc']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="SO3_opc" class="col-sm-4 col-form-label">SO3</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="SO3_opc_e" name="SO3_opc_e" value="<?= $row['SO3_opc']; ?>">
												    </div>
												</div>
												
												<div class="form-group row my-0">
													<label for="z145u_opc" class="col-sm-4 col-form-label">45u</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="z145u_opc_e" name="z145u_opc_e" value="<?= $row['z145u_opc']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="z130u_opc" class="col-sm-4 col-form-label">30u</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="z130u_opc_e" name="z130u_opc_e" value="<?= $row['z130u_opc']; ?>">
													</div>
												</div>
												<div class="form-group row my-0">
												    <label for="H2O_opc" class="col-sm-4 col-form-label">H2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="H2O_opc_e" name="H2O_opc_e" value="<?= $row['H2O_opc']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
													<label for="LOI_opc" class="col-sm-4 col-form-label">LOI</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="LOI_opc_e" name="LOI_opc_e" value="<?= $row['LOI_opc']; ?>">
													</div>
												</div>
												<div class="form-group row my-0">
													<label for="SiO2_opc" class="col-sm-4 col-form-label">SiO2</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="SiO2_opc_e" name="SiO2_opc_e" value="<?= $row['SiO2_opc']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Al2O3_opc" class="col-sm-4 col-form-label">Al2O3</label>
													<div class="col-sm-8">
														<input type="Al2O3_opc" style="height:30px" class="form-control" id="Al2O3_opc_e" name="Al2O3_opc_e" value="<?= $row['Al2O3_opc']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Fe2O3_opc" class="col-sm-4 col-form-label">Fe2O3</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="Fe2O3_opc_e" name="Fe2O3_opc_e" value="<?= $row['Fe2O3_opc']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="CaO_opc" class="col-sm-4 col-form-label">CaO</label>
													<div class="col-sm-8">
														<input type="CaO_opc" style="height:30px" class="form-control" id="CaO_opc_e" name="CaO_opc_e" value="<?= $row['CaO_opc']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
												    <label for="MgO_opc" class="col-sm-4 col-form-label">MgO</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="MgO_opc_e" name="MgO_opc_e" value="<?= $row['MgO_opc']; ?>">
												    </div>
												</div>
												
												<div class="form-group row my-0">
												    <label for="K2O_opc" class="col-sm-4 col-form-label">K2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="K2O_opc_e" name="K2O_opc_e" value="<?= $row['K2O_opc']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="Na2O_opc" class="col-sm-4 col-form-label">Na2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="Na2O_opc_e" name="Na2O_opc_e" value="<?= $row['Na2O_opc']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="Cl2_opc" class="col-sm-4 col-form-label">Cl2</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="Cl2_opc_e" name="Cl2_opc_e" value="<?= $row['Cl2_opc']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="FCaO_opc" class="col-sm-4 col-form-label">FCaO</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="FCaO_opc_e" name="FCaO_opc_e" value="<?= $row['FCaO_opc']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="GYPS_opc" class="col-sm-4 col-form-label">GYPS</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="GYPS_opc_e" name="GYPS_opc_e" value="<?= $row['GYPS_opc']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="LS_opc" class="col-sm-4 col-form-label">LS</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="LS_opc_e" name="LS_opc_e" value="<?= $row['LS_opc']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="PZ_opc" class="col-sm-4 col-form-label">PZ</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="PZ_opc_e" name="PZ_opc_e" value="<?= $row['PZ_opc']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="TYPE_opc" class="col-sm-4 col-form-label">TYPE</label>
												    <div class="col-sm-8">
												        <select name="TYPE_opc_e" id="TYPE_opc_e" style="height:30px" class="form-control">
												            <option value=""></option> 
												            <option value="TIPE1" <?= ($row['TYPE_opc'] == 'TIPE1') ? 'selected' : '' ?>>TIPE1</option>
												            <option value="OPC+" <?= ($row['TYPE_opc'] == 'OPC++') ? 'selected' : '' ?>>OPC+</option>
												            <option value="42.5N" <?= ($row['TYPE_opc'] == '42.5N') ? 'selected' : '' ?>>42.5N</option>
												            <option value="52.5N" <?= ($row['TYPE_opc'] == '52.5N') ? 'selected' : '' ?>>52.5N</option>
												            <option value="EXPORT" <?= ($row['TYPE_opc'] == 'EXPORT') ? 'selected' : '' ?>>EXPORT</option>
												        </select>
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="SILO_opc" class="col-sm-4 col-form-label">SILO</label>
												    <div class="col-sm-8">
												        <select name="SILO_opc_e" id="SILO_opc_e" style="height:30px" class="form-control">
												            <option value=""></option> 
												            <option value="1" <?= ($row['SILO_opc'] == '1') ? 'selected' : '' ?>>1</option>
												            <option value="2" <?= ($row['SILO_opc'] == '2') ? 'selected' : '' ?>>2</option>
												            <option value="3" <?= ($row['SILO_opc'] == '3') ? 'selected' : '' ?>>3</option>
												            <option value="4" <?= ($row['SILO_opc'] == '4') ? 'selected' : '' ?>>4</option>
												            <option value="5" <?= ($row['SILO_opc'] == '5') ? 'selected' : '' ?>>5</option>
												            <option value="6" <?= ($row['SILO_opc'] == '6') ? 'selected' : '' ?>>6</option>
												            <option value="7" <?= ($row['SILO_opc'] == '7') ? 'selected' : '' ?>>7</option>
												            <option value="8" <?= ($row['SILO_opc'] == '8') ? 'selected' : '' ?>>8</option>
												           
												        </select>
												    </div>
												</div>
												<br></br>
												<div class="text-center"> 
												    <label class="text-center">PCC Z1</label>
												</div>
												<div class="form-group row my-0">
												    <label for="BLAINE_pcc" class="col-sm-4 col-form-label">BLAIN</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="BLAINE_pcc_e" name="BLAINE_pcc_e" value="<?= $row['BLAINE_pcc']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="SO3_pcc" class="col-sm-4 col-form-label">SO3</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="SO3_pcc_e" name="SO3_pcc_e" value="<?= $row['SO3_pcc']; ?>">
												    </div>
												</div>
												
												<div class="form-group row my-0">
													<label for="z145u_pcc" class="col-sm-4 col-form-label">45u</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="z145u_pcc_e" name="z145u_pcc_e" value="<?= $row['z145u_pcc']; ?>">
													</div>
												</div>
												<div class="form-group row my-0">
													<label for="LOI_pcc" class="col-sm-4 col-form-label">LOI</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="LOI_pcc_e" name="LOI_pcc_e" value="<?= $row['LOI_pcc']; ?>">
													</div>
												</div>
												<div class="form-group row my-0">
													<label for="SiO2_pcc" class="col-sm-4 col-form-label">SiO2</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="SiO2_pcc_e" name="SiO2_pcc_e" value="<?= $row['SiO2_pcc']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Al2O3_pcc" class="col-sm-4 col-form-label">Al2O3</label>
													<div class="col-sm-8">
														<input type="Al2O3_pcc" style="height:30px" class="form-control" id="Al2O3_pcc_e" name="Al2O3_pcc_e" value="<?= $row['Al2O3_pcc']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Fe2O3_pcc" class="col-sm-4 col-form-label">Fe2O3</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="Fe2O3_pcc_e" name="Fe2O3_pcc_e" value="<?= $row['Fe2O3_pcc']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="CaO_pcc" class="col-sm-4 col-form-label">CaO</label>
													<div class="col-sm-8">
														<input type="CaO_pcc" style="height:30px" class="form-control" id="CaO_pcc_e" name="CaO_pcc_e" value="<?= $row['CaO_pcc']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
												    <label for="MgO_pcc" class="col-sm-4 col-form-label">MgO</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="MgO_pcc_e" name="MgO_pcc_e" value="<?= $row['MgO_pcc']; ?>">
												    </div>
												</div>
												
												<div class="form-group row my-0">
												    <label for="K2O_pcc" class="col-sm-4 col-form-label">K2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="K2O_pcc_e" name="K2O_pcc_e" value="<?= $row['K2O_pcc']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="Na2O_pcc" class="col-sm-4 col-form-label">Na2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="Na2O_pcc_e" name="Na2O_pcc_e" value="<?= $row['Na2O_pcc']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="Cl2_pcc" class="col-sm-4 col-form-label">Cl2</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="Cl2_pcc_e" name="Cl2_pcc_e" value="<?= $row['Cl2_pcc']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="FCaO_pcc" class="col-sm-4 col-form-label">FCaO</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="FCaO_pcc_e" name="FCaO_pcc_e" value="<?= $row['FCaO_pcc']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="GYPS_pcc" class="col-sm-4 col-form-label">GYPS</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="GYPS_pcc_e" name="GYPS_pcc_e" value="<?= $row['GYPS_pcc']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="LS_pcc" class="col-sm-4 col-form-label">LS</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="LS_pcc_e" name="LS_pcc_e" value="<?= $row['LS_pcc']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="PZ_pcc" class="col-sm-4 col-form-label">PZ</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="PZ_pcc_e" name="PZ_pcc_e" value="<?= $row['PZ_pcc']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="SILO_pcc" class="col-sm-4 col-form-label">SILO</label>
												    <div class="col-sm-8">
												        <select name="SILO_pcc_e" id="SILO_pcc_e" style="height:30px" class="form-control">
												            <option value=""></option> 
												            <option value="1" <?= ($row['SILO_pcc'] == '1') ? 'selected' : '' ?>>1</option>
												            <option value="2" <?= ($row['SILO_pcc'] == '2') ? 'selected' : '' ?>>2</option>
												            <option value="3" <?= ($row['SILO_pcc'] == '3') ? 'selected' : '' ?>>3</option>
												            <option value="4" <?= ($row['SILO_pcc'] == '4') ? 'selected' : '' ?>>4</option>
												            <option value="5" <?= ($row['SILO_pcc'] == '5') ? 'selected' : '' ?>>5</option>
												            <option value="6" <?= ($row['SILO_pcc'] == '6') ? 'selected' : '' ?>>6</option>
												            <option value="7" <?= ($row['SILO_pcc'] == '7') ? 'selected' : '' ?>>7</option>
												            <option value="8" <?= ($row['SILO_pcc'] == '8') ? 'selected' : '' ?>>8</option>
												           
												        </select>
												    </div>
												</div>
												<br></br>
												<div class="text-center"> 
												    <label class="text-center">PCC+ Z1</label>
												</div>
												<div class="form-group row my-0">
												    <label for="BLAINE_pcp" class="col-sm-4 col-form-label">BLAIN</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="BLAINE_pcp_e" name="BLAINE_pcp_e" value="<?= $row['BLAINE_pcp']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="SO3_pcp" class="col-sm-4 col-form-label">SO3</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="SO3_pcp_e" name="SO3_pcp_e" value="<?= $row['SO3_pcp']; ?>">
												    </div>
												</div>
												
												<div class="form-group row my-0">
													<label for="z145u_pcp" class="col-sm-4 col-form-label">45u</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="z145u_pcp_e" name="z145u_pcp_e" value="<?= $row['z145u_pcp']; ?>">
													</div>
												</div>
												<div class="form-group row my-0">
													<label for="LOI_pcp" class="col-sm-4 col-form-label">LOI</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="LOI_pcp_e" name="LOI_pcp_e" value="<?= $row['LOI_pcp']; ?>">
													</div>
												</div>
												<div class="form-group row my-0">
													<label for="SiO2_pcp" class="col-sm-4 col-form-label">SiO2</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="SiO2_pcp_e" name="SiO2_pcp_e" value="<?= $row['SiO2_pcp']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Al2O3_pcp" class="col-sm-4 col-form-label">Al2O3</label>
													<div class="col-sm-8">
														<input type="Al2O3_pcp" style="height:30px" class="form-control" id="Al2O3_pcp_e" name="Al2O3_pcp_e" value="<?= $row['Al2O3_pcp']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Fe2O3_pcp" class="col-sm-4 col-form-label">Fe2O3</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="Fe2O3_pcp_e" name="Fe2O3_pcp_e" value="<?= $row['Fe2O3_pcp']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="CaO_pcp" class="col-sm-4 col-form-label">CaO</label>
													<div class="col-sm-8">
														<input type="CaO_pcp" style="height:30px" class="form-control" id="CaO_pcp_e" name="CaO_pcp_e" value="<?= $row['CaO_pcp']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
												    <label for="MgO_pcp" class="col-sm-4 col-form-label">MgO</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="MgO_pcp_e" name="MgO_pcp_e" value="<?= $row['MgO_pcp']; ?>">
												    </div>
												</div>
												
												<div class="form-group row my-0">
												    <label for="K2O_pcp" class="col-sm-4 col-form-label">K2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="K2O_pcp_e" name="K2O_pcp_e" value="<?= $row['K2O_pcp']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="Na2O_pcp" class="col-sm-4 col-form-label">Na2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="Na2O_pcp_e" name="Na2O_pcp_e" value="<?= $row['Na2O_pcp']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="Cl2_pcp" class="col-sm-4 col-form-label">Cl2</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="Cl2_pcp_e" name="Cl2_pcp_e" value="<?= $row['Cl2_pcp']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="FCaO_pcp" class="col-sm-4 col-form-label">FCaO</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="FCaO_pcp_e" name="FCaO_pcp_e" value="<?= $row['FCaO_pcp']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="GYPS_pcp" class="col-sm-4 col-form-label">GYPS</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="GYPS_pcp_e" name="GYPS_pcp_e" value="<?= $row['GYPS_pcp']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="LS_pcp" class="col-sm-4 col-form-label">LS</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="LS_pcp_e" name="LS_pcp_e" value="<?= $row['LS_pcp']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="PZ_pcp" class="col-sm-4 col-form-label">PZ</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="PZ_pcp_e" name="PZ_pcp_e" value="<?= $row['PZ_pcp']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="SILO_pcp" class="col-sm-4 col-form-label">SILO</label>
												    <div class="col-sm-8">
												        <select name="SILO_pcp_e" id="SILO_pcp_e" style="height:30px" class="form-control">
												            <option value=""></option> 
												            <option value="1" <?= ($row['SILO_pcp'] == '1') ? 'selected' : '' ?>>1</option>
												            <option value="2" <?= ($row['SILO_pcp'] == '2') ? 'selected' : '' ?>>2</option>
												            <option value="3" <?= ($row['SILO_pcp'] == '3') ? 'selected' : '' ?>>3</option>
												            <option value="4" <?= ($row['SILO_pcp'] == '4') ? 'selected' : '' ?>>4</option>
												            <option value="5" <?= ($row['SILO_pcp'] == '5') ? 'selected' : '' ?>>5</option>
												            <option value="6" <?= ($row['SILO_pcp'] == '6') ? 'selected' : '' ?>>6</option>
												            <option value="7" <?= ($row['SILO_pcp'] == '7') ? 'selected' : '' ?>>7</option>
												            <option value="8" <?= ($row['SILO_pcp'] == '8') ? 'selected' : '' ?>>8</option>
												           
												        </select>
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

		$fields = array(
		    'JAM', 'FEED', 'BLAINE_opc', 'SO3_opc', 'z145u_opc', 'z130u_opc',
		    'H2O_opc', 'LOI_opc', 'SiO2_opc', 'Al2O3_opc', 'Fe2O3_opc', 'CaO_opc',
		    'MgO_opc', 'K2O_opc', 'Na2O_opc', 'Cl2_opc', 'FCaO_opc', 'GYPS_opc',
		    'LS_opc', 'PZ_opc', 'FA_opc', 'TYPE_opc', 'SILO_opc', 'BLAINE_pcc',
		    'SO3_pcc', 'z145u_pcc', 'LOI_pcc', 'SiO2_pcc', 'Al2O3_pcc', 'Fe2O3_pcc',
		    'CaO_pcc', 'MgO_pcc', 'K2O_pcc', 'Na2O_pcc', 'Cl2_pcc', 'FCaO_pcc',
		    'GYPS_pcc', 'LS_pcc', 'PZ_pcc', 'FA_pcc', 'SILO_pcc', 'BLAINE_pcp',
		    'SO3_pcp', 'z145u_pcp', 'LOI_pcp', 'SiO2_pcp', 'Al2O3_pcp', 'Fe2O3_pcp',
		    'CaO_pcp', 'MgO_pcp', 'K2O_pcp', 'Na2O_pcp', 'Cl2_pcp', 'FCaO_pcp',
		    'GYPS_pcp', 'LS_pcp', 'PZ_pcp', 'FA_pcp', 'SILO_pcp'
		);

		foreach ($fields as $field) {
		    ${$field} = isset($_POST[$field]) && $_POST[$field] !== '' ? $_POST[$field] : NULL;
		}




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
				    $sql = "INSERT INTO z1_3 (TANGGAL, JAM, FEED, BLAINE_opc, SO3_opc, z145u_opc, z130u_opc, H2O_opc, LOI_opc, SiO2_opc, Al2O3_opc, Fe2O3_opc, CaO_opc, MgO_opc, K2O_opc, Na2O_opc, Cl2_opc, FCaO_opc, GYPS_opc, LS_opc, PZ_opc, FA_opc, TYPE_opc, SILO_opc, BLAINE_pcc, SO3_pcc, z145u_pcc, LOI_pcc, SiO2_pcc, Al2O3_pcc, Fe2O3_pcc, CaO_pcc, MgO_pcc, K2O_pcc, Na2O_pcc, Cl2_pcc, FCaO_pcc, GYPS_pcc, LS_pcc, PZ_pcc, FA_pcc, SILO_pcc, BLAINE_pcp, SO3_pcp, z145u_pcp, LOI_pcp, SiO2_pcp, Al2O3_pcp, Fe2O3_pcp, CaO_pcp, MgO_pcp, K2O_pcp, Na2O_pcp, Cl2_pcp, FCaO_pcp, GYPS_pcp, LS_pcp, PZ_pcp, FA_pcp, SILO_pcp, waktu, iduser)  
					VALUES ('$tanggal', " . (empty($JAM) ? 'NULL' : "'$JAM'") . ", " . (empty($FEED) ? 'NULL' : "'$FEED'") . ", " . (empty($BLAINE_opc) ? 'NULL' : "'$BLAINE_opc'") . ", " . (empty($SO3_opc) ? 'NULL' : "'$SO3_opc'") . ", " . (empty($z145u_opc) ? 'NULL' : "'$z145u_opc'") . ", " . (empty($z130u_opc) ? 'NULL' : "'$z130u_opc'") . ", " . (empty($H2O_opc) ? 'NULL' : "'$H2O_opc'") . ", " . (empty($LOI_opc) ? 'NULL' : "'$LOI_opc'") . ", " . (empty($SiO2_opc) ? 'NULL' : "'$SiO2_opc'") . ", " . (empty($Al2O3_opc) ? 'NULL' : "'$Al2O3_opc'") . ", " . (empty($Fe2O3_opc) ? 'NULL' : "'$Fe2O3_opc'") . ", " . (empty($CaO_opc) ? 'NULL' : "'$CaO_opc'") . ", " . (empty($MgO_opc) ? 'NULL' : "'$MgO_opc'") . ", " . (empty($K2O_opc) ? 'NULL' : "'$K2O_opc'") . ", " . (empty($Na2O_opc) ? 'NULL' : "'$Na2O_opc'") . ", " . (empty($Cl2_opc) ? 'NULL' : "'$Cl2_opc'") . ", " . (empty($FCaO_opc) ? 'NULL' : "'$FCaO_opc'") . ", " . (empty($GYPS_opc) ? 'NULL' : "'$GYPS_opc'") . ", " . (empty($LS_opc) ? 'NULL' : "'$LS_opc'") . ", " . (empty($PZ_opc) ? 'NULL' : "'$PZ_opc'") . ", " . (empty($FA_opc) ? 'NULL' : "'$FA_opc'") . ", " . (empty($TYPE_opc) ? 'NULL' : "'$TYPE_opc'") . ", " . (empty($SILO_opc) ? 'NULL' : "'$SILO_opc'") . ", " . (empty($BLAINE_pcc) ? 'NULL' : "'$BLAINE_pcc'") . ", " . (empty($SO3_pcc) ? 'NULL' : "'$SO3_pcc'") . ", " . (empty($z145u_pcc) ? 'NULL' : "'$z145u_pcc'") . ", " . (empty($LOI_pcc) ? 'NULL' : "'$LOI_pcc'") . ", " . (empty($SiO2_pcc) ? 'NULL' : "'$SiO2_pcc'") . ", " . (empty($Al2O3_pcc) ? 'NULL' : "'$Al2O3_pcc'") . ", " . (empty($Fe2O3_pcc) ? 'NULL' : "'$Fe2O3_pcc'") . ", " . (empty($CaO_pcc) ? 'NULL' : "'$CaO_pcc'") . ", " . (empty($MgO_pcc) ? 'NULL' : "'$MgO_pcc'") . ", " . (empty($K2O_pcc) ? 'NULL' : "'$K2O_pcc'") . ", " . (empty($Na2O_pcc) ? 'NULL' : "'$Na2O_pcc'") . ", " . (empty($Cl2_pcc) ? 'NULL' : "'$Cl2_pcc'") . ", " . (empty($FCaO_pcc) ? 'NULL' : "'$FCaO_pcc'") . ", " . (empty($GYPS_pcc) ? 'NULL' : "'$GYPS_pcc'") . ", " . (empty($LS_pcc) ? 'NULL' : "'$LS_pcc'") . ", " . (empty($PZ_pcc) ? 'NULL' : "'$PZ_pcc'") . ", " . (empty($FA_pcc) ? 'NULL' : "'$FA_pcc'") . ", " . (empty($SILO_pcc) ? 'NULL' : "'$SILO_pcc'") . ", " . (empty($BLAINE_pcp) ? 'NULL' : "'$BLAINE_pcp'") . ", " . (empty($SO3_pcp) ? 'NULL' : "'$SO3_pcp'") . ", " . (empty($z145u_pcp) ? 'NULL' : "'$z145u_pcp'") . ", " . (empty($LOI_pcp) ? 'NULL' : "'$LOI_pcp'") . ", " . (empty($SiO2_pcp) ? 'NULL' : "'$SiO2_pcp'") . ", " . (empty($Al2O3_pcp) ? 'NULL' : "'$Al2O3_pcp'") . ", " . (empty($Fe2O3_pcp) ? 'NULL' : "'$Fe2O3_pcp'") . ", " . (empty($CaO_pcp) ? 'NULL' : "'$CaO_pcp'") . ", " . (empty($MgO_pcp) ? 'NULL' : "'$MgO_pcp'") . ", " . (empty($K2O_pcp) ? 'NULL' : "'$K2O_pcp'") . ", " . (empty($Na2O_pcp) ? 'NULL' : "'$Na2O_pcp'") . ", " . (empty($Cl2_pcp) ? 'NULL' : "'$Cl2_pcp'") . ", " . (empty($FCaO_pcp) ? 'NULL' : "'$FCaO_pcp'") . ", " . (empty($GYPS_pcp) ? 'NULL' : "'$GYPS_pcp'") . ", " . (empty($LS_pcp) ? 'NULL' : "'$LS_pcp'") . ", " . (empty($PZ_pcp) ? 'NULL' : "'$PZ_pcp'") . ", " . (empty($FA_pcp) ? 'NULL' : "'$FA_pcp'") . ", " . (empty($SILO_pcp) ? 'NULL' : "'$SILO_pcp'") . ", '$waktu', '$username')";   


					$result = mysqli_query($conn, $sql);

	                        if ($result) {
	                            echo "<script>window.location = 'z1.php'</script>";
	                        } else {

	                            echo "Error: " . mysqli_error($conn);
	                        }
	                    }

	                    $sql = "SELECT * FROM z1_3 WHERE TANGGAL = CURDATE()";
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
								<label for="FEED" class="col-sm-4 col-form-label">FEED</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="FEED" name="FEED" placeholder="Enter FEED" >
								</div>
							</div>
							<br></br>
							<div class="text-center"> 
							    <label class="text-center">OPC Z1</label>
							</div>
							<div class="form-group row my-0">
								<label for="BLAINE_opc" class="col-sm-4 col-form-label">BLAINE</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="BLAINE_opc" name="BLAINE_opc" placeholder="Enter BLAINE" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="SO3_opc" class="col-sm-4 col-form-label">SO3</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="SO3_opc" name="SO3_opc" placeholder="Enter SO3" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="z145u_opc" class="col-sm-4 col-form-label">45u</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="z145u_opc" name="z145u_opc" placeholder="Enter 145u" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="z130u_opc" class="col-sm-4 col-form-label">30u</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="z130u_opc" name="z130u_opc" placeholder="Enter 30u">
								</div>
							</div>
							<div class="form-group row my-0">
							    <label for="H2O_opc" class="col-sm-4 col-form-label">H2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="H2O_opc" name="H2O_opc" placeholder="Enter H2O" >
							    </div>
							</div>
							<div class="form-group row my-0">
								<label for="LOI_opc" class="col-sm-4 col-form-label">LOI</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="LOI_opc" name="LOI_opc" placeholder="Enter LOI" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="SiO2_opc" class="col-sm-4 col-form-label">SiO2</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="SiO2_opc" name="SiO2_opc" placeholder="Enter SiO2" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="Al2O3_opc" class="col-sm-4 col-form-label">Al2O3</label>
								<div class="col-sm-8">
									<input type="Al2O3_opc" style="height:30px" class="form-control" id="Al2O3_opc" name="Al2O3_opc" placeholder="Enter Al2O3" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="Fe2O3_opc" class=" col-sm-4 col-form-label">Fe2O3</label>
								<div class="col-sm-8">
									<input type="Fe2O3_opc" style="height:30px" class="form-control" id="Fe2O3_opc" name="Fe2O3_opc" placeholder="Enter Fe2O3" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="CaO_opc" class="col-sm-4 col-form-label">CaO</label>
								<div class="col-sm-8">
									<input type="CaO_opc" style="height:30px" class="form-control" id="CaO_opc" name="CaO_opc" placeholder="Enter CaO" >
								</div>
							</div>
						
							<div class="form-group row my-0">
							    <label for="MgO_opc" class="col-sm-4 col-form-label">MgO</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="MgO_opc" name="MgO_opc" placeholder="Enter MgO" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="K2O_opc" class="col-sm-4 col-form-label">K2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="K2O_opc" name="K2O_opc" placeholder="Enter K2O" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="Na2O_opc" class="col-sm-4 col-form-label">Na2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="Na2O_opc" name="Na2O_opc" placeholder="Enter Na2O" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="Cl2_opc" class="col-sm-4 col-form-label">Cl2</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="Cl2_opc" name="Cl2_opc" placeholder="Enter Cl2" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="FCaO_opc" class="col-sm-4 col-form-label">FCaO</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="FCaO_opc" name="FCaO_opc" placeholder="Enter FCaO" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="GYPS_opc" class="col-sm-4 col-form-label">GYPS</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="GYPS_opc" name="GYPS_opc" placeholder="Enter GYPS" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="LS_opc" class="col-sm-4 col-form-label">LS</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="LS_opc" name="LS_opc" placeholder="Enter LS" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="PZ_opc" class="col-sm-4 col-form-label">PZ</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="PZ_opc" name="PZ_opc" placeholder="Enter PZ" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="FA_opc" class="col-sm-4 col-form-label">FA</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="FA_opc" name="FA_opc" placeholder="Enter FA" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="TYPE_opc" class="col-sm-4 col-form-label">TYPE</label>
							    <div class="col-sm-8">
							        <select name="TYPE_opc" id="TYPE_opc" style="height:30px" class="form-control">
							            <option value=""></option> 
							            <option value="TIPE1">TIPE1</option>
							            <option value="OPC+">OPC+</option>
							            <option value="42.5N">42.5N</option>
							            <option value="52.5N">52.5N</option>
							            <option value="EXPORT">EXPORT</option>
							        </select>
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="SILO_opc" class="col-sm-4 col-form-label">SILO</label>
							    <div class="col-sm-8">
							        <select name="SILO_opc" id="SILO_opc" style="height:30px" class="form-control">
							            <option value=""></option> 
							            <option value="1">1</option>
							            <option value="2">2</option>
							            <option value="3">3</option>
							            <option value="4">4</option>
							            <option value="5">5</option>
							            <option value="6">6</option>
							            <option value="7">7</option>
							            <option value="8">8</option>
							        </select>
							    </div>
							</div>
							<br></br>
							<div class="text-center"> 
							    <label class="text-center">PCC Z1</label>
							</div>
							<div class="form-group row my-0">
								<label for="BLAINE_pcc" class="col-sm-4 col-form-label">BLAINE</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="BLAINE_pcc" name="BLAINE_pcc" placeholder="Enter BLAINE" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="SO3_pcc" class="col-sm-4 col-form-label">SO3</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="SO3_pcc" name="SO3_pcc" placeholder="Enter SO3" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="z145u_pcc" class="col-sm-4 col-form-label">45u</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="z145u_pcc" name="z145u_pcc" placeholder="Enter 45u" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="LOI_pcc" class="col-sm-4 col-form-label">LOI</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="LOI_pcc" name="LOI_pcc" placeholder="Enter LOI" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="SiO2_pcc" class="col-sm-4 col-form-label">SiO2</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="SiO2_pcc" name="SiO2_pcc" placeholder="Enter SiO2" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="Al2O3_pcc" class="col-sm-4 col-form-label">Al2O3</label>
								<div class="col-sm-8">
									<input type="Al2O3_pcc" style="height:30px" class="form-control" id="Al2O3_pcc" name="Al2O3_pcc" placeholder="Enter Al2O3" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="Fe2O3_pcc" class=" col-sm-4 col-form-label">Fe2O3</label>
								<div class="col-sm-8">
									<input type="Fe2O3_pcc" style="height:30px" class="form-control" id="Fe2O3_pcc" name="Fe2O3_pcc" placeholder="Enter Fe2O3" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="CaO_pcc" class="col-sm-4 col-form-label">CaO</label>
								<div class="col-sm-8">
									<input type="CaO_pcc" style="height:30px" class="form-control" id="CaO_pcc" name="CaO_pcc" placeholder="Enter CaO" >
								</div>
							</div>
						
							<div class="form-group row my-0">
							    <label for="MgO_pcc" class="col-sm-4 col-form-label">MgO</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="MgO_pcc" name="MgO_pcc" placeholder="Enter MgO_pcc" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="K2O_pcc" class="col-sm-4 col-form-label">K2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="K2O_pcc" name="K2O_pcc" placeholder="Enter K2O" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="Na2O_pcc" class="col-sm-4 col-form-label">Na2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="Na2O_pcc" name="Na2O_pcc" placeholder="Enter Na2O" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="Cl2_pcc" class="col-sm-4 col-form-label">Cl2</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="Cl2_pcc" name="Cl2_pcc" placeholder="Enter Cl2" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="FCaO_pcc" class="col-sm-4 col-form-label">FCaO</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="FCaO_pcc" name="FCaO_pcc" placeholder="Enter FCaO" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="GYPS_pcc" class="col-sm-4 col-form-label">GYPS</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="GYPS_pcc" name="GYPS_pcc" placeholder="Enter GYPS" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="LS_pcc" class="col-sm-4 col-form-label">LS</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="LS_pcc" name="LS_pcc" placeholder="Enter LS" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="PZ_pcc" class="col-sm-4 col-form-label">PZ</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="PZ_pcc" name="PZ_pcc" placeholder="Enter PZ" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="FA_pcc" class="col-sm-4 col-form-label">FA</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="FA_pcc" name="FA_pcc" placeholder="Enter FA" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="SILO_pcc" class="col-sm-4 col-form-label">SILO</label>
							    <div class="col-sm-8">
							        <select name="SILO_pcc" id="SILO_pcc" style="height:30px" class="form-control">
							            <option value=""></option> 
							            <option value="1">1</option>
							            <option value="2">2</option>
							            <option value="3">3</option>
							            <option value="4">4</option>
							            <option value="5">5</option>
							            <option value="6">6</option>
							            <option value="7">7</option>
							            <option value="8">8</option>
							        </select>
							    </div>
							</div>
							<br></br>
							<div class="text-center"> 
							    <label class="text-center">PCC+ Z1</label>
							</div>
							<div class="form-group row my-0">
								<label for="BLAINE_pcp" class="col-sm-4 col-form-label">BLAINE</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="BLAINE_pcp" name="BLAINE_pcp" placeholder="Enter BLAINE" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="SO3_pcp" class="col-sm-4 col-form-label">SO3</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="SO3_pcp" name="SO3_pcp" placeholder="Enter SO3" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="z145u_pcp" class="col-sm-4 col-form-label">145u</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="z145u_pcp" name="z145u_pcp" placeholder="Enter 145u" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="LOI_pcp" class="col-sm-4 col-form-label">LOI</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="LOI_pcp" name="LOI_pcp" placeholder="Enter LOI" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="SiO2_pcp" class="col-sm-4 col-form-label">SiO2</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="SiO2_pcp" name="SiO2_pcp" placeholder="Enter SiO2" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="Al2O3_pcp" class="col-sm-4 col-form-label">Al2O3</label>
								<div class="col-sm-8">
									<input type="Al2O3_pcp" style="height:30px" class="form-control" id="Al2O3_pcp" name="Al2O3_pcp" placeholder="Enter Al2O3" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="Fe2O3_pcp" class=" col-sm-4 col-form-label">Fe2O3</label>
								<div class="col-sm-8">
									<input type="Fe2O3_pcp" style="height:30px" class="form-control" id="Fe2O3_pcp" name="Fe2O3_pcp" placeholder="Enter Fe2O3" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="CaO_pcp" class="col-sm-4 col-form-label">CaO</label>
								<div class="col-sm-8">
									<input type="CaO_pcp" style="height:30px" class="form-control" id="CaO_pcp" name="CaO_pcp" placeholder="Enter CaO" >
								</div>
							</div>
						
							<div class="form-group row my-0">
							    <label for="MgO_pcp" class="col-sm-4 col-form-label">MgO</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="MgO_pcp" name="MgO_pcp" placeholder="Enter MgO" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="K2O_pcp" class="col-sm-4 col-form-label">K2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="K2O_pcp" name="K2O_pcp" placeholder="Enter K2O" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="Na2O_pcp" class="col-sm-4 col-form-label">Na2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="Na2O_pcp" name="Na2O_pcp" placeholder="Enter Na2O" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="Cl2_pcp" class="col-sm-4 col-form-label">Cl2</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="Cl2_pcp" name="Cl2_pcp" placeholder="Enter Cl2" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="FCaO_pcp" class="col-sm-4 col-form-label">FCaO</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="FCaO_pcp" name="FCaO_pcp" placeholder="Enter FCaO" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="GYPS_pcp" class="col-sm-4 col-form-label">GYPS</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="GYPS_pcp" name="GYPS_pcp" placeholder="Enter GYPS" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="LS_pcp" class="col-sm-4 col-form-label">LS</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="LS_pcp" name="LS_pcp" placeholder="Enter LS" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="PZ_pcp" class="col-sm-4 col-form-label">PZ</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="PZ_pcp" name="PZ_pcp" placeholder="Enter PZ" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="FA_pcp" class="col-sm-4 col-form-label">FA</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="FA_pcp" name="FA_pcp" placeholder="Enter FA" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="SILO_pcp" class="col-sm-4 col-form-label">SILO</label>
							    <div class="col-sm-8">
							        <select name="SILO_pcp" id="SILO_pcp" style="height:30px" class="form-control">
							            <option value=""></option> 
							            <option value="1">1</option>
							            <option value="2">2</option>
							            <option value="3">3</option>
							            <option value="4">4</option>
							            <option value="5">5</option>
							            <option value="6">6</option>
							            <option value="7">7</option>
							            <option value="8">8</option>
							        </select>
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
	    	var z145u_opc = document.getElementById("z145u_opc").value;
	        var z130u_opc = document.getElementById("z130u_opc").value;
	        var H2O_opc = document.getElementById("H2O_opc").value;
	        var FEED = document.getElementById("FEED").value;
	        var BLAINE_opc = document.getElementById("BLAINE_opc").value;
	        var LOI_opc = document.getElementById("LOI_opc").value;
	        var FCaO_opc = document.getElementById("FCaO_opc").value;
	        var GYPS_opc = document.getElementById("GYPS_opc").value;
	        var LS_opc = document.getElementById("LS_opc").value;
	        var FA_opc = document.getElementById("FA_opc").value;
	        var TYPE_opc = document.getElementById("TYPE_opc").value;
	        var SILO_opc = document.getElementById("SILO_opc").value;
	        var SiO2_opc = document.getElementById("SiO2_opc").value;
	        var Al2O3_opc = document.getElementById("Al2O3_opc").value;
	        var Fe2O3_opc = document.getElementById("Fe2O3_opc").value;
	        var CaO_opc = document.getElementById("CaO_opc").value;
	        var MgO_opc = document.getElementById("MgO_opc").value;
	        var SO3 = document.getElementById("SO3").value;
	        var K2O_opc = document.getElementById("K2O_opc").value;
	        var Na2O_opc = document.getElementById("Na2O_opc").value;
	        var Cl2_opc = document.getElementById("Cl2_opc").value;

	        var inputs = [z145u_opc, z130u_opc, FEED, BLAINE_opc, FCaO_opc,GYPS_opc,LS_opc, FA_opc, TYPE_opc,SILO_opc,SiO2_opc, Al2O3_opc, Fe2O3_opc, CaO_opc, MgO_opc, SO3, K2O_opc, Na2O_opc, Cl2_opc, H2O_opc];

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