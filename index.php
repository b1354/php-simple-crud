<?php 
  // include functions.php;
  require 'functions.php';

  checkCookie($_COOKIE);
  checkSession("user_data", "login.php");
  
  if ( isset($_GET["submit"]) && $_GET["keyword"] ) {
    $mahasiswa = cari($_GET["keyword"]);
  } else {
    $mahasiswa = query("SELECT * FROM mahasiswa");
  };

  $jumlahMhs = mysqli_affected_rows($conn);
  
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Data Mahasiswa - Halaman Admin</title>

  <!-- Bootstrap & Bootstrap icon -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css"
    rel="stylesheet">

  <!-- Bootstrap js & popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>


</head>

<body>
  <div class="wrapper">

    <header>
      <nav class="navbar navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
          <a href="index.php" class="navbar-brand fw-bold">
            <span class="bi bi-bootstrap-fill"></span>
            Data Mahasiswa
          </a>

          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offCanvasNav"
            aria-controls="navColl" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="offcanvas offcanvas-end text-dark" tabindex="-1" id="offCanvasNav" aria-labelledby="offCanvasNavLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title">User</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav text-center">
                <li class="nav-item ">
                  <h3><?= $_SESSION["user_data"]["username"] ?></h3>
                </li>
                <li class="nav-item">
                  <img src="images/default.png" alt="avatar" width="100" height="100" style="border-radius: 50%;">
                </li>
                <li class="nav-item">
                  <a href="logout.php" class="btn btn-danger my-3"> Logout </a>
                </li>
              </ul>
            </div>

          </div>

        </div>
      </nav>
    </header>

    <div class="container pt-5">
      <h1 class="text-center m-5">Daftar Mahasiswa</h1>

      <form action="" method="get" class="mb-3">
        <label class="form-label" for="cari">Cari berdasarkan Nama, NIM, Email, Jurusan (kosongkan untuk manampilkan
          semua data):</label>
        <div class="input-group">
          <input type="text" name="keyword" id="cari" placeholder="masukan data..." class="form-control">
          <button type="submit" name="submit" class="btn btn-primary">
            <span class="bi bi-search"></span> Cari
          </button>
        </div>
      </form>

      <p>
        <a class="btn btn-sm btn-primary my-2" href="tambah.php"><b>+</b> Tambah data mahasiswa</a>
        <?php if(isset($_GET["submit"])) :?>
        <a class="btn btn-sm btn-warning my-2" href="/belajarphp/datamahasiswa/"><b><?= $jumlahMhs?></b> Bersihkan
          Search</a>
        <?php endif ?>
      </p>

      <div class="table-responsive">
        <table class="table table-striped table-hover text-nowrap">

          <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
          </tr>

          <?php $nomor = 1;?>
          <?php foreach ($mahasiswa as $row) : ?>
          <tr>
            <td scope="row"><?= $nomor ?></td>
            <td>
              <a class="btn btn-sm btn-primary" href="ubah.php?id=<?= $row["id"] ?>"><span
                  class="bi bi-pencil"></span></a>
              <a class="btn btn-sm btn-danger" href="hapus.php?id=<?= $row["id"] ?>"
                onclick="return confirm('apakah benar ingin menghapus?')"><span class="bi bi-trash"></span></a>
            </td>
            <td>
              <img width="100" height="100" src="images/<?= $row["gambar"]?>" alt="<?= $row["gambar"] ?>"
                style="object-fit: contain">
            </td>
            <td><?= $row["nim"] ?></td>
            <td><?= $row["nama"] ?></td>
            <td><?= $row["email"] ?></td>
            <td><?= $row["prodi"] ?></td>
          </tr>
          <?php $nomor++; ?>
          <?php endforeach; ?>

        </table>
        <?php if (!$jumlahMhs): ?>
        <p class="text-center text-secondary">tidak ada data yang tersedia</p>
        <?php endif ?>
      </div>
    </div>

    <div class="container-fluid mt-5 pt-5 pb-3 bg-dark" >
      <footer class="d-flex justify-content-center align-items-center p-2 text-light">
        <div class="align-items-center text-center">
          <p class="h4 fw-bold ">Data Mahasiswa</p>
          <p class="fw-bol">
            find me at github:
            <a class="text-decoration-none fw-bold text-light" href="https://github.com/b1354" target="blank">
              b1354 <span class="bi bi-github"></span>
            </a>
          </p>
          <span class="h1 bi bi-bootstrap-fill"></span>
          <p class="my-1">Powered By Bootstrap</p>
          <a class="text-decoration-none text-light" href="https://getbootstrap.com">getbootstrap.com</a>
        </div>
      </footer>
      <hr style="width: 100px; color: white; margin: 5px auto">
    </div>
  </div>

</body>

</html>