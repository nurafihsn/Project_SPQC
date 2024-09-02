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
<title>Data Inputan</title>
</head>
<body>
        <center style=" font-size: 24px; font-weight: bold; color: #333333; ">
            <label>Data Inputan</label>
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
        <label for="filterB">AREA :</label>
        <select id="filterB">
            <option value="">Pilih Area</option>
            <option class="submenu1" value="lstg3">LSTG</option>
            <option class="submenu1" value="lststg3">LSTSTG</option>
            <option class="submenu1" value="lscm3">LSCM</option>
            <option class="submenu1" value="ls3">LS</option>
            <option class="submenu1" value="lst3">LST</option>
            <option class="submenu1" value="cl3">CL</option>
            <option class="submenu1" value="is3">IS</option>
            <option class="submenu1" value="fc3">FC</option>
            <option class="submenu1" value="r13">R1</option>
            <option class="submenu1" value="r23">R2</option>
            <option class="submenu1" value="kf13">KF1</option>
            <option class="submenu1" value="kf23">KF2</option>
            <option class="submenu1" value="cr13">CR W1</option>
            <option class="submenu1" value="cr23">CR W2</option>
            <option class="submenu1" value="z13">Z1</option>
            <option class="submenu1" value="z23">Z2</option>
            <option class="submenu1" value="crf3">CRF</option>
            <option class="submenu1" value="ep3">EP</option>
            <option class="submenu2" value="lstg4">LSTG</option>
            <option class="submenu2" value="ssstg4">SSSTG</option>
            <option class="submenu2" value="lscm4">LSCM</option>
            <option class="submenu2" value="ls4">LS</option>
            <option class="submenu2" value="ss4">SS</option>
            <option class="submenu2" value="cl4">CL</option>
            <option class="submenu2" value="is4">IS</option>
            <option class="submenu2" value="ep4">EP</option>
            <option class="submenu2" value="fc4">FC</option>
            <option class="submenu2" value="r14">R1</option>
            <option class="submenu2" value="r24">R2</option>
            <option class="submenu2" value="kf4">KF</option>
            <option class="submenu2" value="cr4">CR</option>
            <option class="submenu2" value="z14">Z1</option>
            <option class="submenu2" value="z24">Z2</option>
            <option class="submenu2" value="crf4">CRF</option>
            <option class="submenu3" value="lstg5">LSTG</option>
            <option class="submenu3" value="lcstg5">LCSTG</option>
            <option class="submenu3" value="clstg5">CLSTG</option>
            <option class="submenu3" value="sstg5">SSTG</option>
            <option class="submenu3" value="lscm5">LSCM</option>
            <option class="submenu3" value="ls5">LS</option>
            <option class="submenu3" value="ss5">SS</option>
            <option class="submenu3" value="cl5">CL</option>
            <option class="submenu3" value="is5">IS</option>
            <option class="submenu3" value="fc5">FC</option>
            <option class="submenu3" value="r15">R1</option>
            <option class="submenu3" value="r25">R2</option>
            <option class="submenu3" value="kf5">KF</option>
            <option class="submenu3" value="cr5">CR</option>
            <option class="submenu3" value="z15">Z1</option>
            <option class="submenu3" value="z25">Z2</option>
            <option class="submenu3" value="crf5">CRF</option>
            <option class="submenu3" value="ep5">EP</option>
            <option class="submenu3" value="avglstg5">AVG LSTG</option>
            <option class="submenu4" value="lstg6">LSTG</option>
            <option class="submenu4" value="lcmstg6">LCMSTG</option>
            <option class="submenu4" value="sstg6">SSTG</option>
            <option class="submenu4" value="lscm6">LSCM</option>
            <option class="submenu4" value="ls6">LS</option>
            <option class="submenu4" value="ss6">SS</option>
            <option class="submenu4" value="cl6">CL</option>
            <option class="submenu4" value="is6">IS</option>
            <option class="submenu4" value="bhf6">BHF</option>
            <option class="submenu4" value="fc6">FC</option>
            <option class="submenu4" value="r16">R1</option>
            <option class="submenu4" value="kf6">KF</option>
            <option class="submenu4" value="cr6">CR</option>
            <option class="submenu4" value="z16">Z1</option>
            <option class="submenu4" value="crf6">CRF</option>
            <option class="submenu4" value="avglstg6">AVG LSTG</option>
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

    if (selectedOption === "Indarung 2&3" && selectedSubmenu === "lstg3") {
        window.location.href = "indarung_2&3/lstg.php";
    }  else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "lststg3") {
        window.location.href = "indarung_2&3/lststg.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "lscm3") {
        window.location.href = "indarung_2&3/lscm.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "ls3") {
        window.location.href = "indarung_2&3/ls.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "lst3") {
        window.location.href = "indarung_2&3/lst.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "cl3") {
        window.location.href = "indarung_2&3/cl.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "is3") {
        window.location.href = "indarung_2&3/is.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "ep3") {
        window.location.href = "indarung_2&3/ep.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "fc3") {
        window.location.href = "indarung_2&3/fc.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "r13") {
        window.location.href = "indarung_2&3/r1.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "r23") {
        window.location.href = "indarung_2&3/r2.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "kf13") {
        window.location.href = "indarung_2&3/kf1.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "kf23") {
        window.location.href = "indarung_2&3/kf2.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "cr13") {
        window.location.href = "indarung_2&3/cr1.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "cr23") {
        window.location.href = "indarung_2&3/cr2.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "z13") {
        window.location.href = "indarung_2&3/z1.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "z23") {
        window.location.href = "indarung_2&3/z2.php";
    } else if (selectedOption === "Indarung 2&3" && selectedSubmenu === "crf3") {
        window.location.href = "indarung_2&3/crf.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "lstg4") {
        window.location.href = "indarung_4/lstg.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "ep4") {
        window.location.href = "indarung_4/ep.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "ssstg4") {
        window.location.href = "indarung_4/ssstg.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "lscm4") {
        window.location.href = "indarung_4/lscm.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "ls4") {
        window.location.href = "indarung_4/ls.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "ss4") {
        window.location.href = "indarung_4/ss.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "cl4") {
        window.location.href = "indarung_4/cl.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "is4") {
        window.location.href = "indarung_4/is.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "fc4") {
        window.location.href = "indarung_4/fc.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "r14") {
        window.location.href = "indarung_4/r1.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "r24") {
        window.location.href = "indarung_4/r2.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "kf4") {
        window.location.href = "indarung_4/kf.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "cr4") {
        window.location.href = "indarung_4/cr.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "z14") {
        window.location.href = "indarung_4/z1.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "z24") {
        window.location.href = "indarung_4/z2.php";
    } else if (selectedOption === "Indarung 4" && selectedSubmenu === "crf4") {
        window.location.href = "indarung_4/crf.php";
    }  else if (selectedOption === "Indarung 5" && selectedSubmenu === "lstg5") {
        window.location.href = "indarung_5/lstg.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "lcstg5") {
        window.location.href = "indarung_5/lcstg.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "clstg5") {
        window.location.href = "indarung_5/clstg.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "sstg5") {
        window.location.href = "indarung_5/sstg.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "lscm5") {
        window.location.href = "indarung_5/lscm.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "ls5") {
        window.location.href = "indarung_5/ls.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "ss5") {
        window.location.href = "indarung_5/ss.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "cl5") {
        window.location.href = "indarung_5/cl.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "is5") {
        window.location.href = "indarung_5/is.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "fc5") {
        window.location.href = "indarung_5/fc.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "r15") {
        window.location.href = "indarung_5/r1.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "r25") {
        window.location.href = "indarung_5/r2.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "kf5") {
        window.location.href = "indarung_5/kf.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "cr5") {
        window.location.href = "indarung_5/cr.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "z15") {
        window.location.href = "indarung_5/z1.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "z25") {
        window.location.href = "indarung_5/z2.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "crf5") {
        window.location.href = "indarung_5/crf.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "ep5") {
        window.location.href = "indarung_5/ep.php";
    } else if (selectedOption === "Indarung 5" && selectedSubmenu === "avglstg5") {
        window.location.href = "indarung_5/avglstg.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "lstg6") {
        window.location.href = "indarung_6/lstg.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "lcmstg6") {
        window.location.href = "indarung_6/lcmstg.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "sstg6") {
        window.location.href = "indarung_6/sstg.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "lscm6") {
        window.location.href = "indarung_6/lscm.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "ls6") {
        window.location.href = "indarung_6/ls.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "ss6") {
        window.location.href = "indarung_6/ss.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "cl6") {
        window.location.href = "indarung_6/cl.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "is6") {
        window.location.href = "indarung_6/is.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "bhf6") {
        window.location.href = "indarung_6/bhf.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "fc6") {
        window.location.href = "indarung_6/fc.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "r16") {
        window.location.href = "indarung_6/r1.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "kf6") {
        window.location.href = "indarung_6/kf.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "cr6") {
        window.location.href = "indarung_6/cr.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "z16") {
        window.location.href = "indarung_6/z1.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "crf6") {
        window.location.href = "indarung_6/crf.php";
    } else if (selectedOption === "Indarung 6" && selectedSubmenu === "avglstg6") {
        window.location.href = "indarung_6/avglstg.php";
    }
    
}
document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("filterB").style.display = "none";
        hideSubMenuOptions("submenu1", "submenu2", "submenu3", "submenu4");
    });
</script>

</body>
</html>
