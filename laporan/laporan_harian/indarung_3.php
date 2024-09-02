<?php
session_start();
$level = strtoupper($_SESSION['level']);
if ($level == NULL) echo "<script>window.location = '../index.php'</script>";
include "../../include/database.php";
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
<html>
<head>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  
</head>

<body>
	<h3 class="text-center mb-5">PABRIK INDARUNG 2&3</h3>
	  <form id="filterForm" method="get" class="mb-3">
	    <label>PILIH TANGGAL : </label>
	    <input id="dateInput" type="date" name="tgl">
	    <input class="btn btn-primary" type="submit" value="FILTER">
	  </form>
	  <form  method="get">
	  	<button type="submit" class="btn btn-primary btn-sm" name="opentoday" value="1">Data Hari ini</button>
	    <button type="button" class="btn btn-primary btn-sm" onclick="openData2JamTab()">Data 2 Jam</button>
	  </form>
	  <h5 class="text-center">
	    <?php
	    if(isset($_GET['tgl'])){
	      $tgl = $_GET['tgl'];
	      echo "<label> $tgl</label>";
	    }

	    ?>
	  </h5>
        <h6 class="text-center">RAWMIX</h6>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th colspan="8">2R1</th>
                        </tr>
                        <tr class="bg-primary text-white text-center">
                            <th>JAM</th>
                            <th>LSF</th>
                            <th>SIM</th>
                            <th>ALM</th>
                            <th>ALKALI</th>
                            <th>90u</th>
                            <th>180u</th>
                            <th>H2O</th>
                            <th>Report</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($_GET['data2jam']) && $_GET['data2jam'] == '1'){
                            $sql = "SELECT * FROM r1_3 WHERE TANGGAL = CURDATE() AND waktu >= NOW() - INTERVAL 3 HOUR";
                        } elseif(isset($_GET['tgl'])){
                            $tgl = $_GET['tgl'];
                            $tgl = mysqli_real_escape_string($conn, $tgl);
                            $sql = "SELECT * FROM r1_3 WHERE TANGGAL = '$tgl'";
                        } elseif (isset($_GET['opentoday'])) {
                            $sql = "SELECT * FROM r1_3 WHERE TANGGAL = CURDATE()";
                        } else {
                            $sql = "SELECT * FROM r1_3 WHERE TANGGAL = CURDATE()";
                        }

                        $q = mysqli_query($conn, $sql);
                        while ($d = mysqli_fetch_array($q)) {
                            $w_180ur1 = '';
                            if (!empty($d['rm180u']) && $d['rm180u'] > $configs['rm180u4a']['max']) {
                                $w_180ur1 = 'text-danger font-weight-bold';
                            }

                            $w_90ur1 = '';
                            if (!empty($d['rm90u']) && $d['rm90u'] > $configs['rm90u4a']['max']) {
                                $w_90ur1 = 'text-danger font-weight-bold';
                            }

                            $w_h2or1 = '';
                            if (!empty($d['H2O']) && ($d['H2O'] < $configs['H2Orm4a']['min'] || $d['H2O'] > $configs['H2Orm4a']['max'])) {
                                $w_h2or1 = 'text-danger font-weight-bold';
                            }

                            $w_almr1 = '';
                            if (!empty($d['ALM']) && ($d['ALM'] < $configs['ALMrm4a']['min'] || $d['ALM'] > $configs['ALMrm4a']['max'])) {
                                $w_almr1 = 'text-danger font-weight-bold';
                            }

                            $w_lsfr1 = '';
                            if (!empty($d['LSF']) && ($d['LSF'] < $configs['LSFrm4a']['min'] || $d['LSF'] > $configs['LSFrm4a']['max'])) {
                                $w_lsfr1 = 'text-danger font-weight-bold';
                            }

                            $w_simr1 = '';
                            if (!empty($d['SIM']) && ($d['SIM'] < $configs['SIMrm4a']['min'] || $d['SIM'] > $configs['SIMrm4a']['max'])) {
                                $w_simr1 = 'text-danger font-weight-bold';
                            }

                            $w_alkalir1 = '';
                            if (!empty($d['ALKALI']) && $d['ALKALI'] > 0.35) {
                                $w_alkalir1 = 'text-danger font-weight-bold';
                            }

                        ?>

                        <tr class="text-center font-weight-bold">
                            <td><?php echo $d['JAM']; ?></td>
                            <td class="<?php echo $w_lsfr1; ?>"><?php echo $d['LSF']; ?></td>
                            <td class="<?php echo $w_simr1; ?>"><?php echo $d['SIM']; ?></td>
                            <td class="<?php echo $w_almr1; ?>"><?php echo $d['ALM']; ?></td>
                            <td class="<?php echo $w_alkalir1; ?>"><?php echo $d['ALKALI']; ?></td>
                            <td class="<?php echo $w_90ur1; ?>"><?php echo $d['rm90u']; ?></td>
                            <td class="<?php echo $w_180ur1; ?>"><?php echo $d['rm180u']; ?></td>
                            <td class="<?php echo $w_h2or1; ?>"><?php echo $d['H2O']; ?></td>
                            <td><?php echo $d['waktu']; ?> <br><?php echo($d['iduser']); ?></br></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th colspan="8">3R2</th>
                        </tr>
                        <tr class="bg-primary text-white text-center ">
                            <th>JAM</th>
                            <th>LSF</th>
                            <th>SIM</th>
                            <th>ALM</th>
                            <th>ALKALI</th>
                            <th>90u</th>
                            <th>180u</th>
                            <th>H2O</th>
                            <th>Report</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($_GET['data2jam']) && $_GET['data2jam'] == '1'){
                            $sql = "SELECT * FROM r2_3 WHERE TANGGAL = CURDATE() AND waktu >= NOW() - INTERVAL 3 HOUR";
                        } elseif(isset($_GET['tgl'])){
                            $tgl = $_GET['tgl'];
                            $tgl = mysqli_real_escape_string($conn, $tgl);
                            $sql = "SELECT * FROM r2_3 WHERE TANGGAL = '$tgl'";
                        } elseif (isset($_GET['opentoday'])) {
                            $sql = "SELECT * FROM r2_3 WHERE TANGGAL = CURDATE()";
                        } else {
                            $sql = "SELECT * FROM r2_3 WHERE TANGGAL = CURDATE()";
                        }

                        $q = mysqli_query($conn, $sql);
                        while ($d = mysqli_fetch_array($q)) {
                           $w_180ur1 = '';
                            if (!empty($d['rm180u']) && $d['rm180u'] > $configs['rm180u4a']['max']) {
                                $w_180ur1 = 'text-danger font-weight-bold';
                            }

                            $w_90ur1 = '';
                            if (!empty($d['rm90u']) && $d['rm90u'] > $configs['rm90u4a']['max']) {
                                $w_90ur1 = 'text-danger font-weight-bold';
                            }

                            $w_h2or1 = '';
                            if (!empty($d['H2O']) && ($d['H2O'] < $configs['H2Orm4a']['min'] || $d['H2O'] > $configs['H2Orm4a']['max'])) {
                                $w_h2or1 = 'text-danger font-weight-bold';
                            }

                            $w_almr1 = '';
                            if (!empty($d['ALM']) && ($d['ALM'] < $configs['ALMrm4a']['min'] || $d['ALM'] > $configs['ALMrm4a']['max'])) {
                                $w_almr1 = 'text-danger font-weight-bold';
                            }

                            $w_lsfr1 = '';
                            if (!empty($d['LSF']) && ($d['LSF'] < $configs['LSFrm4a']['min'] || $d['LSF'] > $configs['LSFrm4a']['max'])) {
                                $w_lsfr1 = 'text-danger font-weight-bold';
                            }

                            $w_simr1 = '';
                            if (!empty($d['SIM']) && ($d['SIM'] < $configs['SIMrm4a']['min'] || $d['SIM'] > $configs['SIMrm4a']['max'])) {
                                $w_simr1 = 'text-danger font-weight-bold';
                            }

                            $w_alkalir1 = '';
                            if (!empty($d['ALKALI']) && $d['ALKALI'] > 0.35) {
                                $w_alkalir1 = 'text-danger font-weight-bold';
                            }

                        ?>

                        <tr class="text-center font-weight-bold">
                            <td><?php echo $d['JAM']; ?></td>
                            <td class="<?php echo $w_lsfr1; ?>"><?php echo $d['LSF']; ?></td>
                            <td class="<?php echo $w_simr1; ?>"><?php echo $d['SIM']; ?></td>
                            <td class="<?php echo $w_almr1; ?>"><?php echo $d['ALM']; ?></td>
                            <td class="<?php echo $w_alkalir2; ?>"><?php echo $d['ALKALI']; ?></td>
                            <td class="<?php echo $w_90ur1; ?>"><?php echo $d['rm90u']; ?></td>
                            <td class="<?php echo $w_180ur1; ?>"><?php echo $d['rm180u']; ?></td>
                            <td class="<?php echo $w_h2or1; ?>"><?php echo $d['H2O']; ?></td>
                            <td><?php echo $d['waktu']; ?> <br><?php echo($d['iduser']); ?></br></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
   


       <h6 class="text-center">KILN FEED 1</h6>
        <div class="row">
            <div class="col-md-7">
                <table class="table table-striped table-bordered table-hover">
				<thead>
					<tr class="text-center" >
			           <th colspan="11">Kiln Feed</th>
			        </tr>

					<tr class="bg-primary text-white text-center">
						<th>JAM</th> <th>LSF</th> <th>SIM</th> <th>ALM</th> <th>BF</th><th>SO3</th><th>Alkali</th><th>90u</th> <th>180u</th> <th>H2O</th><th>Report</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if(isset($_GET['data2jam']) && $_GET['data2jam'] == '1'){
				    $sql = "SELECT * FROM kf1_3 WHERE TANGGAL = CURDATE() AND waktu >= NOW() - INTERVAL 3 HOUR";
				} elseif(isset($_GET['tgl'])){
				    $tgl = $_GET['tgl'];
				    $tgl = mysqli_real_escape_string($conn, $tgl);
				    $sql = "SELECT * FROM kf1_3 WHERE TANGGAL = '$tgl'";
				} elseif (isset($_GET['opentoday'])) {
				    $sql = "SELECT * FROM kf1_3 WHERE TANGGAL = CURDATE()";
				} else {
				    $sql = "SELECT * FROM kf1_3 WHERE TANGGAL = CURDATE()";
				}

				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
					       $w_180ukf = '';
                            if (!empty($d['kf180u']) && $d['kf180u'] > $configs['kf180u4']['max']) {
                                $w_180ukf = 'text-danger font-weight-bold';
                            }

                            $w_90ukf = '';
                            if (!empty($d['kf90u']) && $d['kf90u'] > $configs['kf90u4']['max']) {
                                $w_90ukf = 'text-danger font-weight-bold';
                            }

                            $w_h2okf = '';
                            if (!empty($d['H2O']) && ($d['H2O'] < $configs['H2Okf4']['min'] || $d['H2O'] > $configs['H2Okf4']['max'])) {
                                $w_h2okf = 'text-danger font-weight-bold';
                            }

                            $w_almkf = '';
                            if (!empty($d['ALM']) && ($d['ALM'] < $configs['ALMkf4']['min'] || $d['ALM'] > $configs['ALMkf4']['max'])) {
                                $w_almkf = 'text-danger font-weight-bold';
                            }

                            $w_simkf = '';
                            if (!empty($d['SIM']) && ($d['SIM'] < $configs['SIMkf4']['min'] || $d['SIM'] > $configs['SIMkf4']['max'])) {
                                $w_simkf = 'text-danger font-weight-bold';
                            }

                            $w_lsfkf = '';
                            if (!empty($d['LSF']) && ($d['LSF'] < $configs['LSFkf4']['min'] || $d['LSF'] > $configs['LSFkf4']['max'])) {
                                $w_lsfkf = 'text-danger font-weight-bold';
                            }

                            $w_alkali = '';
                            if (!empty($d['ALKALI']) && $d['ALKALI'] > 0.35) {
                                $w_alkali = 'text-danger font-weight-bold';
                            }

				?>

					    <tr class="text-center font-weight-bold">
					        <td><?php echo $d['JAM']; ?></td>
					        <td class="<?php echo $w_lsfkf; ?>"><?php echo $d['LSF']; ?> <br> </br></td>
					        <td class="<?php echo $w_simkf; ?>"><?php echo $d['SIM']; ?></td>
					        <td class="<?php echo $w_almkf; ?>"><?php echo $d['ALM']; ?></td>
					        <td class="<?php echo $w_almkf; ?>"><?php echo $d['BF']; ?></td>
					        <td><?php echo $d['SO3']; ?></td>
					        <td class="<?php echo $w_alkali; ?>"><?php echo $d['ALKALI']; ?></td>
					        <td class="<?php echo $w_90ukf; ?>"><?php echo $d['kf90u']; ?></td>
					        <td class="<?php echo $w_180ukf; ?>"><?php echo $d['kf180u']; ?></td>
					        <td class="<?php echo $w_h2okf; ?>"><?php echo $d['H2O']; ?></td>
					        <td><?php echo $d['waktu']; ?> <br><?php echo($d['iduser']); ?></br></td>

					    </tr>
					<?php
					}
					?>
				</tbody>	
    </table>
