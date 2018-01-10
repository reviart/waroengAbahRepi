<?php
    include 'koneksi.php';
    session_start();
    $idbarang = $_GET['c'];
    $qrcekstok = $conn->prepare("SELECT * FROM tbbarang WHERE idBarang = '$idbarang'");
    $qrcekstok->execute();
    $cekstok = $qrcekstok->fetch(PDO::FETCH_OBJ);
    $stoklama = $cekstok->stok;
    $harga = $cekstok->harga;
    if($stoklama < 1)
    {
        echo "<script type='text/javascript'>alert('Item Out of Stock!')</script>";
        echo "<script type='text/javascript'>window.location.href='../index.php'</script>";
    }
    else
    {
        $idUser = $_SESSION['user'];
        $qrcekdata = $conn->prepare("SELECT * FROM tbkeranjang WHERE idBarang = '$idbarang' AND idUser='$idUser'");
        $qrcekdata->execute();
        if($row = $qrcekdata->fetch(PDO::FETCH_OBJ))
        {
            $jml = $row->pcs;
            $jmlt = $jml + 1;
            $total = $harga * $jmlt;

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      			$pdo = $conn->prepare("UPDATE tbkeranjang SET pcs = '$jmlt', total = '$total' WHERE idBarang = '$idbarang' AND idUser = '$idUser'");
      			$updatedata = array(
              ':jmlt' => $jmlt,
              ':total' => $total,
              ':idbarang' => $idbarang,
              ':idUser' => $idUser
      			);
      			$pdo->execute($updatedata);
            $stokbaru = $stoklama - 1;
        }
        else
        {
            $jml = 1;
            $total = $harga * $jml;
            $conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      			$pdo = $conn->prepare(
                  'INSERT INTO tbkeranjang (idBarang, pcs, total, idUser)
      						 VALUES (:idbarang, :jml, :total, :idUser)'
            );
            $insertdata = array(
              ':idbarang' => $idbarang,
              ':jml' => $jml,
      				':total' => $total,
      				':idUser' => $idUser
            );
    			  $pdo->execute($insertdata);
            $stokbaru = $stoklama - $jml;
        }
        echo "<script type='text/javascript'>alert('Added to cart!')</script>";
        echo "<script type='text/javascript'>window.location.href='../index.php'</script>";

        //proses update stok
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo = $conn->prepare("UPDATE tbbarang SET stok = '$stokbaru' WHERE idBarang = '$idbarang'");
        $updatedata = array(
          ':stokbaru' => $stokbaru,
          ':idbarang' => $idbarang
        );
        $pdo->execute($updatedata);
    }
?>
