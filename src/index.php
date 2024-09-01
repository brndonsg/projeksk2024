<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<?php include('inc_header.php'); ?>
<a class="mainContent">
    <h2>Aktivit Anjuran Kelab Dibuka Untuk Semua Ahli</h2>
    <hr>
    <h2>Aktiviti Terkini</h2>
    <div class="row" style="text-align:center;">
        <?php
        # Obtain latest activities from database
        $sql = "SELECT * FROM aktiviti
            ORDER BY idAktiviti DESC LIMIT 6";
        $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));
        # die() functions as an exception handler, stopping all code
        # if a bug occurs
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $idAktiviti = $row['idAktiviti'];
                $tajuk = $row['tajuk'];
                $imej = $row['imej'];

                if (!empty($imej)) {
                    $img = "<img class='imej' src='imej/$imej' height='100%' width='100%'>";
                } else {
                    $img = "Tiada gambar";
                }

                echo "<table class='column' width='32%' border='0' cellspacing='0' cellpadding='4'>
                      <tr><td align='center' height='50' style='color:black;'><strong>$tajuk</strong></td></tr>
                      <tr><td align='center' height='200'>$img</td></tr>
                      <tr><td align='center'><a class='button' href='papar_aktiviti.php?id=$idAktiviti'>Lihat</a></td></tr>
                      </table>";
            }
        } else {
            echo "Belum ada aktiviti dimasukkan";
        }
        ?>
    </div>
    <hr>
    Lihat semua aktiviti <a class="mainContent" href="senarai_aktiviti.php">di sini</a>
</a>
<?php include('inc_footer.php'); ?>
