<?php
include 'proses/koneksi.php';
session_start();

$BatasAwal = 6;
if (!empty($_GET['page'])) {
  $hal = $_GET['page'] - 1;
  $MulaiAwal = $BatasAwal * $hal;
} else if (!empty($_GET['page']) and $_GET['page'] == 1) {
  $MulaiAwal = 0;
} else if (empty($_GET['page'])) {
  $MulaiAwal = 0;
}

if (empty($_GET['p'])) {
  $qrload = $conn->prepare("SELECT * FROM tbbarang ORDER BY idBarang DESC LIMIT $MulaiAwal , $BatasAwal");
  $qrload->execute();
}
else {
  $page = $_GET['p'];
  if ($page == 'makanan') {
    $qrload = $conn->prepare("SELECT * FROM tbbarang WHERE jnBarang = 'MAKANAN' ORDER BY idBarang DESC");
    $qrload->execute();
  } elseif ($page == 'minuman') {
    $qrload = $conn->prepare("SELECT * FROM tbbarang WHERE jnBarang = 'MINUMAN' ORDER BY idBarang DESC");
    $qrload->execute();
  }
}
?>

<html>
<head>
    <title>WA Repi</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/fork.png" sizes="16x16">
</head>
<body>
<div class="card">
  <div class="header">
    <h1>WAROENG ABAH REPI</h1>
  </div>
    <div class="topnav">
      <a href="index.php?p=">HOME</li></a>
      <a href="index.php?p=makanan">MAKANAN</li></a>
      <a href="index.php?p=minuman">MINUMAN </li></a>
      <?php
      if (isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        echo '<a>USER : '.$user.'</a>';
        echo '<div class="button_kanan" style="float:right;padding-left:10px;padding-right:10px;padding-top:12px;">';
        include "btn_logout.php";
        echo '</div>';
      }
      else {
        echo '<div class="button_kanan" style="float:right;padding-left:10px;padding-right:10px;padding-top:12px;padding-bottom:15px;">';
        include "btn_login.php";
        echo '</div>';
        echo '<div class="button_kanan" style="float:right;padding-left:10px;padding-right:10px;padding-top:12px;padding-bottom:15px;">';
        include "btn_signup.php";
        echo '</div>';
      }
      ?>
    </div>

<div class="row">
  <div class="column side">
    <div style="overflow: hidden;background-color: #333;color:white;">
      <p style="height:100$;"><center>Kategori</center></p>
    </div>
    <div>
      <ul>
        <li><a href="index.php?p=makanan">MAKANAN</a></li>
        <li><a href="index.php?p=minuman">MINUMAN</a></li>
      </ul>
    </div>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
    <div style="overflow: hidden;background-color: #333;color:white;">
      <p style='height:100$;'><center>Cek Transaksi</center></p>
    </div>
    <div>
    <input name="idtransaksi" id="idtransaksi" type="text" placeholder="Input Transaction ID here">
    <button type='button' class='btnbayar' onclick='printOut();'>Check</button>
    </div>
  </div>

  <form action="proses/pro-keranjang.php" method="GET">
  <div class="column middle">
    <div style="overflow: hidden;background-color: #333;color:white;">
        <p style='height:100$;'><center>Menu Makanan dan Minuman</center></p>
    </div>

      <div class='card'>
        <?php
        while ($row = $qrload->fetch(PDO::FETCH_OBJ)) {
          echo "
              <div class='konten'>
                <div class='konten pcs'>
                <p><img class='gambar-gambar' src='gambar/".$row->gambar. "' style='height:300px;width:350px ;padding:5px;object-fit: cover;''></p>
                <p>Nama : ".$row->nmBarang."</p>
                <p>Harga : ".$row->harga."</p>
                <p>Stok : ".$row->stok."</p>
                <button style='background-color: #ff7c11;' type='button' onclick='kirimkrj(\"".$row->idBarang."\");'>Add to Cart</button>
                </div>
              </div>
            ";
        }
        echo "<center>";
        if (empty($_GET['p'])) {
        // <!-- navigasi -->

          $cekQuery = $conn->prepare('SELECT * FROM tbbarang');
	        $cekQuery->execute();
          $jumlahData = $cekQuery->rowCount();
          if ($jumlahData > $BatasAwal) {
            echo '<br/><left><div style="display: inline-block;">';
            $a = explode(".", $jumlahData / $BatasAwal);
            $b = $a[0];
            $c = $b + 1;
            for ($i = 1; $i <= $c; $i++) {
              echo '<a style="color: black;float: left;padding: 8px 16px;text-decoration: none;transition: background-color .3s;border: 1px solid #ddd;margin: 0 4px;';
              if ($_GET['page'] == $i) {
                echo 'color:orange';
              }
              echo '" href="?page=' . $i . '">' . $i . '</a>';
            }
            echo '</div></left>';
          } else {
          }
        }
        echo "</center>";

        ?>
      </div>

  </div>
  </form>
  <div class="column sideright">
    <!-- <div style='background-color: #4caf50; color: white; border: dashed; height:55px;'> -->
    <div style="overflow: hidden;background-color: #333;color:white;">
        <p style='height:100$;'><center>Keranjang Belanja</center></p>
    </div>
    <br>
    <div style='border: groove;'>
      <?php include 'proses/pro-loadkeranjang.php'; ?>
    </div>
  </div>

</div>

<div class="footer">
  <p>Made by Risjad Muhammad Reviansyah &copy; 2018</p>
</div>

</body>
</div>
</html>


<script>
  function printOut()
  {
      var cid = document.getElementById('idtransaksi').value;
      if(cid =='')
      {
          alert('Silahkan isi ID Transaksi Dahulu!');
      }
      else
      {
          window.location.href="page/output.php?c="+cid+"";
      }

  }


  function kirimkrj(idbarang)
  {
      if(confirm('Tambahkan ke keranjang ?'))
      {
        <?php
        if (empty($_SESSION['user'])) {
        ?>alert('Silahkan Login Dahulu!');<?php
        }
        else{
        ?>window.location.href="proses/pro-keranjang.php?c="+idbarang+"";<?php
        }
      ?>
      }
  }
</script>
