<html>
<head>
    <link rel="stylesheet" href="login.css">
</head>

<body>
<button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Sign Up</button>

<div id="id02" class="modal">
  
  <form class="modal-content animate" action="proses/pro-signup.php" method="POST">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
      <!-- <img src="user-id.png" alt="Avatar" class="avatar"> -->
    </div>

    <div class="container">
      <label><b>Username</b></label>
      <input type="text" placeholder="Input username here" name="username" required>
      
      <label><b>Password</b></label>
      <input type="password" placeholder="Input Password here" name="password" required>

      <label><b>Name</b></label>
      <input type="text" placeholder="Input Name here" name="name" required>

      <label><b>Status</b></label>
      <input type="text" placeholder="Input Status here" name="status" required>
    
      <button type="submit" name="submit" value="Login">Sign Up</button>
      <input type="checkbox" checked="checked"> Remember me
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
      <!-- <span class="psw">Forgot <a href="#">password?</a></span> -->
    </div>
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id02');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</body>
</html>
