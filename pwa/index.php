<?php
// Postavke za povezivanje s bazom
$servername = "localhost"; // Promijenite po potrebi
$username = "root"; // Promijenite po potrebi
$password = ""; // Promijenite po potrebi
$dbname = "vijesti";

// Povezivanje s bazom
$conn = new mysqli($servername, $username, $password, $dbname);

// Provjera veze
if ($conn->connect_error) {
    die("Povezivanje s bazom nije uspjelo: " . $conn->connect_error);
}

// SQL upit za dohvaćanje svih vijesti
$sql = "SELECT naslov, kratki_sadrzaj, sadrzaj, slika, kategorija, arhivirano FROM vijesti";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frankfurter Allgemeine</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Frankfurter Allgemeine</h1>
            <nav>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Politik</a></li>
                    <li><a href="#">Sport</a></li>
                    <li><a href="#">Administration</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <section class="main-content">
                <h2>Politik</h2>
                <div class="news-section">
                    <article>
                        <img src="uploads/plenki.jpeg" alt="Timmermans">
                        <h3>Sozialdemokrat Timmermans will Kurzstreckenflüge abschaffen</h3>
                        <p>Im letzten deutschen Fernsehduell vor der Europawahl spricht sich Frans Timmermans für einen Ausbau der Bahnverbindungen in ganz Europa aus. Christdemokrat Manfred Weber äußert sich vorsichtiger. Uneins sind sie sich bei einem anderen Thema.</p>
                        <time datetime="2024-06-11">vor 2 Stunden</time>
                    </article>
                    <article>
                        <img src="uploads/vs.jpg" alt="Bundestag">
                        <h3>Bundestag beschließt Bafög-Reform</h3>
                        <p>Um den rückläufigen Zahlen der Bafög-Beziehenden entgegenzuwirken, beschließt der Bundestag eine Erhöhung des Förderbetrages. Auch der Kreis der Empfänger erhöht sich. Ob die Maßnahme die gewünschte Wirkung hat, wird jedoch bezweifelt.</p>
                        <time datetime="2024-06-11">vor 3 Stunden</time>
                    </article>
                    <article>
                        <img src="uploads/milanovic.jpg" alt="Öcalan">
                        <h3>Türkei hebt Besuchsverbot für Öcalan-Anwälte auf</h3>
                        <p>Acht Jahre verbrachte der Gründer der PKK in beinahe völliger Isolation. Nun hebt die türkische Regierung das seit Juli 2011 bestehende Kontaktverbot für die Anwälte von Abdullah Öcalan wieder auf.</p>
                        <time datetime="2024-06-11">vor 3 Stunden</time>
                    </article>
                </div>

                <h2>Sport</h2>
                <div class="news-section">
                    <article>
                        <img src="uploads/broz.jpg" alt="WM-Stadion Qatar">
                        <h3>Erstes komplett neu gebautes WM-Stadion in Qatar eröffnet</h3>
                        <p>In Qatar ist am Donnerstag eines der ersten Stadien für die Fußball-WM 2022 eingeweiht worden. Ein ehemaliger niederländischer Nationalspieler ist besonders beeindruckt von der Spielstätte.</p>
                        <time datetime="2024-06-11">vor 1 Stunde</time>
                    </article>
                    <article>
                        <img src="uploads/mamic.jpg" alt="Handball">
                        <h3>Flensburg bleibt auf Meisterkurs</h3>
                        <p>Die SG Flensburg-Handewitt hat die Kieler abgewehrt und setzt die Jagd nach dem dritten Meistertitel fort. Gegen die MT Melsungen behaupten sie ihren Vorsprung in der Tabelle.</p>
                        <time datetime="2024-06-11">vor 2 Stunden</time>
                    </article>
                    <article>
                        <img src="uploads/modric.jpeg" alt="FCK">
                        <h3>Die nächste Volte des FCK</h3>
                        <p>Nach einer wochenlangen Hängepartie einigt sich der 1. FC Kaiserslautern nun doch auf eine Zusammenarbeit mit dem luxemburgischen Investoren Flavio Becca. Der Aufsichtsratsvorsitzende Littig zieht daraufhin ungedacht Konsequenzen.</p>
                        <time datetime="2024-06-11">vor 2 Stunden</time>
                    </article>
                </div>
        </section>
        <?php
    if ($result->num_rows > 0) {
        // Prikaz svake vijesti
        while ($row = $result->fetch_assoc()) {
            echo '<div class="container">';
            echo '<div class="news-section">';
            echo '<article>';
            echo '<h2>' . htmlspecialchars($row["naslov"]) . '</h2>';
            if ($row["slika"] != 'Nema slike') {
                echo '<img src="' . htmlspecialchars($row["slika"]) . '" alt="Slika vijesti">';
            }
            echo '<p class="category">Kategorija: ' . htmlspecialchars($row["kategorija"]) . '</p>';
            echo '<p class="content">' . htmlspecialchars($row["sadrzaj"]) . '</p>';
            if ($row["arhiva"]) {
                echo '<p class="archive-status">Ova vijest je u arhivi.</p>';
            }
            echo '</article>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "<p>Nema vijesti za prikaz.</p>";
    }

    // Zatvaranje veze
    $conn->close();
    ?>
        <div class="novo">
            <a href="unos.php">NOVI CLANAK</a>
        </div>
</div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Frankfurter Allgemeine</p>
        </div>
    </footer>
</body>
</html>

