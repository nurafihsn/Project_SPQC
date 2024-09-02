
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
	        'JAM', 'SiO2_z1', 'Al2O3_z1', 'Fe2O3_z1', 'CaO_z1', 'MgO_z1', 'SO3_z1', 
	        'K2O_z1', 'Na2O_z1', 'Cl2_z1', 'FCaO_z1', 'SiO2_z2', 'Al2O3_z2', 
	        'Fe2O3_z2', 'CaO_z2', 'MgO_z2', 'SO3_z2', 'K2O_z2', 'Na2O_z2', 'Cl2_z2', 'FCaO_z2'
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

	    $sql = "UPDATE crf_4 SET " . implode(", ", $placeholders) . " WHERE id=?";
	    
	    $stmt = $conn->prepare($sql);

	    if ($stmt === false) {
	        die("Error preparing the SQL statement: " . $conn->error);
	    }

	    $types = str_repeat("s", count($params) - 1) . "i";
	    $values = array_values($params);

	    $stmt->bind_param($types, ...$values);

	    if ($stmt->execute()) {
	        echo "<script>window.location = 'crf.php'</script>";
	    }

	    $stmt->close();
	}



	
$jumlahDataPerhalaman = 24;

$halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;

if (isset($_GET['awal']) && isset($_GET['akhir'])) {
    $awal = $_GET['awal'];
    $akhir = $_GET['akhir'];
    $sql_filtered = "SELECT * FROM crf_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'";
} elseif (isset($_GET['kemarin'])) {
    $sql_filtered = "SELECT * FROM crf_4 WHERE TANGGAL = CURDATE() - INTERVAL 1 DAY";
}
else {
    $sql_filtered = "SELECT * FROM crf_4 WHERE TANGGAL = CURDATE()";
}

$result_filtered = mysqli_query($conn, $sql_filtered);
$jumlahData = mysqli_num_rows($result_filtered);

$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

