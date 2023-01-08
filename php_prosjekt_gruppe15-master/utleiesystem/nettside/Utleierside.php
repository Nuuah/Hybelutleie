
<?php
require_once("../inc/sessioncheck.inc.php");
require_once("../css/cards.html");
require_once("../inc/db.inc.php");
require_once("../inc/loggut.inc.php");
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Min side</title>
        <link rel="stylesheet" href="../css/design1/site/css/white.css">
    </head>
    <body>

<!-- Menybaren -->
    <div class="menybar">
        <a href="#news">Ny annonse</a>
        <a href="Hovedside.php">Hjem</a>
        <a href="Logginn.php">Logg ut</a>
    </div>

  <h1> Dine Annonser </h1>

<?php

if($_SESSION['utleier'] == 1):

$sql = "SELECT boligtype.boligtype, bruker.epost, bolig.bolig_id, bolig.bilde, bolig.areal, bolig.postkode, bolig.adresse, bolig.manedsleie 
        FROM boligtype, bruker, bolig 
        WHERE bolig.boligtype_id = boligtype.boligtype_id 
        AND bruker.epost = :epost
        ORDER BY bolig_id";

    $q = $pdo->prepare($sql);

    $q->bindParam(':epost', $epost, PDO::PARAM_STR);

$epost = $_SESSION['epost'];

try {
    $q->execute();
} catch (PDOException $e) {
    echo "Error querying database: " . $e->getMessage() . "<br>"; // Never do this in production
}
$annonser = $q->fetchAll(PDO::FETCH_ASSOC);

foreach($annonser as $annonse):
?>


<div class="row">
  <div class="column">
    <div class="card">
        <img src="../img/boligbilde.jpg" alt="Bilde" style="width:100%">
        <div class="container">
        <h4><?php echo $annonse['boligtype'] . " - " .  $annonse['areal'] . " m²"; ?></b></h4>
        <p><?php echo $annonse['adresse'] . ", " . $annonse['postkode']; ?></p>
        <p><?php echo $annonse['manedsleie'] . ",-"; ?></p>
        <a href="Redigerannonser.php?id=<?php echo $annonse['bolig_id']?>">Rediger</a>
    </div>
</div>
</div>


<?php 
endforeach;
endif; 
?>