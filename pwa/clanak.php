<?php
// Povezivanje s bazom
$servername = "localhost"; // Promijenite na vašu postavku
$username = "root"; // Promijenite na vašu postavku
$password = ""; // Promijenite na vašu postavku
$dbname = "vijesti_db";

// Spajanje na bazu podataka
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Povezivanje s bazom nije uspjelo: " . $conn->connect_error);
}

// Dohvaćanje ID-a članka iz GET parametra
$id = intval($_GET['id']);

// Dohvaćanje podataka o članku
$sql = "SELECT * FROM vijesti WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    die("Članak nije pronađen.");
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['naslov']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 2em;
            text-align: center;
            margin-bottom: 10px;
        }
        .meta {
            text-align: center;
            color: #777;
            margin-bottom: 20px;
        }
        img {
            max-width: 100%;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            font-size: 1.2em;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $row['naslov']; ?></h1>
        <p class="meta">Ažurirano <?php echo date("d.m.Y", strtotime($row['created_at'])); ?></p>
        <?php if ($row['slika'] != 'Nema slike'): ?>
            <img src="<?php echo $row['slika']; ?>" alt="Slika članka">
        <?php endif; ?>
        <p class="content"><?php echo nl2br($row['sadrzaj']); ?></p>
    </div>
</body>
</html>
