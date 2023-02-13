<?php 
  include 'functions.php';

  checkCookie($_COOKIE);
  checkSession("user_data", "login.php");

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

    <label class="form-label m-0" for="gambar" style="display:block">gambar: 
      <img 
        src="images/default.png"
        width="150" height="150"
        id="gambarMhs"
        style="object-fit: contain; display: block"
      >
    </label>
    <a class="btn btn-sm btn-danger my-3" id="deleteGambarMhs"><span class="bi bi-trash"></span>Hapus gambar</a>
    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/jpg image/png">

    <div class="my-3">
      <a href="index.php" class="btn btn-warning"><span class="bi bi-arrow-left-circle"></span> Kembali</a>
      <button class="btn btn-primary" type="submit" name="submit"><b>+</b> Tambah Data</button></li>
    </div>
    
  </form>
  </div>

  <script type="text/javascript">
    let gambarMhs = document.getElementById("gambarMhs")
    let gambar = document.getElementById("gambar")
    let deleteGambarMhs = document.getElementById("deleteGambarMhs")

    deleteGambarMhs.onclick = function(ev) {
      gambar.value = ""
      gambarMhs.src = "images/default.png"
    }

    gambar.onchange = function(ev) {
      const [file] = gambar.files
      if (file) {
        gambarMhs.src = URL.createObjectURL(file)
      }
    }
  </script>

</body>
</html>