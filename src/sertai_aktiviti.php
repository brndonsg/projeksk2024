<?php include('inc_header.php');
semaklevel('user');

if (isset($_GET['id']) && isset($_GET['action'])) {

    $idAktiviti = $_GET['id'];
    $action = $_GET['action'];
    $idPengguna = $_SESSION['idPengguna'];

    if ($action == 'add') {

        $sql = "INSERT IGNORE INTO hadir (idPengguna, idAktiviti)  VALUES ('$idPengguna', '$idAktiviti')";

        $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));
        echo "<script> alert('Anda berjaya mendaftar untuk aktiviti ini.'); </script>";
    } elseif ($action == 'remove') {

        $sql = "DELETE FROM hadir WHERE idPengguna = $idPengguna AND idAktiviti = $idAktiviti";
        $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));
        echo "<script> alert('Aktiviti telah dikeluarkan daripada rekod.'); </script>";
    }
} else {
    echo "<script> alert('Parameter GET tidak lengkap.'); </script>";
}
echo "<script>window.location.replace('profil_pengguna.php');</script>";

include('inc_footer.php');
