<?php
session_start();
$level = strtoupper($_SESSION['level']);
if ($level == NULL) echo "<script>window.location = '../index.php'</script>";
include "../../include/database_ind5.php";
?>
<html>
<head>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

</head>

<body>
	<h2 class="text-center">JURNAL KUALITAS HARIAN</h2>
	<h2 class="text-center mb-5" >PABRIK INDARUNG V</h2>
	<form method="get" class="mb-3">
			<label>PILIH TANGGAL : </label>
			<input type="date" name="tgl">
			<input class="btn btn-primary" type="submit" value="FILTER">

		</form>
		<h3 class="text-center">
			<?php
			    if(isset($_GET['tgl'])){
			        $tgl = $_GET['tgl'];
			        echo "<label>JURNAL $tgl</label>";
			    }
			    ?>
		</h3>
		<table class="adminlist mb-3" border="1" width="500" cellpadding="5">
			<thead>
				<tr class="text-center" >
			            <th rowspan="2"></th> <th colspan="2">LS STG</th><th  colspan="3">5R1</th><th  colspan="3">5R2</th><th colspan="3">KF</th><th colspan="6">CR</th><th colspan="2">F.CoaL</th><th colspan="1">CF</th><th colspan="1">RC</th>
			        </tr>
			    <tr bgcolor="#8080FF" style="color:#FFFFFF">
			        <th>SiO2</th><th>CaO</th><th>LSF</th><th>SIM</th><th>ALM</th><th>LSF</th><th>SIM</th><th>ALM</th><th>LSF</th><th>SIM</th><th>ALM</th><th>FCaO</th><th>LSF</th><th>SIM</th><th>ALM</th><th>C3S</th><th>C3A</th><th>H2O</th><th>ASH</th><th>SILO</th><th>H2O</th>
			    </tr> 
			    
			</thead>
			     
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>COUNT</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				    } else {
				        $tgl = date('Y-m-d');
				    }

				    $count_query = mysqli_query($conn, "SELECT COUNT(SiO2_lstg) AS count_sio2lstg, COUNT(CaO_lstg) AS count_cao, COUNT(LSF_r1) AS count_lsfr1, COUNT(SIM_r1) AS count_simr1, COUNT(ALM_r1) AS count_almr1, COUNT(LSF_r2) AS count_lsfr2, COUNT(SIM_r2) AS count_simr2, COUNT(ALM_r2) AS count_almr2, COUNT(LSF_kf) AS count_lsfkf, COUNT(SIM_kf) AS count_simkf, COUNT(ALM_kf) AS count_almkf, COUNT(FLIME_cr) AS count_fcaocr, COUNT(LSF_cr) AS count_lsfcr, COUNT(SIM_cr) AS count_simcr, COUNT(ALM_cr) AS count_almcr, COUNT(C3S_cr) AS count_c3scr, COUNT(C3A_cr) AS count_c3acr, COUNT(fcH2O_fc) AS count_h2ofc, COUNT(ASH_fc) AS count_ashfc, COUNT(rcH2O_fc) AS count_h2orc FROM lhk_2024 WHERE TANGGAL = '$tgl'");

				    $count_result = mysqli_fetch_assoc($count_query);
				    foreach ($count_result as $count) {
				        $display_value = ' ';
				        if ($count > 0) {
				            $display_value = number_format(floatval($count));
				        } else {
				            $display_value = '';
				        }
				        echo "<td>".$display_value."</td>";
				    }
				    ?>
				</tr>

				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>MIN</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				    } else {
				        $tgl = date('Y-m-d');
				    }
				        $min_query = mysqli_query($conn, "SELECT MIN(SiO2_lstg) AS min_sio2lstg, MIN(CaO_lstg) AS min_cao, MIN(LSF_r1) AS min_lsfr1, MIN(SIM_r1) AS min_simr1, MIN(ALM_r1) AS min_almr1,  MIN(LSF_r2) AS min_lsfr2, MIN(SIM_r2) AS min_simr2, MIN(ALM_r2) AS min_almr2, MIN(LSF_kf) AS min_lsfkf, MIN(SIM_kf) AS min_simkf, MIN(ALM_kf) AS min_almkf, MIN(FLIME_cr) AS min_fcaocr, MIN(LSF_cr) AS min_lsfcr, MIN(SIM_cr) AS min_simcr, MIN(ALM_cr) AS min_almcr, MIN(C3S_cr) AS min_c3scr, MIN(C3A_cr) AS min_c3acr, MIN(fcH2O_fc) AS min_h2ofc , MIN(ASH_fc) AS min_ashfc , 'SILO', MIN(rcH2O_fc) AS min_h2orc FROM lhk_2024 WHERE TANGGAL  = '$tgl'");

					$min_result = mysqli_fetch_assoc($min_query);
					if ($min_result) {
					    foreach ($min_result as $column => $min) {
					        $display_value = $min !== null ? $min : '';
					        $css_class = '';
					        if ($column == 'min_lsfkf' && (floatval($min) < 94 || floatval($min) > 99)) {
					            $css_class = '';
					        } elseif ($column == 'min_simkf' && (floatval($min) < 2.1 || floatval($min) > 2.5)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'min_simr1' && (floatval($min) < 2.1 || floatval($min) > 2.5)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'min_lsfr1' && (floatval($min) < 91 || floatval($min) > 101)) {
					            $css_class = 'text-danger font-weight-bold';
					        }  elseif ($column == 'min_simr2' && (floatval($min) < 2.1 || floatval($min) > 2.5)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'min_lsfr2' && (floatval($min) < 91 || floatval($min) > 101)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'min_c3acr' && (floatval($min) < 7 || floatval($min) > 11)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'min_simcr' && (floatval($min) < 2.1 || floatval($min) > 2.5)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'min_c3scr' && (floatval($min) < 56 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }elseif ($column == 'min_fcaocr' && (floatval($min) > 1.5 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }elseif ($column == 'min_c3scr' && (floatval($min) < 56 )) {
					            $css_class = 'text-danger';
					        } elseif ($column == 'min_lsfcr' && (floatval($min) < 95 || floatval($min) > 96.9)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'min_cao' && (floatval($min) < 46 )) {
					            $css_class = 'text-danger font-weight-bold';
					        } 
					        echo "<td class='$css_class'>".$display_value."</td>";
					    }
					}
					 else { 
					    $sql = mysqli_query($conn, "SELECT * FROM lhk_2024");
					    while ($data = mysqli_fetch_array($sql)) {
					        // Proses data jika diperlukan
					    }
					}
					?>
				</tr>
				 <tr bgcolor="YELLOW" style="color:BLACK">
			        <th>MAX</th>
			        <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				    } else {
				        $tgl = date('Y-m-d');
				    }
			        $max_query = mysqli_query($conn, "SELECT MAX(SiO2_lstg) AS max_sio2lstg, MAX(CaO_lstg) AS max_cao, MAX(LSF_r1) AS max_lsfr1, MAX(SIM_r1) AS max_simr1, MAX(ALM_r1) AS max_almr1, MAX(LSF_r2) AS max_lsfr2, MAX(SIM_r2) AS max_simr2, MAX(ALM_r2) AS max_almr2, MAX(LSF_kf) AS max_lsfkf, MAX(SIM_kf) AS max_simkf, MAX(ALM_kf) AS max_almkf, MAX(FLIME_cr) AS max_fcaocr, MAX(LSF_cr) AS max_lsfcr, MAX(SIM_cr) AS max_simcr, MAX(ALM_cr) AS max_almcr, MAX(C3S_cr) AS max_c3scr, MAX(C3A_cr) AS max_c3acr, MAX(fcH2O_fc) AS max_h2ofc , MAX(ASH_fc) AS max_ashfc,  'HE', MAX(rcH2O_fc) AS max_h2orc  FROM lhk_2024 WHERE TANGGAL  = '$tgl'");
			           $max_result = mysqli_fetch_assoc($max_query);
					if ($max_result) {
					    foreach ($max_result as $column => $max) {
					        $display_value = $max !== null ? $max : '';
					       $css_class = '';
					        if ($column == 'max_lsfkf' && (floatval($max) < 94 || floatval($max) > 99)) {
					            $css_class = '';
					        } elseif ($column == 'max_simkf' && (floatval($max) < 2.1 || floatval($max) > 2.5)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'max_simr1' && (floatval($max) < 2.1 || floatval($max) > 2.5)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'max_lsfr1' && (floatval($max) < 91 || floatval($max) > 101)) {
					            $css_class = 'text-danger font-weight-bold';
					        }  elseif ($column == 'max_simr2' && (floatval($max) < 2.1 || floatval($max) > 2.5)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'max_lsfr2' && (floatval($max) < 91 || floatval($max) > 101)) {
					            $css_class = 'text-danger font-weight-bold';
					        }  elseif ($column == 'max_c3acr' && (floatval($max) < 7 || floatval($max) > 11)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'max_simcr' && (floatval($max) < 2.1 || floatval($max) > 2.5)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'max_c3scr' && (floatval($max) < 56 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }elseif ($column == 'max_fcaocr' && (floatval($max) > 1.5 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }elseif ($column == 'max_c3scr' && (floatval($max) < 56 )) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'max_lsfcr' && (floatval($max) < 95 || floatval($max) > 96.9)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'max_cao' && (floatval($max) < 46 )) {
					            $css_class = 'text-danger font-weight-bold';
					        } 
					        echo "<td class='$css_class'>".$display_value."</td>";
					    }
					}
					 else {
					    $sql = mysqli_query($conn, "SELECT * FROM lhk_2024");
					    while ($data = mysqli_fetch_array($sql)) {
					        // Proses data jika diperlukan
					    }
					}
					?>
			    </tr>
			     <tr bgcolor="YELLOW" style="color:BLACK">
			        <th>AVERAGE</th>
			         <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				    } else {
				        $tgl = date('Y-m-d');
				    }
			       $avg_query = mysqli_query($conn, "SELECT AVG(SiO2_lstg) AS avg_sio2lstg, AVG(CaO_lstg) AS avg_cao, AVG(LSF_r1) AS avg_lsfr1, AVG(SIM_r1) AS avg_simr1, AVG(ALM_r1) AS avg_almr1,  AVG(LSF_r2) AS avg_lsfr2, AVG(SIM_r2) AS avg_simr2, AVG(ALM_r2) AS avg_almr2, AVG(LSF_kf) AS avg_lsfkf, AVG(SIM_kf) AS avg_simkf, AVG(ALM_kf) AS avg_almkf, AVG(FLIME_cr) AS avg_fcaocr, AVG(LSF_cr) AS avg_lsfcr, AVG(SIM_cr) AS avg_simcr, AVG(ALM_cr) AS avg_almcr, AVG(C3S_cr) AS avg_c3scr, AVG(C3A_cr) AS avg_c3acr, AVG(fcH2O_fc) AS avg_h2ofc, AVG(ASH_fc) AS avg_ashfc ,AVG(SILO_kf) AS avg_silokf , AVG(rcH2O_fc) AS avg_h2orc FROM lhk_2024 WHERE TANGGAL  = '$tgl'");

			    $avg_result = mysqli_fetch_assoc($avg_query);
				if ($avg_result) {
				    foreach ($avg_result as $column => $avg) {
				        $css_class = '';
				        if ($avg === null) {
				            echo "<td></td>";
				        } else {
				            if ($column == 'avg_lsfkf' && (floatval($avg) < 94 || floatval($avg) > 99)) {
					            $css_class = '';
					        } elseif ($column == 'avg_simkf' && (floatval($avg) < 2.1 || floatval($avg) > 2.5)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'avg_simr1' && (floatval($avg) < 2.1 || floatval($avg) > 2.5)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'avg_lsfr1' && (floatval($avg) < 91 || floatval($avg) > 101)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'avg_simr2' && (floatval($avg) < 2.1 || floatval($avg) > 2.5)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'avg_lsfr2' && (floatval($avg) < 91 || floatval($avg) > 101)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'avg_c3acr' && (floatval($avg) < 7 || floatval($avg) > 11)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'avg_simcr' && (floatval($avg) < 2.1 || floatval($avg) > 2.5)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'avg_c3scr' && (floatval($avg) < 56 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }elseif ($column == 'avg_fcaocr' && (floatval($avg) > 1.5 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }elseif ($column == 'avg_c3scr' && (floatval($avg) < 56 )) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'avg_lsfcr' && (floatval($avg) < 95 || floatval($avg) > 96.9)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'avg_cao' && (floatval($avg) < 46 )) {
					            $css_class = 'text-danger font-weight-bold';
					        } 
				            echo "<td class='$css_class'>" . number_format((float)$avg, 2) . "</td>";
				        }
				    }
				}
				 else {
				    $sql = mysqli_query($conn, "SELECT * FROM lhk_2024");
				    while ($data = mysqli_fetch_array($sql)) {
				        // Proses data jika diperlukan
				    }
				}
				?>
			    </tr>
			    <tr bgcolor="YELLOW" style="color:BLACK">
				    <th>SD</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				    } else {
				        $tgl = date('Y-m-d');
				    }

				    $sd_query = mysqli_query($conn, "SELECT STDDEV(SiO2_lstg) AS sd_sio2lstg, STDDEV(CaO_lstg) AS sd_cao, STDDEV(LSF_r1) AS sd_lsfr1, STDDEV(SIM_r1) AS sd_simr1, STDDEV(ALM_r1) AS sd_almr1, STDDEV(LSF_r2) AS sd_lsfr2, STDDEV(SIM_r2) AS sd_simr2, STDDEV(ALM_r2) AS sd_almr2, STDDEV(LSF_kf) AS sd_lsfkf, STDDEV(SIM_kf) AS sd_simkf, STDDEV(ALM_kf) AS sd_almkf, STDDEV(FLIME_cr) AS sd_fcaocr, STDDEV(LSF_cr) AS sd_lsfcr, STDDEV(SIM_cr) AS sd_simcr, STDDEV(ALM_cr) AS sd_almcr, STDDEV(C3S_cr) AS sd_c3scr, STDDEV(C3A_cr) AS sd_c3acr, STDDEV(fcH2O_fc) AS sd_h2ofc, STDDEV(ASH_fc) AS sd_ashfc, STDDEV(rcH2O_fc) AS sd_h2orc FROM lhk_2024 WHERE TANGGAL = '$tgl'");

				    $sd_result = mysqli_fetch_assoc($sd_query);
				    foreach ($sd_result as $sd) {
				        if ($sd === null) {
				            echo "<td></td>";
				        } else {
				            echo "<td>" . number_format((float)$sd, 2) . "</td>";
				        }
				    }
				    ?>
				</tr>

			     <tr bgcolor="YELLOW" style="color:BLACK">
				    <th>Covar</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				    } else {
				        $tgl = date('Y-m-d');
				    }
					    
					    $kolom = array("sio2lstg", "cao", "lsfr1", "simr1", "almr1",  "lsfr2", "simr2", "almr2", "lsfkf", "simkf", "almkf", "fcaocr","lsfcr", "simcr", "almcr", "c3scr","c3acr", "h2ofc", "ashfc");
					    foreach ($kolom as $nama_kolom) {
					        $avg = $avg_result["avg_" . strtolower($nama_kolom)];
							$sd = $sd_result["sd_" . strtolower($nama_kolom)];
							$hasil = '';

						if ($avg > 0) {
						    if ($sd > 0) {
						        $hasil = ($sd / $avg) * 100;
						    }
						}

						if ($hasil !== '' && is_numeric($hasil)) {
					    $css_class = '';
					    if (floatval($hasil) > 15) {
					        $css_class = 'text-danger font-weight-bold';
					    }
					    echo "<td class='$css_class'>" . number_format((float)$hasil, 2) . "%</td>";
					} else {
					    echo "<td></td>";
					}
					} 
						?>

				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
			    <th>%IN</th>
			    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				    } else {
				        $tgl = date('Y-m-d');
				    }
			        $datain_query = mysqli_query($conn, "SELECT 
			            COUNT(IF(SiO2_lstg > 10, 1, NULL)) AS datain_sio2max,
			            COUNT(IF(SiO2_lstg < 7, 1, NULL)) AS datain_sio2min,
			            COUNT(IF(CaO_lstg < 48, 1, NULL)) AS datain_cao,
			            COUNT(IF(LSF_r1 > 107, 1, NULL)) AS datain_lsfr1max,
			            COUNT(IF(LSF_r1 < 91, 1, NULL)) AS datain_lsfr1min,
			            COUNT(IF(SIM_r1 > 2.6, 1, NULL)) AS datain_simr1max,
			            COUNT(IF(SIM_r1 < 2, 1, NULL)) AS datain_simr1min,
			            COUNT(IF(ALM_r1 > 1.9, 1, NULL)) AS datain_almr1max,
			            COUNT(IF(ALM_r1 < 1.3, 1, NULL)) AS datain_almr1min,
			            COUNT(IF(LSF_r2 > 107, 1, NULL)) AS datain_lsfr2max,
			            COUNT(IF(LSF_r2 < 91, 1, NULL)) AS datain_lsfr2min,
			            COUNT(IF(SIM_r2 > 2.6, 1, NULL)) AS datain_simr2max,
			            COUNT(IF(SIM_r2 < 2, 1, NULL)) AS datain_simr2min,
			            COUNT(IF(ALM_r2 > 1.9, 1, NULL)) AS datain_almr2max,
			            COUNT(IF(ALM_r2 < 1.3, 1, NULL)) AS datain_almr2min,
			            COUNT(IF(LSF_kf > 101, 1, NULL)) AS datain_lsfkfmax,
			            COUNT(IF(LSF_kf < 97, 1, NULL)) AS datain_lsfkfmin,
			            COUNT(IF(SIM_kf > 2.6, 1, NULL)) AS datain_simkfmax,
			            COUNT(IF(SIM_kf < 2, 1, NULL)) AS datain_simkfmin,
			            COUNT(IF(ALM_kf > 1.9 , 1, NULL)) AS datain_almkfmax,
			            COUNT(IF(ALM_kf < 1.3 , 1, NULL)) AS datain_almkfmin,
			            COUNT(IF(FLIME_cr > 1.8 , 1, NULL)) AS datain_fcaocr,
			            COUNT(IF(LSF_cr > 100 , 1, NULL)) AS datain_lsfcrmax,
			            COUNT(IF(LSF_cr < 95 , 1, NULL)) AS datain_lsfcrmin,
			            COUNT(IF(SIM_cr > 2.6 , 1, NULL)) AS datain_simcrmax,
			            COUNT(IF(SIM_cr < 2 , 1, NULL)) AS datain_simcrmin,
			            COUNT(IF(ALM_cr > 1.9 , 1, NULL)) AS datain_almcrmax,
			            COUNT(IF(ALM_cr < 1.3 , 1, NULL)) AS datain_almcrmin,
			            COUNT(IF(C3S_cr < 56 , 1, NULL)) AS datain_c3scr,
			            COUNT(IF(C3A_cr > 11 , 1, NULL)) AS datain_c3acrmax,
			            COUNT(IF(C3A_cr < 7 , 1, NULL)) AS datain_c3acrmin,
			            COUNT(IF(fcH2O_fc > 20 , 1, NULL)) AS datain_h2ofc,
			            COUNT(IF(ASH_fc > 20 , 1, NULL)) AS datain_ashfc
			            FROM lhk_2024 WHERE TANGGAL = '$tgl'");

			        $datain_result = mysqli_fetch_assoc($datain_query);
			        
			        
			        $kolom = array("sio2lstg", "cao", "lsfr1", "simr1", "almr1","lsfr2", "simr2", "almr2", "lsfkf", "simkf", "almkf", "fcaocr","lsfcr", "simcr", "almcr", "c3scr","c3acr", "h2ofc", "ashfc");
			        foreach ($kolom as $nama_kolom) {

				        $count = $count_result["count_" . strtolower($nama_kolom)];
			            $datain_sio2max = isset($datain_result["datain_sio2max"]) ? $datain_result["datain_sio2max"] : 0;
			            $datain_sio2min = isset($datain_result["datain_sio2min"]) ? $datain_result["datain_sio2min"] : 0;
			            $datain_cao = isset($datain_result["datain_cao"]) ? $datain_result["datain_cao"] : 0;
			            $datain_lsfr1max = isset($datain_result["datain_lsfr1max"]) ? $datain_result["datain_lsfr1max"] : 0;
			            $datain_lsfr1min = isset($datain_result["datain_lsfr1min"]) ? $datain_result["datain_lsfr1min"] : 0;
			            $datain_simr1max = isset($datain_result["datain_simr1max"]) ? $datain_result["datain_simr1max"] : 0;
			            $datain_simr1min = isset($datain_result["datain_simr1min"]) ? $datain_result["datain_simr1min"] : 0;
			            $datain_almr1max = isset($datain_result["datain_almr1max"]) ? $datain_result["datain_almr1max"] : 0;
			            $datain_almr1min = isset($datain_result["datain_almr1min"]) ? $datain_result["datain_almr1min"] : 0;
			            $datain_lsfr2max = isset($datain_result["datain_lsfr2max"]) ? $datain_result["datain_lsfr2max"] : 0;
			            $datain_lsfr2min = isset($datain_result["datain_lsfr2min"]) ? $datain_result["datain_lsfr2min"] : 0;
			            $datain_simr2max = isset($datain_result["datain_simr2max"]) ? $datain_result["datain_simr2max"] : 0;
			            $datain_simr2min = isset($datain_result["datain_simr2min"]) ? $datain_result["datain_simr2min"] : 0;
			            $datain_almr2max = isset($datain_result["datain_almr2max"]) ? $datain_result["datain_almr2max"] : 0;
			            $datain_almr2min = isset($datain_result["datain_almr2min"]) ? $datain_result["datain_almr2min"] : 0;
			            $datain_lsfkfmax = isset($datain_result["datain_lsfkfmax"]) ? $datain_result["datain_lsfkfmax"] : 0;
			            $datain_lsfkfmin = isset($datain_result["datain_lsfkfmin"]) ? $datain_result["datain_lsfkfmin"] : 0;
			            $datain_simkfmax = isset($datain_result["datain_simkfmax"]) ? $datain_result["datain_simkfmax"] : 0;
			            $datain_simkfmin = isset($datain_result["datain_simkfmin"]) ? $datain_result["datain_simkfmin"] : 0;
			            $datain_almkfmax = isset($datain_result["datain_almkfmax"]) ? $datain_result["datain_almkfmax"] : 0;
			            $datain_almkfmin = isset($datain_result["datain_almkfmin"]) ? $datain_result["datain_almkfmin"] : 0;
			            $datain_fcaocr = isset($datain_result["datain_fcaocr"]) ? $datain_result["datain_fcaocr"] : 0;
			            $datain_lsfcrmax = isset($datain_result["datain_lsfcrmax"]) ? $datain_result["datain_lsfcrmax"] : 0;
			            $datain_lsfcrmin = isset($datain_result["datain_lsfcrmin"]) ? $datain_result["datain_lsfcrmin"] : 0;
			            $datain_simcrmax = isset($datain_result["datain_simcrmax"]) ? $datain_result["datain_simcrmax"] : 0;
			            $datain_simcrmin = isset($datain_result["datain_simcrmin"]) ? $datain_result["datain_simcrmin"] : 0;
			            $datain_almcrmax = isset($datain_result["datain_almcrmax"]) ? $datain_result["datain_almcrmax"] : 0;
			            $datain_almcrmin = isset($datain_result["datain_almcrmin"]) ? $datain_result["datain_almcrmin"] : 0;
			            $datain_c3scr = isset($datain_result["datain_c3scr"]) ? $datain_result["datain_c3scr"] : 0;
			            $datain_c3acrmax = isset($datain_result["datain_c3acrmax"]) ? $datain_result["datain_c3acrmax"] : 0;
			            $datain_c3acrmin = isset($datain_result["datain_c3acrmin"]) ? $datain_result["datain_c3acrmin"] : 0;
			            $datain_h2ofc = isset($datain_result["datain_h2ofc"]) ? $datain_result["datain_h2ofc"] : 0;
			            $datain_ashfc = isset($datain_result["datain_ashfc"]) ? $datain_result["datain_ashfc"] : 0;


			            if ($nama_kolom == "sio2lstg") {
			                $hasil = $count - $datain_sio2max - $datain_sio2min;
			            } elseif ($nama_kolom == "cao") {
				            $hasil = $count - $datain_cao ;
				        } elseif ($nama_kolom == "lsfr1") {
				            $hasil = $count - $datain_lsfr1max - $datain_lsfr1min ;
				        } elseif ($nama_kolom == "simr1") {
				            $hasil = $count - $datain_simr1max - $datain_simr1min ;
				        } elseif ($nama_kolom == "almr1") {
				            $hasil = $count - $datain_almr1max - $datain_almr1min ;
				        } elseif ($nama_kolom == "lsfr2") {
				            $hasil = $count - $datain_lsfr2max - $datain_lsfr2min ;
				        } elseif ($nama_kolom == "simr2") {
				            $hasil = $count - $datain_simr2max - $datain_simr2min ;
				        } elseif ($nama_kolom == "almr2") {
				            $hasil = $count - $datain_almr2max - $datain_almr2min ;
				        }  elseif ($nama_kolom == "lsfkf") {
				            $hasil = $count - $datain_lsfkfmax - $datain_lsfkfmin ;
				        } elseif ($nama_kolom == "simkf") {
				            $hasil = $count - $datain_simkfmax - $datain_simkfmin ;
				        } elseif ($nama_kolom == "almkf") {
				            $hasil = $count - $datain_almkfmax - $datain_almkfmin ;
				        }  elseif ($nama_kolom == "fcaocr") {
				            $hasil = $count -  $datain_fcaocr ;
				        } elseif ($nama_kolom == "lsfcr") {
				            $hasil = $count - $datain_lsfcrmax - $datain_lsfcrmin ;
				        } elseif ($nama_kolom == "simcr") {
				            $hasil = $count - $datain_simcrmax - $datain_simcrmin ;
				        } elseif ($nama_kolom == "almcr") {
				            $hasil = $count - $datain_almcrmax - $datain_almcrmin ;
				        } elseif ($nama_kolom == "c3scr") {
				            $hasil = $count - $datain_c3scr ;
				        } elseif ($nama_kolom == "c3acr") {
				            $hasil = $count - $datain_c3acrmax -$datain_c3acrmin ;
				        } elseif ($nama_kolom == "h2ofc") {
				            $hasil = $count - $datain_h2ofc ;
				        } elseif ($nama_kolom == "ashfc") {
				            $hasil = $count - $datain_ashfc ;
				        }
				       if ($count > 0 || $hasil > 0) {
			                $persentase = ($hasil / $count) * 100;
			                $css_class = '';
			                if ($nama_kolom == "fcaocr" || $nama_kolom == "lsfcr" || $nama_kolom == "simcr" || $nama_kolom == "almcr" || $nama_kolom == "c3scr" || $nama_kolom == "c3acr" ||  $nama_kolom == "lsfkf" ) {
						        if (floatval($persentase) < 79) {
						            $css_class = 'text-danger font-weight-bold';
						        }
						    } elseif ($nama_kolom == "lsfr1"){
							    if (floatval($persentase) < 65) {
							        $css_class = 'text-danger font-weight-bold';
							    }
			                }  elseif ($nama_kolom == "lsfr2"){
							    if (floatval($persentase) < 65) {
							        $css_class = 'text-danger font-weight-bold';
							    }
			                }  elseif ($nama_kolom == "cao"){
							    if (floatval($persentase) < 90) {
							        $css_class = 'text-danger font-weight-bold';
							    }
			                } 
			                echo "<td class='$css_class'>" . number_format((float)$persentase, 2) . "%</td>";
			            } else {
			                echo "<td></td>";
			            }
			        }
			    
			    ?>
			   <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				    } else {
				        $tgl = date('Y-m-d');
				    }
					    
					   $sd_query = mysqli_query($conn, "SELECT STDDEV(LSF_r1) AS sd_lsfr1, STDDEV(LSF_kf) AS sd_lsfkf FROM lhk_2024 WHERE TANGGAL = '$tgl'");
					    $sd_result = mysqli_fetch_assoc($sd_query);

			        if (isset($sd_result["sd_lsfr1"]) && isset($sd_result["sd_lsfkf"])) {
			            $sd_lsfr1 = $sd_result["sd_lsfr1"];
			            $sd_lsfkf = $sd_result["sd_lsfkf"];
			            $hasil = '';

			            if ($sd_lsfr1 > 0 || $sd_lsfkf > 0) {
			                $hasil = ($sd_lsfr1 / $sd_lsfkf); 
			            }

			            if ($hasil !== '' && is_numeric($hasil)) {
			                $css_class = '';
			                if (floatval($hasil) > 15) {
			                    $css_class = 'text-danger font-weight-bold';
			                }
			                echo "<td class='$css_class'>" . number_format((float)$hasil, 2) . "</td>";
			            } else {
			                echo "<td></td>";
			            }
			        } else {
			            echo "<td></td>";
			        }
			    
			    ?>
			</tr>



				
				


					        
  
</body>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>