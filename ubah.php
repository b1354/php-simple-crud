<?php 
  include 'functions.php';

  // ambil data di url
  $id =$_GET['id'];

  // karena hasil dari fungsi query adalah array, maka diambil index pertamanya
  $mhs = query("SELECT * FROM mahasiswa WHERE id = $id ")[0];

  // cek apakah tombol submit sudah ditekan
  if ( isset($_POST["submit"]) ) {
    // cek apakah data berhasil diubah
    if ( ubah($_POST, $mhs['id']) > 0 ) {
      echo "
        <script>
          document.location.href = 'index.php';
          alert('data berhasil di ubah');
        </script>
      ";
    } else {
      $query_error = mysqli_error($conn);
      echo "
        <script>
          document.location.href = 'index.php';
          alert('data gagal diubah');
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
  <title>Ubah data mahasiswa</title>
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
</head>

<body>
  <div class="container">
  <h1 class="text-center my-5">Ubah data mahasiswa</h1>
  <form action="" method="post">
    <label class="form-label" for="nim">nim: </label>
    <input type="text" name="nim" id="nim" class="form-control" value="<?= $mhs["nim"] ?>" required>

    <label class="form-label" for="nama">nama: </label>
    <input type="text" name="nama" id="nama" class="form-control" value="<?= $mhs["nama"] ?>" required>

    <label class="form-label" for="email">email: </label>
    <input type="text" name="email" id="email" class="form-control" value="<?= $mhs["email"] ?>" required>

    <label class="form-label" for="prodi">prodi: </label>
    <input type="text" name="prodi" id="prodi" class="form-control" value="<?= $mhs["prodi"] ?>" required>

    <label class="form-label" for="gambar">gambar: </label>
    <input type="text" name="gambar" id="gambar" class="form-control" value="<?= $mhs["gambar"] ?>" required>

    <br>

    <button class="btn btn-primary" type="submit" name="submit"><b>+</b> Tambah data</button></li>
  </form>
  </div>
</body>
</html>