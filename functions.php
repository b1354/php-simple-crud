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

  function tambah ($data) {
    global $conn;

    // fungsi htmlspecialchars()
    // digunakan untuk mengahadle input user agar tidak dapat memasukan tag html kedalam database

    $nim = htmlspecialchars($data['nim']);
    $nama = htmlspecialchars($data['nama']);
    $email = htmlspecialchars($data['email']);
    $prodi = htmlspecialchars($data['prodi']);
    $gambar = htmlspecialchars($data['gambar']);

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

    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($conn);
  }

  function ubah($data, $id) {
    global $conn;

    $nim = htmlspecialchars($data['nim']);
    $nama = htmlspecialchars($data['nama']);
    $email = htmlspecialchars($data['email']);
    $prodi = htmlspecialchars($data['prodi']);
    $gambar = htmlspecialchars($data['gambar']);

    $query = "UPDATE mahasiswa 
              SET 
                nim = '$nim',
                nama = '$nama',
                email = '$email',
                prodi = '$prodi',
                gambar = '$gambar'
              WHERE id = $id";

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