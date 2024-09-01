<?php include('inc_header.php');

# Check if parameter is valid (ID)
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo "<script> alert('ID aktiviti diperlukan.');
   window.location.replace('senarai_aktiviti.php');
  </script>";
    die();
}

$sql = "SELECT  *  FROM aktiviti  WHERE idaktiviti = $id  LIMIT 1";
$result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));

# Display activity if found
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $id = $row['idAktiviti'];
    $tajuk = $row['tajuk'];
    $detail = $row['detail'];
    $lokasi = $row['lokasi'];   
    $masa = date("j M Y, g:i A", strtotime($row['masa']));

    if (semakmasa($row['masa'])) {
        $button_sertai = "<a class='button' href='sertai_aktiviti.php?id=$id&action=add'>Sertai</a>";
    } else {
        $button_sertai = "Aktiviti Telah Tamat.";
    }

    $imej = $row['imej'];
    if (!empty($imej)) {
        $img = "<img class='imej' src='imej/$imej' width='50%'>";
    } else {
        $img = "Tiada imej.";
    }
    echo "<div style='text-align:center'>
  <h1 style='font-size:30px; color: #3c3af1'>$tajuk</h1>
  $img <br><br> 
  <p>$detail</p>
  <p>Masa<br> <b>$masa</b></p> 
  <p>Lokasi<br> <b>$lokasi</b></p> 
  $button_sertai
</div>";
} else {
    echo "Aktiviti tidak ditemui.";
}
include('inc_footer.php');
