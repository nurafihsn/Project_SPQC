<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

</head>

<?php
session_start();

include "../include/database.php";

$level = strtoupper($_SESSION['level']);
$username = $_SESSION['username'];
if ($level == NULL) echo "<script>window.location = '../index.php'</script>";
$lsf_1 = 0;
$lsf_2 = 0;
$lsf_3 = 0;
$lsf_4 = 0;
$sum_1 = 0;
$sum_2 = 0;
$alkali = 0;
$loi1 = 0;
$s1 = 0;
$ca1 = 0;
$fe1 = 0;
$al1 = 0;
$si1 = 0;
$int1 = 0;
$loi2 = 0;
$s2 = 0;
$ca2 = 0;
$fe2 = 0;
$al2 = 0;
$si2 = 0;
$int2 = 0;
$loi3 = 0;
$s3 = 0;
$ca3 = 0;
$fe3 = 0;
$al3 = 0;
$si3 = 0;
$int3 = 0;

$sql = "SELECT * FROM tbconfig";
$q = mysqli_query($conn, $sql);
while ($d = mysqli_fetch_array($q)) {
    if ($d['nama_config'] == 'lsf_1') $lsf_1 = $d['nilai'];
    if ($d['nama_config'] == 'lsf_2') $lsf_2 = $d['nilai'];
    if ($d['nama_config'] == 'lsf_3') $lsf_3 = $d['nilai'];
    if ($d['nama_config'] == 'lsf_4') $lsf_4 = $d['nilai'];
    if ($d['nama_config'] == 'sum_1') $sum_1 = $d['nilai'];
    if ($d['nama_config'] == 'sum_2') $sum_2 = $d['nilai'];
    if ($d['nama_config'] == 'alkali') $alkali = $d['nilai'];
    if ($d['nama_config'] == 'loi1') $loi1 = $d['nilai'];
    if ($d['nama_config'] == 's1') $s1 = $d['nilai'];
    if ($d['nama_config'] == 'si1') $si1 = $d['nilai'];
    if ($d['nama_config'] == 'ca1') $ca1 = $d['nilai'];
    if ($d['nama_config'] == 'fe1') $fe1 = $d['nilai'];
    if ($d['nama_config'] == 'al1') $al1 = $d['nilai'];
    if ($d['nama_config'] == 'int1') $int1 = $d['nilai'];
    if ($d['nama_config'] == 'loi2') $loi2 = $d['nilai'];
    if ($d['nama_config'] == 's2') $s2 = $d['nilai'];
    if ($d['nama_config'] == 'si2') $si2 = $d['nilai'];
    if ($d['nama_config'] == 'ca2') $ca2 = $d['nilai'];
    if ($d['nama_config'] == 'fe2') $fe2 = $d['nilai'];
    if ($d['nama_config'] == 'al2') $al2 = $d['nilai'];
    if ($d['nama_config'] == 'int2') $int2 = $d['nilai'];
    if ($d['nama_config'] == 'loi3') $loi3 = $d['nilai'];
    if ($d['nama_config'] == 's3') $s3 = $d['nilai'];
    if ($d['nama_config'] == 'si3') $si3 = $d['nilai'];
    if ($d['nama_config'] == 'ca3') $ca3 = $d['nilai'];
    if ($d['nama_config'] == 'fe3') $fe3 = $d['nilai'];
    if ($d['nama_config'] == 'al3') $al3 = $d['nilai'];
    if ($d['nama_config'] == 'int3') $int3 = $d['nilai'];
}