</div>
    <div class="col-md-1">
                <table class="table table-striped table-bordered table-hover">
				<thead>

					<tr class="text-center" >
			           <th colspan="4">EP</th>
			        </tr>

					<tr class="bg-primary text-white text-center">
						
						 <th>LSF</th> <th>SIM</th> <th>ALM</th><th>Report</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if(isset($_GET['data2jam']) && $_GET['data2jam'] == '1'){
				    $sql = "SELECT * FROM ep_3 WHERE TANGGAL = CURDATE() AND waktu >= NOW() - INTERVAL 3 HOUR";
				} elseif(isset($_GET['tgl'])){
				    $tgl = $_GET['tgl'];
				    $tgl = mysqli_real_escape_string($conn, $tgl);
				    $sql = "SELECT * FROM ep_3 WHERE TANGGAL = '$tgl'";
				} elseif (isset($_GET['opentoday'])) {
				    $sql = "SELECT * FROM ep_3 WHERE TANGGAL = CURDATE()";
				} else {
				    $sql = "SELECT * FROM ep_3 WHERE TANGGAL = CURDATE()";
				}

				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							
				?>

					    <tr class="text-center font-weight-bold">
					        <td><?php echo $d['LSF_b']; ?></td>
					        <td><?php echo $d['SIM_b']; ?></td>
					        <td><?php echo $d['ALM_b']; ?></td>
					        <td><?php echo $d['waktu']; ?> <br><?php echo($d['iduser']); ?></br></td>
					    </tr>
					<?php
					}
					?>
					
  			  </tbody>
                </table>
            </div>
        </div>

        <h6 class="text-center">KILN FEED 2</h6>
        <div class="row">
            <div class="col-md-7">
                <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr class="text-center" >
                       <th colspan="11">Kiln Feed</th>
                    </tr>

                    <tr class="bg-primary text-white text-center">
                        <th>JAM</th> <th>LSF</th> <th>SIM</th> <th>ALM</th> <th>BF</th><th>SO3</th><th>Alkali</th><th>90u</th> <th>180u</th> <th>H2O</th><th>Report</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if(isset($_GET['data2jam']) && $_GET['data2jam'] == '1'){
                    $sql = "SELECT * FROM kf2_3 WHERE TANGGAL = CURDATE() AND waktu >= NOW() - INTERVAL 3 HOUR";
                } elseif(isset($_GET['tgl'])){
                    $tgl = $_GET['tgl'];
                    $tgl = mysqli_real_escape_string($conn, $tgl);
                    $sql = "SELECT * FROM kf2_3 WHERE TANGGAL = '$tgl'";
                } elseif (isset($_GET['opentoday'])) {
                    $sql = "SELECT * FROM kf2_3 WHERE TANGGAL = CURDATE()";
                } else {
                    $sql = "SELECT * FROM kf2_3 WHERE TANGGAL = CURDATE()";
                }

                $q = mysqli_query($conn, $sql);
                while ($d = mysqli_fetch_array($q)) {
                           $w_180ukf = '';
                            if (!empty($d['kf180u']) && $d['kf180u'] > $configs['kf180u4']['max']) {
                                $w_180ukf = 'text-danger font-weight-bold';
                            }

                            $w_90ukf = '';
                            if (!empty($d['kf90u']) && $d['kf90u'] > $configs['kf90u4']['max']) {
                                $w_90ukf = 'text-danger font-weight-bold';
                            }

                            $w_h2okf = '';
                            if (!empty($d['H2O']) && ($d['H2O'] < $configs['H2Okf4']['min'] || $d['H2O'] > $configs['H2Okf4']['max'])) {
                                $w_h2okf = 'text-danger font-weight-bold';
                            }

                            $w_almkf = '';
                            if (!empty($d['ALM']) && ($d['ALM'] < $configs['ALMkf4']['min'] || $d['ALM'] > $configs['ALMkf4']['max'])) {
                                $w_almkf = 'text-danger font-weight-bold';
                            }

                            $w_simkf = '';
                            if (!empty($d['SIM']) && ($d['SIM'] < $configs['SIMkf4']['min'] || $d['SIM'] > $configs['SIMkf4']['max'])) {
                                $w_simkf = 'text-danger font-weight-bold';
                            }

                            $w_lsfkf = '';
                            if (!empty($d['LSF']) && ($d['LSF'] < $configs['LSFkf4']['min'] || $d['LSF'] > $configs['LSFkf4']['max'])) {
                                $w_lsfkf = 'text-danger font-weight-bold';
                            }

                            $w_alkali = '';
                            if (!empty($d['ALKALI']) && $d['ALKALI'] > 0.35) {
                                $w_alkali = 'text-danger font-weight-bold';
                            }

                ?>

                        <tr class="text-center font-weight-bold">
                            <td><?php echo $d['JAM']; ?></td>
                            <td class="<?php echo $w_lsfkf; ?>"><?php echo $d['LSF']; ?> <br> </br></td>
                            <td class="<?php echo $w_simkf; ?>"><?php echo $d['SIM']; ?></td>
                            <td class="<?php echo $w_almkf; ?>"><?php echo $d['ALM']; ?></td>
                            <td class="<?php echo $w_almkf; ?>"><?php echo $d['BF']; ?></td>
                            <td><?php echo $d['SO3']; ?></td>
                            <td class="<?php echo $w_alkali; ?>"><?php echo $d['ALKALI']; ?></td>
                            <td class="<?php echo $w_90ukf; ?>"><?php echo $d['kf90u']; ?></td>
                            <td class="<?php echo $w_180ukf; ?>"><?php echo $d['kf180u']; ?></td>
                            <td class="<?php echo $w_h2okf; ?>"><?php echo $d['H2O']; ?></td>
                            <td><?php echo $d['waktu']; ?> <br><?php echo($d['iduser']); ?></br></td>

                        </tr>
                    <?php
                    }
                    ?>
                </tbody>    
    </table>
