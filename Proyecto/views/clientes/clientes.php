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
  <link rel="stylesheet" href="clientes.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
      <li><a href="../clientes/clientes.php">Clientes</a></li>
      <li><a href="../menus/menus.php">Menus</a></li>
      <li><a href="../ordenes/ordenes.php">Ordenes</a></li>
    </ul>
  </nav>

  <section>

    <h1 style="margin-left: 50rem; margin-top: 2rem;">CRUD CLIENTES</h1>

    <dialog class="bg-slate-50 rounded px-10 py-2 border shadow-custom2" id="modalClientes">
      <form id="frm_clientes" enctype="multipart/form-data">
        <h3 class="text-center py-2 text-2xl">Registro de Clientes</h3>
        <div class="flex flex-col gap-10">
          <div class="mb-3">
            <label for="id_cliente">Identificación de Cliente:</label>
            <input class="border rounded text-accent form-control" type="text" name="id_cliente" id="id_cliente" required>
          </div>
          <div class="mb-3">
            <label for="nombre">Nombre:</label>
            <input class="border rounded text-accent form-control" type="text" name="nombre" id="nombre" required>
          </div>
          <div class="mb-3">
            <label for="apellido">Apellido:</label>
            <input class="border rounded text-accent form-control" type="text" name="apellido" id="apellido" required>
          </div>
          <div class="mb-3">
            <label for="email">Correo:</label>
            <input class="border rounded text-accent form-control" type="email" name="email" id="email" required>
          </div>
          <div class="mb-3">
            <label for="telefono">Teléfono:</label>
            <input class="border rounded text-accent form-control" type="text" name="telefono" id="telefono" required>
          </div>
          <div class="modal-footer flex justify-content-center mb-3">
            <button type="submit" class="btn btn-secondary px-10 mx-3">Guardar</button>
            <button type="button" class="btn btn-secondary" id="btn-cerrar-modal">Cancelar</button>
          </div>
        </div>
      </form>
    </dialog>


    <dialog class="bg-slate-50 rounded px-10 py-2 border shadow-custom2" id="EditmodalClientes">
      <form id="frm_edit_clientes" enctype="multipart/form-data">
        <h3 class="text-center py-2 text-2xl">Actualización de Cliente</h3>
        <div class="flex flex-col gap-10">
          <div class="mb-3">
            <label for="Editid_cliente">Identificación de Cliente:</label>
            <input class="border rounded text-accent form-control" type="text" name="Editid_cliente" id="Editid_cliente" required>
          </div>
          <div class="mb-3">
            <label for="Editnombre">Nombre:</label>
            <input class="border rounded text-accent form-control" type="text" name="Editnombre" id="Editnombre" required>
          </div>
          <div class="mb-3">
            <label for="Editapellido">Apellido:</label>
            <input class="border rounded text-accent form-control" type="text" name="Editapellido" id="Editapellido" required>
          </div>
          <div class="mb-3">
            <label for="Editemail">Correo:</label>
            <input class="border rounded text-accent form-control" type="email" name="Editemail" id="Editemail" required>
          </div>
          <div class="mb-3">
            <label for="Edittelefono">Teléfono:</label>
            <input class="border rounded text-accent form-control" type="text" name="Edittelefono" id="Edittelefono" required>
          </div>
          <div class="modal-footer flex justify-content-center mb-3">
            <button type="submit" class="btn btn-secondary px-10 mx-3">Guardar</button>
            <button type="button" class="btn btn-secondary" id="btn-cerrar-modal-edit">Cancelar</button>
          </div>
        </div>
      </form>
    </dialog>

    <button style="margin-left: 18rem;" id="btn-abrir-modal" type="button" class="btn btn-success mb-3 mt-5" data-bs-toggle="modalCliente" data-bs-target="#modalCliente">
      <i class="bi bi-bag-plus-fill mx-2"></i> Añadir Cliente
    </button>

    <br>

    <div class="table-container">
      <table class="table table-bordered table-striped table-hover table-responsive">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">id_cliente</th>
            <th scope="col">nombre</th>
            <th scope="col">apellido</th>
            <th scope="col">email</th>
            <th scope="col">telefono</th>
          </tr>
        </thead>
        <tbody id="cuerpoClientes">
        </tbody>
      </table>
    </div>
  </section>

  <script src="clientes.js"></script>

  <h1>CRUD CLIENTES</h1>
  </section>
</body>

</html>