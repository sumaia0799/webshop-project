<?php
// functie: aanbiedingen tonen
// auteur: Sumaia

require_once('function.php');

$conn = connectDb();

$sql = "SELECT * FROM producten LIMIT 3";
$stmt = $conn->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Aanbiedingen</title>
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
    <h2>Aanbiedingen</h2>
    <p>Bekijk onze beste deals en kortingen!</p>

    <section class="product-grid">

        <?php foreach($rows as $r){ ?>
            <div class="card">

                <?php
                if(!empty($r['foto'])){
                    echo "<img src='images/" . htmlspecialchars($r['foto']) . "' width='150'>";
                } else {
                    echo "<p>Geen foto</p>";
                }
                ?>

                <h3><?php echo htmlspecialchars($r['naam']); ?></h3>

                <p>
                    Van €<?php echo htmlspecialchars($r['prijs']); ?>
                    voor €<?php echo number_format($r['prijs'] - 5, 2); ?>
                </p>

                <a href="winkelwagen.php">In winkelwagen</a>
            </div>
        <?php } ?>

    </section>
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