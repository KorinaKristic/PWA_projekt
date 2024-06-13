<?php
// Povezivanje s bazom podataka
$naslov = $kratki_sadrzaj = $sadrzaj = $kategorija = $arhivirano = $slika = "";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vijesti";

$conn = new mysqli($servername, $username, $password, $dbname);

// Provjera povezivanja
if ($conn->connect_error) {
    die("Povezivanje nije uspjelo: " . $conn->connect_error);
}

// Priprema podataka iz forme
$naslov = $_POST['naslov'];
$kratki_sadrzaj = $_POST['kratki_sadrzaj'];
$sadrzaj = $_POST['sadrzaj'];
$kategorija = $_POST['kategorija'];
$arhivirano = isset($_POST['arhivirano']) ? 1 : 0;
$slika = '';

if ($_FILES['slika']['name']) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["slika"]["name"]);
    move_uploaded_file($_FILES["slika"]["tmp_name"], $target_file);
    $slika = $target_file;
}

// Unos podataka u bazu
$sql = "INSERT INTO vijesti (naslov, kratki_sadrzaj, sadrzaj, kategorija, slika, arhivirano) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $naslov, $kratki_sadrzaj, $sadrzaj, $kategorija, $slika, $arhivirano);

$stmt->close();
$conn->close();

// Prikaz unesenih podataka
echo "
<!DOCTYPE html>
<html lang='hr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Pregled Vijesti</title>
    <style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}
    h1 {
            font-size: 2em;
            text-transform:uppercase;

}
 p{
     font-family: 'Old English Text MT', serif;
        font-size: 4em;
        text-decoration:underline;
        text-decoration-color:blue;
         text-decoration-thickness:3px;
}
        div{
width: 70%;
    margin: 0 auto;
}
    img{
    width:100%;
    margin-top:10px;
    
}
 a:link, a:visited {
  background-color: white;
  color: black;
  border: 2px solid blue;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
}

a:hover, a:active {
  background-color: blue;
  color: white;
}
    </style>
</head>
<body>
<div>
    <p>$kategorija</p>
    <h1>$naslov</h1>
    <article>AUTOR:</article>
    <article>OBJAVLJENO:</article>

    <img src='$slika' alt='Slika vijesti' width='200'>
    <h4>$kratki_sadrzaj</h4>
    <article>$sadrzaj</article>
    <p>" . ($arhivirano ? "Ova vijest je arhivirana." : "") . "</p>
    <a href='index.php'>Povratak na početnu stranicu</a>
    </div>
</body>
</html>
";
?>
