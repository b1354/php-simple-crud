<?php 
  // include functions.php;
  require 'functions.php';

  if ( isset($_GET["submit"]) && $_GET["keyword"] ) {
    $mahasiswa = cari($_GET["keyword"]);
  } else {
    $mahasiswa = query("SELECT * FROM mahasiswa");
  };
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Halaman Admin</title>

  <link rel="stylesheet" href="style.css">
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

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <div class="container">
    <h1 class="text-center m-5">Daftar Mahasiswa</h1>

    <form action="" method="get" class="mb-3">
        <label class="form-label" for="cari">Cari berdasarkan Nama, NIM, Email, Jurusan (kosongkan untuk manampilkan semua data):</label>
        <div class="input-group">
          <input 
            type="text"
            name="keyword"
            id="cari"
            placeholder="masukan data..."
            class="form-control"
          >
          <button type="submit" name="submit" class="btn btn-primary">
            <span class="bi bi-search"></span> Cari
          </button>
        </div>
    </form>

    <p><a class="btn btn-sm btn-primary my-2" href="tambah.php"><b>+</b> Tambah data mahasiswa</a></p>

    <div class="table-responsive">
      <table class="table table-striped table-hover">

        <tr>
          <th scope="col">No.</th>
          <th scope="col">Aksi</th>
          <th scope="col">Gambar</th>
          <th scope="col">NIM</th>
          <th scope="col">Nama</th>
          <th scope="col">Email</th>
          <th scope="col">Jurusan</th>
        </tr>

        <?php $nomor = 1;?>
        <?php foreach ($mahasiswa as $row) : ?>
        <tr>
          <td scope="row"><?= $nomor ?></td>
          <td>
            <a 
              class="btn btn-sm btn-primary"
              href="ubah.php?id=<?= $row["id"] ?>"
            ><span class="bi bi-pencil"></span></a>
            <a 
              class="btn btn-sm btn-danger" 
              href="hapus.php?id=<?= $row["id"] ?>" 
              onclick="return confirm('apakah benar ingin menghapus?')"
            ><span class="bi bi-trash"></span></a>
          </td>
          <td><img width="200" src="<?= $row["gambar"]?>" alt="<?= $row["gambar"] ?>"></td>
          <td><?= $row["nim"] ?></td>
          <td><?= $row["nama"] ?></td>
          <td><?= $row["email"] ?></td>
          <td><?= $row["prodi"] ?></td>
        </tr>
        <?php $nomor++; ?>
        <?php endforeach; ?>

      </table>
    </div>

  </div>
  </script>
</body>
</html>