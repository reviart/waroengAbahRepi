<?php
    include 'koneksi.php';
    session_start();
    $user = $_SESSION['user'];
    $tgl = date("Ymd");
    $idtransaksi = $tgl.$user;

    if(empty($_GET['c1']) || empty($_GET['c2']))
    {
        echo "<script type='text/javascript'>alert('Keranjang masih kosong')</script>";
        echo "<script type='text/javascript'>window.location.href='../index.php'</script>";
    }
    else
    {
        //proses simpan transaksi
        $totalbayar = $_GET['c1'];
        $totalitem = $_GET['c2'];

        $conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  			$pdo = $conn->prepare(
              'INSERT INTO tbtransaksi (idTransaksi, tglTransaksi, idUser, qty, bayar)
  						 VALUES (:idtransaksi, :tgl, :user, :totalitem, :totalbayar)'
        );
        $insertdata = array(
          ':idtransaksi' => $idtransaksi,
          ':tgl' => $tgl,
  				':user' => $user,
  				':totalitem' => $totalitem,
  				':totalbayar' => $totalbayar
        );
			  $pdo->execute($insertdata);

        $qrloop = $conn->prepare("SELECT * FROM tbkeranjang WHERE idUser = '$user'");
        $qrloop->execute();
        $i=1;
        while ($row = $qrloop->fetch(PDO::FETCH_OBJ))
            {
                $idbarang = $row->idBarang;
                $pcs = $row->pcs;
                $tharga = $row->total;

                $conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          			$pdo = $conn->prepare(
                      'INSERT INTO transaksi_detail (idTransaksi, idBarang, pcs, totalharga)
          						 VALUES (:idtransaksi, :idbarang, :pcs, :tharga)'
                );
                $insertdata = array(
                  ':idtransaksi' => $idtransaksi,
                  ':idbarang' => $idbarang,
          				':pcs' => $pcs,
          				':tharga' => $tharga
                );
        			  $pdo->execute($insertdata);
            }

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  			$pdo = $conn->prepare("DELETE FROM tbkeranjang WHERE idUser = '$user'");
  			$deletedata = array(
          ':user' => $user
  			);
  			$pdo->execute($deletedata);
        echo "<script type='text/javascript'>alert('Transaksi telah berhasil, ID Transaksi Anda : $idtransaksi.')</script>";
        echo "<script type='text/javascript'>window.location.href='../index.php'</script>";
    }

?>
