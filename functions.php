<?php 
  mysqli_report(MYSQLI_REPORT_OFF);

  $conn = mysqli_connect("localhost", "bayu", "bayurizky1354", "db_data_mahasiswa");

  function query($query) {
    // diperlukan keyword global untuk mengakses variabel global
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];

    if ( !$result ) {
      // var_dump($conn);
      return "terjadi kesalahan saat query ke database";
    }

    while ( $row = mysqli_fetch_assoc($result) ) {
      $rows[] = $row;
    }

    return $rows;
  }

  function uploadImage ( $data, $path ) {
    $result = [];
    $tmp_name = explode(".", $data["name"]);
    $fileExtension = end( $tmp_name );
    $fileName = uniqid(rand(), true) . "." . $fileExtension;

    if($data["error"] == 4)  {
      $fileName = "default.png";
      return $fileName;
    }

    if($data["size"] > 500000 ) {
      $result["error"] = true;
      $result["message"] = "ukuran gambar terlalu besar";
      return $result;
    }

    move_uploaded_file($data["tmp_name"], $path."/".$fileName);
    return $fileName;
  }

  function deleteImage($id) {
    global $conn;

    $query = "UPDATE mahasiswa SET gambar='default.png' WHERE id=$id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
  }

  function tambah ($data) {
    global $conn;

    // fungsi htmlspecialchars()
    // digunakan untuk mengahadle input user agar tidak dapat memasukan tag html kedalam database

    $nim = htmlspecialchars($data['nim']);
    $nama = htmlspecialchars($data['nama']);
    $email = htmlspecialchars($data['email']);
    $prodi = htmlspecialchars($data['prodi']);

    $gambar = uploadImage($_FILES['gambar'], "images");

    $query = "INSERT INTO mahasiswa
                (nim, nama, email, prodi, gambar)
              VALUES
                ('$nim', '$nama', '$email', '$prodi', '$gambar')
            ";
    
    mysqli_query($conn, $query);

    // affected rows digunakan untuk mengecek apakah query yang dijalan
    // mempengaruhi sebuah/beberapa rows atau tidak
    return mysqli_affected_rows($conn);
  }

  function hapus ($id) {
    global $conn;

    $mahasiswa = query("SELECT gambar FROM mahasiswa WHERE id=$id")[0]['gambar'];

    if ($mahasiswa != "default.png") {
      unlink("images/$mahasiswa");
    }

    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($conn);
  }

  function ubah($data, $id) {
    global $conn;

    $nim = htmlspecialchars($data['nim']);
    $nama = htmlspecialchars($data['nama']);
    $email = htmlspecialchars($data['email']);
    $prodi = htmlspecialchars($data['prodi']);
    
    if ($_FILES["gambar"]["error"] != 4) {
      $gambarLama = query("SELECT * FROM mahasiswa WHERE id=$id")[0]["gambar"];
      $gambarBaru = uploadImage($_FILES["gambar"], "images");
      $query = "UPDATE mahasiswa
                SET
                  nim = '$nim',
                  nama = '$nama',
                  email = '$email',
                  prodi = '$prodi',
                  gambar = '$gambarBaru'
                WHERE id = $id";
      if ($gambarLama != "default.png") {
        unlink("images/$gambarLama");
      }
    } else {
      $query = "UPDATE mahasiswa 
              SET 
                nim = '$nim',
                nama = '$nama',
                email = '$email',
                prodi = '$prodi',
              WHERE id = $id";
    }

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
  }

  function cari ($data) {
    global $conn;

    $query = "SELECT * FROM mahasiswa 
              WHERE 
                nama LIKE '%$data%' OR
                nim LIKE '%$data%' OR
                email LIKE '%$data%' OR
                prodi LIKE '%$data%'
              ";
    
    return query($query);

  }

?>
