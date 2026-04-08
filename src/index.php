<?php
define("DATABASE", "webshop");
define("SERVERNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", "root");
define("CRUD_TABLE", "producten");

function connectDb(){
    $dsn = "mysql:host=" . SERVERNAME . ";dbname=" . DATABASE . ";charset=utf8mb4";
    $conn = new PDO($dsn, USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}

function getData($table){
    $conn = connectDb();
    $sql = "SELECT * FROM $table";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertRecord($post){
    $conn = connectDb();

    $sql = "INSERT INTO producten (naam, prijs, categorie)
            VALUES (:naam, :prijs, :categorie)";

    $values = [
        ':naam' => $post['naam'],
        ':prijs' => $post['prijs'],
        ':categorie' => $post['categorie']
    ];

    $stmt = $conn->prepare($sql);
    return $stmt->execute($values);
}

function deleteRecord($id){
    $conn = connectDb();

    $sql = "DELETE FROM producten WHERE id = :id";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([':id'=>$id]);
}

if(isset($_POST['toevoegen'])){
    insertRecord($_POST);
}

if(isset($_GET['delete'])){
    deleteRecord($_GET['delete']);
}


/* HIER PLAKKEN ↓↓↓ */

$editRow = null;

if(isset($_GET['edit'])){
    $conn = connectDb();
    $sql = "SELECT * FROM producten WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id'=>$_GET['edit']]);
    $editRow = $stmt->fetch(PDO::FETCH_ASSOC);
}

if(isset($_POST['update'])){
    $conn = connectDb();

    $sql = "UPDATE producten 
            SET naam=:naam, prijs=:prijs, categorie=:categorie
            WHERE id=:id";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':naam'=>$_POST['naam'],
        ':prijs'=>$_POST['prijs'],
        ':categorie'=>$_POST['categorie'],
        ':id'=>$_POST['id']
    ]);
}

/* TOT HIER ↑↑↑ */

$rows = getData("producten");
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaTech Shop - Home</title>
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
    <section class="welcome">
        <h2>Welkom bij NovaTech Shop</h2>
        <p>Bekijk onze nieuwste producten</p>
    </section>

    <section class="product-grid">
        <div class="card">
            <div class="img-box">Afbeelding</div>
            <h3>Telefoonhoesje</h3>
            <p>€15</p>
        </div>

        <div class="card">
            <div class="img-box">Afbeelding</div>
            <h3>Oplader</h3>
            <p>€20</p>
        </div>

        <div class="card">
            <div class="img-box">Afbeelding</div>
            <h3>Oordopjes</h3>
            <p>€30</p>
        </div>
    </section>
</main>

<footer>
    <p>Contact | Over ons | Klantenservice</p>
</footer>

</body>
</html>