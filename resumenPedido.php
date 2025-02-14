<?php
    session_start();
    if (empty($_SESSION['usuarioRegistrado'])) {
        header("location: ./login.php");
    }else{
      $nombre = $_SESSION['usuarioRegistrado'];
    }

    $direccion= $_REQUEST['direccionDir'];
    $nombreDir= $_REQUEST['nombreDir'];
    $ciudad= $_REQUEST['ciudadDir'];
    $comunidad= $_REQUEST['comunidadDir'];
    $postal= $_REQUEST['codigoDir'];

    //cosas de la BBDD
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "blostebikes";

    $total=0;
    $totalProductos=0;

    $conexion = new mysqli($servername, $username, $password, $dbname);
    if($seleccion = mysqli_query($conexion, "SELECT * FROM carrito WHERE usuario = '$nombre'")){
      while($linea = mysqli_fetch_array($seleccion)){
        $totalProductos=$totalProductos+1;
      }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/x-icon" href="../images/titleBarImage.ico">
    <title>Finalizar Pedido</title>
    <style>
        .gradient-custom {
        /* fallback for old browsers */
        background: #6a11cb;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }
    </style>
</head>
<body>
<?php echo "<p style='color: white;'>p</p>";  ?>
<?php include './elementosVisuales/header.php'; ?>

<section class="bg-light pt-2 pb-2">
  <div class="container">
    <div class="row d-flex justify-content-center my-4">
      <div class="col-md-8">
        <div class="card mb-4">
          <div class="card-header py-3">
            <h5 class="mb-0">Resumen Pedido - <?php echo $totalProductos; ?> producto(s)</h5>
          </div>


          <?php
              if($seleccion = mysqli_query($conexion, "SELECT * FROM carrito WHERE usuario = '$nombre'")){
                while($linea = mysqli_fetch_array($seleccion)){
                  echo "
                    <div class='card-body'>
                      <!-- Single item -->
                      <div class='row'>
                        <div class='col-lg-3 col-md-12 mb-4 mb-lg-0'>
                          <!-- Image -->
                          <div class='bg-image hover-overlay hover-zoom ripple rounded' data-mdb-ripple-color='light'>
                            <img src='".$linea['imagen']."'
                              class='w-100' alt='Blue Jeans Jacket' />
                            <a href='#!'>
                              <div class='mask' style='background-color: rgba(251, 251, 251, 0.2)'></div>
                            </a>
                          </div>
                          <!-- Image -->
                        </div>

                        <div class='col-lg-5 col-md-6 mb-4 mb-lg-0'>
                          <!-- Data -->
                          <p><strong>".$linea['nombreProducto']."</strong></p>
                          <p>Marca: ".$linea['MarcaProducto']."</p>
                          <p>Categoria: ".$linea['categoria']."</p>
                          
                          <!-- Data -->
                        </div>

                        <div class='col-lg-4 col-md-6 mb-4 mb-lg-0'>
                          <!-- Quantity -->
                          <div class='mb-4'>
                            <br>
                            <span class='text-start' style='float:left; margin-right: 10px;'>
                            <strong>".number_format($linea['PrecioProducto'], 2, ',', '.')." €</strong>
                            </span>
                          </div>
                          <!-- Quantity -->

                          <!-- Price -->
                          
                          <!-- Price -->
                        </div>
                      </div>
                      <!-- Single item -->
                      <hr class='my-4' />
                    </div>";
                    $total=$total+$linea['PrecioProducto'];
                }
              }

              if ($totalProductos==0) {
                echo "<div class='card-body'>
                        <h1 align='center'>Lista de Deseos Vacía</h1>
                        <img src='./images/shoppingCart.png'
                              class='w-25 mx-auto d-block mt-3' />
                              <a class='btn btn-success w-50 mx-auto d-block mt-4' href='./index.php' role='button'>Volver</a>
                    </div>";
              }
          ?>

        </div>
        <div class="card mb-4 mb-lg-0">
          <div class="card-body">
            <p><strong>Dirección Pedido</strong></p>
            <p style="margin-left: 20px;"><b>Nombre:</b> <?php echo $nombreDir; ?><br>
            <b>Ciudad:</b> <?php echo $direccion.", ".$ciudad; ?><br>
            <b>Comunidad:</b> <?php echo $comunidad; ?><br>
            <b>Código Postal:</b> <?php echo $postal; ?></p>
          </div>
        </div>
        <div class="card mb-4 mb-lg-0">
          <div class="card-body">
            <p><strong>Formas de Pago</strong></p>
            <img class="me-2" width="45px"
              src="./images/visaLogo.png"
              alt="Visa" />
            <img class="me-2" width="80px"
              src="./images/paypalLogo.png"
              alt="Paypal" />
          </div>
        </div>
      </div>
      <div class="col-md-4 pb-4">
        <div class="card mb-4">
          <div class="card-header py-3">
            <h5 class="mb-0">Resumen Lista Deseos</h5>
          </div>
          <div class="card-body">
            <ul class="list-group list-group-flush">
              <li
                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                Products
                <span><?php echo number_format($total, 2, ',', '.'); ?> €</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                Envío
                <span>Gratis</span>
              </li>
              <li
                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                <div>
                  <strong>Total</strong>
                  <strong>
                    <p class="mb-0">(IVA Incluido)</p>
                  </strong>
                </div>
                <span><strong><?php echo number_format($total, 2, ',', '.'); ?> €</strong></span>
              </li>
            </ul>
            <div>
                <form method="POST" action="./gestionPedido.php">
                    <input name="nomJeje" type="hidden" value="<?php echo $nombreDir; ?>">
                    <input name="dirJeje" type="hidden" value="<?php echo $direccion; ?>">
                    <input name="ciuJeje" type="hidden" value="<?php echo $ciudad; ?>">
                    <input name="comJeje" type="hidden" value="<?php echo $comunidad; ?>">
                    <input name="codJeje" type="hidden" value="<?php echo $postal; ?>">
                    <input name="totalJeje" type="hidden" value="<?php echo $total; ?>">
                    <button class="btn btn-success w-100" type="submit">Finalizar Pedido</button>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include './elementosVisuales/footer.php'; ?>

</body>
</html>