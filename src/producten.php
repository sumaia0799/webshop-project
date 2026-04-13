<?php require_once 'function.php'; ?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>NovaTech Shop - Producten</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>NovaTech Shop</h1>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="producten.php">Producten</a>
    <a href="aanbiedingen.php">Aanbiedingen</a>
     <a href="leveranciers.php">Leveranciers</a>
    <a href="winkelwagen.php">Winkelwagen</a>
   
</nav>

<main>
    <?php crudMain(); ?>
</main>

<footer>
    <p>
        <a href="contact.php">Contact</a> |
        <a href="overons.php">Over ons</a> |
        <a href="klantenservice.php">Klantenservice</a> |
        <a href="leveranciers.php">Leveranciers</a>
    </p>
</footer>

</body>
</html>