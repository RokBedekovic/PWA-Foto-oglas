<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Home</title>
</head>

<body>
  <header>
    <br>
    <h1>Foto oglasi</h1>
    <br>
    <nav>
      <a href="#">Home</a>
      <a href="index.php">Oglasi</a>
      <a href="objavi.php">Objavi</a>
      <a href="prijava.php">Prijava</a>
      <a href="registracija.php">Registracija</a>
    </nav>
  </header>

  <section class="sekcija">
    <?php
    // Konekcija
    $dbc = mysqli_connect('localhost', 'root', '', 'registracija') or die('Error problem sa konekcijom!' . mysqli_connect_error());

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload'])) {
      $id = $_POST['id'];
      $naziv = $_POST['naziv'];
      $opis = $_POST['opis'];
      $cijena = $_POST['cijena'];
      $slika = $_POST['slika'];

      // Provjera dali vec postoji u home_ads tablici u bazi podataka
      $check_query = $dbc->prepare("SELECT id FROM home_ads WHERE id = ?");
      $check_query->bind_param("i", $id);
      $check_query->execute();
      $check_query->store_result();

      // Puni home_ads tablicu
      if ($check_query->num_rows == 0) {
        $stmt = $dbc->prepare("INSERT INTO home_ads (id, naziv, opis, cijena, slika) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issds", $id, $naziv, $opis, $cijena, $slika);
        if ($stmt->execute()) {
          echo '<script>alert("Uploadano!"); window.location.href = "home.php";</script>';
        } else {
          echo '<script>alert("Nije uploadano!");</script>';
        }
        $stmt->close();
      } else {
        echo '<script>alert("Vec postoji!.");</script>';
      }
      $check_query->close();
    }

    $query = "SELECT naziv, opis, cijena, slika FROM home_ads";
    $result = mysqli_query($dbc, $query);

    // Prikaz u article
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<article>';
        echo '<img src="' . htmlspecialchars($row['slika']) . '" alt="' . htmlspecialchars($row['naziv']) . '" style="width:300px;height:auto;">';
        echo '<h2>' . htmlspecialchars($row['naziv']) . '</h2>';
        echo '<pre>' . htmlspecialchars($row['opis']) . '</pre>';
        echo '<p>Cijena: ' . htmlspecialchars($row['cijena']) . ' eura</p>';
        echo '</article>';
      }
    } else {
      echo '<p>Nema se sto prikazati!</p>';
    }

    mysqli_close($dbc);
    ?>
  </section>

  <footer>
    <p>© 2024 Copyright: RB</p>
  </footer>

</body>

</html>