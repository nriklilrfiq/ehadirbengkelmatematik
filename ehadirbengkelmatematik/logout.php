<?php
#Sambung akses session pengguna semasa
session_start();
#hapuskan semua pembolehubah dalam session
session_unset();
#hapuskan keseluruhan session pengguna
session_destroy();

#paparkan mesej berjaya dan bawa pengguna ke halaman utama
echo "<script>
alert('Log keluar berjaya.');
window.location.replace('index.php');
</script>";
?>