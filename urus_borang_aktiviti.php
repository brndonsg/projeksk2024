<?php include('inc_header.php');
semaklevel('admin');

$tajuk = $detail = $masa = $lokasi = $mata = $imej = $idPengurus = "";
$edit_data = 0;

if (isset($_GET['idAktiviti'])) {

    $id = $_GET['idAktiviti'];
    $sql = "SELECT  *  FROM  aktiviti  WHERE idAktiviti = $id LIMIT 1";
    $result = mysqli_query($db, $sql)  or  die("<pre>$sql</pre>" . mysqli_error($db));

    if (mysqli_num_rows($result) > 0) {

        $edit_data = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $tajuk = $edit_data['tajuk'];
        $detail = $edit_data['detail'];
        $lokasi = $edit_data['lokasi'];
        $mata = $edit_data['mata'];
        $imej = $edit_data['imej'];
        $masa = date("Y-m-d H:i:s", strtotime($edit_data['masa']));
    } else {
        echo "<script>alert('ID aktiviti tidak ditemui.'); 
     window.location.replace('urus_senarai_aktiviti.php');</script>";
    }
}

# Semak nilai POST daripada borang
if (isset($_POST['tajuk']) && !empty($_POST['tajuk'])) {

    $tajuk = mysqli_real_escape_string($db, $_POST['tajuk']);
    $detail = mysqli_real_escape_string($db, $_POST['detail']);
    $lokasi = $_POST['lokasi'];
    $mata = $_POST['mata'];
    $masa = date("Y-m-d H:i:s", strtotime($_POST['masa']));
    $idPengurus = $_SESSION['idPengguna'];

    if (isset($_FILES['imej'])  &&  file_exists($_FILES['imej']['tmp_name'])) {

        $i = $_FILES['imej'];
        $file_size = $i['size'];
        $file_tmp = $i['tmp_name'];
        $file_name = explode('.', $i['name']);
        $file_ext = strtolower(end($file_name));
        # Sistem terima format yang dinyatakan ini sahaja
        $ext = array('jpeg', 'jpg', 'png', 'bmp', 'gif');
        if (in_array($file_ext, $ext)) {
            $location = __DIR__ . '/imej/';
            if (!empty($imej) && file_exists($location . $imej)) {
                unlink($location . $imej);
            }
            $newname = strtotime('now') . '.' . $file_ext;
            if (move_uploaded_file($file_tmp, $location . $newname)) {
                $imej = $newname;
            }
        }
    }

    if ($edit_data) {
        $sql = "UPDATE aktiviti SET tajuk='$tajuk', detail='$detail', masa='$masa', 
      lokasi='$lokasi', imej='$imej', mata='$mata' 
      WHERE idAktiviti=$id";
    } else {
        $sql = "INSERT INTO aktiviti (tajuk, detail, masa, lokasi, imej, mata, idPengurus) 
     VALUES ('$tajuk', '$detail', '$masa', '$lokasi', '$imej', '$mata', '$idPengurus')";
    }

    $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));
    echo "<script>alert('Aktiviti berjaya disimpan.'); 
    window.location.replace('urus_senarai_aktiviti.php')</script>";
}  ?>

<a class='button' href="urus_senarai_aktiviti.php">Ke Senarai Aktiviti</a> <br><br>
<form method='POST' action='' enctype='multipart/form-data'>
    <table align='center' width='100%' border='0' cellspacing='0' cellpadding='5'>
        <tr>
            <td valign='top' width="50%">
                <p> <label>Tajuk Aktiviti</label><br>
                    <input type='text' name='tajuk' value='<?php echo $tajuk; ?>' required>
                </p>
                <p><label>Maklumat Detail Aktiviti</label><br>
                    <textarea type='text' name='detail' rows="4" cols="30"><?php echo $detail; ?></textarea>
                </p>
                <p><label>Tarikh Dan Masa</label><br>
                    <input type='datetime-local' name='masa' value='<?php echo $masa; ?>'>
                </p>
                <p><label>Lokasi</label><br>
                    <input type='text' name='lokasi' value='<?php echo $lokasi; ?>'>
                </p>
                <p><label><?php echo $label_mata; ?></label><br>
                    <input type='number' name='mata' value='<?php echo $mata; ?>'><br>
                    <span class="nota">*Reward peserta aktiviti apabila kehadiran disahkan.</span>
                </p>
            </td>
            <td valign='top'>
                <h3>Gambar / Poster Aktiviti</h3>
                <?php if (!empty($imej)) {
                    echo "<img src='imej/$imej' alt='Poster aktiviti' width='100%'>";
                } else {
                    echo "Belum ada imej.";
                }   ?>
                <p><label for='gambar'>Muat-naik Gambar</label><br>
                    <input type="file" name='imej' id='imej'>
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <p><input type='submit' value='Simpan'></p>
            </td>
        </tr>
    </table>
</form>
<?php include('inc_footer.php'); ?>