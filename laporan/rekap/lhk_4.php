<?php
session_start();
$level = strtoupper($_SESSION['level']);
if ($level == NULL) echo "<script>window.location = '../index.php'</script>";
include "../../include/database_ind4.php";
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
	<h2 class="text-center">LAPORAN HARIAN KUALITAS</h2>
	<h2 class="text-center mb-5" >PABRIK INDARUNG IV</h2>
	<form method="get" class="mb-3">
			<label>PILIH TANGGAL : </label>
			<input type="date" name="tgl">
			<input class="btn btn-primary" type="submit" value="FILTER">

		</form>
		<h3 class="text-center">
			<?php
			    if(isset($_GET['tgl'])){
			        $tgl = $_GET['tgl'];
			        echo "<label>Rekap Tanggal : $tgl</label>";
			    }
			    ?>
		</h3>

	<div >
	<h5 class="text-center">RAW MATERIAL TO STORAGE</h5>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			           <th colspan="1"></th><th colspan="6">Chemical Composition</th><th colspan="3"></th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>JAM</th> <th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th><th>H2O</th><th>LSF</th> 
					</tr>
				</thead>

				<?php
				if(isset($_GET['tgl'])){
				    $tgl = $_GET['tgl'];
				    $sql = "SELECT * FROM lhk_2024 WHERE TANGGAL = '$tgl'";
				} else {  
				    $sql = "SELECT * FROM lhk_2024 WHERE TANGGAL = CURDATE()";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							$w_h2olstg = '';
					        if ($d['H2O_lstg'] > 6 ) {
					            $w_h2olstg = 'text-danger';
					        }
					        $w_caolstg = '';
					        if ($d['CaO_lstg'] < 48 ) {
					            $w_caolstg = 'text-danger';
					        }
					        $w_al2o3lstg = '';
					        if ($d['Al2O3_lstg'] > 1.6 ) {
					            $w_al2o3lstg = 'text-danger';
					        }
					        $w_sio2lstg  = '';
							if ($d['SiO2_lstg'] > 10 ) {
							    $w_sio2lstg = 'text-danger';
							}
						?>
 
					    <tr>
					        <td><?php echo $d['JAM']; ?></td>
					        <td class="<?php echo $w_sio2lstg; ?>"><?php echo $d['SiO2_lstg']; ?></td>
					        <td class="<?php echo $w_al2o3lstg; ?>"><?php echo $d['Al2O3_lstg']; ?></td>
					        <td><?php echo $d['Fe2O3_lstg']; ?></td>
					        <td class="<?php echo $w_caolstg; ?>"><?php echo $d['CaO_lstg']; ?></td>
					        <td><?php echo $d['MgO_lstg']; ?></td>
					        <td><?php echo $d['SO3_lstg']; ?></td>
					        <td class="<?php echo $w_h2olstg; ?>"><?php echo $d['H2O_lstg']; ?></td>
					        <td><?php echo $d['LSF_lstg']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>
</div>
	<div >
	<h5 class="text-center">RAWMIX 4R1</h5>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			          <th colspan="1"></th> <th colspan="2">Modulus Factor</th><th colspan="2">Sieve On</th><th colspan="1"></th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>JAM</th> <th>LSF</th> <th>SIM</th> <th>ALM</th> <th>90u</th> <th>180u</th> <th>H2O</th>
					</tr>
				</thead>

				<?php
				if(isset($_GET['tgl'])){
				    $tgl = $_GET['tgl'];
				    $sql = "SELECT * FROM lhk_2024 WHERE TANGGAL = '$tgl'";
				} else {  
				    $sql = "SELECT * FROM lhk_2024 WHERE TANGGAL = CURDATE() ";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							$w_180ur1 = '';
					        if ($d['r1180u'] > 3 ) {
					            $w_180ur1 = 'text-danger';
					        }
					        $w_90ur1 = '';
					        if ($d['r190u'] > 20 ) {
					            $w_90ur1 = 'text-danger';
					        }
					        $w_h2or1 = '';
							if ($d['H2O_r1'] < 0.3 || $d['H2O_r1'] > 0.7) {
							    $w_h2or1 = 'text-danger';
							}
							$w_almr1 = '';
							if ($d['ALM_r1'] < 1.4 || $d['ALM_r1'] > 1.8) {
							    $w_almr1 = 'text-danger';
							}
					        $w_lsfr1 = '';
							if ($d['LSF_r1'] < 88 || $d['LSF_r1'] > 104) {
							    $w_lsfr1 = 'text-danger';
							}
							$w_simr1 = '';
							if ($d['SIM_r1'] < 2.1 || $d['SIM_r1'] > 2.5) {
							    $w_simr1 = 'text-danger';
							}
				?>

					    <tr>
					        <td><?php echo $d['JAM']; ?></td>
					        <td class="<?php echo $w_lsfr1; ?>"><?php echo $d['LSF_r1']; ?></td>
					        <td class="<?php echo $w_simr1; ?>"><?php echo $d['SIM_r1']; ?></td>
					        <td class="<?php echo $w_almr1; ?>"><?php echo $d['ALM_r1']; ?></td>
					        <td class="<?php echo $w_90ur1; ?>"><?php echo $d['r190u']; ?></td>
					        <td class="<?php echo $w_180ur1; ?>"><?php echo $d['r1180u']; ?></td>
					        <td class="<?php echo $w_h2or1; ?>"><?php echo $d['H2O_r1']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>
    <div >
	<h5 class="text-center">RAWMIX 4R2</h5>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			          <th colspan="1"></th> <th colspan="2">Modulus Factor</th><th colspan="2">Sieve On</th><th colspan="1"></th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>JAM</th> <th>LSF</th> <th>SIM</th> <th>ALM</th> <th>90u</th> <th>180u</th> <th>H2O</th>
					</tr>
				</thead>

				<?php
				if(isset($_GET['tgl'])){
				    $tgl = $_GET['tgl'];
				    $sql = "SELECT * FROM lhk_2024 WHERE TANGGAL = '$tgl'";
				} else {  
				    $sql = "SELECT * FROM lhk_2024 WHERE TANGGAL = CURDATE() ";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							$w_180ur1 = '';
					        if ($d['r1180u'] > 3 ) {
					            $w_180ur1 = 'text-danger';
					        }
					        $w_90ur1 = '';
					        if ($d['r190u'] > 20 ) {
					            $w_90ur1 = 'text-danger';
					        }
					        $w_h2or1 = '';
							if ($d['H2O_r1'] < 0.3 || $d['H2O_r1'] > 0.7) {
							    $w_h2or1 = 'text-danger';
							}
							$w_almr1 = '';
							if ($d['ALM_r1'] < 1.4 || $d['ALM_r1'] > 1.8) {
							    $w_almr1 = 'text-danger';
							}
					        $w_lsfr1 = '';
							if ($d['LSF_r1'] < 88 || $d['LSF_r1'] > 104) {
							    $w_lsfr1 = 'text-danger';
							}
							$w_simr1 = '';
							if ($d['SIM_r1'] < 2.1 || $d['SIM_r1'] > 2.5) {
							    $w_simr1 = 'text-danger';
							}
				?>

					    <tr>
					        <td><?php echo $d['JAM']; ?></td>
					        <td class="<?php echo $w_lsfr1; ?>"><?php echo $d['LSF_r1']; ?></td>
					        <td class="<?php echo $w_simr1; ?>"><?php echo $d['SIM_r1']; ?></td>
					        <td class="<?php echo $w_almr1; ?>"><?php echo $d['ALM_r1']; ?></td>
					        <td class="<?php echo $w_90ur1; ?>"><?php echo $d['r190u']; ?></td>
					        <td class="<?php echo $w_180ur1; ?>"><?php echo $d['r1180u']; ?></td>
					        <td class="<?php echo $w_h2or1; ?>"><?php echo $d['H2O_r1']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>

	<div >
	<h5 class="text-center">KILN FEED</h5>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			          <th colspan="1"></th> <th colspan="4">Modulus Factor</th><th colspan="2">Sieve On</th><th colspan="1"></th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>JAM</th> <th>LSF</th> <th>SIM</th> <th>ALM</th> <th>BF</th> <th>90u</th> <th>180u</th> <th>H2O</th>
					</tr>
				</thead>

				<?php
				if(isset($_GET['tgl'])){
				    $tgl = $_GET['tgl'];
				    $sql = "SELECT * FROM lhk_2024 WHERE TANGGAL = '$tgl'";
				} else {  
				    $sql = "SELECT * FROM lhk_2024 WHERE TANGGAL = CURDATE() ";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
					        $w_180ukf = '';
					        if ($d['kf180u'] > 3 ) {
					            $w_180ukf = 'text-danger';
					        }
					        $w_90ukf= '';
							if ($d['kf90u'] > 20 ) {
							    $w_90ukf = 'text-danger';
							}
							$w_h2okf = '';
							if ($d['H2O_kf'] < 0.3 || $d['H2O_kf'] > 0.7) {
							    $w_h2okf = 'text-danger';
							}
							$w_almkf = '';
							if ($d['ALM_kf'] < 1.4 || $d['ALM_kf'] > 1.8) {
							    $w_almkf = 'text-danger';
							}
					        $w_simkf = '';
							if ($d['SIM_kf'] < 2.1 || $d['SIM_kf'] > 2.5) {
							    $w_simkf = 'text-danger';
							}
							$w_lsfkf = '';
							if ($d['LSF_kf'] < 94 || $d['LSF_kf'] > 98) {
							    $w_lsfkf = 'text-danger';
							}
				?>

					    <tr>
					        <td><?php echo $d['JAM']; ?></td>
					        <td class="<?php echo $w_lsfkf; ?>"><?php echo $d['LSF_kf']; ?></td>
					        <td class="<?php echo $w_simkf; ?>"><?php echo $d['SIM_kf']; ?></td>
					        <td class="<?php echo $w_almkf; ?>"><?php echo $d['ALM_kf']; ?></td>
					        <td class="<?php echo $w_90ukf; ?>"><?php echo $d['kf90u']; ?></td>
					        <td ><?php echo $d['BF_kf']; ?></td>
					        <td class="<?php echo $w_180ukf; ?>"><?php echo $d['kf180u']; ?></td>
					        <td class="<?php echo $w_h2okf; ?>"><?php echo $d['H2O_kf']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>
</div>

<div >
	<h5 class="text-center">CLINKER</h5>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			          <th colspan="1"></th><th colspan="3"></th> <th colspan="3">Modulus Factor</th><th colspan="2">Mineral Compound</th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>JAM</th> <th>LW g/l</th> <th>TEMP </th><th>F.Lime </th> <th>LSF</th> <th>SIM</th> <th>ALM</th> <th>C3S</th> <th>C3A</th> 
					</tr>
				</thead>

				<?php
				if(isset($_GET['tgl'])){
				    $tgl = $_GET['tgl'];
				    $sql = "SELECT * FROM lhk_2024 WHERE TANGGAL = '$tgl'";
				} else {  
				    $sql = "SELECT * FROM lhk_2024 WHERE TANGGAL = CURDATE() ";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							$w_flime = '';
					        if ($d['FLIME_cr'] > 1.8 ) {
					            $w_flime = 'text-danger';
					        }
					        $w_c3scr = '';
							if ($d['C3S_cr'] < 56 ) {
							    $w_c3scr = 'text-danger';
							}
							$w_almcr = '';
							if ($d['ALM_cr'] < 1.3 || $d['ALM_cr'] > 1.9) {
							    $w_almcr = 'text-danger';
							}
					        $w_simcr = '';
							if ($d['SIM_cr'] < 2 || $d['SIM_cr'] > 2.6) {
							    $w_simcr = 'text-danger';
							}
							$w_lsfcr = '';
							if ($d['LSF_cr'] < 93 || $d['LSF_cr'] > 97) {
							    $w_lsfcr = 'text-danger';
							}
							$w_ltwcr = '';
							if ($d['LTW_cr'] < 1050 || $d['LTW_cr'] > 1250) {
							    $w_ltwcr = 'text-danger';
 							}
				?>

					    <tr>
					        <td><?php echo $d['JAM']; ?></td>
					        <td class="<?php echo $w_ltwcr; ?>"><?php echo $d['LTW_cr']; ?></td>
					        <td><?php echo $d['TEMP_cr']; ?></td>
					        <td class="<?php echo $w_flime; ?>"><?php echo $d['FLIME_cr']; ?></td>
					        <td class="<?php echo $w_lsfcr; ?>"><?php echo $d['LSF_cr']; ?></td>
					        <td class="<?php echo $w_simcr; ?>"><?php echo $d['SIM_cr']; ?></td>
					        <td class="<?php echo $w_almcr; ?>"><?php echo $d['ALM_cr']; ?></td>
					        <td class="<?php echo $w_c3scr; ?>"><?php echo $d['C3S_cr']; ?></td>
					        <td><?php echo $d['C3A_cr']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>
</div>

	<div >
	<h5 class="text-center">FINE COAL 4K2</h5>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			          <th colspan="1"></th><th colspan="1"> RAW COAL</th> <th colspan="3">FINE COAL</th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>JAM</th> <th>H2O</th> <th>90u</th><th>H2O </th> <th>ASH Cont.</th> 
					</tr>
				</thead>

				<?php
				if(isset($_GET['tgl'])){
				    $tgl = $_GET['tgl'];
				    $sql = "SELECT * FROM lhk_2024 WHERE TANGGAL = '$tgl'";
				} else {  
				    $sql = "SELECT * FROM lhk_2024 WHERE TANGGAL = CURDATE() ";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
					        $w_ashfc = '';
					        if ($d['ASH_fc'] > 20 ) {
					            $w_ashfc = 'text-danger';
					        }
					        $w_h2ofc = '';
					        if ($d['fcH2O_fc'] > 20 ) {
					            $w_h2ofc = 'text-danger';
					        }
					        $w_90ufc  = '';
							if ($d['fc90u'] > 30) {
							    $w_90ufc = 'text-danger';
							}
							$w_h2orc = '';
							if ($d['rcH2O_fc'] > 40) {
							    $w_h2orc = 'text-danger';
							}
				?>

					    <tr>
					        <td><?php echo $d['JAM']; ?></td>
					        <td class="<?php echo $w_h2orc; ?>"><?php echo $d['rcH2O_fc']; ?></td>
					        <td class="<?php echo $w_90ufc; ?>"><?php echo $d['fc90u']; ?></td>
					        <td class="<?php echo $w_h2ofc; ?>"><?php echo $d['fcH2O_fc']; ?></td>
					        <td class="<?php echo $w_ashfc; ?>"><?php echo $d['ASH_fc']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>
</div>

	<div >
	<h5 class="text-center">FINE COAL 4K3</h5>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			          <th colspan="4">FINE COAL</th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>JAM</th>  <th>90u</th><th>H2O </th> <th>ASH Cont.</th> 
					</tr>
				</thead>

				<?php
				if(isset($_GET['tgl'])){
				    $tgl = $_GET['tgl'];
				    $sql = "SELECT * FROM lhk_2024 WHERE TANGGAL = '$tgl'";
				} else {  
				    $sql = "SELECT * FROM lhk_2024 WHERE TANGGAL = CURDATE() ";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
					        $w_ashfc = '';
					        if ($d['ASH_fc2'] > 20 ) {
					            $w_ashfc = 'text-danger';
					        }
					        $w_h2ofc = '';
					        if ($d['fcH2O_fc2'] > 20 ) {
					            $w_h2ofc = 'text-danger';
					        }
					        $w_90ufc  = '';
							if ($d['fc290u'] > 30) {
							    $w_90ufc = 'text-danger';
							}
							
				?>

					    <tr>
					        <td><?php echo $d['JAM']; ?></td>
					        <td class="<?php echo $w_90ufc; ?>"><?php echo $d['fc290u']; ?></td>
					        <td class="<?php echo $w_h2ofc; ?>"><?php echo $d['fcH2O_fc2']; ?></td>
					        <td class="<?php echo $w_ashfc; ?>"><?php echo $d['ASH_fc2']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>
</div>


	<div >
	<h5 class="text-center">4Z1 CEMENT</h5>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			          <th colspan="1"></th><th colspan="5">OPC </th> <th colspan="5">PCC </th><th colspan="5">PCC+ </th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>JAM</th> <th>Blaine</th> <th>SO3 </th><th>45u </th> <th>LOI</th> <th>F.Cao</th> <th>Blaine</th> <th>SO3 </th><th>45u </th> <th>LOI</th> <th>F.Cao</th> <th>Blaine</th> <th>SO3 </th><th>45u </th> <th>LOI</th> <th>F.Cao</th> 
					</tr>
				</thead>

				<?php
				if(isset($_GET['tgl'])){
				    $tgl = $_GET['tgl'];
				    $sql = "SELECT * FROM lhk_2024 WHERE TANGGAL = '$tgl'";
				} else {  
				    $sql = "SELECT * FROM lhk_2024 WHERE TANGGAL = CURDATE() ";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							$w_fcaopcc = '';
					        if ($d['FCaO_z1pcc'] > 1.5 ) {
					            $w_fcaopcc = 'text-danger';
					        }
					        $w_fcaoppc = '';
					        if ($d['FCaO_z1ppc'] > 1.1 ) {
					            $w_fcaoppc = 'text-danger';
					        }
					        $w_fcaoopc = '';
					        if ($d['FCaO_z1opc'] > 1.5 ) {
					            $w_fcaoopc = 'text-danger';
					        }
					        $w_loippc = '';
					        if ($d['LOI_z1ppc'] > 4.75 ) {
					            $w_loippc = 'text-danger';
					        }
					        $w_loiopc = '';
					        if ($d['LOI_z1opc'] > 5 ) {
					            $w_loiopc = 'text-danger';
					        }$w_45uppc = '';
					        if ($d['z145u_ppc'] > 10 ) {
					            $w_45uppc = 'text-danger';
					        }
					        $w_45upcc = '';
					        if ($d['z145u_pcc'] > 8 ) {
					            $w_45upcc = 'text-danger';
					        }$w_45uopc = '';
					        if ($d['z145u_opc'] > 8 ) {
					            $w_45uopc = 'text-danger';
					        }
					        $w_so3ppc = '';
							if ($d['SO3_z1ppc'] < 1.3 || $d['SO3_z1ppc'] > 2.3) {
							    $w_so3ppc = 'text-danger';
							}
							$w_so3pcc = '';
							if ($d['SO3_z1pcc'] < 1 || $d['SO3_z1pcc'] > 4) {
							    $w_so3pcc = 'text-danger';
							}
							$w_so3opc = '';
							if ($d['SO3_z1opc'] < 1 || $d['SO3_z1opc'] > 3) {
							    $w_so3opc = 'text-danger';
							}
					        $w_blaineppc = '';
					        if ($d['BLAINE_z1ppc'] < 360  ) {
					            $w_blaineppc = 'text-danger';
					        }
					        $w_blainepcc = '';
					        if ($d['BLAINE_z1pcc'] < 400 || $d['BLAINE_z1pcc'] > 500) {
					            $w_blainepcc = 'text-danger';
					        }
					        $w_blaineopc = '';
					        if ($d['BLAINE_z1opc'] < 320 ) {
					            $w_blaineopc = 'text-danger';
					        }
				?>

					    <tr>
					        <td><?php echo $d['JAM']; ?></td>
					        <td class="<?php echo $w_blaineopc; ?>"><?php echo $d['BLAINE_z1opc']; ?></td>
					        <td class="<?php echo $w_so3opc; ?>"><?php echo $d['SO3_z1opc']; ?></td>
					        <td class="<?php echo $w_45uopc; ?>"><?php echo $d['z145u_opc']; ?></td>
					        <td class="<?php echo $w_loiopc; ?>"><?php echo $d['LOI_z1opc']; ?></td>
					        <td class="<?php echo $w_fcaoopc; ?>"><?php echo $d['FCaO_z1opc']; ?></td>
					        <td class="<?php echo $w_blainepcc; ?>"><?php echo $d['BLAINE_z1pcc']; ?></td>
					        <td class="<?php echo $w_so3pcc; ?>"><?php echo $d['SO3_z1pcc']; ?></td>
					        <td class="<?php echo $w_45upcc; ?>"><?php echo $d['z145u_pcc']; ?></td>
					        <td><?php echo $d['LOI_z1pcc']; ?></td>
					        <td class="<?php echo $w_fcaopcc; ?>"><?php echo $d['FCaO_z1pcc']; ?></td>
					        <td class="<?php echo $w_blaineppc; ?>"><?php echo $d['BLAINE_z1ppc']; ?></td>
					        <td class="<?php echo $w_so3ppc; ?>"><?php echo $d['SO3_z1ppc']; ?></td>
					        <td class="<?php echo $w_45uppc; ?>"><?php echo $d['z145u_ppc']; ?></td>
					        <td class="<?php echo $w_loippc; ?>"><?php echo $d['LOI_z1ppc']; ?></td>
					        <td class="<?php echo $w_fcaoppc; ?>"><?php echo $d['FCaO_z1ppc']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>
</div>
	<div >
	<h5 class="text-center">4Z2 CEMENT</h5>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			          <th colspan="1"></th><th colspan="5">OPC</th> <th colspan="5">PCC</th><th colspan="5">PCC+</th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>JAM</th> <th>Blaine</th> <th>SO3 </th><th>45u </th> <th>LOI</th> <th>F.Cao</th> <th>Blaine</th> <th>SO3 </th><th>45u </th> <th>LOI</th> <th>F.Cao</th> <th>Blaine</th> <th>SO3 </th><th>45u </th> <th>LOI</th> <th>F.Cao</th> 
					</tr>
				</thead>

				<?php
				if(isset($_GET['tgl'])){
				    $tgl = $_GET['tgl'];
				    $sql = "SELECT * FROM lhk_2024 WHERE TANGGAL = '$tgl'";
				} else {  
				    $sql = "SELECT * FROM lhk_2024 WHERE TANGGAL = CURDATE() ";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							$w_fcaopccz2 = '';
					        if ($d['FCaO_z2pcc'] > 1.5 ) {
					            $w_fcaopccz2 = 'text-danger';
					        }
					        $w_fcaoppcz2 = '';
					        if ($d['FCaO_z2ppc'] > 1.1 ) {
					            $w_fcaoppcz2 = 'text-danger';
					        }
					        $w_fcaoopcz2 = '';
					        if ($d['FCaO_z2opc'] > 1.5 ) {
					            $w_fcaoopcz2 = 'text-danger';
					        }
					        $w_loippcz2 = '';
					        if ($d['LOI_z2ppc'] > 4.75 ) {
					            $w_loippcz2 = 'text-danger';
					        }
					        $w_loiopc = '';
					        if ($d['LOI_z2opcz2'] > 5 ) {
					            $w_loiopc = 'text-danger';
					        }$w_45uppcz2 = '';
					        if ($d['z245u_ppc'] > 10 ) {
					            $w_45uppcz2 = 'text-danger';
					        }
					        $w_45upccz2 = '';
					        if ($d['z245u_pcc'] > 8 ) {
					            $w_45upccz2 = 'text-danger';
					        }$w_45uopcz2 = '';
					        if ($d['z245u_opc'] > 8 ) {
					            $w_45uopcz2 = 'text-danger';
					        }
					        $w_so3ppcz2 = '';
							if ($d['SO3_z2ppc'] < 1.3 || $d['SO3_z2ppc'] > 2.3) {
							    $w_so3ppcz2 = 'text-danger';
							}
							$w_so3pccz2 = '';
							if ($d['SO3_z2pcc'] < 1 || $d['SO3_z2pcc'] > 4) {
							    $w_so3pccz2 = 'text-danger';
							}
							$w_so3opcz2 = '';
							if ($d['SO3_z2opc'] < 1 || $d['SO3_z2opc'] > 3) {
							    $w_so3opcz2 = 'text-danger';
							}
					        $w_blaineppcz2 = '';
					        if ($d['BLAINE_z2ppc'] < 360  ) {
					            $w_blaineppcz2 = 'text-danger';
					        }
					        $w_blainepccz2 = '';
					        if ($d['BLAINE_z2pcc'] < 400 || $d['BLAINE_z2pcc'] > 500) {
					            $w_blainepccz2 = 'text-danger';
					        }
					        $w_blaineopcz2 = '';
					        if ($d['BLAINE_z2opc'] < 320 ) {
					            $w_blaineopcz2 = 'text-danger';
					        }
				?>

					    <tr>
					        <td><?php echo $d['JAM']; ?></td>
					        <td class="<?php echo $w_blaineopcz2; ?>"><?php echo $d['BLAINE_z2opc']; ?></td>
					        <td class="<?php echo $w_so3opcz2; ?>"><?php echo $d['SO3_z2opc']; ?></td>
					        <td class="<?php echo $w_45uopcz2; ?>"><?php echo $d['z245u_opc']; ?></td>
					        <td class="<?php echo $w_loiopcz2; ?>"><?php echo $d['LOI_z2opc']; ?></td>
					        <td class="<?php echo $w_fcaoopcz2; ?>"><?php echo $d['FCaO_z2opc']; ?></td>
					        <td class="<?php echo $w_blainepccz2; ?>"><?php echo $d['BLAINE_z2pcc']; ?></td>
					        <td class="<?php echo $w_so3pccz2; ?>"><?php echo $d['SO3_z2pcc']; ?></td>
					        <td class="<?php echo $w_45upccz2; ?>"><?php echo $d['z245u_pcc']; ?></td>
					        <td><?php echo $d['LOI_z2pcc']; ?></td>
					        <td class="<?php echo $w_fcaopccz2; ?>"><?php echo $d['FCaO_z2pcc']; ?></td>
					        <td class="<?php echo $w_blaineppcz2; ?>"><?php echo $d['BLAINE_z2ppc']; ?></td>
					        <td class="<?php echo $w_so3ppcz2; ?>"><?php echo $d['SO3_z2ppc']; ?></td>
					        <td class="<?php echo $w_45uppcz2; ?>"><?php echo $d['z245u_ppc']; ?></td>
					        <td class="<?php echo $w_loippcz2; ?>"><?php echo $d['LOI_z2ppc']; ?></td>
					        <td class="<?php echo $w_fcaoppcz2; ?>"><?php echo $d['FCaO_z2ppc']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>
</div>
	<div >
	<h5 class="text-center"></h5>
		<table class="adminlist mb-3 " border="1" width="500" cellpadding="5"  >
				<thead>
					<tr class="text-center" >
			            <th rowspan="1"></th><th colspan="8">Chemical Composition</th>
			        </tr>
					<tr bgcolor="#8080FF" style="color:#FFFFFF">
				        <th></th>
				        <th>SiO2</th><th>Al2O3</th><th>Fe2O3</th><th>CaO</th><th>MgO</th><th>SO3</th><th>H2O</th>
				        
				    </tr> 
				</thead>
					<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>LS R1 (AVG)</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    ?>
				        
				            <td><?php echo $d['SiO2_lsAVG']; ?></td>
				            <td><?php echo $d['Al2O3_lsAVG']; ?></td>
				            <td><?php echo $d['Fe2O3_lsAVG']; ?></td>
				            <td><?php echo $d['CaO_lsAVG']; ?></td>
				            <td><?php echo $d['MgO_lsAVG']; ?></td>
				            <td><?php echo $d['SO3_lsAVG']; ?></td>
				            <td><?php echo $d['H2O_lsAVG']; ?></td>
				       
				    <?php
				    }
				    ?>
				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>LS R1 (SD)</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    ?>
				        
				            <td><?php echo $d['SiO2_lsSD']; ?></td>
				            <td><?php echo $d['Al2O3_lsSD']; ?></td>
				            <td><?php echo $d['Fe2O3_lsSD']; ?></td>
				            <td><?php echo $d['CaO_lsSD']; ?></td>
				            <td><?php echo $d['MgO_lsSD']; ?></td>
				            <td><?php echo $d['SO3_lsSD']; ?></td>
				            <td><?php echo $d['H2O_lsSD']; ?></td>
				       
				    <?php
				    }
				    ?>
				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>LS R2 (AVG)</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    ?>
				        
				            <td><?php echo $d['SiO2_ls2AVG']; ?></td>
				            <td><?php echo $d['Al2O3_ls2AVG']; ?></td>
				            <td><?php echo $d['Fe2O3_ls2AVG']; ?></td>
				            <td><?php echo $d['CaO_ls2AVG']; ?></td>
				            <td><?php echo $d['MgO_ls2AVG']; ?></td>
				            <td><?php echo $d['SO3_ls2AVG']; ?></td>
				            <td><?php echo $d['H2O_ls2AVG']; ?></td>
				       
				    <?php
				    }
				    ?>
				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>LS R2 (SD)</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    ?>
				        
				            <td><?php echo $d['SiO2_ls2SD']; ?></td>
				            <td><?php echo $d['Al2O3_ls2SD']; ?></td>
				            <td><?php echo $d['Fe2O3_ls2SD']; ?></td>
				            <td><?php echo $d['CaO_ls2SD']; ?></td>
				            <td><?php echo $d['MgO_ls2SD']; ?></td>
				            <td><?php echo $d['SO3_ls2SD']; ?></td>
				            <td><?php echo $d['H2O_ls2SD']; ?></td>
				       
				    <?php
				    }
				    ?>
				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>SS RM (AVG)</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    ?>
				        
				            <td><?php echo $d['SiO2_ssAVG']; ?></td>
				            <td><?php echo $d['Al2O3_ssAVG']; ?></td>
				            <td><?php echo $d['Fe2O3_ssAVG']; ?></td>
				            <td><?php echo $d['CaO_ssAVG']; ?></td>
				            <td><?php echo $d['MgO_ssAVG']; ?></td>
				            <td><?php echo $d['SO3_ssAVG']; ?></td>
				            <td><?php echo $d['H2O_ssAVG']; ?></td>
				       
				    <?php
				    }
				    ?>
				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>SS RM (SD)</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    ?>
				        
				            <td><?php echo $d['SiO2_ssSD']; ?></td>
				            <td><?php echo $d['Al2O3_ssSD']; ?></td>
				            <td><?php echo $d['Fe2O3_ssSD']; ?></td>
				            <td><?php echo $d['CaO_ssSD']; ?></td>
				            <td><?php echo $d['MgO_ssSD']; ?></td>
				            <td><?php echo $d['SO3_ssSD']; ?></td>
				            <td><?php echo $d['H2O_ssSD']; ?></td>
				       
				    <?php
				    }
				    ?>
				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>CLAY</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    	 $w_al2o3cl = '';
					        if ($d['Al2O3_clAVG'] < 22 ) {
					            $w_al2o3cl = 'text-danger font-weight-bold';
					        }
					     $w_sio2cl = '';
					        if ($d['SiO2_clAVG'] > 60 ) {
					            $w_sio2cl = 'text-danger font-weight-bold';
					        }
				    ?>
				        
				            <td  class="<?php echo $w_sio2cl; ?>"><?php echo $d['SiO2_clAVG']; ?></td>
				            <td  class="<?php echo $w_al2o3cl; ?>"><?php echo $d['Al2O3_clAVG']; ?></td>
				            <td><?php echo $d['Fe2O3_clAVG']; ?></td>
				            <td><?php echo $d['CaO_clAVG']; ?></td>
				            <td><?php echo $d['MgO_clAVG']; ?></td>
				            <td><?php echo $d['SO3_clAVG']; ?></td>
				            <td><?php echo $d['H2O_clAVG']; ?></td>
				       
				    <?php
				    }
				    ?>
				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>IS</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    	 $w_fe2o3is = '';
					        if ($d['Fe2O3_is'] < 50 ) {
					            $w_fe2o3is = 'text-danger font-weight-bold';
					        }
				    ?>
				        
				            <td><?php echo $d['SiO2_is']; ?></td>
				            <td><?php echo $d['Al2O3_is']; ?></td>
				            <td class="<?php echo $w_fe2o3is; ?>"><?php echo $d['Fe2O3_is']; ?></td>
				            <td><?php echo $d['CaO_is']; ?></td>
				            <td><?php echo $d['MgO_is']; ?></td>
				            <td><?php echo $d['SO3_is']; ?></td>
				            <td><?php echo $d['H2O_is']; ?></td>
				       
				    <?php
				    }
				    ?>
				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>LSCM</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    	 $w_al2o3lscm = '';
					        if ($d['Al2O3_lscm'] > 1 ) {
					            $w_al2o3lscm = 'text-danger font-weight-bold';
					        }
					     $w_sio2lscm = '';
					        if ($d['SiO2_lscm'] > 5 ) {
					            $w_sio2lscm = 'text-danger font-weight-bold';
					        }
					     $w_h2olscm = '';
					        if ($d['H2O_lscm'] > 6 ) {
					            $w_h2olscm = 'text-danger font-weight-bold';
					        }
					     $w_caolscm = '';
					        if ($d['CaO_lscm'] < 52 ) {
					            $w_caolscm = 'text-danger font-weight-bold';
					        }
				    ?>
				        
				            <td class="<?php echo $w_sio2lscm; ?>"><?php echo $d['SiO2_lscm']; ?></td>
				            <td class="<?php echo $w_al2o3lscm; ?>"><?php echo $d['Al2O3_lscm']; ?></td>
				            <td><?php echo $d['Fe2O3_lscm']; ?></td>
				            <td class="<?php echo $w_caolscm; ?>"><?php echo $d['CaO_lscm']; ?></td>
				            <td><?php echo $d['MgO_lscm']; ?></td>
				            <td><?php echo $d['SO3_lscm']; ?></td>
				            <td class="<?php echo $w_h2olscm; ?>"><?php echo $d['H2O_lscm']; ?></td>
				       
				    <?php
				    }
				    ?>
				</tr>
			<thead>
					<tr class="text-center" >
			            <th rowspan="1"></th><th colspan="9">CLINKER FEEDER TO CM</th>
			        </tr>
					<tr bgcolor="#8080FF" style="color:#FFFFFF">
				        <th></th>
				        <th>F.CaO</th><th>LSF</th><th>SIM</th><th>ALM</th><th>C3S</th><th>C3A</th><th>SUM</th> 
				    </tr> 
			</thead>
			<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>CRF Z1</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    ?>
				        
				            <td><?php echo $d['FCaO_crf']; ?></td>
				            <td><?php echo $d['LSF_crf']; ?></td>
				            <td><?php echo $d['SIM_crf']; ?></td>
				            <td><?php echo $d['ALM_crf']; ?></td>
				            <td><?php echo $d['C3S_crf']; ?></td>
				            <td><?php echo $d['C3A_crf']; ?></td>
				            <td><?php echo $d['SUM_crf']; ?></td>
				       
				       
				    <?php
				    }
				    ?>
				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>CRF Z2</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    ?>
				        
				            <td><?php echo $d['FCaO_crf2']; ?></td>
				            <td><?php echo $d['LSF_crf2']; ?></td>
				            <td><?php echo $d['SIM_crf2']; ?></td>
				            <td><?php echo $d['ALM_crf2']; ?></td>
				            <td><?php echo $d['C3S_crf2']; ?></td>
				            <td><?php echo $d['C3A_crf2']; ?></td>
				            <td><?php echo $d['SUM_crf2']; ?></td>
				       
				       
				    <?php
				    }
				    ?>
				</tr>
			<thead>
					<tr class="text-center" >
			            <th rowspan="1"></th><th colspan="8">Clinker Factor</th>
			        </tr>
					<tr bgcolor="#8080FF" style="color:#FFFFFF">
				        <th></th>
				        <th>SiO2</th><th>Al2O3</th><th>Fe2O3</th><th>CaO</th><th>FK%</th><th>Est.BTL</th> 
				    </tr> 
			</thead>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>OPC VIII</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    ?>
				        
				            <td><?php echo $d['SiO2_opc']; ?></td>
				            <td><?php echo $d['Al2O3_opc']; ?></td>
				            <td><?php echo $d['Fe2O3_opc']; ?></td>
				            <td><?php echo $d['CaO_opc']; ?></td>
				            <td><?php echo $d['FK_opc']; ?></td>
				            <td><?php echo $d['est_opc']; ?></td>
				       
				    <?php
				    }
				    ?>
				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>OPC IX</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    ?>
				        
				            <td><?php echo $d['SiO2_z2opc']; ?></td>
				            <td><?php echo $d['Al2O3_z2opc']; ?></td>
				            <td><?php echo $d['Fe2O3_z2opc']; ?></td>
				            <td><?php echo $d['CaO_z2opc']; ?></td>
				            <td><?php echo $d['FK_z2opc']; ?></td>
				            <td><?php echo $d['est_z2opc']; ?></td>
				       
				    <?php
				    }
				    ?>
				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>PCC VIII</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    ?>
				        
				            <td><?php echo $d['SiO2_pcc']; ?></td>
				            <td><?php echo $d['Al2O3_pcc']; ?></td>
				            <td><?php echo $d['Fe2O3_pcc']; ?></td>
				            <td><?php echo $d['CaO_pcc']; ?></td>
				            <td><?php echo $d['FK_pcc']; ?></td>
				            <td><?php echo $d['est_pcc']; ?></td>
				       
				    <?php
				    }
				    ?>
				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>PCC IX</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    ?>
				        
				            <td><?php echo $d['SiO2_z2pcc']; ?></td>
				            <td><?php echo $d['Al2O3_z2pcc']; ?></td>
				            <td><?php echo $d['Fe2O3_z2pcc']; ?></td>
				            <td><?php echo $d['CaO_z2pcc']; ?></td>
				            <td><?php echo $d['FK_z2pcc']; ?></td>
				            <td><?php echo $d['est_z2pcc']; ?></td>
				       
				    <?php
				    }
				    ?>
				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>PCC+ VIII</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    ?>
				        
				            <td><?php echo $d['SiO2_ppc']; ?></td>
				            <td><?php echo $d['Al2O3_ppc']; ?></td>
				            <td><?php echo $d['Fe2O3_ppc']; ?></td>
				            <td><?php echo $d['CaO_ppc']; ?></td>
				            <td><?php echo $d['FK_ppc']; ?></td>
				            <td><?php echo $d['est_ppc']; ?></td>
				       
				    <?php
				    }
				    ?>
				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>PCC+ IX</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    ?>
				        
				            <td><?php echo $d['SiO2_z2ppc']; ?></td>
				            <td><?php echo $d['Al2O3_z2ppc']; ?></td>
				            <td><?php echo $d['Fe2O3_z2ppc']; ?></td>
				            <td><?php echo $d['CaO_z2ppc']; ?></td>
				            <td><?php echo $d['FK_z2ppc']; ?></td>
				            <td><?php echo $d['est_z2ppc']; ?></td>
				       
				    <?php
				    }
				    ?>
				</tr>

				<thead>
					<tr class="text-center" >
			           <th rowspan="1"></th><th colspan="8">RATA-RATA PROPORSI MATERIAL </th>
			        </tr>
			        <tr class="text-center" >
			            <th rowspan="2">RM</th><th colspan="4">PROPORSI (%) </th><th colspan="4">TONASE UNTUK 100 TON RX </th>
			        </tr>
					<tr bgcolor="#8080FF" style="color:#FFFFFF">
				        <th>LS</th><th>SS</th><th>CS</th><th>IS</th> <th>LS</th><th>SS</th><th>CS</th><th>IS</th> 
				    </tr> 
			</thead>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>4R1</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    ?>
				        
				            <td><?php echo $d['LS_r1%']; ?></td>
				            <td><?php echo $d['SS_r1%']; ?></td>
				            <td><?php echo $d['CL_r1%']; ?></td>
				            <td><?php echo $d['IS_r1%']; ?></td>
				            <td><?php echo $d['LS_tonase']; ?></td>
				            <td><?php echo $d['SS_tonase']; ?></td>
				            <td><?php echo $d['CL_tonase']; ?></td>
				            <td><?php echo $d['IS_tonase']; ?></td>
				       
				    <?php
				    }
				    ?>
				</tr>
				<tr bgcolor="YELLOW" style="color:BLACK">
				    <th>4R2</th>
				    <?php
				    if (isset($_GET['tgl'])) {
				        $tgl = $_GET['tgl'];
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = '$tgl'";
				    } else {  
				        $sql = "SELECT * FROM lhk_2024_clinker WHERE TANGGAL = CURDATE()";
				    }
				    
				    $q = mysqli_query($conn, $sql);
				    while ($d = mysqli_fetch_array($q)) {
				    ?>
				        
				            <td><?php echo $d['LS_r2%']; ?></td>
				            <td><?php echo $d['SS_r2%']; ?></td>
				            <td><?php echo $d['CL_r2%']; ?></td>
				            <td><?php echo $d['IS_r2%']; ?></td>
				            <td><?php echo $d['LS_tonase2']; ?></td>
				            <td><?php echo $d['SS_tonase2']; ?></td>
				            <td><?php echo $d['CL_tonase2']; ?></td>
				            <td><?php echo $d['IS_tonase2']; ?></td>
				       
				    <?php
				    }
				    ?>
				</tr>


		

					        
  
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