<?php
session_start();
$level = strtoupper($_SESSION['level']);
if ($level == NULL) echo "<script>window.location = '../index.php'</script>";
include "../../include/database.php";
?>
<html>
<head>
  <title>Z2 indarung 2&3 <?php
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
    <h2>SEMEN 2 Indarung 2&3</h2>
    <div class="data-tables datatable-dark">

        <form method="get">
            <label>PILIH TANGGAL</label>
            <input type="date" name="awal">
            <input type="date" name="akhir">
            <input type="submit" value="FILTER">
        </form>
        
        <!-- Masukkan table nya disini, dimulai dari tag TABLE -->
        <table class="table table-striped table-bordered table-hover" id="z2">
            <thead>
                    <tr class="text-center" >
                        <th rowspan="2" class="freeze1">TANGGAL</th><th rowspan="2" class="freeze2">JAM</th><th rowspan="2" class="freeze4">EMISI CO2 (TON)</th> <th rowspan="2" class="freeze5">TOTAL FEED</th> <th colspan="6">OPC(UltraPro)</th><th  colspan="9">OKSIDA</th><th colspan="4">PROPORSI</th><th colspan="2">ESTIMASI</th><th rowspan="2" >ALKALI OPC</th><th rowspan="2" >TYPE</th> <th rowspan="2" >SILO</th><th colspan="4">PCC(EzPro)</th><th colspan="9">OKSIDA</th><th colspan="4">PROPORSI</th><th colspan="2">ESTIMASI</th><th rowspan="2" >SILO</th><th colspan="4">PCC+(PwrPro)</th><th colspan="9">OKSIDA</th><th colspan="4">PROPORSI</th><th colspan="2">ESTIMASI</th><th rowspan="2" >SILO</th>
                    </tr>
                    <tr class="bg-primary text-white">
                        
                        <th>BLAINE</th><th>SO3</th><th>45u</th><th>30u</th><th>H2O</th><th>LOI</th><th>SiO2</th><th>Al2O3</th><th>Fe2O3</th><th>CaO</th><th>MgO</th><th>K2O</th><th>Na2O</th><th>Cl2</th><th>FCaO</th><th>GYPS</th><th>LS</th><th>PZ</th><th>FA</th><th>CR</th><th>BTL</th><th>BLAINE</th><th>SO3</th><th>45u</th><th>LOI</th><th>SiO2</th><th>Al2O3</th><th>Fe2O3</th><th>CaO</th><th>MgO</th><th>K2O</th><th>Na2O</th><th>Cl2</th><th>FCaO</th><th>GYPS</th><th>LS</th><th>PZ</th><th>FA</th><th>CR</th><th>BTL</th><th>BLAINE</th><th>SO3</th><th>45u</th><th>LOI</th><th>SiO2</th><th>Al2O3</th><th>Fe2O3</th><th>CaO</th><th>MgO</th><th>K2O</th><th>Na2O</th><th>Cl2</th><th>FCaO</th><th>GYPS</th><th>LS</th><th>PZ</th><th>FA</th><th>CR</th><th>BTL</th><th>REPORT</th>
                    </tr>
            </thead>
            <?php

            if(isset($_GET['awal']) && isset($_GET['akhir'])){
                $awal = $_GET['awal'];
                $akhir = $_GET['akhir'];
                $sql = "SELECT * FROM z2_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'";
                    } 
            else {  
                    $sql = "SELECT * FROM z2_3 WHERE TANGGAL = CURDATE() ";
                    }     
            $q = mysqli_query($conn, $sql);
            while ($d = mysqli_fetch_array($q)) {
                
                ?>
                <tr>   
                      <td class="freeze1"><?php echo htmlspecialchars($d['TANGGAL']); ?></td>
					            <td class="freeze2"><?php echo htmlspecialchars($d['JAM']); ?></td>
					            <td class="freeze4"><?php echo htmlspecialchars($d['EMISI']); ?></td>
					            <td class="freeze5"><?php echo htmlspecialchars($d['FEED']); ?></td>
					            <td><?php echo htmlspecialchars($d['BLAINE_opc']); ?></td> 
					            <td><?php echo htmlspecialchars($d['SO3_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['z145u_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['z130u_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['H2O_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['LOI_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['SiO2_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['Al2O3_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['Fe2O3_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['CaO_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['MgO_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['K2O_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['Na2O_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['Cl2_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['FCaO_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['GYPS_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['LS_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['PZ_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['FA_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['CR_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['BTL_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['ALKALI_opc']); ?></td>					            
					            <td><?php echo htmlspecialchars($d['TYPE_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['SILO_opc']); ?></td>
					            <td><?php echo htmlspecialchars($d['BLAINE_pcc']); ?></td> 
					            <td><?php echo htmlspecialchars($d['SO3_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['z145u_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['LOI_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['SiO2_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['Al2O3_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['Fe2O3_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['CaO_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['MgO_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['K2O_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['Na2O_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['Cl2_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['FCaO_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['GYPS_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['LS_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['PZ_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['FA_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['CR_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['BTL_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['SILO_pcc']); ?></td>
					            <td><?php echo htmlspecialchars($d['BLAINE_pcp']); ?></td> 
					            <td><?php echo htmlspecialchars($d['SO3_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['z145u_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['LOI_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['SiO2_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['Al2O3_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['Fe2O3_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['CaO_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['MgO_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['K2O_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['Na2O_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['Cl2_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['FCaO_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['GYPS_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['LS_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['PZ_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['FA_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['CR_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['BTL_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['SILO_pcp']); ?></td>
					            <td><?php echo htmlspecialchars($d['waktu']); ?> <a><?php echo htmlspecialchars($d['iduser']); ?>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

        <script>
        $(document).ready(function() {
            $('#z2').DataTable( {
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