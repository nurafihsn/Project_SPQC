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
    $SHIFT_e = isset($_GET['SHIFT_e']) && $_GET['SHIFT_e'] !== '' ? $_GET['SHIFT_e'] : NULL;
    $SiO2_e = isset($_GET['SiO2_e']) && $_GET['SiO2_e'] !== '' ? $_GET['SiO2_e'] : NULL;
    $Al2O3_e = isset($_GET['Al2O3_e']) && $_GET['Al2O3_e'] !== '' ? $_GET['Al2O3_e'] : NULL;
    $Fe2O3_e = isset($_GET['Fe2O3_e']) && $_GET['Fe2O3_e'] !== '' ? $_GET['Fe2O3_e'] : NULL;
    $CaO_e = isset($_GET['CaO_e']) && $_GET['CaO_e'] !== '' ? $_GET['CaO_e'] : NULL;
    $MgO_e = isset($_GET['MgO_e']) && $_GET['MgO_e'] !== '' ? $_GET['MgO_e'] : NULL;
    $SO3_e = isset($_GET['SO3_e']) && $_GET['SO3_e'] !== '' ? $_GET['SO3_e'] : NULL;
    $K2O_e = isset($_GET['K2O_e']) && $_GET['K2O_e'] !== '' ? $_GET['K2O_e'] : NULL;
    $Na2O_e = isset($_GET['Na2O_e']) && $_GET['Na2O_e'] !== '' ? $_GET['Na2O_e'] : NULL;
    $Cl2_e = isset($_GET['Cl2_e']) && $_GET['Cl2_e'] !== '' ? $_GET['Cl2_e'] : NULL;
    $H2O_ls_e = isset($_GET['H2O_ls_e']) && $_GET['H2O_ls_e'] !== '' ? $_GET['H2O_ls_e'] : NULL;
    $H2O_pz_e = isset($_GET['H2O_pz_e']) && $_GET['H2O_pz_e'] !== '' ? $_GET['H2O_pz_e'] : NULL;
    $H2O_gyp_e = isset($_GET['H2O_gyp_e']) && $_GET['H2O_gyp_e'] !== '' ? $_GET['H2O_gyp_e'] : NULL;
    $jenis_gyp_e = isset($_GET['jenis_gyp_e']) && $_GET['jenis_gyp_e'] !== '' ? $_GET['jenis_gyp_e'] : NULL;
    $id_e = isset($_GET['id_e']) && $_GET['id_e'] !== '' ? $_GET['id_e'] : NULL;

    $sql = "UPDATE lscm_3 SET SHIFT=?, SiO2=?, Al2O3=?, Fe2O3=?, CaO=?, MgO=?, SO3=?, K2O=?, Na2O=?, Cl2=?, H2O_ls=?, H2O_pz=?, H2O_gyp=?, jenis_gyp=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        die("Error preparing the SQL statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "ssssssssssssssi", $SHIFT_e, $SiO2_e, $Al2O3_e, $Fe2O3_e, $CaO_e, $MgO_e, $SO3_e, $K2O_e, $Na2O_e, $Cl2_e, $H2O_ls_e, $H2O_pz_e, $H2O_gyp_e, $jenis_gyp_e, $id_e);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>window.location = 'lscm.php'</script>";
    } 
    mysqli_stmt_close($stmt);
}



$jumlahDataPerhalaman = 24;

$halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;

if (isset($_GET['awal']) && isset($_GET['akhir'])) {
    $awal = $_GET['awal'];
    $akhir = $_GET['akhir'];
    $sql_filtered = "SELECT * FROM lscm_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'";
} elseif (isset($_GET['kemarin'])) {
    $sql_filtered = "SELECT * FROM lscm_3 WHERE TANGGAL = CURDATE() - INTERVAL 1 DAY";
}
else {
    $sql_filtered = "SELECT * FROM lscm_3 WHERE TANGGAL = CURDATE()";
}

$result_filtered = mysqli_query($conn, $sql_filtered);
$jumlahData = mysqli_num_rows($result_filtered);

$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

