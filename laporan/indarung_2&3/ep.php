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
    $fields = [
        'SiO2_b', 'Al2O3_b', 'Fe2O3_b', 'CaO_b', 'MgO_b', 'SO3_b', 'K2O_b', 'Na2O_b',
        'SiO2_c', 'Al2O3_c', 'Fe2O3_c', 'CaO_c', 'MgO_c', 'SO3_c', 'K2O_c', 'Na2O_c', 
        'RM1', 'RM2'
    ];

    $values = [];
    $placeholders = [];

    foreach ($fields as $field) {
        $param = isset($_GET[$field . '_e']) && $_GET[$field . '_e'] !== '' ? $_GET[$field . '_e'] : NULL;
        $values[$field] = $param;
        $placeholders[] = "$field=?";
    }

    $id_e = isset($_GET['id_e']) && $_GET['id_e'] !== '' ? $_GET['id_e'] : NULL;
    $values['id'] = $id_e;

    $sql = "UPDATE ep_3 SET " . implode(", ", $placeholders) . " WHERE id=?";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        die("Error preparing the SQL statement: " . mysqli_error($conn));
    }

    $types = str_repeat("s", count($values) - 1) . "i";
    $params = array_values($values);

    mysqli_stmt_bind_param($stmt, $types, ...$params);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>window.location = 'ep.php'</script>";
    }

    mysqli_stmt_close($stmt);
}


$jumlahDataPerhalaman = 24;

$halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;

if (isset($_GET['awal']) && isset($_GET['akhir'])) {
    $awal = $_GET['awal'];
    $akhir = $_GET['akhir'];
    $sql_filtered = "SELECT * FROM ep_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'";
} elseif (isset($_GET['kemarin'])) {
    $sql_filtered = "SELECT * FROM ep_3 WHERE TANGGAL = CURDATE() - INTERVAL 1 DAY";
}
else {
    $sql_filtered = "SELECT * FROM ep_3 WHERE TANGGAL = CURDATE()";
}

$result_filtered = mysqli_query($conn, $sql_filtered);
$jumlahData = mysqli_num_rows($result_filtered);

$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

