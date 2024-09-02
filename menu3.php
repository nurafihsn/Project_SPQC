<?php
session_start();
$level = strtoupper($_SESSION['level']);
if ($level == NULL) echo "<script>window.location = 'index.php'</script>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="css/jquery.min.js"></script>
	<script type="text/javascript" src="css/ddaccordion.js"></script>
	<script type="text/javascript">
		ddaccordion.init({
			headerclass: "submenuheader", //Shared CSS class name of headers group
			contentclass: "submenu", //Shared CSS class name of contents group
			revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
			mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
			collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
			defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
			onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
			animatedefault: false, //Should contents open by default be animated into view?
			persiststate: true, //persist state of opened contents within browser session?
			toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
			togglehtml: ["suffix", "<img src='images/plus.gif' class='statusicon' />", "<img src='images/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
			animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
			oninit: function(headers, expandedindices) { //custom code to run when headers have initalized
				//do nothing
			},
			onopenclose: function(header, index, state, isuseractivated) { //custom code to run whenever a header is opened or closed
				//do nothing
			}
		})
	</script>
</head>

<body>
	<div class="left_content">
		<div class="sidebarmenu">
			<a class="menuitem_green" href="laporan/halaman_depan.php" target="isi">Dashboard</a>
			<a class="menuitem_green" href="laporan/laporan_harian.php" target="isi">Laporan Harian</a>
			<a class="menuitem_green submenuheader" href="">Data Inputan</a>
			<div class="submenu">
				<ul>
					<li><a href="laporan/data_inputan.php" target="isi">Input Data</a></li>
					<li><a href="master/setting.php" target="isi">Setting Konstanta</a></li>
					<li><a href="master/setting_target.php" target="isi">Setting Standar</a></li>
				</ul>
			</div>	
			<a class="menuitem_green submenuheader" href="">Rekap Data</a>
			<div class="submenu">
				<ul>
					<li><a href="laporan/rekap.php" target="isi">Rekap Data</a></li>
					<li><a href="laporan/rekap/generate_lhk6.php" target="isi">Generate LHK</a></li>
				</ul>
			</div>
			 <a class="menuitem_green submenuheader" href="">Backup/Rekap Data</a>
            <div class="submenu">
                <ul>
                    <li><a href="laporan/rekap/generate_lhk6.php" target="isi">Indarung 6</a></li>
                    <li><a href="laporan/laporan_harian/indarung_5.php" target="isi">Indarung 5</a></li>
                    <li><a href="laporan/laporan_harian/indarung_4.php" target="isi">Indarung 4</a></li>
                    <li><a href="laporan/laporan_harian/indarung_3.php" target="isi">Indarung 2&3</a></li>
                </ul>
            </div>	
			<a class="menuitem_green submenuheader" href="">Account User </a>
			<div class="submenu">
				<ul>
					<li><a href="master/browse-users.php" target="isi">Browse User</a></li>
					<li><a href="master/ubah_pass.php" target="isi">Ubah Password</a></li>
				</ul>
			</div>

			<a class="menuitem_red" href="index.php?act=logout" target="_parent">Logout</a>
		</div>
	</div>
</body>

</html>