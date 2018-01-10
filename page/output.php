<?php
    include '../proses/koneksi.php';
    $idtransaksi = $_GET['c'];

    $cek = $conn->prepare("SELECT * FROM tbtransaksi WHERE idTransaksi = '$idtransaksi'");
    $cek->execute();

    if(empty($row = $cek->fetch(PDO::FETCH_OBJ)))
    {
        echo "<script type='text/javascript'>alert('Transaksi tidak tersedia')</script>";
        echo "<script type='text/javascript'>window.location.href='../index.php'</script>";
    }

    $qrload = $conn->prepare("SELECT * FROM transaksi_detail
    INNER JOIN tbtransaksi ON transaksi_detail.idTransaksi = tbtransaksi.idTransaksi
    INNER JOIN tbbarang ON transaksi_detail.idBarang = tbbarang.idBarang
    INNER JOIN tbuser ON tbtransaksi.idUser = tbuser.idUser WHERE tbtransaksi.idTransaksi = '$idtransaksi'");
    $qrload->execute();
?>


<html>
<head>
    <title>INVOICE</title>
    <link rel="icon" href="../img/fork.png" sizes="16x16">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
</head>
<body>
    <a href="../index.php"><img src="../img/home-icon.png" alt="back" width="50px"></a>
    <center>
    <h1>INVOICE PEMBELIAN</h1>
    <table style='border:dotted;'>
        <thead>
            <tr>
                <th align="center" style='width:30px;border-bottom:dotted;'>No</th>
                <th align="center" style='width:300px;border-bottom:dotted;'>Item</th>
                <th align="center" style='width:30px;border-bottom:dotted;'>Pcs</th>
                <th align="center" style='width:100px;border-bottom:dotted;'>Harga</th>
                <th align="center" style='width:100px;border-bottom:dotted;'>Total</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $i=1;
            while ($row = $qrload->fetch(PDO::FETCH_OBJ)){
                $titem = $row->qty;
                $tbayar = $row->bayar;
                $pembeli = $row->idUser;
            ?>
                <tr>
                <td align="center"><?php echo $i; ?></td>
                <td align="center"><?php echo $row->nmBarang; ?></td>
                <td align="center"><?php echo $row->pcs; ?></td>
                <td align="center"><?php echo $row->harga; ?></td>
                <td align="center"><?php echo $row->totalharga; ?></td>
                </tr>
            <?php
                $i++;
              }
            ?>
        </tbody>
    </table>
    <table>
        <tbody>
            <tr>
                <td align="left" style='width:450px;'></td>
                <td align="left" style='width:230px;'>Total Item : <?php echo $titem; ?></td>
            </tr>
            <tr>
                <td align="left" style='width:450px;'></td>
                <td align="left" style='width:230px;'>Total Bayar : <?php echo $tbayar; ?></td>
            </tr>
            <tr>
                <td align="left" style='width:450px;'></td>
                <td align="left" style='width:230px;'>Atas Nama : <?php echo $pembeli; ?></td>
            </tr>
        </tbody>
    </table>
</center>
</body>
</html>
