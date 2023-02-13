<?php 
  include 'functions.php';

  checkCookie($_COOKIE);
  checkSession("user_data", "login.php");

  // ambil data di url
  $id =$_GET['id'];

  // cek apakah tombol delete image ditekan
  // if ( isset($_POST["deleteImg"]) ) {
  //   deleteImage($id);
  // }

  // karena hasil dari fungsi query adalah array, maka diambil index pertamanya
  // disimpan dibawah delete image agar mendapatkan perubahan terbaru jika didelete
  $mhs = query("SELECT * FROM mahasiswa WHERE id = $id ")[0];

  // cek apakah tombol submit sudah ditekan
  if ( isset($_POST["submit"]) ) {
    // cek apakah data berhasil diubah

    if ( $_POST["isGambarDeleted"] ) {
      deleteImage($id);
    }

    if ( ubah($_POST, $mhs['id']) >= 0 ) {
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
  <form action="" method="post" enctype="multipart/form-data">
    <label class="form-label" for="nim">nim: </label>
    <input type="text" name="nim" id="nim" class="form-control" value="<?= $mhs["nim"] ?>" required>

    <label class="form-label" for="nama">nama: </label>
    <input type="text" name="nama" id="nama" class="form-control" value="<?= $mhs["nama"] ?>" required>

    <label class="form-label" for="email">email: </label>
    <input type="text" name="email" id="email" class="form-control" value="<?= $mhs["email"] ?>" required>

    <label class="form-label" for="prodi">prodi: </label>
    <input type="text" name="prodi" id="prodi" class="form-control" value="<?= $mhs["prodi"] ?>" required>

    <label class="form-label m-0" for="gambar" style="display:block">gambar: 
      <img 
        src="images/<?= $mhs["gambar"] ?>"
        alt="<?= $mhs["nama"]?>"
        width="150" height="150"
        id="gambarMhs"
        style="object-fit: contain; display: block"
      >
    </label>
    
    <input type="hidden" name="isGambarDeleted" id="isGambarDeleted">
    <a class="btn btn-sm btn-danger my-3" name="deleteImg" id="deleteGambarMhs"><span class="bi bi-trash"></span>Delete gambar</a>
    <input type="file" name="gambar" id="gambar" class="form-control" accept="images/jpg images/jpg">

    <div class="my-3">
      <a href="index.php" class="btn btn-warning"><span class="bi bi-arrow-left-circle"></span> Kembali</a>
      <button class="btn btn-primary" type="submit" name="submit"><b>+</b> Simpan Perubahan </button></li>
    </div>

  </form>
  </div>

  
  <script>
    // script untuk merubah gambar sesuai input user
    let gambar = document.getElementById('gambar');
    let gambarMhs = document.getElementById('gambarMhs');
    let isGambarDeleted = document.getElementById('isGambarDeleted')
    let deleteGambarMhs = document.getElementById("deleteGambarMhs");

    deleteGambarMhs.onclick = function(ev) {
      isGambarDeleted.value = "true"
      gambar.value = ""
      gambarMhs.src = "images/default.png"
    }

    gambar.onchange = function (evt)  {
      const [file] = gambar.files;
      if (file) {
        gambarMhs.src = URL.createObjectURL(file);
      }
    }
  </script>
</body>
</html>
