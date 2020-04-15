 <?php
session_start();
include ("/var/db/dbconfig.php");
include('errors.php');

$username = "";
$email    = "";
$errors = array(); 

if (isset($_POST['reg_user'])) 
{
  $nume = mysqli_real_escape_string($db, $_POST['nume']);
  $prenume = mysqli_real_escape_string($db, $_POST['prenume']);

  $email = mysqli_real_escape_string($db, $_POST['email']);
  $email = filter_var($email, FILTER_SANITIZE_EMAIL);

  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  $judet = mysqli_real_escape_string($db, $_POST['judet']);
  $oras = mysqli_real_escape_string($db, $_POST['oras']);

  $adresa = mysqli_real_escape_string($db, $_POST['adresa']);
  $nume_afacere = mysqli_real_escape_string($db, $_POST['nume_afacere']);


  if (empty($nume)) { array_push($errors, "Name is required"); }
  if (empty($prenume)) { array_push($errors, "Vorname is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if (empty($password_2)) { array_push($errors, "Confirm Password is required"); }
  if (empty($judet)) { array_push($errors, "County is required"); }
  if (empty($oras)) { array_push($errors, "City is required"); }
  if (empty($adresa)) { array_push($errors, "Address is required"); }
  if (empty($nume_afacere)) { array_push($errors, "Business Name is required"); }


  if ($password_1 != $password_2)
    array_push($errors, "The passwords do not match");

  $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user)
    if ($user['email'] === $email)
        array_push($errors, "Email already exists");

  if (count($errors) == 0) 
  {
    //$password_h = password_hash($password_1, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (email, password, nume, prenume, judet, oras, adresa, nume_afacere) 
              VALUES('$email', '$password_1', '$nume', '$prenume', '$judet', '$oras', '$adresa', '$nume_afacere')";
    mysqli_query($db, $query);
    $_SESSION['nume_sesiune'] = $nume;
    $_SESSION['success'] = "You are now logged in";
    header('location: index.html');
  }
}

if (isset($_POST['login_user'])) 
{
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $email = filter_var($email, FILTER_SANITIZE_EMAIL);

  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);

  if (empty($email)) { array_push($errors, "Username is required"); }
  if (empty($password)) { array_push($errors, "Password is required"); }

  if (count($errors) == 0) 
  {
    //$password_h = password_hash($password, PASSWORD_DEFAULT);
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password_1'";
    $results = mysqli_query($db, $query);

    if (mysqli_num_rows($results) == 1) 
    {
      $_SESSION['nume_sesiune'] = $nume;
      $_SESSION['success'] = "You are now logged in";
      header('location: index.html');
    }
    else 
      array_push($errors, "Wrong email/password combination");
  }
}


if (isset($_POST['adauga_anunt'])) 
{
  $oras = mysqli_real_escape_string($db, $_POST['oras']);
  $de_cand = mysqli_real_escape_string($db, $_POST['de_cand']);
  $descriere = mysqli_real_escape_string($db, $_POST['descriere']);
  $pana_cand = mysqli_real_escape_string($db, $_POST['pana_cand']);
  $talie = mysqli_real_escape_string($db, $_POST['talie']);


  $username=$_SESSION['username'];

  if (empty($oras)) { array_push($errors, "Specificati un oras"); }
  if (empty($de_cand)) { array_push($errors, "Specificati de cand"); }
  if (empty($descriere)) { array_push($errors, "Descrieti anuntul"); }
  if (empty($pana_cand)) { array_push($errors, "Specificati pana cand"); }
  if (empty($talie)) { array_push($errors, "Specificati talia animalului"); }

  if($pana_cand<=$de_cand)
  {
    array_push($errors,"Perioada invalida");
  }

  if (count($errors) == 0) 
  {
    $query = "INSERT INTO animal (oras, de_cand, pana_cand, talie, user, descriere) 
          VALUES('$oras', '$de_cand', '$pana_cand', '$talie', '$username', '$descriere')";
    mysqli_query($db, $query);
    echo "<script type='text/javascript'>
          alert('Anunt adaugat cu succes.');
          window.location = '/Hackathon/index2.php';
          </script>";
  }
}

?>