<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">  

<?php include('inc_settings.php'); ?>
<html>
    <head>
        <title>Kelab Alam Sekitar</title>
        <link rel="stylesheet" href="style.css">
        <style>* {font-size:<?php echo $fontsize;?>%;}</style>
    </head>
    <body>
        <table width="900" align="center" id="mainTable" cellpadding="10" cellspacing="0" border="0" >
        <tr background="imej/leaf.jpg" style="background-repeat:no-repeat; background-size:cover; " >
            <div>
                <td align="left" valign="middle" colspan='2' style="height:200px;">
                    <img onclick=goHome(); id="logo" src="imej/tree.png" style="border-radius:90px;position:absolute;margin-left:40px;"  >
                    <h1 style="font-size:40px; color:white; text-align:right;  text-shadow:2px 2px 0 #000,-2px 2px 0 #000,-2px -2px 0 #000,2px -2px 0 #000;" >Rekod Kehadiran<br>Kelab Alam Sekitar <a style="font-family:Helvetica; color:blue">KTD</a><a style="color:yellow">THB</a></h1>
                </td>
            </div>
        </tr>
        <tr >
            <td width="130"  valign="top" align="center">
                <a class="mainMenu" href="index.php">Laman Utama</a><br>
                <a class="mainMenu" href="senarai_aktiviti.php">Semua Aktiviti</a><br>
                <?php
                if($level == 'user'){
                    echo "<a class='mainMenu' href='profil_pengguna.php'>Profil Saya</a><br>";
                }
                if($level == 'admin'){
                    echo "<h3>Menu Admin</h3>
                    <a class='mainMenu' href='urus_senarai_aktiviti.php'>Urus Aktiviti</a><br>
                    <a class='mainMenu' href='urus_senarai_kumpulan.php'>Urus $label_kumpulan</a><br>
                    <a class='mainMenu' href='urus_senarai_pengguna.php'>Urus Pengguna</a><br>
                    <a class='mainMenu' href='urus_import.php'>Import Data</a><br>";
                }
                if($level == 'visitor'){
                    echo "<a class='mainMenu' href='login.php' '>Log Masuk</a><br>
                          <a class='mainMenu' href='signup.php' '>Daftar</a><br>";
                } else{
                    $nama = $_SESSION['nama'];
                    echo "<p style='text-align:left; font-size:12px;'>Hi, $nama <br>Anda seorang <a style='color:blue';>$level</a><br><br><br><br><br><br><br><br><br><br><br><br>
                          <a class='mainMenu' href='logout.php'>Log Keluar</a></p>";
                }
                ?>
            </td>
            <td valign="top" id="printcontent">
<script>
    goHome = () => {
        window.location.replace("index.php");
    }

</script>