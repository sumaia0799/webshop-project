<?php
// functie: formulier en database insert product
// auteur: Sumaia

echo "<h1>Insert Product</h1>";

require_once('function.php');

if(isset($_POST['btn_ins'])){
    if(insertRecord($_POST) == true){
        echo "<script>alert('Product is toegevoegd')</script>";
        echo "<script> location.replace('index.php'); </script>";
    } else {
        echo "<script>alert('Product is NIET toegevoegd')</script>";
    }
}
?>
<html>
<body>

<form method="post">
    <label for="naam">Naam:</label>
    <input type="text" id="naam" name="naam" required><br><br>

    <label for="prijs">Prijs:</label>
    <input type="number" step="0.01" id="prijs" name="prijs" required><br><br>

    <label for="categorie">Categorie:</label>
    <input type="text" id="categorie" name="categorie" required><br><br>

    <label for="foto">Foto bestandsnaam:</label>
    <input type="text" id="foto" name="foto" required><br><br>

    <button type="submit" name="btn_ins">Insert</button>
</form>

<br><br>
<a href='index.php'>Home</a>

</body>
</html>