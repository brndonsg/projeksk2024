<tr><td colspan="2" align="center" height="20" bgcolor="#05423e">

Saiz Teks: <br><a class='button' href='?font=plus'>+</a>
<a class='button' href='?font=minus'>-</a>
<a class='button' href='?font=reset'>Reset</a>
<br><br>
<a href='javascript:void(0);' onclick="window.print()">Cetak Halaman</a> <a href='javascript:void(0);' onclick='printcontent("printcontent")'>Cetak
Kandungan</a>
<br>
Copyright Â© Portal SRK</td></tr>
</table>
<script type="text/javascript">

    function printcontent (areaID){

    var printContent = document.getElementById(areaID);
    var WinPrint = window.open('', '', 'width=900,height=650'); WinPrint.document.write(printContent.innerHTML);
    WinPrint.document.close();
    WinPrint.focus(); WinPrint.print(); WinPrint.close();
    }
</script> </body>
<html></html>