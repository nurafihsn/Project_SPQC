<?php
session_start();
$level = strtoupper($_SESSION['level']);
if ($level == NULL) echo "<script>window.location = '../index.php'</script>";
include "../../include/database.php";
?>
<html>
<head>
  
<?php
$y = <<<HTML
<thead>
    <tr class="text-center">
        <th colspan="3"></th>
        <th colspan="3">MODOLUS</th>
        <th colspan="1"></th>
        <th colspan="9">OKSIDA</th>
        <th rowspan="2">H2O</th>
        <th rowspan="2">TONASE</th>
        <th rowspan="2">KAPASITAS</th>
        <th colspan="3"> LAYER </th>
    </tr>
    <tr class="bg-primary text-white">
        <th>id</th>
        <th>Tanggal</th>
        <th>JAM</th>
        <th>LSF</th>
        <th>SIM</th>
        <th>ALM</th>
        <th>ALKALI</th>
        <th>SiO2</th>
        <th>Al2O3</th>
        <th>Fe2O3</th>
        <th>CaO</th>
        <th>MgO</th>
        <th>SO3</th>
        <th>K2O</th>
        <th>Na2O</th>
        <th>Cl2</th>
        <th>TON</th>
        <th>LEVEL</th>
        <th>JUMLAH</th>
        <th>KETERANGAN</th>
    </tr>
