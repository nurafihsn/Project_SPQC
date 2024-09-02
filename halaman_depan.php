<?php
session_start();
$level = strtoupper($_SESSION['level']);
if ($level == NULL) echo "<script>window.location = '../index.php'</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.0.2"></script>
    <link rel="shortcut icon" href="https://demo.learncodeweb.com/favicon.ico">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <style>
        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            padding: 20px;
        }
        .box {
            border: 1px solid #ccc;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #8080FF;
            color: #FFFFFF;
        }

    </style>

        
</head>
		<center style=" font-size: 24px; font-weight: bold; color: #333333; ">
            <label>DASHBOARD</label>
        </center>
<body>
    <div class="container">
         <?php include "../include/database.php"; ?>
        <div class="box">
            <b style="margin-bottom: 10px;">QISI Indarung 6</b>
			<table class="adminlist" width="300" cellpadding="3">
                <thead>
                    <tr class="text-center">
                        <th colspan="2">QISI Bulanan</th>
                        <th colspan="2">QISI Harian</th>
                    </tr>
                    <tr class="text-center" bgcolor="#8080FF" style="color:#FFFFFF">
                        <th>IN</th>
                        <th>RATING</th>
                        <th>IN</th>
                        <th>RATING</th>
                    </tr>
                </thead>
                <tbody>
                    <tr bgcolor="YELLOW" style="color:BLACK">
                        <?php
                        $bulan = date('Y-m');
                        $result_value_sum1 = 0;
                        $datain_query = mysqli_query($conn, "SELECT FCaO, LSF FROM cr_6 WHERE TANGGAL like '$bulan%'");

                        if ($datain_query) {
                            while ($row = mysqli_fetch_assoc($datain_query)) {
                                $FCaO = $row['FCaO'];
                                $LSF = $row['LSF'];
                                $result_value = 0;

                                if ($FCaO >= 0.5 && $FCaO <= 1.8 && $LSF >= 94 && $LSF <= 99) {
                                    $result_value = 1;
                                }

                                $result_value_sum1 += $result_value;
                            }
                        }

                        $count_query = mysqli_query($conn, "SELECT COUNT(FCaO) AS count_fcaocr1 FROM cr_6 WHERE TANGGAL like '$bulan%'");
                        $count_result = mysqli_fetch_assoc($count_query);
                        $count_fcaocr1 = $count_result['count_fcaocr1'];

                        if ($count_fcaocr1 > 0 || $result_value_sum1 > 0) {
                            $percentage = ($result_value_sum1 / $count_fcaocr1) * 100;

                            $css_class = '';
                            if ($percentage <= 70) {
                                $css_class = 'background-color: red;';
                            } elseif ($percentage >= 90) {
                                $css_class = 'background-color: green;';
                            }

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
                                $css_class = 'background-color: red;';
                            }

                            echo "<td style='$css_class'>" . number_format((float)$final_value, 2) . "</td>";
                        }
                        ?>

                        <?php
                        $tgl = date('Y-m-d');
                        $result_value_sum2 = 0;

                        $datain_query = mysqli_query($conn, "SELECT FCaO, LSF FROM cr_6 WHERE TANGGAL = '$tgl'");

                        if ($datain_query) {
                            while ($row = mysqli_fetch_assoc($datain_query)) {
                                $FCaO = $row['FCaO'];
                                $LSF = $row['LSF'];
                                $result_value = 0;

                                if ($FCaO >= 0.5 && $FCaO <= 1.8 && $LSF >= 94 && $LSF <= 99) {
                                    $result_value = 1;
                                }

                                $result_value_sum2 += $result_value;
                            }
                        }

                        $count_query = mysqli_query($conn, "SELECT COUNT(FCaO) AS count_fcaocr2 FROM cr_6 WHERE TANGGAL = '$tgl'");
                        $count_result = mysqli_fetch_assoc($count_query);
                        $count_fcaocr2 = $count_result['count_fcaocr2'];

                        if ($count_fcaocr2 > 0 || $result_value_sum2 > 0) {
                            $percentage = ($result_value_sum2 / $count_fcaocr2) * 100;

                            $css_class = '';
                            if ($percentage <= 70) {
                                $css_class = 'background-color: red;';
                            } elseif ($percentage >= 90) {
                                $css_class = 'background-color: green;';
                            }

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
                                $css_class = 'background-color: red;';
                            }

                            echo "<td style='$css_class'>" . number_format((float)$final_value, 2) . "</td>";
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="box">
            <b style="margin-bottom: 10px;">QISI Indarung 5</b>
            <table class="adminlist mb-5"  width="300" cellpadding="3">
                <thead>
                    <tr class="text-center">
                        <th colspan="2">QISI Bulanan</th>
                        <th colspan="2">QISI Harian</th>
                    </tr>
                    <tr class="text-center" bgcolor="#8080FF" style="color:#FFFFFF">
                        <th>IN</th>
                        <th>RATING</th>
                        <th>IN</th>
                        <th>RATING</th>
                    </tr>
                </thead>
                <tbody>
                    <tr bgcolor="YELLOW" style="color:BLACK">
                        <?php
                        $bulan = date('Y-m');
                        $result_value_sum3 = 0;
                        $datain_query = mysqli_query($conn, "SELECT FCaO, LSF FROM cr_5 WHERE TANGGAL like '$bulan%'");

                        if ($datain_query) {
                            while ($row = mysqli_fetch_assoc($datain_query)) {
                                $FCaO = $row['FCaO'];
                                $LSF = $row['LSF'];
                                $result_value = 0;

                                if ($FCaO >= 0.5 && $FCaO <= 1.8 && $LSF >= 94 && $LSF <= 99) {
                                    $result_value = 1;
                                }

                                $result_value_sum3 += $result_value;
                            }
                        }

                        $count_query = mysqli_query($conn, "SELECT COUNT(FCaO) AS count_fcaocr3 FROM cr_5 WHERE TANGGAL like '$bulan%'");
                        $count_result = mysqli_fetch_assoc($count_query);
                        $count_fcaocr3 = $count_result['count_fcaocr3'];

                        if ($count_fcaocr3 > 0 || $result_value_sum3 > 0) {
                            $percentage = ($result_value_sum3 / $count_fcaocr3) * 100;

                            $css_class = '';
                            if ($percentage <= 70) {
                                $css_class = 'background-color: red;';
                            } elseif ($percentage >= 90) {
                                $css_class = 'background-color: green;';
                            }

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
                                $css_class = 'background-color: red;';
                            }

                            echo "<td style='$css_class'>" . number_format((float)$final_value, 2) . "</td>";
                        }
                        ?>

                        <?php
                        $tgl = date('Y-m-d');
                        $result_value_sum4 = 0;

                        $datain_query = mysqli_query($conn, "SELECT FCaO, LSF FROM cr_5 WHERE TANGGAL = '$tgl'");

                        if ($datain_query) {
                            while ($row = mysqli_fetch_assoc($datain_query)) {
                                $FCaO = $row['FCaO'];
                                $LSF = $row['LSF'];
                                $result_value = 0;

                                if ($FCaO >= 0.5 && $FCaO <= 1.8 && $LSF >= 94 && $LSF <= 99) {
                                    $result_value = 1;
                                }

                                $result_value_sum4 += $result_value;
                            }
                        }

                        $count_query = mysqli_query($conn, "SELECT COUNT(FCaO) AS count_fcaocr4 FROM cr_5 WHERE TANGGAL = '$tgl'");
                        $count_result = mysqli_fetch_assoc($count_query);
                        $count_fcaocr4 = $count_result['count_fcaocr4'];

                        if ($count_fcaocr4 > 0 || $result_value_sum4 > 0) {
                            $percentage = ($result_value_sum4 / $count_fcaocr4) * 100;

                            $css_class = '';
                            if ($percentage <= 70) {
                                $css_class = 'background-color: red;';
                            } elseif ($percentage >= 90) {
                                $css_class = 'background-color: green;';
                            }

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
                                $css_class = 'background-color: red;';
                            }

                            echo "<td style='$css_class'>" . number_format((float)$final_value, 2) . "</td>";
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
         <div class="box">
            <b style="margin-bottom: 10px;">QISI Indarung 4</b>
            <table class="adminlist mb-5"  width="300" cellpadding="3">
                <thead>
                    <tr class="text-center">
                        <th colspan="2">QISI Bulanan</th>
                        <th colspan="2">QISI Harian</th>
                    </tr>
                    <tr class="text-center" bgcolor="#8080FF" style="color:#FFFFFF">
                        <th>IN</th>
                        <th>RATING</th>
                        <th>IN</th>
                        <th>RATING</th>
                    </tr>
                </thead>
                <tbody>
                    <tr bgcolor="YELLOW" style="color:BLACK">
                        <?php
                        $bulan = date('Y-m');
                        $result_value_sum5 = 0;
                        $datain_query = mysqli_query($conn, "SELECT FCaO, LSF FROM cr_4 WHERE TANGGAL like '$bulan%'");

                        if ($datain_query) {
                            while ($row = mysqli_fetch_assoc($datain_query)) {
                                $FCaO = $row['FCaO'];
                                $LSF = $row['LSF'];
                                $result_value = 0;

                                if ($FCaO >= 0.5 && $FCaO <= 1.8 && $LSF >= 94 && $LSF <= 99) {
                                    $result_value = 1;
                                }

                                $result_value_sum5 += $result_value;
                            }
                        }

                        $count_query = mysqli_query($conn, "SELECT COUNT(FCaO) AS count_fcaocr5 FROM cr_4 WHERE TANGGAL like '$bulan%'");
                        $count_result = mysqli_fetch_assoc($count_query);
                        $count_fcaocr5 = $count_result['count_fcaocr5'];

                        if ($count_fcaocr5 > 0 || $result_value_sum5 > 0) {
                            $percentage = ($result_value_sum5 / $count_fcaocr5) * 100;

                            $css_class = '';
                            if ($percentage <= 70) {
                                $css_class = 'background-color: red;';
                            } elseif ($percentage >= 90) {
                                $css_class = 'background-color: green;';
                            }

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
                                $css_class = 'background-color: red;';
                            }

                            echo "<td style='$css_class'>" . number_format((float)$final_value, 2) . "</td>";
                        }
                        ?>

                        <?php
                        $tgl = date('Y-m-d');
                        $result_value_sum6 = 0;

                        $datain_query = mysqli_query($conn, "SELECT FCaO, LSF FROM cr_4 WHERE TANGGAL = '$tgl'");

                        if ($datain_query) {
                            while ($row = mysqli_fetch_assoc($datain_query)) {
                                $FCaO = $row['FCaO'];
                                $LSF = $row['LSF'];
                                $result_value = 0;

                                if ($FCaO >= 0.5 && $FCaO <= 1.8 && $LSF >= 94 && $LSF <= 99) {
                                    $result_value = 1;
                                }

                                $result_value_sum6 += $result_value;
                            }
                        }

                        $count_query = mysqli_query($conn, "SELECT COUNT(FCaO) AS count_fcaocr6 FROM cr_4 WHERE TANGGAL = '$tgl'");
                        $count_result = mysqli_fetch_assoc($count_query);
                        $count_fcaocr6 = $count_result['count_fcaocr6'];

                        if ($count_fcaocr6 > 0 || $result_value_sum6 > 0) {
                            $percentage = ($result_value_sum6 / $count_fcaocr6) * 100;

                            $css_class = '';
                            if ($percentage <= 70) {
                                $css_class = 'background-color: red;';
                            } elseif ($percentage >= 90) {
                                $css_class = 'background-color: green;';
                            }

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
                                $css_class = 'background-color: red;';
                            }

                            echo "<td style='$css_class'>" . number_format((float)$final_value, 2) . "</td>";
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
     </div>

        
    <div class="box">

    	<b style="margin-bottom: 10px;">QISI Semen Padang</b>
            <table class="adminlist mb-5"  width="300" cellpadding="3">
                <thead>
                    <tr class="text-center">
                        <th colspan="2">QISI Bulanan</th>
                        <th colspan="2">QISI Harian</th>
                    </tr>
                    <tr class="text-center" bgcolor="#8080FF" style="color:#FFFFFF">
                        <th>IN</th>
                        <th>RATING</th>
                        <th>IN</th>
                        <th>RATING</th>
                    </tr>
                </thead>
                <tbody>
                    <tr bgcolor="YELLOW" style="color:BLACK">
                        <?php
						
						 
						    $result_value_sum = $result_value_sum1 + $result_value_sum3 + $result_value_sum5 ;
                            $count_fcaocr = $count_fcaocr1 + $count_fcaocr3 + $count_fcaocr5;
                            $result = 0;
                            if ($count_fcaocr != 0) {
                                $result = ($result_value_sum / $count_fcaocr) * 100;
                            }
						    $css_class = '';
                            if ($result <= 70) {
                                $css_class = 'background-color: red;';
                            } elseif ($result >= 90) {
                                $css_class = 'background-color: green;';
                            }

                            echo "<td style='$css_class'>" . number_format((float)$result, 2) . "</td>";

                             if ($result < 70) {
                                $final_value = 0;
                            } elseif ($result > 90) {
                                $final_value = 20;
                            } elseif ($result >= 70) {
                                $final_value = $result - 70;
                            } else {
                                $final_value = "";
                            }

                            $css_class = '';
                            if ($final_value <= 15) {
                                $css_class = 'background-color: red;';
                            }

                            echo "<td style='$css_class'>" . number_format((float)$final_value, 2) . "</td>";
						 
						?>

                        <?php
                        
                         
                            $result_value_sum = $result_value_sum2 + $result_value_sum4 + $result_value_sum6 ;
                            $count_fcaocr = $count_fcaocr2 + $count_fcaocr4 + $count_fcaocr6 ;
                            $result = 0;
                            if ($count_fcaocr != 0) {
                                $result = ($result_value_sum / $count_fcaocr) * 100;
                            }

                            $css_class = '';
                            if ($result <= 70) {
                                $css_class = 'background-color: red;';
                            } elseif ($result >= 90) {
                                $css_class = 'background-color: green;';
                            }

                            echo "<td style='$css_class'>" . number_format((float)$result, 2) . "</td>";

                             if ($result < 70) {
                                $final_value = 0;
                            } elseif ($result > 90) {
                                $final_value = 20;
                            } elseif ($result >= 70) {
                                $final_value = $result - 70;
                            } else {
                                $final_value = "";
                            }

                            $css_class = '';
                            if ($final_value <= 15) {
                                $css_class = 'background-color: red;';
                            }

                            echo "<td style='$css_class'>" . number_format((float)$final_value, 2) . "</td>";
                         
                        ?>
                    </tr>
                </tbody>
            </table>

    </div>	


        <div class="box">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <?php if ($level == '3'): ?>
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#pcc"><i class="fa fa-fw fa-plus-circle"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php

    $cr_pcc6 = !empty($_POST['cr_pcc6']) ? $_POST['cr_pcc6'] : NULL;
    $cr_pcc7 = !empty($_POST['cr_pcc7']) ? $_POST['cr_pcc7'] : NULL;
    $cr_pcc8 = !empty($_POST['cr_pcc8']) ? $_POST['cr_pcc8'] : NULL;
    $cr_pcc8 = !empty($_POST['cr_pcc8']) ? $_POST['cr_pcc8'] : NULL;
    $cr_pcc9 = !empty($_POST['cr_pcc9']) ? $_POST['cr_pcc9'] : NULL;
    $cr_pcc10 = !empty($_POST['cr_pcc10']) ? $_POST['cr_pcc10'] : NULL;
    $cr_pcc11 = !empty($_POST['cr_pcc11']) ? $_POST['cr_pcc11'] : NULL;
    $cr_pcc12 = !empty($_POST['cr_pcc12']) ? $_POST['cr_pcc12'] : NULL;
    
    


    ?>


    <div class="modal fade" id="pcc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title " id="exampleModalLabel">Add Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php

                    include "../include/database_full.php";
                    
                    date_default_timezone_set('Asia/Jakarta');

                    if (isset($_POST['submit_pcc'])) {
                        $waktu = date("H:i:s");
                        $tanggal = date("Y-m-d");
                        
                        $sql = "INSERT pcc_2024 (TANGGAL,cr_pcc6, cr_pcc7, cr_pcc8, cr_pcc9, cr_pcc10, cr_pcc11, cr_pcc12) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = mysqli_prepare($conn, $sql);

                            mysqli_stmt_bind_param($stmt, "ssssssss", $tanggal, $cr_pcc6, $cr_pcc7, $cr_pcc8, $cr_pcc9, $cr_pcc10, $cr_pcc11, $cr_pcc12 );
                            
                            mysqli_stmt_execute($stmt);

                            if (mysqli_stmt_affected_rows($stmt) > 0) {
                                echo "<script>window.location = 'halaman_depan.php'</script>";
                            } else {
                                echo "Gagal menambahkan data.";
                            }

                            mysqli_stmt_close($stmt);
                        }

                    $sql = "Select * from pcc_2024";
                    $q = mysqli_query($conn, $sql);
                    ?>

                    <div class="container">
                        <form method="POST">
                            <div class="form-group row my-0">
                                <label for="cr_pcc6" class="col-sm-4 col-form-label">CR PCC 6</label>
                                <div class="col-sm-8">
                                    <input type="number_format" style="height:30px" class="form-control" id="cr_pcc6" name="cr_pcc6" >
                                </div>
                            </div>

                            <div class="form-group row my-0">
                                <label for="cr_pcc7" class="col-sm-4 col-form-label">CR PCC 7</label>
                                <div class="col-sm-8">
                                    <input type="number_format" style="height:30px" class="form-control" id="cr_pcc7" name="cr_pcc7" >
                                </div>
                            </div>

                            <div class="form-group row my-0">
                                <label for="cr_pcc8" class=" col-sm-4 col-form-label">CR PCC 8</label>
                                <div class="col-sm-8">
                                    <input type="number_format" style="height:30px" class="form-control" id="cr_pcc8" name="cr_pcc8" >
                                </div>
                            </div>
                             <div class="form-group row my-0">
                                <label for="cr_pcc9" class="col-sm-4 col-form-label">CR PCC 9</label>
                                <div class="col-sm-8">
                                    <input type="number_format" style="height:30px" class="form-control" id="cr_pcc9" name="cr_pcc9" >
                                </div>
                            </div>

                            <div class="form-group row my-0">
                                <label for="cr_pcc10" class="col-sm-4 col-form-label">CR PCC 10</label>
                                <div class="col-sm-8">
                                    <input type="number_format" style="height:30px" class="form-control" id="cr_pcc10" name="cr_pcc10" >
                                </div>
                            </div>

                            <div class="form-group row my-0">
                                <label for="cr_pcc11" class=" col-sm-4 col-form-label">CR PCC 11</label>
                                <div class="col-sm-8">
                                    <input type="number_format" style="height:30px" class="form-control" id="cr_pcc11" name="cr_pcc11" >
                                </div>
                            </div>
                            <div class="form-group row my-0">
                                <label for="cr_pcc12" class=" col-sm-4 col-form-label">CR PCC 12</label>
                                <div class="col-sm-8">
                                    <input type="number_format" style="height:30px" class="form-control" id="cr_pcc12" name="cr_pcc12" >
                                </div>
                            </div>
                            
                            
                            <div class="form-group mt-4">
                                <button type="submit" name="submit_pcc" value="submit" id="submit_pcc" class="btn btn-primary pl-4 pr-4">Save</button>
                                <button type="button" class="btn btn-danger pl-4 pr-4" data-dismiss="modal">Close</button>
                            </div>
                    </form>
                 </div>
            </div>
        </div>
    </div>
