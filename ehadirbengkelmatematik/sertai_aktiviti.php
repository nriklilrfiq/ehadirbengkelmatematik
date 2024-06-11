<?php include('inc_header.php');
semaklevel('user');

if(isset($_GET['id']) && isset($_GET['action'])){

    $idaktiviti = $_GET['id'];
    $action = $_GET['action'];
    $idmurid = $_SESSION['idmurid'];

    if($action == 'add'){

        $sql = "INSERT IGNORE INTO hadir (idmurid, idaktiviti) VALUES ('$idmurid', '$idaktiviti')";

        $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
        echo "<script> alert('Anda berjaya mendaftar untuk aktiviti ini.'); </script>";

    }elseif($action == 'remove'){
        $sql = "DELETE FROM hadir WHERE idmurid = $idmurid AND idaktiviti = $idaktiviti";
        $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
        echo "<script> alert('Aktiviti telah dikeluarkan daripada rekod.'); </script>";
    }
}else{
    echo "<script> alert('Parameter GET tidak lengkap.'); </script>";
}
echo "<script>window.location.replace('profil_pengguna.php');</script>";

include('inc_footer.php'); ?>