</div>
    <div class="col-md-1">
                <table class="table table-striped table-bordered table-hover">
                <thead>

                    <tr class="text-center" >
                       <th colspan="4">EP</th>
                    </tr>

                    <tr class="bg-primary text-white text-center">
                        
                         <th>LSF</th> <th>SIM</th> <th>ALM</th><th>Report</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if(isset($_GET['data2jam']) && $_GET['data2jam'] == '1'){
                    $sql = "SELECT * FROM ep_3 WHERE TANGGAL = CURDATE() AND waktu >= NOW() - INTERVAL 3 HOUR";
                } elseif(isset($_GET['tgl'])){
                    $tgl = $_GET['tgl'];
                    $tgl = mysqli_real_escape_string($conn, $tgl);
                    $sql = "SELECT * FROM ep_3 WHERE TANGGAL = '$tgl'";
                } elseif (isset($_GET['opentoday'])) {
                    $sql = "SELECT * FROM ep_3 WHERE TANGGAL = CURDATE()";
                } else {
                    $sql = "SELECT * FROM ep_3 WHERE TANGGAL = CURDATE()";
                }

                $q = mysqli_query($conn, $sql);
                while ($d = mysqli_fetch_array($q)) {
                            
                ?>

                        <tr class="text-center font-weight-bold">
                            <td><?php echo $d['LSF_c']; ?></td>
                            <td><?php echo $d['SIM_c']; ?></td>
                            <td><?php echo $d['ALM_c']; ?></td>
                            <td><?php echo $d['waktu']; ?> <br><?php echo($d['iduser']); ?></br></td>
                        </tr>
                    <?php
                    }
                    ?>
                    
              </tbody>
                </table>
            </div>
        </div>
    



	<h6 class="text-center">CLINKER </h6>
       
                <table class="table table-striped table-bordered table-hover">
				<thead>

					<tr class="text-center" >
			          <th colspan="13">Klinker W1</th>
			        </tr>

					<tr class="bg-primary text-white text-center">
						
						<th>JAM</th> <th>LWg/l</th> <th>TEMP </th><th>F.Lime </th> <th>LSF</th> <th>SIM</th> <th>ALM</th> <th>C3S</th> <th>C3A</th><th>SO3</th><th>Alkali</th><th>Warna</th><th>Fisik</th> 
					</tr>
				</thead>
				<?php
				if(isset($_GET['data2jam']) && $_GET['data2jam'] == '1'){
				    $sql = "SELECT * FROM cr1_3 WHERE TANGGAL = CURDATE() AND waktu >= NOW() - INTERVAL 3 HOUR";
				} elseif(isset($_GET['tgl'])){
				    $tgl = $_GET['tgl'];
				    $tgl = mysqli_real_escape_string($conn, $tgl);
				    $sql = "SELECT * FROM cr1_3 WHERE TANGGAL = '$tgl'";
				} elseif (isset($_GET['opentoday'])) {
				    $sql = "SELECT * FROM cr1_3 WHERE TANGGAL = CURDATE()";
				} else {
				    $sql = "SELECT * FROM cr1_3 WHERE TANGGAL = CURDATE()";
				}   
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							$w_flime = '';
                            if (!empty($d['FCaO']) && $d['FCaO'] > $configs['FCaOcr4']['max']) {
                                $w_flime = 'text-danger font-weight-bold';
                            }

                            $w_c3scr = '';
                            if (!empty($d['C3S']) && ($d['C3S'] < $configs['C3Scr4']['min'] || $d['C3S'] > $configs['C3Scr4']['max'])) {
                                $w_c3scr = 'text-danger font-weight-bold';
                            }

                            $w_almcr = '';
                            if (!empty($d['ALM']) && ($d['ALM'] < $configs['ALMcr4']['min'] || $d['ALM'] > $configs['ALMcr4']['max'])) {
                                $w_almcr = 'text-danger font-weight-bold';
                            }

                            $w_simcr = '';
                            if (!empty($d['SIM']) && ($d['SIM'] < $configs['SIMcr4']['min'] || $d['SIM'] > $configs['SIMcr4']['max'])) {
                                $w_simcr = 'text-danger font-weight-bold';
                            }

                            $w_lsfcr = '';
                            if (!empty($d['LSF']) && ($d['LSF'] < $configs['LSFcr4']['min'] || $d['LSF'] > $configs['LSFcr4']['max'])) {
                                $w_lsfcr = 'text-danger font-weight-bold';
                            }

                            $w_ltwcr = '';
                            if (!empty($d['LTW']) && ($d['LTW'] < $configs['LTWcr4']['min'] || $d['LTW'] > $configs['LTWcr4']['max'])) {
                                $w_ltwcr = 'text-danger font-weight-bold';
                            }

                            $w_alkali = '';
                            if (!empty($d['ALKALI']) && $d['ALKALI'] > $configs['ALKALIcr4']['max']) {
                                $w_alkali = 'text-danger font-weight-bold';
                            }

				?>

					    <tr class="text-center font-weight-bold">
					        <td><?php echo $d['JAM']; ?></td>
					        <td class="<?php echo $w_ltwcr; ?>"><?php echo $d['LTW']; ?></td>
					        <td><?php echo $d['TEMP']; ?></td>
					        <td class="<?php echo $w_flime; ?>"><?php echo $d['FCaO']; ?></td>
					        <td class="<?php echo $w_lsfcr; ?>"><?php echo $d['LSF']; ?></td>
					        <td class="<?php echo $w_simcr; ?>"><?php echo $d['SIM']; ?></td>
					        <td class="<?php echo $w_almcr; ?>"><?php echo $d['ALM']; ?></td>
					        <td class="<?php echo $w_c3scr; ?>"><?php echo $d['C3S']; ?></td>
					        <td><?php echo $d['C3A']; ?></td>
					        <td><?php echo $d['SO3']; ?></td>
					        <td class="<?php echo $w_alkali; ?>"><?php echo $d['ALKALI']; ?></td>
					        <td><?php echo $d['WARNA']; ?></td>
					        <td><?php echo $d['FISIK']; ?></td>

					    </tr>
					<?php
					}
					?>	
    </table>
