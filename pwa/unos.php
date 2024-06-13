<?php
$naslov = $kratki_sadrzaj = $sadrzaj = $kategorija = $arhivirano = $slika = "";
$servername = "localhost"; // Promijenite na vašu postavku
$username = "root"; // Promijenite na vašu postavku
$password = ""; // Promijenite na vašu postavku
$dbname = "vijesti";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Uzimanje podataka iz POST metode
    $naslov = htmlspecialchars($_POST['naslov']);
    $kratki_sadrzaj = htmlspecialchars($_POST['kratki_sadrzaj']);
    $sadrzaj = htmlspecialchars($_POST['sadrzaj']);
    $kategorija = htmlspecialchars($_POST['kategorija']);
    $arhivirano = isset($_POST['arhivirano']) ? 1 : 0;

    // Rukovanje uploadom slike
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $upload_file = $upload_dir . basename($_FILES['slika']['name']);
    if (move_uploaded_file($_FILES['slika']['tmp_name'], $upload_file)) {
        $slika = $upload_file;
    } else {
        $slika = 'Nema slike';
    }

     // Pohrana podataka u bazu
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Povezivanje s bazom nije uspjelo: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO vijesti (naslov, kratki_sadrzaj, sadrzaj, slika, kategorija, arhivirano) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $naslov, $kratki_sadrzaj, $sadrzaj, $slika, $kategorija, $arhivirano);

    if ($stmt->execute()) {
        echo "Vijest je uspješno pohranjena.";
    } else {
        echo "Greška pri pohranjivanju vijesti: " . $stmt->error;
    }

    $stmt->close();
    $conn->close(); 
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unos vijesti</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 20px;
    padding: 0;
    background-color: #f4f4f9;
}

h1 {
    text-align: center;
}

