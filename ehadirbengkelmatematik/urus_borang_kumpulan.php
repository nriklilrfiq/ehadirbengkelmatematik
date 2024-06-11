<?php include('inc_header.php');
semaklevel('admin');

#mode borang, 0 tambah, 1 edit
$edit_data = 0;
#nilai awal pembolehubah utk value borang
$name = "";
#Semak jika ada parameter id di URL
if(isset($_GET['id'])){

    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM kumpulan WHERE idkumpulan = $id LIMIT 1";
    $result = mysqli_query($db,$sql) OR die("<pre>$sql</pre>" . mysqli_error($db));

    #jika kumpulan ada dlm pangkalan data, set nilai $edit_data
    if(mysqli_num_rows($result) > 0) {
        #nilai $edit_data bukan 0 lagi, means mode borang akan digunakan utk edit
        $edit_data = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $name = $edit_data['namakumpulan'];
    }else{
        echo "<script>alert('ID tidak ditemui.');</script>";
    }
}
#semak nilai post drpd borang
if(isset($_POST['name']) && !empty($_POST['name'])){

    $name = mysqli_real_escape_string($db,$_POST['name']);
    if($edit_data){
        $sql = "UPDATE IGNORE kumpulan SET namakumpulan='$name' WHERE idkumpulan=$id";
    }else{
        $sql = "INSERT IGNORE INTO kumpulan (namakumpulan) VALUES ('$name')";
    }
    $result = mysqli_query($db,$sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
    echo "<script> alert('Berjaya disimpan.');
    window.location.replace('urus_senarai_kumpulan.php');</script>";
}
?>
<form method="POST" action="">
    <p>
        <label for='name'>Nama <?php echo $label_kumpulan; ?></label><br>
        <input type='text' name='name' id='name' value='<?php echo $name; ?>'><br>
</p>
<p><input type="submit" value="Simpan"></p>
</form>
<hr>
<?php include('inc_footer.php'); ?>