</div>
				
                <table class="table table-striped table-bordered table-hover" >
				<thead>
					<tr class="text-center" >
			         </th><th colspan="1"> RAWCOAL</th> <th colspan="3">FINECOAL 2K1</th> <th colspan="3">FINECOAL 3K2</th><th colspan="1"></th>
			        </tr>

					<tr class="bg-primary text-white text-center">
						
						<th>H2O</th> <th>90u</th><th>H2O </th> <th>ASH</th><th>90u</th><th>H2O </th> <th>ASH</th> <th>Report</th>
					</tr>
				</thead>
				<?php
				if(isset($_GET['data2jam']) && $_GET['data2jam'] == '1'){
				    $sql = "SELECT * FROM fc_3 WHERE TANGGAL = CURDATE() AND waktu >= NOW() - INTERVAL 3 HOUR";
				} elseif(isset($_GET['tgl'])){
				    $tgl = $_GET['tgl'];
				    $tgl = mysqli_real_escape_string($conn, $tgl);
				    $sql = "SELECT * FROM fc_3 WHERE TANGGAL = '$tgl'";
				} elseif (isset($_GET['opentoday'])) {
				    $sql = "SELECT * FROM fc_3 WHERE TANGGAL = CURDATE()";
				} else {
				    $sql = "SELECT * FROM fc_3 WHERE TANGGAL = CURDATE()";
				}   
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
					        $w_ashfc = '';
                            if (!empty($d['ASHk2']) && $d['ASHk2'] > $configs['ACfc4']['max']) {
                                $w_ashfc = 'text-danger font-weight-bold';
                            }

                             $w_ashfc1 = '';
                            if (!empty($d['ASHk3']) && $d['ASHk3'] > $configs['ACfc4']['max']) {
                                $w_ashfc1 = 'text-danger font-weight-bold';
                            }

                            $w_h2ofc = '';
                            if (!empty($d['H2O_fck2']) && $d['H2O_fck2'] > $configs['H2Ofc4']['max']) {
                                $w_h2ofc = 'text-danger font-weight-bold';
                            }
                            $w_h2ofc1 = '';
                            if (!empty($d['H2O_fck3']) && $d['H2O_fck3'] > $configs['H2Ofc4']['max']) {
                                $w_h2ofc1 = 'text-danger font-weight-bold';
                            }

                            $w_90ufc = '';
                            if (!empty($d['fc90uk2']) && $d['fc90uk2'] > $configs['fc90u4']['max']) {
                                $w_90ufc = 'text-danger font-weight-bold';
                            }

                            $w_90ufc1 = '';
                            if (!empty($d['fc90uk3']) && $d['fc90uk3'] > $configs['fc90u4']['max']) {
                                $w_90ufc1 = 'text-danger font-weight-bold';
                            }

                            $w_h2orc = '';
                            if (!empty($d['H2O_rc']) && $d['H2O_rc'] > 40) {
                                $w_h2orc = 'text-danger font-weight-bold';
                            }

                ?>

                        <tr class="text-center font-weight-bold">
                            <td class="<?php echo $w_h2orc; ?>"><?php echo $d['H2O_rc']; ?></td>
                            <td class="<?php echo $w_90ufc; ?>"><?php echo $d['fc90uk2']; ?></td>
                            <td class="<?php echo $w_h2ofc; ?>"><?php echo $d['H2O_fck2']; ?></td>
                            <td class="<?php echo $w_ashfc; ?>"><?php echo $d['ASHk2']; ?></td>
                            <td class="<?php echo $w_90ufc1; ?>"><?php echo $d['fc90uk3']; ?></td>
                            <td class="<?php echo $w_h2ofc1; ?>"><?php echo $d['H2O_fck3']; ?></td>
                            <td class="<?php echo $w_ashfc1; ?>"><?php echo $d['ASHk3']; ?></td>
                            <td><?php echo $d['waktu']; ?> <br><?php echo($d['iduser']); ?></br></td>
                        </tr>
					<?php
					}
					?>
     	</table>
        </div>

