<?php
require_once("../css/cards.html");
session_start();
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Hovedside</title>
        <link rel="stylesheet" href="black.css">
    </head>

    <body>

<!-- Menybaren -->
    <div class="menybar">
  <a class="active" href="#home">Hjem</a>
  <a href="#news">Ny annonse</a>
  <a href="#contact">Min side</a>
  <a href="Logginn.php">Logg ut</a>

<!-- Søkebaren -->
  <form action="users.php" method="GET">
<input id="search" type="text" placeholder="Søk">
<input id="submit" type="submit" value="Søk">
</form>
</div>


</body>
</html>

<!-- Skrive ut annonse her. -->

<?php

require_once("../inc/db.inc.php");


if(isset($_SESSION['epost'], $_SESSION['etternavn'], $_SESSION['fornavn']))
{

$sql = 'SELECT boligtype.boligtype, bolig.bolig_id, bolig.postkode, bolig.manedsleie, bolig.areal, bolig.adresse 
        FROM boligtype, bolig
        WHERE bolig.boligtype_id = boligtype.boligtype_id
        ORDER BY bolig_id';

$q = $pdo->prepare($sql);

try {

  $q->execute();
  $annonser = $q->fetchALL(PDO::FETCH_ASSOC);


  if($q->rowCount() > 0 ) 
  {

     foreach($annonser as $annonse)
    {?>
      <div class="row">
      <div class="column">
        <div class="card">
            <img src="../img/boligbilde.jpg" alt="Bilde" style="width:100%">
            <div class="container">
            <h4><?php echo $annonse['boligtype'] . " - " .  $annonse['areal'] . " m²"; ?></b></h4>
            <p><?php echo $annonse['adresse'] . ", " . $annonse['postkode']; ?></p>
            <p><?php echo $annonse['manedsleie'] . ",-"; ?></p>
            <a href="Redigerannonser.php?id=<?php echo $annonse['bolig_id']?>">Se mer</a>
        </div>
    </div>
    </div>
    <?php
     }
  }
} catch (PDOException $e) {
    echo "Error querying database: " . $e->getMessage() . "<br>"; // Never do this in production
}

} else {
  echo "feil med session";
}

?>