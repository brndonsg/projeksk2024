<?php
# Database info
$dbname = 'projeksk';
$dbuser = 'root';
$dbpass = '';
$dbhost = 'localhost';
# Open connection to database
$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)
    or die(mysqli_connect_error());


$label_kumpulan = 'Jabatan';

$label_mata = 'Mata';

# Starts session
session_start();
# Session to store and read text size
if (isset($_SESSION['fontsize'])) {
    $fontsize = $_SESSION['fontsize'];
} else {
    $fontsize = 100;
}
if (isset($_GET['font'])) {
    if ($_GET['font'] == 'plus') {
        $fontsize += 1;
    } elseif ($_GET['font'] == 'minus') {
        $fontsize -= 1;
    } else {
        $fontsize = 100;
    }
    $_SESSION['fontsize'] = $fontsize;
    die('<script>window.history.go(-1);</script>');
}

if (!isset($_SESSION['idPengguna'])) {
    $_SESSION['level'] = 'visitor';
}
$level = $_SESSION['level'];

# Check if time ran out
function semakmasa($masa)
{
    if (strtotime('now') < strtotime($masa)) {
        return true;
    } else {
        return false;
    }
}
# FUNCTION : Check user level
function semaklevel($akses)
{
    $level = $_SESSION['level'];
    $error = '';

    if ($level == 'visitor') {
        $error = 'Anda perlu log masuk untuk akses halaman ini.';
    } elseif ($level == 'user'  &&  $akses == 'admin') {
        $error = 'Hanya akaun Pengurus boleh mengakses halaman ini.';
    } elseif ($level == 'admin'  &&  $akses == 'user') {
        $error = 'Hanya akaun Pengguna biasa boleh mengakses halaman ini.';
    }

    if (!empty($error)) {
        echo "<script> alert('$error'); 
            window.location.replace('index.php'); </script>";
        die();
    }
}
