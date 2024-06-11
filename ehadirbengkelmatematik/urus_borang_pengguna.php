<?php include('inc_header.php');
semaklevel('admin');
#Nilai awal pembolehubah untuk 'value' dalam borang
$idmurid = $password = $nama = $idkumpulan = "";
#semak nilai POST drpd borang
if(isset($_POST['idmurid'])){
    $idmurid = trim($_POST['idmurid']);
    $password = trim($_POST['password']);
    $nama = trim($_POST['nama']);
    $idkumpulan = $_POST['idkumpulan'];

    $sql = "INSERT IGNORE INTO murid (idmurid, password, nama, idkumpulan)
    VALUES ('$idmurid', '$password', '$nama', $idkumpulan)";
    $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" .mysqli_error($db));
     echo "<script> alert('Berjaya disimpan.');
    window.location.replace('urus_senarai_pengguna.php'); </script>";
} ?>
<h1 style="font-size:30px">Borang Maklumat Murid</h1>
<form method="POST" action="">
    <p><label>ID Murid</label><br>
    <input type='text' name='idmurid' value='<?php echo $idmurid; ?>' required><br>
</p>
<p><label>Kata laluan</label><br>
<input type='password' name='password' value='<?php echo $password; ?>' required><br>
</p>
<p><label>Nama</label><br>
<input type='text' name='nama' value='<?php echo $nama; ?>' required><br>
</p>
<p><label><?php echo $label_kumpulan; ?></label><br>
<select name='idkumpulan' required>
    <option value='' disabled selected>Sila pilih</option>
    <?php
    $sql = "SELECT * FROM kumpulan ORDER BY namakumpulan";
    $result = mysqli_query($db,$sql);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $rowkumpulan = $row['idkumpulan'];
        $namakumpulan = $row['namakumpulan'];
        if($idkumpulan == $rowkumpulan){
            $selected = "selected";
        }else{
         $selected = "";
       }
        echo "<option $selected value='$rowkumpulan'>$namakumpulan</option>";
    } ?>
    </select>
</p>
<p> <input type="submit" value="Simpan"></p>
</form>
<?php include('inc_footer.php'); ?>