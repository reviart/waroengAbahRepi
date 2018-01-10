<?php
include 'koneksi.php';
$username = $_POST['username'];
$pass = $_POST['password'];

    $pdo = $conn->prepare("SELECT * FROM tbuser where idUser='$username' AND pwUser='$pass'");
		$pdo->execute(array(
				':username' => $username,
				':pass'  => $pass
			));
		$cek = $pdo->rowcount();
		$row = $pdo->fetch(PDO::FETCH_OBJ);

if ($cek > 0) {
  session_start();
  $_SESSION['user'] = $row->idUser;
  echo "<script type='text/javascript'>alert('Welcome " . $_SESSION['user'] . "')</script>";
  echo "<script type='text/javascript'>window.location.href='../index.php'</script>";
} else {
  echo "<script type='text/javascript'>alert('Login Failed!')</script>";
  echo "<script type='text/javascript'>window.location.href='../index.php'</script>";
}
?>
