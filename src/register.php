<?php 
  require "functions.php";

  checkCookie($_COOKIE);
  // (variabel yang dicek, halaman yang dituju, isset(true/false))
  checkSession("user_data", "index.php", true);

  if(isset($_POST["submit"])) {
    $register = daftar($_POST);

    if($register["message"] == "success" ) {
      header('Location: index.php');
    }
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Datamahasiswa - Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css"
    rel="stylesheet">
</head>

<body>

  <div class="container text-center py-5 mx-auto" style="max-width: 400px">
    <h1 class="my-3">Register</h1>

    <?php if(isset($register["message"])): ?>
      <p class="my-4 text-danger">
      <?php foreach($register["message"] as $message): ?>
      <span><?= $message ?></span><br/>
      <?php endforeach ?>
      </p>
    <?php endif ?>

    <form class="my-5" action="" method="post">
    
    <label for="username">username:</label>
      <div class="input-group my-2">
        <span class="bi bi-person-fill input-group-text"></span>
        <input class="form-control" type="text" name="username" id="username" required>
      </div>

      <label for="email">email</label>
      <div class="input-group my-2">
        <span class="bi bi-envelope-at-fill input-group-text"></span>
        <input class="form-control" type="email" name="email" id="email" required>
      </div>

      <label for="password">password:</label>
      <div class="input-group my-2">
        <span class="bi bi-key-fill input-group-text"></span>
        <input class="form-control" type="password" name="password" id="password" autocomplete="off" required>
      </div>
      
      <div class="form-check my-2 text-start">
        <input class="form-check-input" type="checkbox" id="showPw" >
        <label class="form-check-label" for="showPw">show password</label>
      </div>

      <input class="btn btn-primary my-5" type="submit" name="submit" value="Register">
    </form>
  </div>

  <script type="text/javascript">
    // toogle display password
    document.querySelector("#showPw").onchange = function (evnt) {
      if(this.checked) {
        document.querySelector("#password").type = "text"
      } else {
        document.querySelector("#password").type = "password"
      }
    }
  </script>

</body>

</html>