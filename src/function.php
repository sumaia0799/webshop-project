<?php
// functie: database functies webshop
// auteur: Sumaia

include_once "config.php";

function connectDb(){
    $dsn = "mysql:host=" . SERVERNAME . ";dbname=" . DATABASE . ";charset=utf8mb4";

    try {
        $conn = new PDO($dsn, USERNAME, PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return null;
    }
}

function getData($table){
    $conn = connectDb();
    $sql = "SELECT * FROM $table";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getRecord($id){
    $conn = connectDb();

    $sql = "SELECT * FROM " . CRUD_TABLE . " WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => (int)$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function insertRecord($post): bool {
    $conn = connectDb();

    $sql = "INSERT INTO " . CRUD_TABLE . " (naam, prijs, categorie, foto)
            VALUES (:naam, :prijs, :categorie, :foto)";

    $values = [
        ':naam' => $post['naam'],
        ':prijs' => $post['prijs'],
        ':categorie' => $post['categorie'],
        ':foto' => $post['foto']
    ];

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($values);
        return true;
    } catch (PDOException $e) {
        echo "Insert failed: " . $e->getMessage();
        return false;
    }
}

function updateRecord($post): bool {
    $conn = connectDb();

    $sql = "UPDATE " . CRUD_TABLE . "
            SET naam = :naam,
                prijs = :prijs,
                categorie = :categorie,
                foto = :foto
            WHERE id = :id";

    $values = [
        ':naam' => $post['naam'],
        ':prijs' => $post['prijs'],
        ':categorie' => $post['categorie'],
        ':foto' => $post['foto'],
        ':id' => (int)$post['id']
    ];

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($values);
        return true;
    } catch(PDOException $e) {
        echo "Update failed: " . $e->getMessage();
        return false;
    }
}

function deleteRecord($id): bool {
    $conn = connectDb();

    $sql = "DELETE FROM " . CRUD_TABLE . " WHERE id = :id";
    $values = [':id' => (int)$id];

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($values);
        return true;
    } catch(PDOException $e) {
        echo "Delete failed: " . $e->getMessage();
        return false;
    }
}

function getFilteredData($categorie = ""){
    $conn = connectDb();

    if($categorie == ""){
        $sql = "SELECT * FROM " . CRUD_TABLE;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    } else {
        $sql = "SELECT * FROM " . CRUD_TABLE . " WHERE categorie = :categorie";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':categorie' => $categorie]);
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function printCrudTabel($rows){
    echo "<table border='1' cellpadding='6'>";
    echo "<tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Prijs</th>
            <th>Categorie</th>
            <th>Foto</th>
            <th>Actie</th>
          </tr>";


    foreach($rows as $r){
        echo "<tr>";
        echo "<td>" . htmlspecialchars($r['id']) . "</td>";
        echo "<td>" . htmlspecialchars($r['naam']) . "</td>";
        echo "<td>€" . htmlspecialchars($r['prijs']) . "</td>";
        echo "<td>" . htmlspecialchars($r['categorie']) . "</td>";

        if(!empty($r['foto'])){
            echo "<td><img src='images/" . htmlspecialchars($r['foto']) . "' width='80'></td>";
        } else {
            echo "<td>Geen foto</td>";
        }

        echo "<td>
                <a href='update.php?id={$r['id']}'>Wzg</a> |
                <a href='delete.php?id={$r['id']}'>Del</a>
              </td>";
        echo "</tr>";
    }

    echo "</table>";
}

function crudMain(){
    $categorie = $_GET['categorie'] ?? "";
    $result = getFilteredData($categorie);

    echo "<h1>NovaTech Shop</h1>";
    echo "<nav><a href='insert.php'>Toevoegen nieuw product</a></nav><br>";

    echo "
    <form method='get'>
        <label for='categorie'>Filter op categorie:</label>
        <select name='categorie' id='categorie'>
            <option value=''>Alle categorieën</option>
            <option value='Elektronica'>Elektronica</option>
            <option value='Accessoires'>Accessoires</option>
            <option value='Audio'>Audio</option>
        </select>
        <button type='submit'>Filter</button>
    </form><br>
    ";

    printCrudTabel($result);
}
?>