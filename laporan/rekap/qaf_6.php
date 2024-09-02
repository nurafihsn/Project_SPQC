<?php
session_start();
$level = strtoupper($_SESSION['level']);
if ($level == NULL) echo "<script>window.location = '../index.php'</script>";
include "../../include/database_ind6.php";
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
	 <h2 class="text-center">QAF</h2>
    <h2 class="text-center mb-5">PABRIK INDARUNG VI</h2>
    <form method="get" class="mb-3">
        <label>PILIH BULAN: </label>
        <input type="month" name="bulan">
        <input class="btn btn-primary" type="submit" value="FILTER">
    </form>

    <h3 class="text-center">
        <?php
        if (isset($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
            echo "<label>QAF : $bulan</label>";
        }
        ?>
    </h3>

    <table class="adminlist mb-3" border="1" width="500" cellpadding="5">
        <thead>
            <tr class="text-center">
                <th colspan="2">SIEVE RX</th>
                <th colspan="2">Deviasi LSF</th>
                <th colspan="4">CLINKER</th>
                <th colspan="4">OPC 6Z1</th>
                <th colspan="4">PCC 6Z1</th>
            </tr>
            <tr bgcolor="#8080FF" style="color:#FFFFFF">
                <th>S90</th><th>S180</th><th>RX</th><th>KF</th><th>C3S</th><th>LSF</th><th>C3A</th><th>FCaO</th><th>SO3</th><th>LOI</th><th>Blaine</th><th>SIEVE</th><th>SO3</th><th>LOI</th><th>Blaine</th><th>SIEVE</th>
            </tr>
        </thead>
        <tbody>
            <tr bgcolor="YELLOW" style="color:BLACK">
            	<?php
            	if (isset($_GET['bulan'])) {
				        $bulan = $_GET['bulan']; 
				    } else {
				        $bulan = date('Y-m'); 				 
				           }
				    $count_query = mysqli_query($conn, "
				        SELECT 
				            COUNT(lhk.r190u) AS count_r190u, 
				            COUNT(lhk.r1180u) AS count_r1180u, 
				            COUNT(lpb.SDLSF_r1) AS count_sdlsfr1, 
				            COUNT(lpb.SDLSF_kf) AS count_sdlsfkf, 
				            COUNT(lhk.C3S_cr) AS count_c3scr, 
				            COUNT(lhk.LSF_cr) AS count_lsfcr, 
				            COUNT(lhk.C3A_cr) AS count_c3acr, 
				            COUNT(lhk.FLIME_cr) AS count_fcaocr, 
				            COUNT(lhk.SO3_z1opc) AS count_so3opc, 
				            COUNT(lhk.LOI_z1opc) AS count_loiopc, 
				            COUNT(lhk.BLAINE_z1pcc) AS count_blaineopc, 
				            COUNT(lhk.LOI_z1opc) AS count_sievingopc, 
				            COUNT(lhk.SO3_z1pcc) AS count_so3pcc, 
				            COUNT(lhk.LOI_z1pcc) AS count_loipcc, 
				            COUNT(lhk.BLAINE_z1pcc) AS count_blainepcc,
				            COUNT(lhk.LOI_z1pcc) AS count_sievingpcc 
				        FROM lhk_2024 lhk 
				        JOIN lpb_2024 lpb ON lhk.TANGGAL = lpb.TANGGAL 
				        WHERE lhk.TANGGAL LIKE '$bulan%' AND lpb.TANGGAL LIKE '$bulan%'
				    ");


				    $count_result = mysqli_fetch_assoc($count_query);
				    foreach ($count_result as $count) {
				        $display_value = ' ';
				        if ($count > 0) {
				            $display_value = number_format(floatval($count));
				        } else {
				            $display_value = '';
				        }
				    }
				    ?>
                 <?php
				  if (isset($_GET['bulan'])) {
				        $bulan = $_GET['bulan']; 
				    } else {
				        $bulan = date('Y-m'); 				 
				           }
			        $datain_query = mysqli_query($conn, "SELECT 
			            COUNT(IF(lhk.r190u <= 20, 1, NULL)) AS datain_r190u,
			            COUNT(IF(lhk.r1180u <= 3, 1, NULL)) AS datain_r1180u,
			            COUNT(IF(lpb.SDLSF_r1 <= 6, 1, NULL)) AS datain_sdlsfr1,
			            COUNT(IF(lpb.SDLSF_kf <= 2 , 1, NULL)) AS datain_sdlsfkf,
			            COUNT(IF(lhk.C3S_cr >= 56, 1, NULL)) AS datain_c3scr,
			            COUNT(IF(lhk.LSF_cr > 100 , 1, NULL)) AS datain_lsfcrmax,
			            COUNT(IF(lhk.LSF_cr < 95 , 1, NULL)) AS datain_lsfcrmin,
			            COUNT(IF(lhk.C3A_cr > 11, 1, NULL)) AS datain_c3acrmax,
			            COUNT(IF(lhk.C3A_cr < 7, 1, NULL)) AS datain_c3acrmin,
			            COUNT(IF(lhk.FLIME_cr <= 1.8 , 1, NULL)) AS datain_fcaocr,
			            COUNT(IF(lhk.SO3_z1opc > 3, 1, NULL)) AS datain_so3opcmax,
			            COUNT(IF(lhk.SO3_z1opc < 1, 1, NULL)) AS datain_so3opcmin,
			            COUNT(IF(lhk.LOI_z1opc <= 5 , 1, NULL)) AS datain_loiopc,
			            COUNT(IF(lhk.BLAINE_z1pcc >= 320, 1, NULL)) AS datain_blaineopc,
			            COUNT(IF(lhk.LOI_z1opc <= 5, 1, NULL)) AS datain_sievingopc,
			            COUNT(IF(lhk.SO3_z1pcc > 5, 1, NULL)) AS datain_so3pccmax,
			            COUNT(IF(lhk.SO3_z1pcc < 1, 1, NULL)) AS datain_so3pccmin,
			            COUNT(IF(lhk.LOI_z1pcc <= '', 1, NULL)) AS datain_loipcc,
			            COUNT(IF(lhk.BLAINE_z1pcc >= 500 , 1, NULL)) AS datain_blainepccmax,
			            COUNT(IF(lhk.BLAINE_z1pcc <= 400 , 1, NULL)) AS datain_blainepccmin,
			            COUNT(IF(lhk.LOI_z1pcc <= '', 1, NULL)) AS datain_sievingpcc
			            FROM lhk_2024 lhk 
					    JOIN lpb_2024 lpb ON lhk.TANGGAL = lpb.TANGGAL 
					    WHERE lhk.TANGGAL like '$bulan%' AND lpb.TANGGAL like '$bulan%'");

			        $datain_result = mysqli_fetch_assoc($datain_query);
			        
			        
			        $kolom = array("r190u", "r1180u", "sdlsfr1", "sdlsfkf" ,  "c3scr", "lsfcr", "c3acr", "fcaocr", "so3opc", "loiopc", "blaineopc", "sievingopc", "so3pcc", "loipcc", "blainepcc", "sievingpcc");
			        foreach ($kolom as $nama_kolom) {

				        $count = $count_result["count_" . strtolower($nama_kolom)];
			            $datain_r190u = isset($datain_result["datain_r190u"]) ? $datain_result["datain_r190u"] : 0;
			            $datain_r1180u = isset($datain_result["datain_r1180u"]) ? $datain_result["datain_r1180u"] : 0;
			            $datain_sdlsfr1 = isset($datain_result["datain_sdlsfr1"]) ? $datain_result["datain_sdlsfr1"] : 0;
			            $datain_sdlsfkf = isset($datain_result["datain_sdlsfkf"]) ? $datain_result["datain_sdlsfkf"] : 0;
			            $datain_c3scr = isset($datain_result["datain_c3scr"]) ? $datain_result["datain_c3scr"] : 0;
			            $datain_lsfcrmax = isset($datain_result["datain_lsfcrmax"]) ? $datain_result["datain_lsfcrmax"] : 0;
			            $datain_lsfcrmin = isset($datain_result["datain_lsfcrmin"]) ? $datain_result["datain_lsfcrmin"] : 0;
			            $datain_c3acrmax = isset($datain_result["datain_c3acrmax"]) ? $datain_result["datain_c3acrmax"] : 0;
			            $datain_c3acrmin = isset($datain_result["datain_c3acrmin"]) ? $datain_result["datain_c3acrmin"] : 0;
			            $datain_fcaocr = isset($datain_result["datain_fcaocr"]) ? $datain_result["datain_fcaocr"] : 0;
			            $datain_so3opcmax = isset($datain_result["datain_so3opcmax"]) ? $datain_result["datain_so3opcmax"] : 0;
			            $datain_so3opcmin = isset($datain_result["datain_so3opcmin"]) ? $datain_result["datain_so3opcmin"] : 0;
			            $datain_loiopc = isset($datain_result["datain_loiopc"]) ? $datain_result["datain_loiopc"] : 0;
			            $datain_blaineopc = isset($datain_result["datain_blaineopc"]) ? $datain_result["datain_blaineopc"] : 0;
			            $datain_sievingopc = isset($datain_result["datain_sievingopc"]) ? $datain_result["datain_sievingopc"] : 0;
			            $datain_so3pccmax = isset($datain_result["datain_so3pccmax"]) ? $datain_result["datain_so3pccmax"] : 0;
			            $datain_so3pccmin = isset($datain_result["datain_so3pccmin"]) ? $datain_result["datain_so3pccmin"] : 0;
			            $datain_loipcc = isset($datain_result["datain_loipcc"]) ? $datain_result["datain_loipcc"] : 0;
			            $datain_blainepccmax = isset($datain_result["datain_blainepccmax"]) ? $datain_result["datain_blainepccmax"] : 0;
			            $datain_blainepccmin = isset($datain_result["datain_blainepccmin"]) ? $datain_result["datain_blainepccmin"] : 0;
			            $datain_sievingpcc = isset($datain_result["datain_sievingpcc"]) ? $datain_result["datain_sievingpcc"] : 0;
			            


			            if ($nama_kolom == "r190u") {
			                $hasil = $datain_r190u ;
			            } elseif ($nama_kolom == "r1180u") {
				            $hasil = $datain_r1180u ;
				        } elseif ($nama_kolom == "sdlsfr1") {
				            $hasil = $datain_sdlsfr1 ;
				        } elseif ($nama_kolom == "sdlsfkf") {
				            $hasil = $datain_sdlsfkf ;
				        } elseif ($nama_kolom == "c3scr") {
				            $hasil = $datain_c3scr ;
				        }  elseif ($nama_kolom == "lsfcr") {
				            $hasil = $count - $datain_lsfcrmax - $datain_lsfcrmin ;
				        }  elseif ($nama_kolom == "c3acr") {
				            $hasil = $count - $datain_c3acrmax - $datain_c3acrmin ;
				        }  elseif ($nama_kolom == "fcaocr") {
				            $hasil = $datain_fcaocr ;
				        } elseif ($nama_kolom == "so3opc") {
				            $hasil = $count - $datain_so3opcmax - $datain_so3opcmin ;
				        }  elseif ($nama_kolom == "loiopc") {
				            $hasil = $datain_loiopc ;
				        } elseif ($nama_kolom == "blaineopc") {
				            $hasil = $datain_blaineopc ;
				        }  elseif ($nama_kolom == "sievingopc") {
				            $hasil = $datain_sievingopc ;
				        } elseif ($nama_kolom == "so3pcc") {
				            $hasil = $count - $datain_so3pccmax - $datain_so3pccmin ;
				        }  elseif ($nama_kolom == "loipcc") {
				            $hasil = $datain_loipcc ;
				        } elseif ($nama_kolom == "blainepcc") {
				            $hasil = $count - $datain_blainepccmax - $datain_blainepccmin ;
				        } elseif ($nama_kolom == "sievingpcc") {
				            $hasil = $datain_sievingpcc ;
				        }

				     if ($count > 0 || $hasil > 0) {
			                $persentase = ($hasil / $count) * 100;
			                $css_class = '';
			                if ($nama_kolom == "r190u" || $nama_kolom == "r1180u"|| $nama_kolom == "sdlsfr1" || $nama_kolom == "sdlsfkf" || $nama_kolom == "c3scr" || $nama_kolom == "lsfcr" || $nama_kolom == "c3acr" ||  $nama_kolom == "fcaocr" || $nama_kolom == "so3opc" || $nama_kolom == "loiopc"|| $nama_kolom == "blaineopc" ||  $nama_kolom == "sievingopc" || $nama_kolom == "so3opc" || $nama_kolom == "loipcc"|| $nama_kolom == "blainepcc" ||  $nama_kolom == "sievingpcc"  ) {
						        if (floatval($persentase) < 85) {
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