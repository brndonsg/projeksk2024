<?php include('inc_header.php');

if (isset($_POST['idakaun'])  &&  isset($_POST['password'])) {

    $idakaun = trim(strtolower($_POST['idakaun']));
    $password = trim($_POST['password']);
    $level = $_POST['level'];

    if ($level == 'user') {
        $dbname = 'pengguna';
        $medan_id = 'idPengguna';
    } else {
        $dbname = 'pengurus';
        $medan_id = 'idPengurus';
        $level = 'admin';
    }

    $sql = "SELECT * FROM $dbname WHERE $medan_id='$idakaun' AND password='$password' LIMIT 1";
    $result = mysqli_query($db, $sql) or die("<pre>$sql</pre>" . mysqli_error($db));

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $_SESSION['idPengguna'] = $row[$medan_id];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['level'] = $level;
            echo "

            <h6 style='color:green;font-weight:bold;text-align: center;'>Log masuk berjaya! Tunggu sekejap...</h6>
                
                  <script> 
                  alert('Log masuk berjaya.');
                  setTimeout(() => {
                        window.location.replace('index.php');
                    }, 1000) </script>";
            die();
        }
    } else {
        echo "
        <script>
        alert('Log masuk gagal.');
        </script>
        <h6 style='color:red;font-weight:bold;text-align: center;'>ID atau katalaluan anda salah!</h6>";
    }
}
?>
<table class="mainContent" width='400' height='300px' align='center' style="background-color:#0a7a73; border: 4px black solid; border-radius: 10px;">
    <tr>
        <td align='center'>
            <h2>Log Masuk</h2>
            <p>Jika anda belum mempunyai akaun pengguna, klik <a href='signup.php'>Daftar</a></p>
            <form method="POST" action=''>

                <label>ID Akaun</label><br>
                <input type="text" name="idakaun" required><br><br>
                <label>Katalaluan</label><br>
                <input type="password" name="password" required><br><br>

                <label>Tahap Akses</label><br>
                <select name="level">
                    <option value="user" selected>Pengguna</option>
                    <option value="admin">Pengurus</option>
                </select>
                <br><br>
                <input type="submit" name="" value="Log Masuk">
            </form>
        </td>
    </tr>
</table>
<?php
include('inc_footer.php');
?>
