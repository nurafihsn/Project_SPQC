<?php
session_start();
$level = strtoupper($_SESSION['level']);
if ($level == NULL) echo "<script>window.location = '../index.php'</script>";
include "../../include/database.php";

$id = isset($_REQUEST['delId']) ? $_REQUEST['delId'] : '';
$sql = "DELETE FROM lscm_3 where id ='$id'";
$q = mysqli_query($conn, $sql);
echo "<script>window.location = 'lscm.php'</script>";
