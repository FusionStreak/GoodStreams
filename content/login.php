<?php
require $_SERVER['DOCUMENT_ROOT'] . '/include/db.php';

function logout()
{
  /* $database = new DB();
  $database->logout($_SESSION['email'], $_SESSION['token']); */
  print session_unset();
  // Destroy the session
  print session_destroy();
}

if (isset($_GET['logout'])) {
  logout();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $database = new DB();
  $token = $database->login($email, $password);
  if ($token) {
    $_SESSION['email'] = $email;
    $_SESSION['token'] = $token;
  }
}

if (isset($_SESSION['email'])) : // Display the welcome message and logout button 
?>

  <h2>Welcome <?php print $_SESSION['email'] ?> !</h2>

<?php else : // Display the login form 
?>

  <h2>Login Page</h2>
  <?php if (isset($error)) : ?>
    <p><?= $error ?></p>
  <?php endif; ?>
  <form action="?page=login" method="post">
    <label for="email">Email</label>
    <input type="email" id="email" name="email"><br>
    <label for="password">Password</label>
    <input type="password" id="password" name="password"><br>

    <input type="submit" value="Login">
  </form>

  <p>Dont have an account yet? <a href="?page=registration">Register here</a></p>
<?php endif; ?>