<?php
    session_start();
    include 'koneksi.php';
    if(empty($_GET['c']))
    {

    }
    else
    {
        $idbarang = $_GET['c'];
    }

    $tipe = $_GET['t'];
    $user = $_SESSION['user'];

    if($tipe == 'del')
    {
        $qrcekstok = $conn->prepare("SELECT * FROM tbbarang WHERE idBarang = '$idbarang'");
        $qrcekstok->execute();
        $cekstok = $qrcekstok->fetch(PDO::FETCH_OBJ);
        $stoklama = $cekstok->stok;

        $qrcekkrj->execute();
        $cekkrj = $qrcekkrj->fetch(PDO::FETCH_OBJ);
        $stokdiambil = $cekkrj->pcs;

        //total stok
        $stokbaru = $stoklama + $stokdiambil;

        //update item
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  			$pdo = $conn->prepare("UPDATE tbbarang SET stok = '$stokbaru' WHERE idBarang = '$idbarang'");
  			$updatedata = array(
          ':idbarang' => $idbarang,
          ':stokbaru' => $stokbaru
  			);
  			$pdo->execute($updatedata);

        //delete item
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  			$pdo = $conn->prepare("DELETE FROM tbkeranjang WHERE idBarang = '$idbarang' AND idUser = '$user'");
  			$deletedata = array(
          ':idbarang' => $idbarang,
          ':user' => $user
  			);
  			$pdo->execute($deletedata);
        echo "<script type='text/javascript'>alert('Item berhasil terhapus')</script>";
        echo "<script type='text/javascript'>window.location.href='../index.php'</script>";
    }
    else
    {
        $qrloop = $conn->prepare("SELECT * FROM tbkeranjang WHERE idUser = '$user'");
        $qrloop->execute();
        $i=1;
        while ($row = $qrloop->fetch(PDO::FETCH_OBJ))
            {
                $idbarang = $row->idBarang;
                $qrloop = $conn->prepare("SELECT * FROM tbbarang WHERE idBarang = '$idbarang'");
                $qrloop->execute();
                $cekstok = $qrloop->fetch(PDO::FETCH_OBJ);
                $stoklama = $cekstok->stok;

                //cek stok dikeranjang
                $qrcekkrj = $conn->prepare("SELECT * FROM tbkeranjang WHERE idBarang = '$idbarang' AND idUser='$user'");
                $qrcekkrj->execute();
                $cekkrj = $qrcekkrj->fetch(PDO::FETCH_OBJ);
                $stokdiambil = $cekkrj->pcs;

                //hitung total stok
                $stokbaru = $stoklama + $stokdiambil;

                //update item dulu
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          			$pdo = $conn->prepare("UPDATE tbbarang SET stok = '$stokbaru' WHERE idBarang = '$idbarang'");
          			$updatedata = array(
                  ':idbarang' => $idbarang,
                  ':stokbaru' => $stokbaru
          			);
          			$pdo->execute($updatedata);
                $i++;
            }
        //delete keranjang
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  			$pdo = $conn->prepare("DELETE FROM tbkeranjang WHERE idUser = '$user'");
  			$deletedata = array(
          ':user' => $user
  			);
  			$pdo->execute($deletedata);
        echo "<script type='text/javascript'>alert('Seluruh item berhasil terhapus')</script>";
        echo "<script type='text/javascript'>window.location.href='../index.php'</script>";
    }

    ?>
