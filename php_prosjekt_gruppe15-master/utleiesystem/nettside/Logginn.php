<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Logg inn</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

    
<form method="POST" action="Logginn.php">
    <h1>Logg inn</h1>
    <p>Venligst logg inn.</p>

        <label for="e-post"><b>E-post</b></label>
        <input type="email" placeholder="Skriv inn e-post" name="log_email" required>
    <hr>

        <label for="passord"><b>Passord</b></label>
        <input type="password" placeholder="Skriv inn passord" name="log_password" required>
    <hr>

    <button type="submit"  name="registrer">Logg inn</button>

    <p>Har du ikke konto?</p>
    <a href="Registrer.php">Registrer bruker.</a>

    </form>
</body>
</html>

<?php
require_once("../inc/db.inc.php");

$messages = array();

if(isset($_POST['registrer'])) {

    $epost = $_REQUEST['log_email'];
    $passord = $_REQUEST['log_password'];

$sql = "SELECT bruker_id, fornavn, etternavn, epost, passord
        FROM bruker 
        WHERE epost = :epost";

$q = $pdo->prepare($sql);

$q->bindParam(':epost', $epost, PDO::PARAM_STR);

try {
    $q->execute();
} catch (PDOException $e) {
    echo "Error querying database: " . $e->getMessage() . "<br>"; // Never do this in production
}
$bruker = $q->fetch(PDO::FETCH_ASSOC);

$hashetPassord = $bruker['passord'];

$sjekkPass = password_verify($passord, $hashetPassord);

 if($sjekkPass === TRUE) {
   session_start();
            $_SESSION['id'] = $bruker['bruker_id'];
            $_SESSION['epost'] = $bruker['epost'];
            $_SESSION['etternavn'] = $bruker['etternavn'];
            $_SESSION['fornavn'] = $bruker['fornavn'];
            $_SESSION['utleier'] =  $bruker['utleier'];

            header("location: Hovedside.php");
} else{
    $messages['error'][] = "Ugyldig passord eller e-post.";
}


if(isset($messages) && !empty($messages))
{
    echo "<strong>Message" . (sizeof($messages, COUNT_RECURSIVE)-1 > 1 ? "s:<br>" : ":<br>") . "</strong>";
    foreach($messages as $msg_type => $type_messages)
    {
        if($msg_type == 'error')
            foreach($type_messages as $message) { echo '<span style="color:red";>- ' . $message . '</span><br>'; }
        elseif($msg_type == 'success')
            foreach($type_messages as $message) { echo '<span style="color:green";>- ' . $message . '</span><br>'; }
    }
}
else
{
    echo "<strong> Fyll inn passord eller epost </strong>";
}
}
?>
