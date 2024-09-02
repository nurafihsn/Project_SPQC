<?php
session_start();
$level = strtoupper($_SESSION['level'] ?? '');
if (empty($level)) {
    echo "<script>window.location = '../index.php'</script>";
    exit();
}
?>
  
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Laporan Harian</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
     
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     
</head>
<body>
    <center >
        <h2 class="mb-5 " style="margin-top: 20px">Laporan Harian</h2>
    </center>
    <center>
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    PILIH UNIT
  </button>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="laporan_harian/indarung_3.php">Indarung 2&3</a>
    <a class="dropdown-item" href="laporan_harian/indarung_4.php">Indarung 4</a>
    <a class="dropdown-item" href="laporan_harian/indarung_5.php">Indarung 5</a>
    <a class="dropdown-item" href="laporan_harian/indarung_6.php">Indarung 6</a>
</div>
</center>

</div>
</body>
</html>
