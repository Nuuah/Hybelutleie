<?php
require_once("../inc/sessioncheck.inc.php");
require_once("../inc/db.inc.php");
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>Rediger Annonser</title>
        <link rel="stylesheet" href="../css/design1/site/css/white.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
    
    <!-- Menybaren -->
    <div class="menybar">
        <a href="#news">Ny annonse</a>
        <a href="Utleierside.php">Min side</a>
        <a href="Hovedside.php">Hjem</a>
        <a href="../inc/loggut.inc.php">Logg ut</a>
    </div>

  <h1> Rediger Annonser </h1><br>

<?php

if($_SESSION['utleier'] == 1):

$sql = "SELECT boligtype.boligtype, bruker.epost, bolig.manedsleie, bolig.leieperiode, bolig.ledig_fra, bolig.areal, bolig.antall_rom, bolig.ledige_rom, bolig.bolig_beskrivelse,
        bolig.antall_bad, bolig.antall_balkonger, bolig.antall_soverom, bolig.er_moblert, bolig.har_hvitevarer,
        bolig.bilde, bolig.dyr_tillat, bolig.royk_tillat, bolig.har_hage, bolig.antall_parkeringsplasser, bolig.postkode, bolig.adresse
        FROM boligtype, bruker, bolig 
            WHERE bolig.boligtype_id = boligtype.boligtype_id 
            AND bruker.epost = :epost
            AND bolig.bolig_id = :bolig_id
                ORDER BY bolig_id";

    $q = $pdo->prepare($sql);

    $q->bindParam(':epost', $epost, PDO::PARAM_STR);
    $q->bindParam(':bolig_id', $bolig_id, PDO::PARAM_INT);

$epost = $_SESSION['epost'];
$bolig_id = $_GET['id'];

try {
    $q->execute();
} catch (PDOException $e) {
    echo "Error querying database: " . $e->getMessage() . "<br>"; // Never do this in production
}
$annonse = $q->fetch(PDO::FETCH_ASSOC);

?>

<h3>Bolig opplysninger</h3>

<form method="POST" action="" enctype="multipart/form-data">
<div class="container">
<div class="form-row">
    <div class="dropdown">
        <label for="boligtype">Boligtype</label><br>
        <select name="boligtype" id="boligtype">
            <option value='<?php echo $annonse['boligtype']; ?>' selected='selected'> <?php echo $annonse['boligtype']?></option>
            <option value="Hybel">Hybel</option>
            <option value="Jentekollektiv">Jentekollektiv</option>
            <option value="Guttekollektiv">Guttekollektiv</option>
            <option value="Kollektiv">Kollektiv</option>
            <option value="Leilighet">Leilighet</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label for="areal">Areal</label>
        <input type="number" class="form-control" name="areal" id="areal" value="<?php echo $annonse['areal']; ?>" required> 
    </div>
    <div class="col-md-4 mb-3">
        <label for="manedsleie">Månedsleie</label>
        <input type="text" class="form-control" name="manedsleie" id="manedsleie" value="<?php echo $annonse['manedsleie']; ?>" required> 
    </div>
</div>

<div class="form-row">
    <div class="col-md5 mb-3">
        <label for="leieperiode">Leieperiode</label>
        <input type="text" class="form-control" name="leieperiode" id="leieperiode" value="<?php echo $annonse['leieperiode']; ?>" required> 
    </div>
    <div class="col-md5 mb-3">
        <label for="ledig_fra">Bolig ledig fra</label>
        <input type="date" class="form-control"  name="ledig_fra" id="ledig_fra" value="<?php echo $annonse['ledig_fra']; ?>" required> 
    </div>
</div>

