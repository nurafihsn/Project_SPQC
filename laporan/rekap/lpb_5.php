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
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

</head>

<body>
	<h2 class="text-center">LAPORAN BULANAN</h2>
	<h2 class="text-center mb-5" >PABRIK INDARUNG V</h2>
	<form method="get" class="mb-3">
	    <label>PILIH BULAN: </label>
	    <input type="month" name="bulan">
	    <input class="btn btn-primary" type="submit" value="FILTER">
	</form>

		<h3 class="text-center">
			<?php
			    if(isset($_GET['bulan'])){
			        $bulan = $_GET['bulan'];
			        echo "<label>Rekap : $bulan</label>";
			    }
			    ?>
		</h3>


<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'LSTG';
?>

<div>
	<?php if ($page == 'LSTG') : ?>
	<h4 class="text-center">LAPORAN BULANAN LIMESTONE TO STORAGE</h4>
    <h7 class="text-center">1. Limestone Crusher II</h7>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr class="text-center">
                <th colspan="1"></th><th colspan="11">KOMPOSISI</th>
            </tr>
            <tr class="bg-primary text-white">
                <th>TANGGAL</th> <th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th><th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>H2O</th><th>LSF</th>
            </tr>
        </thead>

        <?php
        if (isset($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
            $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
        } else {
        	$tgl = date('Y-m');
            $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
        }
        $q = mysqli_query($conn, $sql);
        while ($d = mysqli_fetch_array($q)) {
            $w_h2olstg = $d['H2O_lstg2'] > 6 ? 'text-danger' : '';
            $w_caolstg = $d['CaO_lstg2'] < 48 ? 'text-danger' : '';
            $w_al2o3lstg = ($d['Al2O3_lstg2'] < 1.5 || $d['Al2O3_lstg2'] > 1.7) ? 'text-danger' : '';
            $w_sio2lstg = ($d['SiO2_lstg2'] < 7 || $d['SiO2_lstg2'] > 10) ? 'text-danger' : '';
            ?>
            <tr>
                <td><?php echo $d['TANGGAL']; ?></td>
                <td class="<?php echo $w_sio2lstg; ?>"><?php echo $d['SiO2_lstg2']; ?></td>
                <td class="<?php echo $w_al2o3lstg; ?>"><?php echo $d['Al2O3_lstg2']; ?></td>
                <td><?php echo $d['Fe2O3_lstg2']; ?></td>
                <td class="<?php echo $w_caolstg; ?>"><?php echo $d['CaO_lstg2']; ?></td>
                <td><?php echo $d['MgO_lstg2']; ?></td>
                <td><?php echo $d['SO3_lstg2']; ?></td>
                <td><?php echo $d['K2O_lstg2']; ?></td>
                <td><?php echo $d['Na2O_lstg2']; ?></td>
                <td><?php echo $d['Cl2_lstg2']; ?></td>
                <td class="<?php echo $w_h2olstg; ?>"><?php echo $d['H2O_lstg2']; ?></td>
                <td><?php echo $d['LSF_lstg2']; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>

    <h7 class="text-center">2. Limestone Crusher IIIA</h7>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr class="text-center">
                <th colspan="1"></th><th colspan="11">KOMPOSISI</th>
            </tr>
            <tr class="bg-primary text-white">
                <th>TANGGAL</th> <th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th><th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>H2O</th><th>LSF</th>
            </tr>
        </thead>

        <?php
        if (isset($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
            $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
        } else {
        	$tgl = date('Y-m');
            $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
        }
        $q = mysqli_query($conn, $sql);
        while ($d = mysqli_fetch_array($q)) {
            $w_h2olstg = $d['H2O_lstg3a'] > 6 ? 'text-danger' : '';
            $w_caolstg = $d['CaO_lstg3a'] < 48 ? 'text-danger' : '';
            $w_al2o3lstg = ($d['Al2O3_lstg3a'] < 1.5 || $d['Al2O3_lstg3a'] > 1.7) ? 'text-danger' : '';
            $w_sio2lstg = ($d['SiO2_lstg3a'] < 7 || $d['SiO2_lstg3a'] > 10) ? 'text-danger' : '';
            ?>
            <tr>
                <td><?php echo $d['TANGGAL']; ?></td>
                <td class="<?php echo $w_sio2lstg; ?>"><?php echo $d['SiO2_lstg3a']; ?></td>
                <td class="<?php echo $w_al2o3lstg; ?>"><?php echo $d['Al2O3_lstg3a']; ?></td>
                <td><?php echo $d['Fe2O3_lstg3a']; ?></td>
                <td class="<?php echo $w_caolstg; ?>"><?php echo $d['CaO_lstg3a']; ?></td>
                <td><?php echo $d['MgO_lstg3a']; ?></td>
                <td><?php echo $d['SO3_lstg3a']; ?></td>
                <td><?php echo $d['K2O_lstg3a']; ?></td>
                <td><?php echo $d['Na2O_lstg3a']; ?></td>
                <td><?php echo $d['Cl2_lstg3a']; ?></td>
                <td class="<?php echo $w_h2olstg; ?>"><?php echo $d['H2O_lstg3a']; ?></td>
                <td><?php echo $d['LSF_lstg3a']; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>

    <h7 class="text-center">3. Limestone Crusher IIIB</h7>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr class="text-center">
                <th colspan="1"></th><th colspan="11">KOMPOSISI</th>
            </tr>
            <tr class="bg-primary text-white">
                <th>TANGGAL</th> <th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th><th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>H2O</th><th>LSF</th>
            </tr>
        </thead>

        <?php
        if (isset($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
            $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
        } else {
        	$tgl = date('Y-m');
            $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
        }
        $q = mysqli_query($conn, $sql);
        while ($d = mysqli_fetch_array($q)) {
            $w_h2olstg = $d['H2O_lstg3b'] > 6 ? 'text-danger' : '';
            $w_caolstg = $d['CaO_lstg3b'] < 48 ? 'text-danger' : '';
            $w_al2o3lstg = ($d['Al2O3_lstg3b'] < 1.5 || $d['Al2O3_lstg3b'] > 1.7) ? 'text-danger' : '';
            $w_sio2lstg = ($d['SiO2_lstg3b'] < 7 || $d['SiO2_lstg3b'] > 10) ? 'text-danger' : '';
            ?>
            <tr>
                <td><?php echo $d['TANGGAL']; ?></td>
                <td class="<?php echo $w_sio2lstg; ?>"><?php echo $d['SiO2_lstg3b']; ?></td>
                <td class="<?php echo $w_al2o3lstg; ?>"><?php echo $d['Al2O3_lstg3b']; ?></td>
                <td><?php echo $d['Fe2O3_lstg3b']; ?></td>
                <td class="<?php echo $w_caolstg; ?>"><?php echo $d['CaO_lstg3b']; ?></td>
                <td><?php echo $d['MgO_lstg3b']; ?></td>
                <td><?php echo $d['SO3_lstg3b']; ?></td>
                <td><?php echo $d['K2O_lstg3b']; ?></td>
                <td><?php echo $d['Na2O_lstg3b']; ?></td>
                <td><?php echo $d['Cl2_lstg3b']; ?></td>
                <td class="<?php echo $w_h2olstg; ?>"><?php echo $d['H2O_lstg3b']; ?></td>
                <td><?php echo $d['LSF_lstg3b']; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>


</div>

     <h7 class="text-center">4. Limestone Crusher VI</h7>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			           <th colspan="1"></th><th colspan="11"> KOMPOSISI</th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>TANGGAL</th> <th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th><th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>H2O</th><th>LSF</th> 
					</tr>
				</thead>

				<?php
				if(isset($_GET['bulan'])){
				    $bulan = $_GET['bulan'];
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
				} else {  
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl' ";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							$w_h2olstg = '';
					        if ($d['H2O_lstg6'] > 6 ) {
					            $w_h2olstg = 'text-danger';
					        }
					        $w_caolstg = '';
					        if ($d['CaO_lstg6'] < 48 ) {
					            $w_caolstg = 'text-danger';
					        }
					       $w_al2o3lstg = '';
					        if ($d['Al2O3_lstg6'] < 1.5 || $d['Al2O3_lstg6'] > 1.7) {
					            $w_al2o3lstg = 'text-danger';
					        }
					        $w_sio2lstg  = '';
							if ($d['SiO2_lstg6'] < 7 || $d['SiO2_lstg6'] > 10) {
							    $w_sio2lstg = 'text-danger';
							}
						?>
 
					    <tr>
					        <td><?php echo $d['TANGGAL']; ?></td>
					        <td class="<?php echo $w_sio2lstg; ?>"><?php echo $d['SiO2_lstg6']; ?></td>
					        <td class="<?php echo $w_al2o3lstg; ?>"><?php echo $d['Al2O3_lstg6']; ?></td>
					        <td><?php echo $d['Fe2O3_lstg6']; ?></td>
					        <td class="<?php echo $w_caolstg; ?>"><?php echo $d['CaO_lstg6']; ?></td>
					        <td><?php echo $d['MgO_lstg6']; ?></td>
					        <td><?php echo $d['SO3_lstg6']; ?></td>
					        <td><?php echo $d['K2O_lstg6']; ?></td>
					        <td><?php echo $d['Na2O_lstg6']; ?></td>
					        <td><?php echo $d['Cl2_lstg6']; ?></td>
					        <td class="<?php echo $w_h2olstg; ?>"><?php echo $d['H2O_lstg6']; ?></td>
					        <td><?php echo $d['LSF_lstg6']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>
    <h7 class="text-center">5. Limestone Crusher MS1</h7>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			           <th colspan="1"></th><th colspan="11"> KOMPOSISI</th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>TANGGAL</th> <th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th><th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>H2O</th><th>LSF</th> 
					</tr>
				</thead>

				<?php
				if(isset($_GET['bulan'])){
				    $bulan = $_GET['bulan'];
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
				} else {  
					$tgl = date('Y-m');
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							$w_h2olstg = '';
					        if ($d['H2O_lstgms1'] > 6 ) {
					            $w_h2olstg = 'text-danger';
					        }
					        $w_caolstg = '';
					        if ($d['CaO_lstgms1'] < 48 ) {
					            $w_caolstg = 'text-danger';
					        }
					       $w_al2o3lstg = '';
					        if ($d['Al2O3_lstgms1'] < 1.5 || $d['Al2O3_lstgms1'] > 1.7) {
					            $w_al2o3lstg = 'text-danger';
					        }
					        $w_sio2lstg  = '';
							if ($d['SiO2_lstgms1'] < 7 || $d['SiO2_lstgms1'] > 10) {
							    $w_sio2lstg = 'text-danger';
							}
						?>
 
					    <tr>
					        <td><?php echo $d['TANGGAL']; ?></td>
					        <td class="<?php echo $w_sio2lstg; ?>"><?php echo $d['SiO2_lstgms1']; ?></td>
					        <td class="<?php echo $w_al2o3lstg; ?>"><?php echo $d['Al2O3_lstgms1']; ?></td>
					        <td><?php echo $d['Fe2O3_lstgms1']; ?></td>
					        <td class="<?php echo $w_caolstg; ?>"><?php echo $d['CaO_lstgms1']; ?></td>
					        <td><?php echo $d['MgO_lstgms1']; ?></td>
					        <td><?php echo $d['SO3_lstgms1']; ?></td>
					        <td><?php echo $d['K2O_lstgms1']; ?></td>
					        <td><?php echo $d['Na2O_lstgms1']; ?></td>
					        <td><?php echo $d['Cl2_lstgms1']; ?></td>
					        <td class="<?php echo $w_h2olstg; ?>"><?php echo $d['H2O_lstgms1']; ?></td>
					        <td><?php echo $d['LSF_lstgms1']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>
    <a href="?page=RM&bulan=<?php echo isset($bulan) ? $bulan : ''; ?>" class="btn btn-primary">Next Page</a>
</div>
	<div > 
    <?php elseif ($page == 'RM') : ?>
	<h4 class="text-center">LAPORAN  BULANAN  RAW  MATERIAL  TO RAWMILL</h4>
	<h7 class="text-center">1. Limestone</h7>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			           <th colspan="1"></th><th colspan="11"> KOMPOSISI</th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>TANGGAL</th> <th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th><th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>H2O</th><th>LSF</th> 
					</tr>
				</thead>

				<?php
				if(isset($_GET['bulan'])){
				    $bulan = $_GET['bulan'];
				    $sql = "SELECT * FROM lpb_2024 WHERE  DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
				} else {  
					$tgl = date('Y-m');
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							$w_h2ols = '';
					        if ($d['H2O_ls'] > 6 ) {
					            $w_h2ols = 'text-danger';
					        }
					        $w_caols = '';
					        if ($d['CaO_ls'] < 48 ) {
					            $w_caols = 'text-danger';
					        }
					        $w_al2o3ls = '';
					        if ($d['Al2O3_ls'] > 1.6) {
					            $w_al2o3ls = 'text-danger';
					        }
					        $w_sio2ls  = '';
							if ( $d['SiO2_ls'] > 10) {
							    $w_sio2ls = 'text-danger';
							}
						?>
 
					    <tr>
					        <td><?php echo $d['TANGGAL']; ?></td>
					        <td class="<?php echo $w_sio2ls; ?>"><?php echo $d['SiO2_ls']; ?></td>
					        <td class="<?php echo $w_al2o3ls; ?>"><?php echo $d['Al2O3_ls']; ?></td>
					        <td><?php echo $d['Fe2O3_ls']; ?></td>
					        <td class="<?php echo $w_caols; ?>"><?php echo $d['CaO_ls']; ?></td>
					        <td><?php echo $d['MgO_ls']; ?></td>
					        <td><?php echo $d['SO3_ls']; ?></td>
					        <td><?php echo $d['K2O_ls']; ?></td>
					        <td><?php echo $d['Na2O_ls']; ?></td>
					        <td><?php echo $d['Cl2_ls']; ?></td>
					        <td class="<?php echo $w_h2ols; ?>"><?php echo $d['H2O_ls']; ?></td>
					        <td><?php echo $d['LSF_ls']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>
    <h7 class="text-center">2. Silicastone</h7>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			           <th colspan="1"></th><th colspan="9"> KOMPOSISI</th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>TANGGAL</th> <th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>H2O</th>
					</tr>
				</thead>

				<?php
				if(isset($_GET['bulan'])){
				    $bulan = $_GET['bulan'];
				    $sql = "SELECT * FROM lpb_2024 WHERE  DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
				} else {  
					$tgl = date('Y-m');
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							$w_h2oss = '';
					        if ($d['H2O_ss'] > 15) {
					            $w_h2oss = 'text-danger';
					        }
					        $w_al2o3ss = '';
					        if ($d['Al2O3_ss'] > 15) {
					            $w_al2o3ss = 'text-danger';
					        }
					        $w_sio2ss  = '';
							if ( $d['SiO2_ss'] < 60) {
							    $w_sio2ss = 'text-danger';
							}
						?>
 
					    <tr>
					        <td><?php echo $d['TANGGAL']; ?></td>
					        <td class="<?php echo $w_sio2ss; ?>"><?php echo $d['SiO2_ss']; ?></td>
					        <td class="<?php echo $w_al2o3ss; ?>"><?php echo $d['Al2O3_ss']; ?></td>
					        <td><?php echo $d['Fe2O3_ss']; ?></td>
					        <td class="<?php echo $w_caoss; ?>"><?php echo $d['CaO_ss']; ?></td>
					        <td><?php echo $d['MgO_ss']; ?></td>
					        <td><?php echo $d['K2O_ss']; ?></td>
					        <td><?php echo $d['Na2O_ss']; ?></td>
					        <td><?php echo $d['Cl2_ss']; ?></td>
					        <td class="<?php echo $w_h2oss; ?>"><?php echo $d['H2O_ss']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>
    <h7 class="text-center">3. Clay</h7>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			           <th colspan="1"></th><th colspan="10"> KOMPOSISI</th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>TANGGAL</th> <th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th><th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>H2O</th> 
					</tr>
				</thead>

				<?php
				if(isset($_GET['bulan'])){
				    $bulan = $_GET['bulan'];
				    $sql = "SELECT * FROM lpb_2024 WHERE  DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
				} else {  
					$tgl = date('Y-m');
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							
					        $w_al2o3cl = '';
					        if ($d['Al2O3_cl'] < 22) {
					            $w_al2o3cl = 'text-danger';
					        }
					        $w_sio2cl  = '';
							if ( $d['SiO2_cl'] > 60) {
							    $w_sio2cl = 'text-danger';
							}
						?>
 
					    <tr>
					        <td><?php echo $d['TANGGAL']; ?></td>
					        <td class="<?php echo $w_sio2cl; ?>"><?php echo $d['SiO2_cl']; ?></td>
					        <td class="<?php echo $w_al2o3cl; ?>"><?php echo $d['Al2O3_cl']; ?></td>
					        <td><?php echo $d['Fe2O3_cl']; ?></td>
					        <td><?php echo $d['CaO_cl']; ?></td>
					        <td><?php echo $d['MgO_cl']; ?></td>
					        <td><?php echo $d['SO3_cl']; ?></td>
					        <td><?php echo $d['K2O_cl']; ?></td>
					        <td><?php echo $d['Na2O_cl']; ?></td>
					        <td><?php echo $d['Cl2_cl']; ?></td>
					        <td><?php echo $d['H2O_cl']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>
     <h7 class="text-center">4. Iron Sand</h7>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			           <th colspan="1"></th><th colspan="10"> KOMPOSISI</th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>TANGGAL</th> <th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th><th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>H2O</th> 
					</tr>
				</thead>

				<?php
				if(isset($_GET['bulan'])){
				    $bulan = $_GET['bulan'];
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
				} else {
					$tgl = date('Y-m');  
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							
					        $w_fe2o3is = '';
					        if ($d['Fe2O3_is'] < 50) {
					            $w_fe2o3is = 'text-danger';
					        }
					        
						?>
 
					    <tr>
					        <td><?php echo $d['TANGGAL']; ?></td>
					        <td><?php echo $d['SiO2_is']; ?></td>
					        <td><?php echo $d['Al2O3_is']; ?></td>
					        <td class="<?php echo $w_fe2o3is; ?>"><?php echo $d['Fe2O3_is']; ?></td>
					        <td><?php echo $d['CaO_is']; ?></td>
					        <td><?php echo $d['MgO_is']; ?></td>
					        <td><?php echo $d['SO3_is']; ?></td>
					        <td><?php echo $d['K2O_is']; ?></td>
					        <td><?php echo $d['Na2O_is']; ?></td>
					        <td><?php echo $d['Cl2_is']; ?></td>
					        <td><?php echo $d['H2O_is']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>

    <a href="?page=LSTG&bulan=<?php echo isset($bulan) ? $bulan : ''; ?>" class="btn btn-primary">Previous Page</a>
    <a href="?page=produk&bulan=<?php echo isset($bulan) ? $bulan : ''; ?>" class="btn btn-primary">Next Page</a>
	<div >

    <?php elseif ($page == 'produk') : ?>
	<h5 class="text-center">LAPORAN BULANAN KUALITAS  PRODUK  PABRIK  INDARUNG  V</h5>
			<h7 class="text-center">1. RAWMIX 5R1</h7>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			           <th colspan="1"></th><th colspan="3"> MODULUS FACTOR</th><th colspan="2">SIEVE ON</th><th rowspan="2" >H2O</th><th rowspan="2">SD LSF</th><th rowspan="2">COUNT</th><th colspan="9"> OKSIDA</th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>TANGGAL</th>  <th>LSF</th> <th>SIM</th> <th>ALM</th><th>90u</th> <th>180u</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th><th>K2O</th> <th>Na2O</th> <th>Cl2</th>
					</tr>
				</thead>

				<?php
				if(isset($_GET['bulan'])){
				    $bulan = $_GET['bulan'];
				    $sql = "SELECT * FROM lpb_2024 WHERE  DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
				} else { 
					$tgl = date('Y-m'); 
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							
					        $w_sdlsfr1 = '';
					        if ($d['SDLSF_r1'] > 6) {
					            $w_sdlsfr1 = 'text-danger';
					        } $w_lsfr1 = '';
					        if ($d['LSF_r1'] < 91 || $d['LSF_r1'] > 107) {
					            $w_lsfr1 = 'text-danger';
					        } $w_h2or1 = '';
					        if ($d['H2O_r1'] < 0.3 || $d['H2O_r1'] > 0.7) {
					            $w_h2or1 = 'text-danger';
					        }$w_180ur1 = '';
					        if ($d['r1180u'] > 3) {
					            $w_180ur1 = 'text-danger';
					        }$w_90ur1 = '';
					        if ($d['r190u'] > 20) {
					            $w_90ur1 = 'text-danger';
					        } $w_almr1 = '';
					        if ($d['ALM_r1'] < 1.3 || $d['ALM_r1'] > 1.9) {
					            $w_almr1 = 'text-danger';
					        }$w_simr1 = '';
					        if ($d['SIM_r1'] < 2 || $d['SIM_r1'] > 2.6) {
					            $w_simr1 = 'text-danger';
					        }
					        
						?>
 
					    <tr>
					        <td><?php echo $d['TANGGAL']; ?></td>
					        <td class="<?php echo $w_lsfr1; ?>"><?php echo $d['LSF_r1']; ?></td>
					        <td class="<?php echo $w_simr1; ?>"><?php echo $d['SIM_r1']; ?></td>
					        <td class="<?php echo $w_almr1; ?>"><?php echo $d['ALM_r1']; ?></td>
					        <td class="<?php echo $w_90ur1; ?>"><?php echo $d['r190u']; ?></td>
					        <td class="<?php echo $w_180ur1; ?>"><?php echo $d['r1180u']; ?></td>
					        <td class="<?php echo $w_h2or1; ?>"><?php echo $d['H2O_r1']; ?></td>
					        <td class="<?php echo $w_sdlsfr1; ?>"><?php echo $d['SDLSF_r1']; ?></td>
					        <td><?php echo $d['COUNTLSF_r1']; ?></td>
					        <td><?php echo $d['SiO2_r1']; ?></td>
					        <td><?php echo $d['Al2O3_r1']; ?></td>
					        <td><?php echo $d['Fe2O3_r1']; ?></td>
					        <td><?php echo $d['CaO_r1']; ?></td>
					        <td><?php echo $d['MgO_r1']; ?></td>
					        <td><?php echo $d['SO3_r1']; ?></td>
					        <td><?php echo $d['K2O_r1']; ?></td>
					        <td><?php echo $d['Na2O_r1']; ?></td>
					        <td><?php echo $d['Cl2_r1']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>
    <h7 class="text-center">2. RAWMIX 5R2</h7>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			           <th colspan="1"></th><th colspan="3"> MODULUS FACTOR</th><th colspan="2">SIEVE ON</th><th rowspan="2" >H2O</th><th rowspan="2">SD LSF</th><th rowspan="2">COUNT</th><th colspan="9"> OKSIDA</th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>TANGGAL</th>  <th>LSF</th> <th>SIM</th> <th>ALM</th><th>90u</th> <th>180u</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th><th>K2O</th> <th>Na2O</th> <th>Cl2</th>
					</tr>
				</thead>

				<?php
				if(isset($_GET['bulan'])){
				    $bulan = $_GET['bulan'];
				    $sql = "SELECT * FROM lpb_2024 WHERE  DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
				} else { 
					$tgl = date('Y-m'); 
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							
					        $w_sdlsfr2 = '';
					        if ($d['SDLSF_r2'] > 6) {
					            $w_sdlsfr2 = 'text-danger';
					        } $w_lsfr2 = '';
					        if ($d['LSF_r2'] < 91 || $d['LSF_r2'] > 107) {
					            $w_lsfr2 = 'text-danger';
					        } $w_h2or2 = '';
					        if ($d['H2O_r2'] < 0.3 || $d['H2O_r2'] > 0.7) {
					            $w_h2or2 = 'text-danger';
					        }$w_180ur2 = '';
					        if ($d['r2180u'] > 3) {
					            $w_180ur2 = 'text-danger';
					        }$w_90ur2 = '';
					        if ($d['r290u'] > 20) {
					            $w_90ur2 = 'text-danger';
					        } $w_almr2 = '';
					        if ($d['ALM_r2'] < 1.3 || $d['ALM_r2'] > 1.9) {
					            $w_almr2 = 'text-danger';
					        }$w_simr2 = '';
					        if ($d['SIM_r2'] < 2 || $d['SIM_r2'] > 2.6) {
					            $w_simr2 = 'text-danger';
					        }
					        
						?>
 
					    <tr>
					        <td><?php echo $d['TANGGAL']; ?></td>
					        <td class="<?php echo $w_lsfr2; ?>"><?php echo $d['LSF_r2']; ?></td>
					        <td class="<?php echo $w_simr2; ?>"><?php echo $d['SIM_r2']; ?></td>
					        <td class="<?php echo $w_almr2; ?>"><?php echo $d['ALM_r2']; ?></td>
					        <td class="<?php echo $w_90ur2; ?>"><?php echo $d['r290u']; ?></td>
					        <td class="<?php echo $w_180ur2; ?>"><?php echo $d['r2180u']; ?></td>
					        <td class="<?php echo $w_h2or2; ?>"><?php echo $d['H2O_r2']; ?></td>
					        <td class="<?php echo $w_sdlsfr2; ?>"><?php echo $d['SDLSF_r2']; ?></td>
					        <td><?php echo $d['COUNTLSF_r2']; ?></td>
					        <td><?php echo $d['SiO2_r2']; ?></td>
					        <td><?php echo $d['Al2O3_r2']; ?></td>
					        <td><?php echo $d['Fe2O3_r2']; ?></td>
					        <td><?php echo $d['CaO_r2']; ?></td>
					        <td><?php echo $d['MgO_r2']; ?></td>
					        <td><?php echo $d['SO3_r2']; ?></td>
					        <td><?php echo $d['K2O_r2']; ?></td>
					        <td><?php echo $d['Na2O_r2']; ?></td>
					        <td><?php echo $d['Cl2_r2']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>
    <h7 class="text-center">3. KILN FEED</h7>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			           <th colspan="1"></th><th colspan="3"> MODULUS FACTOR</th><th colspan="2">SIEVE ON</th><th rowspan="2" >H2O</th><th rowspan="2">SD LSF</th><th colspan="9"> OKSIDA</th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>TANGGAL</th>  <th>LSF</th> <th>SIM</th> <th>ALM</th><th>90u</th> <th>180u</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th><th>K2O</th> <th>Na2O</th> <th>Cl2</th>
					</tr>
				</thead>

				<?php
				if(isset($_GET['bulan'])){
				    $bulan = $_GET['bulan'];
				    $sql = "SELECT * FROM lpb_2024 WHERE  DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
				} else {  
					$tgl = date('Y-m');
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							
					        $w_sdlsfkf = '';
					        if ($d['SDLSF_kf'] > 2.5) {
					            $w_sdlsfkf = 'text-danger';
					        } $w_lsfkf = '';
					        if ($d['LSF_kf'] < 97 || $d['LSF_kf'] > 101) {
					            $w_lsfkf = 'text-danger';
					        } $w_h2okf = '';
					        if ($d['H2O_kf'] < 0.3 || $d['H2O_kf'] > 0.7) {
					            $w_h2okf = 'text-danger';
					        }$w_180ukf = '';
					        if ($d['kf180u'] > 3) {
					            $w_180ukf = 'text-danger';
					        }$w_90ukf = '';
					        if ($d['kf90u'] > 20) {
					            $w_90ukf = 'text-danger';
					        } $w_almkf = '';
					        if ($d['ALM_kf'] < 1.3 || $d['ALM_kf'] > 1.9) {
					            $w_almkf = 'text-danger';
					        }$w_simkf = '';
					        if ($d['SIM_kf'] < 2 || $d['SIM_kf'] > 2.6) {
					            $w_simkf = 'text-danger';
					        }
					        
						?>
 
					    <tr>
					        <td><?php echo $d['TANGGAL']; ?></td>
					        <td class="<?php echo $w_lsfkf; ?>"><?php echo $d['LSF_kf']; ?></td>
					        <td class="<?php echo $w_simkf; ?>"><?php echo $d['SIM_kf']; ?></td>
					        <td class="<?php echo $w_almkf; ?>"><?php echo $d['ALM_kf']; ?></td>
					        <td class="<?php echo $w_90ukf; ?>"><?php echo $d['kf90u']; ?></td>
					        <td class="<?php echo $w_180ukf; ?>"><?php echo $d['kf180u']; ?></td>
					        <td class="<?php echo $w_h2okf; ?>"><?php echo $d['H2O_kf']; ?></td>
					        <td class="<?php echo $w_sdlsfkf; ?>"><?php echo $d['SDLSF_kf']; ?></td>
					        <td><?php echo $d['SiO2_kf']; ?></td>
					        <td><?php echo $d['Al2O3_kf']; ?></td>
					        <td><?php echo $d['Fe2O3_kf']; ?></td>
					        <td><?php echo $d['CaO_kf']; ?></td>
					        <td><?php echo $d['MgO_kf']; ?></td>
					        <td><?php echo $d['SO3_kf']; ?></td>
					        <td><?php echo $d['K2O_kf']; ?></td>
					        <td><?php echo $d['Na2O_kf']; ?></td>
					        <td><?php echo $d['Cl2_kf']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>
    <h7 class="text-center">4. CLINKER</h7>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			           <th colspan="1"></th><th colspan="2">Standar Deviasi</th><th colspan="2"></th><th colspan="5"> MODULUS FACTOR</th><th colspan="2">QAF</th><th colspan="9"> OKSIDA</th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>TANGGAL</th> <th>LSF</th> <th>C3S</th> <th>LTW</th> <th>F.Lime</th><th>LSF</th> <th>SIM</th> <th>ALM</th><th>C3S</th><th>C3A</th><th>FL</th><th>C3S</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th><th>K2O</th> <th>Na2O</th> <th>Cl2</th>
					</tr>
				</thead>

				<?php
				if(isset($_GET['bulan'])){
				    $bulan = $_GET['bulan'];
				    $sql = "SELECT * FROM lpb_2024 WHERE  DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
				} else { 
					$tgl = date('Y-m');
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							
					        $w_flimecr = '';
					        if ($d['FLIME_cr'] > 1.8) {
					            $w_flimecr = 'text-danger';
					        } $w_c3acr = '';
					        if ($d['C3A_cr'] > 7 || $d['C3A_cr'] < 11) {
					            $w_c3acr = 'text-danger';
					        } $w_lsfcr = '';
					        if ($d['LSF_cr'] < 95 || $d['LSF_cr'] > 100) {
					            $w_lsfcr = 'text-danger';
					        }$w_c3scr = '';
					        if ($d['C3S_cr'] < 56) {
					            $w_c3scr = 'text-danger';
					        } $w_almcr = '';
					        if ($d['ALM_cr'] < 1.3 || $d['ALM_cr'] > 1.9) {
					            $w_almcr = 'text-danger';
					        }$w_simcr = '';
					        if ($d['SIM_cr'] < 2 || $d['SIM_cr'] > 2.6) {
					            $w_simcr = 'text-danger';
					        }$w_ltwcr = '';
					        if ($d['LTW_cr'] < 1050 || $d['LTW_cr'] > 1250) {
					            $w_ltwcr = 'text-danger';
					        }
					        
						?>
 
					    <tr>
					        <td><?php echo $d['TANGGAL']; ?></td>
					        <td><?php echo $d['SDLSF_cr']; ?></td>
					        <td><?php echo $d['SDC3S_cr']; ?></td>
					        <td class="<?php echo $w_ltwcr; ?>"><?php echo $d['LTW_cr']; ?></td>
					        <td class="<?php echo $w_flimecr; ?>"><?php echo $d['FLIME_cr']; ?></td>
					        <td class="<?php echo $w_lsfcr; ?>"><?php echo $d['LSF_cr']; ?></td>
					        <td class="<?php echo $w_simcr; ?>"><?php echo $d['SIM_cr']; ?></td>
					        <td class="<?php echo $w_almcr; ?>"><?php echo $d['ALM_cr']; ?></td>
					        <td class="<?php echo $w_c3scr; ?>"><?php echo $d['C3S_cr']; ?></td>
					        <td class="<?php echo $w_c3acr; ?>"><?php echo $d['C3A_cr']; ?></td>
					        <td><?php echo $d['FL_QAFcr']; ?></td>
					        <td><?php echo $d['C3S_QAFcr']; ?></td>
					        <td><?php echo $d['SiO2_cr']; ?></td>
					        <td><?php echo $d['Al2O3_cr']; ?></td>
					        <td><?php echo $d['Fe2O3_cr']; ?></td>
					        <td><?php echo $d['CaO_cr']; ?></td>
					        <td><?php echo $d['MgO_cr']; ?></td>
					        <td><?php echo $d['SO3_cr']; ?></td>
					        <td><?php echo $d['K2O_cr']; ?></td>
					        <td><?php echo $d['Na2O_cr']; ?></td>
					        <td><?php echo $d['Cl2_cr']; ?></td>
					    </tr>
					<?php
					}
					?>
					
    </table>
    <a href="?page=RM&bulan=<?php echo isset($bulan) ? $bulan : ''; ?>" class="btn btn-primary">Previous Page</a>
    <a href="?page=produk2&bulan=<?php echo isset($bulan) ? $bulan : ''; ?>" class="btn btn-primary">Next Page</a>

    <?php elseif ($page == 'produk2') : ?>
	<h5 class="text-center">LAPORAN BULANAN KUALITAS  PRODUK  PABRIK  INDARUNG  V</h5>
			<h7 class="text-center">1. FINE COAL & Raw Coal</h7>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			           <th colspan="1"></th><th colspan="1"> Raw Coal</th><th colspan="4">Fine Coal</th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>TANGGAL</th>  <th>H2O</th> <th>90u</th> <th>H2O</th><th>ASH</th> <th>SD ASH</th>
					</tr>
				</thead>

				<?php
				if(isset($_GET['bulan'])){
				    $bulan = $_GET['bulan'];
				    $sql = "SELECT * FROM lpb_2024 WHERE  DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
				} else {  
					$tgl = date('Y-m');
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							
					        $w_fch2o = '';
					        if ($d['fcH2O_fc'] > 20) {
					            $w_fch2o = 'text-danger';
					        } $w_ashfc = '';
					        if ($d['ASH_fc'] > 20) {
					            $w_ashfc = 'text-danger';
					        } $w_90ufc = '';
					        if ($d['fc90u'] > 30) {
					            $w_90ufc = 'text-danger';
					        } $w_h2orc = '';
					        if ($d['rcH2O_fc'] > 40) {
					            $w_h2orc = 'text-danger';
					        }
					        
						?>
 
					    <tr>
					        <td><?php echo $d['TANGGAL']; ?></td>
					        <td class="<?php echo $w_h2orc; ?>"><?php echo $d['rcH2O_fc']; ?></td>
					        <td class="<?php echo $w_90ufc; ?>"><?php echo $d['fc90u']; ?></td>
					        <td class="<?php echo $w_fch2o; ?>"><?php echo $d['fcH2O_fc']; ?></td>
					        <td class="<?php echo $w_ashfc; ?>"><?php echo $d['ASH_fc']; ?></td>
					        <td><?php echo $d['SDASH_fc']; ?></td>
					<?php
					}
					?>
					
    </table>
     <h7 class="text-center">2.CEMENT  MILL  5Z1 (OPC)</h7>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			           <th colspan="1"></th><th colspan="4"></th><th colspan="9"> OKSIDA</th><th colspan="1"></th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>TANGGAL</th> <th>BLAINE</th> <th>SO3</th> <th>45u</th> <th>LOI</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>FCaO</th><th>COUNT</th>
					</tr>
				</thead>

				<?php
				if(isset($_GET['bulan'])){
				    $bulan = $_GET['bulan'];
				    $sql = "SELECT * FROM lpb_2024 WHERE  DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
				} else {  
					$tgl = date('Y-m');
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							
					        $w_loiopc = '';
					        if ($d['LOI_z1opc'] > 5) {
					            $w_loiopc = 'text-danger';
					        }  $w_45uopc = '';
					        if ($d['z145u_opc'] > 8) {
					            $w_45uopc = 'text-danger';
					        }$w_so3opc = '';
					        if ($d['SO3_z1opc'] < 1 || $d['SO3_z1opc'] > 3) {
					            $w_so3opc = 'text-danger';
					        } $w_blaineopc = '';
					        if ($d['BLAINE_z1opc'] < 320) {
					            $w_blaineopc = 'text-danger';
					        }
					        
						?>
 
					    <tr>
					        <td><?php echo $d['TANGGAL']; ?></td>
					        <td class="<?php echo $w_blaineopc; ?>"><?php echo $d['BLAINE_z1opc']; ?></td>
					        <td class="<?php echo $w_so3opc; ?>"><?php echo $d['SO3_z1opc']; ?></td>
					        <td class="<?php echo $w_45uopc; ?>"><?php echo $d['z145u_opc']; ?></td>
					        <td class="<?php echo $w_loiopc; ?>"><?php echo $d['LOI_z1opc']; ?></td>
					        <td><?php echo $d['SiO2_z1opc']; ?></td>
					        <td><?php echo $d['Al2O3_z1opc']; ?></td>
					        <td><?php echo $d['Fe2O3_z1opc']; ?></td>
					        <td><?php echo $d['CaO_z1opc']; ?></td>
					        <td><?php echo $d['MgO_z1opc']; ?></td>
					        <td><?php echo $d['K2O_z1opc']; ?></td>
					        <td><?php echo $d['Na2O_z1opc']; ?></td>
					        <td><?php echo $d['Cl2_z1opc']; ?></td>
					        <td><?php echo $d['FCaO_z1opc']; ?></td>
					        <td><?php echo $d['COUNT_z1opc']; ?></td>


					    </tr>
					<?php
					}
					?>
					
    </table>
    <h7 class="text-center">3.CEMENT  MILL  5Z1 (PCC)</h7>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			           <th colspan="1"></th><th colspan="4"></th><th colspan="9"> OKSIDA</th><th colspan="1"></th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>TANGGAL</th> <th>BLAINE</th> <th>SO3</th> <th>45u</th> <th>LOI</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>FCaO</th><th>COUNT</th>
					</tr>
				</thead>

				<?php
				if(isset($_GET['bulan'])){
				    $bulan = $_GET['bulan'];
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
				} else {  
					$tgl = date('Y-m');
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							
					        $w_loipcc = '';
					        if ($d['LOI_z1pcc'] > 20) {
					            $w_loipcc = 'text-danger';
					        } $w_fcaopcc = '';
					        if ($d['FCaO_z1pcc'] > 1.5) {
					            $w_fcaopcc = 'text-danger';
					        }  $w_45upcc = '';
					        if ($d['z145u_pcc'] > 8) {
					            $w_45upcc = 'text-danger';
					        }$w_so3pcc = '';
					        if ($d['SO3_z1pcc'] < 1 || $d['SO3_z1pcc'] > 4) {
					            $w_so3pcc = 'text-danger';
					        } $w_blainepcc = '';
					        if ($d['BLAINE_z1pcc'] < 400 || $d['BLAINE_z1pcc'] > 500) {
					            $w_blainepcc = 'text-danger';
					        }
					        
						?>
 
					    <tr>
					        <td><?php echo $d['TANGGAL']; ?></td>
					        <td class="<?php echo $w_blainepcc; ?>"><?php echo $d['BLAINE_z1pcc']; ?></td>
					        <td class="<?php echo $w_so3pcc; ?>"><?php echo $d['SO3_z1pcc']; ?></td>
					        <td class="<?php echo $w_45upcc; ?>"><?php echo $d['z145u_pcc']; ?></td>
					        <td class="<?php echo $w_loipcc; ?>"><?php echo $d['LOI_z1pcc']; ?></td>
					        <td><?php echo $d['SiO2_z1pcc']; ?></td>
					        <td><?php echo $d['Al2O3_z1pcc']; ?></td>
					        <td><?php echo $d['Fe2O3_z1pcc']; ?></td>
					        <td><?php echo $d['CaO_z1pcc']; ?></td>
					        <td><?php echo $d['MgO_z1pcc']; ?></td>
					        <td><?php echo $d['K2O_z1pcc']; ?></td>
					        <td><?php echo $d['Na2O_z1pcc']; ?></td>
					        <td><?php echo $d['Cl2_z1pcc']; ?></td>
					        <td  class="<?php echo $w_fcaopcc; ?>"><?php echo $d['FCaO_z1pcc']; ?></td>
					        <td><?php echo $d['COUNT_z1pcc']; ?></td>


					    </tr>
					<?php
					}
					?>
					
    </table>
    <h7 class="text-center">4.CEMENT  MILL  5Z1 (PCC+)</h7>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			           <th colspan="1"></th><th colspan="4"></th><th colspan="9"> OKSIDA</th><th colspan="1"></th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>TANGGAL</th> <th>BLAINE</th> <th>SO3</th> <th>45u</th> <th>LOI</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>FCaO</th><th>COUNT</th>
					</tr>
				</thead>

				<?php
				if(isset($_GET['bulan'])){
				    $bulan = $_GET['bulan'];
				    $sql = "SELECT * FROM lpb_2024 WHERE  DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
				} else {  
					$tgl = date('Y-m');
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							
					        $w_loippc = '';
					        if ($d['LOI_z1ppc'] > 4.75) {
					            $w_loippc = 'text-danger';
					        } $w_fcaoppc = '';
					        if ($d['FCaO_z1ppc'] > 1.5) {
					            $w_fcaoppc = 'text-danger';
					        }  $w_45uppc = '';
					        if ($d['z145u_ppc'] > 10) {
					            $w_45uppc = 'text-danger';
					        }$w_so3ppc = '';
					        if ($d['SO3_z1ppc'] < 1.3 || $d['SO3_z1ppc'] > 2.3) {
					            $w_so3ppc = 'text-danger';
					        } $w_blaineppc = '';
					        if ($d['BLAINE_z1ppc'] < 360 ) {
					            $w_blaineppc = 'text-danger';
					        }
					        
						?>
 
					    <tr>
					        <td><?php echo $d['TANGGAL']; ?></td>
					        <td class="<?php echo $w_blaineppc; ?>"><?php echo $d['BLAINE_z1ppc']; ?></td>
					        <td class="<?php echo $w_so3ppc; ?>"><?php echo $d['SO3_z1ppc']; ?></td>
					        <td class="<?php echo $w_45uppc; ?>"><?php echo $d['z145u_ppc']; ?></td>
					        <td class="<?php echo $w_loippc; ?>"><?php echo $d['LOI_z1ppc']; ?></td>
					        <td><?php echo $d['SiO2_z1ppc']; ?></td>
					        <td><?php echo $d['Al2O3_z1ppc']; ?></td>
					        <td><?php echo $d['Fe2O3_z1ppc']; ?></td>
					        <td><?php echo $d['CaO_z1ppc']; ?></td>
					        <td><?php echo $d['MgO_z1ppc']; ?></td>
					        <td><?php echo $d['K2O_z1ppc']; ?></td>
					        <td><?php echo $d['Na2O_z1ppc']; ?></td>
					        <td><?php echo $d['Cl2_z1ppc']; ?></td>
					        <td  class="<?php echo $w_fcaoppc; ?>"><?php echo $d['FCaO_z1ppc']; ?></td>
					        <td><?php echo $d['COUNT_z1ppc']; ?></td>


					    </tr>
					<?php
					}
					?>
					
    </table>
     <h7 class="text-center">5.CEMENT  MILL  5Z2 (OPC)</h7>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			           <th colspan="1"></th><th colspan="4"></th><th colspan="9"> OKSIDA</th><th colspan="1"></th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>TANGGAL</th> <th>BLAINE</th> <th>SO3</th> <th>45u</th> <th>LOI</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>FCaO</th><th>COUNT</th>
					</tr>
				</thead>

				<?php
				if(isset($_GET['bulan'])){
				    $bulan = $_GET['bulan'];
				    $sql = "SELECT * FROM lpb_2024 WHERE  DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
				} else {  
					$tgl = date('Y-m');
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							
					        $w_loiopc = '';
					        if ($d['LOI_z2opc'] > 5) {
					            $w_loiopc = 'text-danger';
					        }  $w_45uopc = '';
					        if ($d['z245u_opc'] > 8) {
					            $w_45uopc = 'text-danger';
					        }$w_so3opc = '';
					        if ($d['SO3_z2opc'] < 1 || $d['SO3_z2opc'] > 3) {
					            $w_so3opc = 'text-danger';
					        } $w_blaineopc = '';
					        if ($d['BLAINE_z2opc'] < 320) {
					            $w_blaineopc = 'text-danger';
					        }
					        
						?>
 
					    <tr>
					        <td><?php echo $d['TANGGAL']; ?></td>
					        <td class="<?php echo $w_blaineopc; ?>"><?php echo $d['BLAINE_z2opc']; ?></td>
					        <td class="<?php echo $w_so3opc; ?>"><?php echo $d['SO3_z2opc']; ?></td>
					        <td class="<?php echo $w_45uopc; ?>"><?php echo $d['z245u_opc']; ?></td>
					        <td class="<?php echo $w_loiopc; ?>"><?php echo $d['LOI_z2opc']; ?></td>
					        <td><?php echo $d['SiO2_z2opc']; ?></td>
					        <td><?php echo $d['Al2O3_z2opc']; ?></td>
					        <td><?php echo $d['Fe2O3_z2opc']; ?></td>
					        <td><?php echo $d['CaO_z2opc']; ?></td>
					        <td><?php echo $d['MgO_z2opc']; ?></td>
					        <td><?php echo $d['K2O_z2opc']; ?></td>
					        <td><?php echo $d['Na2O_z2opc']; ?></td>
					        <td><?php echo $d['Cl2_z2opc']; ?></td>
					        <td><?php echo $d['FCaO_z2opc']; ?></td>
					        <td><?php echo $d['COUNT_z2opc']; ?></td>


					    </tr>
					<?php
					}
					?>
					
    </table>
    <h7 class="text-center">6.CEMENT  MILL  5Z2 (PCC)</h7>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			           <th colspan="1"></th><th colspan="4"></th><th colspan="9"> OKSIDA</th><th colspan="1"></th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>TANGGAL</th> <th>BLAINE</th> <th>SO3</th> <th>45u</th> <th>LOI</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>FCaO</th><th>COUNT</th>
					</tr>
				</thead>

				<?php
				if(isset($_GET['bulan'])){
				    $bulan = $_GET['bulan'];
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
				} else {  
					$tgl = date('Y-m');
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							
					        $w_loipcc = '';
					        if ($d['LOI_z2pcc'] > 20) {
					            $w_loipcc = 'text-danger';
					        } $w_fcaopcc = '';
					        if ($d['FCaO_z2pcc'] > 1.5) {
					            $w_fcaopcc = 'text-danger';
					        }  $w_45upcc = '';
					        if ($d['z245u_pcc'] > 8) {
					            $w_45upcc = 'text-danger';
					        }$w_so3pcc = '';
					        if ($d['SO3_z2pcc'] < 1 || $d['SO3_z2pcc'] > 4) {
					            $w_so3pcc = 'text-danger';
					        } $w_blainepcc = '';
					        if ($d['BLAINE_z2pcc'] < 400 || $d['BLAINE_z2pcc'] > 500) {
					            $w_blainepcc = 'text-danger';
					        }
					        
						?>
 
					    <tr>
					        <td><?php echo $d['TANGGAL']; ?></td>
					        <td class="<?php echo $w_blainepcc; ?>"><?php echo $d['BLAINE_z2pcc']; ?></td>
					        <td class="<?php echo $w_so3pcc; ?>"><?php echo $d['SO3_z2pcc']; ?></td>
					        <td class="<?php echo $w_45upcc; ?>"><?php echo $d['z245u_pcc']; ?></td>
					        <td class="<?php echo $w_loipcc; ?>"><?php echo $d['LOI_z2pcc']; ?></td>
					        <td><?php echo $d['SiO2_z2pcc']; ?></td>
					        <td><?php echo $d['Al2O3_z2pcc']; ?></td>
					        <td><?php echo $d['Fe2O3_z2pcc']; ?></td>
					        <td><?php echo $d['CaO_z2pcc']; ?></td>
					        <td><?php echo $d['MgO_z2pcc']; ?></td>
					        <td><?php echo $d['K2O_z2pcc']; ?></td>
					        <td><?php echo $d['Na2O_z2pcc']; ?></td>
					        <td><?php echo $d['Cl2_z2pcc']; ?></td>
					        <td  class="<?php echo $w_fcaopcc; ?>"><?php echo $d['FCaO_z2pcc']; ?></td>
					        <td><?php echo $d['COUNT_z2pcc']; ?></td>


					    </tr>
					<?php
					}
					?>
					
    </table>
    <h7 class="text-center">7.CEMENT  MILL  5Z2 (PCC+)</h7>
			 <table class="table table-striped table-bordered table-hover" >
				<thead>

					<tr class="text-center" >
			           <th colspan="1"></th><th colspan="4"></th><th colspan="9"> OKSIDA</th><th colspan="1"></th>
			        </tr>

					<tr class="bg-primary text-white">
						
						<th>TANGGAL</th> <th>BLAINE</th> <th>SO3</th> <th>45u</th> <th>LOI</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>FCaO</th><th>COUNT</th>
					</tr>
				</thead>

				<?php
				if(isset($_GET['bulan'])){
				    $bulan = $_GET['bulan'];
				    $sql = "SELECT * FROM lpb_2024 WHERE  DATE_FORMAT(TANGGAL, '%Y-%m') = '$bulan'";
				} else {  
					$tgl = date('Y-m');
				    $sql = "SELECT * FROM lpb_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";
				}     
				$q = mysqli_query($conn, $sql);
				while ($d = mysqli_fetch_array($q)) {
							
					        $w_loippc = '';
					        if ($d['LOI_z2ppc'] > 4.75) {
					            $w_loippc = 'text-danger';
					        } $w_fcaoppc = '';
					        if ($d['FCaO_z2ppc'] > 1.5) {
					            $w_fcaoppc = 'text-danger';
					        }  $w_45uppc = '';
					        if ($d['z245u_ppc'] > 10) {
					            $w_45uppc = 'text-danger';
					        }$w_so3ppc = '';
					        if ($d['SO3_z2ppc'] < 1.3 || $d['SO3_z2ppc'] > 2.3) {
					            $w_so3ppc = 'text-danger';
					        } $w_blaineppc = '';
					        if ($d['BLAINE_z2ppc'] < 360 ) {
					            $w_blaineppc = 'text-danger';
					        }
					        
						?>
 
					    <tr>
					        <td><?php echo $d['TANGGAL']; ?></td>
					        <td class="<?php echo $w_blaineppc; ?>"><?php echo $d['BLAINE_z2ppc']; ?></td>
					        <td class="<?php echo $w_so3ppc; ?>"><?php echo $d['SO3_z2ppc']; ?></td>
					        <td class="<?php echo $w_45uppc; ?>"><?php echo $d['z245u_ppc']; ?></td>
					        <td class="<?php echo $w_loippc; ?>"><?php echo $d['LOI_z2ppc']; ?></td>
					        <td><?php echo $d['SiO2_z2ppc']; ?></td>
					        <td><?php echo $d['Al2O3_z2ppc']; ?></td>
					        <td><?php echo $d['Fe2O3_z2ppc']; ?></td>
					        <td><?php echo $d['CaO_z2ppc']; ?></td>
					        <td><?php echo $d['MgO_z2ppc']; ?></td>
					        <td><?php echo $d['K2O_z2ppc']; ?></td>
					        <td><?php echo $d['Na2O_z2ppc']; ?></td>
					        <td><?php echo $d['Cl2_z2ppc']; ?></td>
					        <td  class="<?php echo $w_fcaoppc; ?>"><?php echo $d['FCaO_z2ppc']; ?></td>
					        <td><?php echo $d['COUNT_z2ppc']; ?></td>


					    </tr>
					<?php
					}
					?>
					
    </table>
    <a href="?page=produk&bulan=<?php echo isset($bulan) ? $bulan : ''; ?>" class="btn btn-primary">Previous Page</a>

    <?php endif; ?>
</div>



		

					        
  
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