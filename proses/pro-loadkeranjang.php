<?php
include 'koneksi.php';
if (empty($_SESSION['user'])) {

} else {
    $ucek = $_SESSION['user'];
    $qrload = $conn->prepare("SELECT * FROM tbkeranjang INNER JOIN tbbarang ON tbkeranjang.idBarang = tbbarang.idBarang WHERE idUser = '$ucek'");
    $qrload->execute();
    $i = 1;
    echo "<table>";
    echo "  <tbody style='background-color: #c6cac6;'>
            <tr>
                <th style='width:30px;'><center>No.</center></th>
                <th style='width:180px;'><center>Item</center></th>
                <th style='width:20px;'><center>Pcs</center></th>
                <th style='width:75px;'><center>Action</center></th>
            </tr>
            </tbody>
    ";
    while ($row = $qrload->fetch(PDO::FETCH_OBJ)) {
        echo "<tr><td><center>".$i."</center></td>
              <td><center>".$row->nmBarang."</center></td>
              <td><center>".$row->pcs."</center></td>
              <td style = 'text-align:center;'>
              <button type='button' class='btndel' onclick='del(\"".$row->idBarang."\");'>Delete</button></td></tr>";
        $i++;
    }
    echo "</table>";
    $bayar = $conn->prepare("SELECT SUM(total) AS hitung FROM tbkeranjang WHERE idUser = '$ucek'");
    $bayar->execute();
    $tmpbayar = $bayar->fetch(PDO::FETCH_OBJ);
    $totalbayar = $tmpbayar->hitung;

    $item = $conn->prepare("SELECT SUM(pcs) AS hitung FROM tbkeranjang WHERE idUser = '$ucek'");
    $item->execute();
    $tmpitem = $item->fetch(PDO::FETCH_OBJ);
    $totalitem = $tmpitem->hitung;

    echo "<br><center>IDR.: ".$totalbayar."</center>";
    echo "
    <center style='border-top:dotted;'><button type='button' class='btndelall' onclick='delall();'>Delete All Item</button> <button type='button' class='btnbayar' onclick='checkout(\"".$tmpbayar->hitung."\",\"".$tmpitem->hitung."\");'>Checkout</button></center>
    ";
}
?>

<script type="text/javascript">

  function checkout(totalb,totali)
  {
    if(confirm('Yakin dengan pesanan anda ?'))
    {
        window.location.href="proses/pro-checkout.php?t=kuy&c1="+totalb+"&c2="+totali+"";
    }
  }
  function del(kodei)
  {
    if(confirm('Yakin ingin menghapus item ?'))
    {
        window.location.href="proses/pro-delete.php?t=del&c="+kodei+"";
    }
  }

  function delall()
  {
    if(confirm('Yakin ingin menghapus semua item ?'))
    {
        window.location.href="proses/pro-delete.php?t=delall";
    }
  }
</script>
