<?php
// functie: verwijderen product
// auteur: Sumaia

require_once('function.php');

if(isset($_GET['id'])){
    if(deleteRecord($_GET['id']) == true){
        echo '<script>alert("Productcode: ' . $_GET['id'] . ' is verwijderd")</script>';
        echo "<script> location.replace('index.php'); </script>";
    } else {
        echo '<script>alert("Product is NIET verwijderd")</script>';
        echo "<script> location.replace('index.php'); </script>";
    }
} else {
    echo "<script>alert('Geen id meegegeven')</script>";
    echo "<script> location.replace('index.php'); </script>";
}
?>