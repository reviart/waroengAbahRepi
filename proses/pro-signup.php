<?php
	include "koneksi.php";
	if(isset($_POST['submit'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $name = $_POST['name'];
    $status = $_POST['status'];
		try{
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo = $conn->prepare(
				"INSERT INTO tbuser (idUSer, pwUser, nmUser, stUser)
        VALUES('" . $user . "','" . $pass . "','" . $name . "','" . $status . "')"
			);
			$insertdata = array(
				':user' => $user,
				':pass' => $pass,
				':name'  => $name,
				':status'  => $status
			);
			$pdo->execute($insertdata);
			echo '<script type="text/javascript">';
      echo 'alert("'.$pdo->rowcount().' akun berhasil dibuat");';
      echo 'window.location.href = "../index.php";';
      echo '</script>';
		}
		catch(PDOException $e){
			echo '<script type="text/javascript">';
      echo 'alert("Akun gagal dibuat, lakukan pendaftaran ulang!");';
      echo 'window.location.href = "../index.php";';
      echo '</script>';
			die();
		}
	}
?>