$sql = "$sql_filtered LIMIT $awalData, $jumlahDataPerhalaman";
$q = mysqli_query($conn, $sql);
?>
		<center style="font-family: Arial, sans-serif; font-size: 24px; font-weight: bold; color: #333333; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
		    <label>LIMESTONE CM Indarung 2&3</label>
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
			        <th>H2O_LS</th>
			        <th>H2O_PZ</th>
			        <th>H2O_GYP</th>
			    </tr> 
			    

			     <tr bgcolor="YELLOW" style="color:BLACK">
				    <th>COUNT</th>
				    <?php
				    // Periksa apakah variabel $_GET['TANGGAL'] terdefinisi
				    if(isset($_GET['awal']) && isset($_GET['akhir'])){
				        $awal = $_GET['awal'];
			        	$akhir = $_GET['akhir'];
				        // Lakukan query untuk menghitung jumlah setiap kolom berdasarkan tanggal yang dipilih
				     $count_query = mysqli_query($conn, "SELECT COUNT(LSF) AS count_lsf, COUNT(SIM) AS count_sim, COUNT(ALM) AS count_alm, COUNT(SiO2) AS count_sio2, COUNT(Al2O3) AS count_al2o3, COUNT(Fe2O3) AS count_fe2o3, COUNT(CaO) AS count_cao, COUNT(MgO) AS count_mgo, COUNT(SO3) AS count_so3, COUNT(K2O) AS count_k2o, COUNT(Na2O) AS count_na2o, COUNT(Cl2) AS count_cl2, COUNT(SUM) AS count_sum, COUNT(ALKALI) AS count_alkali, COUNT(H2O_ls) AS count_h2ols, COUNT(H2O_pz) AS count_h2opz, COUNT(H2O_gyp) AS count_h2ogyp FROM lscm_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

				        $count_result = mysqli_fetch_assoc($count_query);
				        foreach ($count_result as $count) {
				            echo "<td>".$count."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM lscm_3");
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
			      $min_query = mysqli_query($conn, "SELECT MIN(LSF) AS min_lsf, MIN(SIM) AS min_sim, MIN(ALM) AS min_alm, MIN(SiO2) AS min_sio2, MIN(Al2O3) AS min_al2o3, MIN(Fe2O3) AS min_fe2o3, MIN(CaO) AS min_cao, MIN(MgO) AS min_mgo, MIN(SO3) AS min_so3, MIN(K2O) AS min_k2o, MIN(Na2O) AS min_na2o, MIN(Cl2) AS min_cl2, MIN(SUM) AS min_sum, MIN(ALKALI) AS min_alkali, MIN(H2O_ls) AS min_h2ols,  MIN(H2O_pz) AS min_h2opz,  MIN(H2O_gyp) AS min_h2ogyp FROM lscm_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

			       $min_result = mysqli_fetch_assoc($min_query);
				        foreach ($min_result as $min) {
				            echo "<td>".$min."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM lscm_3");
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
			       $average_query = mysqli_query($conn, "SELECT AVG(LSF) AS avg_lsf, AVG(SIM) AS avg_sim, AVG(ALM) AS avg_alm, AVG(SiO2) AS avg_sio2, AVG(Al2O3) AS avg_al2o3, AVG(Fe2O3) AS avg_fe2o3, AVG(CaO) AS avg_cao, AVG(MgO) AS avg_mgo, AVG(SO3) AS avg_so3, AVG(K2O) AS avg_k2o, AVG(Na2O) AS avg_na2o, AVG(Cl2) AS avg_cl2, AVG(SUM) AS avg_sum, AVG(ALKALI) AS avg_alkali, AVG(H2O_ls) AS avg_h2ols, AVG(H2O_pz) AS avg_h2opz, AVG(H2O_gyp) AS avg_h2ogyp FROM lscm_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

			        $average_result = mysqli_fetch_assoc($average_query);
				        foreach ($average_result as $average) {
				            echo "<td>".number_format($average, 2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM lscm_3");
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
			        $max_query = mysqli_query($conn, "SELECT MAX(LSF) AS max_lsf, MAX(SIM) AS max_sim, MAX(ALM) AS max_alm, MAX(SiO2) AS max_sio2, MAX(Al2O3) AS max_al2o3, MAX(Fe2O3) AS max_fe2o3, MAX(CaO) AS max_cao, MAX(MgO) AS max_mgo, MAX(SO3) AS max_so3, MAX(K2O) AS max_k2o, MAX(Na2O) AS max_na2o, MAX(Cl2) AS max_cl2, MAX(SUM) AS max_sum, MAX(ALKALI) AS max_alkali, MAX(H2O_ls) AS max_h2ols,  MAX(H2O_pz) AS max_h2opz,  MAX(H2O_gyp) AS max_h2ogyp FROM lscm_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
			         $max_result = mysqli_fetch_assoc($max_query);
				        foreach ($max_result as $max) {
				            echo "<td>".$max."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM lscm_3");
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
			       $sd_query = mysqli_query($conn, "SELECT STDDEV(LSF) AS sd_lsf, STDDEV(SIM) AS sd_sim, STDDEV(ALM) AS sd_alm, STDDEV(SiO2) AS sd_sio2, STDDEV(Al2O3) AS sd_al2o3, STDDEV(Fe2O3) AS sd_fe2o3, STDDEV(CaO) AS sd_cao, STDDEV(MgO) AS sd_mgo, STDDEV(SO3) AS sd_so3, STDDEV(K2O) AS sd_k2o, STDDEV(Na2O) AS sd_na2o, STDDEV(Cl2) AS sd_cl2, STDDEV(SUM) AS sd_sum, STDDEV(ALKALI) AS sd_alkali, STDDEV(H2O_ls) AS sd_h2ols, STDDEV(H2O_pz) AS sd_h2opz, STDDEV(H2O_gyp) AS sd_h2ogyp FROM lscm_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

			        $sd_result = mysqli_fetch_assoc($sd_query);
				        foreach ($sd_result as $sd) {
				            echo "<td>".number_format($sd, 2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM lscm_3");
				        while($data = mysqli_fetch_array($sql)){
				        }
				    }
				    ?>
			    </tr>  
			</table>
			<table class="adminlist mb-3" border="1" width="500" cellpadding="5" >
			    <tr bgcolor="#8080FF" style="color:#FFFFFF">
			        <th></th>
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
					        COUNT(IF(SiO2 > 5, 1, NULL)) AS datain_sio2,
					        COUNT(IF(Al2O3 > 1, 1, NULL)) AS datain_al2o3,
					        COUNT(IF(CaO < 52, 1, NULL)) AS datain_cao
					        FROM lscm_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
					    
					    $datain_result = mysqli_fetch_assoc($datain_query);
					    $kolom = array("SiO2", "Al2O3", "CaO");
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
					        COUNT(IF(SiO2 > 5, 1, NULL)) AS datain_sio2,
					        COUNT(IF(Al2O3 > 1, 1, NULL)) AS datain_al2o3,
					        COUNT(IF(CaO < 52, 1, NULL)) AS datain_cao
					        FROM lscm_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
					    
					    $datain_result = mysqli_fetch_assoc($datain_query);
					    $kolom = array("SiO2", "Al2O3", "CaO");
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
	                <a href="" class="btn btn-primary" data-toggle="modal" data-target="#addData"><i class="fa fa-fw fa-plus-circle"></i> Add Data</a>
	            </div>
	            <div class="form-group">
	                <a href="exportlscm.php" class="btn btn-primary" > Download </a>
	            </div>
	        </div>        
	    </div>
	</div>
	    


		<div>
			 <table class="table table-striped table-bordered table-hover">
				<thead>

					<tr class="text-center" >
			            <th  rowspan="1" ></th><th  rowspan="1" ></th><th colspan="3">LIMESTONE CM</th><th colspan="10">OKSIDA</th> <th colspan="1"></th> <th colspan="1">LS</th> <th colspan="1">PZ</th> <th colspan="2">GYPS</th>   <th colspan="1"></th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>Tanggal</th><th>SHIFT</th><th>LSF</th> <th>SIM</th> <th>ALM</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th> <th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>SUM</th><th>Alkali</th><th>H2O</th> <th>H2O</th> <th>H2O</th><th>Jenis</th><th>KETERANGAN</th> <th>Report</th>

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


					       $update_query = "UPDATE lscm_3 SET LSF=?, SIM=?, ALM=?, SUM=?, ALKALI=? WHERE id=?";
							$stmt = mysqli_prepare($conn, $update_query);

							mysqli_stmt_bind_param($stmt, "sssssi", $lsf, $sim, $alm, $sum, $alkali, $d['id']);

							if (mysqli_stmt_execute($stmt)) {
							    echo "";
							} else {
							    echo "Error: " . mysqli_error($conn);
							}
							mysqli_stmt_close($stmt);

							$w_al2o3 = '';
							if ($d['Al2O3'] > $configs['Al2O3cm']['max'] ) {
							    $w_al2o3 = 'text-danger';
							}
							$w_alkali = '';
					        if ($alkali > $configs['ALKALIcm']['max'] ) {
					            $w_alkali = 'text-danger';
					        }
					        $w_sio2 = '';
							if ($d['SiO2'] > $configs['SiO2cm']['max'] ) {
							    $w_sio2 = 'text-danger';
							}
							$w_cao = '';
					        if ($d['CaO'] < $configs['CaOcm']['min'] ) {
					            $w_cao = 'text-danger';
					        }
					        $w_h2o = '';
					        if ($d['H2O_ls'] > $configs['H2Ocm']['max'] ) {
					            $w_h2o = 'text-danger';
					        }
					      

					    ?>

					        	<td><?php echo $d['TANGGAL']; ?></td>
					            <td><?php echo $d['SHIFT']; ?></td>
					            <td><?php echo $lsf; ?></td>
					            <td><?php echo $sim; ?></td>
					            <td><?php echo $alm; ?></td>
					            <td class="<?php echo $w_sio2; ?>"><?php echo $d['SiO2']; ?></td>
					            <td class="<?php echo $w_al2o3; ?>"><?php echo $d['Al2O3']; ?></td>
					            <td><?php echo $d['Fe2O3']; ?></td>
					            <td class="<?php echo $w_cao; ?>"><?php echo $d['CaO']; ?></td>
					            <td><?php echo $d['MgO']; ?></td>
					            <td><?php echo $d['SO3']; ?></td>
					            <td><?php echo $d['K2O']; ?></td>
					            <td><?php echo $d['Na2O']; ?></td>
					            <td><?php echo $d['Cl2']; ?></td>
					            <td><?php echo $sum; ?></td>
					            <td class="<?php echo $w_alkali; ?>"><?php echo $alkali; ?></td>
					            <td class="<?php echo $w_h2o; ?>"><?php echo $d['H2O_ls']; ?></td>
					            <td><?php echo $d['H2O_pz']; ?></td>
					            <td><?php echo $d['H2O_gyp']; ?></td>
					            <td><?php echo $d['jenis_gyp']; ?></td>
					            <td><?php echo $d['KETERANGAN']; ?></td>
					            <td><?php echo $d['waktu'] ; ?> <a> <?php echo $d['iduser'] ; ?></a></td>
					            
					            
					            <td align="center">
					                <a href="#" type="button" style="height:34px" class="btn btn-success btn-md  pl-4 pr-4" data-toggle="modal" data-target="#myModal<?php echo $d['id']; ?>"><i class="fa fa-fw fa-edit"></i>Edit</a>
					                <a href="del-lscm.php?delId=<?php echo $d['id']; ?>" type="button" class="btn btn-danger" style="height:34px" onClick="return confirm('Are you sure to delete this data?');"><i class="fa fa-fw fa-trash"></i> Delete</a>
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
											$sql = "SELECT * FROM lscm_3 where id ='$id' order by id";
											$qr = mysqli_query($conn, $sql);

											//$result = mysqli_query($conn, $query);
											while ($row = mysqli_fetch_array($qr)) {
											?>
 

												<input type="hidden" name="id_e" value="<?php echo $row['id']; ?>">

												<div class="form-group row my-0">
													<label for="SHIFT" class="col-sm-4 col-form-label">SHIFT Ke-</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="SHIFT-e" name="SHIFT_e" value="<?= $row['SHIFT']; ?>">
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
												    <label for="H2O_ls" class="col-sm-4 col-form-label">H2O_LS</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="H2O_ls_e" name="H2O_ls_e" value="<?= $row['H2O_ls']; ?>">
												    </div>
												</div>

												<div class="form-group row my-0">
												    <label for="H2O_pz" class="col-sm-4 col-form-label">H2O_PZ</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="H2O_pz_e" name="H2O_pz_e" value="<?= $row['H2O_pz']; ?>">
												    </div>
												</div>

												 <div class="form-group row my-0">
												    <label for="H2O_gyp" class="col-sm-4 col-form-label">H2O_GYP</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="H2O_gyp_e" name="H2O_gyp_e" value="<?= $row['H2O_gyp']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="jenis_gyp" class="col-sm-4 col-form-label">JENIS_GYP</label>
												    <div class="col-sm-8">
												        <select name="jenis_gyp_e" id="jenis_gyp_e" style="height:30px" class="form-control">
												            <option value=""></option> 
												            <option value="NATURAL" <?= ($row['jenis_gyp'] == 'NATURAL') ? 'selected' : '' ?>>NATURAL</option>
												            <option value="PURIFIED" <?= ($row['jenis_gyp'] == 'PURIFIED') ? 'selected' : '' ?>>PURIFIED</option>


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

	$SHIFT = !empty($_POST['SHIFT']) ? $_POST['SHIFT'] : NULL;
	$SiO2 = !empty($_POST['SiO2']) ? $_POST['SiO2'] : NULL;
	$Al2O3 = !empty($_POST['Al2O3']) ? $_POST['Al2O3'] : NULL;
	$Fe2O3 = !empty($_POST['Fe2O3']) ? $_POST['Fe2O3'] : NULL;
	$CaO = !empty($_POST['CaO']) ? $_POST['CaO'] : NULL;
	$MgO = !empty($_POST['MgO']) ? $_POST['MgO'] : NULL;
	$SO3 = !empty($_POST['SO3']) ? $_POST['SO3'] : NULL;
	$K2O = !empty($_POST['K2O']) ? $_POST['K2O'] : NULL;
	$Na2O = !empty($_POST['Na2O']) ? $_POST['Na2O'] : NULL;
	$Cl2 = !empty($_POST['Cl2']) ? $_POST['Cl2'] : NULL;
	$H2O_ls = !empty($_POST['H2O_ls']) ? $_POST['H2O_ls'] : NULL;
	$H2O_pz = !empty($_POST['H2O_pz']) ? $_POST['H2O_pz'] : NULL;
	$H2O_gyp = !empty($_POST['H2O_gyp']) ? $_POST['H2O_gyp'] : NULL;
	$jenis_gyp = !empty($_POST['jenis_gyp']) ? $_POST['jenis_gyp'] : NULL;


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

					    $sql = "INSERT INTO lscm_3 (TANGGAL, SHIFT, SiO2, Al2O3, Fe2O3, CaO, MgO, SO3, K2O, Na2O, Cl2, H2O_ls, H2O_pz, H2O_gyp, jenis_gyp, waktu, iduser) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
					    $stmt = mysqli_prepare($conn, $sql);

					    if ($stmt) {
					        mysqli_stmt_bind_param($stmt, "sssssssssssssssss", $tanggal, $SHIFT, $SiO2, $Al2O3, $Fe2O3, $CaO, $MgO, $SO3, $K2O, $Na2O, $Cl2, $H2O_ls, $H2O_pz, $H2O_gyp, $jenis_gyp, $waktu, $username);

					        mysqli_stmt_execute($stmt);

					        mysqli_stmt_close($stmt);

					        echo "<script>window.location = 'lscm.php'</script>";
					    } else {
					        echo "Error: " . mysqli_error($conn);
					    }
					}

					$sql = "SELECT * FROM lscm_3 WHERE TANGGAL = CURDATE()";
					$q = mysqli_query($conn, $sql);
					?>


					<div class="container">
						<form method="POST" onsubmit="return validateForm()">

							<div class="form-group row my-0">
								<label for="SHIFT" class="col-sm-4 col-form-label">SHIFT Ke-</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="SHIFT" name="SHIFT" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="SiO2" class="col-sm-4 col-form-label">SiO2</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="SiO2" name="SiO2" placeholder="Enter SiO2" >
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
							    <label for="H2O_ls" class="col-sm-4 col-form-label">H2O_LS</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="H2O_ls" name="H2O_ls" placeholder="Enter H2O_LS" >
							    </div>
							</div>

							<div class="form-group row my-0">
							    <label for="H2O_pz" class="col-sm-4 col-form-label">H2O_PZ</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="H2O_pz" name="H2O_pz" placeholder="Enter H2O_PZ" >
							    </div>
							</div>

							<div class="form-group row my-0">
							    <label for="H2O_gyp" class="col-sm-4 col-form-label">H2O_GYP</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="H2O_gyp" name="H2O_gyp" placeholder="Enter H2O_GYP" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="jenis_gyp" class="col-sm-4 col-form-label">JENIS_GYP </label>
							    <div class="col-sm-8">
							        <select name="jenis_gyp" id="jenis_gyp" style="height:30px" class="form-control">
			                            <option value="" ></option>
			                            <option value="NATURAL">NATURAL</option>
			                            <option value="PURIFIED">PURIFIED</option>
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
	        var SiO2 = document.getElementById("SiO2").value;
	        var Al2O3 = document.getElementById("Al2O3").value;
	        var Fe2O3 = document.getElementById("Fe2O3").value;
	        var CaO = document.getElementById("CaO").value;
	        var MgO = document.getElementById("MgO").value;
	        var SO3 = document.getElementById("SO3").value;
	        var K2O = document.getElementById("K2O").value;
	        var Na2O = document.getElementById("Na2O").value;
	        var Cl2 = document.getElementById("Cl2").value;
	        var H2O_ls = document.getElementById("H2O_ls").value;
	        var H2O_pz = document.getElementById("H2O_pz").value;
	        var H2O_gyp = document.getElementById("H2O_gyp").value;

	        var inputs = [SiO2, Al2O3, Fe2O3, CaO, MgO, SO3, K2O, Na2O, Cl2, H2O_ls, H2O_pz, H2O_gyp];

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