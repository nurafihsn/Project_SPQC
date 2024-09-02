<?php
session_start();
$level = strtoupper($_SESSION['level']);
if ($level == NULL) echo "<script>window.location = '../index.php'</script>";
include "../../include/database.php";
?>
<html>
<head>
  <title>FC indarung 4 <?php
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
    <h2>FINE COAL & RAW COAL Indarung 4</h2>
    <div class="data-tables datatable-dark">

        <form method="get">
            <label>PILIH TANGGAL</label>
            <input type="date" name="awal">
            <input type="date" name="akhir">
            <input type="submit" value="FILTER">
        </form>
        
        <!-- Masukkan table nya disini, dimulai dari tag TABLE -->
        <table class="table table-striped table-bordered table-hover" id="fc">
            <thead>
                <tr class="text-center" >
                   <th  rowspan="1" ></th><th  rowspan="1" ></th><th colspan="4">FINE COAL 4K2</th><th colspan="4">FINE COAL 4K3</th><th colspan="2">RAW COAL</th> 
              </tr>
                <tr class="bg-primary text-white">
                   <th>Tanggal</th><th>Jam</th><th>90u</th><th>H2O</th><th>ASH</th> <th>ADB</th><th>90u</th><th>H2O</th><th>ASH</th> <th>ADB</th> <th>SHIFT</th> <th>H2O</th> <th>Report</th>
          </tr>
                    
                </tr>
            </thead>
            <?php

            if(isset($_GET['awal']) && isset($_GET['akhir'])){
                $awal = $_GET['awal'];
                $akhir = $_GET['akhir'];
                $sql = "SELECT * FROM fc_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'";
                    } 
            else {  
                    $sql = "SELECT * FROM fc_4 WHERE TANGGAL = CURDATE() ";
                    }     
            $q = mysqli_query($conn, $sql);
            while ($d = mysqli_fetch_array($q)) {
               
                ?>
                <tr>   
                   <td><?php echo $d['TANGGAL']; ?></td>
                   <td><?php echo $d['JAM']; ?></td>
                   <td><?php echo $d['fc90uk2']; ?></td>
                   <td><?php echo $d['H2O_fck2']; ?></td>
                   <td><?php echo $d['ASHk2']; ?></td>
                   <td><?php echo $d['ADBk2']; ?></td>
                   <td><?php echo $d['fc90uk3']; ?></td>
                   <td><?php echo $d['H2O_fck3']; ?></td>
                   <td><?php echo $d['ASHk3']; ?></td>
                   <td><?php echo $d['ADBk3']; ?></td>
                   <td><?php echo $d['SHIFT']; ?></td>
                   <td><?php echo $d['H2O_rc']; ?></td>
                   <td><?php echo $d['waktu'] ; ?> <a> <?php echo $d['iduser'] ; ?></a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

        <script>
        $(document).ready(function() {
            $('#fc').DataTable( {
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