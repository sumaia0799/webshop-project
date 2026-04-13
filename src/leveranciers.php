<?php
require_once 'function.php';

$conn = connectDb();
$sql = "SELECT * FROM leveranciers";
$stmt = $conn->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>NovaTech Shop - Leveranciers</title>
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
<h2>Leveranciers</h2>

<table class="table">
<tr>
    <th>ID</th>
    <th>Naam</th>
    <th>Email</th>
</tr>

<?php foreach($rows as $r){ ?>
<tr>
    <td><?php echo $r['id']; ?></td>
    <td><?php echo $r['naam']; ?></td>
    <td><?php echo $r['email']; ?></td>
</tr>
<?php } ?>

</table>

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