<?php
if(isset($_REQUEST["loggut"])){
    session_start();
    session_destroy();
    header("Location: Logginn.php");
}
?>