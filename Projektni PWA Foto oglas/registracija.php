<?php

// Konekcija
$dbc = mysqli_connect('localhost', 'root', '', 'registracija') or die('Error nemozete se registrirati' . mysqli_connect_error());

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $korisnik = $_POST['korisnik'];
  $lozinka = $_POST['lozinka'];

  // Provjera postoji li vec korisnik
  $check_stmt = $dbc->prepare("SELECT id FROM korisnici WHERE korisnik = ?");
  $check_stmt->bind_param("s", $korisnik);
  $check_stmt->execute();
  $check_stmt->store_result();
  if ($check_stmt->num_rows > 0) {
    ?>
    <script>
      alert("Korisnik vec postoji!");
      window.location.href = "registracija.php";
    </script>
    <?php
    $check_stmt->close();
    exit;
  }
  $check_stmt->close();

  // Zamaskirana lozinka
  $hashed_password = password_hash($lozinka, PASSWORD_BCRYPT);

  $stmt = $dbc->prepare("INSERT INTO korisnici (korisnik, lozinka) VALUES (?, ?)");
  $stmt->bind_param("ss", $korisnik, $hashed_password);

  if ($stmt->execute()) {

    ?>
    <script>
      alert("Registracija uspjesna!");
    </script>
    <?php
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
  $dbc->close();
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Registracija</title>
</head>

<body>
  <header>
    <br>
    <h1>Foto oglasi</h1>
    <br>
    <nav>
      <a href="home.php">Home</a>
      <a href="index.php">Oglasi</a>
      <a href="objavi.php">Objavi</a>
      <a href="prijava.php">Prijava</a>
      <a href="#">Registracija</a>
    </nav>
  </header>

  <section>
    <br>
    <br>
    <br>
    <h2 class="centriraj">Registracija</h2>
    <br>
    <form class="forma2" name="registerForm" onsubmit="return validiraj()" method="post" enctype="multipart/form-data">
      <div>
        <label for="korisnik">Korisnik:</label>
        <input type="text" name="korisnik" required>
      </div>
      <br>
      <div>
        <label for="lozinka">Lozinka:</label>
        <input type="password" name="lozinka" required>
      </div>
      <br>
      <div>
        <button type="submit">Submit</button>
      </div>
    </form>
  </section>

  <footer>
    <p>© 2024 Copyright: RB</p>
  </footer>

  <script>
    function validiraj() {
      var korisnik = document.forms["registerForm"]["korisnik"].value;
      var lozinka = document.forms["registerForm"]["lozinka"].value;

      if (korisnik == "" || lozinka == "") {
        alert("Svi obrasci moraju bit ispunjeni!");
        return false;
      }

      if (korisnik.length < 3) {
        alert("U obrascu korisnik mora biti najmanje 3 znaka!");
        return false;
      }

      if (lozinka.length < 3) {
        alert("U obrascu lozinka mora biti najmanje 3 znaka!");
        return false;
      }

      return true;
    }
  </script>
</body>

</html>