<h6 class="text-center">CEMENT</h6>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-striped table-bordered table-hover">
				<thead>

					<tr class="text-center" >
			         <th colspan="10">2Z1</th> 
			        </tr>

					<tr class="bg-primary text-white text-center">
						
						<th>JAM</th> <th>Blaine</th> <th>SO3 </th><th>45u </th><th>Alkali</th> <th>LOI</th> <th>F.Cao</th><th>BTL</th><th>Type Semen</th> <th>Report</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if(isset($_GET['data2jam']) && $_GET['data2jam'] == '1'){
				    $sql = "SELECT * FROM z1_3 WHERE TANGGAL = CURDATE() AND waktu >= NOW() - INTERVAL 3 HOUR";
				} elseif(isset($_GET['tgl'])){
				    $tgl = $_GET['tgl'];
				    $tgl = mysqli_real_escape_string($conn, $tgl);
				    $sql = "SELECT * FROM z1_3 WHERE TANGGAL = '$tgl'";
				} elseif (isset($_GET['opentoday'])) {
				    $sql = "SELECT * FROM z1_3 WHERE TANGGAL = CURDATE()";
				} else {
				    $sql = "SELECT * FROM z1_3 WHERE TANGGAL = CURDATE()";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							$w_fcaopcc = '';
                            if ($d['FCaO_pcc'] > $configs['FCaOpcc']['max'] ) {
                                $w_fcaopcc = 'bg-danger text-white';
                            }
                            $w_fcaopcp = '';
                            if ($d['FCaO_pcp'] > $configs['FCaOppc']['max'] ) {
                                $w_fcaopcp = 'bg-danger text-white';
                            }
                            $w_fcaoopc = '';
                            if ($d['FCaO_opc'] > $configs['FCaOopc']['max'] ) {
                                $w_fcaoopc = 'bg-danger text-white';
                            }
                            $w_alkali = '';
                            if ($d['ALKALI_opc'] > $configs['ALKALIopc']['max'] ) {
                                $w_alkali = 'bg-danger text-white';
                            }
                            $w_loipcp = '';
                            if ($d['LOI_pcp'] > $configs['LOIppc']['max'] ) {
                                $w_loipcp = 'bg-danger text-white';
                            }$w_loiopc = '';
                            if ($d['LOI_opc'] > $configs['LOIopc']['max'] ) {
                                $w_loiopc = 'bg-danger text-white';
                            }$w_45upcp = '';
                            if ($d['z145u_pcp'] > $configs['z145uppc']['max'] ) {
                                $w_45upcp = 'bg-danger text-white';
                            }
                            $w_45upcc = '';
                            if ($d['z145u_pcc'] > $configs['z145upcc']['max'] ) {
                                $w_45upcc = 'bg-danger text-white';
                            }$w_45uopc = '';
                            if ($d['z145u_opc'] > $configs['z145uopc']['max'] ) {
                                $w_45uopc = 'bg-danger text-white';
                            }
                            $w_so3pcp = '';
                            if ($d['SO3_pcp'] < $configs['SO3ppc']['min'] || $d['SO3_pcp'] > $configs['SO3ppc']['max']) {
                                $w_so3pcp = 'bg-danger text-white';
                            }
                            $w_so3pcc = '';
                            if ($d['SO3_pcc'] < $configs['SO3pcc']['min'] || $d['SO3_pcc'] > $configs['SO3pcc']['max']) {
                                $w_so3pcc = 'bg-danger text-white';
                            }
                            $w_so3opc = '';
                            if ($d['SO3_opc'] < $configs['SO3opc']['min'] || $d['SO3_opc'] > $configs['SO3opc']['max']) {
                                $w_so3opc = 'bg-danger text-white';
                            }
                            $w_blainepcp = '';
                            if ($d['BLAINE_pcp'] < $configs['BLAINEppc']['min']  ) {
                                $w_blainepcp = 'bg-danger text-white';
                            }
                            $w_blainepcc = '';
                            if ($d['BLAINE_pcc'] < $configs['BLAINEpcc']['min'] || $d['BLAINE_pcc'] > $configs['BLAINEpcc']['max']) {
                                $w_blainepcc = 'bg-danger text-white';
                            }
                             $w_blaineopc = '';
                            if ($d['BLAINE_opc'] < $configs['BLAINEopc']['min'] ) {
                                $w_blaineopc = 'bg-danger text-white';
                            }
                            $w_btlpcp  = '';
                            if ($d['BTL_pcp'] > $configs['BTLppc']['max']) {
                                $w_btlpcp = 'bg-danger text-white';
                            }
                            $w_btlpcc  = '';
                            if ($d['BTL_pcc'] > $configs['BTLpcc']['max']) {
                                $w_btlpcc = 'bg-danger text-white';
                            }
                            $w_btlopc  = '';
                            if ($d['BTL_opc'] > $configs['BTLopc']['max']) {
                                $w_btlopc = 'bg-danger text-white';
                            }
				?>

					    <tr class="text-center font-weight-bold">
					        <td><?php echo htmlspecialchars($d['JAM']); ?></td>
							<td class="<?php 
							    if (!empty($d['BLAINE_opc'])) {
							        echo htmlspecialchars($w_blaineopc);
							    } elseif (!empty($d['BLAINE_pcc'])) {
							        echo htmlspecialchars($w_blainepcc);
							    } elseif (!empty($d['BLAINE_pcp'])) {
							        echo htmlspecialchars($w_blainepcp);
							    }
							?>">
							    <?php 
							        $blaine_value = $d['BLAINE_opc'] ?? $d['BLAINE_pcc'] ?? $d['BLAINE_pcp'] ?? ''; 
							        echo htmlspecialchars($blaine_value); 
							    ?>
							</td>
							<td class="<?php 
							    if (!empty($d['SO3_opc'])) {
							        echo htmlspecialchars($w_so3opc);
							    } elseif (!empty($d['SO3_pcc'])) {
							        echo htmlspecialchars($w_so3pcc);
							    } elseif (!empty($d['SO3_pcp'])) {
							        echo htmlspecialchars($w_so3pcp);
							    }
							?>">
							    <?php 
							        $so3_value = $d['SO3_opc'] ?? $d['SO3_pcc'] ?? $d['SO3_pcp'] ?? ''; 
							        echo htmlspecialchars($so3_value); 
							    ?>
							</td>
							<td class="<?php 
							    if (!empty($d['z145u_opc'])) {
							        echo htmlspecialchars($w_45uopc);
							    } elseif (!empty($d['z145u_pcc'])) {
							        echo htmlspecialchars($w_45upcc);
							    } elseif (!empty($d['z145u_pcp'])) {
							        echo htmlspecialchars($w_45upcp);
							    }
							?>">
							    <?php 
							        $z45u_value = $d['z145u_opc'] ?? $d['z145u_pcc'] ?? $d['z145u_pcp'] ?? ''; 
							        echo htmlspecialchars($z45u_value); 
							    ?>
							</td>

							<td><?php echo "" ?></td>

							<td class="<?php 
							    if (!empty($d['LOI_opc'])) {
							        echo htmlspecialchars($w_loiopc);
							    } elseif (!empty($d['LOI_pcc'])) {
							        echo htmlspecialchars($w_loipcc);
							    } elseif (!empty($d['LOI_pcp'])) {
							        echo htmlspecialchars($w_loipcp);
							    }
							?>">
							    <?php 
							        $zloi_value = $d['LOI_opc'] ?? $d['LOI_pcc'] ?? $d['LOI_pcp'] ?? ''; 
							        echo htmlspecialchars($zloi_value); 
							    ?>
							</td>

							<td class="<?php 
							    if (!empty($d['FCaO_opc'])) {
							        echo htmlspecialchars($w_fcaoopc);
							    } elseif (!empty($d['FCaO_pcc'])) {
							        echo htmlspecialchars($w_fcaopcc);
							    } elseif (!empty($d['FCaO_pcp'])) {
							        echo htmlspecialchars($w_fcaopcp);
							    }
							?>">
							    <?php 
							        $zfcao_value = $d['FCaO_opc'] ?? $d['FCaO_pcc'] ?? $d['FCaO_pcp'] ?? ''; 
							        echo htmlspecialchars($zfcao_value); 
							    ?>
							</td>

							<td class="<?php 
							    if (!empty($d['BTL_opc'])) {
							        echo htmlspecialchars($w_btlopc);
							    } elseif (!empty($d['BTL_pcc'])) {
							        echo htmlspecialchars($w_btlpcc);
							    } elseif (!empty($d['BTL_pcp'])) {
							        echo htmlspecialchars($w_btlpcp);
							    }
							?>">
							    <?php 
							        $zbtl_value = $d['BTL_opc'] ?? $d['BTL_pcc'] ?? $d['BTL_pcp'] ?? ''; 
							        echo htmlspecialchars($zbtl_value); 
							    ?>
							</td>

							<td>
							    <?php 
							        if (!empty($d['BLAINE_opc'])) {
							            echo 'OPC';
							        } elseif (!empty($d['BLAINE_pcc'])) {
							            echo 'PCC';
							        } elseif (!empty($d['BLAINE_pcp'])) {
							            echo 'PCP';
							        } else {
							            echo '';
							        }
							    ?>
							</td>
							<td><?php echo $d['waktu']; ?> <br><?php echo($d['iduser']); ?></br></td>
					       
					    </tr>
					<?php
					}
					?>
					</tbody>
    </table>
