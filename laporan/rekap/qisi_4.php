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
  <style>
        .red-background {
            background-color: red;
        }
        .green-background {
            background-color: green;
        }
    </style>

</head>

<body>
	<h2 class="text-center">QISI</h2>
    <h2 class="text-center mb-5">PABRIK INDARUNG IV</h2>

	<form method="get" class="mb-3">
            <label>PILIH TANGGAL : </label>
            <input type="date" name="tgl">
            <input class="btn btn-primary" type="submit" value="FILTER">

        </form>
        <h3 class="text-center">
            <?php
                if(isset($_GET['tgl'])){
                    $tgl = $_GET['tgl'];
                    echo "<label>QISI $tgl</label>";
                }
                ?>
        </h3>   

    <table class="adminlist mb-3" border="1" width="500" cellpadding="5">
        <thead>
            <tr class="text-center">
                <th colspan="2">QISI HARIAN</th>
            </tr>
            <tr class="text-center" bgcolor="#8080FF" style="color:#FFFFFF">
                <th>IN</th><th>RATING</th>
            </tr>
        </thead>
        <tbody>
            <tr bgcolor="YELLOW" style="color:BLACK">
            	 <?php
               	   if (isset($_GET['tgl'])) {
                    try {
                        $date = new DateTime($_GET['tgl']);
                        $tgl = $date->format('Y-m-d');  
                        $bulan = $date->format('Y-m'); 
                    } catch (Exception $e) {
                        $tgl = date('Y-m-d');  
                        $bulan = date('Y-m');  
                    }
                } else {
                    $tgl = date('Y-m-d');  
                    $bulan = date('Y-m');  
                }


                $result_value_sum = 0;

                $datain_query = mysqli_query($conn, "SELECT FLIME_cr, LSF_cr FROM lhk_2024 WHERE TANGGAL = '$tgl'");

                if ($datain_query) {
                    while ($row = mysqli_fetch_assoc($datain_query)) {
                        $FLIME_cr = $row['FLIME_cr'];
                        $LSF_cr = $row['LSF_cr'];
                        $result_value = 0;

                        if ($FLIME_cr >= 0.5 && $FLIME_cr <= 1.8 && $LSF_cr >= 94 && $LSF_cr <= 99) {
                            $result_value = 1;
                        }

                        $result_value_sum += $result_value;
                    }
                }

                $count_query = mysqli_query($conn, "SELECT COUNT(FLIME_cr) AS count_fcaocr FROM lhk_2024 WHERE TANGGAL = '$tgl'");
                $count_result = mysqli_fetch_assoc($count_query);
                $count_fcaocr = $count_result['count_fcaocr'];

                if ($count_fcaocr > 0 || $result_value_sum > 0 ) {
                    $percentage = ($result_value_sum / $count_fcaocr) * 100;

                 $css_class = '';
			     if ($percentage <= 70) {
				    $css_class = 'background-color: red;';}
				 elseif ($percentage >= 90) {
				    $css_class = 'background-color: green;';}

                    echo "<td style='$css_class'>" . number_format((float)$percentage, 2) . "</td>";

                if ($percentage < 70) {
                    $final_value = 0;
                } elseif ($percentage > 90) {
                    $final_value = 20;
                } elseif ($percentage >= 70) {
                    $final_value = $percentage - 70;
                } else {
                    $final_value = "";
                }

                $css_class = '';
			     if ($final_value <= 15) {
				    $css_class = 'background-color: red;';}

                echo "<td style='$css_class'>" . number_format((float)$final_value, 2) . "</td>";
                }

			    ?>
            </tr>
        </tbody>
    </table>

        <table class="adminlist mb-3" border="1" width="500" cellpadding="5">
        <thead>
            <tr class="text-center">
                <th colspan="2">QISI BULANAN</th>
            </tr>
            <tr class="text-center" bgcolor="#8080FF" style="color:#FFFFFF">
                <th>IN</th><th>RATING</th>
            </tr>
        </thead>
        <tbody>
             <tr bgcolor="YELLOW" style="color:BLACK">
			     <?php
                   
                $result_value_sum = 0;

                $datain_query = mysqli_query($conn, "SELECT FLIME_cr, LSF_cr FROM lhk_2024 WHERE TANGGAL like '$bulan%'");

                if ($datain_query) {
                    while ($row = mysqli_fetch_assoc($datain_query)) {
                        $FLIME_cr = $row['FLIME_cr'];
                        $LSF_cr = $row['LSF_cr'];
                        $result_value = 0;

                        if ($FLIME_cr >= 0.5 && $FLIME_cr <= 1.8 && $LSF_cr >= 94 && $LSF_cr <= 99) {
                            $result_value = 1;
                        }

                        $result_value_sum += $result_value;
                    }
                }

                $count_query = mysqli_query($conn, "SELECT COUNT(FLIME_cr) AS count_fcaocr FROM lhk_2024 WHERE TANGGAL like '$bulan%'");
                $count_result = mysqli_fetch_assoc($count_query);
                $count_fcaocr = $count_result['count_fcaocr'];

                if ($count_fcaocr > 0 || $result_value_sum > 0 ) {
                    $percentage = ($result_value_sum / $count_fcaocr) * 100;

                 $css_class = '';
			     if ($percentage <= 70) {
				    $css_class = 'background-color: red;';}
				 elseif ($percentage >= 90) {
				    $css_class = 'background-color: green;';}

                    echo "<td style='$css_class'>" . number_format((float)$percentage, 2) . "</td>";

                if ($percentage < 70) {
                    $final_value = 0;
                } elseif ($percentage > 90) {
                    $final_value = 20;
                } elseif ($percentage >= 70) {
                    $final_value = $percentage - 70;
                } else {
                    $final_value = "";
                }

                 $css_class = '';
			     if ($final_value <= 15) {
				    $css_class = 'background-color: red;';}
				 

                echo "<td style='$css_class'>" . number_format((float)$final_value, 2) . "</td>";
                }

                ?>

				   
			</tr>
		</tbody>
	</table>
				



		
					        
  
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