<?php include('inc_header.php');
#Pemboleh ubah untuk menyimpan input pengguna
$idmurid = $nama = $password = $idkumpulan = '';
#String untuk simpan mesej ralat
$error = '';

 if(isset($_POST['idmurid'])){

    $idmurid = trim($_POST['idmurid']);
    $password = trim($_POST['password']);
    $nama = trim($_POST['nama']);
    $idkumpulan = $_POST['idkumpulan'];

    #semak supaya username tiada simbol khas
    if(preg_match('/[^a-zA-Z0-9]+/', $idmurid)){
        $error .= "ID murid tidak boleh menggunakan simbol. ";
    }
    #Semak supaya semua maklumat sudah diisi (tidak empty)
    if(empty($nama) || empty($idmurid) || empty($password)){
        $error .= "Sila isi semua ruang di borang pendaftaran. ";
    }
    #Dapatkan bilangan aksara idmurid
    $id_lenght = strlen($idmurid);
    #Had atas untuk panjang idmurid
    if($id_lenght > 15){
        $error .= "ID terlalu panjang. Maksima 4 aksara. ";
    }
    #Had bawah untuk panjang idmurid
    if($id_lenght < 4){
        $error .= "ID terlalu pendek. Minima 4 aksara. ";
    }
    #Had bawah untuk password
    $password_lenght = strlen($password);
    if($password_lenght < 6){
        $error .= "Kata laluan terlalu pendek. Minima 6 aksara. ";
    }
    #Semak jika ID sudah wujud dalam database
    $sql = "SELECT * FROM murid WHERE idmurid='$idmurid' LIMIT 1";
    $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));

    if(mysqli_num_rows($result) > 0){
        $error .= "ID ($idmurid) sudah digunakan, sila pilih ID berbeza.";
    }
    #Jika tiada error, teruskan pendaftaran
    if(empty($error)){
        $sql = "INSERT INTO murid (idmurid, password, nama, idkumpulan)
        VALUES ('$idmurid', '$password', '$nama', $idkumpulan)";
        $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
        echo "<script>
        alert('Pendaftaran berjaya. Sila Log Masuk menggunakan ID ($idmurid).');
        window.location.replace('login.php'); </script>";
    die();
    }else{
        echo "<script>alert('$error');</script>";
    }
}
?>
<table width='400' height='100%' align='center'>
<tr>
<td align='center'>
 <h2>Daftar Akaun</h2>
 <p>Jika anda sudah mempunyai akaun, klik <a href='login.php'>Log Masuk</a></p>
 <form method='POST' action=''>
 <label>ID Murid</label><br>
 <input type="text" name="idmurid" value='<?php echo $idmurid; ?>' required><br><br>
 <label>Kata Laluan</label><br>
 <input type="password" name="password" value='<?php echo $password; ?>' required><br><br>
 <label>Nama</label><br>
 <input type="text" name="nama" value='<?php echo $nama; ?>' required><br>
 <p>
 <label><?php echo $label_kumpulan; ?></label><br>
 <select name='idkumpulan' required>
 <option value='' disabled selected>Sila Pilih</option>
 <?php
  #Dapatkan senarai kumpulan untuk dijadikan dropdown
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
    }
  ?>
  </select>
</p>
<input type="submit" name='signup' value="Daftar">
</form>
</td>
</tr>
</table>

<?php include('inc_footer.php'); ?>