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
<html>
<head>
<title>CRUD Webshop</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<h1>Producten CRUD</h1>

<h2>Product toevoegen / bewerken</h2>

<form method="post">

<input type="hidden" name="id" value="<?= $editRow['id'] ?? '' ?>">

Naam:
<input type="text" name="naam" 
value="<?= $editRow['naam'] ?? '' ?>" required>

Prijs:
<input type="number" step="0.01" name="prijs"
value="<?= $editRow['prijs'] ?? '' ?>" required>

Categorie:
<input type="text" name="categorie"
value="<?= $editRow['categorie'] ?? '' ?>" required>

<?php if($editRow): ?>
<button name="update">Update</button>
<?php else: ?>
<button name="toevoegen">Toevoegen</button>
<?php endif; ?>

</form>

<h2>Alle producten</h2>

<table>
<tr>
<th>ID</th>
<th>Naam</th>
<th>Prijs</th>
<th>Categorie</th>
<th>Actie</th>
</tr>

<?php foreach($rows as $r): ?>

<tr>
<td><?= $r['id'] ?></td>
<td><?= $r['naam'] ?></td>
<td>€<?= $r['prijs'] ?></td>
<td><?= $r['categorie'] ?></td>
<td>
<a href="?edit=<?= $r['id'] ?>">Bewerken</a> |
<a href="?delete=<?= $r['id'] ?>">Verwijderen</a>
</td>
</tr>

<?php endforeach; ?>

</table>

</body>
</html>