form {
    max-width: 600px;
    margin: 0 auto;
    background: #fff;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

form label {
    display: block;
    margin: 15px 0 5px;
}

form input[type="text"],
form textarea,
form input[type="file"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

form input[type="checkbox"] {
    margin-left: 0;
}

.buttons {
    text-align: right;
}

.buttons button {
    padding: 10px 15px;
    margin: 5px;
    border: none;
    background-color: #007bff;
    color: white;
    border-radius: 4px;
    cursor: pointer;
}

.buttons button[type="reset"] {
    background-color: #6c757d;
}

.buttons button:hover {
    opacity: 0.8;
}

.news-preview {
    max-width: 600px;
    margin: 20px auto;
    background: #fff;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.news-preview img {
    max-width: 100%;
}

form {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        form label {
            display: block;
            margin: 15px 0 5px;
        }
        form input[type="text"],
        form textarea,
        form input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
    </style>
</head>
<body>
    <h1>Unos vijesti</h1>
    <form id=forma enctype="multipart/form-data" action="skripta.php" method="POST">
        <div class="form-item">
            <span id="poruka_naslov" class="bojaPoruke"></span>
            <label for="naslov">Naslov vijesti</label>
            <div class="form-field">
                <input type="text" name="naslov" id="naslov" class="formfield-textual">
            </div>
        </div>
        <div class="form-item">
            <span id="poruka_kratki_sadrzaj" class="bojaPoruke"></span>
            <label for="kratki_sadrzaj">Kratki sadržaj vijesti (do 50 znakova)</label>
            <div class="form-field">
                <textarea name="kratki_sadrzaj" id="kratki_sadrzaj" cols="30" rows="10"
                    class="form-field-textual"></textarea>
            </div>
        </div>
        <div class="form-item">
            <span id="poruka_sadrzaj" class="bojaPoruke"></span>
            <label for="sadrzaj">Sadržaj vjesti</label>
            <div class="form-field">
                <textarea name="sadrzaj" id="sadrzaj" cols="30" rows="10"
                    class="form-field-textual"></textarea>
            </div>
        </div>
        <div class="form-item">
            <span id="poruka_slika" class="bojaPoruke"></span>
            <label for="slika">Slika: </label>
            <div class="form-field">
                <input type="file" class="input-text" id="slika" name="slika"/>
            </div>
        </div>
        <div class="form-item">
            <span id="poruka_kategorija" class="bojaPoruke"></span>
            <label for="kategorija">Kategorija vjesti</label>
            <div class="form-field">
                <select name="kategorija" id="kategorija" class="form-fieldtextual">
                    <option value="" disabled selected>Odabir kategorije</option>
                    <option value="sport">Sport</option>
                    <option value="kultura">Kultura</option>
                </select>
            </div>
        </div>
        <div class="form-item">
            <label>
                Spremiti u arhivu:
                <div class="form-field">
                    <input type="checkbox" name="arhivirano" id="arhivirano">
                </div>
            </label>
        </div>
        <div class="form-item">
            <button type="reset" value="Poništi">Poništi</button>
            <button type="submit" value="Prihvati" id="slanje">Prihvati</button>
        </div>
    </form>
    <script type = "text/javascript">
    // Provjera forme prije slanja
    document.getElementById("slanje").onclick = function(event) {

        var slanjeForme = true;

        // Naslov vjesti (5-30 znakova)
        var poljeTitle = document.getElementById("naslov");
        var poljeTitlePoruka = document.getElementById("poruka_naslov");
        var title = document.getElementById("naslov").value;
        if (title.length < 5 || title.length > 30) {
            slanjeForme = false;
            poljeTitle.style.border = "1px dashed red";
            poljeTitlePoruka.style.color = "red";
            document.getElementById("poruka_naslov").innerHTML = "Naslov vjesti mora imati između 5 i 30 znakova!<br>";
        } else {
            poljeTitle.style.border = "1px solid green";
            document.getElementById("poruka_naslov").innerHTML = "";
        }

        // Kratki sadržaj (10-100 znakova)
        var poljeAbout = document.getElementById("kratki_sadrzaj");
        var poljeAboutPoruka = document.getElementById("poruka_kratki_sadrzaj");
        var about = document.getElementById("kratki_sadrzaj").value;
        if (about.length < 10 || about.length > 100) {
            slanjeForme = false;
            poljeAbout.style.border = "1px dashed red";
            poljeAboutPoruka.style.color = "red";
            document.getElementById("poruka_kratki_sadrzaj").innerHTML = "Kratki sadržaj mora imati između 10 i 100 znakova!<br>";
        } else {
            poljeAbout.style.border = "1px solid green";
            document.getElementById("poruka_kratki_sadrzaj").innerHTML = "";
        }
        // Sadržaj mora biti unesen
        var poljeContent = document.getElementById("sadrzaj");
        var poljeContentPoruka = document.getElementById("poruka_sadrzaj");
        var content = document.getElementById("sadrzaj").value;
        if (content.length == 0) {
            slanjeForme = false;
            poljeContent.style.border = "1px dashed red";
            poljeContentPoruka.style.color = "red";
            document.getElementById("poruka_sadrzaj").innerHTML = "Sadržaj mora biti unesen!<br>";
        } else {
            poljeContent.style.border = "1px solid green";
            10
            document.getElementById("poruka_sadrzaj").innerHTML = "";
        }
        // Slika mora biti unesena
        var poljeSlika = document.getElementById("slika");
        var poljeSlikaPoruka = document.getElementById("poruka_slika");
        var pphoto = document.getElementById("slika").value;
        if (pphoto.length == 0) {
            slanjeForme = false;
            poljeSlika.style.border = "1px dashed red";
            poljeSlikaPoruka.style.color = "red";
            document.getElementById("poruka_slika").innerHTML = "Slika mora biti unesena!<br>";
        } else {
            poljeSlika.style.border = "1px solid green";
            document.getElementById("poruka_slika").innerHTML = "";
        }
        // Kategorija mora biti odabrana
        var poljeCategory = document.getElementById("kategorija");
        var poljeCategoryPoruka = document.getElementById("poruka_kategorija");
        if (document.getElementById("kategorija").selectedIndex == 0) {
            slanjeForme = false;
            poljeCategory.style.border = "1px dashed red";
            poljeCategoryPoruka.style.color = "red";
            document.getElementById("poruka_kategorija").innerHTML = "Kategorija mora biti odabrana!<br>";
        } else {
            poljeCategory.style.border = "1px solid green";
            document.getElementById("poruka_kategorija").innerHTML = "";
        }

        if (slanjeForme != true) {
            event.preventDefault();
        }

    }; </script>
</body>
</html>
