<?php
session_start();
$level = strtoupper($_SESSION['level']);
if ($level == NULL) echo "<script>window.location = '../index.php'</script>";
include "../../include/database.php";
?>
<html>
<head>
   <title>R1 Indarung 5 <?php
    if(isset($_GET['awal']) && isset($_GET['akhir'])){
        $awal = $_GET['awal'];
        $akhir = $_GET['akhir'];
        echo "$awal Sampai $akhir";
    }
?>
  </title>
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
<div class="container">
    <h2> Raw Mix 1 Indarung 5</h2>
    <div class="data-tables datatable-dark">

        <form method="get">
            <label>PILIH TANGGAL</label>
            <input type="date" name="awal">
            <input type="date" name="akhir">
            <input type="submit" value="FILTER">
        </form>
        
        <!-- Masukkan table nya disini, dimulai dari tag TABLE -->
        <table class="table table-striped table-bordered table-hover" id="r1">
            <thead>
                <tr class="text-center" >
			            <th colspan="2"></th><th  colspan="6">5R1</th><th  colspan="4">Proposi Actual</th><th colspan="1">TON</th><th colspan="4">Setpoint QCX, %Wet</th><th colspan="4">Proporsi SET POINT</th> <th colspan="12">OKSIDA</th><th colspan="1">TON</th><th colspan="4">LS BACK</th>
			        </tr>
                <tr class="bg-primary text-white">
						
					<th>Tanggal</th><th>Jam</th><th>LSF</th> <th>SIM</th> <th>ALM</th> <th>90u</th><th>180u</th> <th>H2O</th><th>LS</th> <th>SS</th> <th>CL</th> <th>IS</th><th>dry</th><th>LS</th><th>SS</th><th>CL</th> <th>IS</th><th>LS</th> <th>SS</th> <th>CL</th> <th>IS</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th> <th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>SUM</th><th>Alkali</th><th>Emisi CO2</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>Report</th>
					</tr>
            </thead>
            <?php

            if(isset($_GET['awal']) && isset($_GET['akhir'])){
                $awal = $_GET['awal'];
                $akhir = $_GET['akhir'];
                $sql = "SELECT * FROM r1_5 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'";
                    } 
            else {  
                    $sql = "SELECT * FROM r1_5 WHERE TANGGAL = CURDATE() ";
                    }     
            $q = mysqli_query($conn, $sql);
            while ($d = mysqli_fetch_array($q)) {
                
                ?>
                <tr>   
                    			<td><?php echo htmlspecialchars($d['TANGGAL']); ?></td>
					            <td><?php echo htmlspecialchars($d['JAM']); ?></td>
					            <td><?php echo htmlspecialchars($d['LSF']); ?></td>
					            <td><?php echo htmlspecialchars($d['SIM']); ?></td>
					            <td><?php echo htmlspecialchars($d['ALM']); ?></td>
					            <td><?php echo htmlspecialchars($d['rm90u']); ?></td>
					            <td><?php echo htmlspecialchars($d['rm180u']); ?></td>
					            <td><?php echo htmlspecialchars($d['H2O']); ?></td>
					            <td><?php echo htmlspecialchars($d['LS_act']); ?></td>
					            <td><?php echo htmlspecialchars($d['SS_act']); ?></td>
					            <td><?php echo htmlspecialchars($d['CL_act']); ?></td>
					            <td><?php echo htmlspecialchars($d['IS_act']); ?></td>
					            <td><?php echo htmlspecialchars($d['TON_dry']); ?></td>
					            <td><?php echo htmlspecialchars($d['LS_qcx']); ?></td>
					            <td><?php echo htmlspecialchars($d['SS_qcx']); ?></td>
					            <td><?php echo htmlspecialchars($d['CL_qcx']); ?></td>
					            <td><?php echo htmlspecialchars($d['IS_qcx']); ?></td>
					            <td><?php echo htmlspecialchars($d['LS_set']); ?></td>
					            <td><?php echo htmlspecialchars($d['SS_set']); ?></td>
					            <td><?php echo htmlspecialchars($d['CL_set']); ?></td>
					            <td><?php echo htmlspecialchars($d['IS_set']); ?></td>
					            <td><?php echo htmlspecialchars($d['SiO2']); ?></td>
					            <td><?php echo htmlspecialchars($d['Al2O3']); ?></td>
					            <td><?php echo htmlspecialchars($d['Fe2O3']); ?></td>
					            <td><?php echo htmlspecialchars($d['CaO']); ?></td>
					            <td><?php echo htmlspecialchars($d['MgO']); ?></td>
					            <td><?php echo htmlspecialchars($d['SO3']); ?></td>
					            <td><?php echo htmlspecialchars($d['K2O']); ?></td>
					            <td><?php echo htmlspecialchars($d['Na2O']); ?></td>
					            <td><?php echo htmlspecialchars($d['Cl2']); ?></td>
					            <td><?php echo htmlspecialchars($d['SUM']); ?></td>
					            <td><?php echo htmlspecialchars($d['ALKALI']); ?></td>
					            <td><?php echo htmlspecialchars($d['TON_emisi']); ?></td>
					            <td><?php echo htmlspecialchars($d['SiO2_back']); ?></td>
					            <td><?php echo htmlspecialchars($d['Al2O3_back']); ?></td>
					            <td><?php echo htmlspecialchars($d['Fe2O3_back']); ?></td>
					            <td><?php echo htmlspecialchars($d['CaO_back']); ?></td>
					            <td><?php echo htmlspecialchars($d['waktu']); ?> <a><?php echo htmlspecialchars($d['iduser']); ?></a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

        <script>
        $(document).ready(function() {
            $('#r1').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel'
                ]
            });
        });
        </script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>