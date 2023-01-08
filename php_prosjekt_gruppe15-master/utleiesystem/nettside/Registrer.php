<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <title>Registrer bruker</title>
    </head> 
    <body>
    <form method="POST" action="Registrer.php" enctype="multipart/form-data">

    <h1>Registrer bruker</h1>
    <p>Venligst fyll inn all nødvendig informasjon.</p>
    <hr>

        <label for="fornavn"> Fornavn:</label>
        <input type="text" name="fornavn">

        <hr>

        <label for="etternavn"> Etternavn:</label>
        <input type="text" name="etternavn">
        
        <hr>

        <label for="epost"> E-post:</label>
        <input type="email" name="epost">
        
        <hr>

        <label for="telefon"> Telefonnummer:</label>
        <input type="number" name="telefon">

        <hr>

        <label for="passord"> Passord</label>
        <input type="password" id="passord" name="passord">

        <hr>

        <label for="rolle">Rolle</label>
            <select name="rolle">       
                <option><disabled selected>Velg rolle</option>
                <option value="0">Student</option>
                <option value="1">Utleier</option>
            </select>
        
        <hr>

        
        <label for="kjonn">Kjønn</label>
            <select name="kjonn">       
                <option><disabled selected>Velg kjønn</option>
                <option value="0">Mann</option>
                <option value="1">Kvinne</option>
            </select>
        
        <hr>

        <button type="submit" name="registrer">Registrer</button>

        <p>Har du allerede konto?</p>
        <a href="Logginn.php">Logg inn.</a>

        </form>  
        </pre>
    </body>
    
</html>

<?php
require_once("../inc/db.inc.php");

if(isset($_POST['registrer'])) {
    
    $messages = array();    //array med feilmeldinger

    if(empty($_POST['fornavn'])) {    
        $messages['error'][] = "Du må legge til fornavn";
    }
    if(empty($_POST['etternavn'])) {    
        $messages['error'][] = "Du må legge til etternavn";
    }
    if(empty($_POST['epost'])) {   
        $messages['error'][] = "Du må legge til e-post";
    }
    if(empty($_POST['telefon'])) {    
        $messages['error'][] = "Du må legge til telefonnummer";
    }
    if(empty($_POST['passord'])) {    
        $messages['error'][] = "Du må legge til passord";
    }

    //Sjekker om det er duplikat epost

    $sql = "SELECT * FROM bruker WHERE epost=:epost";
    $query = $pdo->prepare($sql);
    $query->bindParam(':epost', $epost, PDO::PARAM_STR);
    $epost = $_REQUEST['epost'];
    try { 
        $query->execute(); 
    } catch (PDOException $e) {
        echo "Error querying database: " . $e->getMessage() . "<br>"; // Never do this in production
    }
    $result = $query->rowCount();
    if($result > 0) {
        $messages['error'][] = "Epost eksisterer alt";
    }

    // Kjører hvis det ikke  er feilmeldinger

    if(empty($messages)) {       

        echo "Ny bruker er registrert!" . "<br>";

        $sql = "INSERT INTO bruker 
        (fornavn, etternavn, epost, telefon, passord, utleier, kjonn) 
        VALUES 
        (:fornavn, :etternavn, :epost, :telefon, :passord, :rolle, :kjonn)"; 

$q = $pdo->prepare($sql);

$q->bindParam(':fornavn', $fornavn, PDO::PARAM_STR);
$q->bindParam(':etternavn', $etternavn, PDO::PARAM_STR);
$q->bindParam(':epost', $epost, PDO::PARAM_STR);
$q->bindParam(':telefon', $telefon, PDO::PARAM_STR);
$q->bindParam(':passord', $passord, PDO::PARAM_STR);
$q->bindParam(':rolle', $rolle, PDO::PARAM_STR);
$q->bindParam(':kjonn', $kjonn, PDO::PARAM_STR);
//$q->bindParam(':profilbilde', $profilbilde, PDO::PARAM_STR);

$fornavn = $_REQUEST['fornavn'];
$etternavn = $_REQUEST['etternavn'];
$epost = $_REQUEST['epost'];
$telefon = $_REQUEST['telefon'];
$passord = password_hash($_REQUEST['passord'], PASSWORD_DEFAULT);
$rolle = $_REQUEST['rolle'];    
$kjonn = $_REQUEST['kjonn'];
//$profilbilde = $_FILES['upload-file']['name'];

try {
    $q->execute();
} catch (PDOException $e) {
    echo "Error querying database: " . $e->getMessage() . "<br>"; // Never do this in production
}

if($pdo->lastInsertId() > 0) {
  echo "Bruker er registrert!";
} else {
    echo "Data were not inserted into database.";
}
        }
    
    else {    
        if(isset($messages) && !empty($messages))
        {
            echo "<strong>Feilmelding" . (sizeof($messages, COUNT_RECURSIVE)-1 > 1 ? "er:<br>" : ":<br>") . "</strong>";
            foreach($messages as $msg_type => $type_messages)
            {
                if($msg_type == 'error')
                    foreach($type_messages as $message) { echo '<span style="color:red";>- ' . $message . '</span><br>'; }
                elseif($msg_type == 'success')
                    foreach($type_messages as $message) { echo '<span style="color:green";>- ' . $message . '</span><br>'; }
            }
        }
    }
}


?>
