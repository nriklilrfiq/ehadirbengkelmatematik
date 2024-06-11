<?php include('inc_header.php');
semaklevel('admin');

if(isset($_GET['delete'])){
 $idmurid = $_GET['delete'];

 $sql = "DELETE FROM murid WHERE idmurid = '$idmurid' ";
 $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
 echo "<scipt> alert('Akaun murid berjaya dibuang.');
   window.location.replace('urus_senarai_pengguna.php'); </script>"; die();
}

if(isset($_POST['idaktiviti']) && isset($_POST['sertai'])){
 $idaktiviti = $_POST['idaktiviti'];
 foreach ($_POST['sertai'] as $idmurid) {
  $sql = "INSERT IGNORE INTO hadir (idmurid, idaktiviti)
   VALUES ('$idmurid', '$idaktiviti')";
  $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
 }
 echo "<script> alert('Murid yang dipilih telah didaftarkan.');
 window.location.replace('urus_senarai_pengguna.php');</script>";
}

$input_a = '';
$q = '';
if(isset($_POST['search'])){
 $input_a = $_POST['input_a'];
 if(!empty($input_a)){
  $q .= "WHERE p.idmurid LIKE '%$input_a%' ";
 }
}
?>
<h1 style="font-size:30px">Urus Murid</h1>
<a class='button' href="urus_borang_pengguna.php">Tambah Murid Baru</a> <br><br>
<form method='POST' action=''>
<input type='text' name='input_a' value='<?php echo $input_a; ?>' placeholder='ID Murid'>
<input type='submit' name='search' value='Cari'>
<input type='submit' name='reset' value='Reset'>
</form>
<hr>

<?php
$sql = "SELECT p.*, COUNT(h.idmurid) as jumlahaktiviti FROM murid p
  LEFT JOIN hadir h ON p.idmurid = h.idmurid
  $q
  GROUP BY idmurid ORDER BY p.idmurid ASC";

$result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
$total = mysqli_num_rows($result);
if($total > 0){
 echo "Jumlah: $total<br>";
?>
<form action='' method='POST'>
<table class='table-data' border='1' cellpadding='4' cellspacing='0'>
  <tr>
   <th align='left' width='50'>Sertai</th> <th align='left'>ID Murid</th>
   <th align='left'>Nama Murid</th> <th align='left'>Penyertaan</th>
   <th align='center' width='150'>Tindakan</th>
  </tr>
<?php
 while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  $idmurid = $row['idmurid'];
  $namamurid = $row['nama'];
  $jumlahaktiviti = $row['jumlahaktiviti'];
  echo "<tr><td align='center'><input type='checkbox' name='sertai[]' value='$idmurid'></td>
    <td>$idmurid</td> <td>$namamurid</td> <td align='center'>$jumlahaktiviti</td>
    <td align='right'>
     <a href='profil_pengguna.php?idmurid=$idmurid'>Profil</a> -
     <a href='javascript:void(0);' onclick='deletethis(\"$idmurid\")' >Buang</a>
    </td> </tr>";
 } ?>
</table>
<p>
<label>Daftarkan Murid Ke Aktiviti:</label><br>
<select name='idaktiviti' required>
<option value='' disable selected>Sila pilih aktiviti</option>
<?php
$sql = "SELECT * FROM aktiviti ORDER BY namaaktiviti";
$result = mysqli_query($db,$sql);
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
 $idaktiviti = $row['idaktiviti'];
 $namaaktiviti = $row['namaaktiviti'];
 echo "<option value='$idaktiviti'>$namaaktiviti</option>";
}
?>
</select>
</p>
<p> <input type="submit" value="Daftar Murid"></p>
</form>
<?php
}else{
 echo "Belum ada rekod murid.";
} ?>
<script> 
function deletethis(val){
 if (confirm("Anda pasti untuk buang murid ini?") == true) {
  window.location.replace('urus_senarai_pengguna.php?delete='+val);
 }
}
</script>
<?php include('inc_footer.php'); ?>