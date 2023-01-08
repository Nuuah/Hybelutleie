<!DOCTYPE html>
<?php
session_start();
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Lag Annonse</title>
        <link rel="" href="">
    </head>
    <body>
        <form method="POST" action="LagAnnonse.php">

            <h1>Ny Annonse</h1><br>
            <a href="Hovedside.php">Avbryt</a>

            <hr>

            <label for="annonseoverskrift">Annonseoverskrift</label>
            <input type="text" name="annonseoverskrift" placeholder="Skriv en tittel">

            <hr>

            <label for="postkode">Postnummer</label>
            <input for="number" name="postkode" placeholder="Postnummer">

            <hr>

            <label for="adresse">Gateadresse</label>
            <input type="text" name="adresse" placeholder="Legg inn Adresse">

            <hr>

            <label for="areal">Kvm</label>
            <select name="areal"><option><disabled selected>Velg kvadratmeter</option>
            <?php
            for ($i=0; $i<=200; $i++) {
            ?>
            <option value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php }
            ?>
            </select>

            <hr>

            <label for="manedsleie">Månedsleie</label>
            <input type="number" name="manedsleie" placeholder="Leie">

            <hr>

            
            <label for="depositum">Depositum</label>
            <input type="number" name="depositum" placeholder="Depositum">

            <hr>

            <label for="boligtype">Boligtype</label>
            <select name="boligtype">       
                <option><disabled selected>Velg boligtype</option>
                <option value="0">Guttekollektiv</option>
                <option value="1">Jentekollektiv</option>
                <option value="2">Hybel</option>
                <option value="3">Leilighet</option>
                <option value="4">Enebolig</option>
                <option value="5">Tomannsbolig</option>
                <option value="6">Rekkehus</option>
            </select>

            <hr>

            <label for="antall_rom">Antall rom</label>
            <select name="antall_rom">       
                <option><disabled selected>Velg antall rom</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>

            <hr>

            <label for="antall_soverom">Soverom</label>
            <select name="antall_soverom">       
                <option><disabled selected>Velg antall soverom</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>

            <hr>

            <label for="antall_bad">Bad</label>
            <select name="antall_bad">       
                <option><disabled selected>Velg antall bad</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>

            <hr>

            <label for="antall_balkonger">Balkonger</label>
            <select name="antall_balkonger">       
                <option><disabled selected>Velg antall balkonger</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>

            <hr>
            
            <input type='hidden' value='0' name='er_moblert'>
            <input type="checkbox" name="er_moblert" value="1">
            <label for="er_moblert">Er møblert</label>
            
            <input type='hidden' value='0' name='har_hvitevarer'>
            <input type="checkbox" name="har_hvitevarer" value="1">
            <label for="har_hvitevarer">Har hvitevarer</label>

            <input type='hidden' value='0' name='dyr_tillat'>
            <input type="checkbox" name="dyr_tillat" value="1">
            <label for="dyr_tillat">Dyr tillat</label><br>  

            <input type='hidden' value='0' name='royk_tillat'>
            <input type="checkbox" name="royk_tillat" value="1">
            <label for="royk_tillat">Røyking tillat</label>

            <input type='hidden' value='0' name='har_hage'>
            <input type="checkbox" name="har_hage" value="1">
            <label for="har_hage">Har hage</label>
            
            <input type='hidden' value='0' name='har_varmekabler'>
            <input type="checkbox" name="har_varmekabler" value="1">
            <label for="har_varmekabler">Har varmekabler</label>       
            
            <hr>  
            
            <label for="antall_parkeringsplasser">Parkeringsplasser</label>
            <select name="antall_parkeringsplasser">       
                <option><disabled selected>Velg antall parkeringsplasser</option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>

            <hr>

            <label for="ledig_fra">Leies ut fra</label>
            <input type="date" name="ledig_fra">

            <hr>

            <label for="leieperiode">Leieperiode (Måneder)</label>
            <select name="leieperiode"><option><disabled selected>Velg leieperiode</option>
            <?php
            for ($i=1; $i<=36; $i++) {
            ?>
            <option value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php }
            ?>
            </select>

            <hr>

            <label for="bolig_beskrivelse">Boligbeskrivelse (Maks 500 karakterer)</label><br>
            <textarea name="bolig_beskrivelse" rows="10" cols="75" maxlength="500"></textarea>

            <hr>

            <button type="submit" name="lagAnnonse">Lag annonse</button>

        </form>
    </body>
