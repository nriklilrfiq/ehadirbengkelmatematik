<?php include('inc_header.php'); ?>
<h2><marquee>Bengkel Matematik dianjurkan oleh Panitia Matematik Sekolah</marquee></h2>
<hr>
<h2>Aktiviti Terkini</h2>
<div class='row' style='text-align:center;'>
<?php
# Dapatkan aktiviti terkini untuk dipaparkan
$sql = "SELECT * FROM aktiviti
   ORDER BY idaktiviti DESC LIMIT 6";

$result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_array($result)){
        $idaktiviti = $row['idaktiviti'];
        $namaaktiviti = $row['namaaktiviti'];
        $imej = $row['imej'];
        
        if(!empty($imej)){
            $img = "<img class='imej' src='imej/$imej' height='100%' width='100%'>";
            }else{
             $img = "Tiada gambar.";
}

    echo "<table class='column' width='32%' border='0' cellspacing='0' cellpadding='4'>
    <tr><td align='center' height='50'><strong>$namaaktiviti</strong></td></tr>
    <tr><td align='center' height='200'>$img</td></tr>
    <tr><td align='center'><a class='button' href='papar_aktiviti.php?id=$idaktiviti'>Lihat</a></td></tr>
    </table>";
}
}else{
    echo "Belum ada aktiviti dimasukkan.";
}
?>
</div>
<hr>
Lihat semua aktiviti <a href='senarai_aktiviti.php'>di sini.</a>

<?php include('inc_footer.php'); ?>