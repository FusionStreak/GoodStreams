<?php 
session_start();
require_once 'db.php';

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   $email = $_POST['email'];
//   $password = $_POST['password'];

//   $database = new DB();
// }
// ?>

<body>
  <h2>Login Page</h2>
  <?php if (isset($error)): ?>
    <p><?= $error ?></p>
  <?php endif; ?>
  <form action="login.php" method="post">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email"><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br>

    <input type="submit" value="Login">
  </form>

  <p>Don't have an account yet? <a href="registration.php">Register here</a></p>
</body>