</html>

<?php   
if(isset($_SESSION['id'], $_SESSION['epost'], $_SESSION['etternavn'], $_SESSION['fornavn'])) {
require_once("../inc/db.inc.php");

if(isset($_POST['lagAnnonse'])) {

    $messages = array();

    if(empty($_POST['annonseoverskrift'])) {    
        $messages['error'][] = "Du må lage en annonseoverskrift";
    }
    if(empty($_POST['postkode'])) {    
        $messages['error'][] = "Du må legge til postnummer";
    }
    if(empty($_POST['adresse'])) {    
        $messages['error'][] = "Du må legge til adresse";
    }
    if($_POST['areal'] == "Velg kvadratmeter") {    
        $messages['error'][] = "Du må legge til kvadratmeter";
    }
    if(empty($_POST['manedsleie'])) {    
        $messages['error'][] = "Du må legge til månedsleie";
    }
    if(empty($_POST['depositum'])) {    
        $messages['error'][] = "Du må legge til depositum";
    }
    if($_POST['boligtype'] == "Velg boligtype") {    
        $messages['error'][] = "Du må velge boligtype";
    }
    if($_POST['antall_rom'] == "Velg antall rom") {    
        $messages['error'][] = "Du må legge til antall rom";
    }
    if($_POST['antall_soverom'] == "Velg antall soverom") {    
        $messages['error'][] = "Du må legge til antall soverom";
    }
    if($_POST['antall_bad'] == "Velg antall bad") {    
        $messages['error'][] = "Du må legge til antall bad";
    }
    if($_POST['antall_balkonger'] == "Velg antall balkonger") {    
        $messages['error'][] = "Du må legge til antall balkonger";
    }
    if($_POST['antall_parkeringsplasser'] == "Velg antall parkeringsplasser") {    
        $messages['error'][] = "Du må legge til antall parkeringsplasser";
    }
    if(empty($_POST['ledig_fra'])) {    
        $messages['error'][] = "Du må legge til dato leiligheten er ledig fra";
    }
    if($_POST['leieperiode'] == "Velg leieperiode") {    
        $messages['error'][] = "Du må legge til leieperiode";
    }
    if(empty($_POST['bolig_beskrivelse'])) {    
        $messages['error'][] = "Du må legge til en boligbeskrivelse";
    }
    
    if(empty($messages)) {

        $sql = "INSERT INTO bolig
        (boligtype_id, bolig_eier, annonseoverskrift, manedsleie, 
        depositum, leieperiode, ledig_fra, 
        areal, antall_rom, ledige_rom, 
        bolig_beskrivelse, antall_bad, antall_balkonger, 
        antall_soverom, er_moblert, har_hvitevarer,
        har_varmekabler, dyr_tillat, royk_tillat, 
        har_hage, antall_parkeringsplasser, postkode, adresse) 

        VALUES
        (:boligtype, :bolig_eier, :annonseoverskrift, :manedsleie,
        :depositum, :leieperiode, :ledig_fra,
        :areal, :antall_rom, :ledige_rom,
        :bolig_beskrivelse, :antall_bad, :antall_balkonger,
        :antall_soverom, :er_moblert, :har_hvitevarer,
        :har_varmekabler, :dyr_tillat, :royk_tillat,
        :har_hage, :antall_parkeringsplasser, :postkode, :adresse)";

        $q = $pdo->prepare($sql);

        $q->bindParam(':boligtype', $boligtype, PDO::PARAM_INT);
        $q->bindParam(':bolig_eier', $bolig_eier, PDO::PARAM_INT);
        $q->bindParam(':annonseoverskrift', $annonseoverskrift, PDO::PARAM_STR);
        $q->bindParam(':manedsleie', $manedsleie, PDO::PARAM_INT);
        $q->bindParam(':depositum', $depositum, PDO::PARAM_INT);
        $q->bindParam(':leieperiode', $leieperiode, PDO::PARAM_INT);
        $q->bindParam(':ledig_fra', $ledig_fra, PDO::PARAM_STR);
        $q->bindParam(':areal', $areal, PDO::PARAM_INT);
        $q->bindParam(':antall_rom', $antall_rom, PDO::PARAM_INT);
        $q->bindParam(':ledige_rom', $ledige_rom, PDO::PARAM_INT);
        $q->bindParam(':bolig_beskrivelse', $bolig_beskrivelse, PDO::PARAM_STR);
        $q->bindParam(':antall_bad', $antall_bad, PDO::PARAM_INT);
        $q->bindParam(':antall_balkonger', $antall_balkonger, PDO::PARAM_INT);
        $q->bindParam(':antall_soverom', $antall_soverom, PDO::PARAM_INT);
        $q->bindParam(':er_moblert', $er_moblert, PDO::PARAM_INT);
        $q->bindParam(':har_hvitevarer', $har_hvitevarer, PDO::PARAM_INT);
        $q->bindParam(':har_varmekabler', $har_varmekabler, PDO::PARAM_INT);
        $q->bindParam(':dyr_tillat', $dyr_tillat, PDO::PARAM_INT);
        $q->bindParam(':royk_tillat', $royk_tillat, PDO::PARAM_INT);
        $q->bindParam(':har_hage', $har_hage, PDO::PARAM_INT);
        $q->bindParam(':antall_parkeringsplasser', $antall_parkeringsplasser, PDO::PARAM_INT);
        $q->bindParam(':postkode', $postkode, PDO::PARAM_INT);
        $q->bindParam(':adresse', $adresse, PDO::PARAM_STR);
;
        $boligtype = $_REQUEST['boligtype'];
        $bolig_eier = $_SESSION['id'];
        $annonseoverskrift = $_REQUEST['annonseoverskrift'];
        $manedsleie = $_REQUEST['manedsleie'];
        $depositum = $_REQUEST['depositum'];
        $leieperiode = $_REQUEST['leieperiode'];   ;
        $ledig_fra = $_REQUEST['ledig_fra'];
        $areal = $_REQUEST['areal'];
        $antall_rom = $_REQUEST['antall_rom'];
        $ledige_rom = $_REQUEST['antall_soverom'];
        $bolig_beskrivelse = $_REQUEST['bolig_beskrivelse'];
        $antall_bad = $_REQUEST['antall_bad'];    
        $antall_balkonger = $_REQUEST['antall_balkonger'];
        $antall_soverom = $_REQUEST['antall_soverom'];
        $er_moblert = $_REQUEST['er_moblert'];
        $har_hvitevarer = $_REQUEST['har_hvitevarer'];
        $har_varmekabler = $_REQUEST['har_varmekabler'];    
        $dyr_tillat = $_REQUEST['dyr_tillat'];
        $royk_tillat = $_REQUEST['royk_tillat'];
        $har_hage = $_REQUEST['har_hage'];
        $antall_parkeringsplasser = $_REQUEST['antall_parkeringsplasser'];
        $postkode = $_REQUEST['postkode'];
        $adresse = $_REQUEST['adresse'];

        try { 
            $q->execute();
        } catch (PDOException $e) {
            echo "Noe gikk feil med innsetting" . $e->getMessage() . "<br>";
        }

    } else {   
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
} else {
    echo "ingenting funker";
}

?>