<?php

session_start();

session_unset();

session_destroy();


echo "<script>
    alert('Log keluar berjaya.');
    window.location.replace('index.php');
  </script>";
?>
