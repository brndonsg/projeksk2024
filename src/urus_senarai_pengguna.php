<?php include('inc_header.php');
semaklevel('admin');

if (isset($_GET['delete'])) {
    $idPengguna = $_GET['delete'];

    $sql = "DELETE FROM pengguna WHERE  idPengguna = '$idPengguna' ";
    $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));
    echo "<script> alert('Akaun pengguna berjaya dibuang.');
   window.location.replace('urus_senarai_pengguna.php'); </script>";
    die();
}

if (isset($_POST['idAktiviti'])  &&  isset($_POST['sertai'])) {
    $idAktiviti = $_POST['idAktiviti'];
    foreach ($_POST['sertai'] as $idPengguna) {
        $sql = "INSERT IGNORE INTO hadir (idPengguna, idAktiviti) 
   VALUES ('$idPengguna', '$idAktiviti')";
        $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));
    }
    echo "<script> alert('Pengguna yang dipilih telah didaftarkan.'); 
 window.location.replace('urus_senarai_pengguna.php');</script>";
}

$input_a = '';
$q = '';
if (isset($_POST['search'])) {
    $input_a = $_POST['input_a'];
    if (!empty($input_a)) {
        $q .= "WHERE p.idPengguna LIKE  '%$input_a%' ";
    }
}
?>
<h1 style="font-size:30px">Urus Pengguna</h1>
<a class='button' href="urus_borang_pengguna.php">Tambah Pengguna Baru</a> <br><br>
<form method='POST' action=''>
    <input type='text' name='input_a' value='<?php echo $input_a; ?>' placeholder='ID Pengguna'>
    <input type='submit' name='search' value='Cari'>
    <input type='submit' name='reset' value='Reset'>
</form>
<hr>

<?php
$sql = "SELECT p.*, COUNT(h.idPengguna) as jumlahaktiviti FROM pengguna p 
  LEFT JOIN hadir h ON p.idPengguna = h.idPengguna 
  $q
  GROUP BY idPengguna ORDER BY p.nama ASC";

$result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));
$total = mysqli_num_rows($result);
if ($total > 0) {
    echo "Jumlah: $total<br>";
?>
    <form action='' method='POST'>
        <div style="overflow-y:auto;height:100%;border-collapse:collapse">
            <table class='table-data' border='1' cellpadding='4' cellspacing='0'>
                <tr>
                    <th align='left' width='50'>Sertai</th>
                    <th align='left'>ID Pengguna</th>
                    <th align='left'>Nama Pengguna</th>
                    <th align='left'>Penyertaan</th>
                    <th align='center' width='150'>Tindakan</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $idPengguna = $row['idPengguna'];
                    $namapengguna = $row['nama'];
                    $jumlahaktiviti = $row['jumlahaktiviti'];
                    echo "<tr><td align='center'><input type='checkbox' name='sertai[]' value='$idPengguna'></td>
    <td>$idPengguna</td> <td>$namapengguna</td> <td align='center'>$jumlahaktiviti</td>
    <td align='right'>
     <a href='profil_pengguna.php?idPengguna=$idPengguna'>Profil</a> - 
     <a href='javascript:void(0);' onclick='deletethis(\"$idPengguna\")' >Buang</a>
    </td> </tr>";
                }   ?>
            </table>
        </div>
        <p>
            <label>Daftarkan Pengguna Ke Aktiviti:</label><br>
            <select name='idAktiviti' required>
                <option value='' disabled selected>Sila pilih aktiviti</option>
                <?php
                $sql = "SELECT  *  FROM  aktiviti  ORDER BY  tajuk";
                $result = mysqli_query($db, $sql);
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $idAktiviti = $row['idAktiviti'];
                    $tajuk = $row['tajuk'];
                    echo "<option value='$idAktiviti'>$tajuk</option>";
                }
                ?>
            </select>
        </p>
        <p> <input type="submit" value="Daftar Pengguna"></p>
    </form>
<?php
} else {
    echo "Belum ada rekod pengguna.";
}   ?>
<script>
    function deletethis(val) {
        if (confirm("Anda pasti untuk buang pengguna ini?") == true) {
            window.location.replace('urus_senarai_pengguna.php?delete=' + val);
        }
    }
</script>
<?php include('inc_footer.php'); ?>
