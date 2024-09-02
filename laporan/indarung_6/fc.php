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
    $fc90u_e = isset($_GET['fc90u_e']) && $_GET['fc90u_e'] !== '' ? $_GET['fc90u_e'] : NULL;
    $H2Ofc_e = isset($_GET['H2Ofc_e']) && $_GET['H2Ofc_e'] !== '' ? $_GET['H2Ofc_e'] : NULL;
    $ASH_e = isset($_GET['ASH_e']) && $_GET['ASH_e'] !== '' ? $_GET['ASH_e'] : NULL;
    $SHIFT_e = isset($_GET['SHIFT_e']) && $_GET['SHIFT_e'] !== '' ? $_GET['SHIFT_e'] : NULL;
    $H2Orc_e = isset($_GET['H2Orc_e']) && $_GET['H2Orc_e'] !== '' ? $_GET['H2Orc_e'] : NULL;
    $id_e = isset($_GET['id_e']) && $_GET['id_e'] !== '' ? $_GET['id_e'] : NULL;

    $sql = "UPDATE fc_6 SET JAM=?, fc90u=?, H2O_fc=?, ASH=?, SHIFT=?, H2O_rc=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        die("Error preparing the SQL statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "ssssssi", $JAM_e, $fc90u_e, $H2Ofc_e, $ASH_e, $SHIFT_e, $H2Orc_e, $id_e);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>window.location = 'fc.php'</script>";
    } 

    mysqli_stmt_close($stmt);
}



	
$jumlahDataPerhalaman = 12;

$halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;

if (isset($_GET['awal']) && isset($_GET['akhir'])) {
    $awal = $_GET['awal'];
    $akhir = $_GET['akhir'];
    $sql_filtered = "SELECT * FROM fc_6 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'";
} elseif (isset($_GET['kemarin'])) {
    $sql_filtered = "SELECT * FROM fc_6 WHERE TANGGAL = CURDATE() - INTERVAL 1 DAY";
}
else {
    $sql_filtered = "SELECT * FROM fc_6 WHERE TANGGAL = CURDATE()";
}

$result_filtered = mysqli_query($conn, $sql_filtered);
$jumlahData = mysqli_num_rows($result_filtered);

$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