</div>

        <h5><label style="margin-bottom: 10px;">Pencapaian Faktor Klinker PCC</label></h5>
        <?php
             include "../include/database.php";

             $target2 = 0;
             $sql = "SELECT * FROM tbconfig";
                $q = mysqli_query($conn, $sql);
                while ($d = mysqli_fetch_array($q)) {
                    if ($d['nama_config'] == 'target2') $target2 = $d['nilai'];
                }
                $target2 = isset($_POST['target2']) ? $_POST['target2'] : $target2;
                if (isset($_POST['update'])) {
                    $sql = "UPDATE tbconfig set nilai='$target2' where nama_config='target2'";
                    mysqli_query($conn, $sql);
                }
            ?>
                <?php if ($level == '3'): ?>
                 <div class="container">
                    <form action="" method="POST" class="mt-3">
                        <div class="form-group row my-0">
                            <div class="col-sm-5">
                                <input type="text" style="height:30px" PLA class="form-control"  id="target2" name="target2" value="<?= $target2; ?>"placeholder=" Update target" >
                            </div>
                        </div>
                         <div class="form-group row mt-3">
                            <div class="col-sm-12">
                                <button type="submit" name="update" value="Update" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                <?php endif; ?>
              <canvas id="myChart1"></canvas>
        </div>
        <div class="box">
             <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <?php if ( $level == '3'): ?>
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#opc"><i class="fa fa-fw fa-plus-circle"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php

   
    $cr_opc6 = !empty($_POST['cr_opc6']) ? $_POST['cr_opc6'] : NULL;
    $cr_opc7 = !empty($_POST['cr_opc7']) ? $_POST['cr_opc7'] : NULL;
    $cr_opc8 = !empty($_POST['cr_opc8']) ? $_POST['cr_opc8'] : NULL;
    $cr_opc8 = !empty($_POST['cr_opc8']) ? $_POST['cr_opc8'] : NULL;
    $cr_opc9 = !empty($_POST['cr_opc9']) ? $_POST['cr_opc9'] : NULL;
    $cr_opc10 = !empty($_POST['cr_opc10']) ? $_POST['cr_opc10'] : NULL;
    $cr_opc11 = !empty($_POST['cr_opc11']) ? $_POST['cr_opc11'] : NULL;
    $cr_opc12 = !empty($_POST['cr_opc12']) ? $_POST['cr_opc12'] : NULL;
    
    


    ?>


    <div class="modal fade" id="opc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title " id="exampleModalLabel">Add Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php

                    include "../include/database_full.php";
                    
                    date_default_timezone_set('Asia/Jakarta');

                    if (isset($_POST['submit_opc'])) {
                        $waktu = date("H:i:s");
                        $tanggal = date("Y-m-d");
                        
                        $sql = "INSERT opc_2024 (TANGGAL, cr_opc6, cr_opc7, cr_opc8, cr_opc9, cr_opc10, cr_opc11, cr_opc12) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = mysqli_prepare($conn, $sql);

                            mysqli_stmt_bind_param($stmt, "ssssssss", $tanggal, $cr_opc6, $cr_opc7, $cr_opc8, $cr_opc9, $cr_opc10, $cr_opc11, $cr_opc12 );
                            
                            mysqli_stmt_execute($stmt);

                            if (mysqli_stmt_affected_rows($stmt) > 0) {
                                echo "<script>window.location = 'halaman_depan.php'</script>";
                            } else {
                                echo "Gagal menambahkan data.";
                            }

                            mysqli_stmt_close($stmt);
                        }

                    $sql = "Select * from opc_2024";
                    $q = mysqli_query($conn, $sql);
                    ?>

                    <div class="container">
                        <form method="POST">
                            
                            <div class="form-group row my-0">
                                <label for="cr_opc6" class="col-sm-4 col-form-label">CR OPC 6</label>
                                <div class="col-sm-8">
                                    <input type="number_format" style="height:30px" class="form-control" id="cr_opc6" name="cr_opc6" >
                                </div>
                            </div>

                            <div class="form-group row my-0">
                                <label for="cr_opc7" class="col-sm-4 col-form-label">CR OPC 7</label>
                                <div class="col-sm-8">
                                    <input type="number_format" style="height:30px" class="form-control" id="cr_opc7" name="cr_opc7" >
                                </div>
                            </div>

                            <div class="form-group row my-0">
                                <label for="cr_opc8" class=" col-sm-4 col-form-label">CR OPC 8</label>
                                <div class="col-sm-8">
                                    <input type="number_format" style="height:30px" class="form-control" id="cr_opc8" name="cr_opc8" >
                                </div>
                            </div>
                             <div class="form-group row my-0">
                                <label for="cr_opc9" class="col-sm-4 col-form-label">CR OPC 9</label>
                                <div class="col-sm-8">
                                    <input type="number_format" style="height:30px" class="form-control" id="cr_opc9" name="cr_opc9" >
                                </div>
                            </div>

                            <div class="form-group row my-0">
                                <label for="cr_opc10" class="col-sm-4 col-form-label">CR OPC 10</label>
                                <div class="col-sm-8">
                                    <input type="number_format" style="height:30px" class="form-control" id="cr_opc10" name="cr_opc10" >
                                </div>
                            </div>

                            <div class="form-group row my-0">
                                <label for="cr_opc11" class=" col-sm-4 col-form-label">CR OPC 11</label>
                                <div class="col-sm-8">
                                    <input type="number_format" style="height:30px" class="form-control" id="cr_opc11" name="cr_opc11" >
                                </div>
                            </div>
                            <div class="form-group row my-0">
                                <label for="cr_opc12" class=" col-sm-4 col-form-label">CR OPC 12</label>
                                <div class="col-sm-8">
                                    <input type="number_format" style="height:30px" class="form-control" id="cr_opc12" name="cr_opc12" >
                                </div>
                            </div>
                           
                            
                            <div class="form-group mt-4">
                               <button type="submit" name="submit_opc" value="submit" id="submit_opc" class="btn btn-primary pl-4 pr-4">Save</button>
                                <button type="button" class="btn btn-danger pl-4 pr-4" data-dismiss="modal">Close</button>
                            </div>
                    </form>
                 </div>
            </div>
        </div>
    </div>
