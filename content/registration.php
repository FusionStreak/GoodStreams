<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/include/db.php';
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $name = $_POST['name'];
  $database = new DB();
  $success = $database->create_user($email, $password, $name);
}

?>

<h2>Register for GoodStreams</h2>
<form action='?page=registration' method='post'>
  <form>
    <label for='name'> Name:</label>
    <input type='text' id='name' name='name' required>
    <label for='email'>Email:</label>
    <input type='email' id='email' name='email' required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br>
    <input type='submit' value='Register'>
  </form>
  <?php if ($success): 
    header("Location: ?page=login"); // redirect to the login page
    exit();
    ?>
  <?php endif; ?>