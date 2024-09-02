<?php
session_start();
$level = strtoupper($_SESSION['level']);
if ($level == NULL) echo "<script>window.location = '../index.php'</script>";
include "../../include/database.php";
?>
<html>
<head>
  <title>KF1 indarung 2&3 <?php
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
    <h2>KILN FEED 1 Indarung 2&3</h2>
    <div class="data-tables datatable-dark">

        <form method="get">
            <label>PILIH TANGGAL</label>
            <input type="date" name="awal">
            <input type="date" name="akhir">
            <input type="submit" value="FILTER">
        </form>
        
        <!-- Masukkan table nya disini, dimulai dari tag TABLE -->
        <table class="table table-striped table-bordered table-hover" id="kf">
            <thead>
                <tr class="text-center" >
			            <th  rowspan="1" ></th><th  rowspan="1" ></th><th colspan="7">KILN FEED</th><th colspan="9">OKSIDA</th> <th colspan="5"></th>
			        </tr>
                <tr class="bg-primary text-white">
                    <th>Tanggal</th><th>Jam</th><th>LSF</th> <th>SIM</th> <th>ALM</th><th>BF</th><th>90u</th><th>180u</th> <th>H2O</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th> <th>K2O</th> <th>Na2O</th> <th>SUM</th><th>TYPE</th><th>Report</th>
                    
                </tr>
            </thead>
            <?php

            if(isset($_GET['awal']) && isset($_GET['akhir'])){
                $awal = $_GET['awal'];
                $akhir = $_GET['akhir'];
                $sql = "SELECT * FROM kf1_3 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'";
                    } 
            else {  
                    $sql = "SELECT * FROM kf1_3 WHERE TANGGAL = CURDATE() ";
                    }     
            $q = mysqli_query($conn, $sql);
            while ($d = mysqli_fetch_array($q)) {
               
                ?>
                <tr>   
                    			<td><?php echo $d['TANGGAL']; ?></td>
					            <td><?php echo $d['JAM']; ?></td>
					            <td><?php echo $d['LSF']; ?></td>
					            <td><?php echo $d['SIM']; ?></td>
					            <td><?php echo $d['ALM']; ?></td>
					            <td><?php echo $d['BF']; ?></td>
					            <td><?php echo $d['kf90u']; ?></td>
					            <td><?php echo $d['kf180u']; ?></td>
					            <td><?php echo $d['H2O']; ?></td>
					            <td><?php echo $d['SiO2']; ?></td>
					            <td><?php echo $d['Al2O3']; ?></td>
					            <td><?php echo $d['Fe2O3']; ?></td>
					            <td><?php echo $d['CaO']; ?></td>
					            <td><?php echo $d['MgO']; ?></td>
					            <td><?php echo $d['SO3']; ?></td>
					            <td><?php echo $d['K2O']; ?></td>
					            <td><?php echo $d['Na2O']; ?></td>
					            <td><?php echo $d['SUM']; ?></td>
					            <td><?php echo $d['TYPE']; ?></td>
					            <td><?php echo $d['waktu'] ; ?> <a> <?php echo $d['iduser'] ; ?></a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

        <script>
        $(document).ready(function() {
            $('#kf').DataTable( {
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