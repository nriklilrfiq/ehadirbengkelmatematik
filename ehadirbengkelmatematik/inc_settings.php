<?php
# Maklumat pangkalan data
$dbname ='ehadirbengkelmatematik';
$dbuser ='root';
$dbpass ='';
$dbhost ='localhost';
# Buka sambungan ke pangkalan data
$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)
 OR die(mysqli_connect_error());

 # Label kumpulan, contoh: Jabatan, Kelas, Department
$label_kumpulan = 'Kelas';

# Label untuk reward kehadiran, contoh: Point, Mata, Star, Coin
$label_mata ='Star';

# Session dimulakan
session_start();
# Session untuk simpan dan baca saiz teks
if(isset($_SESSION['fontsize'])){
    $fontsize = $_SESSION['fontsize'];
}else{
    $fontsize = 100;
}
if(isset($_GET['font'])){
    if($_GET['font'] == 'plus'){
        $fontsize += 1;
    }elseif($_GET['font'] == 'minus'){
        $fontsize -= 1;
    }else{
        $fontsize = 100;
    }
    $_SESSION['fontsize'] = $fontsize;
}

# Session tahap pengguna, untuk tentukan akses halaman
if(!isset($_SESSION['idmurid'])){
    $_SESSION['level'] = 'visitor';
}
$level = $_SESSION['level'];

# FUNCTION: semak jika masa sudah lepas
function semakmasa($masa){
    if(strtotime('now') < strtotime($masa)){
        return true;
    }else{
        return false;
    }
}

# function: semak tahap pengguna dan tahap kebenaran akses
function semaklevel($akses){
    $level = $_SESSION['level'];
    $error = '';

if($level == 'visitor'){
    $error = 'Anda perlu log masuk untuk akses halaman ini.';
}elseif($level == 'user' &&  $akses =='admin'){
    $error = 'Hanya akaun Pengurus boleh mengakses halaman ini.';
}elseif($level == 'admin' && $akses == 'user'){
    $error = 'Hanya akaun Pengguna biasa boleh mengakses halaman ini.';
}

if(!empty($error)){
    echo "<script> alert('$error');
    window.location.replace('index.php'); </script>";
    die();
}
}
?> 