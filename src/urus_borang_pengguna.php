<?php include('inc_header.php');
semaklevel('admin');
# Nilai awal pembolehubah untuk 'value' dalam borang.
$idPengguna = $password = $nama = $idKumpulan = "";
# Semak nilai POST daripada borang
if (isset($_POST['idPengguna'])) {
    $idPengguna = trim($_POST['idPengguna']);
    $password = trim($_POST['password']);
    $nama = trim($_POST['nama']);
    $idKumpulan = $_POST['idKumpulan'];

    $sql = "INSERT IGNORE INTO pengguna (idPengguna, password, nama, idKumpulan) 
     VALUES ('$idPengguna', '$password', '$nama', $idKumpulan)";
    $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));
    echo "<script> alert('Berjaya disimpan.');
   window.location.replace('urus_senarai_pengguna.php'); </script>";
}  ?>
<h1 style="font-size:30px">Borang Maklumat Pengguna</h1>
<form method="POST" action="">
    <p><label>ID Pengguna</label><br>
        <input type='text' name='idPengguna' value='<?php echo $idPengguna; ?>' required><br>
    </p>
    <p><label>Katalaluan</label><br>
        <input type='password' name='password' value='<?php echo $password; ?>' required><br>
    </p>
    <p><label>Nama</label><br>
        <input type='text' name='nama' value='<?php echo $nama; ?>' required><br>
    </p>
    <p><label><?php echo $label_kumpulan; ?></label><br>
        <select name='idKumpulan' required>
            <option value='' disabled selected>Sila pilih</option>
            <?php
            $sql = "SELECT * FROM kumpulan ORDER BY namaKumpulan";
            $result = mysqli_query($db, $sql);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $rowkumpulan = $row['idKumpulan'];
                $namaKumpulan = $row['namaKumpulan'];
                if ($idKumpulan == $rowkumpulan) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                echo "<option $selected value='$rowkumpulan'>$namaKumpulan</option>";
            }   ?>
        </select>
    </p>
    <p> <input type="submit" value="Simpan"></p>
</form>
<?php include('inc_footer.php'); ?>;;
