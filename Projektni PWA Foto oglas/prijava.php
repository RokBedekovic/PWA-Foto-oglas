<?php
session_start();

// Konekcija
$dbc = mysqli_connect('localhost', 'root', '', 'registracija') or die('Error problem sa konekcijom!' . mysqli_connect_error());

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $korisnik = $_POST['korisnik'];
  $lozinka = $_POST['lozinka'];

  // Vracanje zamaskirane lozinke
  $stmt = $dbc->prepare("SELECT lozinka FROM korisnici WHERE korisnik = ?");
  $stmt->bind_param("s", $korisnik);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows == 1) {
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if (password_verify($lozinka, $hashed_password)) {
      $_SESSION['korisnik'] = $korisnik;
      header("Location: objavi.php");
      exit;
    } else {
      echo '<script>alert("Neispravna lozinka!");</script>';
    }
  } else {
    echo '<script>alert("Korisnik ne postoji!");</script>';
  }

  $stmt->close();
}

$dbc->close();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Prijava</title>
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
      <a href="#">Prijava</a>
      <a href="registracija.php">Registracija</a>
    </nav>
  </header>

  <section>
    <br>
    <br>
    <br>
    <h2 class="centriraj">Prijava</h2>
    <br>
    <form class="forma2" name="loginForm" onsubmit="return validiraj()" method="post" enctype="multipart/form-data">
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
      var korisnik = document.forms["loginForm"]["korisnik"].value;
      var lozinka = document.forms["loginForm"]["lozinka"].value;

      if (korisnik == "" || lozinka == "") {
        alert("Svi obrasci moraju bit ispunjeni!");
        return false;
      }
      return true;
    }
  </script>
</body>

</html>