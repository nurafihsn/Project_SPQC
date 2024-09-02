<?php
@session_start();

if ($_SESSION['level'] == "1") $menu = "menu1.php";
else
if ($_SESSION['level'] == "2") $menu = "menu2.php";
else
if ($_SESSION['level'] == "3") $menu = "menu3.php";
else
if ($_SESSION['level'] == "4") $menu = "menu4.php";
else
  header("Location: index.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>QC Semen Padang</title>
</head>
<frameset rows="145,*" cols="*" frameborder="no" border="0" framespacing="0">
  <frame src="header.php" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="topFrame" />
  <frameset cols="230,*" frameborder="no" border="0" framespacing="0">
    <frame src="<?= $menu; ?>" name="leftFrame" id="leftFrame" title="leftFrame" />
    <frame src="laporan/halaman_depan.php" name="isi" id="isi" scrolling="Yes" title="isi" />
  </frameset>
</frameset>
<noframes>
</noframes>

</html>