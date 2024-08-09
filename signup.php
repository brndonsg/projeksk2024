<?php include('inc_header.php');
# To store user input
$idPengguna = $nama = $password = $idKumpulan = '';
# To store error messages
$error = '';

if (isset($_POST['idPengguna'])) {

    $idPengguna = trim($_POST['idPengguna']);
    $password = trim($_POST['password']);
    $nama = trim($_POST['nama']);
    $idKumpulan = $_POST['idKumpulan'];

    # Special character check for username
    if (preg_match('/[^a-zA-Z0-9]+/', $idPengguna)) {
        $error .= "ID pengguna tidak boleh menggunakan simbol. ";
    }
    if (empty($nama)  ||  empty($idPengguna)  ||  empty($password)) {
        $error .= "Sila isi semua ruang di borang pendaftaran. ";
    }

    $id_length = strlen($idPengguna);

    if ($id_length > 8) {
        $error .= "ID terlalu panjang. Maksima 8 aksara. ";
    }

    if ($id_length < 4) {
        $error .= "ID terlalu pendek. Minima 4 aksara. ";
    }

    $password_length = strlen($password);
    if ($password_length < 6) {
        $error .= "Katalaluan terlalu pendek. Minima 6 aksara. ";
    }

    if ($password_length > 24) {
        $error .= "Katalaluan terlalu panjang. Maksima 24 aksara. ";
    }

    $sql = "SELECT  *  FROM  pengguna  WHERE  idPengguna='$idPengguna'  LIMIT 1";
    $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));

    if (mysqli_num_rows($result) > 0) {
        $error .= "ID ($idPengguna) sudah digunakan, sila pilih ID berbeza.";
    }

    if (empty($error)) {
        $sql = "INSERT INTO pengguna (idPengguna, password, nama, idKumpulan) 
  VALUES ('$idPengguna', '$password', '$nama', $idKumpulan)";
        $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));
        echo "<script> 
  alert('Pendaftaran berjaya. Sila Log Masuk menggunakan ID ($idPengguna).');
      window.location.replace('login.php'); </script>";
        die();
    } else {
        echo "<script>alert('$error');</script>";
    }
}
?>
<table class="mainContent" width='400' height='300px' align='center' style="background-color:#0a7a73; border: 4px black solid; border-radius: 10px;">
    <tr>
        <td align='center'>
            <h2>Daftar Akaun</h2>
            <p>Jika anda sudah mempunyai akaun, klik <a href='login.php'>Log Masuk</a></p>
            <form method='POST' action=''>
                <label>ID Pengguna</label><br>
                <input type="text" name="idPengguna" value='<?php echo $idPengguna; ?>' required><br><br>
                <label>Katalaluan</label><br>
                <input type="password" name="password" value='<?php echo $password; ?>' required><br><br>
                <label>Nama</label><br>
                <input type="text" name="nama" value='<?php echo $nama; ?>' required><br>
                <p>
                    <label><?php echo $label_kumpulan; ?></label><br>
                    <select name='idKumpulan' required>
                        <option value='' disabled selected>Sila pilih</option>
                        <?php

                        $sql = "SELECT * FROM kumpulan ORDER BY namakumpulan";
                        $result = mysqli_query($db, $sql);

                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

                            $rowkumpulan = $row['idKumpulan'];
                            $namakumpulan = $row['namaKumpulan'];

                            if ($idKumpulan == $rowkumpulan) {
                                $selected = "selected";
                            } else {
                                $selected = "";
                            }
                            echo "<option $selected  value='$rowkumpulan'>$namakumpulan</option>";
                        }
                        ?>
                    </select>
                </p>
                <input type="submit" name='signup' value="Daftar">
            </form>
        </td>
    </tr>
</table>

<?php include('inc_footer.php');  ?>