</div>

        	 <h5><label style="margin-bottom: 10px;">Pencapaian Faktor Klinker OPC</label></h5>
             <?php
             include "../include/database.php";

             $target1 = 0;
             $sql = "SELECT * FROM tbconfig";
                $q = mysqli_query($conn, $sql);
                while ($d = mysqli_fetch_array($q)) {
                    if ($d['nama_config'] == 'target1') $target1 = $d['nilai'];
                }
                $target1 = isset($_POST['target1']) ? $_POST['target1'] : $target1;
                if (isset($_POST['update'])) {
                    $sql = "UPDATE tbconfig set nilai='$target1' where nama_config='target1'";
                    mysqli_query($conn, $sql);
                }
            ?>
                <?php if ($level == '3'): ?>
                <div class="container">
                    <form action="" method="POST" class="mt-3">
                        <div class="form-group row my-0">
                            <div class="col-sm-5">
                                <input type="text" style="height:30px" class="form-control" id="target1" name="target1" value="<?= $target1; ?>" placeholder="Update target">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-sm-12">
                                <button type="submit" name="update" value="Update" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

              <canvas id="myChart2"></canvas>
        </div>
        <div class="box">
        	<h5><label style="margin-bottom: 10px;">Rekap Proporsi Clay & Iron Sand</label></h5>
                    <?php
        include "../include/database_full.php"; 

        if (isset($_POST['update'])) {
            $BULAN_e = isset($_POST['BULAN_e']) && $_POST['BULAN_e'] !== '' ? $_POST['BULAN_e'] : NULL;
            $clay_4r1_e = isset($_POST['clay_4r1_e']) && $_POST['clay_4r1_e'] !== '' ? $_POST['clay_4r1_e'] : NULL;
            $is_4r1_e = isset($_POST['is_4r1_e']) && $_POST['is_4r1_e'] !== '' ? $_POST['is_4r1_e'] : NULL;
            $clay_4r2_e = isset($_POST['clay_4r2_e']) && $_POST['clay_4r2_e'] !== '' ? $_POST['clay_4r2_e'] : NULL;
            $is_4r2_e = isset($_POST['is_4r2_e']) && $_POST['is_4r2_e'] !== '' ? $_POST['is_4r2_e'] : NULL;
            $clay_5r1_e = isset($_POST['clay_5r1_e']) && $_POST['clay_5r1_e'] !== '' ? $_POST['clay_5r1_e'] : NULL;
            $is_5r1_e = isset($_POST['is_5r1_e']) && $_POST['is_5r1_e'] !== '' ? $_POST['is_5r1_e'] : NULL;
            $clay_5r2_e = isset($_POST['clay_5r2_e']) && $_POST['clay_5r2_e'] !== '' ? $_POST['clay_5r2_e'] : NULL;
            $is_5r2_e = isset($_POST['is_5r2_e']) && $_POST['is_5r2_e'] !== '' ? $_POST['is_5r2_e'] : NULL;
            $clay_6_e = isset($_POST['clay_6_e']) && $_POST['clay_6_e'] !== '' ? $_POST['clay_6_e'] : NULL;
            $is_6_e = isset($_POST['is_6_e']) && $_POST['is_6_e'] !== '' ? $_POST['is_6_e'] : NULL;
            $is_avg_e = isset($_POST['is_avg_e']) && $_POST['is_avg_e'] !== '' ? $_POST['is_avg_e'] : NULL;
            $clay_avg_e = isset($_POST['clay_avg_e']) && $_POST['clay_avg_e'] !== '' ? $_POST['clay_avg_e'] : NULL;
            $id_e = isset($_POST['id_e']) && $_POST['id_e'] !== '' ? $_POST['id_e'] : NULL;

            if (!empty($id_e)) {
                $sql = "UPDATE proporsi_2024 SET BULAN = ?, clay_4r1 = ?, is_4r1 = ?, clay_4r2 = ?, is_4r2 = ?, clay_5r1 = ?, is_5r1 = ?, clay_5r2 = ?, is_5r2 = ?, clay_6 = ?, is_6 = ?, is_avg = ?, clay_avg = ? WHERE id = ?";

                $stmt = mysqli_prepare($conn, $sql);

                if ($stmt === false) {
                    die("Error preparing the SQL statement: " . mysqli_error($conn));
                }

                mysqli_stmt_bind_param($stmt, "sssssssssssssi", $BULAN_e, $clay_4r1_e, $is_4r1_e, $clay_4r2_e, $is_4r2_e, $clay_5r1_e, $is_5r1_e, $clay_5r2_e, $is_5r2_e, $clay_6_e,  $is_6_e, $is_avg_e, $clay_avg_e, $id_e);

                if (mysqli_stmt_execute($stmt)) {
                    echo "<script>window.location = 'halaman_depan.php'</script>";
                }

                mysqli_stmt_close($stmt);
            }
        }

       if (isset($_POST['submit'])) {
        $BULAN = !empty($_POST['BULAN']) ? "'".$_POST['BULAN']."'" : 'NULL';
        $clay_4r1 = !empty($_POST['clay_4r1']) ? "'".$_POST['clay_4r1']."'" : 'NULL';
        $is_4r1 = !empty($_POST['is_4r1']) ? "'".$_POST['is_4r1']."'" : 'NULL';
        $clay_4r2 = !empty($_POST['clay_4r2']) ? "'".$_POST['clay_4r2']."'" : 'NULL';
        $is_4r2 = !empty($_POST['is_4r2']) ? "'".$_POST['is_4r2']."'" : 'NULL';
        $clay_5r1 = !empty($_POST['clay_5r1']) ? "'".$_POST['clay_5r1']."'" : 'NULL';
        $is_5r1 = !empty($_POST['is_5r1']) ? "'".$_POST['is_5r1']."'" : 'NULL';
        $clay_5r2 = !empty($_POST['clay_5r2']) ? "'".$_POST['clay_5r2']."'" : 'NULL';
        $is_5r2 = !empty($_POST['is_5r2']) ? "'".$_POST['is_5r2']."'" : 'NULL';
        $clay_6 = !empty($_POST['clay_6']) ? "'".$_POST['clay_6']."'" : 'NULL';
        $is_6 = !empty($_POST['is_6']) ? "'".$_POST['is_6']."'" : 'NULL';
        $clay_avg = !empty($_POST['clay_avg']) ? "'".$_POST['clay_avg']."'" : 'NULL';
        $is_avg = !empty($_POST['is_avg']) ? "'".$_POST['is_avg']."'" : 'NULL';

        $sql = "INSERT INTO proporsi_2024 (BULAN, clay_4r1, is_4r1, clay_4r2, is_4r2, clay_5r1, is_5r1, clay_5r2, is_5r2, clay_6, is_6, clay_avg, is_avg)
                VALUES ($BULAN, $clay_4r1, $is_4r1, $clay_4r2, $is_4r2, $clay_5r1, $is_5r1, $clay_5r2, $is_5r2, $clay_6, $is_6, $clay_avg, $is_avg)";

        if ($conn->query($sql) === TRUE) {
            echo "Data successfully inserted.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }


        $sql = "SELECT * FROM proporsi_2024";
        $result = $conn->query($sql);
        ?>
           <div class="container">
            <form method="POST" action="">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th rowspan="2">Bulan</th>
                            <th colspan="2">4R1</th>
                            <th colspan="2">4R2</th>
                            <th colspan="2">5R1</th>
                            <th colspan="2">5R2</th>
                            <th colspan="2">6R1</th>
                            <th colspan="2">AVG</th><?php if ($level == '3'): ?>
                            <th rowspan="2">ACTION</th>
                            <?php endif; ?>
                        </tr>
                        <tr class="bg-primary text-white">
                            <th>Clay</th>
                            <th>IS</th>
                            <th>Clay</th>
                            <th>IS</th>
                            <th>Clay</th>
                            <th>IS</th>
                            <th>Clay</th>
                            <th>IS</th>
                            <th>Clay</th>
                            <th>IS</th>
                            <th>Clay</th>
                            <th>IS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($d = mysqli_fetch_array($result)) : ?>
                        <tr>
                            <td><?php echo $d['BULAN']; ?></td>
                            <td><?php echo $d['clay_4r1']; ?></td>
                            <td><?php echo $d['is_4r1']; ?></td>
                            <td><?php echo $d['clay_4r2']; ?></td>
                            <td><?php echo $d['is_4r2']; ?></td>
                            <td><?php echo $d['clay_5r1']; ?></td>
                            <td><?php echo $d['is_5r1']; ?></td>
                            <td><?php echo $d['clay_5r2']; ?></td>
                            <td><?php echo $d['is_5r2']; ?></td>
                            <td><?php echo $d['clay_6']; ?></td>
                            <td><?php echo $d['is_6']; ?></td>
                            <td><?php echo $d['clay_avg']; ?></td>
                            <td><?php echo $d['is_avg']; ?></td>
                            <?php if ($level == '3'): ?>
                            <td align="center">
                                <a href="#" type="button" style="height:34px" class="btn btn-success btn-md pl-4 pr-4" data-toggle="modal" data-target="#myModal<?php echo $d['id']; ?>"><i class="fa fa-fw fa-edit"></i>Edit</a>
                            </td>
                            <?php endif; ?>
                        </tr>

                        <div class="modal fade" id="myModal<?php echo $d['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" action="" method="POST">
                                            <input type="hidden" name="id_e" value="<?php echo $d['id']; ?>">
                                            <div class="form-group row my-0">
                                                <label for="BULAN" class="col-sm-4 col-form-label">BULAN</label>
                                                <div class="col-sm-8">
                                                    <input type="text" style="height:30px" class="form-control" id="BULAN_e" name="BULAN_e" value="<?php echo $d['BULAN']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row my-0">
                                                <label for="clay_4r1" class="col-sm-4 col-form-label">Clay 4R1</label>
                                                <div class="col-sm-8">
                                                    <input type="text" style="height:30px" class="form-control" id="clay_4r1_e" name="clay_4r1_e" value="<?php echo $d['clay_4r1']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row my-0">
                                                <label for="is_4r1" class="col-sm-4 col-form-label">IS 4R1</label>
                                                <div class="col-sm-8">
                                                    <input type="text" style="height:30px" class="form-control" id="is_4r1_e" name="is_4r1_e" value="<?php echo $d['is_4r1']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row my-0">
                                                <label for="clay_4r2" class="col-sm-4 col-form-label">CLAY 4R2</label>
                                                <div class="col-sm-8">
                                                    <input type="text" style="height:30px" class="form-control" id="clay_4r2_e" name="clay_4r2_e" value="<?php echo $d['clay_4r2']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row my-0">
                                                <label for="is_4r2" class="col-sm-4 col-form-label">IS 4R2</label>
                                                <div class="col-sm-8">
                                                    <input type="text" style="height:30px" class="form-control" id="is_4r2_e" name="is_4r2_e" value="<?php echo $d['is_4r2']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row my-0">
                                                <label for="clay_5r1" class="col-sm-4 col-form-label">CLAY 5R1</label>
                                                <div class="col-sm-8">
                                                    <input type="text" style="height:30px" class="form-control" id="clay_5r1_e" name="clay_5r1_e" value="<?php echo $d['clay_5r1']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row my-0">
                                                <label for="is_5r1" class="col-sm-4 col-form-label">IS 5R1</label>
                                                <div class="col-sm-8">
                                                    <input type="text" style="height:30px" class="form-control" id="is_5r1_e" name="is_5r1_e" value="<?php echo $d['is_5r1']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row my-0">
                                                <label for="clay_5r2" class="col-sm-4 col-form-label">CLAY 5R2</label>
                                                <div class="col-sm-8">
                                                    <input type="text" style="height:30px" class="form-control" id="clay_5r2_e" name="clay_5r2_e" value="<?php echo $d['clay_5r2']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row my-0">
                                                <label for="is_5r2" class="col-sm-4 col-form-label">IS 5R2</label>
                                                <div class="col-sm-8">
                                                    <input type="text" style="height:30px" class="form-control" id="is_5r2_e" name="is_5r2_e" value="<?php echo $d['is_5r2']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row my-0">
                                                <label for="clay_6" class="col-sm-4 col-form-label">CLAY 6R1</label>
                                                <div class="col-sm-8">
                                                    <input type="text" style="height:30px" class="form-control" id="clay_6_e" name="clay_6_e" value="<?php echo $d['clay_6']; ?>">
                                                </div>
                                            </div>
                                             <div class="form-group row my-0">
                                                <label for="is_6" class="col-sm-4 col-form-label">IS 6R1</label>
                                                <div class="col-sm-8">
                                                    <input type="text" style="height:30px" class="form-control" id="is_6_e" name="is_6_e" value="<?php echo $d['is_6']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row my-0">
                                                <label for="clay_avg" class="col-sm-4 col-form-label">CLAY AVG</label>
                                                <div class="col-sm-8">
                                                    <input type="text" style="height:30px" class="form-control" id="clay_avg_e" name="clay_avg_e" value="<?php echo $d['clay_avg']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row my-0">
                                                <label for="is_avg" class="col-sm-4 col-form-label">IS AVG</label>
                                                <div class="col-sm-8">
                                                    <input type="text" style="height:30px" class="form-control" id="is_avg_e" name="is_avg_e" value="<?php echo $d['is_avg']; ?>">
                                                </div>
                                            </div>
                                             <div class="form-group mt-4">
                                                <button type="submit" name="update" value="update" id="update" class="btn btn-primary">Update</button>
                                                <button type="button" class="btn btn-danger pl-4 pr-4" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </form>
        </div>

                <br></br>
                <?php if ($level == '3'): ?>
                <form method="POST" action="" >
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>Bulan</th>
                                <th>4R1 Clay</th>
                                <th>4R1 IS</th>
                                <th>4R2 Clay</th>
                                <th>4R2 IS</th>
                                <th>5R1 Clay</th>
                                <th>5R1 IS</th>
                                <th>5R2 Clay</th>
                                <th>5R2 IS</th>
                                <th>6R1 Clay</th>
                                <th>6R1 IS</th>
                                <th>AVG Clay</th>
                                <th>AVG IS</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td><input style="width: 100px" type="text" class="form-control" name="BULAN" ></td>
                                <td><input style="width: 40px" type="text" class="form-control" name="clay_4r1" ></td>
                                <td><input style="width: 40px" type="text" class="form-control" name="is_4r1" ></td>
                                <td><input style="width: 40px" type="text" class="form-control" name="clay_4r2" ></td>
                                <td><input style="width: 40px" type="text" class="form-control" name="is_4r2"></td>
                                <td><input style="width: 40px" type="text" class="form-control" name="clay_5r1" ></td>
                                <td><input style="width: 40px" type="text" class="form-control" name="is_5r1"></td>
                                <td><input style="width: 40px" type="text" class="form-control" name="clay_5r2" ></td>
                                <td><input style="width: 40px" type="text" class="form-control" name="is_5r2" ></td>
                                <td><input style="width: 40px" type="text" class="form-control" name="clay_6" ></td>
                                <td><input style="width: 40px" type="text" class="form-control" name="is_6"></td>
                                <td><input style="width: 40px" type="text" class="form-control" name="clay_avg" ></td>
                                <td><input style="width: 40px" type="text" class="form-control" name="is_avg" ></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" name="submit" class="btn btn-primary">Tambah Data</button>
                </form>
                <?php endif; ?>
            </div>
          
       


    <div>
         <?php
        include "../include/database_full.php";

        $tgl = date('Y-m');
        $sql = "SELECT TANGGAL, cr_pcc6, cr_pcc7, cr_pcc8, cr_pcc9, cr_pcc10, cr_pcc11, cr_pcc12 FROM pcc_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";

        $result = $conn->query($sql);

        if ($result === false) {
            echo "Error: " . $conn->error;
            exit;
        }

        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $conn->close();
        ?>
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            const data = <?php echo json_encode($data); ?>;
            const labels = data.map(item => item.TANGGAL);
            const pcc6 = data.map(item => item.cr_pcc6);
            const pcc7 = data.map(item => item.cr_pcc7);
            const pcc8 = data.map(item => item.cr_pcc8);
            const pcc9 = data.map(item => item.cr_pcc9);
            const pcc10 = data.map(item => item.cr_pcc10);
            const pcc11 = data.map(item => item.cr_pcc11);
            const pcc12 = data.map(item => item.cr_pcc12);

            function createChart(ctx, labels, datasets) {
                return new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            annotation: {
                                annotations: {
                                    targetLine: {
                                        type: 'line',
                                        yMin: <?php echo $target2 ?>,
                                        yMax: <?php echo $target2 ?>,
                                        borderColor: 'red',
                                        borderWidth: 2,
                                        label: {
                                            content: 'Target FK: <?php echo $target2 ?>',
                                            enabled: true,
                                            position: 'start'
                                        }
                                        
                                    }
                                }
                            }
                        }
                    }
                });
            }

            const datasets = [
                {
                    label: 'PCC6',
                    data: pcc6,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'PCC7',
                    data: pcc7,
                    backgroundColor: 'rgba(192, 75, 75, 0.2)',
                    borderColor: 'rgba(192, 75, 75, 1)',
                    borderWidth: 1
                },
                {
                    label: 'PCC8',
                    data: pcc8,
                    backgroundColor: 'rgba(75, 75, 192, 0.2)',
                    borderColor: 'rgba(75, 75, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'PCC9',
                    data: pcc9,
                    backgroundColor: 'rgba(75, 192, 75, 0.2)',
                    borderColor: 'rgba(75, 192, 75, 1)',
                    borderWidth: 1
                },
                {
                    label: 'PCC10',
                    data: pcc10,
                    backgroundColor: 'rgba(192, 192, 75, 0.2)',
                    borderColor: 'rgba(192, 192, 75, 1)',
                    borderWidth: 1
                },
                {
                    label: 'PCC11',
                    data: pcc11,
                    backgroundColor: 'rgba(192, 75, 192, 0.2)',
                    borderColor: 'rgba(192, 75, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'PCC12',
                    data: pcc12,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ];

            const ctx1 = document.getElementById('myChart1').getContext('2d');
            createChart(ctx1, labels, datasets);
        });
    </script>

