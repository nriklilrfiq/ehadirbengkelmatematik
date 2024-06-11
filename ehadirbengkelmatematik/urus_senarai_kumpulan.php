<?php include('inc_header.php');
semaklevel('admin');
#Semak jika ada parameter 'delete' di URL.
if(isset($_GET['delete'])){
    $idkumpulan = $_GET['delete'];
    $sql = "DELETE FROM kumpulan WHERE idkumpulan = $idkumpulan ";
    $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
    echo "<script> alert('Kumpulan berjaya dibuang.');
    window.location.replace('urus_senarai_kumpulan.php'); </script>"; die();
} ?>
<h1 style="font-size:30px">Urus <?php echo $label_kumpulan; ?></h1>
<a class='button' href="urus_borang_kumpulan.php">Tambah <?php echo $label_kumpulan; ?> Baru</a> <br><br>
<?php
$sql = "SELECT k.*, COUNT(p.idmurid) as jumlahmurid FROM kumpulan k
LEFT JOIN murid p ON p.idkumpulan = k.idkumpulan
GROUP BY k.idkumpulan ORDER BY namakumpulan";
$result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
$total = mysqli_num_rows($result);

if($total > 0){
    echo "Jumlah: $total<br>";
    echo "<table class='table-data' border='1' cellpadding='4' cellspacing='0'>
    <tr><th align='left'>Nama $label_kumpulan</td>
    <th align='center' width='150'>Tindakan</td></tr>";

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $id = $row['idkumpulan'];
        $name = $row['namakumpulan'];
        $jumlahmurid = $row['jumlahmurid'];
        echo "<tr>
        <td>$name ($jumlahmurid murid)</td>
        <td align='right'>
        <a href='urus_borang_kumpulan.php?id=$id'>Edit</a> -
        <a href='javascript:void(0);' onclick='deletethis($id)' >Buang</a>
        </td>
        </tr>";
    }
    echo "</table>";
}else{
    echo "Belum ada rekod $label_kumpulan.";
} ?>
<script>
    function deletethis(val){
        if(confirm("Anda pasti untuk buang?") == true) {
            window.location.replace('urus_senarai_kumpulan.php?delete='+val);
        }
    }
    </script>
    <?php include('inc_footer.php'); ?>