$sql = "$sql_filtered LIMIT $awalData, $jumlahDataPerhalaman";
$q = mysqli_query($conn, $sql);
?>

		<center style="font-family: Arial, sans-serif; font-size: 24px; font-weight: bold; color: #333333; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
		    <label>EP Indarung 2&3</label>
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
					<tr class="text-center" >
			            <th rowspan="1"></th><th colspan="14">EP R1</th><th  colspan="14">EP R2</th>
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
			        <th>SUM</th>
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
			        <th>SUM</th>
			    </tr> 
			    

			     <tr bgcolor="YELLOW" style="color:BLACK">
				    <th>COUNT</th>
				     <?php
			        if(isset($_GET['awal']) && isset($_GET['akhir'])){
				        $awal = $_GET['awal'];
			        	$akhir = $_GET['akhir'];
			      $count_query = mysqli_query($conn, "SELECT COUNT(LSF_b) AS count_lsfb, COUNT(SIM_b) AS count_simb, COUNT(ALM_b) AS count_almb, COUNT(SiO2_b) AS count_sio2b, COUNT(Al2O3_b) AS count_al2o3b, COUNT(Fe2O3_b) AS count_fe2o3b, COUNT(CaO_b) AS count_caob, COUNT(MgO_b) AS count_mgob, COUNT(SO3_b) AS count_so3b, COUNT(K2O_b) AS count_k2ob, COUNT(Na2O_b) AS count_na2ob,  COUNT(SUM_b) AS count_sumb, COUNT(LSF_c) AS count_lsfc, COUNT(SIM_c) AS count_simc, COUNT(ALM_c) AS count_almc, COUNT(SiO2_c) AS count_sio2c, COUNT(Al2O3_c) AS count_al2o3c, COUNT(Fe2O3_c) AS count_fe2o3c, COUNT(CaO_c) AS count_caoc, COUNT(MgO_c) AS count_mgoc, COUNT(SO3_c) AS count_so3c, COUNT(K2O_c) AS count_k2oc, COUNT(Na2O_c) AS count_na2oc,  COUNT(SUM_c) AS count_sumc FROM ep_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

			       $count_result = mysqli_fetch_assoc($count_query);
				        foreach ($count_result as $count) {
				            echo "<td>".$count."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM ep_3");
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
			      $min_query = mysqli_query($conn, "SELECT MIN(LSF_b) AS min_lsfb, MIN(SIM_b) AS min_simb, MIN(ALM_b) AS min_almb, MIN(SiO2_b) AS min_sio2b, MIN(Al2O3_b) AS min_al2o3b, MIN(Fe2O3_b) AS min_fe2o3b, MIN(CaO_b) AS min_caob, MIN(MgO_b) AS min_mgob, MIN(SO3_b) AS min_so3b, MIN(K2O_b) AS min_k2ob, MIN(Na2O_b) AS min_na2ob,  MIN(SUM_b) AS min_sumb, MIN(LSF_c) AS min_lsfc, MIN(SIM_c) AS min_simc, MIN(ALM_c) AS min_almc, MIN(SiO2_c) AS min_sio2c, MIN(Al2O3_c) AS min_al2o3c, MIN(Fe2O3_c) AS min_fe2o3c, MIN(CaO_c) AS min_caoc, MIN(MgO_c) AS min_mgoc, MIN(SO3_c) AS min_so3c, MIN(K2O_c) AS min_k2oc, MIN(Na2O_c) AS min_na2oc,  MIN(SUM_c) AS min_sumc FROM ep_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

			       $min_result = mysqli_fetch_assoc($min_query);
				        foreach ($min_result as $min) {
				            echo "<td>".$min."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM ep_3");
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
			       $average_query = mysqli_query($conn, "SELECT AVG(LSF_b) AS avg_lsfb, AVG(SIM_b) AS avg_simb, AVG(ALM_b) AS avg_almb, AVG(SiO2_b) AS avg_sio2b, AVG(Al2O3_b) AS avg_al2o3b, AVG(Fe2O3_b) AS avg_fe2o3b, AVG(CaO_b) AS avg_caob, AVG(MgO_b) AS avg_mgob, AVG(SO3_b) AS avg_so3b, AVG(K2O_b) AS avg_k2ob, AVG(Na2O_b) AS avg_na2ob, AVG(SUM_b) AS avg_sumb, AVG(LSF_c) AS avg_lsfc, AVG(SIM_c) AS avg_simc, AVG(ALM_c) AS avg_almc, AVG(SiO2_c) AS avg_sio2c, AVG(Al2O3_c) AS avg_al2o3c, AVG(Fe2O3_c) AS avg_fe2o3c, AVG(CaO_c) AS avg_caoc, AVG(MgO_c) AS avg_mgoc, AVG(SO3_c) AS avg_so3c, AVG(K2O_c) AS avg_k2oc, AVG(Na2O_c) AS avg_na2oc,  AVG(SUM_c) AS avg_sumc FROM ep_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
			        $average_result = mysqli_fetch_assoc($average_query);
				        foreach ($average_result as $average) {
				            echo "<td>".number_format($average, 2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM ep_3");
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
			        $max_query = mysqli_query($conn, "SELECT MAX(LSF_b) AS max_lsfb, MAX(SIM_b) AS max_simb, MAX(ALM_b) AS max_almb, MAX(SiO2_b) AS max_sio2b, MAX(Al2O3_b) AS max_al2o3b, MAX(Fe2O3_b) AS max_fe2o3b, MAX(CaO_b) AS max_caob, MAX(MgO_b) AS max_mgob, MAX(SO3_b) AS max_so3b, MAX(K2O_b) AS max_k2ob, MAX(Na2O_b) AS max_na2ob, MAX(SUM_b) AS max_sumb, MAX(LSF_c) AS max_lsfc, MAX(SIM_c) AS max_simc, MAX(ALM_c) AS max_almc, MAX(SiO2_c) AS max_sio2c, MAX(Al2O3_c) AS max_al2o3c, MAX(Fe2O3_c) AS max_fe2o3c, MAX(CaO_c) AS max_caoc, MAX(MgO_c) AS max_mgoc, MAX(SO3_c) AS max_so3c, MAX(K2O_c) AS max_k2oc, MAX(Na2O_c) AS max_na2oc, MAX(SUM_c) AS max_sumc FROM ep_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
			         $max_result = mysqli_fetch_assoc($max_query);
				        foreach ($max_result as $max) {
				            echo "<td>".$max."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM ep_3");
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
			        $sd_query = mysqli_query($conn, "SELECT STDDEV(LSF_b) AS sd_lsfb, STDDEV(SIM_b) AS sd_simb, STDDEV(ALM_b) AS sd_almb, STDDEV(SiO2_b) AS sd_sio2b, STDDEV(Al2O3_b) AS sd_al2o3b, STDDEV(Fe2O3_b) AS sd_fe2o3b, STDDEV(CaO_b) AS sd_caob, STDDEV(MgO_b) AS sd_mgob, STDDEV(SO3_b) AS sd_so3b, STDDEV(K2O_b) AS sd_k2ob, STDDEV(Na2O_b) AS sd_na2ob, STDDEV(SUM_b) AS sd_sumb, STDDEV(LSF_c) AS sd_lsfc, STDDEV(SIM_c) AS sd_simc, STDDEV(ALM_c) AS sd_almc, STDDEV(SiO2_c) AS sd_sio2c, STDDEV(Al2O3_c) AS sd_al2o3c, STDDEV(Fe2O3_c) AS sd_fe2o3c, STDDEV(CaO_c) AS sd_caoc, STDDEV(MgO_c) AS sd_mgoc, STDDEV(SO3_c) AS sd_so3c, STDDEV(K2O_c) AS sd_k2oc, STDDEV(Na2O_c) AS sd_na2oc,  STDDEV(SUM_c) AS sd_sumc FROM ep_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

			        $sd_result = mysqli_fetch_assoc($sd_query);
				        foreach ($sd_result as $sd) {
				            echo "<td>".number_format($sd, 2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM ep_3");
				        while($data = mysqli_fetch_array($sql)){
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
	                <a href="exportep.php" class="btn btn-primary" > Download </a>
	            </div>
	        </div>        
	    </div>
	</div>
	    


		<div>
			 <table class="table table-striped table-bordered table-hover">
				<thead>

					<tr class="text-center" >
			           </th><th  rowspan="1" ></th><th colspan="3">EP R1</th><th colspan="9">OKSIDA</th><th colspan="3">EP R2</th><th colspan="9">OKSIDA</th> <th colspan="2">STATUS </th><th colspan="1"></th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>Tanggal</th><th>LSF</th> <th>SIM</th> <th>ALM</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th> <th>K2O</th> <th>Na2O</th> <th>SUM</th><th>LSF</th> <th>SIM</th> <th>ALM</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th> <th>K2O</th> <th>Na2O</th><th>SUM</th><th>RM1</th><th>RM2</th> <th>Report</th>

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
					    	
					       
					        $lsfb = null;
							if (!empty($d['SiO2_b']) && ($d['SiO2_b'] != 0 || $d['Al2O3_b'] != 0 || $d['Fe2O3_b'] != 0)) {
							    $lsfb = ($d['CaO_b'] * $configs['lsf_1']) / ($configs['lsf_2']* $d['SiO2_b'] + $configs['lsf_3']* $d['Al2O3_b'] + $configs['lsf_4'] * $d['Fe2O3_b']);
							}
							$lsfb = !is_null($lsfb) ? number_format((float)$lsfb, 2, '.', '') : null;

							$simb = null;
							if (!empty($d['SiO2_b']) && ($d['Al2O3_b'] + $d['Fe2O3_b'] != 0)) {
							    $simb =  $d['SiO2_b'] / ($d['Al2O3_b'] + $d['Fe2O3_b']);
							}
							$simb = !is_null($simb) ? number_format((float)$simb, 2, '.', '') : null;

							$almb = null;
							if (!empty($d['Al2O3_b']) && $d['Fe2O3_b'] != 0) {
							    $almb =  $d['Al2O3_b'] / $d['Fe2O3_b'];
							}
							$almb = !is_null($almb) ? number_format((float)$almb, 2, '.', '') : null;

							$sumb = null;
							if (!empty($d['SiO2_b'])) {
							    $sumb = $d['SiO2_b'] + $d['Al2O3_b'] + $d['Fe2O3_b'] + $d['CaO_b'] + $d['MgO_b'] + $d['SO3_b'] + $d['K2O_b'] + $d['Na2O_b'] + $d['K2O_b'];
							}
							$sumb = !is_null($sumb) ? number_format((float)$sumb, 2, '.', '') : null;

							$alkalib = null;
							if (!empty($d['Na2O_b']) || !empty($d['K2O_b'])) {
							    $alkalib =  $d['Na2O_b'] + ($d['K2O_b'] * $configs['alkali']);
							}
							$alkalib = !is_null($alkalib) ? number_format((float)$alkalib, 2, '.', '') : null;

							$lsfc = null;
							if (!empty($d['SiO2_c']) && ($d['SiO2_c'] != 0 || $d['Al2O3_c'] != 0 || $d['Fe2O3_c'] != 0)) {
							    $lsfc = ($d['CaO_c'] * $configs['lsf_1']) / ($configs['lsf_2']* $d['SiO2_c'] + $configs['lsf_3']* $d['Al2O3_c'] + $configs['lsf_4'] * $d['Fe2O3_c']);
							}
							$lsfc = !is_null($lsfc) ? number_format((float)$lsfc, 2, '.', '') : null;

							$simc = null;
							if (!empty($d['SiO2_c']) && ($d['Al2O3_c'] + $d['Fe2O3_c'] != 0)) {
							    $simc =  $d['SiO2_c'] / ($d['Al2O3_c'] + $d['Fe2O3_c']);
							}
							$simc = !is_null($simc) ? number_format((float)$simc, 2, '.', '') : null;

							$almc = null;
							if (!empty($d['Al2O3_c']) && $d['Fe2O3_c'] != 0) {
							    $almc =  $d['Al2O3_c'] / $d['Fe2O3_c'];
							}
							$almc = !is_null($almc) ? number_format((float)$almc, 2, '.', '') : null;

							$sumc = null;
							if (!empty($d['SiO2_c'])) {
							    $sumc = $d['SiO2_c'] + $d['Al2O3_c'] + $d['Fe2O3_c'] + $d['CaO_c'] + $d['MgO_c'] + $d['SO3_c'] + $d['K2O_c'] + $d['Na2O_c'] + $d['K2O_c'];
							}
							$sumc = !is_null($sumc) ? number_format((float)$sumc, 2, '.', '') : null;

							$alkalic = null;
							if (!empty($d['Na2O_c']) || !empty($d['K2O_c'])) {
							    $alkalic =  $d['Na2O_c'] + ($d['K2O_c'] * $configs['alkali']);
							}
							$alkalic = !is_null($alkalic) ? number_format((float)$alkalic, 2, '.', '') : null;

					      $update_query = "UPDATE ep_3 SET LSF_b=?, SIM_b=?, ALM_b=?, SUM_b=?, ALKALI_b=?, LSF_c=?, SIM_c=?, ALM_c=?, SUM_c=?, ALKALI_c=? WHERE id=?";
							$stmt = mysqli_prepare($conn, $update_query);

							mysqli_stmt_bind_param($stmt, "sssssssssss", $lsfb, $simb, $almb, $sumb, $alkalib, $lsfc, $simc, $almc, $sumc, $alkalic, $d['id']);

							if (mysqli_stmt_execute($stmt)) {
							    echo "";
							} else {
							    echo "Error: " . mysqli_error($conn);
							}
							mysqli_stmt_close($stmt);

					    ?>

					        	<td><?php echo $d['TANGGAL']; ?></td>
					            <td><?php echo $lsfb; ?></td>
					            <td><?php echo $simb; ?></td>
					            <td><?php echo $almb; ?></td>
					            <td><?php echo $d['SiO2_b']; ?></td>
					            <td><?php echo $d['Al2O3_b']; ?></td>
					            <td><?php echo $d['Fe2O3_b']; ?></td>
					            <td><?php echo $d['CaO_b']; ?></td>
					            <td><?php echo $d['MgO_b']; ?></td>
					            <td><?php echo $d['SO3_b']; ?></td>
					            <td><?php echo $d['K2O_b']; ?></td>
					            <td><?php echo $d['Na2O_b']; ?></td>
					            <td><?php echo $sumb; ?></td>
					            <td><?php echo $lsfc; ?></td>
					            <td><?php echo $simc; ?></td>
					            <td><?php echo $almc; ?></td>
					            <td><?php echo $d['SiO2_c']; ?></td>
					            <td><?php echo $d['Al2O3_c']; ?></td>
					            <td><?php echo $d['Fe2O3_c']; ?></td>
					            <td><?php echo $d['CaO_c']; ?></td>
					            <td><?php echo $d['MgO_c']; ?></td>
					            <td><?php echo $d['SO3_c']; ?></td>
					            <td><?php echo $d['K2O_c']; ?></td>
					            <td><?php echo $d['Na2O_c']; ?></td>
					            <td><?php echo $sumc; ?></td>
					            <td ><?php echo $d['RM1']; ?></td>
					            <td ><?php echo $d['RM2']; ?></td>
					            <td><?php echo $d['waktu'] ; ?> <a> <?php echo $d['iduser'] ; ?></a></td>
					            
					            
					            <td align="center">
					                <a href="#" type="button" style="height:34px" class="btn btn-success btn-md  pl-4 pr-4" data-toggle="modal" data-target="#myModal<?php echo $d['id']; ?>"><i class="fa fa-fw fa-edit"></i>Edit</a>
					                <a href="del-ep.php?delId=<?php echo $d['id']; ?>" type="button" class="btn btn-danger" style="height:34px" onClick="return confirm('Are you sure to delete this data?');"><i class="fa fa-fw fa-trash"></i> Delete</a>
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
											$sql = "SELECT * FROM ep_3 where id ='$id' order by id";
											$qr = mysqli_query($conn, $sql);

											//$result = mysqli_query($conn, $query);
											while ($row = mysqli_fetch_array($qr)) {
											?>
 

												<input type="hidden" name="id_e" value="<?php echo $row['id']; ?>">

												<br>
													<center>EP R1</center>
												</br>
												<div class="form-group row my-0">
													<label for="SiO2_b" class="col-sm-4 col-form-label">SiO2</label>
													<div class="col-sm-8">
														<input type="number_format" style="height:30px" class="form-control" id="SiO2_b_e" name="SiO2_b_e" value="<?= $row['SiO2_b']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Al2O3_b" class="col-sm-4 col-form-label">Al2O3</label>
													<div class="col-sm-8">
														<input type="Al2O3_b" style="height:30px" class="form-control" id="Al2O3_b_e" name="Al2O3_b_e" value="<?= $row['Al2O3_b']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Fe2O3_b" class="col-sm-4 col-form-label">Fe2O3</label>
													<div class="col-sm-8">
														<input type="number_format" style="height:30px" class="form-control" id="Fe2O3_b_e" name="Fe2O3_b_e" value="<?= $row['Fe2O3_b']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="CaO_b" class="col-sm-4 col-form-label">CaO</label>
													<div class="col-sm-8">
														<input type="CaO_b" style="height:30px" class="form-control" id="CaO_b_e" name="CaO_b_e" value="<?= $row['CaO_b']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
												    <label for="MgO_b" class="col-sm-4 col-form-label">MgO</label>
												    <div class="col-sm-8">
												        <input type="number_format" style="height:30px" class="form-control" id="MgO_b_e" name="MgO_b_e" value="<?= $row['MgO_b']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="SO3_b" class="col-sm-4 col-form-label">SO3</label>
												    <div class="col-sm-8">
												        <input type="number_format" style="height:30px" class="form-control" id="SO3_b_e" name="SO3_b_e" value="<?= $row['SO3_b']; ?>">
												    </div>
												</div>
												
												<div class="form-group row my-0">
												    <label for="K2O_b" class="col-sm-4 col-form-label">K2O</label>
												    <div class="col-sm-8">
												        <input type="number_format" style="height:30px" class="form-control" id="K2O_b_e" name="K2O_b_e" value="<?= $row['K2O_b']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="Na2O_b" class="col-sm-4 col-form-label">Na2O</label>
												    <div class="col-sm-8">
												        <input type="number_format" style="height:30px" class="form-control" id="Na2O_b_e" name="Na2O_b_e" value="<?= $row['Na2O_b']; ?>">
												    </div>
												</div>
												<br> 
												<center> EP R2</center>
												</br>
												<div class="form-group row my-0">
													<label for="SiO2_c" class="col-sm-4 col-form-label">SiO2</label>
													<div class="col-sm-8">
														<input type="number_format" style="height:30px" class="form-control" id="SiO2_c_e" name="SiO2_c_e" value="<?= $row['SiO2_c']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Al2O3_c" class="col-sm-4 col-form-label">Al2O3</label>
													<div class="col-sm-8">
														<input type="Al2O3_c" style="height:30px" class="form-control" id="Al2O3_c_e" name="Al2O3_c_e" value="<?= $row['Al2O3_c']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Fe2O3_c" class="col-sm-4 col-form-label">Fe2O3</label>
													<div class="col-sm-8">
														<input type="number_format" style="height:30px" class="form-control" id="Fe2O3_c_e" name="Fe2O3_c_e" value="<?= $row['Fe2O3_c']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="CaO_c" class="col-sm-4 col-form-label">CaO</label>
													<div class="col-sm-8">
														<input type="CaO_c" style="height:30px" class="form-control" id="CaO_c_e" name="CaO_c_e" value="<?= $row['CaO_c']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
												    <label for="MgO_c" class="col-sm-4 col-form-label">MgO</label>
												    <div class="col-sm-8">
												        <input type="number_format" style="height:30px" class="form-control" id="MgO_c_e" name="MgO_c_e" value="<?= $row['MgO_c']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="SO3_c" class="col-sm-4 col-form-label">SO3</label>
												    <div class="col-sm-8">
												        <input type="number_format" style="height:30px" class="form-control" id="SO3_c_e" name="SO3_c_e" value="<?= $row['SO3_c']; ?>">
												    </div>
												</div>
												
												<div class="form-group row my-0">
												    <label for="K2O_c" class="col-sm-4 col-form-label">K2O</label>
												    <div class="col-sm-8">
												        <input type="number_format" style="height:30px" class="form-control" id="K2O_c_e" name="K2O_c_e" value="<?= $row['K2O_c']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="Na2O_c" class="col-sm-4 col-form-label">Na2O</label>
												    <div class="col-sm-8">
												        <input type="number_format" style="height:30px" class="form-control" id="Na2O_c_e" name="Na2O_c_e" value="<?= $row['Na2O_c']; ?>">
												    </div>
												</div>
												<br></br>

												<div class="form-group row my-0">
												    <label for="RM1" class="col-sm-4 col-form-label">5R1</label>
												    <div class="col-sm-8">
												        <select name="RM1_e" id="RM1_e" style="height:30px" class="form-control">
												            <option value=""></option> 
												            <option value="RUN" <?= ($row['RM1'] == 'RUN') ? 'selected' : '' ?>>RUN</option>
												            <option value="STOP" <?= ($row['RM1'] == 'STOP') ? 'selected' : '' ?>>STOP</option>
												        </select>
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="RM2" class="col-sm-4 col-form-label">5R2</label>
												    <div class="col-sm-8">
												        <select name="RM2_e" id="RM2_e" style="height:30px" class="form-control">
												            <option value=""></option> 
												            <option value="RUN" <?= ($row['RM2'] == 'RUN') ? 'selected' : '' ?>>RUN</option>
												            <option value="STOP" <?= ($row['RM2'] == 'STOP') ? 'selected' : '' ?>>STOP</option>
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
		                    <a class="page-link" href="?halaman=<?= $halamanAktif - 1; ?>&awal=<?= isset($_GET['awal']) ? $_GET['awal'] : ''; ?>&akhir=<?= isset($_GET['akhir']) ? $_GET['akhir'] : ''; ?>">Previous</a>
		                </li>
		            <?php endif; ?>
		            <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
		                <?php if ($i == $halamanAktif) : ?>
		                    <li class="page-item active"><a class="page-link" href="?halaman=<?= $i; ?>&awal=<?= isset($_GET['awal']) ? $_GET['awal'] : ''; ?>&akhir=<?= isset($_GET['akhir']) ? $_GET['akhir'] : ''; ?>"><?= $i; ?></a></li>
		                <?php else : ?>
		                    <li class="page-item"><a class="page-link" href="?halaman=<?= $i; ?>&awal=<?= isset($_GET['awal']) ? $_GET['awal'] : ''; ?>&akhir=<?= isset($_GET['akhir']) ? $_GET['akhir'] : ''; ?>"><?= $i; ?></a></li>
		                <?php endif; ?>
		            <?php endfor; ?>
		            <?php if ($halamanAktif < $jumlahHalaman) : ?>
		                <li class="page-item"><a class="page-link" href="?halaman=<?= $halamanAktif + 1; ?>&awal=<?= isset($_GET['awal']) ? $_GET['awal'] : ''; ?>&akhir=<?= isset($_GET['akhir']) ? $_GET['akhir'] : ''; ?>">Next</a></li>
		            <?php endif; ?>
		        </ul>
		    </nav>
		</div>


	<!-- add data  -->

	<?php

	$SiO2_b = !empty($_POST['SiO2_b']) ? $_POST['SiO2_b'] : NULL;
	$Al2O3_b = !empty($_POST['Al2O3_b']) ? $_POST['Al2O3_b'] : NULL;
	$Fe2O3_b = !empty($_POST['Fe2O3_b']) ? $_POST['Fe2O3_b'] : NULL;
	$CaO_b = !empty($_POST['CaO_b']) ? $_POST['CaO_b'] : NULL;
	$MgO_b = !empty($_POST['MgO_b']) ? $_POST['MgO_b'] : NULL;
	$SO3_b = !empty($_POST['SO3_b']) ? $_POST['SO3_b'] : NULL;
	$K2O_b = !empty($_POST['K2O_b']) ? $_POST['K2O_b'] : NULL;
	$Na2O_b = !empty($_POST['Na2O_b']) ? $_POST['Na2O_b'] : NULL;
	$SiO2_c = !empty($_POST['SiO2_c']) ? $_POST['SiO2_c'] : NULL;
	$Al2O3_c = !empty($_POST['Al2O3_c']) ? $_POST['Al2O3_c'] : NULL;
	$Fe2O3_c = !empty($_POST['Fe2O3_c']) ? $_POST['Fe2O3_c'] : NULL;
	$CaO_c = !empty($_POST['CaO_c']) ? $_POST['CaO_c'] : NULL;
	$MgO_c = !empty($_POST['MgO_c']) ? $_POST['MgO_c'] : NULL;
	$SO3_c = !empty($_POST['SO3_c']) ? $_POST['SO3_c'] : NULL;
	$K2O_c = !empty($_POST['K2O_c']) ? $_POST['K2O_c'] : NULL;
	$Na2O_c = !empty($_POST['Na2O_c']) ? $_POST['Na2O_c'] : NULL;
	$RM1 = !empty($_POST['RM1']) ? $_POST['RM1'] : NULL;
	$RM2 = !empty($_POST['RM2']) ? $_POST['RM2'] : NULL;


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
						
						$sql = "INSERT ep_3 (TANGGAL,SiO2_b, Al2O3_b, Fe2O3_b, CaO_b, MgO_b, SO3_b, K2O_b, Na2O_b,SiO2_c, Al2O3_c, Fe2O3_c, CaO_c, MgO_c, SO3_c, K2O_c, Na2O_c, RM1, RM2, waktu, iduser) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
						$stmt = mysqli_prepare($conn, $sql);

						    // Bind parameter ke statement
						    mysqli_stmt_bind_param($stmt, "sssssssssssssssssssss", $tanggal, $SiO2_b, $Al2O3_b, $Fe2O3_b, $CaO_b, $MgO_b, $SO3_b, $K2O_b, $Na2O_b, $SiO2_c, $Al2O3_c, $Fe2O3_c, $CaO_c, $MgO_c, $SO3_c, $K2O_c, $Na2O_c, $RM1 ,$RM2 , $waktu, $username);
						    
						    // Eksekusi statement
						    mysqli_stmt_execute($stmt);

						    // Cek apakah berhasil
						    if (mysqli_stmt_affected_rows($stmt) > 0) {
						        echo "<script>window.location = 'ep.php'</script>";
						    } else {
						        echo "Gagal menambahkan data.";
						    }

						    // Tutup statement
						    mysqli_stmt_close($stmt);
						}

					$sql = "Select * from ep_3 where TANGGAL = CURDATE()";
					$q = mysqli_query($conn, $sql);
					?>

					<div class="container">
						<form method="POST" onsubmit="return validateForm()">

							<br >
								<center> EP R1</center> 
							</br>
							<div class="form-group row my-0">
								<label for="SiO2_b" class="col-sm-4 col-form-label">SiO2</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="SiO2_b" name="SiO2_b" placeholder="Enter SiO2" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="Al2O3_b" class="col-sm-4 col-form-label">Al2O3</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="Al2O3_b" name="Al2O3_b" placeholder="Enter Al2O3" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="Fe2O3_b" class=" col-sm-4 col-form-label">Fe2O3</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="Fe2O3_b" name="Fe2O3_b" placeholder="Enter Fe2O3" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="CaO_b" class="col-sm-4 col-form-label">CaO</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="CaO_b" name="CaO_b" placeholder="Enter CaO" >
								</div>
							</div>
						
							<div class="form-group row my-0">
							    <label for="MgO_b" class="col-sm-4 col-form-label">MgO</label>
							    <div class="col-sm-8">
							        <input type="number_format" style="height:30px" class="form-control" id="MgO_b" name="MgO_b" placeholder="Enter MgO" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="SO3_b" class="col-sm-4 col-form-label">SO3</label>
							    <div class="col-sm-8">
							        <input type="number_format" style="height:30px" class="form-control" id="SO3_b" name="SO3_b" placeholder="Enter SO3" >
							    </div>
							</div>
							
							<div class="form-group row my-0">
							    <label for="K2O_b" class="col-sm-4 col-form-label">K2O</label>
							    <div class="col-sm-8">
							        <input type="number_format" style="height:30px" class="form-control" id="K2O_b" name="K2O_b" placeholder="Enter K2O" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="Na2O_b" class="col-sm-4 col-form-label">Na2O</label>
							    <div class="col-sm-8">
							        <input type="number_format" style="height:30px" class="form-control" id="Na2O_b" name="Na2O_b" placeholder="Enter Na2O" >
							    </div>
							</div>
							<br> 
							<center>EP R2</center>
							</br>
							<div class="form-group row my-0">
								<label for="SiO2_c" class="col-sm-4 col-form-label">SiO2</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="SiO2_c" name="SiO2_c" placeholder="Enter SiO2" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="Al2O3_c" class="col-sm-4 col-form-label">Al2O3</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="Al2O3_c" name="Al2O3_c" placeholder="Enter Al2O3" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="Fe2O3_c" class=" col-sm-4 col-form-label">Fe2O3</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="Fe2O3_c" name="Fe2O3_c" placeholder="Enter Fe2O3" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="CaO_c" class="col-sm-4 col-form-label">CaO</label>
								<div class="col-sm-8">
									<input type="number_format" style="height:30px" class="form-control" id="CaO_c" name="CaO_c" placeholder="Enter CaO" >
								</div>
							</div>
						
							<div class="form-group row my-0">
							    <label for="MgO_c" class="col-sm-4 col-form-label">MgO</label>
							    <div class="col-sm-8">
							        <input type="number_format" style="height:30px" class="form-control" id="MgO_c" name="MgOb" placeholder="Enter MgO" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="SO3_c" class="col-sm-4 col-form-label">SO3</label>
							    <div class="col-sm-8">
							        <input type="number_format" style="height:30px" class="form-control" id="SO3_c" name="SO3_c" placeholder="Enter SO3" >
							    </div>
							</div>
							
							<div class="form-group row my-0">
							    <label for="K2O_c" class="col-sm-4 col-form-label">K2O</label>
							    <div class="col-sm-8">
							        <input type="number_format" style="height:30px" class="form-control" id="K2O_c" name="K2O_c" placeholder="Enter K2O" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="Na2O_c" class="col-sm-4 col-form-label">Na2O</label>
							    <div class="col-sm-8">
							        <input type="number_format" style="height:30px" class="form-control" id="Na2O_c" name="Na2O_c" placeholder="Enter Na2O" >
							    </div>
							</div>
							<br></br>
							<div class="form-group row my-0">
							    <label for="RM1" class="col-sm-4 col-form-label">5R1</label>
							    <div class="col-sm-8">
							        <select name="RM1" id="RM1" style="height:30px" class="form-control">
							            <option value=""></option> 
							            <option value="RUN">RUN</option>
							            <option value="STOP">STOP</option>
							        </select>
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="RM2" class="col-sm-4 col-form-label">5R2</label>
							    <div class="col-sm-8">
							        <select name="RM2" id="RM2" style="height:30px" class="form-control">
							            <option value=""></option> 
							            <option value="RUN">RUN</option>
							            <option value="STOP">STOP</option>
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
	        var SiO2_b = document.getElementById("SiO2_b").value;
	        var Al2O3_b = document.getElementById("Al2O3_b").value;
	        var Fe2O3_b = document.getElementById("Fe2O3_b").value;
	        var CaO_b = document.getElementById("CaO_b").value;
	        var MgO_b = document.getElementById("MgO_b").value;
	        var SO3_b = document.getElementById("SO3_b").value;
	        var K2O_b = document.getElementById("K2O_b").value;
	        var Na2O_b = document.getElementById("Na2O_b").value;

	        var inputs = [SiO2_b, Al2O3_b, Fe2O3_b, CaO_b, MgO_b, SO3_b, K2O_b, Na2O_b,  SiO2_c, Al2O3_c, Fe2O3_c, CaO_c, MgO_c, SO3_c, K2O_c, Na2O_c];

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