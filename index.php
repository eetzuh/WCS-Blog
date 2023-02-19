<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="./style.css">
  <title>Blog - Log In</title>
</head>

<body>
  <div class="inputFormContainer">
    <div class="inputForm">
      <form action="index.php" method="POST">
        <div class="formContainer">
          <input type="text" id="username" name="username" placeholder="username..." required>
          <input type="password" id="password" name="password" placeholder="password..." required>
          <div class="warning">
          <?php
          $json = file_get_contents("usersData.json");
          $keys = json_decode($json, true);
          if (isset($_POST["submit"])) {
            $userUsername = $_POST["username"];
            $userPassword = $_POST["password"];
            if ($userUsername !== $keys["username"] || $userPassword !== $keys["password"]) {
              echo "<p class='wrongInput'>Invalid username or password</p>";
            } else {
              header("Location: ./mainpage.php", true);
            }
          }
          ?>
          </div>
          <button type="submit" name="submit" class="submit btn btn-light">Log in</button>
        </div>
      </form>
    </div>
  </div>
  <style>
  <?php include "style.css" ?>
</style>
</body>

</html>