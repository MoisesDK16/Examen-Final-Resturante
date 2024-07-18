<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Menús</title>
    <link rel="stylesheet" href="../estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="menus.css">
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
        <h1 style="margin-left: 50rem; margin-top: 2rem;">CRUD MENÚS</h1>

        <dialog class="bg-slate-50 rounded px-10 py-2 border shadow-custom2" id="modalMenus">
            <form id="frm_menus" enctype="multipart/form-data">
                <h3 class="text-center py-2 text-2xl">Registro de Menús</h3>
                <div class="flex flex-col gap-10">
                    <div class="mb-3">
                        <label for="nombre">Nombre:</label>
                        <input class="border rounded text-accent form-control" type="text" name="nombre" id="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion">Descripción:</label>
                        <input class="border rounded text-accent form-control" type="text" name="descripcion" id="descripcion" required>
                    </div>
                    <div class="mb-3">
                        <label for="precio">Precio:</label>
                        <input class="border rounded text-accent form-control" type="number" step="0.01" name="precio" id="precio" required>
                    </div>
                    <div class="mb-3">
                        <label for="disponible">Disponible:</label>
                        <select class="border rounded text-accent form-control" name="disponible" id="disponible" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="modal-footer flex justify-content-center mb-3">
                        <button type="submit" class="btn btn-secondary px-10 mx-3">Guardar</button>
                        <button type="button" class="btn btn-secondary" id="btn-cerrar-modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </dialog>


        <dialog class="bg-slate-50 rounded px-10 py-2 border shadow-custom2" id="EditmodalMenus">
            <form id="frm_edit_menus" enctype="multipart/form-data">
                <h3 class="text-center py-2 text-2xl">Actualización de Menú</h3>
                <div class="flex flex-col gap-10">
                    <div class="mb-3">
                        <!-- <label for="Editmenu_id">ID del Menú:</label> -->
                        <input class="border rounded text-accent form-control" type="hidden" name="Editmenu_id" id="Editmenu_id" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="Editnombre">Nombre:</label>
                        <input class="border rounded text-accent form-control" type="text" name="Editnombre" id="Editnombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="Editdescripcion">Descripción:</label>
                        <input class="border rounded text-accent form-control" type="text" name="Editdescripcion" id="Editdescripcion" required>
                    </div>
                    <div class="mb-3">
                        <label for="Editprecio">Precio:</label>
                        <input class="border rounded text-accent form-control" type="number" step="0.01" name="Editprecio" id="Editprecio" required>
                    </div>
                    <div class="mb-3">
                        <label for="Editdisponible">Disponible:</label>
                        <select class="border rounded text-accent form-control" name="Editdisponible" id="Editdisponible" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="modal-footer flex justify-content-center mb-3">
                        <button type="submit" class="btn btn-secondary px-10 mx-3">Guardar</button>
                        <button type="button" class="btn btn-secondary" id="btn-cerrar-modal-edit">Cancelar</button>
                    </div>
                </div>
            </form>
        </dialog>


        <button style="margin-left: 18rem;" id="btn-abrir-modal" type="button" class="btn btn-success mb-3 mt-5">
            <i class="bi bi-bag-plus-fill mx-2"></i> Añadir Menú
        </button>

        <br>

        <div class="table-container">
            <table class="table table-bordered table-striped table-hover table-responsive">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID de Menú</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Disponible</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="cuerpoMenus">
                </tbody>
            </table>
        </div>
    </section>

    <script src="menus.js"></script>
</body>

</html>