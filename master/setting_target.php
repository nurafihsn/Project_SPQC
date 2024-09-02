<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
<?php
session_start();

include "../include/database.php";

$level = strtoupper($_SESSION['level']);
$username = $_SESSION['username'];
if ($level == NULL) echo "<script>window.location = '../index.php'</script>";

$H2Ols_max = 0; $H2Ols_min = 0; $SiO2ls_max = 0; $SiO2ls_min = 0; $Al2O3ls_max = 0; $Al2O3ls_min = 0; $CaOls_max = 0; $CaOls_min = 0;
$ALKALIls_max = 0; $ALKALIls_min = 0;$H2Orm_max = 0;$H2Orm_min = 0; $SiO2rm_max = 0; $SiO2rm_min = 0; $Al2O3rm_max = 0; $Al2O3rm_min = 0; 
$CaOrm_max = 0;$CaOrm_min = 0; $ALKALIrm_max = 0; $ALKALIrm_min = 0; $H2Ocm_max = 0; $H2Ocm_min = 0; $SiO2cm_max = 0; $SiO2cm_min = 0; 
$Al2O3cm_max = 0; $Al2O3cm_min = 0; $CaOcm_max = 0;$CaOcm_min = 0; $ALKALIcm_max = 0; $ALKALIcm_min = 0;$H2Oss_max = 0; $H2Oss_min = 0;
$SiO2ss_max = 0; $SiO2ss_min = 0; $Al2O3ss_max = 0; $Al2O3ss_min = 0; $LSFrm4amin = 0; $SIMrm4amin = 0; $ALMrm4amin = 0; $rm90u4amin = 0; 
$rm180u4amin = 0; $H2Orm4amin = 0; $SDLSFrm4amin = 0; $LSFrm4amax = 0; $SIMrm4amax = 0; $ALMrm4amax = 0; $rm90u4amax = 0; $rm180u4amax = 0; 
$H2Orm4amax = 0; $SDLSFrm4amax = 0;$LSFrm4cmax = 0;  $LSFrm4cmin = 0; $SIMrm4cmin = 0; $ALMrm4cmin = 0; $rm90u4cmin = 0; $rm180u4cmin = 0; 
$H2Orm4cmin = 0; $SDLSFrm4cmin = 0; $LSFrm4cmax = 0; $SIMrm4cmax = 0; $ALMrm4cmax = 0; $rm90u4cmax = 0; $rm180u4cmax = 0; $H2Orm4cmax = 0; 
$SDLSFrm4cmax = 0; $LSFrm5max = 0;  $LSFrm5min = 0; $SIMrm5min = 0; $ALMrm5min = 0; $rm90u5min = 0; $rm180u5min = 0; $H2Orm5min = 0; 
$SDLSFrm5min = 0; $LSFrm5max = 0; $SIMrm5max = 0; $ALMrm5max = 0; $rm90u5max = 0; $rm180u5max = 0; $H2Orm5max = 0; $SDLSFrm5max = 0;
$LSFrm6max = 0;  $LSFrm6min = 0; $SIMrm6min = 0; $ALMrm6min = 0; $rm90u6min = 0; $rm180u6min = 0; $H2Orm6min = 0;  $SDLSFrm6min = 0;
$LSFrm6max = 0; $SIMrm6max = 0; $ALMrm6max = 0; $rm90u6max = 0; $rm180u6max = 0; $H2Orm6max = 0; $SDLSFrm6max = 0; $LSFkf4min = 0; 
$SIMkf4min = 0; $ALMkf4min = 0; $kf90u4min = 0; $kf180u4min = 0; $H2Okf4min = 0; $SDLSFkf4min = 0; $LSFkf4max = 0; $SIMkf4max = 0;
$ALMkf4max = 0; $kf90u4max = 0; $kf180u4max = 0; $H2Okf4max = 0; $SDLSFkf4max = 0; $LSFkf5min = 0; $SIMkf5min = 0; $ALMkf5min = 0;
$kf90u5min = 0; $kf180u5min = 0; $H2Okf5min = 0; $SDLSFkf5min = 0; $LSFkf5max = 0; $SIMkf5max = 0; $ALMkf5max = 0; $kf90u5max = 0; 
$kf180u5max = 0; $H2Okf5max = 0; $SDLSFkf5max = 0; $LSFkf6min = 0; $SIMkf6min = 0; $ALMkf6min = 0; $kf90u6min = 0; $kf180u6min = 0;
$H2Okf6min = 0; $SDLSFkf6min = 0; $LSFkf6max = 0; $SIMkf6max = 0; $ALMkf6max = 0; $kf90u6max = 0; $kf180u6max = 0; $H2Okf6max = 0; 
$SDLSFkf6max = 0; $LSFcr4min = 0; $SIMcr4min = 0; $ALMcr4min = 0; $C3Scr4min = 0; $C3Acr4min = 0; $ALKALIcr4min = 0; $SDLSFC3Scr4min = 0;
$FCaOcr4min = 0; $LSFcr4max = 0; $SIMcr4max = 0; $ALMcr4max = 0; $C3Scr4max = 0; $C3Acr4max = 0; $ALKALIcr4max = 0; $SDLSFC3Scr4max = 0;
$FCaOcr4max = 0;  $LSFcr5min = 0; $SIMcr5min = 0; $ALMcr5min = 0; $C3Scr5min = 0; $C3Acr5min = 0; $ALKALIcr5min = 0; $SDLSFC3Scr5min = 0;
$FCaOcr5min = 0; $LSFcr5max = 0; $SIMcr5max = 0; $ALMcr5max = 0; $C3Scr5max = 0; $C3Acr5max = 0; $ALKALIcr5max = 0; $SDLSFC3Scr5max = 0;
$FCaOcr5max = 0;  $LSFcr6min = 0; $SIMcr6min = 0; $ALMcr6min = 0; $C3Scr6min = 0; $C3Acr6min = 0; $ALKALIcr6min = 0; $SDLSFC3Scr6min = 0;
$FCaOcr6min = 0; $LSFcr6max = 0; $SIMcr6max = 0; $ALMcr6max = 0; $C3Scr6max = 0; $C3Acr6max = 0; $ALKALIcr6max = 0; $SDLSFC3Scr6max = 0;
$FCaOcr6max = 0; $H2Ois_max = 0; $H2Ois_min = 0; $Fe2O3is_max = 0; $Fe2O3is_min = 0; $ACfc4max = 0; $fc90u4max = 0; $H2Ofc4max = 0;
$ACfc4min = 0; $fc90u4min = 0; $H2Ofc4min = 0; $ACfc5max = 0; $fc90u5max = 0; $H2Ofc5max = 0; $ACfc5min = 0; $fc90u5min = 0; $H2Ofc5min = 0;
$ACfc6max = 0; $fc90u6max = 0; $H2Ofc6max = 0; $ACfc6min = 0; $fc90u6min = 0; $H2Ofc6min = 0; $BTLpccmax = 0;$BTLpccmin = 0; $MgOpccmax = 0; 
$MgOpccmin = 0; $SO3pccmax = 0; $SO3pccmin = 0; $FCaOpccmax = 0; $FCaOpccmin = 0; $LOIpccmax = 0; $LOIpccmin = 0; $ALKALIpccmax = 0;
$ALKALIpccmin = 0; $z145upccmax = 0; $z145upccmin = 0; $BLAINEpccmax = 0; $BLAINEpccmin = 0; $BTLopcmax = 0;$BTLopcmin = 0; $MgOopcmax = 0; 
$MgOopcmin = 0; $SO3opcmax = 0; $SO3opcmin = 0; $FCaOopcmax = 0; $FCaOopcmin = 0; $LOIopcmax = 0; $LOIopcmin = 0; $ALKALIopcmax = 0;
$ALKALIopcmin = 0; $z145uopcmax = 0; $z145uopcmin = 0; $BLAINEopcmax = 0; $BLAINEopcmin = 0;  $BTLppcmax = 0;$BTLppcmin = 0; $MgOppcmax = 0; 
$MgOppcmin = 0; $SO3ppcmax = 0; $SO3ppcmin = 0; $FCaOppcmax = 0; $FCaOppcmin = 0; $LOIppcmax = 0; $LOIppcmin = 0; $ALKALIppcmax = 0;
$ALKALIppcmin = 0; $z145uppcmax = 0; $z145uppcmin = 0; $BLAINEppcmax = 0; $BLAINEppcmin = 0; $SiO2cl_max = 0; $SiO2cl_min = 0; $Al2O3cl_max = 0;
$Al2O3cl_min = 0; $SiO2qc_max = 0; $SiO2qc_min = 0; $Al2O3qc_max = 0; $Al2O3qc_min = 0; $CaOqc_max = 0; $CaOqc_min = 0;
$ALKALIqc_max = 0; $ALKALIqc_min = 0;