</div>
 <div>
         <?php
        include "../include/database_full.php";

        $tgl = date('Y-m');
        $sql = "SELECT TANGGAL, cr_opc6, cr_opc7, cr_opc8, cr_opc9, cr_opc10, cr_opc11, cr_opc12 FROM opc_2024 WHERE DATE_FORMAT(TANGGAL, '%Y-%m') = '$tgl'";

        $result = $conn->query($sql);

        if ($result === false) {
            echo "Error: " . $conn->error;
            exit;
        }

        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $conn->close();
        ?>
     <script>
        
        document.addEventListener('DOMContentLoaded', function () {
            const data = <?php echo json_encode($data); ?>;
            const labels = data.map(item => item.TANGGAL);
            const opc6 = data.map(item => item.cr_opc6);
            const opc7 = data.map(item => item.cr_opc7);
            const opc8 = data.map(item => item.cr_opc8);
            const opc9 = data.map(item => item.cr_opc9);
            const opc10 = data.map(item => item.cr_opc10);
            const opc11 = data.map(item => item.cr_opc11);
            const opc12 = data.map(item => item.cr_opc12);

            function createChart(ctx, labels, datasets) {
                return new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            annotation: {
                                annotations: {
                                    targetLine: {
                                        type: 'line',
                                        yMin:  <?php echo $target1 ?> ,
                                        yMax: <?php echo $target1 ?>,
                                        borderColor: 'red',
                                        borderWidth: 2,
                                       label: {
                                            content: 'Target FK: <?php echo $target1 ?>',
                                            enabled: true,
                                            position: 'start'
                                        } 
                                    }
                                }
                            }
                        }
                    }
                });
            }

            const datasets = [
                {
                    label: 'OPC6',
                    data: opc6,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'OPC7',
                    data: opc7,
                    backgroundColor: 'rgba(192, 75, 75, 0.2)',
                    borderColor: 'rgba(192, 75, 75, 1)',
                    borderWidth: 1
                },
                {
                    label: 'OPC8',
                    data: opc8,
                    backgroundColor: 'rgba(75, 75, 192, 0.2)',
                    borderColor: 'rgba(75, 75, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'OPC9',
                    data: opc9,
                    backgroundColor: 'rgba(75, 192, 75, 0.2)',
                    borderColor: 'rgba(75, 192, 75, 1)',
                    borderWidth: 1
                },
                {
                    label: 'OPC10',
                    data: opc10,
                    backgroundColor: 'rgba(192, 192, 75, 0.2)',
                    borderColor: 'rgba(192, 192, 75, 1)',
                    borderWidth: 1
                },
                {
                    label: 'OPC11',
                    data: opc11,
                    backgroundColor: 'rgba(192, 75, 192, 0.2)',
                    borderColor: 'rgba(192, 75, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'OPC12',
                    data: opc12,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ];

            const ctx1 = document.getElementById('myChart2').getContext('2d');
            createChart(ctx1, labels, datasets);
        });
    </script>
</div>
</body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/jquery.caret/0.1/jquery.caret.js"></script>
    <script src="https://www.solodev.com/_/assets/phone/jquery.mobilePhoneNumber.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
</html>