<div class="form-row">
    <div class="col-sm-2">
        <label for="antall_rom">Antall rom</label>
        <input type="number" class="form-control"  name="antall_rom" id="antall_rom" value="<?php echo $annonse['antall_rom']; ?>" required>
    </div>
    <div class="col-sm-2">
        <label for="ledige_rom">Ledige rom</label>
        <input type="number" class="form-control"  name="ledige_rom" id="ledige_rom" value="<?php echo $annonse['ledige_rom']; ?>">
    </div>
    <div class="col-sm-2">
        <label for="antall_bad">Antall bad</label>
        <input type="number" class="form-control"  name="antall_bad" id="antall_bad" value="<?php echo $annonse['antall_bad']; ?>" required>
    </div>
    <div class="col-sm-2">
        <label for="antall_balkonger">Antall balkonger</label>
        <input type="number" class="form-control"  name="antall_balkonger" id="antall_balkonger" value="<?php echo $annonse['antall_balkonger']; ?>"> 
    </div>
    <div class="col-sm-2">
        <label for="antall_soverom">Antall soverom</label>
        <input type="number" class="form-control" name="antall_soverom" id="antall_soverom" value="<?php echo $annonse['antall_soverom']; ?>" required>
    </div>
</div>
<br>

<div class="form-row">
    <div class="col-sm-2">
        <label for="er_moblert">Møblert bolig?</label>
        <input type="number" class="form-control"  name="er_moblert" id="er_moblert" min="0" max="1" value="<?php echo $annonse['er_moblert']; ?>" required>
    </div>
    <div class="col-sm-2">
        <label for="har_hvitevarer">Hvitevarer?</label>
        <input type="number" class="form-control"  name="har_hvitevarer" id="har_hvitevarer" min="0" max="1" value="<?php echo $annonse['har_hvitevarer']; ?>" required>
    </div>
    <div class="col-sm-2">
        <label for="dyr_tillat">Dyr tillat?</label>
        <input type="number" class="form-control"  name="dyr_tillat" id="dyr_tillat" min="0" max="1" value="<?php echo $annonse['dyr_tillat']; ?>" required>
    </div>
    <div class="col-sm-2">
        <label for="royk_tillat">Røyk tillat?</label>
        <input type="number" class="form-control"  name="royk_tillat" id="royk_tillat" min="0" max="1" value="<?php echo $annonse['royk_tillat']; ?>" required>
    </div>
    <div class="col-sm-2">
        <label for="har_hage">Hage?</label>
        <input type="number" class="form-control"  name="har_hage" id="har_hage" min="0" max="1" value="<?php echo $annonse['har_hage']; ?>" required>
    </div>
</div>
<br>

<div class="form-row">
    <div class="col-md5 mb-3">
        <label for="bilde">Bilde av bolig</label>
        <input type="file" class="form-control"  name="bilde" id="bilde" value="<?php echo $annonse['bilde']; ?>">
    </div>
</div>

<div class="form-row">
    <div class="col-md5 mb-3">
        <label for="antall_parkeringsplasser">Antall parkeringsplasser</label>
        <input type="number" class="form-control"  name="antall_parkeringsplasser" id="antall_parkeringsplasser" value="<?php echo $annonse['antall_parkeringsplasser']; ?>" required>
    </div>
    <div class="col-md5 mb-3">
        <label for="postkode">Postkode</label>
        <input type="number" class="form-control"  name="postkode" id="postkode" value="<?php echo $annonse['postkode']; ?>" required>
    </div>
    <div class="col-md5 mb-3">
        <label for="adresse">Adresse</label>
        <input type="text" class="form-control"  name="adresse" id="adresse" value="<?php echo $annonse['adresse']; ?>" required>
    </div>
</div>

<div class="form-row">
    <div class="col-md5 mb-3">
        <label for="bolig_beskrivelse">Beskrivelse av boligen</label>
        <input type="text" class="form-control"  name="bolig_beskrivelse" id="bolig_beskrivelse" value="<?php echo $annonse['bolig_beskrivelse']; ?>" required> 
    </div>
</div>


<input type="submit" name="endre" value="Bekreft Endringer">

</div>
<br><br>
</form>

<?php
endif;