$sql = "SELECT * FROM tb_config";
$q = mysqli_query($conn, $sql);
while ($d = mysqli_fetch_array($q)) {
    if ($d['nama_config'] == 'H2Ols') {
        $H2Ols_max = $d['max'];
        $H2Ols_min = $d['min'];
    }
     if ($d['nama_config'] == 'SiO2ls') {
        $SiO2ls_max = $d['max'];
        $SiO2ls_min = $d['min'];
    }
     if ($d['nama_config'] == 'Al2O3ls') {
        $Al2O3ls_max = $d['max'];
        $Al2O3ls_min = $d['min'];
    }
    if ($d['nama_config'] == 'CaOls') {
        $CaOls_max = $d['max'];
        $CaOls_min = $d['min'];
    }
     if ($d['nama_config'] == 'ALKALIls') {
        $ALKALIls_max = $d['max'];
        $ALKALIls_min = $d['min'];
    }
     if ($d['nama_config'] == 'H2Orm') {
        $H2Orm_max = $d['max'];
        $H2Orm_min = $d['min'];
    }
     if ($d['nama_config'] == 'SiO2rm') {
        $SiO2rm_max = $d['max'];
        $SiO2rm_min = $d['min'];
    }
     if ($d['nama_config'] == 'Al2O3rm') {
        $Al2O3rm_max = $d['max'];
        $Al2O3rm_min = $d['min'];
    }
    if ($d['nama_config'] == 'CaOrm') {
        $CaOrm_max = $d['max'];
        $CaOrm_min = $d['min'];
    }
     if ($d['nama_config'] == 'ALKALIrm') {
        $ALKALIrm_max = $d['max'];
        $ALKALIrm_min = $d['min'];
    }
     if ($d['nama_config'] == 'H2Ocm') {
        $H2Ocm_max = $d['max'];
        $H2Ocm_min = $d['min'];
    }
     if ($d['nama_config'] == 'SiO2cm') {
        $SiO2cm_max = $d['max'];
        $SiO2cm_min = $d['min'];
    }
     if ($d['nama_config'] == 'Al2O3cm') {
        $Al2O3cm_max = $d['max'];
        $Al2O3cm_min = $d['min'];
    }
    if ($d['nama_config'] == 'CaOcm') {
        $CaOcm_max = $d['max'];
        $CaOcm_min = $d['min'];
    }
     if ($d['nama_config'] == 'ALKALIcm') {
        $ALKALIcm_max = $d['max'];
        $ALKALIcm_min = $d['min'];
    }
     if ($d['nama_config'] == 'H2Oss') {
        $H2Oss_max = $d['max'];
        $H2Oss_min = $d['min'];
    }
     if ($d['nama_config'] == 'SiO2ss') {
        $SiO2ss_max = $d['max'];
        $SiO2ss_min = $d['min'];
    }
     if ($d['nama_config'] == 'Al2O3ss') {
        $Al2O3ss_max = $d['max'];
        $Al2O3ss_min = $d['min'];
    }
     if ($d['nama_config'] == 'LSFrm4a') {
        $LSFrm4amax = $d['max'];
        $LSFrm4amin = $d['min'];
    }
    if ($d['nama_config'] == 'SIMrm4a') {
        $SIMrm4amax = $d['max'];
        $SIMrm4amin = $d['min'];
    }
     if ($d['nama_config'] == 'ALMrm4a') {
        $ALMrm4amax = $d['max'];
        $ALMrm4amin = $d['min'];
    }
    if ($d['nama_config'] == 'rm90u4a') {
        $rm90u4amax = $d['max'];
        $rm90u4amin = $d['min'];
    }
     if ($d['nama_config'] == 'rm180u4a') {
        $rm180u4amax = $d['max'];
        $rm180u4amin = $d['min'];
    }
    if ($d['nama_config'] == 'H2Orm4a') {
        $H2Orm4amax = $d['max'];
        $H2Orm4amin = $d['min'];
    }
    if ($d['nama_config'] == 'SDLSFrm4a') {
        $SDLSFrm4amax = $d['max'];
        $SDLSFrm4amin = $d['min'];
    }
    if ($d['nama_config'] == 'LSFrm4c') {
        $LSFrm4cmax = $d['max'];
        $LSFrm4cmin = $d['min'];
    }
    if ($d['nama_config'] == 'SIMrm4c') {
        $SIMrm4cmax = $d['max'];
        $SIMrm4cmin = $d['min'];
    }
     if ($d['nama_config'] == 'ALMrm4c') {
        $ALMrm4cmax = $d['max'];
        $ALMrm4cmin = $d['min'];
    }
    if ($d['nama_config'] == 'rm90u4c') {
        $rm90u4cmax = $d['max'];
        $rm90u4cmin = $d['min'];
    }
     if ($d['nama_config'] == 'rm180u4c') {
        $rm180u4cmax = $d['max'];
        $rm180u4cmin = $d['min'];
    }
    if ($d['nama_config'] == 'H2Orm4c') {
        $H2Orm4cmax = $d['max'];
        $H2Orm4cmin = $d['min'];
    }
    if ($d['nama_config'] == 'SDLSFrm4c') {
        $SDLSFrm4cmax = $d['max'];
        $SDLSFrm4cmin = $d['min'];
    }
     if ($d['nama_config'] == 'LSFrm5') {
        $LSFrm5max = $d['max'];
        $LSFrm5min = $d['min'];
    }
    if ($d['nama_config'] == 'SIMrm5') {
        $SIMrm5max = $d['max'];
        $SIMrm5min = $d['min'];
    }
     if ($d['nama_config'] == 'ALMrm5') {
        $ALMrm5max = $d['max'];
        $ALMrm5min = $d['min'];
    }
    if ($d['nama_config'] == 'rm90u5') {
        $rm90u5max = $d['max'];
        $rm90u5min = $d['min'];
    }
     if ($d['nama_config'] == 'rm180u5') {
        $rm180u5max = $d['max'];
        $rm180u5min = $d['min'];
    }
    if ($d['nama_config'] == 'H2Orm5') {
        $H2Orm5max = $d['max'];
        $H2Orm5min = $d['min'];
    }
    if ($d['nama_config'] == 'SDLSFrm5') {
        $SDLSFrm5max = $d['max'];
        $SDLSFrm5min = $d['min'];
    }
    if ($d['nama_config'] == 'LSFrm6') {
        $LSFrm6max = $d['max'];
        $LSFrm6min = $d['min'];
    }
    if ($d['nama_config'] == 'SIMrm6') {
        $SIMrm6max = $d['max'];
        $SIMrm6min = $d['min'];
    }
     if ($d['nama_config'] == 'ALMrm6') {
        $ALMrm6max = $d['max'];
        $ALMrm6min = $d['min'];
    }
    if ($d['nama_config'] == 'rm90u6') {
        $rm90u6max = $d['max'];
        $rm90u6min = $d['min'];
    }
     if ($d['nama_config'] == 'rm180u6') {
        $rm180u6max = $d['max'];
        $rm180u6min = $d['min'];
    }
    if ($d['nama_config'] == 'H2Orm6') {
        $H2Orm6max = $d['max'];
        $H2Orm6min = $d['min'];
    }
    if ($d['nama_config'] == 'SDLSFrm6') {
        $SDLSFrm6max = $d['max'];
        $SDLSFrm6min = $d['min'];
    }
    if ($d['nama_config'] == 'LSFkf4') {
        $LSFkf4max = $d['max'];
        $LSFkf4min = $d['min'];
    }
    if ($d['nama_config'] == 'SIMkf4') {
        $SIMkf4max = $d['max'];
        $SIMkf4min = $d['min'];
    }
     if ($d['nama_config'] == 'ALMkf4') {
        $ALMkf4max = $d['max'];
        $ALMkf4min = $d['min'];
    }
    if ($d['nama_config'] == 'kf90u4') {
        $kf90u4max = $d['max'];
        $kf90u4min = $d['min'];
    }
     if ($d['nama_config'] == 'kf180u4') {
        $kf180u4max = $d['max'];
        $kf180u4min = $d['min'];
    }
    if ($d['nama_config'] == 'H2Okf4') {
        $H2Okf4max = $d['max'];
        $H2Okf4min = $d['min'];
    }
    if ($d['nama_config'] == 'SDLSFkf4') {
        $SDLSFkf4max = $d['max'];
        $SDLSFkf4min = $d['min'];
    }
    if ($d['nama_config'] == 'LSFkf5') {
        $LSFkf5max = $d['max'];
        $LSFkf5min = $d['min'];
    }
    if ($d['nama_config'] == 'SIMkf5') {
        $SIMkf5max = $d['max'];
        $SIMkf5min = $d['min'];
    }
     if ($d['nama_config'] == 'ALMkf5') {
        $ALMkf5max = $d['max'];
        $ALMkf5min = $d['min'];
    }
    if ($d['nama_config'] == 'kf90u5') {
        $kf90u5max = $d['max'];
        $kf90u5min = $d['min'];
    }
     if ($d['nama_config'] == 'kf180u5') {
        $kf180u5max = $d['max'];
        $kf180u5min = $d['min'];
    }
    if ($d['nama_config'] == 'H2Okf5') {
        $H2Okf5max = $d['max'];
        $H2Okf5min = $d['min'];
    }
    if ($d['nama_config'] == 'SDLSFkf5') {
        $SDLSFkf5max = $d['max'];
        $SDLSFkf5min = $d['min'];
    }
     if ($d['nama_config'] == 'LSFkf6') {
        $LSFkf6max = $d['max'];
        $LSFkf6min = $d['min'];
    }
    if ($d['nama_config'] == 'SIMkf6') {
        $SIMkf6max = $d['max'];
        $SIMkf6min = $d['min'];
    }
     if ($d['nama_config'] == 'ALMkf6') {
        $ALMkf6max = $d['max'];
        $ALMkf6min = $d['min'];
    }
    if ($d['nama_config'] == 'kf90u6') {
        $kf90u6max = $d['max'];
        $kf90u6min = $d['min'];
    }
     if ($d['nama_config'] == 'kf180u6') {
        $kf180u6max = $d['max'];
        $kf180u6min = $d['min'];
    }
    if ($d['nama_config'] == 'H2Okf6') {
        $H2Okf6max = $d['max'];
        $H2Okf6min = $d['min'];
    }
    if ($d['nama_config'] == 'SDLSFkf6') {
        $SDLSFkf6max = $d['max'];
        $SDLSFkf6min = $d['min'];
    }
    if ($d['nama_config'] == 'LSFcr4') {
        $LSFcr4max = $d['max'];
        $LSFcr4min = $d['min'];
    }
    if ($d['nama_config'] == 'SIMcr4') {
        $SIMcr4max = $d['max'];
        $SIMcr4min = $d['min'];
    }
     if ($d['nama_config'] == 'ALMcr4') {
        $ALMcr4max = $d['max'];
        $ALMcr4min = $d['min'];
    }
    if ($d['nama_config'] == 'C3Scr4') {
        $C3Scr4max = $d['max'];
        $C3Scr4min = $d['min'];
    }
     if ($d['nama_config'] == 'C3Acr4') {
        $C3Acr4max = $d['max'];
        $C3Acr4min = $d['min'];
    }
    if ($d['nama_config'] == 'ALKALIcr4') {
        $ALKALIcr4max = $d['max'];
        $ALKALIcr4min = $d['min'];
    }
    if ($d['nama_config'] == 'SDC3Scr4') {
        $SDC3Scr4max = $d['max'];
        $SDC3Scr4min = $d['min'];
    }
    if ($d['nama_config'] == 'FCaOcr4') {
        $FCaOcr4max = $d['max'];
        $FCaOcr4min = $d['min'];
    }
    if ($d['nama_config'] == 'LSFcr5') {
        $LSFcr5max = $d['max'];
        $LSFcr5min = $d['min'];
    }
    if ($d['nama_config'] == 'SIMcr5') {
        $SIMcr5max = $d['max'];
        $SIMcr5min = $d['min'];
    }
     if ($d['nama_config'] == 'ALMcr5') {
        $ALMcr5max = $d['max'];
        $ALMcr5min = $d['min'];
    }
    if ($d['nama_config'] == 'C3Scr5') {
        $C3Scr5max = $d['max'];
        $C3Scr5min = $d['min'];
    }
     if ($d['nama_config'] == 'C3Acr5') {
        $C3Acr5max = $d['max'];
        $C3Acr5min = $d['min'];
    }
    if ($d['nama_config'] == 'ALKALIcr5') {
        $ALKALIcr5max = $d['max'];
        $ALKALIcr5min = $d['min'];
    }
    if ($d['nama_config'] == 'SDC3Scr5') {
        $SDC3Scr5max = $d['max'];
        $SDC3Scr5min = $d['min'];
    }
    if ($d['nama_config'] == 'FCaOcr5') {
        $FCaOcr5max = $d['max'];
        $FCaOcr5min = $d['min'];
    }
     if ($d['nama_config'] == 'LSFcr6') {
        $LSFcr6max = $d['max'];
        $LSFcr6min = $d['min'];
    }
    if ($d['nama_config'] == 'SIMcr6') {
        $SIMcr6max = $d['max'];
        $SIMcr6min = $d['min'];
    }
     if ($d['nama_config'] == 'ALMcr6') {
        $ALMcr6max = $d['max'];
        $ALMcr6min = $d['min'];
    }
    if ($d['nama_config'] == 'C3Scr6') {
        $C3Scr6max = $d['max'];
        $C3Scr6min = $d['min'];
    }
     if ($d['nama_config'] == 'C3Acr6') {
        $C3Acr6max = $d['max'];
        $C3Acr6min = $d['min'];
    }
    if ($d['nama_config'] == 'ALKALIcr6') {
        $ALKALIcr6max = $d['max'];
        $ALKALIcr6min = $d['min'];
    }
    if ($d['nama_config'] == 'SDC3Scr6') {
        $SDC3Scr6max = $d['max'];
        $SDC3Scr6min = $d['min'];
    }
    if ($d['nama_config'] == 'FCaOcr6') {
        $FCaOcr6max = $d['max'];
        $FCaOcr6min = $d['min'];
    }
     if ($d['nama_config'] == 'H2Ois') {
        $H2Ois_max = $d['max'];
        $H2Ois_min = $d['min'];
    }
     if ($d['nama_config'] == 'Fe2O3is') {
        $Fe2O3is_max = $d['max'];
        $Fe2O3is_min = $d['min'];
    }
    if ($d['nama_config'] == 'ACfc4') {
        $ACfc4max = $d['max'];
        $ACfc4min = $d['min'];
    }
     if ($d['nama_config'] == 'fc90u4') {
        $fc90u4max = $d['max'];
        $fc90u4min = $d['min'];
    }
     if ($d['nama_config'] == 'H2Ofc4') {
        $H2Ofc4max = $d['max'];
        $H2Ofc4min = $d['min'];
    }
    if ($d['nama_config'] == 'ACfc5') {
        $ACfc5max = $d['max'];
        $ACfc5min = $d['min'];
    }
     if ($d['nama_config'] == 'fc90u5') {
        $fc90u5max = $d['max'];
        $fc90u5min = $d['min'];
    }
     if ($d['nama_config'] == 'H2Ofc5') {
        $H2Ofc5max = $d['max'];
        $H2Ofc5min = $d['min'];
    } 
     if ($d['nama_config'] == 'ACfc6') {
        $ACfc6max = $d['max'];
        $ACfc6min = $d['min'];
    }
     if ($d['nama_config'] == 'fc90u6') {
        $fc90u6max = $d['max'];
        $fc90u6min = $d['min'];
    }
     if ($d['nama_config'] == 'H2Ofc6') {
        $H2Ofc6max = $d['max'];
        $H2Ofc6min = $d['min'];
    }
    if ($d['nama_config'] == 'BTLpcc') {
        $BTLpccmax = $d['max'];
        $BTLpccmin = $d['min'];
    }
     if ($d['nama_config'] == 'MgOpcc') {
        $MgOpccmax = $d['max'];
        $MgOpccmin = $d['min'];
    }
    if ($d['nama_config'] == 'SO3pcc') {
        $SO3pccmax = $d['max'];
        $SO3pccmin = $d['min'];
    }
     if ($d['nama_config'] == 'FCaOpcc') {
        $FCaOpccmax = $d['max'];
        $FCaOpccmin = $d['min'];
    }
     if ($d['nama_config'] == 'LOIpcc') {
        $LOIpccmax = $d['max'];
        $LOIpccmin = $d['min'];
    } 
     if ($d['nama_config'] == 'ALKALIpcc') {
        $ALKALIpccmax = $d['max'];
        $ALKALIpccmin = $d['min'];
    }
     if ($d['nama_config'] == 'z145upcc') {
        $z145upccmax = $d['max'];
        $z145upccmin = $d['min'];
    }
     if ($d['nama_config'] == 'BLAINEpcc') {
        $BLAINEpccmax = $d['max'];
        $BLAINEpccmin = $d['min'];
    }
     if ($d['nama_config'] == 'BTLopc') {
        $BTLopcmax = $d['max'];
        $BTLopcmin = $d['min'];
    }
     if ($d['nama_config'] == 'MgOopc') {
        $MgOopcmax = $d['max'];
        $MgOopcmin = $d['min'];
    }
    if ($d['nama_config'] == 'SO3opc') {
        $SO3opcmax = $d['max'];
        $SO3opcmin = $d['min'];
    }
     if ($d['nama_config'] == 'FCaOopc') {
        $FCaOopcmax = $d['max'];
        $FCaOopcmin = $d['min'];
    }
     if ($d['nama_config'] == 'LOIopc') {
        $LOIopcmax = $d['max'];
        $LOIopcmin = $d['min'];
    } 
     if ($d['nama_config'] == 'ALKALIopc') {
        $ALKALIopcmax = $d['max'];
        $ALKALIopcmin = $d['min'];
    }
     if ($d['nama_config'] == 'z145uopc') {
        $z145uopcmax = $d['max'];
        $z145uopcmin = $d['min'];
    }
     if ($d['nama_config'] == 'BLAINEopc') {
        $BLAINEopcmax = $d['max'];
        $BLAINEopcmin = $d['min'];
    }

     if ($d['nama_config'] == 'BTLppc') {
        $BTLppcmax = $d['max'];
        $BTLppcmin = $d['min'];
    }
     if ($d['nama_config'] == 'MgOppc') {
        $MgOppcmax = $d['max'];
        $MgOppcmin = $d['min'];
    }
    if ($d['nama_config'] == 'SO3ppc') {
        $SO3ppcmax = $d['max'];
        $SO3ppcmin = $d['min'];
    }
     if ($d['nama_config'] == 'FCaOppc') {
        $FCaOppcmax = $d['max'];
        $FCaOppcmin = $d['min'];
    }
     if ($d['nama_config'] == 'LOIppc') {
        $LOIppcmax = $d['max'];
        $LOIppcmin = $d['min'];
    } 
     if ($d['nama_config'] == 'ALKALIppc') {
        $ALKALIppcmax = $d['max'];
        $ALKALIppcmin = $d['min'];
    }
     if ($d['nama_config'] == 'z145uppc') {
        $z145uppcmax = $d['max'];
        $z145uppcmin = $d['min'];
    }
     if ($d['nama_config'] == 'BLAINEppc') {
        $BLAINEppcmax = $d['max'];
        $BLAINEppcmin = $d['min'];
    }
     if ($d['nama_config'] == 'SiO2cl') {
        $SiO2cl_max = $d['max'];
        $SiO2cl_min = $d['min'];
    }
     if ($d['nama_config'] == 'Al2O3cl') {
        $Al2O3cl_max = $d['max'];
        $Al2O3cl_min = $d['min'];
    }
    if ($d['nama_config'] == 'SiO2qc') {
        $SiO2qc_max = $d['max'];
        $SiO2qc_min = $d['min'];
    }
     if ($d['nama_config'] == 'Al2O3qc') {
        $Al2O3qc_max = $d['max'];
        $Al2O3qc_min = $d['min'];
    }
    if ($d['nama_config'] == 'CaOqc') {
        $CaOqc_max = $d['max'];
        $CaOqc_min = $d['min'];
    }
     if ($d['nama_config'] == 'ALKALIqc') {
        $ALKALIqc_max = $d['max'];
        $ALKALIqc_min = $d['min'];
    }
}

