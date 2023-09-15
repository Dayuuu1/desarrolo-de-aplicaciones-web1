<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sistema de venta</title>
  <link rel="shortcut icon" href="assets/img/logito.png">
  <link rel="stylesheet" href="assets/css/loging.css">

</head>

<body>
  <header style="top: 0;">

  </header>
  <form action="controller/UsuarioController.php" class="user" method="post" accept-charset="utf-8">
    <div class="square abs-img abs-img-1 has-before" data-parallax-item data-parallax-speed="1.75">


      <i style="--clr:#fffd44;"></i>
      <div class="login">
        <h2>Iniciar sesion</h2>
        <div class="inputBx">
          <input type="text" placeholder="nombre" name="nombre" id="nombre" autocomplete="off">
        </div>
        <div class="inputBx">
          <input type="password" placeholder="contraseña" name="contraseña" id="contraseña">
        </div>
        <div class="inputBx">
          <input type="submit" value="Iniciar" name="login" id="login">
        </div>
        <div class="links">
          <a href="#">Olvidaste tu Contraseña?</a>
        </div>
      </div>
    </div>
  </form>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    const parallaxItems = document.querySelectorAll("[data-parallax-item]");

    let x, y;

    window.addEventListener("mousemove", function(event) {

      x = (event.clientX / window.innerWidth * 10) - 5;
      y = (event.clientY / window.innerHeight * 10) - 5;

      // reverse the number eg. 20 -> -20, -5 -> 5
      x = x - (x * 2);
      y = y - (y * 2);

      for (let i = 0, len = parallaxItems.length; i < len; i++) {
        x = x * Number(parallaxItems[i].dataset.parallaxSpeed);
        y = y * Number(parallaxItems[i].dataset.parallaxSpeed);
        parallaxItems[i].style.transform = `translate3d(${x}px, ${y}px, 0px)`;
      }

    });
  </script>
  <?php
  
  if (isset($_SESSION['success_message'])) {
    echo '<script type="text/javascript">';
    echo "Swal.fire({
			icon: 'error',
			title: 'Oops...',
			text: '{$_SESSION['success_message']}'
		});";
    echo '</script>';
    unset($_SESSION['success_message']);
  }
  ?>
</body>

</html>