</div>
			 <div class="col-md-6">
                <table class="table table-striped table-bordered table-hover">
				<thead>

					<tr class="text-center" >
			         <th colspan="10">3Z2</th> 
			        </tr>

					<tr class="bg-primary text-white text-center">
						
						<th>JAM</th> <th>Blaine</th> <th>SO3 </th><th>45u </th><th>Alkali</th> <th>LOI</th> <th>F.Cao</th><th>BTL</th><th>Type Semen</th> <th>Report</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if(isset($_GET['data2jam']) && $_GET['data2jam'] == '1'){
				    $sql = "SELECT * FROM z2_3 WHERE TANGGAL = CURDATE() AND waktu >= NOW() - INTERVAL 3 HOUR";
				} elseif(isset($_GET['tgl'])){
				    $tgl = $_GET['tgl'];
				    $tgl = mysqli_real_escape_string($conn, $tgl);
				    $sql = "SELECT * FROM z2_3 WHERE TANGGAL = '$tgl'";
				} elseif (isset($_GET['opentoday'])) {
				    $sql = "SELECT * FROM z2_3 WHERE TANGGAL = CURDATE()";
				} else {
				    $sql = "SELECT * FROM z2_3 WHERE TANGGAL = CURDATE()";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							$w_fcaopcc = '';
                            if ($d['FCaO_pcc'] > $configs['FCaOpcc']['max'] ) {
                                $w_fcaopcc = 'bg-danger text-white';
                            }
                            $w_fcaopcp = '';
                            if ($d['FCaO_pcp'] > $configs['FCaOppc']['max'] ) {
                                $w_fcaopcp = 'bg-danger text-white';
                            }
                            $w_fcaoopc = '';
                            if ($d['FCaO_opc'] > $configs['FCaOopc']['max'] ) {
                                $w_fcaoopc = 'bg-danger text-white';
                            }
                            $w_alkali = '';
                            if ($d['ALKALI_opc'] > $configs['ALKALIopc']['max'] ) {
                                $w_alkali = 'bg-danger text-white';
                            }
                            $w_loipcp = '';
                            if ($d['LOI_pcp'] > $configs['LOIppc']['max'] ) {
                                $w_loipcp = 'bg-danger text-white';
                            }$w_loiopc = '';
                            if ($d['LOI_opc'] > $configs['LOIopc']['max'] ) {
                                $w_loiopc = 'bg-danger text-white';
                            }$w_45upcp = '';
                            if ($d['z145u_pcp'] > $configs['z145uppc']['max'] ) {
                                $w_45upcp = 'bg-danger text-white';
                            }
                            $w_45upcc = '';
                            if ($d['z145u_pcc'] > $configs['z145upcc']['max'] ) {
                                $w_45upcc = 'bg-danger text-white';
                            }$w_45uopc = '';
                            if ($d['z145u_opc'] > $configs['z145uopc']['max'] ) {
                                $w_45uopc = 'bg-danger text-white';
                            }
                            $w_so3pcp = '';
                            if ($d['SO3_pcp'] < $configs['SO3ppc']['min'] || $d['SO3_pcp'] > $configs['SO3ppc']['max']) {
                                $w_so3pcp = 'bg-danger text-white';
                            }
                            $w_so3pcc = '';
                            if ($d['SO3_pcc'] < $configs['SO3pcc']['min'] || $d['SO3_pcc'] > $configs['SO3pcc']['max']) {
                                $w_so3pcc = 'bg-danger text-white';
                            }
                            $w_so3opc = '';
                            if ($d['SO3_opc'] < $configs['SO3opc']['min'] || $d['SO3_opc'] > $configs['SO3opc']['max']) {
                                $w_so3opc = 'bg-danger text-white';
                            }
                            $w_blainepcp = '';
                            if ($d['BLAINE_pcp'] < $configs['BLAINEppc']['min']  ) {
                                $w_blainepcp = 'bg-danger text-white';
                            }
                            $w_blainepcc = '';
                            if ($d['BLAINE_pcc'] < $configs['BLAINEpcc']['min'] || $d['BLAINE_pcc'] > $configs['BLAINEpcc']['max']) {
                                $w_blainepcc = 'bg-danger text-white';
                            }
                             $w_blaineopc = '';
                            if ($d['BLAINE_opc'] < $configs['BLAINEopc']['min'] ) {
                                $w_blaineopc = 'bg-danger text-white';
                            }
                            $w_btlpcp  = '';
                            if ($d['BTL_pcp'] > $configs['BTLppc']['max']) {
                                $w_btlpcp = 'bg-danger text-white';
                            }
                            $w_btlpcc  = '';
                            if ($d['BTL_pcc'] > $configs['BTLpcc']['max']) {
                                $w_btlpcc = 'bg-danger text-white';
                            }
                            $w_btlopc  = '';
                            if ($d['BTL_opc'] > $configs['BTLopc']['max']) {
                                $w_btlopc = 'bg-danger text-white';
                            }
				?>

					    <tr class="text-center font-weight-bold">
					        <td><?php echo htmlspecialchars($d['JAM']); ?></td>
							<td class="<?php 
							    if (!empty($d['BLAINE_opc'])) {
							        echo htmlspecialchars($w_blaineopc);
							    } elseif (!empty($d['BLAINE_pcc'])) {
							        echo htmlspecialchars($w_blainepcc);
							    } elseif (!empty($d['BLAINE_pcp'])) {
							        echo htmlspecialchars($w_blainepcp);
							    }
							?>">
							    <?php 
							        $blaine_value = $d['BLAINE_opc'] ?? $d['BLAINE_pcc'] ?? $d['BLAINE_pcp'] ?? ''; 
							        echo htmlspecialchars($blaine_value); 
							    ?>
							</td>
							<td class="<?php 
							    if (!empty($d['SO3_opc'])) {
							        echo htmlspecialchars($w_so3opc);
							    } elseif (!empty($d['SO3_pcc'])) {
							        echo htmlspecialchars($w_so3pcc);
							    } elseif (!empty($d['SO3_pcp'])) {
							        echo htmlspecialchars($w_so3pcp);
							    }
							?>">
							    <?php 
							        $so3_value = $d['SO3_opc'] ?? $d['SO3_pcc'] ?? $d['SO3_pcp'] ?? ''; 
							        echo htmlspecialchars($so3_value); 
							    ?>
							</td>
							<td class="<?php 
							    if (!empty($d['z145u_opc'])) {
							        echo htmlspecialchars($w_45uopc);
							    } elseif (!empty($d['z145u_pcc'])) {
							        echo htmlspecialchars($w_45upcc);
							    } elseif (!empty($d['z145u_pcp'])) {
							        echo htmlspecialchars($w_45upcp);
							    }
							?>">
							    <?php 
							        $z45u_value = $d['z145u_opc'] ?? $d['z145u_pcc'] ?? $d['z145u_pcp'] ?? ''; 
							        echo htmlspecialchars($z45u_value); 
							    ?>
							</td>

							<td><?php echo "" ?></td>

							<td class="<?php 
							    if (!empty($d['LOI_opc'])) {
							        echo htmlspecialchars($w_loiopc);
							    } elseif (!empty($d['LOI_pcc'])) {
							        echo htmlspecialchars($w_loipcc);
							    } elseif (!empty($d['LOI_pcp'])) {
							        echo htmlspecialchars($w_loipcp);
							    }
							?>">
							    <?php 
							        $zloi_value = $d['LOI_opc'] ?? $d['LOI_pcc'] ?? $d['LOI_pcp'] ?? ''; 
							        echo htmlspecialchars($zloi_value); 
							    ?>
							</td>

							<td class="<?php 
							    if (!empty($d['FCaO_opc'])) {
							        echo htmlspecialchars($w_fcaoopc);
							    } elseif (!empty($d['FCaO_pcc'])) {
							        echo htmlspecialchars($w_fcaopcc);
							    } elseif (!empty($d['FCaO_pcp'])) {
							        echo htmlspecialchars($w_fcaopcp);
							    }
							?>">
							    <?php 
							        $zfcao_value = $d['FCaO_opc'] ?? $d['FCaO_pcc'] ?? $d['FCaO_pcp'] ?? ''; 
							        echo htmlspecialchars($zfcao_value); 
							    ?>
							</td>

							<td class="<?php 
							    if (!empty($d['BTL_opc'])) {
							        echo htmlspecialchars($w_btlopc);
							    } elseif (!empty($d['BTL_pcc'])) {
							        echo htmlspecialchars($w_btlpcc);
							    } elseif (!empty($d['BTL_pcp'])) {
							        echo htmlspecialchars($w_btlpcp);
							    }
							?>">
							    <?php 
							        $zbtl_value = $d['BTL_opc'] ?? $d['BTL_pcc'] ?? $d['BTL_pcp'] ?? ''; 
							        echo htmlspecialchars($zbtl_value); 
							    ?>
							</td>

							<td>
							    <?php 
							        if (!empty($d['BLAINE_opc'])) {
							            echo 'OPC';
							        } elseif (!empty($d['BLAINE_pcc'])) {
							            echo 'PCC';
							        } elseif (!empty($d['BLAINE_pcp'])) {
							            echo 'PCP';
							        } else {
							            echo '';
							        }
							    ?>
							</td>
							<td><?php echo $d['waktu']; ?> <br><?php echo($d['iduser']); ?></br></td>
					       
					    </tr>
					<?php
					}
					?>
					
     </tbody>
                </table>
            </div>
        </div>



  <script>
        function openData2JamTab() {
            const url = new URL(window.location.href);
            url.searchParams.set('data2jam', '1');
            window.open(url.toString(), '_blank');
        }
    </script>
		

					        
  
</body>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>