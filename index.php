<?php
// Datenbankverbindung
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "produktverwaltung";

// Verbindung erstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung überprüfen
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Suchen von Produkten
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $search_result = $conn->query("SELECT * FROM Produkt WHERE name LIKE '%$search_query%'");

    if ($search_result->num_rows > 0) {
        while ($row = $search_result->fetch_assoc()) {
            echo "Produkt mit dem Namen " . $row['name'] . " gefunden.<br>";
        }
    } else {
        echo "Produkt ist nicht in der Datenbank vorhanden.<br>";
    }
}

// Anlegen von Produkten
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $check_query = "SELECT * FROM Produkt WHERE name='$name' AND beschreibung='$description' AND price='$price'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        echo "Produkt existiert bereits.<br>";
    } else {
        $insert_query = "INSERT INTO Produkt (name, beschreibung, price) VALUES ('$name', '$description', '$price')";

        if ($conn->query($insert_query) === TRUE) {
            echo "Produkt erfolgreich angelegt.<br>";
        } else {
            echo "Fehler beim Anlegen des Produkts: " . $conn->error . "<br>";
        }
    }
}

// Bearbeiten von Produkten
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editID'])) {
    $editID = $_POST['editID'];
    // Hier wird die ID verändert, je nach Bedarf
    echo "Produkt mit ID $editID bearbeitet.<br>";
}

// Drucken von Produktlisten
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['print'])) {
    $print_result = $conn->query("SELECT * FROM Produkt");

    if ($print_result->num_rows > 0) {
        while ($row = $print_result->fetch_assoc()) {
            echo "Produkt: " . $row['name'] . ", Beschreibung: " . $row['description'] . ", Preis: " . $row['price'] . "<br>";
        }
    } else {
        echo "Keine Produkte in der Datenbank.<br>";
    }
}

$conn->close();
?>