$lsf_1 = isset($_POST['lsf_1']) ? $_POST['lsf_1'] : $lsf_1;
$lsf_2 = isset($_POST['lsf_2']) ? $_POST['lsf_2'] : $lsf_2;
$lsf_3 = isset($_POST['lsf_3']) ? $_POST['lsf_3'] : $lsf_3;
$lsf_4 = isset($_POST['lsf_4']) ? $_POST['lsf_4'] : $lsf_4;
$sum_1 = isset($_POST['sum_1']) ? $_POST['sum_1'] : $sum_1;
$sum_2 = isset($_POST['sum_2']) ? $_POST['sum_2'] : $sum_2;
$alkali = isset($_POST['alkali']) ? $_POST['alkali'] : $alkali;
$loi1 = isset($_POST['loi1']) ? $_POST['loi1'] : $loi1;
$s1 = isset($_POST['s1']) ? $_POST['s1'] : $s1;
$si1 = isset($_POST['si1']) ? $_POST['si1'] : $si1;
$ca1 = isset($_POST['ca1']) ? $_POST['ca1'] : $ca1;
$fe1 = isset($_POST['fe1']) ? $_POST['fe1'] : $fe1;
$al1 = isset($_POST['al1']) ? $_POST['al1'] : $al1;
$int1 = isset($_POST['int1']) ? $_POST['int1'] : $int1;
$loi2 = isset($_POST['loi2']) ? $_POST['loi2'] : $loi2;
$s2 = isset($_POST['s2']) ? $_POST['s2'] : $s2;
$si2 = isset($_POST['si2']) ? $_POST['si2'] : $si2;
$ca2 = isset($_POST['ca2']) ? $_POST['ca2'] : $ca2;
$fe2 = isset($_POST['fe2']) ? $_POST['fe2'] : $fe2;
$al2 = isset($_POST['al2']) ? $_POST['al2'] : $al2;
$int2 = isset($_POST['int2']) ? $_POST['int2'] : $int2;
$loi3 = isset($_POST['loi3']) ? $_POST['loi3'] : $loi3;
$s3 = isset($_POST['s3']) ? $_POST['s3'] : $s3;
$si3 = isset($_POST['si3']) ? $_POST['si3'] : $si3;
$ca3 = isset($_POST['ca3']) ? $_POST['ca3'] : $ca3;
$fe3 = isset($_POST['fe3']) ? $_POST['fe3'] : $fe3;
$al3 = isset($_POST['al3']) ? $_POST['al3'] : $al3;
$int3 = isset($_POST['int3']) ? $_POST['int3'] : $int3;

if (isset($_POST['update'])) {
    $sql = "UPDATE tbconfig set nilai='$lsf_1' where nama_config='lsf_1'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$lsf_2' where nama_config='lsf_2'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$lsf_3' where nama_config='lsf_3'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$lsf_4' where nama_config='lsf_4'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$sum_1' where nama_config='sum_1'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$sum_2' where nama_config='sum_2'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$alkali' where nama_config='alkali'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$loi1' where nama_config='loi1'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$s1' where nama_config='s1'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$si1' where nama_config='si1'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$ca1' where nama_config='ca1'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$fe1' where nama_config='fe1'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$al1' where nama_config='al1'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$int1' where nama_config='int1'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$loi2' where nama_config='loi2'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$s2' where nama_config='s2'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$si2' where nama_config='si2'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$ca2' where nama_config='ca2'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$fe2' where nama_config='fe2'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$al2' where nama_config='al2'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$int2' where nama_config='int2'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$loi3' where nama_config='loi3'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$s3' where nama_config='s3'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$si3' where nama_config='si3'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$ca3' where nama_config='ca3'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$fe3' where nama_config='fe3'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$al3' where nama_config='al3'";
    mysqli_query($conn, $sql);
    $sql = "UPDATE tbconfig set nilai='$int3' where nama_config='int3'";
    mysqli_query($conn, $sql);
}
?>



