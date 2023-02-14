<?php 
  require "functions.php";

  checkCookie($_COOKIE);
  checkSession("user_data", "index.php", true);

  if(isset($_POST["submit"])) {
    $login = login($_POST);

    if($login["message"] == "success") {
      header("Location: index.php");
    }

  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Datamahasiswa - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css"
    rel="stylesheet">
</head>

<body>
  <div class="container text-center py-5 mx-auto" style="max-width: 400px">
  <h1 class="my-3">Login</h1>

  <form action="" method="post" class="my-5">

    <p>
      <?php if(isset($login)): ?>
      <span class="text-danger"><?= $login["message"] ?></span>
      <?php endif ?>
    </p>
  
    <label for="username">Username: </label>
    <div class="input-group my-3">
      <div class="input-group-text"><span class="bi bi-person-fill"></span></div>
      <input class="form-control" type="text" name="username" id="username">
    </div>

    <label for="password">Password: </label>
    <div class="input-group my-3">
      <div class="input-group-text"><span class="bi bi-key-fill"></span></div>
      <input class="form-control" type="password" name="password" id="password">
    </div>
    
    
    <div class="form-check my-2 text-start">
      <input 
        type="checkbox" 
        id="showPw" 
        class="form-check-input"
      >
      <label for="showPw" class="form-check-label text-secondary">Show Password</label>
    </div>

    <div class="form-check my-2 text-start">
      <input 
        type="checkbox" 
        id="rememberMe" 
        name="rememberMe" 
        class="form-check-input"
      >
      <label for="rememberMe" class="form-check-label text-secondary">Remember Me</label>
    </div>

    <input type="submit" name="submit" value="Login" class="btn btn-primary my-5">
  </form>

  </div>
  
  <script type="text/javascript">
    
    // show password
    document.querySelector("#showPw").onchange = function (event) {
      // jangan gunakan arrow function
      // karena dengan menggunakan arrow function tidak dapat menggunakan keyword this
      document.querySelector("#password").type = this.checked ? "text" : "password"
    }
  </script>
</body>

</html>