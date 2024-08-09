<?php include('inc_header.php');
$input_a = '';
$q = '';
if (isset($_POST['search'])) {
    $input_a = $_POST['input_a'];
    if (!empty($input_a)) {
        $q = "WHERE aktiviti.tajuk  LIKE  '%$input_a%' ";
    }
}  ?>
<a class="mainContent">
    <h2 class='tajuk'>Semua Aktiviti</h2>
    <p>Susunan mengikut aktiviti terkini didahulukan.</p>
    <div align='center'>
        <form method='POST' action=''>
            <input type='text' name='input_a' value='<?php echo $input_a; ?>' placeholder='Nama aktiviti'>
            <input type='submit' name='search' value='Cari'> <input type='submit' name='reset' value='Reset'>
        </form>
    </div>
    <hr>
    <div class='row'>
        <?php
        # Search user for activity
        $sql = "SELECT  *  FROM  aktiviti  $q ORDER BY idaktiviti DESC";
        $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table-data' align='center' border='1' cellspacing='0'>
    <tr> <th width='20'>No.</th> <th>Aktiviti</th> <th width='200'>Poster</th> </tr>";

            $counter = 1;
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $id = $row['idAktiviti'];
                $tajuk = $row['tajuk'];
                $lokasi = $row['lokasi'];
                $mata = $row['mata'];
                $masa = date("j M Y, g:i A", strtotime($row['masa']));
                $imej = $row['imej'];
                if (!empty($imej)) {
                    $img = "<img class='imej' src='imej/$imej' width='100%'>";
                } else {
                    $img = "Tiada gambar.";
                }
                echo "<tr>
      <td>$counter</td>
      <td>
       <b>$tajuk</b> <br><br>Masa: $masa <br>
       Lokasi: $lokasi<br>  Ganjaran: $mata $label_mata<br><br>
       <a class='button' href='papar_aktiviti.php?id=$id'>Lihat</a>
      </td>
      <td>$img</td>
     </tr>";
                $counter += 1;
            }
            echo "</table>";
        } else {
            echo "Tiada aktiviti ditemui.";
        }  ?>
    </div>
</a>
<?php include('inc_footer.php');    ?>