<body>
   <div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card border-primary mb-3">
                <div class="card-header">
                    <h5 class="card-title">Setting Konstanta LSF</h5>
                </div>
                <img src="img/lsf.png" class="card-img-top" alt="rumus lsf">
                <div class="container">
                    <form action="" method="POST" class="mt-3">
                        <div class="form-group row my-0">
                            <label for="lsf_1" class="col-sm-7 col-form-label">A</label>
                            <div class="col-sm-5">
                                <input type="text" style="height:30px" class="form-control" id="lsf_1" name="lsf_1" value="<?= $lsf_1; ?>">
                            </div>
                        </div>
                        <div class="form-group row my-0">
                            <label for="lsf_2" class="col-sm-7 col-form-label">B</label>
                            <div class="col-sm-5">
                                <input type="text" style="height:30px" class="form-control" id="lsf_2" name="lsf_2" value="<?= $lsf_2; ?>">
                            </div>
                        </div>
                        <div class="form-group row my-0">
                            <label for="lsf_3" class="col-sm-7 col-form-label">C</label>
                            <div class="col-sm-5">
                                <input type="text" style="height:30px" class="form-control" id="lsf_3" name="lsf_3" value="<?= $lsf_3; ?>">
                            </div>
                        </div>
                        <div class="form-group row my-0">
                            <label for="lsf_4" class="col-sm-7 col-form-label">D</label>
                            <div class="col-sm-5">
                                <input type="text" style="height:30px" class="form-control" id="lsf_4" name="lsf_4" value="<?= $lsf_4; ?>">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-sm-12">
                                <button type="submit" name="update" value="Update" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-primary mb-3">
                <div class="card-header">
                    <h5 class="card-title">Setting Konstanta SUM</h5>
                </div>
                <img src="img/sum.png" class="card-img-top" alt="rumus sum">
                <div class="container">
                    <form action="" method="POST" class="mt-3">
                        <div class="form-group row my-0">
                            <label for="sum_1" class="col-sm-7 col-form-label">A</label>
                            <div class="col-sm-5">
                                <input type="text" style="height:30px" class="form-control" id="sum_1" name="sum_1" value="<?= $sum_1; ?>">
                            </div>
                        </div>
                        <div class="form-group row my-0">
                            <label for="sum_2" class="col-sm-7 col-form-label">B</label>
                            <div class="col-sm-5">
                                <input type="text" style="height:30px" class="form-control" id="sum_2" name="sum_2" value="<?= $sum_2; ?>">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-sm-12">
                                <button type="submit" name="update" value="Update" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 <div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card border-primary mb-3">
                <div class="card-header">
                    <h5 class="card-title">Setting Konstanta ALKALI</h5>
                </div>
                <img src="img/alkali.png" class="card-img-top" alt="rumus alkali">
                <div class="container">
                    <form action="" method="POST" class="mt-3">
                        <div class="form-group row my-0">
                            <label for="alkali" class="col-sm-7 col-form-label">A</label>
                            <div class="col-sm-5">
                                <input type="text" style="height:30px" class="form-control" id="alkali" name="alkali" value="<?= $alkali; ?>">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-sm-12">
                                <button type="submit" name="update" value="Update" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
       <div class="col-md-6">
                <div class="card border-primary mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Setting Konstanta Sement</h5>
                    </div>
                    <div class="container">
                        <form action="" method="POST" class="mt-3">
                            <div class="form-group row">
                                <label for="LSF" class="col-sm-2 col-form-label mt-4">LOI</label>                          
                                <div class="col-sm-3">
                                    <label for="LSFrm" class="col-form-label">IND 4</label>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px; " class="form-control" id="loi1" name="loi1" value="<?= $loi1; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label for="H2Orm" class="col-form-label">IND 5</label>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px;" class="form-control" id="loi2" name="loi2" value="<?= $loi2; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label for="H2Ocm" class="col-form-label">IND 6</label>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px; " class="form-control" id="loi3" name="loi3" value="<?= $loi3; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        <div class="form-group row">
                            <label for="LSF" class="col-sm-2 col-form-label ">S</label>                          
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px; " class="form-control" id="s1" name="s1" value="<?= $s1; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px;" class="form-control" id="s2" name="s2" value="<?= $s2; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px; " class="form-control" id="s3" name="s3" value="<?= $s3; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                       <div class="form-group row">
                            <label for="LSF" class="col-sm-2 col-form-label ">Ca</label>                          
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px; " class="form-control" id="ca1" name="ca1" value="<?= $ca1; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px;" class="form-control" id="ca2" name="ca2" value="<?= $ca2; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px; " class="form-control" id="ca3" name="ca3" value="<?= $ca3; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        <div class="form-group row">
                             <label for="LSF" class="col-sm-2 col-form-label">Fe</label>                          
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px; " class="form-control" id="fe1" name="fe1" value="<?= $fe1; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px;" class="form-control" id="fe2" name="fe2" value="<?= $fe2; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px; " class="form-control" id="fe3" name="fe3" value="<?= $fe3; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        <div class="form-group row">
                             <label for="LSF" class="col-sm-2 col-form-label">Al</label>                          
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px; " class="form-control" id="al1" name="al1" value="<?= $al1; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px;" class="form-control" id="al2" name="al2" value="<?= $al2; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px; " class="form-control" id="al3" name="al3" value="<?= $al3; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group row">
                             <label for="LSF" class="col-sm-2 col-form-label">Si</label>                          
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px; " class="form-control" id="si1" name="si1" value="<?= $si1; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px;" class="form-control" id="si2" name="si2" value="<?= $si2; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px; " class="form-control" id="si3" name="si3" value="<?= $si3; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group row">
                             <label for="LSF" class="col-sm-2 col-form-label">Int</label>                          
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px; " class="form-control" id="int1" name="int1" value="<?= $int1; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px;" class="form-control" id="int2" name="int2" value="<?= $int2; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" style="height:30px; " class="form-control" id="int3" name="int3" value="<?= $int3; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        <div class="form-group row mt-3">
                            <div class="col-sm-12">
                                <button type="submit" name="update" value="Update" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
</body>

</html>