$H2Ols_max = isset($_POST['H2Ols_max']) ? $_POST['H2Ols_max'] : $H2Ols_max;
$H2Ols_min = isset($_POST['H2Ols_min']) ? $_POST['H2Ols_min'] : $H2Ols_min;
$SiO2ls_max = isset($_POST['SiO2ls_max']) ? $_POST['SiO2ls_max'] : $SiO2ls_max;
$SiO2ls_min = isset($_POST['SiO2ls_min']) ? $_POST['SiO2ls_min'] : $SiO2ls_min;
$Al2O3ls_max = isset($_POST['Al2O3ls_max']) ? $_POST['Al2O3ls_max'] : $Al2O3ls_max;
$Al2O3ls_min = isset($_POST['Al2O3ls_min']) ? $_POST['Al2O3ls_min'] : $Al2O3ls_min;
$CaOls_max = isset($_POST['CaOls_max']) ? $_POST['CaOls_max'] : $CaOls_max;
$CaOls_min = isset($_POST['CaOls_min']) ? $_POST['CaOls_min'] : $CaOls_min;
$ALKALIls_max = isset($_POST['ALKALIls_max']) ? $_POST['ALKALIls_max'] : $ALKALIls_max;
$ALKALIls_min = isset($_POST['ALKALIls_min']) ? $_POST['ALKALIls_min'] : $ALKALIls_min;
$H2Orm_max = isset($_POST['H2Orm_max']) ? $_POST['H2Orm_max'] : $H2Orm_max;
$H2Orm_min = isset($_POST['H2Orm_min']) ? $_POST['H2Orm_min'] : $H2Orm_min;
$SiO2rm_max = isset($_POST['SiO2rm_max']) ? $_POST['SiO2rm_max'] : $SiO2rm_max;
$SiO2rm_min = isset($_POST['SiO2rm_min']) ? $_POST['SiO2rm_min'] : $SiO2rm_min;
$Al2O3rm_max = isset($_POST['Al2O3rm_max']) ? $_POST['Al2O3rm_max'] : $Al2O3rm_max;
$Al2O3rm_min = isset($_POST['Al2O3rm_min']) ? $_POST['Al2O3rm_min'] : $Al2O3rm_min;
$CaOrm_max = isset($_POST['CaOrm_max']) ? $_POST['CaOrm_max'] : $CaOrm_max;
$CaOrm_min = isset($_POST['CaOrm_min']) ? $_POST['CaOrm_min'] : $CaOrm_min;
$ALKALIrm_max = isset($_POST['ALKALIrm_max']) ? $_POST['ALKALIrm_max'] : $ALKALIrm_max;
$ALKALIrm_min = isset($_POST['ALKALIrm_min']) ? $_POST['ALKALIrm_min'] : $ALKALIrm_min;
$H2Ocm_max = isset($_POST['H2Ocm_max']) ? $_POST['H2Ocm_max'] : $H2Ocm_max;
$H2Ocm_min = isset($_POST['H2Ocm_min']) ? $_POST['H2Ocm_min'] : $H2Ocm_min;
$SiO2cm_max = isset($_POST['SiO2cm_max']) ? $_POST['SiO2cm_max'] : $SiO2cm_max;
$SiO2cm_min = isset($_POST['SiO2cm_min']) ? $_POST['SiO2cm_min'] : $SiO2cm_min;
$Al2O3cm_max = isset($_POST['Al2O3cm_max']) ? $_POST['Al2O3cm_max'] : $Al2O3cm_max;
$Al2O3cm_min = isset($_POST['Al2O3cm_min']) ? $_POST['Al2O3cm_min'] : $Al2O3cm_min;
$CaOcm_max = isset($_POST['CaOcm_max']) ? $_POST['CaOcm_max'] : $CaOcm_max;
$CaOcm_min = isset($_POST['CaOcm_min']) ? $_POST['CaOcm_min'] : $CaOcm_min;
$ALKALIcm_max = isset($_POST['ALKALIcm_max']) ? $_POST['ALKALIcm_max'] : $ALKALIcm_max;
$ALKALIcm_min = isset($_POST['ALKALIcm_min']) ? $_POST['ALKALIcm_min'] : $ALKALIcm_min;
$H2Oss_max = isset($_POST['H2Oss_max']) ? $_POST['H2Oss_max'] : $H2Oss_max;
$H2Oss_min = isset($_POST['H2Oss_min']) ? $_POST['H2Oss_min'] : $H2Oss_min;
$SiO2ss_max = isset($_POST['SiO2ss_max']) ? $_POST['SiO2ss_max'] : $SiO2ss_max;
$SiO2ss_min = isset($_POST['SiO2ss_min']) ? $_POST['SiO2ss_min'] : $SiO2ss_min;
$Al2O3ss_max = isset($_POST['Al2O3ss_max']) ? $_POST['Al2O3ss_max'] : $Al2O3ss_max;
$Al2O3ss_min = isset($_POST['Al2O3ss_min']) ? $_POST['Al2O3ss_min'] : $Al2O3ss_min;
$LSFrm4amin = isset($_POST['LSFrm4amin']) ? $_POST['LSFrm4amin'] : $LSFrm4amin;
$LSFrm4amax = isset($_POST['LSFrm4amax']) ? $_POST['LSFrm4amax'] : $LSFrm4amax;
$SIMrm4amin = isset($_POST['SIMrm4amin']) ? $_POST['SIMrm4amin'] : $SIMrm4amin;
$SIMrm4amax = isset($_POST['SIMrm4amax']) ? $_POST['SIMrm4amax'] : $SIMrm4amax;
$ALMrm4amin = isset($_POST['ALMrm4amin']) ? $_POST['ALMrm4amin'] : $ALMrm4amin;
$ALMrm4amax = isset($_POST['ALMrm4amax']) ? $_POST['ALMrm4amax'] : $ALMrm4amax;
$rm90u4amin = isset($_POST['rm90u4amin']) ? $_POST['rm90u4amin'] : $rm90u4amin;
$rm90u4amax = isset($_POST['rm90u4amax']) ? $_POST['rm90u4amax'] : $rm90u4amax;
$rm180u4amin = isset($_POST['rm180u4amin']) ? $_POST['rm180u4amin'] : $rm180u4amin;
$rm180u4amax = isset($_POST['rm180u4amax']) ? $_POST['rm180u4amax'] : $rm180u4amax;
$H2Orm4amin = isset($_POST['H2Orm4amin']) ? $_POST['H2Orm4amin'] : $H2Orm4amin;
$H2Orm4amax = isset($_POST['H2Orm4amax']) ? $_POST['H2Orm4amax'] : $H2Orm4amax;
$SDLSFrm4amin = isset($_POST['SDLSFrm4amin']) ? $_POST['SDLSFrm4amin'] : $SDLSFrm4amin;
$SDLSFrm4amax = isset($_POST['SDLSFrm4amax']) ? $_POST['SDLSFrm4amax'] : $SDLSFrm4amax;
$LSFrm4cmin = isset($_POST['LSFrm4cmin']) ? $_POST['LSFrm4cmin'] : $LSFrm4cmin;
$LSFrm4cmax = isset($_POST['LSFrm4cmax']) ? $_POST['LSFrm4cmax'] : $LSFrm4cmax;
$SIMrm4cmin = isset($_POST['SIMrm4cmin']) ? $_POST['SIMrm4cmin'] : $SIMrm4cmin;
$SIMrm4cmax = isset($_POST['SIMrm4cmax']) ? $_POST['SIMrm4cmax'] : $SIMrm4cmax;
$ALMrm4cmin = isset($_POST['ALMrm4cmin']) ? $_POST['ALMrm4cmin'] : $ALMrm4cmin;
$ALMrm4cmax = isset($_POST['ALMrm4cmax']) ? $_POST['ALMrm4cmax'] : $ALMrm4cmax;
$rm90u4cmin = isset($_POST['rm90u4cmin']) ? $_POST['rm90u4cmin'] : $rm90u4cmin;
$rm90u4cmax = isset($_POST['rm90u4cmax']) ? $_POST['rm90u4cmax'] : $rm90u4cmax;
$rm180u4cmin = isset($_POST['rm180u4cmin']) ? $_POST['rm180u4cmin'] : $rm180u4cmin;
$rm180u4cmax = isset($_POST['rm180u4cmax']) ? $_POST['rm180u4cmax'] : $rm180u4cmax;
$H2Orm4cmin = isset($_POST['H2Orm4cmin']) ? $_POST['H2Orm4cmin'] : $H2Orm4cmin;
$H2Orm4cmax = isset($_POST['H2Orm4cmax']) ? $_POST['H2Orm4cmax'] : $H2Orm4cmax;
$SDLSFrm4cmin = isset($_POST['SDLSFrm4cmin']) ? $_POST['SDLSFrm4cmin'] : $SDLSFrm4cmin;
$SDLSFrm4cmax = isset($_POST['SDLSFrm4cmax']) ? $_POST['SDLSFrm4cmax'] : $SDLSFrm4cmax;
$LSFrm5min = isset($_POST['LSFrm5min']) ? $_POST['LSFrm5min'] : $LSFrm5min;
$LSFrm5max = isset($_POST['LSFrm5max']) ? $_POST['LSFrm5max'] : $LSFrm5max;
$SIMrm5min = isset($_POST['SIMrm5min']) ? $_POST['SIMrm5min'] : $SIMrm5min;
$SIMrm5max = isset($_POST['SIMrm5max']) ? $_POST['SIMrm5max'] : $SIMrm5max;
$ALMrm5min = isset($_POST['ALMrm5min']) ? $_POST['ALMrm5min'] : $ALMrm5min;
$ALMrm5max = isset($_POST['ALMrm5max']) ? $_POST['ALMrm5max'] : $ALMrm5max;
$rm90u5min = isset($_POST['rm90u5min']) ? $_POST['rm90u5min'] : $rm90u5min;
$rm90u5max = isset($_POST['rm90u5max']) ? $_POST['rm90u5max'] : $rm90u5max;
$rm180u5min = isset($_POST['rm180u5min']) ? $_POST['rm180u5min'] : $rm180u5min;
$rm180u5max = isset($_POST['rm180u5max']) ? $_POST['rm180u5max'] : $rm180u5max;
$H2Orm5min = isset($_POST['H2Orm5min']) ? $_POST['H2Orm5min'] : $H2Orm5min;
$H2Orm5max = isset($_POST['H2Orm5max']) ? $_POST['H2Orm5max'] : $H2Orm5max;
$SDLSFrm5min = isset($_POST['SDLSFrm5min']) ? $_POST['SDLSFrm5min'] : $SDLSFrm5min;
$SDLSFrm5max = isset($_POST['SDLSFrm5max']) ? $_POST['SDLSFrm5max'] : $SDLSFrm5max;
$LSFrm6min = isset($_POST['LSFrm6min']) ? $_POST['LSFrm6min'] : $LSFrm6min;
$LSFrm6max = isset($_POST['LSFrm6max']) ? $_POST['LSFrm6max'] : $LSFrm6max;
$SIMrm6min = isset($_POST['SIMrm6min']) ? $_POST['SIMrm6min'] : $SIMrm6min;
$SIMrm6max = isset($_POST['SIMrm6max']) ? $_POST['SIMrm6max'] : $SIMrm6max;
$ALMrm6min = isset($_POST['ALMrm6min']) ? $_POST['ALMrm6min'] : $ALMrm6min;
$ALMrm6max = isset($_POST['ALMrm6max']) ? $_POST['ALMrm6max'] : $ALMrm6max;
$rm90u6min = isset($_POST['rm90u6min']) ? $_POST['rm90u6min'] : $rm90u6min;
$rm90u6max = isset($_POST['rm90u6max']) ? $_POST['rm90u6max'] : $rm90u6max;
$rm180u6min = isset($_POST['rm180u6min']) ? $_POST['rm180u6min'] : $rm180u6min;
$rm180u6max = isset($_POST['rm180u6max']) ? $_POST['rm180u6max'] : $rm180u6max;
$H2Orm6min = isset($_POST['H2Orm6min']) ? $_POST['H2Orm6min'] : $H2Orm6min;
$H2Orm6max = isset($_POST['H2Orm6max']) ? $_POST['H2Orm6max'] : $H2Orm6max;
$SDLSFrm6min = isset($_POST['SDLSFrm6min']) ? $_POST['SDLSFrm6min'] : $SDLSFrm6min;
$SDLSFrm6max = isset($_POST['SDLSFrm6max']) ? $_POST['SDLSFrm6max'] : $SDLSFrm6max;
$LSFkf4min = isset($_POST['LSFkf4min']) ? $_POST['LSFkf4min'] : $LSFkf4min;
$LSFkf4max = isset($_POST['LSFkf4max']) ? $_POST['LSFkf4max'] : $LSFkf4max;
$SIMkf4min = isset($_POST['SIMkf4min']) ? $_POST['SIMkf4min'] : $SIMkf4min;
$SIMkf4max = isset($_POST['SIMkf4max']) ? $_POST['SIMkf4max'] : $SIMkf4max;
$ALMkf4min = isset($_POST['ALMkf4min']) ? $_POST['ALMkf4min'] : $ALMkf4min;
$ALMkf4max = isset($_POST['ALMkf4max']) ? $_POST['ALMkf4max'] : $ALMkf4max;
$kf90u4min = isset($_POST['kf90u4min']) ? $_POST['kf90u4min'] : $kf90u4min;
$kf90u4max = isset($_POST['kf90u4max']) ? $_POST['kf90u4max'] : $kf90u4max;
$kf180u4min = isset($_POST['kf180u4min']) ? $_POST['kf180u4min'] : $kf180u4min;
$kf180u4max = isset($_POST['kf180u4max']) ? $_POST['kf180u4max'] : $kf180u4max;
$H2Okf4min = isset($_POST['H2Okf4min']) ? $_POST['H2Okf4min'] : $H2Okf4min;
$H2Okf4max = isset($_POST['H2Okf4max']) ? $_POST['H2Okf4max'] : $H2Okf4max;
$SDLSFkf4min = isset($_POST['SDLSFkf4min']) ? $_POST['SDLSFkf4min'] : $SDLSFkf4min;
$SDLSFkf4max = isset($_POST['SDLSFkf4max']) ? $_POST['SDLSFkf4max'] : $SDLSFkf4max;
$LSFkf5min = isset($_POST['LSFkf5min']) ? $_POST['LSFkf5min'] : $LSFkf5min;
$LSFkf5max = isset($_POST['LSFkf5max']) ? $_POST['LSFkf5max'] : $LSFkf5max;
$SIMkf5min = isset($_POST['SIMkf5min']) ? $_POST['SIMkf5min'] : $SIMkf5min;
$SIMkf5max = isset($_POST['SIMkf5max']) ? $_POST['SIMkf5max'] : $SIMkf5max;
$ALMkf5min = isset($_POST['ALMkf5min']) ? $_POST['ALMkf5min'] : $ALMkf5min;
$ALMkf5max = isset($_POST['ALMkf5max']) ? $_POST['ALMkf5max'] : $ALMkf5max;
$kf90u5min = isset($_POST['kf90u5min']) ? $_POST['kf90u5min'] : $kf90u5min;
$kf90u5max = isset($_POST['kf90u5max']) ? $_POST['kf90u5max'] : $kf90u5max;
$kf180u5min = isset($_POST['kf180u5min']) ? $_POST['kf180u5min'] : $kf180u5min;
$kf180u5max = isset($_POST['kf180u5max']) ? $_POST['kf180u5max'] : $kf180u5max;
$H2Okf5min = isset($_POST['H2Okf5min']) ? $_POST['H2Okf5min'] : $H2Okf5min;
$H2Okf5max = isset($_POST['H2Okf5max']) ? $_POST['H2Okf5max'] : $H2Okf5max;
$SDLSFkf5min = isset($_POST['SDLSFkf5min']) ? $_POST['SDLSFkf5min'] : $SDLSFkf5min;
$SDLSFkf5max = isset($_POST['SDLSFkf5max']) ? $_POST['SDLSFkf5max'] : $SDLSFkf5max;
$LSFkf6min = isset($_POST['LSFkf6min']) ? $_POST['LSFkf6min'] : $LSFkf6min;
$LSFkf6max = isset($_POST['LSFkf6max']) ? $_POST['LSFkf6max'] : $LSFkf6max;
$SIMkf6min = isset($_POST['SIMkf6min']) ? $_POST['SIMkf6min'] : $SIMkf6min;
$SIMkf6max = isset($_POST['SIMkf6max']) ? $_POST['SIMkf6max'] : $SIMkf6max;
$ALMkf6min = isset($_POST['ALMkf6min']) ? $_POST['ALMkf6min'] : $ALMkf6min;
$ALMkf6max = isset($_POST['ALMkf6max']) ? $_POST['ALMkf6max'] : $ALMkf6max;
$kf90u6min = isset($_POST['kf90u6min']) ? $_POST['kf90u6min'] : $kf90u6min;
$kf90u6max = isset($_POST['kf90u6max']) ? $_POST['kf90u6max'] : $kf90u6max;
$kf180u6min = isset($_POST['kf180u6min']) ? $_POST['kf180u6min'] : $kf180u6min;
$kf180u6max = isset($_POST['kf180u6max']) ? $_POST['kf180u6max'] : $kf180u6max;
$H2Okf6min = isset($_POST['H2Okf6min']) ? $_POST['H2Okf6min'] : $H2Okf6min;
$H2Okf6max = isset($_POST['H2Okf6max']) ? $_POST['H2Okf6max'] : $H2Okf6max;
$SDLSFkf6min = isset($_POST['SDLSFkf6min']) ? $_POST['SDLSFkf6min'] : $SDLSFkf6min;
$SDLSFkf6max = isset($_POST['SDLSFkf6max']) ? $_POST['SDLSFkf6max'] : $SDLSFkf6max;
$LSFcr4min = isset($_POST['LSFcr4min']) ? $_POST['LSFcr4min'] : $LSFcr4min;
$LSFcr4max = isset($_POST['LSFcr4max']) ? $_POST['LSFcr4max'] : $LSFcr4max;
$SIMcr4min = isset($_POST['SIMcr4min']) ? $_POST['SIMcr4min'] : $SIMcr4min;
$SIMcr4max = isset($_POST['SIMcr4max']) ? $_POST['SIMcr4max'] : $SIMcr4max;
$ALMcr4min = isset($_POST['ALMcr4min']) ? $_POST['ALMcr4min'] : $ALMcr4min;
$ALMcr4max = isset($_POST['ALMcr4max']) ? $_POST['ALMcr4max'] : $ALMcr4max;
$C3Scr4min = isset($_POST['C3Scr4min']) ? $_POST['C3Scr4min'] : $C3Scr4min;
$C3Scr4max = isset($_POST['C3Scr4max']) ? $_POST['C3Scr4max'] : $C3Scr4max;
$C3Acr4min = isset($_POST['C3Acr4min']) ? $_POST['C3Acr4min'] : $C3Acr4min;
$C3Acr4max = isset($_POST['C3Acr4max']) ? $_POST['C3Acr4max'] : $C3Acr4max;
$ALKALIcr4min = isset($_POST['ALKALIcr4min']) ? $_POST['ALKALIcr4min'] : $ALKALIcr4min;
$ALKALIcr4max = isset($_POST['ALKALIcr4max']) ? $_POST['ALKALIcr4max'] : $ALKALIcr4max;
$SDC3Scr4min = isset($_POST['SDC3Scr4min']) ? $_POST['SDC3Scr4min'] : $SDC3Scr4min;
$SDC3Scr4max = isset($_POST['SDC3Scr4max']) ? $_POST['SDC3Scr4max'] : $SDC3Scr4max;
$FCaOcr4min = isset($_POST['FCaOcr4min']) ? $_POST['FCaOcr4min'] : $FCaOcr4min;
$FCaOcr4max = isset($_POST['FCaOcr4max']) ? $_POST['FCaOcr4max'] : $FCaOcr4max;
$LSFcr5min = isset($_POST['LSFcr5min']) ? $_POST['LSFcr5min'] : $LSFcr5min;
$LSFcr5max = isset($_POST['LSFcr5max']) ? $_POST['LSFcr5max'] : $LSFcr5max;
$SIMcr5min = isset($_POST['SIMcr5min']) ? $_POST['SIMcr5min'] : $SIMcr5min;
$SIMcr5max = isset($_POST['SIMcr5max']) ? $_POST['SIMcr5max'] : $SIMcr5max;
$ALMcr5min = isset($_POST['ALMcr5min']) ? $_POST['ALMcr5min'] : $ALMcr5min;
$ALMcr5max = isset($_POST['ALMcr5max']) ? $_POST['ALMcr5max'] : $ALMcr5max;
$C3Scr5min = isset($_POST['C3Scr5min']) ? $_POST['C3Scr5min'] : $C3Scr5min;
$C3Scr5max = isset($_POST['C3Scr5max']) ? $_POST['C3Scr5max'] : $C3Scr5max;
$C3Acr5min = isset($_POST['C3Acr5min']) ? $_POST['C3Acr5min'] : $C3Acr5min;
$C3Acr5max = isset($_POST['C3Acr5max']) ? $_POST['C3Acr5max'] : $C3Acr5max;
$ALKALIcr5min = isset($_POST['ALKALIcr5min']) ? $_POST['ALKALIcr5min'] : $ALKALIcr5min;
$ALKALIcr5max = isset($_POST['ALKALIcr5max']) ? $_POST['ALKALIcr5max'] : $ALKALIcr5max;
$SDC3Scr5min = isset($_POST['SDC3Scr5min']) ? $_POST['SDC3Scr5min'] : $SDC3Scr5min;
$SDC3Scr5max = isset($_POST['SDC3Scr5max']) ? $_POST['SDC3Scr5max'] : $SDC3Scr5max;
$FCaOcr5min = isset($_POST['FCaOcr5min']) ? $_POST['FCaOcr5min'] : $FCaOcr5min;
$FCaOcr5max = isset($_POST['FCaOcr5max']) ? $_POST['FCaOcr5max'] : $FCaOcr5max;
$LSFcr6min = isset($_POST['LSFcr6min']) ? $_POST['LSFcr6min'] : $LSFcr6min;
$LSFcr6max = isset($_POST['LSFcr6max']) ? $_POST['LSFcr6max'] : $LSFcr6max;
$SIMcr6min = isset($_POST['SIMcr6min']) ? $_POST['SIMcr6min'] : $SIMcr6min;
$SIMcr6max = isset($_POST['SIMcr6max']) ? $_POST['SIMcr6max'] : $SIMcr6max;
$ALMcr6min = isset($_POST['ALMcr6min']) ? $_POST['ALMcr6min'] : $ALMcr6min;
$ALMcr6max = isset($_POST['ALMcr6max']) ? $_POST['ALMcr6max'] : $ALMcr6max;
$C3Scr6min = isset($_POST['C3Scr6min']) ? $_POST['C3Scr6min'] : $C3Scr6min;
$C3Scr6max = isset($_POST['C3Scr6max']) ? $_POST['C3Scr6max'] : $C3Scr6max;
$C3Acr6min = isset($_POST['C3Acr6min']) ? $_POST['C3Acr6min'] : $C3Acr6min;
$C3Acr6max = isset($_POST['C3Acr6max']) ? $_POST['C3Acr6max'] : $C3Acr6max;
$ALKALIcr6min = isset($_POST['ALKALIcr6min']) ? $_POST['ALKALIcr6min'] : $ALKALIcr6min;
$ALKALIcr6max = isset($_POST['ALKALIcr6max']) ? $_POST['ALKALIcr6max'] : $ALKALIcr6max;
$SDC3Scr6min = isset($_POST['SDC3Scr6min']) ? $_POST['SDC3Scr6min'] : $SDC3Scr6min;
$SDC3Scr6max = isset($_POST['SDC3Scr6max']) ? $_POST['SDC3Scr6max'] : $SDC3Scr6max;
$FCaOcr6min = isset($_POST['FCaOcr6min']) ? $_POST['FCaOcr6min'] : $FCaOcr6min;
$FCaOcr6max = isset($_POST['FCaOcr6max']) ? $_POST['FCaOcr6max'] : $FCaOcr6max;
$H2Ois_max = isset($_POST['H2Ois_max']) ? $_POST['H2Ois_max'] : $H2Ois_max;
$H2Ois_min = isset($_POST['H2Ois_min']) ? $_POST['H2Ois_min'] : $H2Ois_min;
$Fe2O3is_max = isset($_POST['Fe2O3is_max']) ? $_POST['Fe2O3is_max'] : $Fe2O3is_max;
$Fe2O3is_min = isset($_POST['Fe2O3is_min']) ? $_POST['Fe2O3is_min'] : $Fe2O3is_min;
$ACfc4min = isset($_POST['ACfc4min']) ? $_POST['ACfc4min'] : $ACfc4min;
$ACfc4max = isset($_POST['ACfc4max']) ? $_POST['ACfc4max'] : $ACfc4max;
$fc90u4max = isset($_POST['fc90u4max']) ? $_POST['fc90u4max'] : $fc90u4max;
$fc90u4min = isset($_POST['fc90u4min']) ? $_POST['fc90u4min'] : $fc90u4min;
$H2Ofc4max = isset($_POST['H2Ofc4max']) ? $_POST['H2Ofc4max'] : $H2Ofc4max;
$H2Ofc4min = isset($_POST['H2Ofc4min']) ? $_POST['H2Ofc4min'] : $H2Ofc4min;
$ACfc5min = isset($_POST['ACfc5min']) ? $_POST['ACfc5min'] : $ACfc5min;
$ACfc5max = isset($_POST['ACfc5max']) ? $_POST['ACfc5max'] : $ACfc5max;
$fc90u5max = isset($_POST['fc90u5max']) ? $_POST['fc90u5max'] : $fc90u5max;
$fc90u5min = isset($_POST['fc90u5min']) ? $_POST['fc90u5min'] : $fc90u5min;
$H2Ofc5max = isset($_POST['H2Ofc5max']) ? $_POST['H2Ofc5max'] : $H2Ofc5max;
$H2Ofc5min = isset($_POST['H2Ofc5min']) ? $_POST['H2Ofc5min'] : $H2Ofc5min;
$ACfc6min = isset($_POST['ACfc6min']) ? $_POST['ACfc6min'] : $ACfc6min;
$ACfc6max = isset($_POST['ACfc6max']) ? $_POST['ACfc6max'] : $ACfc6max;
$fc90u6max = isset($_POST['fc90u6max']) ? $_POST['fc90u6max'] : $fc90u6max;
$fc90u6min = isset($_POST['fc90u6min']) ? $_POST['fc90u6min'] : $fc90u6min;
$H2Ofc6max = isset($_POST['H2Ofc6max']) ? $_POST['H2Ofc6max'] : $H2Ofc6max;
$H2Ofc6min = isset($_POST['H2Ofc6min']) ? $_POST['H2Ofc6min'] : $H2Ofc6min;
$BTLpccmax = isset($_POST['BTLpccmax']) ? $_POST['BTLpccmax'] : $BTLpccmax;
$BTLpccmin = isset($_POST['BTLpccmin']) ? $_POST['BTLpccmin'] : $BTLpccmin;
$MgOpccmin = isset($_POST['MgOpccmin']) ? $_POST['MgOpccmin'] : $MgOpccmin;
$MgOpccmax = isset($_POST['MgOpccmax']) ? $_POST['MgOpccmax'] : $MgOpccmax;
$SO3pccmax = isset($_POST['SO3pccmax']) ? $_POST['SO3pccmax'] : $SO3pccmax;
$SO3pccmin = isset($_POST['SO3pccmin']) ? $_POST['SO3pccmin'] : $SO3pccmin;
$FCaOpccmax = isset($_POST['FCaOpccmax']) ? $_POST['FCaOpccmax'] : $FCaOpccmax;
$FCaOpccmin = isset($_POST['FCaOpccmin']) ? $_POST['FCaOpccmin'] : $FCaOpccmin;
$LOIpccmin = isset($_POST['LOIpccmin']) ? $_POST['LOIpccmin'] : $LOIpccmin;
$LOIpccmax = isset($_POST['LOIpccmax']) ? $_POST['LOIpccmax'] : $LOIpccmax;
$ALKALIpccmax = isset($_POST['ALKALIpccmax']) ? $_POST['ALKALIpccmax'] : $ALKALIpccmax;
$ALKALIpccmin = isset($_POST['ALKALIpccmin']) ? $_POST['ALKALIpccmin'] : $ALKALIpccmin;
$z145upccmax = isset($_POST['z145upccmax']) ? $_POST['z145upccmax'] : $z145upccmax;
$z145upccmin = isset($_POST['z145upccmin']) ? $_POST['z145upccmin'] : $z145upccmin;
$BLAINEpccmax = isset($_POST['BLAINEpccmax']) ? $_POST['BLAINEpccmax'] : $BLAINEpccmax;
$BLAINEpccmin = isset($_POST['BLAINEpccmin']) ? $_POST['BLAINEpccmin'] : $BLAINEpccmin;
$BTLopcmax = isset($_POST['BTLopcmax']) ? $_POST['BTLopcmax'] : $BTLopcmax;
$BTLopcmin = isset($_POST['BTLopcmin']) ? $_POST['BTLopcmin'] : $BTLopcmin;
$MgOopcmin = isset($_POST['MgOopcmin']) ? $_POST['MgOopcmin'] : $MgOopcmin;
$MgOopcmax = isset($_POST['MgOopcmax']) ? $_POST['MgOopcmax'] : $MgOopcmax;
$SO3opcmax = isset($_POST['SO3opcmax']) ? $_POST['SO3opcmax'] : $SO3opcmax;
$SO3opcmin = isset($_POST['SO3opcmin']) ? $_POST['SO3opcmin'] : $SO3opcmin;
$FCaOopcmax = isset($_POST['FCaOopcmax']) ? $_POST['FCaOopcmax'] : $FCaOopcmax;
$FCaOopcmin = isset($_POST['FCaOopcmin']) ? $_POST['FCaOopcmin'] : $FCaOopcmin;
$LOIopcmin = isset($_POST['LOIopcmin']) ? $_POST['LOIopcmin'] : $LOIopcmin;
$LOIopcmax = isset($_POST['LOIopcmax']) ? $_POST['LOIopcmax'] : $LOIopcmax;
$ALKALIopcmax = isset($_POST['ALKALIopcmax']) ? $_POST['ALKALIopcmax'] : $ALKALIopcmax;
$ALKALIopcmin = isset($_POST['ALKALIopcmin']) ? $_POST['ALKALIopcmin'] : $ALKALIopcmin;
$z145uopcmax = isset($_POST['z145uopcmax']) ? $_POST['z145uopcmax'] : $z145uopcmax;
$z145uopcmin = isset($_POST['z145uopcmin']) ? $_POST['z145uopcmin'] : $z145uopcmin;
$BLAINEopcmax = isset($_POST['BLAINEopcmax']) ? $_POST['BLAINEopcmax'] : $BLAINEopcmax;
$BLAINEopcmin = isset($_POST['BLAINEopcmin']) ? $_POST['BLAINEopcmin'] : $BLAINEopcmin;
$BTLppcmax = isset($_POST['BTLppcmax']) ? $_POST['BTLppcmax'] : $BTLppcmax;
$BTLppcmin = isset($_POST['BTLppcmin']) ? $_POST['BTLppcmin'] : $BTLppcmin;
$MgOppcmin = isset($_POST['MgOppcmin']) ? $_POST['MgOppcmin'] : $MgOppcmin;
$MgOppcmax = isset($_POST['MgOppcmax']) ? $_POST['MgOppcmax'] : $MgOppcmax;
$SO3ppcmax = isset($_POST['SO3ppcmax']) ? $_POST['SO3ppcmax'] : $SO3ppcmax;
$SO3ppcmin = isset($_POST['SO3ppcmin']) ? $_POST['SO3ppcmin'] : $SO3ppcmin;
$FCaOppcmax = isset($_POST['FCaOppcmax']) ? $_POST['FCaOppcmax'] : $FCaOppcmax;
$FCaOppcmin = isset($_POST['FCaOppcmin']) ? $_POST['FCaOppcmin'] : $FCaOppcmin;
$LOIppcmin = isset($_POST['LOIppcmin']) ? $_POST['LOIppcmin'] : $LOIppcmin;
$LOIppcmax = isset($_POST['LOIppcmax']) ? $_POST['LOIppcmax'] : $LOIppcmax;
$ALKALIppcmax = isset($_POST['ALKALIppcmax']) ? $_POST['ALKALIppcmax'] : $ALKALIppcmax;
$ALKALIppcmin = isset($_POST['ALKALIppcmin']) ? $_POST['ALKALIppcmin'] : $ALKALIppcmin;
$z145uppcmax = isset($_POST['z145uppcmax']) ? $_POST['z145uppcmax'] : $z145uppcmax;
$z145uppcmin = isset($_POST['z145uppcmin']) ? $_POST['z145uppcmin'] : $z145uppcmin;
$BLAINEppcmax = isset($_POST['BLAINEppcmax']) ? $_POST['BLAINEppcmax'] : $BLAINEppcmax;
$BLAINEppcmin = isset($_POST['BLAINEppcmin']) ? $_POST['BLAINEppcmin'] : $BLAINEppcmin;
$SiO2cl_max = isset($_POST['SiO2cl_max']) ? $_POST['SiO2cl_max'] : $SiO2cl_max;
$SiO2cl_min = isset($_POST['SiO2cl_min']) ? $_POST['SiO2cl_min'] : $SiO2cl_min;
$Al2O3cl_max = isset($_POST['Al2O3cl_max']) ? $_POST['Al2O3cl_max'] : $Al2O3cl_max;
$Al2O3cl_min = isset($_POST['Al2O3cl_min']) ? $_POST['Al2O3cl_min'] : $Al2O3cl_min;
$SiO2qc_max = isset($_POST['SiO2qc_max']) ? $_POST['SiO2qc_max'] : $SiO2qc_max;
$SiO2qc_min = isset($_POST['SiO2qc_min']) ? $_POST['SiO2qc_min'] : $SiO2qc_min;
$Al2O3qc_max = isset($_POST['Al2O3qc_max']) ? $_POST['Al2O3qc_max'] : $Al2O3qc_max;
$Al2O3qc_min = isset($_POST['Al2O3qc_min']) ? $_POST['Al2O3qc_min'] : $Al2O3qc_min;
$CaOqc_max = isset($_POST['CaOqc_max']) ? $_POST['CaOqc_max'] : $CaOqc_max;
$CaOqc_min = isset($_POST['CaOqc_min']) ? $_POST['CaOqc_min'] : $CaOqc_min;
$ALKALIqc_max = isset($_POST['ALKALIqc_max']) ? $_POST['ALKALIqc_max'] : $ALKALIqc_max;
$ALKALIqc_min = isset($_POST['ALKALIqc_min']) ? $_POST['ALKALIqc_min'] : $ALKALIqc_min;



