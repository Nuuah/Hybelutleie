<?php
session_start();
if (!isset($_SESSION['fornavn'])){
    header("location: Logginn.php");
    exit();
} 
?>