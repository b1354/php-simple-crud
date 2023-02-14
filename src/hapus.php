<?php 
  include 'functions.php';

  checkCookie($_COOKIE);
  checkSession("user_data", "login.php");
  
  if (!isset($_GET["id"])) {
    header("Location: index.php");
  }
    
  $id = $_GET["id"];

  if ( hapus($id) > 0 ) {
    echo "
        <script>
          document.location.href = 'index.php'; 
          alert('data berhasil dihapus');
        </script>
      ";
  } else {
    echo "
        <script>
          document.location.href = 'index.php';  
          alert('data gagal dihapus');
        </script>
      ";
  }
?>