if (isset($_POST['update'])) {
     { $sql = "UPDATE tb_config SET max = '$H2Ols_max', min = '$H2Ols_min' WHERE nama_config = 'H2Ols'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$SiO2ls_max', min = '$SiO2ls_min' WHERE nama_config = 'SiO2ls'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$Al2O3ls_max', min = '$Al2O3ls_min' WHERE nama_config = 'Al2O3ls'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$CaOls_max', min = '$CaOls_min' WHERE nama_config = 'CaOls'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$ALKALIls_max', min = '$ALKALIls_min' WHERE nama_config = 'ALKALIls'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$H2Orm_max', min = '$H2Orm_min' WHERE nama_config = 'H2Orm'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$SiO2rm_max', min = '$SiO2rm_min' WHERE nama_config = 'SiO2rm'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$Al2O3rm_max', min = '$Al2O3rm_min' WHERE nama_config = 'Al2O3rm'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$CaOrm_max', min = '$CaOrm_min' WHERE nama_config = 'CaOrm'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$ALKALIrm_max', min = '$ALKALIrm_min' WHERE nama_config = 'ALKALIrm'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$H2Ocm_max', min = '$H2Ocm_min' WHERE nama_config = 'H2Ocm'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$SiO2cm_max', min = '$SiO2cm_min' WHERE nama_config = 'SiO2cm'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$Al2O3cm_max', min = '$Al2O3cm_min' WHERE nama_config = 'Al2O3cm'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$CaOcm_max', min = '$CaOcm_min' WHERE nama_config = 'CaOcm'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$ALKALIcm_max', min = '$ALKALIcm_min' WHERE nama_config = 'ALKALIcm'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$H2Oss_max', min = '$H2Oss_min' WHERE nama_config = 'H2Oss'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$SiO2ss_max', min = '$SiO2ss_min' WHERE nama_config = 'SiO2ss'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$Al2O3ss_max', min = '$Al2O3ss_min' WHERE nama_config = 'Al2O3ss'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$LSFrm4amax', min = '$LSFrm4amin' WHERE nama_config = 'LSFrm4a'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$SIMrm4amax', min = '$SIMrm4amin' WHERE nama_config = 'SIMrm4a'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$ALMrm4amax', min = '$ALMrm4amin' WHERE nama_config = 'ALMrm4a'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$rm90u4amax', min = '$rm90u4amin' WHERE nama_config = 'rm90u4a'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$rm180u4amax', min = '$rm180u4amin' WHERE nama_config = 'rm180u4a'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$H2Orm4amax', min = '$H2Orm4amin' WHERE nama_config = 'H2Orm4a'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$SDLSFrm4amax', min = '$SDLSFrm4amin' WHERE nama_config = 'SDLSFrm4a'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$LSFrm4cmax', min = '$LSFrm4cmin' WHERE nama_config = 'LSFrm4c'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$SIMrm4cmax', min = '$SIMrm4cmin' WHERE nama_config = 'SIMrm4c'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$ALMrm4cmax', min = '$ALMrm4cmin' WHERE nama_config = 'ALMrm4c'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$rm90u4cmax', min = '$rm90u4cmin' WHERE nama_config = 'rm90u4c'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$rm180u4cmax', min = '$rm180u4cmin' WHERE nama_config = 'rm180u4c'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$H2Orm4cmax', min = '$H2Orm4cmin' WHERE nama_config = 'H2Orm4c'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$SDLSFrm4cmax', min = '$SDLSFrm4cmin' WHERE nama_config = 'SDLSFrm4c'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$LSFrm5max', min = '$LSFrm5min' WHERE nama_config = 'LSFrm5'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$SIMrm5max', min = '$SIMrm5min' WHERE nama_config = 'SIMrm5'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$ALMrm5max', min = '$ALMrm5min' WHERE nama_config = 'ALMrm5'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$rm90u5max', min = '$rm90u5min' WHERE nama_config = 'rm90u5'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$rm180u5max', min = '$rm180u5min' WHERE nama_config = 'rm180u5'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$H2Orm5max', min = '$H2Orm5min' WHERE nama_config = 'H2Orm5'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$SDLSFrm5max', min = '$SDLSFrm5min' WHERE nama_config = 'SDLSFrm5'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$LSFrm6max', min = '$LSFrm6min' WHERE nama_config = 'LSFrm6'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$SIMrm6max', min = '$SIMrm6min' WHERE nama_config = 'SIMrm6'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$ALMrm6max', min = '$ALMrm6min' WHERE nama_config = 'ALMrm6'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$rm90u6max', min = '$rm90u6min' WHERE nama_config = 'rm90u6'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$rm180u6max', min = '$rm180u6min' WHERE nama_config = 'rm180u6'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$H2Orm6max', min = '$H2Orm6min' WHERE nama_config = 'H2Orm6'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$SDLSFrm6max', min = '$SDLSFrm6min' WHERE nama_config = 'SDLSFrm6'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$LSFkf4max', min = '$LSFkf4min' WHERE nama_config = 'LSFkf4'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$SIMkf4max', min = '$SIMkf4min' WHERE nama_config = 'SIMkf4'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$ALMkf4max', min = '$ALMkf4min' WHERE nama_config = 'ALMkf4'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$kf90u4max', min = '$kf90u4min' WHERE nama_config = 'kf90u4'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$kf180u4max', min = '$kf180u4min' WHERE nama_config = 'kf180u4'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$H2Okf4max', min = '$H2Okf4min' WHERE nama_config = 'H2Okf4'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$SDLSFkf4max', min = '$SDLSFkf4min' WHERE nama_config = 'SDLSFkf4'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$LSFkf5max', min = '$LSFkf5min' WHERE nama_config = 'LSFkf5'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$SIMkf5max', min = '$SIMkf5min' WHERE nama_config = 'SIMkf5'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$ALMkf5max', min = '$ALMkf5min' WHERE nama_config = 'ALMkf5'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$kf90u5max', min = '$kf90u5min' WHERE nama_config = 'kf90u5'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$kf180u5max', min = '$kf180u5min' WHERE nama_config = 'kf180u5'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$H2Okf5max', min = '$H2Okf5min' WHERE nama_config = 'H2Okf5'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$SDLSFkf5max', min = '$SDLSFkf5min' WHERE nama_config = 'SDLSFkf5'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$LSFkf6max', min = '$LSFkf6min' WHERE nama_config = 'LSFkf6'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$SIMkf6max', min = '$SIMkf6min' WHERE nama_config = 'SIMkf6'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$ALMkf6max', min = '$ALMkf6min' WHERE nama_config = 'ALMkf6'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$kf90u6max', min = '$kf90u6min' WHERE nama_config = 'kf90u6'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$kf180u6max', min = '$kf180u6min' WHERE nama_config = 'kf180u6'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$H2Okf6max', min = '$H2Okf6min' WHERE nama_config = 'H2Okf6'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$SDLSFkf6max', min = '$SDLSFkf6min' WHERE nama_config = 'SDLSFkf6'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$LSFcr4max', min = '$LSFcr4min' WHERE nama_config = 'LSFcr4'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$SIMcr4max', min = '$SIMcr4min' WHERE nama_config = 'SIMcr4'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$ALMcr4max', min = '$ALMcr4min' WHERE nama_config = 'ALMcr4'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$C3Scr4max', min = '$C3Scr4min' WHERE nama_config = 'C3Scr4'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$C3Acr4max', min = '$C3Acr4min' WHERE nama_config = 'C3Acr4'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$ALKALIcr4max', min = '$ALKALIcr4min' WHERE nama_config = 'ALKALIcr4'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$SDC3Scr4max', min = '$SDC3Scr4min' WHERE nama_config = 'SDC3Scr4'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$FCaOcr4max', min = '$FCaOcr4min' WHERE nama_config = 'FCaOcr4'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$LSFcr5max', min = '$LSFcr5min' WHERE nama_config = 'LSFcr5'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$SIMcr5max', min = '$SIMcr5min' WHERE nama_config = 'SIMcr5'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$ALMcr5max', min = '$ALMcr5min' WHERE nama_config = 'ALMcr5'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$C3Scr5max', min = '$C3Scr5min' WHERE nama_config = 'C3Scr5'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$C3Acr5max', min = '$C3Acr5min' WHERE nama_config = 'C3Acr5'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$ALKALIcr5max', min = '$ALKALIcr5min' WHERE nama_config = 'ALKALIcr5'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$SDC3Scr5max', min = '$SDC3Scr5min' WHERE nama_config = 'SDC3Scr5'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$FCaOcr5max', min = '$FCaOcr5min' WHERE nama_config = 'FCaOcr5'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$LSFcr6max', min = '$LSFcr6min' WHERE nama_config = 'LSFcr6'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$SIMcr6max', min = '$SIMcr6min' WHERE nama_config = 'SIMcr6'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$ALMcr6max', min = '$ALMcr6min' WHERE nama_config = 'ALMcr6'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$C3Scr6max', min = '$C3Scr6min' WHERE nama_config = 'C3Scr6'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$C3Acr6max', min = '$C3Acr6min' WHERE nama_config = 'C3Acr6'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$ALKALIcr6max', min = '$ALKALIcr6min' WHERE nama_config = 'ALKALIcr6'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$SDC3Scr6max', min = '$SDC3Scr6min' WHERE nama_config = 'SDC3Scr6'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$FCaOcr6max', min = '$FCaOcr6min' WHERE nama_config = 'FCaOcr6'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$H2Ois_max', min = '$H2Ois_min' WHERE nama_config = 'H2Ois'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$Fe2O3is_max', min = '$Fe2O3is_min' WHERE nama_config = 'Fe2O3is'";
        mysqli_query($conn, $sql);
    }{ $sql = "UPDATE tb_config SET max = '$fc90u4max', min = '$fc90u4min' WHERE nama_config = 'fc90u4'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$ACfc4max', min = '$ACfc4min' WHERE nama_config = 'ACfc4'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$H2Ofc4max', min = '$H2Ofc4min' WHERE nama_config = 'H2Ofc4'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$fc90u5max', min = '$fc90u5min' WHERE nama_config = 'fc90u5'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$ACfc5max', min = '$ACfc5min' WHERE nama_config = 'ACfc5'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$H2Ofc5max', min = '$H2Ofc5min' WHERE nama_config = 'H2Ofc5'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$fc90u6max', min = '$fc90u6min' WHERE nama_config = 'fc90u6'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$ACfc6max', min = '$ACfc6min' WHERE nama_config = 'ACfc6'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$H2Ofc6max', min = '$H2Ofc6min' WHERE nama_config = 'H2Ofc6'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$BTLpccmax', min = '$BTLpccmin' WHERE nama_config = 'BTLpcc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$MgOpccmax', min = '$MgOpccmin' WHERE nama_config = 'MgOpcc'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$SO3pccmax', min = '$SO3pccmin' WHERE nama_config = 'SO3pcc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$FCaOpccmax', min = '$FCaOpccmin' WHERE nama_config = 'FCaOpcc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$LOIpccmax', min = '$LOIpccmin' WHERE nama_config = 'LOIpcc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$ALKALIpccmax', min = '$ALKALIpccmin' WHERE nama_config = 'ALKALIpcc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$z145upccmax', min = '$z145upccmin' WHERE nama_config = 'z145upcc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$BLAINEpccmax', min = '$BLAINEpccmin' WHERE nama_config = 'BLAINEpcc'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$BTLopcmax', min = '$BTLopcmin' WHERE nama_config = 'BTLopc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$MgOopcmax', min = '$MgOopcmin' WHERE nama_config = 'MgOopc'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$SO3opcmax', min = '$SO3opcmin' WHERE nama_config = 'SO3opc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$FCaOopcmax', min = '$FCaOopcmin' WHERE nama_config = 'FCaOopc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$LOIopcmax', min = '$LOIopcmin' WHERE nama_config = 'LOIopc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$ALKALIopcmax', min = '$ALKALIopcmin' WHERE nama_config = 'ALKALIopc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$z145uopcmax', min = '$z145uopcmin' WHERE nama_config = 'z145uopc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$BLAINEopcmax', min = '$BLAINEopcmin' WHERE nama_config = 'BLAINEopc'";
        mysqli_query($conn, $sql);
    }

     { $sql = "UPDATE tb_config SET max = '$BTLppcmax', min = '$BTLppcmin' WHERE nama_config = 'BTLppc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$MgOppcmax', min = '$MgOppcmin' WHERE nama_config = 'MgOppc'";
        mysqli_query($conn, $sql);
    } { $sql = "UPDATE tb_config SET max = '$SO3ppcmax', min = '$SO3ppcmin' WHERE nama_config = 'SO3ppc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$FCaOppcmax', min = '$FCaOppcmin' WHERE nama_config = 'FCaOppc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$LOIppcmax', min = '$LOIppcmin' WHERE nama_config = 'LOIppc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$ALKALIppcmax', min = '$ALKALIppcmin' WHERE nama_config = 'ALKALIppc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$z145uppcmax', min = '$z145uppcmin' WHERE nama_config = 'z145uppc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$BLAINEppcmax', min = '$BLAINEppcmin' WHERE nama_config = 'BLAINEppc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$SiO2cl_max', min = '$SiO2cl_min' WHERE nama_config = 'SiO2cl'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$Al2O3cl_max', min = '$Al2O3cl_min' WHERE nama_config = 'Al2O3cl'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$SiO2qc_max', min = '$SiO2qc_min' WHERE nama_config = 'SiO2qc'";
        mysqli_query($conn, $sql);
    }
     { $sql = "UPDATE tb_config SET max = '$Al2O3qc_max', min = '$Al2O3qc_min' WHERE nama_config = 'Al2O3qc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$CaOqc_max', min = '$CaOqc_min' WHERE nama_config = 'CaOqc'";
        mysqli_query($conn, $sql);
    }
    { $sql = "UPDATE tb_config SET max = '$ALKALIqc_max', min = '$ALKALIqc_min' WHERE nama_config = 'ALKALIqc'";
        mysqli_query($conn, $sql);
    }
}
?>


  
        <div class="row">
            <div class="col-md-6">
                <div class="card border-primary mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Setting STD Lime Stone</h5>
                    </div>
                    <div class="container">
                        <form action="" method="POST" class="mt-3">
                            <div class="form-group row">
                            <label for="H2O" class="col-sm-2 col-form-label mt-4">H2O</label>
                            <div class="col-sm-3">
                                <label for="H2Ols" class="col-form-label">Storage</label>
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Ols_max" name="H2Ols_max" placeholder="Max" value="<?= $H2Ols_max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Ols_min" name="H2Ols_min" placeholder="Min" value="<?= $H2Ols_min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label for="H2Orm" class="col-form-label">Raw Mill</label>
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Orm_max" name="H2Orm_max" placeholder="Max" value="<?= $H2Orm_max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Orm_min" name="H2Orm_min" placeholder="Min" value="<?= $H2Orm_min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label for="H2Ocm" class="col-form-label">Cement Mill</label>
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Ocm_max" name="H2Ocm_max" placeholder="Max" value="<?= $H2Ocm_max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Ocm_min" name="H2Ocm_min" placeholder="Min" value="<?= $H2Ocm_min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="SiO2" class="col-sm-2 col-form-label ">SiO2</label>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SiO2ls_max" name="SiO2ls_max" placeholder="Max" value="<?= $SiO2ls_max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SiO2ls_min" name="SiO2ls_min" placeholder="Min" value="<?= $SiO2ls_min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SiO2rm_max" name="SiO2rm_max" placeholder="Max" value="<?= $SiO2rm_max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SiO2rm_min" name="SiO2rm_min" placeholder="Min" value="<?= $SiO2rm_min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SiO2cm_max" name="SiO2cm_max" placeholder="Max" value="<?= $SiO2cm_max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SiO2cm_min" name="SiO2cm_min" placeholder="Min" value="<?= $SiO2cm_min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">Al2O3</label>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="Al2O3ls_max" name="Al2O3ls_max" placeholder="Max" value="<?= $Al2O3ls_max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="Al2O3ls_min" name="Al2O3ls_min" placeholder="Min" value="<?= $Al2O3ls_min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="Al2O3rm_max" name="Al2O3rm_max" placeholder="Max" value="<?= $Al2O3rm_max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="Al2O3rm_min" name="Al2O3rm_min" placeholder="Min" value="<?= $Al2O3rm_min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="Al2O3cm_max" name="Al2O3cm_max" placeholder="Max" value="<?= $Al2O3cm_max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="Al2O3cm_min" name="Al2O3cm_min" placeholder="Min" value="<?= $Al2O3cm_min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="CaO" class="col-sm-2 col-form-label ">CaO</label>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="CaOls_max" name="CaOls_max" placeholder="Max" value="<?= $CaOls_max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="CaOls_min" name="CaOls_min" placeholder="Min" value="<?= $CaOls_min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="CaOrm_max" name="CaOrm_max" placeholder="Max" value="<?= $CaOrm_max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="CaOrm_min" name="CaOrm_min" placeholder="Min" value="<?= $CaOrm_min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="CaOcm_max" name="CaOcm_max" placeholder="Max" value="<?= $CaOcm_max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="CaOcm_min" name="CaOcm_min" placeholder="Min" value="<?= $CaOcm_min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ALKALI" class="col-sm-2 col-form-label ">ALKALI</label>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALKALIls_max" name="ALKALIls_max" placeholder="Max" value="<?= $ALKALIls_max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALKALIls_min" name="ALKALIls_min" placeholder="Min" value="<?= $ALKALIls_min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALKALIrm_max" name="ALKALIrm_max" placeholder="Max" value="<?= $ALKALIrm_max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALKALIrm_min" name="ALKALIrm_min" placeholder="Min" value="<?= $ALKALIrm_min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALKALIcm_max" name="ALKALIcm_max" placeholder="Max" value="<?= $ALKALIcm_max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALKALIcm_min" name="ALKALIcm_min" placeholder="Min" value="<?= $ALKALIcm_min; ?>">
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
        <div class="col-md-6">
            <div class="card border-primary mb-3">
                <div class="card-header">
                    <h5 class="card-title">Setting STD Silica Stone</h5>
                </div>
                <div class="container">
                    <form action="" method="POST" class="mt-3">
                       <div class="form-group row my-0">
                            <label for="H2Oss" class="col-sm-4 col-form-label">H2O</label>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="H2Oss_max" name="H2Oss_max" placeholder="Max" value="<?= $H2Oss_max; ?>">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="H2Oss_min" name="H2Oss_min" placeholder="Min" value="<?= $H2Oss_min; ?>">
                            </div>
                        </div>
                        <div class="form-group row my-0">
                            <label for="SiO2ss" class="col-sm-4 col-form-label">SiO2</label>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="SiO2ss_max" name="SiO2ss_max" placeholder="Max" value="<?= $SiO2ss_max; ?>">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="SiO2ss_min" name="SiO2ss_min" placeholder="Min" value="<?= $SiO2ss_min; ?>">
                            </div>
                        </div>
                        <div class="form-group row my-0">
                            <label for="Al2O3ss" class="col-sm-4 col-form-label">Al2O3</label>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="Al2O3ss_max" name="Al2O3ss_max" placeholder="Max" value="<?= $Al2O3ss_max; ?>">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="Al2O3ss_min" name="Al2O3ss_min" placeholder="Min" value="<?= $Al2O3ss_min; ?>">
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
             <div class="card border-primary mb-3">
                <div class="card-header">
                    <h5 class="card-title">Setting STD Iron Sand</h5>
                </div>
                <div class="container">
                    <form action="" method="POST" class="mt-3">
                       <div class="form-group row my-0">
                            <label for="H2Ois" class="col-sm-4 col-form-label">H2O</label>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="H2Ois_max" name="H2Ois_max" placeholder="Max" value="<?= $H2Ois_max; ?>">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="H2Ois_min" name="H2Ois_min" placeholder="Min" value="<?= $H2Ois_min; ?>">
                            </div>
                        </div>
                        <div class="form-group row my-0">
                            <label for="Fe2O3is" class="col-sm-4 col-form-label">Fe2O3</label>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="Fe2O3is_max" name="Fe2O3is_max" placeholder="Max" value="<?= $Fe2O3is_max; ?>">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="Fe2O3is_min" name="Fe2O3is_min" placeholder="Min" value="<?= $Fe2O3is_min; ?>">
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


    <div class="row">
         <div class="col-md-6">
                <div class="card border-primary mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Setting STD Raw Mix</h5>
                    </div>
                    <div class="container">
                        <form action="" method="POST" class="mt-3">
                            <div class="form-group row">
                            <label for="LSF" class="col-sm-2 col-form-label mt-4">LSF</label>
                            <div class="col-sm-3">
                                <label for="LSFrm" class="col-form-label">IND 4(3a)</label>
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFrm4amax" name="LSFrm4amax" placeholder="Max" value="<?= $LSFrm4amax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFrm4amin" name="LSFrm4amin" placeholder="Min" value="<?= $LSFrm4amin; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <label for="LSFrm" class="col-form-label">IND 4(3c)</label>
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFrm4cmax" name="LSFrm4cmax" placeholder="Max" value="<?= $LSFrm4cmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFrm4cmin" name="LSFrm4cmin" placeholder="Min" value="<?= $LSFrm4cmin; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <label for="LSFrm" class="col-form-label">IND 5</label>
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFrm5max" name="LSFrm5max" placeholder="Max" value="<?= $LSFrm5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFrm5min" name="LSFrm5min" placeholder="Min" value="<?= $LSFrm5min; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3 mb-3" style="left: 85px">
                                <label for="LSFrm" class="col-form-label">IND 6</label>
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFrm6max" name="LSFrm6max" placeholder="Max" value="<?= $LSFrm6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFrm6min" name="LSFrm6min" placeholder="Min" value="<?= $LSFrm6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">SIM</label>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMrm4amax" name="SIMrm4amax" placeholder="Max" value="<?= $SIMrm4amax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMrm4amin" name="SIMrm4amin" placeholder="Min" value="<?= $SIMrm4amin; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMrm4cmax" name="SIMrm4cmax" placeholder="Max" value="<?= $SIMrm4cmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMrm4cmin" name="SIMrm4cmin" placeholder="Min" value="<?= $SIMrm4cmin; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMrm5max" name="SIMrm5max" placeholder="Max" value="<?= $SIMrm5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMrm5min" name="SIMrm5min" placeholder="Min" value="<?= $SIMrm5min; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3 mb-3" style="left: 85px">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMrm6max" name="SIMrm6max" placeholder="Max" value="<?= $SIMrm6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMrm6min" name="SIMrm6min" placeholder="Min" value="<?= $SIMrm6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">ALM</label>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMrm4amax" name="ALMrm4amax" placeholder="Max" value="<?= $ALMrm4amax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMrm4amin" name="ALMrm4amin" placeholder="Min" value="<?= $ALMrm4amin; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMrm4cmax" name="ALMrm4cmax" placeholder="Max" value="<?= $ALMrm4cmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMrm4cmin" name="ALMrm4cmin" placeholder="Min" value="<?= $ALMrm4cmin; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMrm5max" name="ALMrm5max" placeholder="Max" value="<?= $ALMrm5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMrm5min" name="ALMrm5min" placeholder="Min" value="<?= $ALMrm5min; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3 mb-3" style="left: 85px">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMrm6max" name="ALMrm6max" placeholder="Max" value="<?= $ALMrm6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMrm6min" name="ALMrm6min" placeholder="Min" value="<?= $ALMrm6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">Sieve 90</label>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="rm90u4amax" name="rm90u4amax" placeholder="Max" value="<?= $rm90u4amax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="rm90u4amin" name="rm90u4amin" placeholder="Min" value="<?= $rm90u4amin; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="rm90u4cmax" name="rm90u4cmax" placeholder="Max" value="<?= $rm90u4cmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="rm90u4cmin" name="rm90u4cmin" placeholder="Min" value="<?= $rm90u4cmin; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="rm90u5max" name="rm90u5max" placeholder="Max" value="<?= $rm90u5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="rm90u5min" name="rm90u5min" placeholder="Min" value="<?= $rm90u5min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3" style="left: 85px">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="rm90u6max" name="rm90u6max" placeholder="Max" value="<?= $rm90u6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="rm90u6min" name="rm90u6min" placeholder="Min" value="<?= $rm90u6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                       <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">Sieve 180</label>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="rm180u4amax" name="rm180u4amax" placeholder="Max" value="<?= $rm180u4amax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="rm180u4amin" name="rm180u4amin" placeholder="Min" value="<?= $rm180u4amin; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="rm180u4cmax" name="rm180u4cmax" placeholder="Max" value="<?= $rm180u4cmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="rm180u4cmin" name="rm180u4cmin" placeholder="Min" value="<?= $rm180u4cmin; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="rm180u5max" name="rm180u5max" placeholder="Max" value="<?= $rm180u5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="rm180u5min" name="rm180u5min" placeholder="Min" value="<?= $rm180u5min; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3 mb-3" style="left: 85px">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="rm180u6max" name="rm180u6max" placeholder="Max" value="<?= $rm180u6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="rm180u6min" name="rm180u6min" placeholder="Min" value="<?= $rm180u6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">H2O</label>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Orm4amax" name="H2Orm4amax" placeholder="Max" value="<?= $H2Orm4amax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Orm4amin" name="H2Orm4amin" placeholder="Min" value="<?= $H2Orm4amin; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Orm4cmax" name="H2Orm4cmax" placeholder="Max" value="<?= $H2Orm4cmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Orm4cmin" name="H2Orm4cmin" placeholder="Min" value="<?= $H2Orm4cmin; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Orm5max" name="H2Orm5max" placeholder="Max" value="<?= $H2Orm5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Orm5min" name="H2Orm5min" placeholder="Min" value="<?= $H2Orm5min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3" style="left: 85px">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Orm6max" name="H2Orm6max" placeholder="Max" value="<?= $H2Orm6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Orm6min" name="H2Orm6min" placeholder="Min" value="<?= $H2Orm6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">SD LSF</label>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDLSFrm4amax" name="SDLSFrm4amax" placeholder="Max" value="<?= $SDLSFrm4amax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDLSFrm4amin" name="SDLSFrm4amin" placeholder="Min" value="<?= $SDLSFrm4amin; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDLSFrm4cmax" name="SDLSFrm4cmax" placeholder="Max" value="<?= $SDLSFrm4cmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDLSFrm4cmin" name="SDLSFrm4cmin" placeholder="Min" value="<?= $SDLSFrm4cmin; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDLSFrm5max" name="SDLSFrm5max" placeholder="Max" value="<?= $SDLSFrm5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDLSFrm5min" name="SDLSFrm5min" placeholder="Min" value="<?= $SDLSFrm5min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 mb-2" style="left: 85px">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDLSFrm6max" name="SDLSFrm6max" placeholder="Max" value="<?= $SDLSFrm6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDLSFrm6min" name="SDLSFrm6min" placeholder="Min" value="<?= $SDLSFrm6min; ?>">
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
         <div class="col-md-6">
                <div class="card border-primary mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Setting STD Kiln Feed</h5>
                    </div>
                    <div class="container">
                        <form action="" method="POST" class="mt-3">
                            <div class="form-group row">
                            <label for="LSF" class="col-sm-2 col-form-label mt-4">LSF</label>                          
                           <div class="col-sm-3">
                                <label for="LSFrm" class="col-form-label">IND 4</label>
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFkf4max" name="LSFkf4max" placeholder="Max" value="<?= $LSFkf4max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFkf4min" name="LSFkf4min" placeholder="Min" value="<?= $LSFkf4min; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <label for="LSFrm" class="col-form-label">IND 5</label>
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFkf5max" name="LSFkf5max" placeholder="Max" value="<?= $LSFkf5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFkf5min" name="LSFkf5min" placeholder="Min" value="<?= $LSFkf5min; ?>">
                                    </div>
                                </div>
                            </div>
                              <div class="col-sm-3">
                                <label for="LSFrm" class="col-form-label">IND 6</label>
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFkf6max" name="LSFkf6max" placeholder="Max" value="<?= $LSFkf6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFkf6min" name="LSFkf6min" placeholder="Min" value="<?= $LSFkf6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">SIM</label>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMkf4max" name="SIMkf4max" placeholder="Max" value="<?= $SIMkf4max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMkf4min" name="SIMkf4min" placeholder="Min" value="<?= $SIMkf4min; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMkf5max" name="SIMkf5max" placeholder="Max" value="<?= $SIMkf5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMkf5min" name="SIMkf5min" placeholder="Min" value="<?= $SIMkf5min; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMkf6max" name="SIMkf6max" placeholder="Max" value="<?= $SIMkf6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMkf6min" name="SIMkf6min" placeholder="Min" value="<?= $SIMkf6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">ALM</label>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMkf4max" name="ALMkf4max" placeholder="Max" value="<?= $ALMkf4max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMkf4min" name="ALMkf4min" placeholder="Min" value="<?= $ALMkf4min; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMkf5max" name="ALMkf5max" placeholder="Max" value="<?= $ALMkf5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMkf5min" name="ALMkf5min" placeholder="Min" value="<?= $ALMkf5min; ?>">
                                    </div>
                                </div>
                            </div>
                              <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMkf6max" name="ALMkf6max" placeholder="Max" value="<?= $ALMkf6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMkf6min" name="ALMkf6min" placeholder="Min" value="<?= $ALMkf6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">Sieve 90</label>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="kf90u4max" name="kf90u4max" placeholder="Max" value="<?= $kf90u4max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="kf90u4min" name="kf90u4min" placeholder="Min" value="<?= $kf90u4min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="kf90u5max" name="kf90u5max" placeholder="Max" value="<?= $kf90u5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="kf90u5min" name="kf90u5min" placeholder="Min" value="<?= $kf90u5min; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="kf90u6max" name="kf90u6max" placeholder="Max" value="<?= $kf90u6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="kf90u6min" name="kf90u6min" placeholder="Min" value="<?= $kf90u6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                       <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">Sieve 180</label>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="kf180u4max" name="kf180u4max" placeholder="Max" value="<?= $kf180u4max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="kf180u4min" name="kf180u4min" placeholder="Min" value="<?= $kf180u4min; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="kf180u5max" name="kf180u5max" placeholder="Max" value="<?= $kf180u5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="kf180u5min" name="kf180u5min" placeholder="Min" value="<?= $kf180u5min; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="kf180u6max" name="kf180u6max" placeholder="Max" value="<?= $kf180u6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="kf180u6min" name="kf180u6min" placeholder="Min" value="<?= $kf180u6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">H2O</label>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Okf4max" name="H2Okf4max" placeholder="Max" value="<?= $H2Okf4max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Okf4min" name="H2Okf4min" placeholder="Min" value="<?= $H2Okf4min; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Okf5max" name="H2Okf5max" placeholder="Max" value="<?= $H2Okf5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Okf5min" name="H2Okf5min" placeholder="Min" value="<?= $H2Okf5min; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Okf6max" name="H2Okf6max" placeholder="Max" value="<?= $H2Okf6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Okf6min" name="H2Okf6min" placeholder="Min" value="<?= $H2Okf6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">SD LSF</label>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDLSFkf4max" name="SDLSFkf4max" placeholder="Max" value="<?= $SDLSFkf4max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDLSFkf4min" name="SDLSFkf4min" placeholder="Min" value="<?= $SDLSFkf4min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDLSFkf5max" name="SDLSFkf5max" placeholder="Max" value="<?= $SDLSFkf5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDLSFkf5min" name="SDLSFkf5min" placeholder="Min" value="<?= $SDLSFkf5min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDLSFkf6max" name="SDLSFkf6max" placeholder="Max" value="<?= $SDLSFkf6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDLSFkf6min" name="SDLSFkf6min" placeholder="Min" value="<?= $SDLSFkf6min; ?>">
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
            <div class="card border-primary mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Setting STD Fine Coal</h5>
                    </div>
                    <div class="container">
                        <form action="" method="POST" class="mt-3">
                            <div class="form-group row">
                            <label for="AC" class="col-sm-2 col-form-label mt-4">AC</label>
                            <div class="col-sm-3">
                                <label for="H2Ols" class="col-form-label">IND 4</label>
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ACfc4max" name="ACfc4max" placeholder="Max" value="<?= $ACfc4max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ACfc4min" name="ACfc4min" placeholder="Min" value="<?= $ACfc4min; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <label for="H2Ols" class="col-form-label">IND 5</label>
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ACfc5max" name="ACfc5max" placeholder="Max" value="<?= $ACfc5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ACfc5min" name="ACfc5min" placeholder="Min" value="<?= $ACfc5min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label for="H2Ols" class="col-form-label">IND 6</label>
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ACfc6max" name="ACfc6max" placeholder="Max" value="<?= $ACfc6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ACfc6min" name="ACfc6min" placeholder="Min" value="<?= $ACfc6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="SiO2" class="col-sm-2 col-form-label ">Sieve 90</label>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="fc90u4max" name="fc90u4max" placeholder="Max" value="<?= $fc90u4max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="fc90u4min" name="fc90u4min" placeholder="Min" value="<?= $fc90u4min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="fc90u5max" name="fc90u5max" placeholder="Max" value="<?= $fc90u5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="fc90u5min" name="fc90u5min" placeholder="Min" value="<?= $fc90u5min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="fc90u6max" name="fc90u6max" placeholder="Max" value="<?= $fc90u6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="fc90u6min" name="fc90u6min" placeholder="Min" value="<?= $fc90u6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">InMoisture</label>
                            <div class="col-sm-3">
                                <div class="row">
                                     <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Ofc4max" name="H2Ofc4max" placeholder="Max" value="<?= $H2Ofc4max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Ofc4min" name="H2Ofc4min" placeholder="Min" value="<?= $H2Ofc4min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                     <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Ofc5max" name="H2Ofc5max" placeholder="Max" value="<?= $H2Ofc5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Ofc5min" name="H2Ofc5min" placeholder="Min" value="<?= $H2Ofc5min; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <div class="row">
                                     <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Ofc6max" name="H2Ofc6max" placeholder="Max" value="<?= $H2Ofc6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="H2Ofc6min" name="H2Ofc6min" placeholder="Min" value="<?= $H2Ofc6min; ?>">
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
    <div class="row">
         <div class="col-md-6">
                <div class="card border-primary mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Setting STD SEMEN</h5>
                    </div>
                    <div class="container">
                        <form action="" method="POST" class="mt-3">
                            <div class="form-group row">
                            <label for="LSF" class="col-sm-2 col-form-label mt-4">BTL</label>                          
                           <div class="col-sm-3">
                                <label for="btl" class="col-form-label">PCC</label>
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="BTLpccmax" name="BTLpccmax" placeholder="Max" value="<?= $BTLpccmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="BTLpccmin" name="BTLpccmin" placeholder="Min" value="<?= $BTLpccmin; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <label for="LSFrm" class="col-form-label">OPC</label>
                                 <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="BTLopcmax" name="BTLopcmax" placeholder="Max" value="<?= $BTLopcmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="BTLopcmin" name="BTLopcmin" placeholder="Min" value="<?= $BTLopcmin; ?>">
                                    </div>
                                </div>
                            </div>
                              <div class="col-sm-3">
                                <label for="LSFrm" class="col-form-label">PPC</label>
                                 <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="BTLppcmax" name="BTLppcmax" placeholder="Max" value="<?= $BTLppcmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="BTLppcmin" name="BTLppcmin" placeholder="Min" value="<?= $BTLppcmin; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">MgO</label>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="MgOpccmax" name="MgOpccmax" placeholder="Max" value="<?= $MgOpccmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="MgOpccmin" name="MgOpccmin" placeholder="Min" value="<?= $MgOpccmin; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="MgOopcmax" name="MgOopcmax" placeholder="Max" value="<?= $MgOopcmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="MgOopcmin" name="MgOopcmin" placeholder="Min" value="<?= $MgOopcmin; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="MgOppcmax" name="MgOppcmax" placeholder="Max" value="<?= $MgOppcmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="MgOppcmin" name="MgOppcmin" placeholder="Min" value="<?= $MgOppcmin; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">SO3</label>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SO3pccmax" name="SO3pccmax" placeholder="Max" value="<?= $SO3pccmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SO3pccmin" name="SO3pccmin" placeholder="Min" value="<?= $SO3pccmin; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SO3opcmax" name="SO3opcmax" placeholder="Max" value="<?= $SO3opcmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SO3opcmin" name="SO3opcmin" placeholder="Min" value="<?= $SO3opcmin; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SO3ppcmax" name="SO3ppcmax" placeholder="Max" value="<?= $SO3ppcmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SO3ppcmin" name="SO3ppcmin" placeholder="Min" value="<?= $SO3ppcmin; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">FCaO</label>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="FCaOpccmax" name="FCaOpccmax" placeholder="Max" value="<?= $FCaOpccmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="FCaOpccmin" name="FCaOpccmin" placeholder="Min" value="<?= $FCaOpccmin; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="FCaOopcmax" name="FCaOopcmax" placeholder="Max" value="<?= $FCaOopcmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="FCaOopcmin" name="FCaOopcmin" placeholder="Min" value="<?= $FCaOopcmin; ?>">
                                    </div>
                                </div>
                            </div>
                          <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="FCaOppcmax" name="FCaOppcmax" placeholder="Max" value="<?= $FCaOppcmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="FCaOppcmin" name="FCaOppcmin" placeholder="Min" value="<?= $FCaOopcmin; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                       <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">LOI</label>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LOIpccmax" name="LOIpccmax" placeholder="Max" value="<?= $LOIpccmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LOIpccmin" name="LOIpccmin" placeholder="Min" value="<?= $LOIpccmin; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LOIopcmax" name="LOIopcmax" placeholder="Max" value="<?= $LOIopcmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LOIopcmin" name="LOIopcmin" placeholder="Min" value="<?= $LOIopcmin; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LOIppcmax" name="LOIppcmax" placeholder="Max" value="<?= $LOIppcmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LOIppcmin" name="LOIppcmin" placeholder="Min" value="<?= $LOIppcmin; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">ALKALI</label>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALKALIpccmax" name="ALKALIpccmax" placeholder="Max" value="<?= $ALKALIpccmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALKALIpccmin" name="ALKALIpccmin" placeholder="Min" value="<?= $ALKALIcr4min; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALKALIopcmax" name="ALKALIopcmax" placeholder="Max" value="<?= $ALKALIopcmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALKALIopcmin" name="ALKALIopcmin" placeholder="Min" value="<?= $ALKALIcr4min; ?>">
                                    </div>
                                </div>
                            </div>
                              <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALKALIppcmax" name="ALKALIppcmax" placeholder="Max" value="<?= $ALKALIppcmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALKALIppcmin" name="ALKALIppcmin" placeholder="Min" value="<?= $ALKALIcr4min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">Sieve 45</label>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="z145upccmax" name="z145upccmax" placeholder="Max" value="<?= $z145upccmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="z145upccmin" name="z145upccmin" placeholder="Min" value="<?= $z145upccmin; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="z145uopcmax" name="z145uopcmax" placeholder="Max" value="<?= $z145uopcmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="z145uopcmin" name="z145uopcmin" placeholder="Min" value="<?= $z145uopcmin; ?>">
                                    </div>
                                </div>
                            </div>
                              <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="z145uppcmax" name="z145uppcmax" placeholder="Max" value="<?= $z145uppcmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="z145uppcmin" name="z145uppcmin" placeholder="Min" value="<?= $z145uppcmin; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">BLAINE</label>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="BLAINEpccmax" name="BLAINEpccmax" placeholder="Max" value="<?= $BLAINEpccmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="BLAINEpccmin" name="BLAINEpccmin" placeholder="Min" value="<?= $BLAINEpccmin; ?>">
                                    </div>
                                </div>
                            </div>
                              <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="BLAINEopcmax" name="BLAINEopcmax" placeholder="Max" value="<?= $BLAINEopcmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="BLAINEopcmin" name="BLAINEopcmin" placeholder="Min" value="<?= $BLAINEopcmin; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="BLAINEppcmax" name="BLAINEppcmax" placeholder="Max" value="<?= $BLAINEppcmax; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="BLAINEppcmin" name="BLAINEppcmin" placeholder="Min" value="<?= $BLAINEppcmin; ?>">
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
         <div class="col-md-6">
                <div class="card border-primary mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Setting STD CLINKER</h5>
                    </div>
                    <div class="container">
                        <form action="" method="POST" class="mt-3">
                            <div class="form-group row">
                            <label for="LSF" class="col-sm-2 col-form-label mt-4">FCaO</label>                          
                           <div class="col-sm-3">
                                <label for="LSFrm" class="col-form-label">IND 4</label>
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="FCaOcr4max" name="FCaOcr4max" placeholder="Max" value="<?= $FCaOcr4max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="FCaOcr4min" name="FCaOcr4min" placeholder="Min" value="<?= $FCaOcr4min; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <label for="LSFrm" class="col-form-label">IND 5</label>
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="FCaOcr5max" name="FCaOcr5max" placeholder="Max" value="<?= $FCaOcr5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="FCaOcr5min" name="FCaOcr5min" placeholder="Min" value="<?= $FCaOcr5min; ?>">
                                    </div>
                                </div>
                            </div>
                              <div class="col-sm-3">
                                <label for="LSFrm" class="col-form-label">IND 6</label>
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="FCaOcr6max" name="FCaOcr6max" placeholder="Max" value="<?= $FCaOcr6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="FCaOcr6min" name="FCaOcr6min" placeholder="Min" value="<?= $FCaOcr6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">LSF</label>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFcr4max" name="LSFcr4max" placeholder="Max" value="<?= $LSFcr4max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFcr4min" name="LSFcr4min" placeholder="Min" value="<?= $LSFcr4min; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFcr5max" name="LSFcr5max" placeholder="Max" value="<?= $LSFcr5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFcr5min" name="LSFcr5min" placeholder="Min" value="<?= $LSFcr5min; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFcr6max" name="LSFcr6max" placeholder="Max" value="<?= $LSFcr6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="LSFcr6min" name="LSFcr6min" placeholder="Min" value="<?= $LSFcr6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">SIM</label>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMcr4max" name="SIMcr4max" placeholder="Max" value="<?= $SIMcr4max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMcr4min" name="SIMcr4min" placeholder="Min" value="<?= $SIMcr4min; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMcr5max" name="SIMcr5max" placeholder="Max" value="<?= $SIMcr5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMcr5min" name="SIMcr5min" placeholder="Min" value="<?= $SIMcr5min; ?>">
                                    </div>
                                </div>
                            </div>
                              <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMcr6max" name="SIMcr6max" placeholder="Max" value="<?= $SIMcr6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SIMcr6min" name="SIMcr6min" placeholder="Min" value="<?= $SIMcr6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">ALM</label>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMcr4max" name="ALMcr4max" placeholder="Max" value="<?= $ALMcr4max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMcr4min" name="ALMcr4min" placeholder="Min" value="<?= $ALMcr4min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMcr5max" name="ALMcr5max" placeholder="Max" value="<?= $ALMcr5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMcr5min" name="ALMcr5min" placeholder="Min" value="<?= $ALMcr5min; ?>">
                                    </div>
                                </div>
                            </div>
                          <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMcr6max" name="ALMcr6max" placeholder="Max" value="<?= $ALMcr6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALMcr6min" name="ALMcr6min" placeholder="Min" value="<?= $ALMcr6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                       <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">C3S</label>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="C3Scr4max" name="C3Scr4max" placeholder="Max" value="<?= $C3Scr4max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="C3Scr4min" name="C3Scr4min" placeholder="Min" value="<?= $C3Scr4min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="C3Scr5max" name="C3Scr5max" placeholder="Max" value="<?= $C3Scr5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="C3Scr5min" name="C3Scr5min" placeholder="Min" value="<?= $C3Scr5min; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="C3Scr6max" name="C3Scr6max" placeholder="Max" value="<?= $C3Scr6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="C3Scr6min" name="C3Scr6min" placeholder="Min" value="<?= $C3Scr6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">C3A</label>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="C3Acr4max" name="C3Acr4max" placeholder="Max" value="<?= $C3Acr4max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="C3Acr4min" name="C3Acr4min" placeholder="Min" value="<?= $C3Acr4min; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="C3Acr5max" name="C3Acr5max" placeholder="Max" value="<?= $C3Acr5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="C3Acr5min" name="C3Acr5min" placeholder="Min" value="<?= $C3Acr5min; ?>">
                                    </div>
                                </div>
                            </div>
                              <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="C3Acr6max" name="C3Acr6max" placeholder="Max" value="<?= $C3Acr6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="C3Acr6min" name="C3Acr6min" placeholder="Min" value="<?= $C3Acr6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">SD C3S</label>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDC3Scr4max" name="SDC3Scr4max" placeholder="Max" value="<?= $SDC3Scr4max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDC3Scr4min" name="SDC3Scr4min" placeholder="Min" value="<?= $SDC3Scr4min; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDC3Scr5max" name="SDC3Scr5max" placeholder="Max" value="<?= $SDC3Scr5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDC3Scr5min" name="SDC3Scr5min" placeholder="Min" value="<?= $SDC3Scr5min; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDC3Scr6max" name="SDC3Scr6max" placeholder="Max" value="<?= $SDC3Scr6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="SDC3Scr6min" name="SDC3Scr6min" placeholder="Min" value="<?= $SDC3Scr6min; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="Al2O3" class="col-sm-2 col-form-label ">ALKALI</label>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALKALIcr4max" name="ALKALIcr4max" placeholder="Max" value="<?= $ALKALIcr4max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALKALIcr4min" name="ALKALIcr4min" placeholder="Min" value="<?= $ALKALIcr4min; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALKALIcr5max" name="ALKALIcr5max" placeholder="Max" value="<?= $ALKALIcr5max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALKALIcr5min" name="ALKALIcr5min" placeholder="Min" value="<?= $ALKALIcr5min; ?>">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-6 ">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALKALIcr6max" name="ALKALIcr6max" placeholder="Max" value="<?= $ALKALIcr6max; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" style="height:30px; width: 150%;" class="form-control" id="ALKALIcr6min" name="ALKALIcr6min" placeholder="Min" value="<?= $ALKALIcr6min; ?>">
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
    <div class="row">
        <div class="col-md-6">
            <div class="card border-primary mb-3">
                <div class="card-header">
                    <h5 class="card-title">Setting STD CLAY</h5>
                </div>
                <div class="container">
                    <form action="" method="POST" class="mt-3">
                        <div class="form-group row my-0">
                            <label for="SiO2ss" class="col-sm-4 col-form-label">SiO2</label>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="SiO2cl_max" name="SiO2cl_max" placeholder="Max" value="<?= $SiO2cl_max; ?>">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="SiO2cl_min" name="SiO2cl_min" placeholder="Min" value="<?= $SiO2cl_min; ?>">
                            </div>
                        </div>
                        <div class="form-group row my-0">
                            <label for="Al2O3ss" class="col-sm-4 col-form-label">Al2O3</label>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="Al2O3cl_max" name="Al2O3cl_max" placeholder="Max" value="<?= $Al2O3cl_max; ?>">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="Al2O3cl_min" name="Al2O3cl_min" placeholder="Min" value="<?= $Al2O3cl_min; ?>">
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
                    <h5 class="card-title">Setting LimeStone QC Tambang</h5>
                </div>
                <div class="container">
                    <form action="" method="POST" class="mt-3">
                        <div class="form-group row my-0">
                            <label for="SiO2ss" class="col-sm-4 col-form-label">Si</label>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="SiO2qc_max" name="SiO2qc_max" placeholder="Max" value="<?= $SiO2qc_max; ?>">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="SiO2qc_min" name="SiO2qc_min" placeholder="Min" value="<?= $SiO2qc_min; ?>">
                            </div>
                        </div>
                        <div class="form-group row my-0">
                            <label for="Al2O3ss" class="col-sm-4 col-form-label">Al</label>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="Al2O3qc_max" name="Al2O3qc_max" placeholder="Max" value="<?= $Al2O3qc_max; ?>">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="Al2O3qc_min" name="Al2O3qc_min" placeholder="Min" value="<?= $Al2O3qc_min; ?>">
                            </div>
                        </div>
                        <div class="form-group row my-0">
                            <label for="Al2O3ss" class="col-sm-4 col-form-label">CaO</label>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="CaOqc_max" name="CaOqc_max" placeholder="Max" value="<?= $CaOqc_max; ?>">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="CaOqc_min" name="CaOqc_min" placeholder="Min" value="<?= $CaOqc_min; ?>">
                            </div>
                        </div>
                         <div class="form-group row my-0">
                            <label for="Al2O3ss" class="col-sm-4 col-form-label">Alkali</label>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="ALKALIqc_max" name="ALKALIqc_max" placeholder="Max" value="<?= $ALKALIqc_max; ?>">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" style="height:30px" class="form-control" id="ALKALIqc_min" name="ALKALIqc_min" placeholder="Min" value="<?= $ALKALIqc_min; ?>">
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
