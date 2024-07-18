<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menú Responsive</title>
  <link rel="stylesheet" href="../estilos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="productos.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <nav>
    <input type="checkbox" id="check">
    <label for="check" class="checkbtn">
      <i class="fas fa-bars"></i>
    </label>
    <a href="#" class="enlace">
      <img src="https://i.pinimg.com/1200x/0b/37/d2/0b37d2d7bfa695c05f0337d8a3473d54.jpg" alt="Logo" class="logo">
    </a>
    <ul>
      <li><a href="../index.html">Inicio</a></li>
      <li><a href="../productos/productos.php">Productos</a></li>
      <li><a href="../clientes/clientes.php">Clientes</a></li>
      <li><a href="../menus/menus.php">Menus</a></li>
      <li><a href="#">Contacto</a></li>
    </ul>
  </nav>
  <section>
    <h1 style="margin-left: 50rem; margin-top: 2rem;">CRUD PRODUCTOS</h1>
    <br>

    <div class="table-container">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">id_producto</th>
            <th scope="col">nombre_producto</th>
            <th scope="col">precio</th>
          </tr>
        </thead>
        <tbody id="">
        </tbody>
      </table>
    </div>

  </section>
</body>

</html>