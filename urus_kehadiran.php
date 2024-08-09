<?php include('inc_header.php');
semaklevel('admin');
if (isset($_GET['idAktiviti'])) {
    $idAktiviti = $_GET['idAktiviti'];
} else {
    echo "<script> alert('ID aktiviti diperlukan.');
   window.location.replace('urus_senarai_aktiviti.php'); </script>";
    die();
}
if (isset($_GET['action']) && isset($_GET['idHadir'])) {
    $idHadir = $_GET['idHadir'];
    $action = $_GET['action'];
    if ($action == 'hadir' || $action == 'tidakhadir') {
        $sql = "UPDATE hadir SET status = '$action' WHERE idHadir = $idHadir";
        $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));
        echo "<script> alert('Status kehadiran berjaya dikemaskini.'); </script>";
    } elseif ($action == 'delete') {
        $sql = "DELETE FROM hadir WHERE idHadir = $idHadir";
        $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));
        echo "<script> alert('Pengguna berjaya dinyah-daftar daripada aktiviti.'); </script>";
    }
    echo "<script>window.location.replace('urus_kehadiran.php?idAktiviti=$idAktiviti');</script>";
} ?>
<h1 style="font-size:30px">Rekod Kehadiran Aktiviti</h1>
<?php $sql = "SELECT a.*,  p.* FROM aktiviti a 
  LEFT JOIN pengurus p on a.idPengurus = p.idPengurus  WHERE idAktiviti = $idAktiviti LIMIT 1";
$result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $tajuk = $row['tajuk'];
    $detail = $row['detail'];
    $lokasi = $row['lokasi'];
    $mata = $row['mata'];
    $namapengurus = $row['nama'];
    $masa = date("j M Y, g:i A", strtotime($row['masa']));
    $imej = $row['imej'];
    if (!empty($imej)) {
        $img = "<img class='imej' src='imej/$imej' width='80%'>";
    } else {
        $img = "Tiada imej.";
    }
    echo "<table width='100%' align='center' border='0' cellspacing='0'><tr>
    <td width='200'>$img</td>
    <td valign='top'><h2 class='tajuk'>$tajuk</h2>Masa: $masa <br>Lokasi: $lokasi <br>Pengurus: $namapengurus
    <br><br>
    <a class='button' href='urus_kiosk.php?idAktiviti=$idAktiviti' target='_blank'>Self Checkin Kiosk</a>
    <a class='button' href='javascript:void(0);' onclick='printcontent(&quot;printcontent&quot;)'>Cetak</a>
    </td>
    </tr></table>";
    echo "<h2>Senarai Peserta</h2>";
    $sql = "SELECT h.*, p.*, a.* FROM hadir h 
  LEFT JOIN pengguna p on p.idPengguna = h.idPengguna 
  LEFT JOIN aktiviti a on a.idAktiviti = h.idAktiviti 
  WHERE h.idAktiviti = $idAktiviti ORDER BY  idHadir  DESC";
    $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));
    $total = mysqli_num_rows($result);
    if ($total > 0) {
        echo "Jumlah: $total<br><table class='table-data' border='1' cellspacing='0'>
    <tr>
     <th width='20'>No.</th> <th>Nama</th>
     <th width='200'>Masa Mendaftar</th> <th width='100'>Kehadiran</td>
     <th width='200'>Tindakan</td>
    </tr>";
        $counter = 1;
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $idHadir = $row['idHadir'];
            $idPengguna = $row['idPengguna'];
            $namapengguna = $row['nama'];
            $masa = date("j M Y, g:i A", strtotime($row['masa']));
            $status = $row['status'];
            if ($status == 'hadir') {
                $status_text = 'Hadir';
            } elseif ($status == 'tidakhadir') {
                $status_text = 'Tidak Hadir';
            } else {
                $status_text = 'Belum Disahkan';
            }
            echo "<tr>
     <td>$counter</td> <td>$namapengguna ($idPengguna)</td>
     <td>$masa</td> <td>$status_text</td>
     <td align='center'>
      <a href='?idAktiviti=$idAktiviti&idHadir=$idHadir&action=hadir'>Hadir</a> | 
      <a href='?idAktiviti=$idAktiviti&idHadir=$idHadir&action=tidakhadir'>Tidak Hadir</a> | 
      <a href='javascript:void(0);' onclick='deletethis($idHadir)' >Buang Pendaftaran</a>
     </td> </tr>";
            $counter = $counter + 1;
        }
        echo "</table>";
    } else {
        echo "Belum ada pengguna yang mendaftar.";
    }
} else {
    echo "Aktiviti tidak ditemui.";
}  ?>
<script>
    function deletethis(val) {
        if (confirm("Anda pasti?") == true) {
            window.location.replace(window.location.href + '&action=delete&idHadir=' + val);
        }
    }
</script>
<?php include('inc_footer.php'); ?>