<?php
session_start();
$level = strtoupper($_SESSION['level']);
if ($level == NULL) echo "<script>window.location = '../index.php'</script>";
include "../../include/database.php";
?>
<html>
<head>
  <title>EP indarung 4 <?php
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
    <h2>EP Indarung 4 </h2>
    <div class="data-tables datatable-dark">

        <form method="get">
            <label>PILIH TANGGAL</label>
            <input type="date" name="awal">
            <input type="date" name="akhir">
            <input type="submit" value="FILTER">
        </form>
        
        <table class="table table-striped table-bordered table-hover" id="bhf">
            <thead>
                    <tr class="text-center" >
                       </th><th  rowspan="1" ></th><th colspan="3">EP 3B</th><th colspan="11">OKSIDA</th><th colspan="3">EP 3C</th><th colspan="11">OKSIDA</th> <th colspan="2">STATUS </th><th colspan="1"></th>
                    </tr>

                    <tr class="bg-primary text-white">
                        
                        <th>Tanggal</th><th>LSF</th> <th>SIM</th> <th>ALM</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th> <th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>SUM</th><th>Alkali</th><th>LSF</th> <th>SIM</th> <th>ALM</th><th>SiO2</th> <th>Al2O3</th> <th>Fe2O3</th> <th>CaO</th> <th>MgO</th> <th>SO3</th> <th>K2O</th> <th>Na2O</th> <th>Cl2</th><th>SUM</th><th>Alkali</th><th>RM1</th><th>RM2</th> <th>Report</th>

                    
                    </tr>
            </thead>
            <?php

            if(isset($_GET['awal']) && isset($_GET['akhir'])){
                $awal = $_GET['awal'];
                $akhir = $_GET['akhir'];
                $sql = "SELECT * FROM ep_4 WHERE TANGGAL BETWEEN '$awal' AND '$akhir'";
                    } 
            else {  
                    $sql = "SELECT * FROM ep_4 WHERE TANGGAL = CURDATE() ";
                    }     
            $q = mysqli_query($conn, $sql);
            while ($d = mysqli_fetch_array($q)) {
                
                
                ?>
                <tr>   
                    <td><?php echo $d['TANGGAL']; ?></td>
                    <td><?php echo $d['LSF_b']; ?></td>
                    <td><?php echo $d['SIM_b']; ?></td>
                    <td><?php echo $d['ALM_b']; ?></td>
                    <td><?php echo $d['SiO2_b']; ?></td>
                    <td><?php echo $d['Al2O3_b']; ?></td>
                    <td><?php echo $d['Fe2O3_b']; ?></td>
                    <td><?php echo $d['CaO_b']; ?></td>
                    <td><?php echo $d['MgO_b']; ?></td>
                    <td><?php echo $d['SO3_b']; ?></td>
                    <td><?php echo $d['K2O_b']; ?></td>
                    <td><?php echo $d['Na2O_b']; ?></td>
                    <td><?php echo $d['Cl2_b']; ?></td>
                    <td><?php echo $d['SUM_b']; ?></td>
                    <td><?php echo $d['ALKALI_b']; ?></td>
                    <td><?php echo $d['LSF_c']; ?></td>
                    <td><?php echo $d['SIM_c']; ?></td>
                    <td><?php echo $d['ALM_c']; ?></td>
                    <td><?php echo $d['SiO2_c']; ?></td>
                    <td><?php echo $d['Al2O3_c']; ?></td>
                    <td><?php echo $d['Fe2O3_c']; ?></td>
                    <td><?php echo $d['CaO_c']; ?></td>
                    <td><?php echo $d['MgO_c']; ?></td>
                    <td><?php echo $d['SO3_c']; ?></td>
                    <td><?php echo $d['K2O_c']; ?></td>
                    <td><?php echo $d['Na2O_c']; ?></td>
                    <td><?php echo $d['Cl2_c']; ?></td>
                    <td><?php echo $d['SUM_c']; ?></td>
                    <td><?php echo $d['ALKALI_c']; ?></td>
                    <td><?php echo $d['RM1']; ?></td> 
                    <td><?php echo $d['RM2']; ?></td> 
                    <td><?php echo $d['waktu'] ; ?> <a> <?php echo $d['iduser'] ; ?></a></td>
                </tr>



            <?php } ?>
        </table>
    </div>
</div>

        <script>
        $(document).ready(function() {
            $('#bhf').DataTable( {
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