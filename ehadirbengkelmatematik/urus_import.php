<?php include('inc_header.php');
semaklevel('admin');
if(isset($_FILES["import"])){
    if(!file_exists($_FILES['import']['tmp_name'])) {
        echo "<script> alert('Sila pilih fail yang ingin di import.');
        window.location.replace('urus_import.php'); </script>";
    }
    $counter = 0;
    $file = fopen($_FILES["import"]["tmp_name"], 'rb');

    if($_POST['jenis']=='pengguna'){
        while (($line = fgetcsv($file, 50, ",")) !== FALSE) {
            if(count($line) == 4){
                $idmurid = trim($line[0]);
                $password = trim($line[1]);
                $nama = trim($line[2]);
                $idkumpulan = trim($line[3]);
                $sql = "INSERT IGNORE INTO murid (idmurid, password, nama, idkumpulan)
                VALUES ('$idmurid', '$password', '$nama', $idkumpulan)";
                $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" .mysqli_error($db));
                $counter += 1; # Tambah 1 ke nilai counter
            }
        }
    }else{
        while (($line = fgetcsv($file, 50, ",")) !== FALSE) {
            $namakumpulan = trim($line[0]);
            if(!empty($namakumpulan) && count($line)==1){
                #Masukkan teks tersebut ke pangkalan data
                $sql = "INSERT IGNORE INTO kumpulan (namakumpulan) VALUES ('$namakumpulan')";
                $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
                $counter += 1;
            }
        }
    }

    fclose($file);
    echo "<script>alert('$counter rekod data telah diproses. Jika nilai telah wujud dalam pangkalan data, ia telah diabaikan.');
    window.location.replace('urus_import.php'); </script>";
} ?>
<h1 style="font-size:30px">Import Data</h1>
<form method="POST" action="" enctype="multipart/form-data">
    <p>
        <input type="radio" id="murid" name="jenis" value="murid" required>
        <label for="murid">Murid</label><br>
        <input type="radio" id="kumpulan" name="jenis" value="kumpulan" required>
        <label for="kumpulan"><?php echo $label_kumpulan; ?></label><br>
</p>
<p>
    <label for='import'>Pilih fail untuk di import (Format CSV sahaja)</label><br>
    <input type="file" name='import' accept='.csv' required>
</p>
<p><input type="submit" value="Import Data"></p>
</form>
<?php include('inc_footer.php'); ?>