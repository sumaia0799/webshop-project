<?php
define("DATABASE", "webshop");
define("SERVERNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", "root");
define("CRUD_TABLE", "producten");

// database verbinding
function connectDb(){
    $dsn = "mysql:host=" . SERVERNAME . ";dbname=" . DATABASE . ";charset=utf8mb4";

    try{
        $conn = new PDO($dsn, USERNAME, PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e){
        die("Verbinding mislukt: " . $e->getMessage());
    }
}

// alle producten ophalen
function getData($table){
    $conn = connectDb();
    $sql = "SELECT * FROM $table";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// product toevoegen
function insertRecord($post){
    $conn = connectDb();

    $sql = "INSERT INTO " . CRUD_TABLE . " (naam, prijs, categorie)
            VALUES (:naam, :prijs, :categorie)";

    $values = [
        ':naam' => $post['naam'],
        ':prijs' => $post['prijs'],
        ':categorie' => $post['categorie']
    ];

    $stmt = $conn->prepare($sql);
    return $stmt->execute($values);
}

// product verwijderen
function deleteRecord($id){
    $conn = connectDb();

    $sql = "DELETE FROM " . CRUD_TABLE . " WHERE id = :id";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([':id' => (int)$id]);
}

// 1 product ophalen om te bewerken
function getRecord($id){
    $conn = connectDb();

    $sql = "SELECT * FROM " . CRUD_TABLE . " WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => (int)$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// product updaten
function updateRecord($post){
    $conn = connectDb();

    $sql = "UPDATE " . CRUD_TABLE . "
            SET naam = :naam, prijs = :prijs, categorie = :categorie
            WHERE id = :id";

    $values = [
        ':naam' => $post['naam'],
        ':prijs' => $post['prijs'],
        ':categorie' => $post['categorie'],
        ':id' => (int)$post['id']
    ];

    $stmt = $conn->prepare($sql);
    return $stmt->execute($values);
}

// tabel tonen
function printCrudTabel($rows){
    echo "<table>";
    echo "<tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Prijs</th>
            <th>Categorie</th>
            <th>Actie</th>
          </tr>";

    foreach($rows as $r){
        echo "<tr>";
        echo "<td>{$r['id']}</td>";
        echo "<td>{$r['naam']}</td>";
        echo "<td>€{$r['prijs']}</td>";
        echo "<td>{$r['categorie']}</td>";
        echo "<td>
                <a href='producten.php?edit={$r['id']}'>Bewerken</a> |
                <a href='producten.php?delete={$r['id']}'>Verwijderen</a>
              </td>";
        echo "</tr>";
    }

    echo "</table>";
}

// toevoegen
if(isset($_POST['toevoegen'])){
    insertRecord($_POST);
    header("Location: producten.php");
    exit;
}

// verwijderen
if(isset($_GET['delete'])){
    deleteRecord($_GET['delete']);
    header("Location: producten.php");
    exit;
}

// edit voorbereiden
$editRow = null;
if(isset($_GET['edit'])){
    $editRow = getRecord($_GET['edit']);
}

// updaten
if(isset($_POST['update'])){
    updateRecord($_POST);
    header("Location: producten.php");
    exit;
}

$rows = getData(CRUD_TABLE);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <a href="#">Aanbiedingen</a>
    <a href="#">Winkelwagen</a>
</nav>

<main>
    <h2>Product toevoegen / bewerken</h2>

    <form method="post" class="product-form">
        <input type="hidden" name="id" value="<?= $editRow['id'] ?? '' ?>">

        <label for="naam">Naam:</label>
        <input type="text" id="naam" name="naam" value="<?= $editRow['naam'] ?? '' ?>" required>

        <label for="prijs">Prijs:</label>
        <input type="number" step="0.01" id="prijs" name="prijs" value="<?= $editRow['prijs'] ?? '' ?>" required>

        <label for="categorie">Categorie:</label>
        <input type="text" id="categorie" name="categorie" value="<?= $editRow['categorie'] ?? '' ?>" required>

        <?php if($editRow): ?>
            <button type="submit" name="update">Update</button>
        <?php else: ?>
            <button type="submit" name="toevoegen">Toevoegen</button>
        <?php endif; ?>
    </form>

    <h2>Alle producten</h2>

    <?php printCrudTabel($rows); ?>
</main>

<footer>
    <p>Contact | Over ons | Klantenservice</p>
</footer>

</body>
</html>