</thead>
HTML;
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
	<h2 class="text-center">Data Pengisian LS Storage (CHEVRON) IND. 6  </h2>
    	<div class="container">
	    <table class="table table-striped table-bordered table-hover" id="all" style="background-color: yellow;">
            <thead>
                    <tr class="bg-primary text-white">
                        
                        <th>NO</th><th>PILE</th><th style="background-color : white"></th><th>Alakali</th><th>SiO2</th> <th>Al2O3</th><th>Si/Al</th><th style="background-color:  white"></th> <th>Dari</th><th>Sampai</th> <th>Jarak</th> <th style="background-color:  white"></th><th>Isi</th> <th>Speed</th> <th style="background-color:  white"></th><th>Level</th> <th>Layer</th> 
                    
                    </tr>
            </thead>
            <tbody>
		    <?php
			$sql1 = "SELECT * FROM lstg_6 WHERE TIANG = '26-35'";
			$sqla = "SELECT * FROM avglstg_6 WHERE TIANG = '26-35'";
			$q = mysqli_query($conn, $sql1);
			$p = mysqli_query($conn, $sqla);

			    while (($d = mysqli_fetch_array($q)) && ($e = mysqli_fetch_array($p))) {
			    		 
			?>		            
			<tr>
		                <td><?php echo $e['NO']; ?></td>
		                <td><?php echo $e['PILE']; ?></td>
		                <td style="background: white"></td>
		                <td><?php
						    $sum_query = mysqli_query($conn, "SELECT SUM(ALKALI) AS sum_alkali FROM lstg_6 WHERE TIANG = '26-35'");
						    $sum_result = mysqli_fetch_assoc($sum_query);
						    $sum_alkali = $sum_result['sum_alkali'];
						    $sum_alkali = number_format((float)$sum_alkali, 2, '.', '') ;

						    $update_query = "UPDATE avglstg_6 SET ALKALI = '$sum_alkali' WHERE TIANG = '26-35'";
						    if (mysqli_query($conn, $update_query)) {
						        echo $sum_alkali;
						    } else {
						        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						    }
						    ?></td>
		                <td>
		                <?php
						    $sum_query = mysqli_query($conn, "SELECT SUM(SiO2) AS sum_sio2 FROM lstg_6 WHERE TIANG = '26-35'");
						    $sum_result = mysqli_fetch_assoc($sum_query);
						    $sum_sio2 = $sum_result['sum_sio2'];
						    $sum_sio2 = number_format((float)$sum_sio2, 2, '.', '') ;

						    $update_query = "UPDATE avglstg_6 SET SiO2 = '$sum_sio2' WHERE TIANG = '26-35'";
						    if (mysqli_query($conn, $update_query)) {
						        echo $sum_sio2;
						    } else {
						        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						    }
						    ?></td>
		                <td><?php
						    $sum_query = mysqli_query($conn, "SELECT SUM(Al2O3) AS sum_al2o3 FROM lstg_6 WHERE TIANG = '26-35'");
						    $sum_result = mysqli_fetch_assoc($sum_query);
						    $sum_al2o3 = $sum_result['sum_al2o3'];
						    $sum_al2o3 = number_format((float)$sum_al2o3, 2, '.', '') ;

						    $update_query = "UPDATE avglstg_6 SET Al2O3 = '$sum_al2o3' WHERE TIANG = '26-35'";
						    if (mysqli_query($conn, $update_query)) {
						        echo $sum_al2o3;
						    } else {
						        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						    }
						    ?></td>

		                <td><?php
		                	$sioal = '';
					        if (!empty($e['SiO2'])) {
					            $sioal = ($e['SiO2']) / $e['Al2O3'];
					        }
					        $sioal = number_format((float)$sioal, 2, '.', '');

					         $update_query = "UPDATE avglstg_6 SET SioAl='$sioal' WHERE TIANG = '26-35' AND id=" . $d['id'];

					        if (mysqli_query($conn, $update_query)) {
							        echo "".$sioal." ";
							    } else {
							        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
							    }
		                ?></td>
		                <td style="background: white"></td>
		                <td><?php echo $e['DARI']; ?></td>
		                <td><?php echo $e['SAMPAI']; ?></td>
		                <td><?php echo $e['JARAK_1T']; ?></td>
		                <td style="background: white"></td>
		                <td>
						    <?php
						    $sum_query = mysqli_query($conn, "SELECT SUM(TONASE) AS sum_tonase FROM lstg_6 WHERE TIANG = '26-35'");
						    $sum_result = mysqli_fetch_assoc($sum_query);
						    $sum1 = $sum_result['sum_tonase'];

						    // Update nilai ISI di tabel avglstg_6
						    $update_query = "UPDATE avglstg_6 SET ISI = '$sum1' WHERE TIANG = '26-35'";
						    if (mysqli_query($conn, $update_query)) {
						        echo $sum1;
						    } else {
						        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						    }
						    ?>
						</td>
		                <td><?php echo $e['SPEED']; ?></td>
		                <td style="background: white"></td>
		                <td><?php
		                	$level = '';
					        if (!empty($sum1)) {
					            $level = ($sum1) / (($e['SAMPAI'] - $e['DARI'] ) * 18);
					        }
					        $level = number_format((float)$level, 2, '.', '') . '%';

					         $update_query = "UPDATE avglstg_6 SET LEVEL='$level' WHERE TIANG = '26-35' AND id=" . $d['id'];

					        if (mysqli_query($conn, $update_query)) {
							        echo "".$level." ";
							    } else {
							        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
							    }
		                ?></td>
		                <td><?php
						$sum_query = mysqli_query($conn, "SELECT SUM(JUMLAH) AS sum_jumlah FROM lstg_6 WHERE TIANG = '26-35'");
						$sum_result = mysqli_fetch_assoc($sum_query);
						$sumJ = $sum_result['sum_jumlah'];
						$sumJ = number_format((float)$sumJ, 2, '.', '');
						$update_query = "UPDATE avglstg_6 SET LAYER = '$sumJ' WHERE TIANG = '26-35' AND id=" . $d['id'];
						if (mysqli_query($conn, $update_query)) {
						    echo "".$sumJ."";
						} else {
						    echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						}
			                ?></td>
			        </tr>
			<?php
			    }
			?>
		</tbody>

		</table> </div>
        <div class="data-tables datatable-dark">
	    <div class="row">
	        <div class="col-sm-3">
	            <div class="form-group">
	                <a href="" class="btn btn-primary" data-toggle="modal" data-target="#addData"><i class="fa fa-fw fa-plus-circle"></i> Add Kapasitas</a>
	            </div>
	        </div>
	    </div>
         <table class="table table-striped table-bordered table-hover" id="1">
           <?php
			echo "<thead>";
			echo $y; 
			echo "</thead>";
			?>
          <tbody>
		    <?php
		    $sql = "SELECT lstg_6.*, avglstg_6.JARAK_1T, avglstg_6.SAMPAI, avglstg_6.DARI, avglstg_6.SPEED, avglstg_6.ISI 
		            FROM lstg_6 
		            JOIN avglstg_6 ON lstg_6.TIANG = avglstg_6.TIANG 
		            WHERE lstg_6.TIANG = '26-35'";
		    
		    $result = mysqli_query($conn, $sql);

		    if(mysqli_num_rows($result) > 0) {
		        while ($row = mysqli_fetch_assoc($result)) {
		            $ton = '';
		            if (!empty($row['KAPASITAS'])) {
		                $ton = ($row['JARAK_1T'] * ($row['SAMPAI'] - $row['DARI']) / $row['SPEED']) * $row['KAPASITAS'];
		            }
		            $ton = number_format((float)$ton, 2, '.', '');

		            $level1 = '';
		            if (!empty($row['TONASE'])) {
		                $level1 =  ($row['TONASE'] / $row['ISI']);
		            }
		            $level1 = number_format((float)$level1, 2, '.', '');

		            $jumlah = '';
		            if (!empty($row['TONASE'])) {
		                $jumlah = ($row['TONASE'] / $ton);
		            }
		            $jumlah = number_format((float)$jumlah, 2, '.', '');

		            $update_query = "UPDATE lstg_6 
		                             SET JUMLAH = '$jumlah', TON = '$ton', LEVEL = '$level1' 
		                             WHERE TIANG = '26-35' AND id=" . $row['id'];

		            if (mysqli_query($conn, $update_query)) {
		                // Tampilkan baris tabel
		                echo "<tr>";
		                echo "<td>{$row['id']}</td>";
		                echo "<td>{$row['TANGGAL']}</td>";
		                echo "<td>{$row['JAM']}</td>";
		                echo "<td>{$row['LSF']}</td>";
		                echo "<td>{$row['SIM']}</td>";
		                echo "<td>{$row['ALM']}</td>";
		                echo "<td>{$row['ALKALI']}</td>";
		                echo "<td>{$row['SiO2']}</td>";
		                echo "<td>{$row['Al2O3']}</td>";
		                echo "<td>{$row['Fe2O3']}</td>";
		                echo "<td>{$row['CaO']}</td>";
		                echo "<td>{$row['MgO']}</td>";
		                echo "<td>{$row['SO3']}</td>";
		                echo "<td>{$row['K2O']}</td>";
		                echo "<td>{$row['Na2O']}</td>";
		                echo "<td>{$row['Cl2']}</td>";
		                echo "<td>{$row['H2O']}</td>";
		                echo "<td>{$row['TONASE']}</td>";
		                echo "<td>{$row['KAPASITAS']}</td>";
		                echo "<td>{$ton}</td>";
		                echo "<td>{$level1}</td>";
		                echo "<td>{$jumlah}</td>";
		                echo "<td>{$row['KETERANGAN']}</td>";
		                echo "</tr>";
		            } else {
		                echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
		            }
		        }
		    }
		    ?>
		</tbody>

        </table>
  
	<div class="modal fade" id="addData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

					  if ($_SERVER["REQUEST_METHOD"] == "POST") {
		                    $kapasitas_ = $_POST['nilai_baru'];
		                    $id_ = $_POST['id'];

		                    $sql = "UPDATE lstg_6 SET KAPASITAS ='$kapasitas_' WHERE id=$id_";
		                    mysqli_query($conn, $sql);
		                    echo "<script>window.location = 'avglstg.php'</script>";
		                }

		                $sql = "Select * from lstg_6 ";
		                $q = mysqli_query($conn, $sql);
		                ?>

		                <div class="container">
		                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		                        <div class="form-group row my-0">
						            <label class="col-sm-4 col-form-label">ID</label>
						            <div class="col-sm-8">
						                <input type="text" style="height:30px" class="form-control" name="id">
						            </div>
						        </div>
						        <div class="form-group row my-0">
						            <label class="col-sm-4 col-form-label">Kapasitas</label>
						            <div class="col-sm-8">
						                <input type="text" style="height:30px" class="form-control" name="nilai_baru">
						            </div>
						        </div>
						        <div class="form-group row my-0">
						        	<label> note: tambahkan kapasitas sesuaikan dengan id yang ada</label>
						        </div>
						        <div class="form-group row my-0">
						            <div class="col-sm-4"></div>
						            <div class="col-sm-8">
						                <input type="submit" name="submit" value="Update" class="btn btn-primary pl-4 pr-4">
						            </div>
						        </div>
						    </form>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>

		<h2 class="text-center">Data Pengisian LS Storage (CHEVRON) IND. 6  </h2>
    	<div class="container">
	    <table class="table table-striped table-bordered table-hover" id="all" style="background-color: yellow;">
            <thead>
                    <tr class="bg-primary text-white">
                        
                        <th>NO</th><th>PILE</th><th style="background-color : white"></th><th>Alakali</th><th>SiO2</th> <th>Al2O3</th><th>Si/Al</th><th style="background-color:  white"></th> <th>Dari</th><th>Sampai</th> <th>Jarak</th> <th style="background-color:  white"></th><th>Isi</th> <th>Speed</th> <th style="background-color:  white"></th><th>Level</th> <th>Layer</th> 
                    
                    </tr>
            </thead>
            <tbody>
		    <?php
			$sql1 = "SELECT * FROM lstg_6 WHERE TIANG = '19-29'";
			$sqla = "SELECT * FROM avglstg_6 WHERE TIANG = '19-29'";
			$q = mysqli_query($conn, $sql1);
			$p = mysqli_query($conn, $sqla);

			    while (($d = mysqli_fetch_array($q)) && ($e = mysqli_fetch_array($p))) {
			    		 
			?>		            
			<tr>
		                <td><?php echo $e['NO']; ?></td>
		                <td><?php echo $e['PILE']; ?></td>
		                <td style="background: white"></td>
		                <td><?php
						    $sum_query = mysqli_query($conn, "SELECT SUM(ALKALI) AS sum_alkali FROM lstg_6 WHERE TIANG = '19-29'");
						    $sum_result = mysqli_fetch_assoc($sum_query);
						    $sum_alkali = $sum_result['sum_alkali'];
						    $sum_alkali = number_format((float)$sum_alkali, 2, '.', '') ;

						    $update_query = "UPDATE avglstg_6 SET ALKALI = '$sum_alkali' WHERE TIANG = '19-29'";
						    if (mysqli_query($conn, $update_query)) {
						        echo $sum_alkali;
						    } else {
						        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						    }
						    ?></td>
		                <td>
		                <?php
						    $sum_query = mysqli_query($conn, "SELECT SUM(SiO2) AS sum_sio2 FROM lstg_6 WHERE TIANG = '19-29'");
						    $sum_result = mysqli_fetch_assoc($sum_query);
						    $sum_sio2 = $sum_result['sum_sio2'];
						    $sum_sio2 = number_format((float)$sum_sio2, 2, '.', '') ;

						    $update_query = "UPDATE avglstg_6 SET SiO2 = '$sum_sio2' WHERE TIANG = '19-29'";
						    if (mysqli_query($conn, $update_query)) {
						        echo $sum_sio2;
						    } else {
						        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						    }
						    ?></td>
		                <td><?php
						    $sum_query = mysqli_query($conn, "SELECT SUM(Al2O3) AS sum_al2o3 FROM lstg_6 WHERE TIANG = '19-29'");
						    $sum_result = mysqli_fetch_assoc($sum_query);
						    $sum_al2o3 = $sum_result['sum_al2o3'];
						    $sum_al2o3 = number_format((float)$sum_al2o3, 2, '.', '') ;

						    $update_query = "UPDATE avglstg_6 SET Al2O3 = '$sum_al2o3' WHERE TIANG = '19-29'";
						    if (mysqli_query($conn, $update_query)) {
						        echo $sum_al2o3;
						    } else {
						        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						    }
						    ?></td>

		                <td><?php
		                	$sioal = '';
					        if (!empty($e['SiO2'])) {
					            $sioal = ($e['SiO2']) / $e['Al2O3'];
					        }
					        $sioal = number_format((float)$sioal, 2, '.', '');

					         $update_query = "UPDATE avglstg_6 SET SioAl='$sioal' WHERE TIANG = '19-29' AND id=" . $d['id'];

					        if (mysqli_query($conn, $update_query)) {
							        echo "".$sioal." ";
							    } else {
							        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
							    }
		                ?></td>
		                <td style="background: white"></td>
		                <td><?php echo $e['DARI']; ?></td>
		                <td><?php echo $e['SAMPAI']; ?></td>
		                <td><?php echo $e['JARAK_1T']; ?></td>
		                <td style="background: white"></td>
		                <td>
						    <?php
						    $sum_query = mysqli_query($conn, "SELECT SUM(TONASE) AS sum_tonase FROM lstg_6 WHERE TIANG = '19-29'");
						    $sum_result = mysqli_fetch_assoc($sum_query);
						    $sum1 = $sum_result['sum_tonase'];

						    // Update nilai ISI di tabel avglstg_6
						    $update_query = "UPDATE avglstg_6 SET ISI = '$sum1' WHERE TIANG = '19-29'";
						    if (mysqli_query($conn, $update_query)) {
						        echo $sum1;
						    } else {
						        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						    }
						    ?>
						</td>
		                <td><?php echo $e['SPEED']; ?></td>
		                <td style="background: white"></td>
		                <td><?php
		                	$level = '';
					        if (!empty($sum1)) {
					            $level = ($sum1) / (($e['SAMPAI'] - $e['DARI'] ) * 18);
					        }
					        $level = number_format((float)$level, 2, '.', '') . '%';

					         $update_query = "UPDATE avglstg_6 SET LEVEL='$level' WHERE TIANG = '19-29' AND id=" . $d['id'];

					        if (mysqli_query($conn, $update_query)) {
							        echo "".$level." ";
							    } else {
							        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
							    }
		                ?></td>
		                <td><?php
						$sum_query = mysqli_query($conn, "SELECT SUM(JUMLAH) AS sum_jumlah FROM lstg_6 WHERE TIANG = '19-29'");
						$sum_result = mysqli_fetch_assoc($sum_query);
						$sumJ = $sum_result['sum_jumlah'];
						$sumJ = number_format((float)$sumJ, 2, '.', '');
						$update_query = "UPDATE avglstg_6 SET LAYER = '$sumJ' WHERE TIANG = '19-29' AND id=" . $d['id'];
						if (mysqli_query($conn, $update_query)) {
						    echo "".$sumJ."";
						} else {
						    echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						}
			                ?></td>
			        </tr>
			<?php
			    }
			?>
		</tbody>

		</table> </div>
        <div class="data-tables datatable-dark">
	    <div class="row">
	        <div class="col-sm-3">
	            <div class="form-group">
	                <a href="" class="btn btn-primary" data-toggle="modal" data-target="#addData"><i class="fa fa-fw fa-plus-circle"></i> Add Kapasitas</a>
	            </div>
	        </div>
	    </div>
         <table class="table table-striped table-bordered table-hover" id="1">
           <?php
			echo "<thead>";
			echo $y; 
			echo "</thead>";
			?>
          <tbody>
		    <?php
		    $sql = "SELECT lstg_6.*, avglstg_6.JARAK_1T, avglstg_6.SAMPAI, avglstg_6.DARI, avglstg_6.SPEED, avglstg_6.ISI 
		            FROM lstg_6 
		            JOIN avglstg_6 ON lstg_6.TIANG = avglstg_6.TIANG 
		            WHERE lstg_6.TIANG = '19-29'";
		    
		    $result = mysqli_query($conn, $sql);

		    if(mysqli_num_rows($result) > 0) {
		        while ($row = mysqli_fetch_assoc($result)) {
		            $ton = '';
		            if (!empty($row['KAPASITAS'])) {
		                $ton = ($row['JARAK_1T'] * ($row['SAMPAI'] - $row['DARI']) / $row['SPEED']) * $row['KAPASITAS'];
		            }
		            $ton = number_format((float)$ton, 2, '.', '');

		            $level1 = '';
		            if (!empty($row['TONASE'])) {
		                $level1 =  ($row['TONASE'] / $row['ISI']);
		            }
		            $level1 = number_format((float)$level1, 2, '.', '');

		            $jumlah = '';
		            if (!empty($row['TONASE'])) {
		                $jumlah = ($row['TONASE'] / $ton);
		            }
		            $jumlah = number_format((float)$jumlah, 2, '.', '');

		            $update_query = "UPDATE lstg_6 
		                             SET JUMLAH = '$jumlah', TON = '$ton', LEVEL = '$level1' 
		                             WHERE TIANG = '19-29' AND id=" . $row['id'];

		            if (mysqli_query($conn, $update_query)) {
		                // Tampilkan baris tabel
		                echo "<tr>";
		                echo "<td>{$row['id']}</td>";
		                echo "<td>{$row['TANGGAL']}</td>";
		                echo "<td>{$row['JAM']}</td>";
		                echo "<td>{$row['LSF']}</td>";
		                echo "<td>{$row['SIM']}</td>";
		                echo "<td>{$row['ALM']}</td>";
		                echo "<td>{$row['ALKALI']}</td>";
		                echo "<td>{$row['SiO2']}</td>";
		                echo "<td>{$row['Al2O3']}</td>";
		                echo "<td>{$row['Fe2O3']}</td>";
		                echo "<td>{$row['CaO']}</td>";
		                echo "<td>{$row['MgO']}</td>";
		                echo "<td>{$row['SO3']}</td>";
		                echo "<td>{$row['K2O']}</td>";
		                echo "<td>{$row['Na2O']}</td>";
		                echo "<td>{$row['Cl2']}</td>";
		                echo "<td>{$row['H2O']}</td>";
		                echo "<td>{$row['TONASE']}</td>";
		                echo "<td>{$row['KAPASITAS']}</td>";
		                echo "<td>{$ton}</td>";
		                echo "<td>{$level1}</td>";
		                echo "<td>{$jumlah}</td>";
		                echo "<td>{$row['KETERANGAN']}</td>";
		                echo "</tr>";
		            } else {
		                echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
		            }
		        }
		    }
		    ?>
		</tbody>

        </table>
  
	<div class="modal fade" id="addData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

					  if ($_SERVER["REQUEST_METHOD"] == "POST") {
		                    $kapasitas_ = $_POST['nilai_baru'];
		                    $id_ = $_POST['id'];

		                    $sql = "UPDATE lstg_6 SET KAPASITAS ='$kapasitas_' WHERE id=$id_";
		                    mysqli_query($conn, $sql);
		                    echo "<script>window.location = 'avglstg.php'</script>";
		                }

		                $sql = "Select * from lstg_6 ";
		                $q = mysqli_query($conn, $sql);
		                ?>

		                <div class="container">
		                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		                        <div class="form-group row my-0">
						            <label class="col-sm-4 col-form-label">ID</label>
						            <div class="col-sm-8">
						                <input type="text" style="height:30px" class="form-control" name="id">
						            </div>
						        </div>
						        <div class="form-group row my-0">
						            <label class="col-sm-4 col-form-label">Kapasitas</label>
						            <div class="col-sm-8">
						                <input type="text" style="height:30px" class="form-control" name="nilai_baru">
						            </div>
						        </div>
						        <div class="form-group row my-0">
						        	<label> note: tambahkan kapasitas sesuaikan dengan id yang ada</label>
						        </div>
						        <div class="form-group row my-0">
						            <div class="col-sm-4"></div>
						            <div class="col-sm-8">
						                <input type="submit" name="submit" value="Update" class="btn btn-primary pl-4 pr-4">
						            </div>
						        </div>
						    </form>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>

		<h2 class="text-center">Data Pengisian LS Storage (CHEVRON) IND. 6  </h2>
    	<div class="container">
	    <table class="table table-striped table-bordered table-hover" id="all" style="background-color: yellow;">
            <thead>
                    <tr class="bg-primary text-white">
                        
                        <th>NO</th><th>PILE</th><th style="background-color : white"></th><th>Alakali</th><th>SiO2</th> <th>Al2O3</th><th>Si/Al</th><th style="background-color:  white"></th> <th>Dari</th><th>Sampai</th> <th>Jarak</th> <th style="background-color:  white"></th><th>Isi</th> <th>Speed</th> <th style="background-color:  white"></th><th>Level</th> <th>Layer</th> 
                    
                    </tr>
            </thead>
            <tbody>
		    <?php
			$sql1 = "SELECT * FROM lstg_6 WHERE TIANG = '10-16'";
			$sqla = "SELECT * FROM avglstg_6 WHERE TIANG = '10-16'";
			$q = mysqli_query($conn, $sql1);
			$p = mysqli_query($conn, $sqla);

			    while (($d = mysqli_fetch_array($q)) && ($e = mysqli_fetch_array($p))) {
			    		 
			?>		            
			<tr>
		                <td><?php echo $e['NO']; ?></td>
		                <td><?php echo $e['PILE']; ?></td>
		                <td style="background: white"></td>
		                <td><?php
						    $sum_query = mysqli_query($conn, "SELECT SUM(ALKALI) AS sum_alkali FROM lstg_6 WHERE TIANG = '10-16'");
						    $sum_result = mysqli_fetch_assoc($sum_query);
						    $sum_alkali = $sum_result['sum_alkali'];
						    $sum_alkali = number_format((float)$sum_alkali, 2, '.', '') ;

						    $update_query = "UPDATE avglstg_6 SET ALKALI = '$sum_alkali' WHERE TIANG = '10-16'";
						    if (mysqli_query($conn, $update_query)) {
						        echo $sum_alkali;
						    } else {
						        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						    }
						    ?></td>
		                <td>
		                <?php
						    $sum_query = mysqli_query($conn, "SELECT SUM(SiO2) AS sum_sio2 FROM lstg_6 WHERE TIANG = '10-16'");
						    $sum_result = mysqli_fetch_assoc($sum_query);
						    $sum_sio2 = $sum_result['sum_sio2'];
						    $sum_sio2 = number_format((float)$sum_sio2, 2, '.', '') ;

						    $update_query = "UPDATE avglstg_6 SET SiO2 = '$sum_sio2' WHERE TIANG = '10-16'";
						    if (mysqli_query($conn, $update_query)) {
						        echo $sum_sio2;
						    } else {
						        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						    }
						    ?></td>
		                <td><?php
						    $sum_query = mysqli_query($conn, "SELECT SUM(Al2O3) AS sum_al2o3 FROM lstg_6 WHERE TIANG = '10-16'");
						    $sum_result = mysqli_fetch_assoc($sum_query);
						    $sum_al2o3 = $sum_result['sum_al2o3'];
						    $sum_al2o3 = number_format((float)$sum_al2o3, 2, '.', '') ;

						    $update_query = "UPDATE avglstg_6 SET Al2O3 = '$sum_al2o3' WHERE TIANG = '10-16'";
						    if (mysqli_query($conn, $update_query)) {
						        echo $sum_al2o3;
						    } else {
						        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						    }
						    ?></td>

		                <td><?php
		                	$sioal = '';
					        if (!empty($e['SiO2'])) {
					            $sioal = ($e['SiO2']) / $e['Al2O3'];
					        }
					        $sioal = number_format((float)$sioal, 2, '.', '');

					         $update_query = "UPDATE avglstg_6 SET SioAl='$sioal' WHERE TIANG = '10-16' AND id=" . $d['id'];

					        if (mysqli_query($conn, $update_query)) {
							        echo "".$sioal." ";
							    } else {
							        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
							    }
		                ?></td>
		                <td style="background: white"></td>
		                <td><?php echo $e['DARI']; ?></td>
		                <td><?php echo $e['SAMPAI']; ?></td>
		                <td><?php echo $e['JARAK_1T']; ?></td>
		                <td style="background: white"></td>
		                <td>
						    <?php
						    $sum_query = mysqli_query($conn, "SELECT SUM(TONASE) AS sum_tonase FROM lstg_6 WHERE TIANG = '10-16'");
						    $sum_result = mysqli_fetch_assoc($sum_query);
						    $sum1 = $sum_result['sum_tonase'];

						    // Update nilai ISI di tabel avglstg_6
						    $update_query = "UPDATE avglstg_6 SET ISI = '$sum1' WHERE TIANG = '10-16'";
						    if (mysqli_query($conn, $update_query)) {
						        echo $sum1;
						    } else {
						        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						    }
						    ?>
						</td>
		                <td><?php echo $e['SPEED']; ?></td>
		                <td style="background: white"></td>
		                <td><?php
		                	$level = '';
					        if (!empty($sum1)) {
					            $level = ($sum1) / (($e['SAMPAI'] - $e['DARI'] ) * 18);
					        }
					        $level = number_format((float)$level, 2, '.', '') . '%';

					         $update_query = "UPDATE avglstg_6 SET LEVEL='$level' WHERE TIANG = '10-16' AND id=" . $d['id'];

					        if (mysqli_query($conn, $update_query)) {
							        echo "".$level." ";
							    } else {
							        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
							    }
		                ?></td>
		                <td><?php
						$sum_query = mysqli_query($conn, "SELECT SUM(JUMLAH) AS sum_jumlah FROM lstg_6 WHERE TIANG = '10-16'");
						$sum_result = mysqli_fetch_assoc($sum_query);
						$sumJ = $sum_result['sum_jumlah'];
						$sumJ = number_format((float)$sumJ, 2, '.', '');
						$update_query = "UPDATE avglstg_6 SET LAYER = '$sumJ' WHERE TIANG = '10-16' AND id=" . $d['id'];
						if (mysqli_query($conn, $update_query)) {
						    echo "".$sumJ."";
						} else {
						    echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						}
			                ?></td>
			        </tr>
			<?php
			    }
			?>
		</tbody>

		</table> </div>
        <div class="data-tables datatable-dark">
	    <div class="row">
	        <div class="col-sm-3">
	            <div class="form-group">
	                <a href="" class="btn btn-primary" data-toggle="modal" data-target="#addData"><i class="fa fa-fw fa-plus-circle"></i> Add Kapasitas</a>
	            </div>
	        </div>
	    </div>
         <table class="table table-striped table-bordered table-hover" id="1">
           <?php
			echo "<thead>";
			echo $y; 
			echo "</thead>";
			?>
          <tbody>
		    <?php
		    $sql = "SELECT lstg_6.*, avglstg_6.JARAK_1T, avglstg_6.SAMPAI, avglstg_6.DARI, avglstg_6.SPEED, avglstg_6.ISI 
		            FROM lstg_6 
		            JOIN avglstg_6 ON lstg_6.TIANG = avglstg_6.TIANG 
		            WHERE lstg_6.TIANG = '10-16'";
		    
		    $result = mysqli_query($conn, $sql);

		    if(mysqli_num_rows($result) > 0) {
		        while ($row = mysqli_fetch_assoc($result)) {
		            $ton = '';
		            if (!empty($row['KAPASITAS'])) {
		                $ton = ($row['JARAK_1T'] * ($row['SAMPAI'] - $row['DARI']) / $row['SPEED']) * $row['KAPASITAS'];
		            }
		            $ton = number_format((float)$ton, 2, '.', '');

		            $level1 = '';
		            if (!empty($row['TONASE'])) {
		                $level1 =  ($row['TONASE'] / $row['ISI']);
		            }
		            $level1 = number_format((float)$level1, 2, '.', '');

		            $jumlah = '';
		            if (!empty($row['TONASE'])) {
		                $jumlah = ($row['TONASE'] / $ton);
		            }
		            $jumlah = number_format((float)$jumlah, 2, '.', '');

		            $update_query = "UPDATE lstg_6 
		                             SET JUMLAH = '$jumlah', TON = '$ton', LEVEL = '$level1' 
		                             WHERE TIANG = '10-16' AND id=" . $row['id'];

		            if (mysqli_query($conn, $update_query)) {
		                // Tampilkan baris tabel
		                echo "<tr>";
		                echo "<td>{$row['id']}</td>";
		                echo "<td>{$row['TANGGAL']}</td>";
		                echo "<td>{$row['JAM']}</td>";
		                echo "<td>{$row['LSF']}</td>";
		                echo "<td>{$row['SIM']}</td>";
		                echo "<td>{$row['ALM']}</td>";
		                echo "<td>{$row['ALKALI']}</td>";
		                echo "<td>{$row['SiO2']}</td>";
		                echo "<td>{$row['Al2O3']}</td>";
		                echo "<td>{$row['Fe2O3']}</td>";
		                echo "<td>{$row['CaO']}</td>";
		                echo "<td>{$row['MgO']}</td>";
		                echo "<td>{$row['SO3']}</td>";
		                echo "<td>{$row['K2O']}</td>";
		                echo "<td>{$row['Na2O']}</td>";
		                echo "<td>{$row['Cl2']}</td>";
		                echo "<td>{$row['H2O']}</td>";
		                echo "<td>{$row['TONASE']}</td>";
		                echo "<td>{$row['KAPASITAS']}</td>";
		                echo "<td>{$ton}</td>";
		                echo "<td>{$level1}</td>";
		                echo "<td>{$jumlah}</td>";
		                echo "<td>{$row['KETERANGAN']}</td>";
		                echo "</tr>";
		            } else {
		                echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
		            }
		        }
		    }
		    ?>
		</tbody>

        </table>
  
	<div class="modal fade" id="addData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

					  if ($_SERVER["REQUEST_METHOD"] == "POST") {
		                    $kapasitas_ = $_POST['nilai_baru'];
		                    $id_ = $_POST['id'];

		                    $sql = "UPDATE lstg_6 SET KAPASITAS ='$kapasitas_' WHERE id=$id_";
		                    mysqli_query($conn, $sql);
		                    echo "<script>window.location = 'avglstg.php'</script>";
		                }

		                $sql = "Select * from lstg_6 ";
		                $q = mysqli_query($conn, $sql);
		                ?>

		                <div class="container">
		                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		                        <div class="form-group row my-0">
						            <label class="col-sm-4 col-form-label">ID</label>
						            <div class="col-sm-8">
						                <input type="text" style="height:30px" class="form-control" name="id">
						            </div>
						        </div>
						        <div class="form-group row my-0">
						            <label class="col-sm-4 col-form-label">Kapasitas</label>
						            <div class="col-sm-8">
						                <input type="text" style="height:30px" class="form-control" name="nilai_baru">
						            </div>
						        </div>
						        <div class="form-group row my-0">
						        	<label> note: tambahkan kapasitas sesuaikan dengan id yang ada</label>
						        </div>
						        <div class="form-group row my-0">
						            <div class="col-sm-4"></div>
						            <div class="col-sm-8">
						                <input type="submit" name="submit" value="Update" class="btn btn-primary pl-4 pr-4">
						            </div>
						        </div>
						    </form>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>

		<h2 class="text-center">Data Pengisian LS Storage (CHEVRON) IND. 6  </h2>
    	<div class="container">
	    <table class="table table-striped table-bordered table-hover" id="all" style="background-color: yellow;">
            <thead>
                    <tr class="bg-primary text-white">
                        
                        <th>NO</th><th>PILE</th><th style="background-color : white"></th><th>Alakali</th><th>SiO2</th> <th>Al2O3</th><th>Si/Al</th><th style="background-color:  white"></th> <th>Dari</th><th>Sampai</th> <th>Jarak</th> <th style="background-color:  white"></th><th>Isi</th> <th>Speed</th> <th style="background-color:  white"></th><th>Level</th> <th>Layer</th> 
                    
                    </tr>
            </thead>
            <tbody>
		    <?php
			$sql1 = "SELECT * FROM lstg_6 WHERE TIANG = '30-35'";
			$sqla = "SELECT * FROM avglstg_6 WHERE TIANG = '30-35'";
			$q = mysqli_query($conn, $sql1);
			$p = mysqli_query($conn, $sqla);

			    while (($d = mysqli_fetch_array($q)) && ($e = mysqli_fetch_array($p))) {
			    		 
			?>		            
			<tr>
		                <td><?php echo $e['NO']; ?></td>
		                <td><?php echo $e['PILE']; ?></td>
		                <td style="background: white"></td>
		                <td><?php
						    $sum_query = mysqli_query($conn, "SELECT SUM(ALKALI) AS sum_alkali FROM lstg_6 WHERE TIANG = '30-35'");
						    $sum_result = mysqli_fetch_assoc($sum_query);
						    $sum_alkali = $sum_result['sum_alkali'];
						    $sum_alkali = number_format((float)$sum_alkali, 2, '.', '') ;

						    $update_query = "UPDATE avglstg_6 SET ALKALI = '$sum_alkali' WHERE TIANG = '30-35'";
						    if (mysqli_query($conn, $update_query)) {
						        echo $sum_alkali;
						    } else {
						        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						    }
						    ?></td>
		                <td>
		                <?php
						    $sum_query = mysqli_query($conn, "SELECT SUM(SiO2) AS sum_sio2 FROM lstg_6 WHERE TIANG = '30-35'");
						    $sum_result = mysqli_fetch_assoc($sum_query);
						    $sum_sio2 = $sum_result['sum_sio2'];
						    $sum_sio2 = number_format((float)$sum_sio2, 2, '.', '') ;

						    $update_query = "UPDATE avglstg_6 SET SiO2 = '$sum_sio2' WHERE TIANG = '30-35'";
						    if (mysqli_query($conn, $update_query)) {
						        echo $sum_sio2;
						    } else {
						        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						    }
						    ?></td>
		                <td><?php
						    $sum_query = mysqli_query($conn, "SELECT SUM(Al2O3) AS sum_al2o3 FROM lstg_6 WHERE TIANG = '30-35'");
						    $sum_result = mysqli_fetch_assoc($sum_query);
						    $sum_al2o3 = $sum_result['sum_al2o3'];
						    $sum_al2o3 = number_format((float)$sum_al2o3, 2, '.', '') ;

						    $update_query = "UPDATE avglstg_6 SET Al2O3 = '$sum_al2o3' WHERE TIANG = '30-35'";
						    if (mysqli_query($conn, $update_query)) {
						        echo $sum_al2o3;
						    } else {
						        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						    }
						    ?></td>

		                <td><?php
		                	$sioal = '';
					        if (!empty($e['SiO2'])) {
					            $sioal = ($e['SiO2']) / $e['Al2O3'];
					        }
					        $sioal = number_format((float)$sioal, 2, '.', '');

					         $update_query = "UPDATE avglstg_6 SET SioAl='$sioal' WHERE TIANG = '30-35' AND id=" . $d['id'];

					        if (mysqli_query($conn, $update_query)) {
							        echo "".$sioal." ";
							    } else {
							        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
							    }
		                ?></td>
		                <td style="background: white"></td>
		                <td><?php echo $e['DARI']; ?></td>
		                <td><?php echo $e['SAMPAI']; ?></td>
		                <td><?php echo $e['JARAK_1T']; ?></td>
		                <td style="background: white"></td>
		                <td>
						    <?php
						    $sum_query = mysqli_query($conn, "SELECT SUM(TONASE) AS sum_tonase FROM lstg_6 WHERE TIANG = '30-35'");
						    $sum_result = mysqli_fetch_assoc($sum_query);
						    $sum1 = $sum_result['sum_tonase'];

						    // Update nilai ISI di tabel avglstg_6
						    $update_query = "UPDATE avglstg_6 SET ISI = '$sum1' WHERE TIANG = '30-35'";
						    if (mysqli_query($conn, $update_query)) {
						        echo $sum1;
						    } else {
						        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						    }
						    ?>
						</td>
		                <td><?php echo $e['SPEED']; ?></td>
		                <td style="background: white"></td>
		                <td><?php
		                	$level = '';
					        if (!empty($sum1)) {
					            $level = ($sum1) / (($e['SAMPAI'] - $e['DARI'] ) * 18);
					        }
					        $level = number_format((float)$level, 2, '.', '') . '%';

					         $update_query = "UPDATE avglstg_6 SET LEVEL='$level' WHERE TIANG = '30-35' AND id=" . $d['id'];

					        if (mysqli_query($conn, $update_query)) {
							        echo "".$level." ";
							    } else {
							        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
							    }
		                ?></td>
		                <td><?php
						$sum_query = mysqli_query($conn, "SELECT SUM(JUMLAH) AS sum_jumlah FROM lstg_6 WHERE TIANG = '30-35'");
						$sum_result = mysqli_fetch_assoc($sum_query);
						$sumJ = $sum_result['sum_jumlah'];
						$sumJ = number_format((float)$sumJ, 2, '.', '');
						$update_query = "UPDATE avglstg_6 SET LAYER = '$sumJ' WHERE TIANG = '30-35' AND id=" . $d['id'];
						if (mysqli_query($conn, $update_query)) {
						    echo "".$sumJ."";
						} else {
						    echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
						}
			                ?></td>
			        </tr>
			<?php
			    }
			?>
		</tbody>

		</table> </div>
        <div class="data-tables datatable-dark">
	    <div class="row">
	        <div class="col-sm-3">
	            <div class="form-group">
	                <a href="" class="btn btn-primary" data-toggle="modal" data-target="#addData"><i class="fa fa-fw fa-plus-circle"></i> Add Kapasitas</a>
	            </div>
	        </div>
	    </div>
         <table class="table table-striped table-bordered table-hover" id="1">
           <?php
			echo "<thead>";
			echo $y; 
			echo "</thead>";
			?>
          <tbody>
		    <?php
		    $sql = "SELECT lstg_6.*, avglstg_6.JARAK_1T, avglstg_6.SAMPAI, avglstg_6.DARI, avglstg_6.SPEED, avglstg_6.ISI 
		            FROM lstg_6 
		            JOIN avglstg_6 ON lstg_6.TIANG = avglstg_6.TIANG 
		            WHERE lstg_6.TIANG = '30-35'";
		    
		    $result = mysqli_query($conn, $sql);

		    if(mysqli_num_rows($result) > 0) {
		        while ($row = mysqli_fetch_assoc($result)) {
		            $ton = '';
		            if (!empty($row['KAPASITAS'])) {
		                $ton = ($row['JARAK_1T'] * ($row['SAMPAI'] - $row['DARI']) / $row['SPEED']) * $row['KAPASITAS'];
		            }
		            $ton = number_format((float)$ton, 2, '.', '');

		            $level1 = '';
		            if (!empty($row['TONASE'])) {
		                $level1 =  ($row['TONASE'] / $row['ISI']);
		            }
		            $level1 = number_format((float)$level1, 2, '.', '');

		            $jumlah = '';
		            if (!empty($row['TONASE'])) {
		                $jumlah = ($row['TONASE'] / $ton);
		            }
		            $jumlah = number_format((float)$jumlah, 2, '.', '');

		            $update_query = "UPDATE lstg_6 
		                             SET JUMLAH = '$jumlah', TON = '$ton', LEVEL = '$level1' 
		                             WHERE TIANG = '30-35' AND id=" . $row['id'];

		            if (mysqli_query($conn, $update_query)) {
		                // Tampilkan baris tabel
		                echo "<tr>";
		                echo "<td>{$row['id']}</td>";
		                echo "<td>{$row['TANGGAL']}</td>";
		                echo "<td>{$row['JAM']}</td>";
		                echo "<td>{$row['LSF']}</td>";
		                echo "<td>{$row['SIM']}</td>";
		                echo "<td>{$row['ALM']}</td>";
		                echo "<td>{$row['ALKALI']}</td>";
		                echo "<td>{$row['SiO2']}</td>";
		                echo "<td>{$row['Al2O3']}</td>";
		                echo "<td>{$row['Fe2O3']}</td>";
		                echo "<td>{$row['CaO']}</td>";
		                echo "<td>{$row['MgO']}</td>";
		                echo "<td>{$row['SO3']}</td>";
		                echo "<td>{$row['K2O']}</td>";
		                echo "<td>{$row['Na2O']}</td>";
		                echo "<td>{$row['Cl2']}</td>";
		                echo "<td>{$row['H2O']}</td>";
		                echo "<td>{$row['TONASE']}</td>";
		                echo "<td>{$row['KAPASITAS']}</td>";
		                echo "<td>{$ton}</td>";
		                echo "<td>{$level1}</td>";
		                echo "<td>{$jumlah}</td>";
		                echo "<td>{$row['KETERANGAN']}</td>";
		                echo "</tr>";
		            } else {
		                echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
		            }
		        }
		    }
		    ?>
		</tbody>

        </table>
  
	<div class="modal fade" id="addData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

					  if ($_SERVER["REQUEST_METHOD"] == "POST") {
		                    $kapasitas_ = $_POST['nilai_baru'];
		                    $id_ = $_POST['id'];

		                    $sql = "UPDATE lstg_6 SET KAPASITAS ='$kapasitas_' WHERE id=$id_";
		                    mysqli_query($conn, $sql);
		                    echo "<script>window.location = 'avglstg.php'</script>";
		                }

		                $sql = "Select * from lstg_6 ";
		                $q = mysqli_query($conn, $sql);
		                ?>

		                <div class="container">
		                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		                        <div class="form-group row my-0">
						            <label class="col-sm-4 col-form-label">ID</label>
						            <div class="col-sm-8">
						                <input type="text" style="height:30px" class="form-control" name="id">
						            </div>
						        </div>
						        <div class="form-group row my-0">
						            <label class="col-sm-4 col-form-label">Kapasitas</label>
						            <div class="col-sm-8">
						                <input type="text" style="height:30px" class="form-control" name="nilai_baru">
						            </div>
						        </div>
						        <div class="form-group row my-0">
						        	<label> note: tambahkan kapasitas sesuaikan dengan id yang ada</label>
						        </div>
						        <div class="form-group row my-0">
						            <div class="col-sm-4"></div>
						            <div class="col-sm-8">
						                <input type="submit" name="submit" value="Update" class="btn btn-primary pl-4 pr-4">
						            </div>
						        </div>
						    </form>
		                </div>
		            </div>
		        </div>
		    </div>
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