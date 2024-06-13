<?php
session_start();

// Provjera dali je korisnik ulogiran
if (!isset($_SESSION['korisnik'])) {
  echo '<script>alert("Niste prijavljeni!"); window.location.href = "prijava.php";</script>';
  exit;
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Oglasi</title>
</head>

<body>
  <header>
    <br>
    <h1>Foto oglasi</h1>
    <br>
    <nav>
      <a href="home.php">Home</a>
      <a href="#">Oglasi</a>
      <a href="objavi.php">Objavi</a>
      <a href="prijava.php">Prijava</a>
      <a href="registracija.php">Registracija</a>
    </nav>
  </header>

  <section class="sekcija">
    <?php
    // Konekcija
    $dbc = mysqli_connect('localhost', 'root', '', 'registracija') or die('Error problem sa konekcijom!' . mysqli_connect_error());

    $query = "SELECT id, naziv, opis, cijena, slika FROM oglasi";
    $result = mysqli_query($dbc, $query);

    // Provjera ima li podataka u bazi
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<article>';
        echo '<img src="' . htmlspecialchars($row['slika']) . '" alt="' . htmlspecialchars($row['naziv']) . '" style="width:300px;height:auto;">';
        echo '<h2>' . htmlspecialchars($row['naziv']) . '</h2>';
        echo '<pre>' . htmlspecialchars($row['opis']) . '</pre>';
        echo '<p>Cijena: ' . htmlspecialchars($row['cijena']) . ' eura</p>';
        // Brisanje
        echo '<form method="post" action="index.php" style="display:inline;">';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
        echo '<button type="submit" name="delete" onclick="return confirm(\'Sigurno brisete?\')">Delete</button>';
        echo '</form>';
        // Savljena maska i iskoristena za upload
        echo '<form method="post" action="home.php" style="display:inline;">';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
        echo '<input type="hidden" name="naziv" value="' . htmlspecialchars($row['naziv']) . '">';
        echo '<input type="hidden" name="opis" value="' . htmlspecialchars($row['opis']) . '">';
        echo '<input type="hidden" name="cijena" value="' . htmlspecialchars($row['cijena']) . '">';
        echo '<input type="hidden" name="slika" value="' . htmlspecialchars($row['slika']) . '">';
        echo '<button type="submit" name="upload">Upload</button>';
        echo '</form>';
        echo '</article>';
      }
    } else {
      echo '<p>Nema se sto prikazati!</p>';
    }

    // Funkcija za brisanje
    if (isset($_POST['delete'])) {
      $id = $_POST['id'];
      // Deleting from oglasi
      $stmt = $dbc->prepare("DELETE FROM oglasi WHERE id = ?");
      $stmt->bind_param("i", $id);
      if ($stmt->execute()) {
        // Deleting from home_ads
        $stmt2 = $dbc->prepare("DELETE FROM home_ads WHERE id = ?");
        $stmt2->bind_param("i", $id);
        if ($stmt2->execute()) {
          echo '<script>alert("Obrisano."); window.location.href = "index.php";</script>';
        } else {
          echo '<script>alert("Problem kod brisanja iz home_ads.");</script>';
        }
        $stmt2->close();
      } else {
        echo '<script>alert("Problem kod brisanja iz oglasi.");</script>';
      }
      $stmt->close();
    }

    mysqli_close($dbc);
    ?>
  </section>

  <footer>
    <p>© 2024 Copyright: RB</p>
  </footer>

</body>

</html>
