<?php
$servername = "localhost"; // Promijenite na vašu postavku
$username = "root"; // Promijenite na vašu postavku
$password = ""; // Promijenite na vašu postavku
$dbname = "vijesti_db";

$kategorija = htmlspecialchars($_GET['kategorija']);

// Povezivanje s bazom
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Povezivanje s bazom nije uspjelo: " . $conn->connect_error);
}

// Dohvat vijesti po kategoriji koje nisu arhivirane
$sql = "SELECT * FROM vijesti WHERE arhiva = 0 AND kategorija = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $kategorija);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vijesti - <?php echo $kategorija; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 
