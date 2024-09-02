<?php
session_start();
$level = strtoupper($_SESSION['level']);
if ($level == NULL) echo "<script>window.location = '../index.php'</script>";

?>

  
<!DOCTYPE html>
<html lang="en">
<head>
      <title></title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
      <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

      <style>
        .form-select {
            max-width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-top: 30px
        }
        .mb-3 {
            margin-bottom: 15px; 
        }
    </style>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <center style=" font-size: 24px; font-weight: bold; color: #333333; ">
            <label>Rekap Data</label>
        </center>

<form action="" method="get" class="form-select" aria-label="Default select example"> 
    <div class="mb-3">
        <label for="filterA" class="form-label">UNIT:</label>
        <select id="filterA" onchange="showSubmenu()">
            <option value="">Pilih Unit</option>
            <option value="Indarung 2&3">Indarung 2&3</option>
            <option value="Indarung 4">Indarung 4</option>
            <option value="Indarung 5">Indarung 5</option>
            <option value="Indarung 6">Indarung 6</option>
        </select>
    </div>
    <div class="mb-3 form-label">
        <label for="filterB">Area :</label>
        <select id="filterB">
            <option value="">Pilih Area</option>
            <option class="submenu1" value="lhk3">LHK</option>
            <option class="submenu1" value="lpb3">LPB</option>
            <option class="submenu1" value="qaf3">QAF</option>
            <option class="submenu1" value="qisi3">QISI</option>
            <option class="submenu1" value="jurnal3">Jurnal Harian</option>
            <option class="submenu1" value="faktor3">Faktor Clinker</option>
            <option class="submenu2" value="lhk4">LHK</option>
            <option class="submenu2" value="lpb4">LPB</option>
            <option class="submenu2" value="qaf4">QAF</option>
            <option class="submenu2" value="qisi4">QISI</option>
            <option class="submenu2" value="jurnal4">Jurnal Harian</option>
            <option class="submenu2" value="faktor4">Faktor Clinker</option>
            <option class="submenu3" value="lhk5">LHK</option>
            <option class="submenu3" value="lpb5">LPB</option>
            <option class="submenu3" value="qaf5">QAF</option>
            <option class="submenu3" value="qisi5">QISI</option>
            <option class="submenu3" value="jurnal5">Jurnal Harian</option>
            <option class="submenu3" value="faktor5">Faktor Clinker</option>
            <option class="submenu4" value="lhk6">LHK</option>
            <option class="submenu4" value="lpb6">LPB</option>
            <option class="submenu4" value="qaf6">QAF</option>
            <option class="submenu4" value="qisi6">QISI</option>
            <option class="submenu4" value="jurnal6">Jurnal Harian</option>
            <option class="submenu4" value="faktor6">Faktor Clinker</option>
        </select>
    </div>

    <button type="button" class="btn btn-primary pl-4 pr-4" onclick="redirectToPage()">Pilih</button>
</form>


<script>
 function showSubmenu() {
        var selectedOption = document.getElementById("filterA").value;
        var filterB = document.getElementById("filterB");

        if (selectedOption === "") {
            filterB.style.display = "none";
            hideSubMenuOptions("submenu1", "submenu2", "submenu3", "submenu4");
        } else {
            filterB.style.display = "block";
            if (selectedOption === "Indarung 2&3") {
                showSubMenuOptions("submenu1");
                hideSubMenuOptions("submenu2", "submenu3", "submenu4");
            } else if (selectedOption === "Indarung 4") {
                showSubMenuOptions("submenu2");
                hideSubMenuOptions("submenu1", "submenu3", "submenu4");
            } else if (selectedOption === "Indarung 5") {
                showSubMenuOptions("submenu3");
                hideSubMenuOptions("submenu1", "submenu2", "submenu4");
            } else if (selectedOption === "Indarung 6") {
                showSubMenuOptions("submenu4");
                hideSubMenuOptions("submenu1", "submenu2", "submenu3");
            }
        }
    }

    function showSubMenuOptions(className) {
        var options = document.getElementsByClassName(className);
        for (var i = 0; i < options.length; i++) {
            options[i].style.display = "block";
        }
    }

    function hideSubMenuOptions() {
        for (var i = 0; i < arguments.length; i++) {
            var options = document.getElementsByClassName(arguments[i]);
            for (var j = 0; j < options.length; j++) {
                options[j].style.display = "none";
            }
        }
    }

    function redirectToPage() {
        var selectedOption = document.getElementById("filterA").value;
        var selectedSubmenu = document.getElementById("filterB").value;

    // Mengarahkan pengguna ke halaman yang sesuai berdasarkan pilihan
    if (selectedOption === "Indarung 2&3" && selectedSubmenu === "lhk3") {
        window.location.href = "rekap/lhk_3.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "lpb3") {
        window.location.href = "rekap/lpb_3.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "qisi3") {
        window.location.href = "rekap/qisi_3.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "jurnal3") {
        window.location.href = "rekap/jurnal_3.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "faktor3") {
        window.location.href = "rekap/faktor_3.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "qaf3") {
        window.location.href = "rekap/qaf_3.php";
    }  else if (selectedOption === "Indarung 4" && selectedSubmenu === "lhk4") {
        window.location.href = "rekap/lhk_4.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "lpb4") {
        window.location.href = "rekap/lpb_4.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "qaf4") {
        window.location.href = "rekap/qaf_4.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "jurnal4") {
        window.location.href = "rekap/jurnal_4.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "faktor4") {
        window.location.href = "rekap/faktor_4.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "qisi4") {
        window.location.href = "rekap/qisi_4.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "lhk5") {
        window.location.href = "rekap/lhk_5.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "lpb5") {
        window.location.href = "rekap/lpb_5.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "qaf5") {
        window.location.href = "rekap/qaf_5.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "jurnal5") {
        window.location.href = "rekap/jurnal_5.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "faktor5") {
        window.location.href = "rekap/faktor_5.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "qisi5") {
        window.location.href = "rekap/qisi_5.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "lhk6") {
        window.location.href = "rekap/lhk_6.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "lpb6") {
        window.location.href = "rekap/lpb_6.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "qaf6") {
        window.location.href = "rekap/qaf_6.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "jurnal6") {
        window.location.href = "rekap/jurnal_6.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "faktor6") {
        window.location.href = "rekap/faktor_6.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "qisi6") {
        window.location.href = "rekap/qisi_6.php";
    }
}
document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("filterB").style.display = "none";
        hideSubMenuOptions("submenu1", "submenu2", "submenu3", "submenu4");
    });
</script>

</body>
</html>
