<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>UBAH PASSWORD</title>
</head>

<?php
session_start();
include "../include/database.php";
$level = strtoupper($_SESSION['level']);
$username = $_SESSION['username'];
if ($level == NULL) echo "<script>window.location = '../index.php'</script>";
$sql = "SELECT * FROM tbuser where username='$username'";
$q = mysqli_query($conn, $sql);
$r = mysqli_fetch_array($q);
$pass_lama = $r['passwd'];
$err1 = '';
$err2 = '';
$err3 = '';
$pass_lama_ = isset($_POST['pass_lama']) ? $_POST['pass_lama'] : '';
$pass_baru = isset($_POST['pass_baru']) ? $_POST['pass_baru'] : '';
$pass_ulang = isset($_POST['pass_ulang']) ? $_POST['pass_ulang'] : '';
$pass_rekam = md5($pass_baru);

if ($pass_lama <> md5($pass_lama_) && $pass_lama_ <> '') $err1 = "Salah Password";
if ($pass_baru <> $pass_ulang) $err2 = "Password tidak sama";

if (isset($_POST['update'])) {

    if ($pass_lama_ <> '' || $pass_baru <> '' || $pass_ulang <> '') {
        if ($pass_lama == md5($pass_lama_) && $pass_baru == $pass_ulang) {
            $sql = "UPDATE tbuser set passwd='$pass_rekam' where username='$username'";
            mysqli_query($conn, $sql);
            $err3 = "Sukses rubah password";
        }
    }
}

?>

<body>
    <div class="container">
        <div class="card border-primary mb-3" style="width: 24rem;">
            <div class="card-header">
                <h5 class="card-title">Ubah Password</h5>
            </div>
            <div class="container">
                <form action="" method="POST" class="mt-3">
                    <div class="form-group row my-0">
                        <label for=" pass_lama" class=" col-sm-5 col-form-label">Password lama</label>
                        <div class="col-sm-7">
                            <input type="password" style="height:30px" class="form-control" id="pass_lama" name="pass_lama">
                            <p><code>
                                    <?php
                                    if ($err1 <> '') echo $err1;  ?>
                                </code>
                            </p>
                        </div>

                    </div>
                    <div class="form-group row my-0">
                        <label for="pass_baru" class="col-sm-5 col-form-label">Password baru</label>
                        <div class="col-sm-7">
                            <input type="password" style="height:30px" class="form-control" id="pass_baru" name="pass_baru">
                        </div>
                    </div>
                    <div class="form-group row my-0">
                        <label for="pass_ulang" class="col-sm-5 col-form-label">Ulang Password</label>
                        <div class="col-sm-7">
                            <input type="password" style="height:30px" class="form-control" id="pass_ulang" name="pass_ulang">
                            <p><code>
                                    <?php
                                    if ($err2 <> '') echo $err2;  ?>
                                </code>
                            </p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-5">
                            <button type="submit" name="update" value="Update" class="btn btn-primary">Rekam data</button>
                        </div>
                        <div class="col-sm-7">
                            <p><code>
                                    <?php
                                    if ($err3 <> '') echo $err3;  ?>
                                </code>
                            </p>
                        </div>
                    </div>
                </form>

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