$sql = "$sql_filtered LIMIT $awalData, $jumlahDataPerhalaman";
$q = mysqli_query($conn, $sql);
?>

		<center style="font-family: Arial, sans-serif; font-size: 24px; font-weight: bold; color: #333333; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
		    <label>FINE COAL & RAW COAL Indarung 6</label>
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
			        <th>90u</th>
			        <th>H2O</th>
			        <th>ASH</th>
			        <th>ADB</th>
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
				        $count_query = mysqli_query($conn, "SELECT COUNT(fc90u) AS count_fc90u, COUNT(H2O_fc) AS count_h2ofc, COUNT(ASH) AS count_ASH, COUNT(ADB) AS count_adb, COUNT(H2O_rc) AS count_h2orc FROM fc_6 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
				        $count_result = mysqli_fetch_assoc($count_query);
				        foreach ($count_result as $count) {
				            echo "<td>".$count."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM fc_6");
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
			        $min_query = mysqli_query($conn, "SELECT MIN(fc90u) AS min_fc90u, MIN(H2O_fc) AS min_h2ofc, MIN(ASH) AS min_ASH, MIN(ADB) AS min_adb, MIN(H2O_rc) AS min_h2orc FROM fc_6 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
			       $min_result = mysqli_fetch_assoc($min_query);
				        foreach ($min_result as $min) {
				            echo "<td>".number_format($min,2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM fc_6");
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
			     $average_query = mysqli_query($conn, "SELECT AVG(fc90u) AS avg_fc90u, AVG(H2O_fc) AS avg_h2ofc, AVG(ASH) AS avg_ASH, AVG(ADB) AS avg_adb, AVG(H2O_rc) AS avg_h2orc FROM fc_6 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
			        $average_result = mysqli_fetch_assoc($average_query);
				        foreach ($average_result as $average) {
				            echo "<td>".number_format($average, 2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM fc_6");
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
			        $max_query = mysqli_query($conn, "SELECT MAX(fc90u) AS max_fc90u, MAX(H2O_fc) AS max_h2ofc, MAX(ASH) AS max_ASH, MAX(ADB) AS max_adb, MAX(H2O_rc) AS max_h2orc FROM fc_6 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
			         $max_result = mysqli_fetch_assoc($max_query);
				        foreach ($max_result as $max) {
				            echo "<td>".$max."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM fc_6");
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
				      $sd_query = mysqli_query($conn, "SELECT STDDEV(fc90u) AS sd_fc90u, STDDEV(H2O_fc) AS sd_h2ofc, STDDEV(ASH) AS sd_ASH, STDDEV(ADB) AS sd_adb, STDDEV(H2O_rc) AS sd_h2orc FROM fc_6 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'");
				        $sd_result = mysqli_fetch_assoc($sd_query);
				        foreach ($sd_result as $sd) {
				            echo "<td>".number_format($sd, 2)."</td>";
				        }
				    } else {
				        $sql = mysqli_query($conn,"SELECT * FROM fc_6");
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
	                <a href="exportfc.php" class="btn btn-primary" > Download </a>
	            </div>
	        </div>        
	    </div>
	</div>
	    


		<div>
			 <table class="table table-striped table-bordered table-hover m">
				<thead>

					<tr class="text-center" >
			             <th  rowspan="1" ></th><th  rowspan="1" ></th><th colspan="4">FINE COAL</th><th colspan="2">RAW COAL</th> 
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>Tanggal</th><th>Jam</th><th>90u</th><th>H2O</th><th>ASH</th> <th>ADB</th> <th>SHIFT</th> <th>H2O</th> <th>Report</th><th class="text-center">Action</th>
					</tr>
				</thead>

				<tbody>
					    <?php
					    $n = $awalData;
					    while ($d = mysqli_fetch_array($q)) {
					        
						$adb = null;
						if (!empty($d['ASH']) && !empty($d['H2O_fc']) && $d['H2O_fc'] != 0) {
						    $adb = $d['ASH'] * (100 / (100 - $d['H2O_fc']));
						}
						$adb = !is_null($adb) ? number_format((float)$adb, 2, '.', '') : null;


					    $update_query = "UPDATE fc_6 SET ADB=" . (!is_null($adb) ? "'$adb'" : "NULL") . " WHERE id=" . $d['id'];

					        if (mysqli_query($conn, $update_query)) {
							        echo " ";
							    } else {
							        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
							    }

							$w_ash = '';
					        if ($d['ASH'] > $configs['ACfc6']['max'] ) {
					            $w_ash = 'text-danger';
					        }
					        $w_h2ofc = '';
					        if ($d['H2O_fc'] > $configs['H2Ofc6']['max'] ) {
					            $w_h2ofc = 'text-danger';
					        }
					        $w_90u  = '';
							if ($d['fc90u'] > $configs['fc90u6']['max']) {
							    $w_90u = 'text-danger';
							}
							$w_h2orc = '';
							if ($d['H2O_rc'] > 40) {
							    $w_h2orc = 'text-danger';
							}

					    ?>

					        <tr>
					        	<td><?php echo $d['TANGGAL']; ?></td>
					            <td><?php echo $d['JAM']; ?></td>
					            <td class="<?php echo $w_90u; ?>"><?php echo $d['fc90u']; ?></td>
					            <td class="<?php echo $w_h2ofc; ?>"><?php echo $d['H2O_fc']; ?></td>
					            <td class="<?php echo $w_ash; ?>"><?php echo $d['ASH']; ?></td>
					            <td><?php echo $adb; ?></td>
					            <td><?php echo $d['SHIFT']; ?></td>
					            <td class="<?php echo $w_h2orc; ?>"><?php echo $d['H2O_rc']; ?></td>
					            <td><?php echo $d['waktu'] ; ?> <a> <?php echo $d['iduser'] ; ?></a></td>
					            
					            
					            <td align="center">
					                <a href="#" type="button" style="height:34px" class="btn btn-success btn-md  pl-4 pr-4" data-toggle="modal" data-target="#myModal<?php echo $d['id']; ?>"><i class="fa fa-fw fa-edit"></i>Edit</a>
					                <a href="del-fc.php?delId=<?php echo $d['id']; ?>" type="button" class="btn btn-danger" style="height:34px" onClick="return confirm('Are you sure to delete this data?');"><i class="fa fa-fw fa-trash"></i> Delete</a>
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
											$sql = "SELECT * FROM fc_6 where id ='$id' ";
											$qr = mysqli_query($conn, $sql);

											//$result = mysqli_query($conn, $query);
											while ($row = mysqli_fetch_array($qr)) {
											?>
 

												<input type="hidden" name="id_e" value="<?php echo $row['id']; ?>">

												<div class="form-group row my-0">
													<label for="JAM" class="col-sm-4 col-form-label">Jam Ke-</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="JAM-e" name="JAM_e" value="<?= $row['JAM']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="fc90u" class="col-sm-4 col-form-label">90u</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="fc90u_e" name="fc90u_e" value="<?= $row['fc90u']; ?>">
													</div>
												</div>
												<div class="form-group row my-0">
												    <label for="H2O_fc" class="col-sm-4 col-form-label">H2O_fc</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="H2Ofc_e" name="H2Ofc_e" value="<?= $row['H2O_fc']; ?>">
												    </div>
												</div>

												<div class="form-group row my-0">
													<label for="ASH" class="col-sm-4 col-form-label">ASH</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="ASH_e" name="ASH_e" value="<?= $row['ASH']; ?>">
													</div>
												</div>

												<div class="form-group row my-0">
													<label for="SHIFT" class="col-sm-4 col-form-label">SHIFT Ke-</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="SHIFT_e" name="SHIFT_e" value="<?= $row['SHIFT']; ?>">
													</div>
												</div>

												
												<div class="form-group row my-0">
												    <label for="H2O_rc" class="col-sm-4 col-form-label">H2O_rc</label>
												    <div class="col-sm-8">
												        <input type="text" style="height:30px" class="form-control" id="H2Orc_e" name="H2Orc_e" value="<?= $row['H2O_rc']; ?>">
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
	$fc90u = !empty($_POST['fc90u']) ? $_POST['fc90u'] : NULL;
	$H2O_fc = !empty($_POST['H2O_fc']) ? $_POST['H2O_fc'] : NULL;
	$ASH = !empty($_POST['ASH']) ? $_POST['ASH'] : NULL;
	$SHIFT = !empty($_POST['SHIFT']) ? $_POST['SHIFT'] : NULL;
	$H2O_rc = !empty($_POST['H2O_rc']) ? $_POST['H2O_rc'] : NULL;
	
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
	                       
	                       $sql = "INSERT INTO fc_6 (TANGGAL, JAM, fc90u, H2O_fc, ASH, SHIFT, H2O_rc, waktu, iduser) 
							        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
							$stmt = $conn->prepare($sql);

							if ($stmt) {
							    $stmt->bind_param('sssssssss', $tanggal, $JAM, $fc90u, $H2O_fc, $ASH, $SHIFT, $H2O_rc, $waktu, $username);

						    if (mysqli_stmt_execute($stmt)) {
						        echo "<script>window.location = 'fc.php'</script>";
						    } else {
						        echo "Execute failed: (" . mysqli_stmt_errno($stmt) . ") " . mysqli_stmt_error($stmt);
						    }
						}}

	                    $sql = "SELECT * FROM fc_6 WHERE TANGGAL = CURDATE()";
	                    $q = mysqli_query($conn, $sql);
	                ?>

	

					<div class="container" >
						<form method="POST" onsubmit="return validateForm()">

							<div class="form-group row my-0">
								<label for="JAM" class="col-sm-4 col-form-label">Jam Ke-</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="JAM" name="JAM" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="fc90u" class="col-sm-4 col-form-label">90u</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="fc90u" name="fc90u" placeholder="Enter 90u" >
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="H2O_fc" class="col-sm-4 col-form-label">H2O_fc</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="H2O_fc" name="H2O_fc" placeholder="Enter H2O" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="ASH" class="col-sm-4 col-form-label">ASH</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="ASH" name="ASH" placeholder="Enter ASH" >
								</div>
							</div>

							<div class="form-group row my-0">
								<label for="SHIFT" class="col-sm-4 col-form-label">SHIFT Ke-</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="SHIFT" name="SHIFT" >
								</div>
							</div>
							
							<div class="form-group row my-0">
							    <label for="H2O_rc" class="col-sm-4 col-form-label">H2O_rc</label>
							    <div class="col-sm-8">
							        <input type="text" style="height:30px" class="form-control" id="H2O_rc" name="H2O_rc" placeholder="Enter H2O" >
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
	        var fc90u = document.getElementById("fc90u").value;
	        var H2O_fc = document.getElementById("H2O_fc").value;
	        var ASH = document.getElementById("ASH").value;
	        var H2O_rc = document.getElementById("H2O_rc").value;

	        var inputs = [fc90u, H2O_fc, ASH, H2O_rc];

	        for (var i = 0; i < inputs.length; i++) {
	            console.log("Nilai input:", inputs[i]);
	            if (inputs[i].indexOf(",") !== -1) {
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