if (isset($_REQUEST["endre"])){
    
$sql2 = "UPDATE bolig SET boligtype = :boligtype, manedsleie = :manedsleie, leieperiode = :leieperiode,
        ledig_fra = :ledig_fra, areal = :areal, antall_rom = :antall_rom, ledige_rom = :ledige_rom, 
        bolig_beskrivelse = :bolig_beskrivelse, antall_bad = :antall_bad, antall_balkonger = :antall_balkonger,
        antall_soverom = :antall_soverom, er_moblert = :er_moblert, har_hvitevarer = :har_hvitevarer,
        dyr_tillat = :dyr_tillat, royk_tillat = :royk_tillat, har_hage = :har_hage,
        antall_parkeringsplasser = :antall_parkeringsplasser, postkode = :postkode, adresse = :adresse 
        WHERE bolig.bolig_id = :bolig_id";

$q2 = $pdo->prepare($sql2);

$q2->bindParam(':boligtype', $boligtype, PDO::PARAM_STR);
$q2->bindParam(':manedsleie', $manedsleie, PDO::PARAM_INT);
$q2->bindParam(':leieperiode', $leieperiode, PDO::PARAM_STR);
$q2->bindParam(':ledig_fra', $ledig_fra, PDO::PARAM_STR);
$q2->bindParam(':areal', $areal, PDO::PARAM_INT);
$q2->bindParam(':antall_rom', $antall_rom, PDO::PARAM_INT);
$q2->bindParam(':ledige_rom', $ledige_rom, PDO::PARAM_INT);
$q2->bindParam(':bolig_beskrivelse', $bolig_beskrivelse, PDO::PARAM_STR);
$q2->bindParam(':antall_bad', $antall_bad, PDO::PARAM_INT);
$q2->bindParam(':antall_balkonger', $antall_balkonger, PDO::PARAM_INT);
$q2->bindParam(':antall_soverom', $antall_soverom, PDO::PARAM_INT);
$q2->bindParam(':er_moblert', $er_moblert, PDO::PARAM_INT);
$q2->bindParam(':har_hvitevarer', $har_hvitevarer, PDO::PARAM_INT);
$q2->bindParam(':dyr_tillat', $dyr_tillat, PDO::PARAM_INT);
$q2->bindParam(':royk_tillat', $royk_tillat, PDO::PARAM_INT);
$q2->bindParam(':har_hage', $har_hage, PDO::PARAM_INT);
$q2->bindParam(':antall_parkeringsplasser', $antall_parkeringsplasser, PDO::PARAM_INT);
$q2->bindParam(':postkode', $postkode, PDO::PARAM_INT);
$q2->bindParam(':adresse', $adresse, PDO::PARAM_STR);

$boligtype = $_REQUEST['boligtype'];
$manedsleie = $_REQUEST['manedsleie'];
$leieperiode = $_REQUEST['leieperiode'];      
$ledig_fra = $_REQUEST['ledig_fra'];
$areal = $_REQUEST['areal'];
$antall_rom = $_REQUEST['antall_rom'];
$ledige_rom = $_REQUEST['ledige_rom'];
$bolig_beskrivelse = $_REQUEST['bolig_beskrivelse'];
$antall_bad = $_REQUEST['antall_bad'];
$antall_balkonger = $_REQUEST['antall_balkonger'];
$antall_soverom = $_REQUEST['antall_soverom'];
$er_moblert = $_REQUEST['er_moblert'];
$har_hvitevarer = $_REQUEST['har_hvitevarer'];
$dyr_tillat = $_REQUEST['dyr_tillat'];
$royk_tilalt = $_REQUEST['royk_tillat'];
$har_hage = $_REQUEST['har_hage'];
$antall_parkeringsplasser = $_REQUEST['antall_parkeringsplasser'];
$postkode = $_REQUEST['postkode'];
$adresse = $_REQUEST['adresse'];

echo "Endringen er registrert!";
}
?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>