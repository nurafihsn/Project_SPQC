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
	<h2 class="text-center">FAKTOR KLINKER</h2>
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
		<table class="adminlist mb-3" border="1" width="500" cellpadding="5" >
			<thead>
				<tr class="text-center" >
			            <th rowspan="2"></th> <th colspan="5">OPC 5Z1</th><th  colspan="5">PCC 5Z1</th><th colspan="5">PCC+ 5Z1</th>
			        </tr>
			    <tr bgcolor="#8080FF" style="color:#FFFFFF">
			        <th>Blaine</th><th>SO3</th><th>R45</th><th>LOI</th><th>BTL</th> <th>Blaine</th><th>SO3</th><th>R45</th><th>LOI</th><th>BTL</th> <th>Blaine</th><th>SO3</th><th>R45</th><th>LOI</th><th>BTL</th>
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

				    $count_query = mysqli_query($conn, "SELECT COUNT(BLAINE_z1opc) AS count_blaineopc, COUNT(SO3_z1opc) AS count_so3opc, COUNT(z145u_opc) AS count_r45opc, COUNT(LOI_z1opc) AS count_loiopc, COUNT(BTL_z1opc) AS count_btlopc, COUNT(BLAINE_z1pcc) AS count_blainepcc, COUNT(SO3_z1pcc) AS count_so3pcc, COUNT(z145u_pcc) AS count_r45pcc, COUNT(LOI_z1pcc) AS count_loipcc, COUNT(BTL_z1pcc) AS count_btlpcc,  COUNT(BLAINE_z1ppc) AS count_blaineppc, COUNT(SO3_z1ppc) AS count_so3ppc, COUNT(z145u_ppc) AS count_r45ppc, COUNT(LOI_z1ppc) AS count_loippc, COUNT(BTL_z1ppc) AS count_btlppc FROM lhk_2024 WHERE TANGGAL = '$tgl'");

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
				        $min_query = mysqli_query($conn, "SELECT MIN(BLAINE_z1opc) AS min_blaineopc, MIN(SO3_z1opc) AS min_so3opc, MIN(z145u_opc) AS min_r45opc, MIN(LOI_z1opc) AS min_loiopc, MIN(BTL_z1opc) AS min_btlopc, MIN(BLAINE_z1pcc) AS min_blainepcc, MIN(SO3_z1pcc) AS min_so3pcc, MIN(z145u_pcc) AS min_r45pcc, MIN(LOI_z1pcc) AS min_loipcc, MIN(BTL_z1pcc) AS min_btlpcc,  MIN(BLAINE_z1ppc) AS min_blaineppc, MIN(SO3_z1ppc) AS min_so3ppc, MIN(z145u_ppc) AS min_r45ppc, MIN(LOI_z1ppc) AS min_loippc, MIN(BTL_z1ppc) AS min_btlppc FROM lhk_2024 WHERE TANGGAL = '$tgl'");

					$min_result = mysqli_fetch_assoc($min_query);
					if ($min_result) {
					    foreach ($min_result as $column => $min) {
					        $display_value = $min !== null ? $min : '';
					        $css_class = '';
					        if ($column == 'min_so3ppc' && (floatval($min) < 1 || floatval($min) > 2)) {
					            $css_class = '';
					        } elseif ($column == 'min_so3pcc' && (floatval($min) < 1 || floatval($min) > 1.8)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'min_blainepcc' && (floatval($min) < 430 || floatval($min) > 500)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'min_so3opc' && (floatval($min) < 1 || floatval($min) > 1.8)) {
					            $css_class = 'text-danger font-weight-bold';
					        }  elseif ($column == 'min_r45opc' && (floatval($min) > 8 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }elseif ($column == 'min_r45pcc' && (floatval($min) > 8 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }elseif ($column == 'min_r45ppc' && (floatval($min) > 8 )) {
					            $css_class = 'text-danger';
					        }  elseif ($column == 'min_blaineppc' && (floatval($min) < 360 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }  elseif ($column == 'min_btlopc' && (floatval($min) > 2.7 )) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'min_loiopc' && (floatval($min) > 5 )) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'min_blaineopc' && (floatval($min) < 360 )) {
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
			        $max_query = mysqli_query($conn, "SELECT MAX(BLAINE_z1opc) AS max_blaineopc, MAX(SO3_z1opc) AS max_so3opc, MAX(z145u_opc) AS max_r45opc, MAX(LOI_z1opc) AS max_loiopc, MAX(BTL_z1opc) AS max_btlopc, MAX(BLAINE_z1pcc) AS max_blainepcc, MAX(SO3_z1pcc) AS max_so3pcc, MAX(z145u_pcc) AS max_r45pcc, MAX(LOI_z1pcc) AS max_loipcc, MAX(BTL_z1pcc) AS max_btlpcc,  MAX(BLAINE_z1ppc) AS max_blaineppc, MAX(SO3_z1ppc) AS max_so3ppc, MAX(z145u_ppc) AS max_r45ppc, MAX(LOI_z1ppc) AS max_loippc, MAX(BTL_z1ppc) AS max_btlppc FROM lhk_2024 WHERE TANGGAL = '$tgl'");
			           $max_result = mysqli_fetch_assoc($max_query);
					if ($max_result) {
					    foreach ($max_result as $column => $max) {
					        $display_value = $max !== null ? $max : '';
					       $css_class = '';
					        if ($column == 'max_so3ppc' && (floatval($max) < 1 || floatval($max) > 2)) {
					            $css_class = '';
					        } elseif ($column == 'max_so3pcc' && (floatval($max) < 1 || floatval($max) > 1.8)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'max_blainepcc' && (floatval($max) < 430 || floatval($max) > 500)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'max_so3opc' && (floatval($max) < 1 || floatval($max) > 1.8)) {
					            $css_class = 'text-danger font-weight-bold';
					        }  elseif ($column == 'max_r45opc' && (floatval($max) > 8 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }elseif ($column == 'max_r45pcc' && (floatval($max) > 8 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }elseif ($column == 'max_r45ppc' && (floatval($max) > 8 )) {
					            $css_class = 'text-danger';
					        }  elseif ($column == 'max_blaineppc' && (floatval($max) < 360 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }  elseif ($column == 'max_btlopc' && (floatval($max) > 2.7 )) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'max_loiopc' && (floatval($max) > 5 )) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'max_blaineopc' && (floatval($max) < 360 )) {
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
			       $avg_query = mysqli_query($conn, "SELECT AVG(BLAINE_z1opc) AS avg_blaineopc, AVG(SO3_z1opc) AS avg_so3opc, AVG(z145u_opc) AS avg_r45opc, AVG(LOI_z1opc) AS avg_loiopc, AVG(BTL_z1opc) AS avg_btlopc, AVG(BLAINE_z1pcc) AS avg_blainepcc, AVG(SO3_z1pcc) AS avg_so3pcc, AVG(z145u_pcc) AS avg_r45pcc, AVG(LOI_z1pcc) AS avg_loipcc, AVG(BTL_z1pcc) AS avg_btlpcc,  AVG(BLAINE_z1ppc) AS avg_blaineppc, AVG(SO3_z1ppc) AS avg_so3ppc, AVG(z145u_ppc) AS avg_r45ppc, AVG(LOI_z1ppc) AS avg_loippc, AVG(BTL_z1ppc) AS avg_btlppc FROM lhk_2024 WHERE TANGGAL = '$tgl'");

			    $avg_result = mysqli_fetch_assoc($avg_query);
				if ($avg_result) {
				    foreach ($avg_result as $column => $avg) {
				        $css_class = '';
				        if ($avg === null) {
				            echo "<td></td>";
				        } else {
					           $css_class = '';
					        if ($column == 'avg_so3ppc' && (floatval($avg) < 1 || floatval($avg) > 2)) {
					            $css_class = '';
					        } elseif ($column == 'avg_so3pcc' && (floatval($avg) < 1 || floatval($avg) > 1.8)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'avg_blainepcc' && (floatval($avg) < 430 || floatval($avg) > 500)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'avg_so3opc' && (floatval($avg) < 1 || floatval($avg) > 1.8)) {
					            $css_class = 'text-danger font-weight-bold';
					        }  elseif ($column == 'avg_r45opc' && (floatval($avg) > 8 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }elseif ($column == 'avg_r45pcc' && (floatval($avg) > 8 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }elseif ($column == 'avg_r45ppc' && (floatval($avg) > 8 )) {
					            $css_class = 'text-danger';
					        }  elseif ($column == 'avg_blaineppc' && (floatval($avg) < 360 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }  elseif ($column == 'avg_btlopc' && (floatval($avg) > 2.7 )) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'avg_loiopc' && (floatval($avg) > 5 )) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'avg_blaineopc' && (floatval($avg) < 360 )) {
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

				    $sd_query = mysqli_query($conn, "SELECT STDDEV(BLAINE_z1opc) AS sd_blaineopc, STDDEV(SO3_z1opc) AS sd_so3opc, STDDEV(z145u_opc) AS sd_r45opc, STDDEV(LOI_z1opc) AS sd_loiopc, STDDEV(BTL_z1opc) AS sd_btlopc, STDDEV(BLAINE_z1pcc) AS sd_blainepcc, STDDEV(SO3_z1pcc) AS sd_so3pcc, STDDEV(z145u_pcc) AS sd_r45pcc, STDDEV(LOI_z1pcc) AS sd_loipcc, STDDEV(BTL_z1pcc) AS sd_btlpcc,  STDDEV(BLAINE_z1ppc) AS sd_blaineppc, STDDEV(SO3_z1ppc) AS sd_so3ppc, STDDEV(z145u_ppc) AS sd_r45ppc, STDDEV(LOI_z1ppc) AS sd_loippc, STDDEV(BTL_z1ppc) AS sd_btlppc FROM lhk_2024 WHERE TANGGAL = '$tgl'");

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
					    
					    $kolom = array("blaineopc", "so3opc", "r45opc", "loiopc","btlopc", "blainepcc", "so3pcc", "r45pcc", "loipcc","btlpcc", "blaineppc", "so3ppc", "r45ppc","loippc", "btlppc");
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
			            COUNT(IF(BLAINE_z1opc > 320, 1, NULL)) AS datain_blaineopc,
			            COUNT(IF(SO3_z1opc > 3, 1, NULL)) AS datain_so3opcmax,
			            COUNT(IF(SO3_z1opc < 1, 1, NULL)) AS datain_so3opcmin,
			            COUNT(IF(z145u_opc < 8, 1, NULL)) AS datain_r45opc,
			            COUNT(IF(LOI_z1opc < 5, 1, NULL)) AS datain_loiopc,
			            COUNT(IF(BLAINE_z1pcc > 500, 1, NULL)) AS datain_blainepccmax,
			            COUNT(IF(BLAINE_z1pcc < 400, 1, NULL)) AS datain_blainepccmin,
			            COUNT(IF(SO3_z1pcc > 4, 1, NULL)) AS datain_so3pccmax,
			            COUNT(IF(SO3_z1pcc < 1, 1, NULL)) AS datain_so3pccmin,
			            COUNT(IF(z145u_pcc < 8, 1, NULL)) AS datain_r45pcc,
			            COUNT(IF(LOI_z1pcc < 20, 1, NULL)) AS datain_loipcc,
			            COUNT(IF(BLAINE_z1ppc > 360, 1, NULL)) AS datain_blaineppc,
			            COUNT(IF(SO3_z1ppc > 2.3, 1, NULL)) AS datain_so3ppcmax,
			            COUNT(IF(SO3_z1ppc < 1.3, 1, NULL)) AS datain_so3ppcmin,
			            COUNT(IF(z145u_ppc < 10, 1, NULL)) AS datain_r45ppc,
			            COUNT(IF(LOI_z1ppc < 4.75, 1, NULL)) AS datain_loippc
			            FROM lhk_2024 WHERE TANGGAL = '$tgl'");

			        $datain_result = mysqli_fetch_assoc($datain_query);
			        
			        
			        $kolom = array("blaineopc", "so3opc", "r45opc", "loiopc", "btlopc", "blainepcc", "so3pcc", "r45pcc", "loipcc", "btlpcc", "blaineppc", "so3ppc", "r45ppc", "loippc", "btlppc");
			        foreach ($kolom as $nama_kolom) {

				        $count = $count_result["count_" . strtolower($nama_kolom)];
			            $datain_blaineopc = isset($datain_result["datain_blaineopc"]) ? $datain_result["datain_blaineopc"] : 0;
			            $datain_so3opcmax = isset($datain_result["datain_so3opcmax"]) ? $datain_result["datain_so3opcmax"] : 0;
			            $datain_so3opcmin = isset($datain_result["datain_so3opcmin"]) ? $datain_result["datain_so3opcmin"] : 0;
			            $datain_r45opc = isset($datain_result["datain_r45opc"]) ? $datain_result["datain_r45opc"] : 0;
			            $datain_loiopc = isset($datain_result["datain_loiopc"]) ? $datain_result["datain_loiopc"] : 0;
			            $datain_blainepccmax = isset($datain_result["datain_blainepccmax"]) ? $datain_result["datain_blainepccmax"] : 0;
			            $datain_blainepccmin = isset($datain_result["datain_blainepccmin"]) ? $datain_result["datain_blainepccmin"] : 0;
			            $datain_so3pccmax = isset($datain_result["datain_so3pccmax"]) ? $datain_result["datain_so3pccmax"] : 0;
			            $datain_so3pccmin = isset($datain_result["datain_so3pccmin"]) ? $datain_result["datain_so3pccmin"] : 0;
			            $datain_r45pcc = isset($datain_result["datain_r45pcc"]) ? $datain_result["datain_r45pcc"] : 0;
			            $datain_loipcc = isset($datain_result["datain_loipcc"]) ? $datain_result["datain_loipcc"] : 0;
			            $datain_blaineppc = isset($datain_result["datain_blaineppc"]) ? $datain_result["datain_blaineppc"] : 0;
			            $datain_so3ppcmax = isset($datain_result["datain_so3ppcmax"]) ? $datain_result["datain_so3ppcmax"] : 0;
			            $datain_so3ppcmin = isset($datain_result["datain_so3ppcmin"]) ? $datain_result["datain_so3ppcmin"] : 0;
			            $datain_r45ppc = isset($datain_result["datain_r45ppc"]) ? $datain_result["datain_r45ppc"] : 0;
			            $datain_loippc = isset($datain_result["datain_loippc"]) ? $datain_result["datain_loippc"] : 0;
			            


			            if ($nama_kolom == "blaineopc") {
			                $hasil = $datain_blaineopc;
			            } elseif ($nama_kolom == "so3opc") {
				            $hasil = $count - $datain_so3opcmax - $datain_so3opcmin ;
				        } elseif ($nama_kolom == "r45opc") {
				            $hasil = $datain_r45opc ;
				        } elseif ($nama_kolom == "loiopc") {
				            $hasil = $datain_loiopc ;
				        } elseif ($nama_kolom == "btlopc") {
				            $hasil = 0 ;
				        }  elseif ($nama_kolom == "blainepcc") {
			                $hasil = $count - $datain_blainepccmax - $datain_blainepccmin;
			            } elseif ($nama_kolom == "so3pcc") {
				            $hasil = $count - $datain_so3pccmax - $datain_so3pccmin ;
				        } elseif ($nama_kolom == "r45pcc") {
				            $hasil = $datain_r45pcc ;
				        } elseif ($nama_kolom == "loipcc") {
				            $hasil = $datain_loipcc ;
				        } elseif ($nama_kolom == "btlpcc") {
				            $hasil = 0 ;
				        } elseif ($nama_kolom == "blaineppc") {
			                $hasil = $datain_blaineppc;
			            } elseif ($nama_kolom == "so3ppc") {
				            $hasil = $count - $datain_so3ppcmax - $datain_so3ppcmin ;
				        } elseif ($nama_kolom == "r45ppc") {
				            $hasil = $datain_r45ppc ;
				        } elseif ($nama_kolom == "loippc") {
				            $hasil = $datain_loippc ;
				        } elseif ($nama_kolom == "btlppc") {
				            $hasil = 0 ;
				        } 

				       if ($hasil > 0) {
			                $persentase = ($hasil / $count) * 100;
			                $css_class = '';
			                if ($nama_kolom == "blaineopc" || $nama_kolom == "so3opc"  || $nama_kolom == "r45opc"|| $nama_kolom == "loiopc" || $nama_kolom == "btlopc" || $nama_kolom == "blainepcc" || $nama_kolom == "so3pcc"  || $nama_kolom == "r45pcc"||  $nama_kolom == "loipcc" || $nama_kolom == "btlpcc" || $nama_kolom == "blaineppc" || $nama_kolom == "so3ppc"  || $nama_kolom == "r45ppc" || $nama_kolom == "loippc" || $nama_kolom == "btlppc" ) {
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

			   
			</tr>
			 <tr bgcolor="YELLOW" style="color:BLACK">
				    <th> Faktor Cinker </th>
				    <?php
				    include "../../include/database.php";
					    if (isset($_GET['tgl'])) {
					        $tgl = $_GET['tgl'];
					    } else {
					        $tgl = date('Y-m-d');
					    }
						    
						    $avg_query = mysqli_query($conn, "SELECT AVG(CR_opc) AS avg_cropc FROM z1_6 WHERE TANGGAL = '$tgl'");
			                $avg_result = mysqli_fetch_assoc($avg_query);
			                $avg_cropc = $avg_result['avg_cropc'];

			               echo "<td colspan='5' class='$css_class'>" . number_format((float)$avg_cropc, 3)* 100 . "%</td>";

					?>
					
					<?php
				    include "../../include/database.php";
					    if (isset($_GET['tgl'])) {
					        $tgl = $_GET['tgl'];
					    } else {
					        $tgl = date('Y-m-d');
					    }
						    
						    $avg_query = mysqli_query($conn, "SELECT AVG(CR_pcc) AS avg_crpcc FROM z1_6 WHERE TANGGAL = '$tgl'");
			                $avg_result = mysqli_fetch_assoc($avg_query);
			                $avg_crpcc = $avg_result['avg_crpcc'];

			               echo "<td colspan='5' class='$css_class'>" . number_format((float)$avg_crpcc, 3)* 100 . "%</td>";

					?>
					<?php
				    include "../../include/database.php";
					    if (isset($_GET['tgl'])) {
					        $tgl = $_GET['tgl'];
					    } else {
					        $tgl = date('Y-m-d');
					    }
						    
						    $avg_query = mysqli_query($conn, "SELECT AVG(CR_pcp) AS avg_crppc FROM z1_6 WHERE TANGGAL = '$tgl'");
			                $avg_result = mysqli_fetch_assoc($avg_query);
			                $avg_crppc = $avg_result['avg_crppc'];

			               echo "<td colspan='5' class='$css_class'>" . number_format((float)$avg_crppc, 3)* 100 . "%</td>";

					?>

				</tr>
		</table>

		<table class="adminlist mb-3" border="1" width="500" cellpadding="5" >
			<thead>
				<tr class="text-center" >
			            <th rowspan="2"></th> <th colspan="5">OPC 5Z2</th><th  colspan="5">PCC 5Z2</th><th colspan="5">PCC+ 5Z2</th>
			        </tr>
			    <tr bgcolor="#8080FF" style="color:#FFFFFF">
			        <th>Blaine</th><th>SO3</th><th>R45</th><th>LOI</th><th>BTL</th> <th>Blaine</th><th>SO3</th><th>R45</th><th>LOI</th><th>BTL</th> <th>Blaine</th><th>SO3</th><th>R45</th><th>LOI</th><th>BTL</th>
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

				    $count_query = mysqli_query($conn, "SELECT COUNT(BLAINE_z2opc) AS count_blaineopcz2, COUNT(SO3_z2opc) AS count_so3opcz2, COUNT(z245u_opc) AS count_r45opcz2, COUNT(LOI_z2opc) AS count_loiopcz2, COUNT(BTL_z2opc) AS count_btlopcz2, COUNT(BLAINE_z2pcc) AS count_blainepccz2, COUNT(SO3_z2pcc) AS count_so3pccz2, COUNT(z245u_pcc) AS count_r45pccz2, COUNT(LOI_z2pcc) AS count_loipccz2, COUNT(BTL_z2pcc) AS count_btlpccz2,  COUNT(BLAINE_z2ppc) AS count_blaineppcz2, COUNT(SO3_z2ppc) AS count_so3ppcz2, COUNT(z245u_ppc) AS count_r45ppcz2, COUNT(LOI_z2ppc) AS count_loippcz2, COUNT(BTL_z2ppc) AS count_btlppcz2 FROM lhk_2024 WHERE TANGGAL = '$tgl'");

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
				        $min_query = mysqli_query($conn, "SELECT MIN(BLAINE_z2opc) AS min_blaineopcz2, MIN(SO3_z2opc) AS min_so3opcz2, MIN(z245u_opc) AS min_r45opcz2, MIN(LOI_z2opc) AS min_loiopcz2, MIN(BTL_z2opc) AS min_btlopcz2, MIN(BLAINE_z2pcc) AS min_blainepccz2, MIN(SO3_z2pcc) AS min_so3pccz2, MIN(z245u_pcc) AS min_r45pccz2, MIN(LOI_z2pcc) AS min_loipccz2, MIN(BTL_z2pcc) AS min_btlpccz2,  MIN(BLAINE_z2ppc) AS min_blaineppcz2, MIN(SO3_z2ppc) AS min_so3ppcz2, MIN(z245u_ppc) AS min_r45ppcz2, MIN(LOI_z2ppc) AS min_loippcz2, MIN(BTL_z2ppc) AS min_btlppcz2 FROM lhk_2024 WHERE TANGGAL = '$tgl'");

					$min_result = mysqli_fetch_assoc($min_query);
					if ($min_result) {
					    foreach ($min_result as $column => $min) {
					        $display_value = $min !== null ? $min : '';
					        $css_class = '';
					        if ($column == 'min_so3ppcz2' && (floatval($min) < 1 || floatval($min) > 2)) {
					            $css_class = '';
					        } elseif ($column == 'min_so3pccz2' && (floatval($min) < 1 || floatval($min) > 1.8)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'min_blainepccz2' && (floatval($min) < 430 || floatval($min) > 500)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'min_so3opcz2' && (floatval($min) < 1 || floatval($min) > 1.8)) {
					            $css_class = 'text-danger font-weight-bold';
					        }  elseif ($column == 'min_r45opcz2' && (floatval($min) > 8 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }elseif ($column == 'min_r45pccz2' && (floatval($min) > 8 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }elseif ($column == 'min_r45ppcz2' && (floatval($min) > 8 )) {
					            $css_class = 'text-danger';
					        }  elseif ($column == 'min_blaineppcz2' && (floatval($min) < 360 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }  elseif ($column == 'min_btlopcz2' && (floatval($min) > 2.7 )) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'min_loiopcz2' && (floatval($min) > 5 )) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'min_blaineopcz2' && (floatval($min) < 360 )) {
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
			        $max_query = mysqli_query($conn, "SELECT MAX(BLAINE_z2opc) AS max_blaineopcz2, MAX(SO3_z2opc) AS max_so3opcz2, MAX(z245u_opc) AS max_r45opcz2, MAX(LOI_z2opc) AS max_loiopcz2, MAX(BTL_z2opc) AS max_btlopcz2, MAX(BLAINE_z2pcc) AS max_blainepccz2, MAX(SO3_z2pcc) AS max_so3pccz2, MAX(z245u_pcc) AS max_r45pccz2, MAX(LOI_z2pcc) AS max_loipccz2, MAX(BTL_z2pcc) AS max_btlpccz2,  MAX(BLAINE_z2ppc) AS max_blaineppcz2, MAX(SO3_z2ppc) AS max_so3ppcz2, MAX(z245u_ppc) AS max_r45ppcz2, MAX(LOI_z2ppc) AS max_loippcz2, MAX(BTL_z2ppc) AS max_btlppcz2 FROM lhk_2024 WHERE TANGGAL = '$tgl'");
			           $max_result = mysqli_fetch_assoc($max_query);
					if ($max_result) {
					    foreach ($max_result as $column => $max) {
					        $display_value = $max !== null ? $max : '';
					       $css_class = '';
					        if ($column == 'max_so3ppcz2' && (floatval($max) < 1 || floatval($max) > 2)) {
					            $css_class = '';
					        } elseif ($column == 'max_so3pccz2' && (floatval($max) < 1 || floatval($max) > 1.8)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'max_blainepccz2' && (floatval($max) < 430 || floatval($max) > 500)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'max_so3opcz2' && (floatval($max) < 1 || floatval($max) > 1.8)) {
					            $css_class = 'text-danger font-weight-bold';
					        }  elseif ($column == 'max_r45opcz2' && (floatval($max) > 8 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }elseif ($column == 'max_r45pccz2' && (floatval($max) > 8 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }elseif ($column == 'max_r45ppcz2' && (floatval($max) > 8 )) {
					            $css_class = 'text-danger';
					        }  elseif ($column == 'max_blaineppcz2' && (floatval($max) < 360 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }  elseif ($column == 'max_btlopcz2' && (floatval($max) > 2.7 )) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'max_loiopcz2' && (floatval($max) > 5 )) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'max_blaineopcz2' && (floatval($max) < 360 )) {
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
			       $avg_query = mysqli_query($conn, "SELECT AVG(BLAINE_z2opc) AS avg_blaineopcz2, AVG(SO3_z2opc) AS avg_so3opcz2, AVG(z245u_opc) AS avg_r45opcz2, AVG(LOI_z2opc) AS avg_loiopcz2, AVG(BTL_z2opc) AS avg_btlopcz2, AVG(BLAINE_z2pcc) AS avg_blainepccz2, AVG(SO3_z2pcc) AS avg_so3pccz2, AVG(z245u_pcc) AS avg_r45pccz2, AVG(LOI_z2pcc) AS avg_loipccz2, AVG(BTL_z2pcc) AS avg_btlpccz2,  AVG(BLAINE_z2ppc) AS avg_blaineppcz2, AVG(SO3_z2ppc) AS avg_so3ppcz2, AVG(z245u_ppc) AS avg_r45ppcz2, AVG(LOI_z2ppc) AS avg_loippcz2, AVG(BTL_z2ppc) AS avg_btlppcz2 FROM lhk_2024 WHERE TANGGAL = '$tgl'");

			    $avg_result = mysqli_fetch_assoc($avg_query);
				if ($avg_result) {
				    foreach ($avg_result as $column => $avg) {
				        $css_class = '';
				        if ($avg === null) {
				            echo "<td></td>";
				        } else {
					           $css_class = '';
					        if ($column == 'avg_so3ppcz2' && (floatval($avg) < 1 || floatval($avg) > 2)) {
					            $css_class = '';
					        } elseif ($column == 'avg_so3pccz2' && (floatval($avg) < 1 || floatval($avg) > 1.8)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'avg_blainepccz2' && (floatval($avg) < 430 || floatval($avg) > 500)) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'avg_so3opcz2' && (floatval($avg) < 1 || floatval($avg) > 1.8)) {
					            $css_class = 'text-danger font-weight-bold';
					        }  elseif ($column == 'avg_r45opcz2' && (floatval($avg) > 8 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }elseif ($column == 'avg_r45pccz2' && (floatval($avg) > 8 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }elseif ($column == 'avg_r45ppcz2' && (floatval($avg) > 8 )) {
					            $css_class = 'text-danger';
					        }  elseif ($column == 'avg_blaineppcz2' && (floatval($avg) < 360 )) {
					            $css_class = 'text-danger font-weight-bold';
					        }  elseif ($column == 'avg_btlopcz2' && (floatval($avg) > 2.7 )) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'avg_loiopcz2' && (floatval($avg) > 5 )) {
					            $css_class = 'text-danger font-weight-bold';
					        } elseif ($column == 'avg_blaineopcz2' && (floatval($avg) < 360 )) {
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

				    $sd_query = mysqli_query($conn, "SELECT STDDEV(BLAINE_z2opc) AS sd_blaineopcz2, STDDEV(SO3_z2opc) AS sd_so3opcz2, STDDEV(z245u_opc) AS sd_r45opcz2, STDDEV(LOI_z2opc) AS sd_loiopcz2, STDDEV(BTL_z2opc) AS sd_btlopcz2, STDDEV(BLAINE_z2pcc) AS sd_blainepccz2, STDDEV(SO3_z2pcc) AS sd_so3pccz2, STDDEV(z245u_pcc) AS sd_r45pccz2, STDDEV(LOI_z2pcc) AS sd_loipccz2, STDDEV(BTL_z2pcc) AS sd_btlpccz2,  STDDEV(BLAINE_z2ppc) AS sd_blaineppcz2, STDDEV(SO3_z2ppc) AS sd_so3ppcz2, STDDEV(z245u_ppc) AS sd_r45ppcz2, STDDEV(LOI_z2ppc) AS sd_loippcz2, STDDEV(BTL_z2ppc) AS sd_btlppcz2 FROM lhk_2024 WHERE TANGGAL = '$tgl'");

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
					    
					    $kolom = array("blaineopcz2", "so3opcz2", "r45opcz2", "loiopcz2","btlopcz2", "blainepccz2", "so3pccz2", "r45pccz2", "loipccz2","btlpccz2", "blaineppcz2", "so3ppcz2", "r45ppcz2","loippcz2", "btlppcz2");
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
			            COUNT(IF(BLAINE_z2opc > 320, 1, NULL)) AS datain_blaineopcz2,
			            COUNT(IF(SO3_z2opc > 3, 1, NULL)) AS datain_so3opcz2max,
			            COUNT(IF(SO3_z2opc < 1, 1, NULL)) AS datain_so3opcz2min,
			            COUNT(IF(z245u_opc < 8, 1, NULL)) AS datain_r45opcz2,
			            COUNT(IF(LOI_z2opc < 5, 1, NULL)) AS datain_loiopcz2,
			            COUNT(IF(BLAINE_z2pcc > 500, 1, NULL)) AS datain_blainepccz2max,
			            COUNT(IF(BLAINE_z2pcc < 400, 1, NULL)) AS datain_blainepccz2min,
			            COUNT(IF(SO3_z2pcc > 4, 1, NULL)) AS datain_so3pccz2max,
			            COUNT(IF(SO3_z2pcc < 1, 1, NULL)) AS datain_so3pccz2min,
			            COUNT(IF(z245u_pcc < 8, 1, NULL)) AS datain_r45pccz2,
			            COUNT(IF(LOI_z2pcc < 20, 1, NULL)) AS datain_loipccz2,
			            COUNT(IF(BLAINE_z2ppc > 360, 1, NULL)) AS datain_blaineppcz2,
			            COUNT(IF(SO3_z2ppc > 2.3, 1, NULL)) AS datain_so3ppcz2max,
			            COUNT(IF(SO3_z2ppc < 1.3, 1, NULL)) AS datain_so3ppcz2min,
			            COUNT(IF(z245u_ppc < 10, 1, NULL)) AS datain_r45ppcz2,
			            COUNT(IF(LOI_z2ppc < 4.75, 1, NULL)) AS datain_loippcz2
			            FROM lhk_2024 WHERE TANGGAL = '$tgl'");

			        $datain_result = mysqli_fetch_assoc($datain_query);
			        
			        
			        $kolom = array("blaineopcz2", "so3opcz2", "r45opcz2", "loiopcz2", "btlopcz2", "blainepccz2", "so3pccz2", "r45pccz2", "loipccz2", "btlpccz2", "blaineppcz2", "so3ppcz2", "r45ppcz2", "loippcz2", "btlppcz2");
			        foreach ($kolom as $nama_kolom) {

				        $count = $count_result["count_" . strtolower($nama_kolom)];
			            $datain_blaineopcz2 = isset($datain_result["datain_blaineopcz2"]) ? $datain_result["datain_blaineopcz2"] : 0;
			            $datain_so3opcz2max = isset($datain_result["datain_so3opcz2max"]) ? $datain_result["datain_so3opcz2max"] : 0;
			            $datain_so3opcz2min = isset($datain_result["datain_so3opcz2min"]) ? $datain_result["datain_so3opcz2min"] : 0;
			            $datain_r45opcz2 = isset($datain_result["datain_r45opcz2"]) ? $datain_result["datain_r45opcz2"] : 0;
			            $datain_loiopcz2 = isset($datain_result["datain_loiopcz2"]) ? $datain_result["datain_loiopcz2"] : 0;
			            $datain_blainepccz2max = isset($datain_result["datain_blainepccz2max"]) ? $datain_result["datain_blainepccz2max"] : 0;
			            $datain_blainepccz2min = isset($datain_result["datain_blainepccz2min"]) ? $datain_result["datain_blainepccz2min"] : 0;
			            $datain_so3pccz2max = isset($datain_result["datain_so3pccz2max"]) ? $datain_result["datain_so3pccz2max"] : 0;
			            $datain_so3pccz2min = isset($datain_result["datain_so3pccz2min"]) ? $datain_result["datain_so3pccz2min"] : 0;
			            $datain_r45pccz2 = isset($datain_result["datain_r45pccz2"]) ? $datain_result["datain_r45pccz2"] : 0;
			            $datain_loipccz2 = isset($datain_result["datain_loipccz2"]) ? $datain_result["datain_loipccz2"] : 0;
			            $datain_blaineppcz2 = isset($datain_result["datain_blaineppcz2"]) ? $datain_result["datain_blaineppcz2"] : 0;
			            $datain_so3ppcz2max = isset($datain_result["datain_so3ppcz2max"]) ? $datain_result["datain_so3ppcz2max"] : 0;
			            $datain_so3ppcz2min = isset($datain_result["datain_so3ppcz2min"]) ? $datain_result["datain_so3ppcz2min"] : 0;
			            $datain_r45ppcz2 = isset($datain_result["datain_r45ppcz2"]) ? $datain_result["datain_r45ppcz2"] : 0;
			            $datain_loippcz2 = isset($datain_result["datain_loippcz2"]) ? $datain_result["datain_loippcz2"] : 0;
			            


			            if ($nama_kolom == "blaineopcz2") {
			                $hasil = $datain_blaineopcz2;
			            } elseif ($nama_kolom == "so3opcz2") {
				            $hasil = $count - $datain_so3opcz2max - $datain_so3opcz2min ;
				        } elseif ($nama_kolom == "r45opcz2") {
				            $hasil = $datain_r45opcz2 ;
				        } elseif ($nama_kolom == "loiopcz2") {
				            $hasil = $datain_loiopcz2 ;
				        } elseif ($nama_kolom == "btlopcz2") {
				            $hasil = 0 ;
				        }  elseif ($nama_kolom == "blainepccz2") {
			                $hasil = $count - $datain_blainepccz2max - $datain_blainepccz2min;
			            } elseif ($nama_kolom == "so3pccz2") {
				            $hasil = $count - $datain_so3pccz2max - $datain_so3pccz2min ;
				        } elseif ($nama_kolom == "r45pccz2") {
				            $hasil = $datain_r45pccz2 ;
				        } elseif ($nama_kolom == "loipccz2") {
				            $hasil = $datain_loipccz2 ;
				        } elseif ($nama_kolom == "btlpccz2") {
				            $hasil = 0 ;
				        } elseif ($nama_kolom == "blaineppcz2") {
			                $hasil = $datain_blaineppcz2;
			            } elseif ($nama_kolom == "so3ppcz2") {
				            $hasil = $count - $datain_so3ppcz2max - $datain_so3ppcz2min ;
				        } elseif ($nama_kolom == "r45ppcz2") {
				            $hasil = $datain_r45ppcz2 ;
				        } elseif ($nama_kolom == "loippcz2") {
				            $hasil = $datain_loippcz2 ;
				        } elseif ($nama_kolom == "btlppcz2") {
				            $hasil = 0 ;
				        } 

				       if ($hasil > 0) {
			                $persentase = ($hasil / $count) * 100;
			                $css_class = '';
			                if ($nama_kolom == "blaineopcz2" || $nama_kolom == "so3opcz2"  || $nama_kolom == "r45opcz2"|| $nama_kolom == "loiopcz2" || $nama_kolom == "btlopcz2" || $nama_kolom == "blainepccz2" || $nama_kolom == "so3pccz2"  || $nama_kolom == "r45pccz2"||  $nama_kolom == "loipccz2" || $nama_kolom == "btlpccz2" || $nama_kolom == "blaineppcz2" || $nama_kolom == "so3ppcz2"  || $nama_kolom == "r45ppcz2" || $nama_kolom == "loippcz2" || $nama_kolom == "btlppcz2" ) {
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

			   
			</tr>
			 <tr bgcolor="YELLOW" style="color:BLACK">
				    <th> Faktor Cinker </th>
				    <?php
				    include "../../include/database.php";
					    if (isset($_GET['tgl'])) {
					        $tgl = $_GET['tgl'];
					    } else {
					        $tgl = date('Y-m-d');
					    }
						    
						    $avg_query = mysqli_query($conn, "SELECT AVG(CR_opc) AS avg_cropc FROM z2_5 WHERE TANGGAL = '$tgl'");
			                $avg_result = mysqli_fetch_assoc($avg_query);
			                $avg_cropc = $avg_result['avg_cropc'];

			               echo "<td colspan='5' class='$css_class'>" . number_format((float)$avg_cropc, 3)* 100 . "%</td>";

					?>
					
					<?php
				    include "../../include/database.php";
					    if (isset($_GET['tgl'])) {
					        $tgl = $_GET['tgl'];
					    } else {
					        $tgl = date('Y-m-d');
					    }
						    
						    $avg_query = mysqli_query($conn, "SELECT AVG(CR_pcc) AS avg_crpcc FROM z2_5 WHERE TANGGAL = '$tgl'");
			                $avg_result = mysqli_fetch_assoc($avg_query);
			                $avg_crpcc = $avg_result['avg_crpcc'];

			               echo "<td colspan='5' class='$css_class'>" . number_format((float)$avg_crpcc, 3)* 100 . "%</td>";

					?>
					<?php
				    include "../../include/database.php";
					    if (isset($_GET['tgl'])) {
					        $tgl = $_GET['tgl'];
					    } else {
					        $tgl = date('Y-m-d');
					    }
						    
						    $avg_query = mysqli_query($conn, "SELECT AVG(CR_pcp) AS avg_crppc FROM z2_5 WHERE TANGGAL = '$tgl'");
			                $avg_result = mysqli_fetch_assoc($avg_query);
			                $avg_crppc = $avg_result['avg_crppc'];

			               echo "<td colspan='5' class='$css_class'>" . number_format((float)$avg_crppc, 3)* 100 . "%</td>";

					?>

				</tr>


		</table>
				
	








		


				
				


					        
  
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