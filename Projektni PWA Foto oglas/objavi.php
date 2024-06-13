<?php
session_start();

// Provjera dali je korisnik ulogiran
if (!isset($_SESSION['korisnik'])) {
  echo '<script>alert("Niste prijavljeni!"); window.location.href = "prijava.php";</script>';
  exit;
}

// Logout i vracanje na prijavu
if (isset($_POST['logout'])) {
  $_SESSION = array();
  session_destroy();
  echo '<script>alert("Uspjesno ste se odjavili."); window.location.href = "prijava.php";</script>';
  exit;
}
// Konekcija
$dbc = mysqli_connect('localhost', 'root', '', 'registracija') or die('Error problem sa konekcijom!' . mysqli_connect_error());

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $naziv = $_POST['naziv'];
  $opis = $_POST['opis'];
  $cijena = $_POST['cijena'];

  // Upload slike
  $target_dir = "slike/";
  $target_file = $target_dir . basename($_FILES["slika"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  // Provjera slike
  $check = getimagesize($_FILES["slika"]["tmp_name"]);
  if ($check !== false) {
    $uploadOk = 1;
  } else {
    echo '<script>alert("File nije slika!");</script>';
    $uploadOk = 0;
  }

  if (file_exists($target_file)) {
    echo '<script>alert("Slika vec postoji!");</script>';
    $uploadOk = 0;
  }

  // Provjera velicine slike
  if ($_FILES["slika"]["size"] > 5000000) {
    echo '<script>alert("Slika ne smije biti preko 5mb!");</script>';
    $uploadOk = 0;
  }

  // Formati slike
  if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
  ) {
    echo '<script>alert("Samo JPG, JPEG, PNG ili GIF.");</script>';
    $uploadOk = 0;
  }

  if ($uploadOk == 0) {
    echo '<script>alert("Problem s uploadom.");</script>';
  } else {
    if (move_uploaded_file($_FILES["slika"]["tmp_name"], $target_file)) {
      echo '<script>alert("File ' . basename($_FILES["slika"]["name"]) . ' uploadan!");</script>';
      $stmt = $dbc->prepare("INSERT INTO oglasi (naziv, opis, cijena, slika) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssds", $naziv, $opis, $cijena, $target_file);

      if ($stmt->execute()) {
        echo '<script>alert("Oglas uspjesno objavljen!"); window.location.href = "index.php";</script>';
      } else {
        echo '<script>alert("Error: ' . $stmt->error . '");</script>';
      }

      $stmt->close();
    } else {
      echo '<script>alert("Problem s uploadom!");</script>';
    }
  }
}

$dbc->close();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Objavi</title>
</head>

<body>
  <header>
    <br>
    <h1>Foto oglasi</h1>
    <br>
    <nav>
      <a href="home.php">Home</a>
      <a href="index.php">Oglasi</a>
      <a href="#">Objavi</a>
      <a href="prijava.php">Prijava</a>
      <a href="registracija.php">Registracija</a>
    </nav>
  </header>

  <section>
    <h2 class="centriraj">Objavi oglas</h2>
    <br>
    <form class="forma" name="oglasForm" onsubmit="return validiraj()" method="post" enctype="multipart/form-data">
      <div>
        <label for="slika">Slika:</label>
        <input type="file" name="slika" accept="image/*" required>
      </div>
      <br>
      <div>
        <label for="naziv">Naziv:</label>
        <input type="text" name="naziv" required>
      </div>
      <br>
      <div>
        <p>Opis:</p>
        <label for="opis"></label>
        <textarea name="opis" rows="25" cols="30" required></textarea>
      </div>
      <br>
      <div>
        <label for="cijena">Cijena:</label>
        <input type="number" name="cijena" step="0.01" required>
      </div>
      <br>
      <button type="submit">Submit</button>
      </div>
    </form>
    <br>

    <form method="post">
      <button type="submit" name="logout">Odjava</button>
    </form>
  </section>

  <footer>
    <p>© 2024 Copyright: RB</p>
  </footer>

  <script>
    function validiraj() {
      var slika = document.forms["oglasForm"]["slika"].files[0];
      var naziv = document.forms["oglasForm"]["naziv"].value;
      var opis = document.forms["oglasForm"]["opis"].value;
      var cijena = document.forms["oglasForm"]["cijena"].value;
      var allowedExtensions = ["jpg", "jpeg", "png", "gif"];
      var fileExtension = slika.name.split('.').pop().toLowerCase();
      var maxFileSize = 5 * 1024 * 1024;

      if (!allowedExtensions.includes(fileExtension)) {
        alert("Mora biti JPG, JPEG, PNG, ili GIF!.");
        return false;
      }

      if (slika.size > maxFileSize) {
        alert("Slika ne smije biti veca od 5MB.");
        return false;
      }

      if (naziv.trim() == "") {
        alert("Naziv!.");
        return false;
      }

      if (opis.trim() == "" || opis.length < 10) {
        alert("Opis!");
        return false;
      }

      if (isNaN(cijena) || cijena <= 0) {
        alert("Cijena!");
        return false;
      }

      return true;
    }
  </script>
</body>

</html>