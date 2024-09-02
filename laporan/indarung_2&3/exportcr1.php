<?php
session_start();
$level = strtoupper($_SESSION['level']);
if ($level == NULL) echo "<script>window.location = '../index.php'</script>";
include "../../include/database.php";
?>
<html>
<head>
   <title>CR1 indarung 2&3 <?php
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
    <h2>CLINKER 1 Indarung 2&3</h2>
    <div class="data-tables datatable-dark">

        <form method="get">
            <label>PILIH TANGGAL</label>
            <input type="date" name="awal">
            <input type="date" name="akhir">
            <input type="submit" value="FILTER">
        </form>
        
        <!-- Masukkan table nya disini, dimulai dari tag TABLE -->
        <table class="table table-striped table-bordered table-hover" id="cr">
            <thead>
                    <tr class="text-center" >
                        <tr class="text-center" >
                        <th colspan="2"></th><th  colspan="9">CLINKER</th><th  colspan="10">OKISDA</th><th colspan="3">VISUAL</th> <th colspan="1"></th><th colspan="3">SIEVE 1.18mm</th><th colspan="1"></th>
                    </tr>

                    <tr class="bg-primary text-white">
                        
                      <th>Tanggal</th><th>Jam</th><th>LTW</th><th>TEMP</th> <th>LSF</th> <th>SIM</th> <th>ALM</th> <th>C3S</th><th>C2S</th> <th>C3A</th> <th>C4AF</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th> <th>K2O</th> <th>Na2O</th> <th>FCaO</th><th>SUM</th> <th>WARNA</th> <th>FISIK</th><th>SILO</th><th>TYPE</th> <th>BERAT</th> <th>LOLOS</th> <th>% LOLOS</th> <th>Report</th>
                    
                    </tr>
            </thead>
            <?php

            if(isset($_GET['awal']) && isset($_GET['akhir'])){
                $awal = $_GET['awal'];
                $akhir = $_GET['akhir'];
                $sql = "SELECT * FROM cr1_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'";
                    } 
            else {  
                    $sql = "SELECT * FROM cr1_3 WHERE TANGGAL = CURDATE() ";
                    }     
            $q = mysqli_query($conn, $sql);
            while ($d = mysqli_fetch_array($q)) {
                
                
                ?>
                <tr>   
								<td><?php echo htmlspecialchars($d['TANGGAL']); ?></td>
					            <td><?php echo htmlspecialchars($d['JAM']); ?></td>
					            <td><?php echo htmlspecialchars($d['LTW']); ?></td>
					            <td><?php echo htmlspecialchars($d['TEMP']); ?></td>
					            <td><?php echo htmlspecialchars($d['LSF']); ?></td>
					            <td><?php echo htmlspecialchars($d['SIM']); ?></td>
					            <td><?php echo htmlspecialchars($d['ALM']); ?></td>
					            <td><?php echo htmlspecialchars($d['C3S']); ?></td>
					            <td><?php echo htmlspecialchars($d['C2S']); ?></td>
					            <td><?php echo htmlspecialchars($d['C3A']); ?></td>
					            <td><?php echo htmlspecialchars($d['C4AF']); ?></td>
					            <td><?php echo htmlspecialchars($d['SiO2']); ?></td>
					            <td><?php echo htmlspecialchars($d['Al2O3']); ?></td>
					            <td><?php echo htmlspecialchars($d['Fe2O3']); ?></td>
					            <td><?php echo htmlspecialchars($d['CaO']); ?></td>
					            <td><?php echo htmlspecialchars($d['MgO']); ?></td>
					            <td><?php echo htmlspecialchars($d['SO3']); ?></td>
					            <td><?php echo htmlspecialchars($d['K2O']); ?></td>
					            <td><?php echo htmlspecialchars($d['Na2O']); ?></td>
					            <td><?php echo htmlspecialchars($d['FCaO']); ?></td>
					            <td><?php echo htmlspecialchars($d['SUM']); ?></td>
					            <td><?php echo htmlspecialchars($d['WARNA']); ?></td>
					            <td><?php echo htmlspecialchars($d['FISIK']); ?></td>
					            <td><?php echo htmlspecialchars($d['SILO']); ?></td>
					            <td><?php echo htmlspecialchars($d['TYPE']); ?></td>
					            <td><?php echo htmlspecialchars($d['BERAT_sampel']); ?></td>
					            <td><?php echo htmlspecialchars($d['LOLOS_ayakan']); ?></td>
					            <td><?php echo htmlspecialchars($d['PERSEN_lolos']); ?></td>
					            <td><?php echo htmlspecialchars($d['waktu']); ?> <a><?php echo htmlspecialchars($d['iduser']); ?>
                </tr>



            <?php } ?>
        </table>
    </div>
</div>

        <script>
        $(document).ready(function() {
            $('#cr').DataTable( {
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