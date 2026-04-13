<?php
// functie: update product
// auteur: Sumaia

require_once('function.php');

if(isset($_POST['btn_wzg'])){
    if(updateRecord($_POST) == true){
        echo "<script>alert('Product is gewijzigd')</script>";
        echo "<script> location.replace('index.php'); </script>";
    } else {
        echo '<script>alert("Product is NIET gewijzigd")</script>';
    }
}

if(isset($_GET['id'])){  
    $id = $_GET['id'];
    $row = getRecord($id);
} else {
    echo "Geen id opgegeven<br>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Wijzig Product</title>
</head>
<body>

<h2>Wijzig Product</h2>

<form method="post">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <label for="naam">Naam:</label>
    <input type="text" id="naam" name="naam" required value="<?php echo htmlspecialchars($row['naam']); ?>"><br><br>

    <label for="prijs">Prijs:</label>
    <input type="number" step="0.01" id="prijs" name="prijs" required value="<?php echo htmlspecialchars($row['prijs']); ?>"><br><br>

    <label for="categorie">Categorie:</label>
    <input type="text" id="categorie" name="categorie" required value="<?php echo htmlspecialchars($row['categorie']); ?>"><br><br>

    <label for="foto">Foto bestandsnaam:</label>
    <input type="text" id="foto" name="foto" required value="<?php echo htmlspecialchars($row['foto']); ?>"><br><br>

    <button type="submit" name="btn_wzg">Wijzig</button>
</form>

<br><br>
<a href="index.php">Home</a>

</body>
</html>