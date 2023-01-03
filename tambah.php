<?php 
  include 'functions.php';

  // cek apakah tombol submit sudah ditekan
  if ( isset($_POST["submit"]) ) {
    if ( tambah($_POST) > 0 ) {
      echo "
        <script>
          alert('data berhasil ditambahkan');
          document.location.href = 'index.php';
        </script>
      ";
    } else {
      $query_error = mysqli_error($conn);
      echo "
        <script>
          alert('data gagal ditambahkan');
          document.location.href = 'tambah.php';
        </script>
      ";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" 
    rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
    crossorigin="anonymous"
  >
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css"
    rel="stylesheet"
  >
  <title>Tambah data mahasiswa</title>
</head>
<body>
  <div class="container">
  <h1 class="text-center my-5">Tambah data mahasiswa</h1>

  <!-- enctype = "multipart/form-data" dapat memisahkan mana yang akan dimasukan ke variabel $_POST dan $_FILES -->
  <form action="" method="post" enctype="multipart/form-data">
    <label class="form-label" for="nim">nim: </label>
    <input type="text" name="nim" id="nim" class="form-control" required>

    <label class="form-label" for="nama">nama: </label>
    <input type="text" name="nama" id="nama" class="form-control" required>

    <label class="form-label" for="email">email: </label>
    <input type="text" name="email" id="email" class="form-control" required>

    <label class="form-label" for="prodi">prodi: </label>
    <input type="text" name="prodi" id="prodi" class="form-control" required>

    <label class="form-label" for="gambar">gambar: </label>
    <input type="file" name="gambar" id="gambar" class="form-control" required>

    <br>

    <button class="btn btn-primary" type="submit" name="submit"><b>+</b> Tambah data</button></li>
  </form>
  </div>

</body>
</html>