$sql = "$sql_filtered LIMIT $awalData, $jumlahDataPerhalaman";
$q = mysqli_query($conn, $sql);
?>
		<center style="font-family: Arial, sans-serif; font-size: 24px; font-weight: bold; color: #333333; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
		    <label>CR FEEDER Indarung 4</label>
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
			           <th colspan="1"></th><th colspan="5">CR Feeder 4Z1</th><th colspan="11">OKSIDA</th> <th colspan="1" ></th> <th colspan="5">CR Feeder 4Z2 </th><th colspan="11">OKSIDA</th>
			        </tr>
			    <tr bgcolor="#8080FF" style="color:#FFFFFF">
			        <th></th>
			        <th>LSF</th>
			        <th>SIM</th>
			        <th>ALM</th>
			        <th>C3S</th>
			        <th>C3A</th>
			        <th>SiO2</th>
			        <th>Al2O3</th>
			        <th>Fe2O3</th>
			        <th>CaO</th>
			        <th>MgO</th>
			        <th>SO3</th>
			        <th>K2O</th>
			        <th>Na2O</th>
			        <th>Cl2</th>
			        <th>FCaO</th>
			        <th>SUM</th>
			        <th>ALKALI</th>
			        <th>LSF</th>
			        <th>SIM</th>
			        <th>ALM</th>
			        <th>C3S</th>
			        <th>C3A</th>
			        <th>SiO2</th>
			        <th>Al2O3</th>
			        <th>Fe2O3</th>
			        <th>CaO</th>
			        <th>MgO</th>
			        <th>SO3</th>
			        <th>K2O</th>
			        <th>Na2O</th>
			        <th>Cl2</th>
			        <th>FCaO</th>
			        <th>SUM</th>
			        <th>ALKALI</th>
			       
			    </tr> 
			    

			     <tr bgcolor="YELLOW" style="color:BLACK">
				    <th>COUNT</th>
				    <?php
				    // Periksa apakah variabel $_GET['TANGGAL'] terdefinisi
				    if(isset($_GET['awal']) && isset($_GET['akhir'])){
				        $awal = $_GET['awal'];
			        	$akhir = $_GET['akhir'];
				        // Lakukan query untuk menghitung jumlah setiap kolom berdasarkan tanggal yang dipilih
				      $count_query = mysqli_query($conn, "SELECT COUNT(LSF_z1) AS count_lsfz1, COUNT(SIM_z1) AS count_simz1, COUNT(ALM_z1) AS count_almz1, COUNT(C3S_z1) AS count_c3sz1, COUNT(C3A_z1) AS count_c3az1, COUNT(SiO2_z1) AS count_sio2z1, COUNT(Al2O3_z1) AS count_al2o3z1, COUNT(Fe2O3_z1) AS count_fe2o3z1, COUNT(CaO_z1) AS count_caoz1, COUNT(MgO_z1) AS count_mgoz1, COUNT(SO3_z1) AS count_so3z1, COUNT(K2O_z1) AS count_k2oz1, COUNT(Na2O_z1) AS count_na2oz1, COUNT(Cl2_z1) AS count_cl2z1, COUNT(FCaO_z1) AS count_fcaoz1, COUNT(SUM_z1) AS count_sumz1, COUNT(ALKALI_z1) AS count_alkaliz1, COUNT(LSF_z2) AS count_lsfz2, COUNT(SIM_z2) AS count_simz2, COUNT(ALM_z2) AS count_almz2, COUNT(C3S_z2) AS count_c3sz2, COUNT(C3A_z2) AS count_c3az2, COUNT(SiO2_z2) AS count_sio2z2, COUNT(Al2O3_z2) AS count_al2o3z2, COUNT(Fe2O3_z2) AS count_fe2o3z2, COUNT(CaO_z2) AS count_caoz2, COUNT(MgO_z2) AS count_mgoz2, COUNT(SO3_z2) AS count_so3z2, COUNT(K2O_z2) AS count_k2oz2, COUNT(Na2O_z2) AS count_na2oz2, COUNT(Cl2_z2) AS count_cl2z2, COUNT(FCaO_z2) AS count_fcaoz2, COUNT(SUM_z2) AS count_sumz2, COUNT(ALKALI_z2) AS count_alkaliz2  FROM crf_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

				        // Ambil hasil dari query count
				        $count_result = mysqli_fetch_assoc($count_query);
				        // Tampilkan hasil count dalam baris tabel
				        foreach ($count_result as $count) {
				            echo "<td>".$count."</td>";
				        }
				    } else {
				        // Jika tanggal tidak terdefinisi, tampilkan semua data
				        $sql = mysqli_query($conn,"SELECT * FROM crf_4");
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
			       $min_query = mysqli_query($conn, "SELECT MIN(LSF_z1) AS min_lsfz1, MIN(SIM_z1) AS min_simz1, MIN(ALM_z1) AS min_almz1, MIN(C3S_z1) AS min_c3sz1, MIN(C3A_z1) AS min_c3az1, MIN(SiO2_z1) AS min_sio2z1, MIN(Al2O3_z1) AS min_al2o3z1, MIN(Fe2O3_z1) AS min_fe2o3z1, MIN(CaO_z1) AS min_caoz1, MIN(MgO_z1) AS min_mgoz1, MIN(SO3_z1) AS min_so3z1, MIN(K2O_z1) AS min_k2oz1, MIN(Na2O_z1) AS min_na2oz1, MIN(Cl2_z1) AS min_cl2z1, MIN(FCaO_z1) AS min_fcaoz1, MIN(SUM_z1) AS min_sumz1, MIN(ALKALI_z1) AS min_alkaliz1,  MIN(LSF_z2) AS min_lsfz2, MIN(SIM_z2) AS min_simz2, MIN(ALM_z2) AS min_almz2, MIN(C3S_z2) AS min_c3sz2, MIN(C3A_z2) AS min_c3az2, MIN(SiO2_z2) AS min_sio2z2, MIN(Al2O3_z2) AS min_al2o3z2, MIN(Fe2O3_z2) AS min_fe2o3z2, MIN(CaO_z2) AS min_caoz2, MIN(MgO_z2) AS min_mgoz2, MIN(SO3_z2) AS min_so3z2, MIN(K2O_z2) AS min_k2oz2, MIN(Na2O_z2) AS min_na2oz2, MIN(Cl2_z2) AS min_cl2z2, MIN(FCaO_z2) AS min_fcaoz2, MIN(SUM_z2) AS min_sumz2, MIN(ALKALI_z2) AS min_alkaliz2 FROM crf_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

			       $min_result = mysqli_fetch_assoc($min_query);
				        foreach ($min_result as $min) {
				            echo "<td>".number_format($min,2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM crf_4");
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
			        $average_query = mysqli_query($conn, "SELECT AVG(LSF_z1) AS avg_lsfz1, AVG(SIM_z1) AS avg_simz1, AVG(ALM_z1) AS avg_almz1, AVG(C3S_z1) AS avg_c3sz1, AVG(C3A_z1) AS avg_c3az1, AVG(SiO2_z1) AS avg_sio2z1, AVG(Al2O3_z1) AS avg_al2o3z1, AVG(Fe2O3_z1) AS avg_fe2o3z1, AVG(CaO_z1) AS avg_caoz1, AVG(MgO_z1) AS avg_mgoz1, AVG(SO3_z1) AS avg_so3z1, AVG(K2O_z1) AS avg_k2oz1, AVG(Na2O_z1) AS avg_na2oz1, AVG(Cl2_z1) AS avg_cl2z1, AVG(FCaO_z1) AS avg_fcaoz1, AVG(SUM_z1) AS avg_sumz1, AVG(ALKALI_z1) AS avg_alkaliz1, AVG(LSF_z2) AS avg_lsfz2, AVG(SIM_z2) AS avg_simz2, AVG(ALM_z2) AS avg_almz2, AVG(C3S_z2) AS avg_c3sz2, AVG(C3A_z2) AS avg_c3az2, AVG(SiO2_z2) AS avg_sio2z2, AVG(Al2O3_z2) AS avg_al2o3z2, AVG(Fe2O3_z2) AS avg_fe2o3z2, AVG(CaO_z2) AS avg_caoz2, AVG(MgO_z2) AS avg_mgoz2, AVG(SO3_z2) AS avg_so3z2, AVG(K2O_z2) AS avg_k2oz2, AVG(Na2O_z2) AS avg_na2oz2, AVG(Cl2_z2) AS avg_cl2z2, AVG(FCaO_z2) AS avg_fcaoz2, AVG(SUM_z2) AS avg_sumz2, AVG(ALKALI_z2) AS avg_alkaliz2 FROM crf_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

			        $average_result = mysqli_fetch_assoc($average_query);
				        foreach ($average_result as $average) {
				            echo "<td>".number_format($average, 2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM crf_4");
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
			        $max_query = mysqli_query($conn, "SELECT MAX(LSF_z1) AS max_lsfz1, MAX(SIM_z1) AS max_simz1, MAX(ALM_z1) AS max_almz1, MAX(C3S_z1) as max_c3sz1, MAX(C3A_z1) as max_c3az1, MAX(SiO2_z1) AS max_sio2z1, MAX(Al2O3_z1) AS max_al2o3z1, MAX(Fe2O3_z1) AS max_fe2o3z1, MAX(CaO_z1) AS max_caoz1, MAX(MgO_z1) AS max_mgoz1, MAX(SO3_z1) AS max_so3z1, MAX(K2O_z1) AS max_k2oz1, MAX(Na2O_z1) AS max_na2oz1, MAX(Cl2_z1) AS max_cl2z1, MAX(FCaO_z1) AS max_fcaoz1, MAX(SUM_z1) AS max_sumz1, MAX(ALKALI_z1) AS max_alkaliz1, MAX(LSF_z2) AS max_lsfz2, MAX(SIM_z2) AS max_simz2, MAX(ALM_z2) AS max_almz2, MAX(C3S_z2) as max_c3sz2, MAX(C3A_z2) as max_c3az2, MAX(SiO2_z2) AS max_sio2z2, MAX(Al2O3_z2) AS max_al2o3z2, MAX(Fe2O3_z2) AS max_fe2o3z2, MAX(CaO_z2) AS max_caoz2, MAX(MgO_z2) AS max_mgoz2, MAX(SO3_z2) AS max_so3z2, MAX(K2O_z2) AS max_k2oz2, MAX(Na2O_z2) AS max_na2oz2, MAX(Cl2_z2) AS max_cl2z2, MAX(FCaO_z2) AS max_fcaoz2, MAX(SUM_z2) AS max_sumz2, MAX(ALKALI_z2) AS max_alkaliz2 FROM crf_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
			         $max_result = mysqli_fetch_assoc($max_query);
				        foreach ($max_result as $max) {
				            echo "<td>".$max."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM crf_4");
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
			       $sd_query = mysqli_query($conn, "SELECT STDDEV(LSF_z1) AS sd_lsfz1, STDDEV(SIM_z1) AS sd_simz1, STDDEV(ALM_z1) AS sd_almz1, STDDEV(C3S_z1) AS sd_c3sz1, STDDEV(C3A_z1) AS sd_c3az1, STDDEV(SiO2_z1) AS sd_sio2z1, STDDEV(Al2O3_z1) AS sd_al2o3z1, STDDEV(Fe2O3_z1) AS sd_fe2o3z1, STDDEV(CaO_z1) AS sd_caoz1, STDDEV(MgO_z1) AS sd_mgoz1, STDDEV(SO3_z1) AS sd_so3z1, STDDEV(K2O_z1) AS sd_k2oz1, STDDEV(Na2O_z1) AS sd_na2oz1, STDDEV(Cl2_z1) AS sd_cl2z1, STDDEV(FCaO_z1) AS sd_fcaoz1, STDDEV(SUM_z1) AS sd_sumz1, STDDEV(ALKALI_z1) AS sd_alkaliz1, STDDEV(LSF_z2) AS sd_lsfz2, STDDEV(SIM_z2) AS sd_simz2, STDDEV(ALM_z2) AS sd_almz2, STDDEV(C3S_z2) AS sd_c3sz2, STDDEV(C3A_z2) AS sd_c3az2, STDDEV(SiO2_z2) AS sd_sio2z2, STDDEV(Al2O3_z2) AS sd_al2o3z2, STDDEV(Fe2O3_z2) AS sd_fe2o3z2, STDDEV(CaO_z2) AS sd_caoz2, STDDEV(MgO_z2) AS sd_mgoz2, STDDEV(SO3_z2) AS sd_so3z2, STDDEV(K2O_z2) AS sd_k2oz2, STDDEV(Na2O_z2) AS sd_na2oz2, STDDEV(Cl2_z2) AS sd_cl2z2, STDDEV(FCaO_z2) AS sd_fcaoz2, STDDEV(SUM_z2) AS sd_sumz2, STDDEV(ALKALI_z2) AS sd_alkaliz2 FROM crf_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");

			        $sd_result = mysqli_fetch_assoc($sd_query);
				        foreach ($sd_result as $sd) {
				            echo "<td>".number_format($sd, 2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM crf_4");
				        while($data = mysqli_fetch_array($sql)){
				        }
				    }
				    ?>
			    </tr>  
			</table>
			<table class="adminlist mb-3" border="1" width="500" cellpadding="5">
				<tr class="text-center" >
                        <th  rowspan="1" ></th><th colspan="4">CR 4Z1</th><th colspan="4">CR 4Z2</th> 
                    </tr>
			    <tr bgcolor="#8080FF" style="color:#FFFFFF">
				    <th></th>
				    <th>FCaO</th>
				    <th>LSF</th>
				    <th>C3S</th>
				    <th>C3A</th>
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
				            COUNT(IF(FCaO_z1 > 1.5, 1, NULL)) AS datain_fcaoz1,
				            COUNT(IF(LSF_z1 > 98, 1, NULL)) AS datain_lsfmaxz1,
				            COUNT(IF(LSF_z1 < 93, 1, NULL)) AS datain_lsfminz1,
				            COUNT(IF(C3S_z1 < 56, 1, NULL)) AS datain_c3sz1,
				            COUNT(IF(C3A_z1 < 8, 1, NULL)) AS datain_c3aminz1,
				            COUNT(IF(C3A_z1 > 12, 1, NULL)) AS datain_c3amaxz1,
				            COUNT(IF(FCaO_z2 > 1.5, 1, NULL)) AS datain_fcaoz2,
				            COUNT(IF(LSF_z2 > 98, 1, NULL)) AS datain_lsfmaxz2,
				            COUNT(IF(LSF_z2 < 93, 1, NULL)) AS datain_lsfminz2,
				            COUNT(IF(C3S_z2 < 56, 1, NULL)) AS datain_c3sz2,
				            COUNT(IF(C3A_z2 < 8, 1, NULL)) AS datain_c3aminz2,
				            COUNT(IF(C3A_z2 > 12, 1, NULL)) AS datain_c3amaxz2
				            FROM crf_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
 
				        $datain_result = mysqli_fetch_assoc($datain_query);
				        $kolom = array("fcaoz1", "lsfz1", "c3sz1", "c3az1", "fcaoz2", "lsfz2", "c3sz2", "c3az2");
				        foreach ($kolom as $nama_kolom) {
				            $count = $count_result["count_" . strtolower($nama_kolom)];
				            $datain_lsfmaxz1 = isset($datain_result["datain_lsfmaxz1"]) ? $datain_result["datain_lsfmaxz1"] : 0;
				            $datain_lsfminz1 = isset($datain_result["datain_lsfminz1"]) ? $datain_result["datain_lsfminz1"] : 0;
				            $datain_c3amaxz1 = isset($datain_result["datain_c3amaxz1"]) ? $datain_result["datain_c3amaxz1"] : 0;
				            $datain_c3aminz1 = isset($datain_result["datain_c3aminz1"]) ? $datain_result["datain_c3aminz1"] : 0;
				            $datain_lsfmaxz2 = isset($datain_result["datain_lsfmaxz2"]) ? $datain_result["datain_lsfmaxz2"] : 0;
				            $datain_lsfminz2 = isset($datain_result["datain_lsfminz2"]) ? $datain_result["datain_lsfminz2"] : 0;
				            $datain_c3amaxz2 = isset($datain_result["datain_c3amaxz2"]) ? $datain_result["datain_c3amaxz2"] : 0;
				            $datain_c3aminz2 = isset($datain_result["datain_c3aminz2"]) ? $datain_result["datain_c3aminz2"] : 0;
				            $datain = isset($datain_result["datain_" . strtolower($nama_kolom)]) ? $datain_result["datain_" . strtolower($nama_kolom)] : 0;
				            if ($nama_kolom == "LSF_z1") {
				                $hasil = $count - $datain_lsfmaxz1 - $datain_lsfminz1;
				            } else if ($nama_kolom == "C3A_z1") {
				                $hasil = $count - $datain_c3amaxz1 - $datain_c3aminz1;
				            } else if ($nama_kolom == "LSF_z2") {
				                $hasil = $count - $datain_lsfmaxz2 - $datain_lsfminz2;
				            } else if ($nama_kolom == "C3A_z2") {
				                $hasil = $count - $datain_c3amaxz2 - $datain_c3aminz2;
				            } else {
				                $hasil = $count - $datain;
				            }
				            echo "<td>" . $hasil . "</td>";
				        }
				    }
				    ?>
				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>DATA IN</th>
				    <?php
				    if (isset($_GET['awal']) && isset($_GET['akhir'])) {
				        $awal = $_GET['awal'];
				        $akhir = $_GET['akhir'];

				        $datain_query = mysqli_query($conn, "SELECT 
				            COUNT(IF(FCaO_z1 > 1.5, 1, NULL)) AS datain_fcaoz1,
				            COUNT(IF(LSF_z1 > 98, 1, NULL)) AS datain_lsfmaxz1,
				            COUNT(IF(LSF_z1 < 93, 1, NULL)) AS datain_lsfminz1,
				            COUNT(IF(C3S_z1 < 56, 1, NULL)) AS datain_c3sz1,
				            COUNT(IF(C3A_z1 < 8, 1, NULL)) AS datain_c3aminz1,
				            COUNT(IF(C3A_z1 > 12, 1, NULL)) AS datain_c3amaxz1,
				            COUNT(IF(FCaO_z2 > 1.5, 1, NULL)) AS datain_fcaoz2,
				            COUNT(IF(LSF_z2 > 98, 1, NULL)) AS datain_lsfmaxz2,
				            COUNT(IF(LSF_z2 < 93, 1, NULL)) AS datain_lsfminz2,
				            COUNT(IF(C3S_z2 < 56, 1, NULL)) AS datain_c3sz2,
				            COUNT(IF(C3A_z2 < 8, 1, NULL)) AS datain_c3aminz2,
				            COUNT(IF(C3A_z2 > 12, 1, NULL)) AS datain_c3amaxz2
				            FROM crf_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
 
				        $datain_result = mysqli_fetch_assoc($datain_query);
				        $kolom = array("fcaoz1", "lsfz1", "c3sz1", "c3az1", "fcaoz2", "lsfz2", "c3sz2", "c3az2");
				        foreach ($kolom as $nama_kolom) {
				            $count = $count_result["count_" . strtolower($nama_kolom)];
				            $datain_lsfmaxz1 = isset($datain_result["datain_lsfmaxz1"]) ? $datain_result["datain_lsfmaxz1"] : 0;
				            $datain_lsfminz1 = isset($datain_result["datain_lsfminz1"]) ? $datain_result["datain_lsfminz1"] : 0;
				            $datain_c3amaxz1 = isset($datain_result["datain_c3amaxz1"]) ? $datain_result["datain_c3amaxz1"] : 0;
				            $datain_c3aminz1 = isset($datain_result["datain_c3aminz1"]) ? $datain_result["datain_c3aminz1"] : 0;
				            $datain_lsfmaxz2 = isset($datain_result["datain_lsfmaxz2"]) ? $datain_result["datain_lsfmaxz2"] : 0;
				            $datain_lsfminz2 = isset($datain_result["datain_lsfminz2"]) ? $datain_result["datain_lsfminz2"] : 0;
				            $datain_c3amaxz2 = isset($datain_result["datain_c3amaxz2"]) ? $datain_result["datain_c3amaxz2"] : 0;
				            $datain_c3aminz2 = isset($datain_result["datain_c3aminz2"]) ? $datain_result["datain_c3aminz2"] : 0;
				            $datain = isset($datain_result["datain_" . strtolower($nama_kolom)]) ? $datain_result["datain_" . strtolower($nama_kolom)] : 0;
				            if ($nama_kolom == "LSF_z1") {
				                $hasil = $count - $datain_lsfmaxz1 - $datain_lsfminz1;
				            } else if ($nama_kolom == "C3A_z1") {
				                $hasil = $count - $datain_c3amaxz1 - $datain_c3aminz1;
				            } else if ($nama_kolom == "LSF_z2") {
				                $hasil = $count - $datain_lsfmaxz2 - $datain_lsfminz2;
				            } else if ($nama_kolom == "C3A_z2") {
				                $hasil = $count - $datain_c3amaxz2 - $datain_c3aminz2;
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
	                <a href="exportcrf.php" class="btn btn-primary" > Download </a>
	            </div>
	        </div>        
	    </div>
	</div>
	    


		<div>
			 <table class="table table-striped table-bordered table-hover">
				<thead>

					<tr class="text-center" >
			            <th  rowspan="1" ></th><th  rowspan="1" ></th><th colspan="5">CR FEEDER Z1</th><th colspan="11">OKSIDA</th> <th colspan="1"></th><th colspan="1"></th></th><th colspan="5">CR FEEDER Z2</th><th colspan="11">OKSIDA</th> <th colspan="1"></th><th colspan="1"></th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>Tanggal</th><th>Jam</th><th>LSF</th> <th>SIM</th> <th>ALM</th><th>C3S</th> <th>C3A</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th> <th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>FCaO</th><th>SUM</th><th>Alkali</th><th>KETERANGAN</th><th>LSF</th> <th>SIM</th> <th>ALM</th><th>C3S</th> <th>C3A</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th> <th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>FCaO</th><th>SUM</th><th>Alkali</th><th>KETERANGAN</th> <th>Report</th>

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
					    	
					        $lsfz1 = null;
							if (!empty($d['SiO2_z1']) && ($d['SiO2_z1'] != 0 || $d['Al2O3_z1'] != 0 || $d['Fe2O3_z1'] != 0)) {
							    $lsfz1 = ($d['CaO_z1'] * $configs['lsf_1']) / ($configs['lsf_2']* $d['SiO2_z1'] + $configs['lsf_3']* $d['Al2O3_z1'] + $configs['lsf_4'] * $d['Fe2O3_z1']);
							}
							$lsfz1 = !is_null($lsfz1) ? number_format((float)$lsfz1, 2, '.', '') : null;

							$simz1 = null;
							if (!empty($d['SiO2_z1']) && ($d['Al2O3_z1'] + $d['Fe2O3_z1'] != 0)) {
							    $simz1 =  $d['SiO2_z1'] / ($d['Al2O3_z1'] + $d['Fe2O3_z1']);
							}
							$simz1 = !is_null($simz1) ? number_format((float)$simz1, 2, '.', '') : null;

							$almz1 = null;
							if (!empty($d['Al2O3_z1']) && $d['Fe2O3_z1'] != 0) {
							    $almz1 =  $d['Al2O3_z1'] / $d['Fe2O3_z1'];
							}
							$almz1 = !is_null($almz1) ? number_format((float)$almz1, 2, '.', '') : null;

							$c3sz1 = null;
							if (!empty($d['SiO2_z1'])) {
							    $c3sz1 = 4.071 * ($d['CaO_z1'] - $d['FCaO_z1']) - 7.6 * $d['SiO2_z1'] - 6.718 * $d['Al2O3_z1'] - 1.43 * $d['Fe2O3_z1'];
							}
							$c3sz1 = !is_null($c3sz1) ? number_format((float)$c3sz1, 2, '.', '') : null;

							$c3az1 = null;
							if (!empty($d['Al2O3_z1'])) {
							    $c3az1 = 2.65 * $d['Al2O3_z1'] - 1.692 * $d['Fe2O3_z1'];
							}
							$c3az1 = !is_null($c3az1) ? number_format((float)$c3az1, 2, '.', '') : null;

							$sumz1 = null;
							if (!empty($d['SiO2_z1'])) {
							    $sumz1 = $d['SiO2_z1'] + $d['Al2O3_z1'] + $d['Fe2O3_z1'] + $d['CaO_z1'] + $d['MgO_z1'] + $d['SO3_z1'] + $d['K2O_z1'] + $d['Na2O_z1'] + $d['K2O_z1'];
							}
							$sumz1 = !is_null($sumz1) ? number_format((float)$sumz1, 2, '.', '') : null;

							$alkaliz1 = null;
							if (!empty($d['Na2O_z1']) || !empty($d['K2O_z1'])) {
							    $alkaliz1 =  $d['Na2O_z1'] + ($d['K2O_z1'] * $configs['alkali']);
							}
							$alkaliz1 = !is_null($alkaliz1) ? number_format((float)$alkaliz1, 2, '.', '') : null;

							$lsfz2 = null;
							if (!empty($d['SiO2_z2']) && ($d['SiO2_z2'] != 0 || $d['Al2O3_z2'] != 0 || $d['Fe2O3_z2'] != 0)) {
							    $lsfz2 = ($d['CaO_z2'] * $configs['lsf_1']) / ($configs['lsf_2']* $d['SiO2_z2'] + $configs['lsf_3']* $d['Al2O3_z2'] + $configs['lsf_4'] * $d['Fe2O3_z2']);
							}
							$lsfz2 = !is_null($lsfz2) ? number_format((float)$lsfz2, 2, '.', '') : null;

							$simz2 = null;
							if (!empty($d['SiO2_z2']) && ($d['Al2O3_z2'] + $d['Fe2O3_z2'] != 0)) {
							    $simz2 =  $d['SiO2_z2'] / ($d['Al2O3_z2'] + $d['Fe2O3_z2']);
							}
							$simz2 = !is_null($simz2) ? number_format((float)$simz2, 2, '.', '') : null;

							$almz2 = null;
							if (!empty($d['Al2O3_z2']) && $d['Fe2O3_z2'] != 0) {
							    $almz2 =  $d['Al2O3_z2'] / $d['Fe2O3_z2'];
							}
							$almz2 = !is_null($almz2) ? number_format((float)$almz2, 2, '.', '') : null;

							$c3sz2 = null;
							if (!empty($d['SiO2_z2'])) {
							    $c3sz2 = 4.071 * ($d['CaO_z2'] - $d['FCaO_z2']) - 7.6 * $d['SiO2_z2'] - 6.718 * $d['Al2O3_z2'] - 1.43 * $d['Fe2O3_z2'];
							}
							$c3sz2 = !is_null($c3sz2) ? number_format((float)$c3sz2, 2, '.', '') : null;

							$c3az2 = null;
							if (!empty($d['Al2O3_z2'])) {
							    $c3az2 = 2.65 * $d['Al2O3_z2'] - 1.692 * $d['Fe2O3_z2'];
							}
							$c3az2 = !is_null($c3az2) ? number_format((float)$c3az2, 2, '.', '') : null;

							$sumz2 = null;
							if (!empty($d['SiO2_z2'])) {
							    $sumz2 = $d['SiO2_z2'] + $d['Al2O3_z2'] + $d['Fe2O3_z2'] + $d['CaO_z2'] + $d['MgO_z2'] + $d['SO3_z2'] + $d['K2O_z2'] + $d['Na2O_z2'] + $d['K2O_z2'];
							}
							$sumz2 = !is_null($sumz2) ? number_format((float)$sumz2, 2, '.', '') : null;

							$alkaliz2 = null;
							if (!empty($d['Na2O_z2']) || !empty($d['K2O_z2'])) {
							    $alkaliz2 =  $d['Na2O_z2'] + ($d['K2O_z2'] * $configs['alkali']);
							}
							$alkaliz2 = !is_null($alkaliz2) ? number_format((float)$alkaliz2, 2, '.', '') : null;

							$update_query = "UPDATE crf_4 SET LSF_z1=" . ($lsfz1 !== null ? "'$lsfz1'" : "NULL") . ", SIM_z1=" . ($simz1 !== null ? "'$simz1'" : "NULL") . ", ALM_z1=" . ($almz1 !== null ? "'$almz1'" : "NULL") . ", C3S_z1=" . ($c3sz1 !== null ? "'$c3sz1'" : "NULL") . ", C3A_z1=" . ($c3az1 !== null ? "'$c3az1'" : "NULL") . ", SUM_z1=" . ($sumz1 !== null ? "'$sumz1'" : "NULL") . ", ALKALI_z1=" . ($alkaliz1 !== null ? "'$alkaliz1'" : "NULL") . " , LSF_z2=" . ($lsfz2 !== null ? "'$lsfz2'" : "NULL") . ", SIM_z2=" . ($simz2 !== null ? "'$simz2'" : "NULL") . ", ALM_z2=" . ($almz2 !== null ? "'$almz2'" : "NULL") . ", C3S_z2=" . ($c3sz2 !== null ? "'$c3sz2'" : "NULL") . ", C3A_z2=" . ($c3az2 !== null ? "'$c3az2'" : "NULL") . ", SUM_z2=" . ($sumz2 !== null ? "'$sumz2'" : "NULL") . ", ALKALI_z2=" . ($alkaliz2 !== null ? "'$alkaliz2'" : "NULL") . " WHERE id=" . $d['id'];

							if (mysqli_query($conn, $update_query)) {
							    echo " ";
							} else {
							    echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
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



							$w_fcaoz1 = '';
					        if ($d['FCaO_z1'] > 1.5 ) {
					            $w_fcaoz1 = 'text-danger';
					        }
					        $w_cl2z1 = '';
					        if ($d['Cl2_z1'] > "1.5" ) {
					            $w_cl2z1 = 'text-danger';
					        }
					        $w_alkaliz1  = '';
							if ($alkaliz1 > 0.6) {
							    $w_alkaliz1 = 'text-danger';
							}
							$w_c3sz1 = '';
							if ($c3sz1 < 56) {
							    $w_c3sz1 = 'text-danger';
							}
					        $w_almz1 = '';
							if ($almz1 < 1.4 || $almz1 > 1.8) {
							    $w_almz1 = 'text-danger';
							}
							$w_simz1 = '';
							if ($simz1 < 2.1 || $simz1 > 2.5) {
							    $w_simz1 = 'text-danger';
							}
					        $w_lsfz1 = '';
							if ($lsfz1 < 93 || $lsfz1 > 97) {
							    $w_lsfz1 = 'text-danger';
							}
							$w_c3az1 = '';
							if ($c3az1 < 8 || $c3az1 > 12) {
							    $w_c3az1 = 'text-danger';
							}$w_fcaoz2 = '';
					        if ($d['FCaO_z2'] > 1.5 ) {
					            $w_fcaoz2 = 'text-danger';
					        }
					        $w_cl2z2 = '';
					        if ($d['Cl2_z2'] > "1.5" ) {
					            $w_cl2z2 = 'text-danger';
					        }
					        $w_alkaliz2  = '';
							if ($alkaliz2 > 0.6) {
							    $w_alkaliz2 = 'text-danger';
							}
							$w_c3sz2 = '';
							if ($c3sz2 < 56) {
							    $w_c3sz2 = 'text-danger';
							}
					        $w_almz2 = '';
							if ($almz2 < 1.4 || $almz2 > 1.8) {
							    $w_almz2 = 'text-danger';
							}
							$w_simz2 = '';
							if ($simz2 < 2.1 || $simz2 > 2.5) {
							    $w_simz2 = 'text-danger';
							}
					        $w_lsfz2 = '';
							if ($lsfz2 < 93 || $lsfz2 > 97) {
							    $w_lsfz2 = 'text-danger';
							}
							$w_c3az2 = '';
							if ($c3az2 < 8 || $c3az2 > 12) {
							    $w_c3az2 = 'text-danger';
							}
					        
					      

					    ?>

					        	<td><?php echo $d['TANGGAL']; ?></td>
					            <td><?php echo $d['JAM']; ?></td>
					            <td class="<?php echo $w_lsfz1; ?>"><?php echo $lsfz1; ?></td>
					            <td class="<?php echo $w_simz1; ?>"><?php echo $simz1; ?></td>
					            <td class="<?php echo $w_almz1; ?>"><?php echo $almz1; ?></td>
					            <td class="<?php echo $w_c3sz1; ?>"><?php echo $c3sz1; ?></td>
					            <td class="<?php echo $w_c3az1; ?>"><?php echo $c3az1; ?></td>
					            <td><?php echo $d['SiO2_z1']; ?></td>
					            <td><?php echo $d['Al2O3_z1']; ?></td>
					            <td><?php echo $d['Fe2O3_z1']; ?></td>
					            <td><?php echo $d['CaO_z1']; ?></td>
					            <td><?php echo $d['MgO_z1']; ?></td>
					            <td><?php echo $d['SO3_z1']; ?></td>
					            <td><?php echo $d['K2O_z1']; ?></td>
					            <td><?php echo $d['Na2O_z1']; ?></td>
					            <td class="<?php echo $w_cl2z1; ?>"><?php echo $d['Cl2_z1']; ?></td>
					            <td class="<?php echo $w_fcaoz1; ?>"><?php echo $d['FCaO_z1']; ?></td>
					            <td><?php echo $sumz1; ?></td>
					            <td class="<?php echo $w_alkaliz1; ?>"><?php echo $alkaliz1; ?></td>
					            <td><?php echo $d['KETERANGAN_z1']; ?></td>
					            <td class="<?php echo $w_lsfz2; ?>"><?php echo $lsfz2; ?></td>
					            <td class="<?php echo $w_simz2; ?>"><?php echo $simz2; ?></td>
					            <td class="<?php echo $w_almz2; ?>"><?php echo $almz2; ?></td>
					            <td class="<?php echo $w_c3sz2; ?>"><?php echo $c3sz2; ?></td>
					            <td class="<?php echo $w_c3az2; ?>"><?php echo $c3az2; ?></td>
					            <td><?php echo $d['SiO2_z2']; ?></td>
					            <td><?php echo $d['Al2O3_z2']; ?></td>
					            <td><?php echo $d['Fe2O3_z2']; ?></td>
					            <td><?php echo $d['CaO_z2']; ?></td>
					            <td><?php echo $d['MgO_z2']; ?></td>
					            <td><?php echo $d['SO3_z2']; ?></td>
					            <td><?php echo $d['K2O_z2']; ?></td>
					            <td><?php echo $d['Na2O_z2']; ?></td>
					            <td class="<?php echo $w_cl2z2; ?>"><?php echo $d['Cl2_z2']; ?></td>
					            <td class="<?php echo $w_fcaoz2; ?>"><?php echo $d['FCaO_z2']; ?></td>
					            <td><?php echo $sumz2; ?></td>
					            <td class="<?php echo $w_alkaliz2; ?>"><?php echo $alkaliz2; ?></td>
					            <td><?php echo $d['KETERANGAN_z2']; ?></td>
					            <td><?php echo $d['waktu'] ; ?> <a> <?php echo $d['iduser'] ; ?></a></td>
					            
					            
					            <td align="center">
					                <a href="#" type="button" style="height:34px" class="btn btn-success btn-md  pl-4 pr-4" data-toggle="modal" data-target="#myModal<?php echo $d['id']; ?>"><i class="fa fa-fw fa-edit"></i>Edit</a>
					                <a href="del-crf.php?delId=<?php echo $d['id']; ?>" type="button" class="btn btn-danger" style="height:34px" onClick="return confirm('Are you sure to delete this data?');"><i class="fa fa-fw fa-trash"></i> Delete</a>
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
											$sql = "SELECT * FROM crf_4 where id ='$id' order by id";
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
													<label for="SiO2_z1" class="col-sm-4 col-form-label">SiO2</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="SiO2_z1_e" name="SiO2_z1_e" value="<?= $row['SiO2_z1']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Al2O3_z1" class="col-sm-4 col-form-label">Al2O3</label>
													<div class="col-sm-8">
														<input type="Al2O3_z1" style="height:30px" class="form-control" id="Al2O3_z1_e" name="Al2O3_z1_e" value="<?= $row['Al2O3_z1']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Fe2O3_z1" class="col-sm-4 col-form-label">Fe2O3</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="Fe2O3_z1_e" name="Fe2O3_z1_e" value="<?= $row['Fe2O3_z1']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="CaO_z1" class="col-sm-4 col-form-label">CaO</label>
													<div class="col-sm-8">
														<input type="CaO_z1" style="height:30px" class="form-control" id="CaO_z1_e" name="CaO_z1_e" value="<?= $row['CaO_z1']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
												    <label for="MgO_z1" class="col-sm-4 col-form-label">MgO</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="MgO_z1_e" name="MgO_z1_e" value="<?= $row['MgO_z1']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="SO3_z1" class="col-sm-4 col-form-label">SO3</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="SO3_z1_e" name="SO3_z1_e" value="<?= $row['SO3_z1']; ?>">
												    </div>
												</div>
												
												<div class="form-group row my-0">
												    <label for="K2O_z1" class="col-sm-4 col-form-label">K2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="K2O_z1_e" name="K2O_z1_e" value="<?= $row['K2O_z1']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="Na2O_z1" class="col-sm-4 col-form-label">Na2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="Na2O_z1_e" name="Na2O_z1_e" value="<?= $row['Na2O_z1']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="Cl2_z1" class="col-sm-4 col-form-label">Cl2</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="Cl2_z1_e" name="Cl2_z1_e" value="<?= $row['Cl2_z1']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="FCaO_z1" class="col-sm-4 col-form-label">FCaO</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="FCaO_z1_e" name="FCaO_z1_e" value="<?= $row['FCaO_z1']; ?>">
												    </div>
												</div>

												<br></br>
												<div class="text-center"> 
												</div>

												<div class="form-group row my-0">
													<label for="SiO2_z2" class="col-sm-4 col-form-label">SiO2</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="SiO2_z2_e" name="SiO2_z2_e" value="<?= $row['SiO2_z2']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Al2O3_z2" class="col-sm-4 col-form-label">Al2O3</label>
													<div class="col-sm-8">
														<input type="Al2O3_z2" style="height:30px" class="form-control" id="Al2O3_z2_e" name="Al2O3_z2_e" value="<?= $row['Al2O3_z2']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="Fe2O3_z2" class="col-sm-4 col-form-label">Fe2O3</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="Fe2O3_z2_e" name="Fe2O3_z2_e" value="<?= $row['Fe2O3_z2']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="CaO_z2" class="col-sm-4 col-form-label">CaO</label>
													<div class="col-sm-8">
														<input type="CaO_z2" style="height:30px" class="form-control" id="CaO_z2_e" name="CaO_z2_e" value="<?= $row['CaO_z2']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
												    <label for="MgO_z2" class="col-sm-4 col-form-label">MgO</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="MgO_z2_e" name="MgO_z2_e" value="<?= $row['MgO_z2']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="SO3_z2" class="col-sm-4 col-form-label">SO3</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="SO3_z2_e" name="SO3_z2_e" value="<?= $row['SO3_z2']; ?>">
												    </div>
												</div>
												
												<div class="form-group row my-0">
												    <label for="K2O_z2" class="col-sm-4 col-form-label">K2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="K2O_z2_e" name="K2O_z2_e" value="<?= $row['K2O_z2']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="Na2O_z2" class="col-sm-4 col-form-label">Na2O</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="Na2O_z2_e" name="Na2O_z2_e" value="<?= $row['Na2O_z2']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="Cl2_z2" class="col-sm-4 col-form-label">Cl2</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="Cl2_z2_e" name="Cl2_z2_e" value="<?= $row['Cl2_z2']; ?>">
												    </div>
												</div>
												<div class="form-group row my-0">
												    <label for="FCaO_z2" class="col-sm-4 col-form-label">FCaO</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="FCaO_z2_e" name="FCaO_z2_e" value="<?= $row['FCaO_z2']; ?>">
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
	$JAM = !empty($_POST['JAM']) ? $_POST['JAM'] : 'NULL';
	$SiO2_z1 = !empty($_POST['SiO2_z1']) ? $_POST['SiO2_z1'] : 'NULL';
	$Al2O3_z1 = !empty($_POST['Al2O3_z1']) ? $_POST['Al2O3_z1'] : 'NULL';
	$Fe2O3_z1 = !empty($_POST['Fe2O3_z1']) ? $_POST['Fe2O3_z1'] : 'NULL';
	$CaO_z1 = !empty($_POST['CaO_z1']) ? $_POST['CaO_z1'] : 'NULL';
	$MgO_z1 = !empty($_POST['MgO_z1']) ? $_POST['MgO_z1'] : 'NULL';
	$SO3_z1 = !empty($_POST['SO3_z1']) ? $_POST['SO3_z1'] : 'NULL';
	$K2O_z1 = !empty($_POST['K2O_z1']) ? $_POST['K2O_z1'] : 'NULL';
	$Na2O_z1 = !empty($_POST['Na2O_z1']) ? $_POST['Na2O_z1'] : 'NULL';
	$Cl2_z1 = !empty($_POST['Cl2_z1']) ? $_POST['Cl2_z1'] : 'NULL';
	$FCaO_z1 = !empty($_POST['FCaO_z1']) ? $_POST['FCaO_z1'] : 'NULL';
	$SiO2_z2 = !empty($_POST['SiO2_z2']) ? $_POST['SiO2_z2'] : 'NULL';
	$Al2O3_z2 = !empty($_POST['Al2O3_z2']) ? $_POST['Al2O3_z2'] : 'NULL';
	$Fe2O3_z2 = !empty($_POST['Fe2O3_z2']) ? $_POST['Fe2O3_z2'] : 'NULL';
	$CaO_z2 = !empty($_POST['CaO_z2']) ? $_POST['CaO_z2'] : 'NULL';
	$MgO_z2 = !empty($_POST['MgO_z2']) ? $_POST['MgO_z2'] : 'NULL';
	$SO3_z2 = !empty($_POST['SO3_z2']) ? $_POST['SO3_z2'] : 'NULL';
	$K2O_z2 = !empty($_POST['K2O_z2']) ? $_POST['K2O_z2'] : 'NULL';
	$Na2O_z2 = !empty($_POST['Na2O_z2']) ? $_POST['Na2O_z2'] : 'NULL';
	$Cl2_z2 = !empty($_POST['Cl2_z2']) ? $_POST['Cl2_z2'] : 'NULL';
	$FCaO_z2 = !empty($_POST['FCaO_z2']) ? $_POST['FCaO_z2'] : 'NULL';

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
	                       
	                        $sql = "INSERT INTO crf_4 (TANGGAL, JAM, SiO2_z1, Al2O3_z1, Fe2O3_z1, CaO_z1, MgO_z1, SO3_z1, K2O_z1, Na2O_z1, Cl2_z1, FCaO_z1,SiO2_z2, Al2O3_z2, Fe2O3_z2, CaO_z2, MgO_z2, SO3_z2, K2O_z2, Na2O_z2, Cl2_z2, FCaO_z2, waktu, iduser) 
	                                VALUES ('$tanggal', $JAM, $SiO2_z1, $Al2O3_z1, $Fe2O3_z1, $CaO_z1, $MgO_z1, $SO3_z1, $K2O_z1, $Na2O_z1, $Cl2_z1, $FCaO_z1, $SiO2_z2, $Al2O3_z2, $Fe2O3_z2, $CaO_z2, $MgO_z2, $SO3_z2, $K2O_z2, $Na2O_z2, $Cl2_z2, $FCaO_z2,'$waktu', '$username')";

	                        $result = mysqli_query($conn, $sql);

	                        if ($result) {
	                            echo "<script>window.location = 'crf.php'</script>";
	                        } else {

	                            echo "Error: " . mysqli_error($conn);
	                        }
	                    }

	                    $sql = "SELECT * FROM crf_4 WHERE TANGGAL = CURDATE()";
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
								<label for="SiO2_z1" class="col-sm-4 col-form-label">SiO2</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="SiO2_z1" name="SiO2_z1" placeholder="Enter SiO2_z1" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="Al2O3_z1" class="col-sm-4 col-form-label">Al2O3</label>
								<div class="col-sm-8">
									<input type="Al2O3_z1" style="height:30px" class="form-control" id="Al2O3_z1" name="Al2O3_z1" placeholder="Enter Al2O3_z1" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="Fe2O3_z1" class=" col-sm-4 col-form-label">Fe2O3</label>
								<div class="col-sm-8">
									<input type="Fe2O3_z1" style="height:30px" class="form-control" id="Fe2O3_z1" name="Fe2O3_z1" placeholder="Enter Fe2O3_z1" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="CaO_z1" class="col-sm-4 col-form-label">CaO</label>
								<div class="col-sm-8">
									<input type="CaO_z1" style="height:30px" class="form-control" id="CaO_z1" name="CaO_z1" placeholder="Enter CaO_z1" >
								</div>
							</div>
						
							<div class="form-group row my-0">
							    <label for="MgO_z1" class="col-sm-4 col-form-label">MgO</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="MgO_z1" name="MgO_z1" placeholder="Enter MgO_z1" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="SO3_z1" class="col-sm-4 col-form-label">SO3</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="SO3_z1" name="SO3_z1" placeholder="Enter SO3_z1" >
							    </div>
							</div>
							
							<div class="form-group row my-0">
							    <label for="K2O_z1" class="col-sm-4 col-form-label">K2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="K2O_z1" name="K2O_z1" placeholder="Enter K2O_z1" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="Na2O_z1" class="col-sm-4 col-form-label">Na2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="Na2O_z1" name="Na2O_z1" placeholder="Enter Na2O_z1" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="Cl2_z1" class="col-sm-4 col-form-label">Cl2</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="Cl2_z1" name="Cl2_z1" placeholder="Enter Cl2_z1" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="FCaO_z1" class="col-sm-4 col-form-label">FCaO</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="FCaO_z1" name="FCaO_z1" placeholder="Enter FCaO_z1" >
							    </div>
							</div>

								<br></br>
								<div class="text-center"> 
								</div>

							<div class="form-group row my-0">
								<label for="SiO2_z2" class="col-sm-4 col-form-label">SiO2</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="SiO2_z2" name="SiO2_z2" placeholder="Enter SiO2_z2" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="Al2O3_z2" class="col-sm-4 col-form-label">Al2O3</label>
								<div class="col-sm-8">
									<input type="Al2O3_z2" style="height:30px" class="form-control" id="Al2O3_z2" name="Al2O3_z2" placeholder="Enter Al2O3_z2" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="Fe2O3_z2" class=" col-sm-4 col-form-label">Fe2O3</label>
								<div class="col-sm-8">
									<input type="Fe2O3_z2" style="height:30px" class="form-control" id="Fe2O3_z2" name="Fe2O3_z2" placeholder="Enter Fe2O3_z2" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="CaO_z2" class="col-sm-4 col-form-label">CaO</label>
								<div class="col-sm-8">
									<input type="CaO_z2" style="height:30px" class="form-control" id="CaO_z2" name="CaO_z2" placeholder="Enter CaO_z2" >
								</div>
							</div>
						
							<div class="form-group row my-0">
							    <label for="MgO_z2" class="col-sm-4 col-form-label">MgO</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="MgO_z2" name="MgO_z2" placeholder="Enter MgO_z2" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="SO3_z2" class="col-sm-4 col-form-label">SO3</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="SO3_z2" name="SO3_z2" placeholder="Enter SO3_z2" >
							    </div>
							</div>
							
							<div class="form-group row my-0">
							    <label for="K2O_z2" class="col-sm-4 col-form-label">K2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="K2O_z2" name="K2O_z2" placeholder="Enter K2O_z2" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="Na2O_z2" class="col-sm-4 col-form-label">Na2O</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="Na2O_z2" name="Na2O_z2" placeholder="Enter Na2O_z2" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="Cl2_z2" class="col-sm-4 col-form-label">Cl2</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="Cl2_z2" name="Cl2_z2" placeholder="Enter Cl2_z2" >
							    </div>
							</div>
							<div class="form-group row my-0">
							    <label for="FCaO_z2" class="col-sm-4 col-form-label">FCaO</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="FCaO_z2" name="FCaO_z2" placeholder="Enter FCaO_z2" >
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
	        var SiO2_z1 = document.getElementById("SiO2_z1").value;
	        var Al2O3_z1 = document.getElementById("Al2O3_z1").value;
	        var Fe2O3_z1 = document.getElementById("Fe2O3_z1").value;
	        var CaO_z1 = document.getElementById("CaO_z1").value;
	        var MgO_z1 = document.getElementById("MgO_z1").value;
	        var SO3_z1 = document.getElementById("SO3_z1").value;
	        var K2O_z1 = document.getElementById("K2O_z1").value;
	        var Na2O_z1 = document.getElementById("Na2O_z1").value;
	        var Cl2_z1 = document.getElementById("Cl2_z1").value;
	        var FCaO_z1 = document.getElementById("FCaO_z1").value;
	        var Al2O3_z2 = document.getElementById("Al2O3_z2").value;
	        var Fe2O3_z2 = document.getElementById("Fe2O3_z2").value;
	        var CaO_z2 = document.getElementById("CaO_z2").value;
	        var MgO_z2 = document.getElementById("MgO_z2").value;
	        var SO3_z2 = document.getElementById("SO3_z2").value;
	        var K2O_z2 = document.getElementById("K2O_z2").value;
	        var Na2O_z2 = document.getElementById("Na2O_z2").value;
	        var Cl2_z2 = document.getElementById("Cl2_z2").value;
	        var FCaO_z2 = document.getElementById("FCaO_z2").value;

	        var inputs = [SiO2_z1, Al2O3_z1, Fe2O3_z1, CaO_z1, MgO_z1, SO3_z1, K2O_z1, Na2O_z1, Cl2_z1, FCaO_z1, SiO2_z2, Al2O3_z2, Fe2O3_z2, CaO_z2, MgO_z2, SO3_z2, K2O_z2, Na2O_z2, Cl2_z2, FCaO_z2];

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