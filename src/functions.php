<?php 
  session_start();
  mysqli_report(MYSQLI_REPORT_OFF);

  $conn = mysqli_connect("mysql", "datamahasiswa", "123", "datamahasiswa");

  function query($query) {
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];

    if ( !$result ) {
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
    $mahasiswa = query("SELECT gambar FROM mahasiswa WHERE id=$id")[0]['gambar'];

    if ($mahasiswa != "default.png" ) {
      unlink("images/$mahasiswa");
    }

    $query = "UPDATE mahasiswa SET gambar='default.png' WHERE id=$id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
  }

  function tambah ($data) {
    global $conn;

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

    return mysqli_affected_rows($conn);
  }

  function hapus ($id) {
    global $conn;

    $gambarMahasiswa = query("SELECT gambar FROM mahasiswa WHERE id=$id")[0]['gambar'];

    if ($gambarMahasiswa != "default.png") {
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
                prodi = '$prodi'
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

  function checkSession($value, $fallback, $isset=false) {
    if ($isset) {
      if( isset($_SESSION[$value]) ) {
        header("Location: $fallback");
        exit;
      }
    } else {
      if ( !isset($_SESSION[$value]) ) {
        header("Location: $fallback");
        exit;
      }
    }
  }

  function checkCookie($cookie) {
    if ( !isset($cookie['cookie_id']) || !isset($cookie['cookie_id']) ) {
      return false;
    }

    $userId = $cookie['cookie_id'];
    $username = $cookie['cookie_key'];
    $row = query("SELECT * FROM user WHERE id_user=$userId")[0];

    if ( hash("sha256", $row['username']) === $username ) {
      $_SESSION["user_data"] = $row;
      $_SESSION["login"] = true;
    }
    
  }

  function daftar($data) {
    global $conn;

    $error = [];

    $username = htmlspecialchars($data['username']);
    $email = htmlspecialchars($data['email']);
    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    if (strlen($data['password']) < 4) {
      $error[] = "password harus lebih dari 3 karakter";
    }

    $checkUser = query("SELECT username FROM user");

    foreach($checkUser as $user) {
      if($user["username"] == $username){
        $error[] = "username sudah diambil";
      }
    }

    if (count($error)) {
      return [ "message" => $error ];
    }

    $sql = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn)) {
      return [ "message" => "success" ];
    }

    $error["message"][] = "terjadi error saat register";
    return $error;
  }

  function login ($data) {
    global $conn;

    $username = $data["username"];
    $password = $data["password"];

    $row = query("SELECT * FROM user WHERE username='$username'")[0];
    $checkPw = password_verify($password, $row["password"]);
    
    if ( isset($row["username"]) && $checkPw ) {
      $_SESSION["user_data"] = $row;
      $_SESSION["login"] = true;

      if ( isset($_POST["rememberMe"]) ) {
        setcookie( 'cookie_id', $row['id_user'], time()+60*60*24*7 );
        setcookie( 'cookie_key', hash("sha256", $row['username']), time()+60*60*24*7 );
      }

      return [ "message" => "success" ];
    }

    if ($conn->error) {
      return [ "message" => "terjadi masalah saat login" ];
    }

    return [ "message" => "username atau password salah" ];
  }

  function pagination($limit, $query) {
    global $conn;

    $totalData = mysqli_num_rows( mysqli_query($conn, $query) );
    $jumlahHalaman = ceil($totalData/$limit);
    $currentPage = ( isset($_GET["page"]) ) ? $_GET["page"]:0;
    $indexHalaman = ($currentPage>1) ? ($currentPage-1)*$limit:0;

    return [
      'limit' => $limit,
      "totalData" => $totalData,
      "jumlahHalaman" => $jumlahHalaman,
      "indexHalaman" => $indexHalaman
    ];
  }

?>
