<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Órdenes</title>
    <link rel="stylesheet" href="../estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="ordenes.css">
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
        <h1 style="margin-left: 50rem; margin-top: 2rem;">ÓRDENES</h1>

        <dialog class="bg-slate-50 rounded px-10 py-2 border shadow-custom2" id="modalOrdenes">
            <form id="frm_ordenes" enctype="multipart/form-data">
                <h3 class="text-center py-2 text-2xl">Registro de Órdenes</h3>
                <div class="flex flex-col gap-10">
                    <div class="mt-4 mb-5">
                        <label for="cliente_id">ID del Cliente:</label>
                        <!-- <input class="border rounded text-accent form-control" type="text" name="cliente_id" id="cliente_id" required> -->

                        <select style="width: 20rem;" id="cliente_id" name="cliente_id">

                        </select>
                    </div>
                    <div class="modal-footer flex justify-content-center mb-3">
                        <button type="submit" class="btn btn-secondary px-10 mx-3">Guardar</button>
                        <button type="button" class="btn btn-secondary" id="btn-cerrar-modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </dialog>

        <!-- <dialog class="bg-slate-50 rounded px-10 py-2 border shadow-custom2" id="EditmodalOrdenes">
            <form id="frm_edit_ordenes" enctype="multipart/form-data">
                <h3 class="text-center py-2 text-2xl">Actualización de Órdenes</h3>
                <div class="flex flex-col gap-10">
                    <div class="mb-3">
                        <label for="Editorden_id">ID de la Orden:</label>
                        <input class="border rounded text-accent form-control" type="text" name="Editorden_id" id="Editorden_id" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="Editcliente_id">ID del Cliente:</label>
                        <input class="border rounded text-accent form-control" type="text" name="Editcliente_id" id="Editcliente_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="Edittotal">Total:</label>
                        <input class="border rounded text-accent form-control" type="number" step="0.01" name="Edittotal" id="Edittotal" required>
                    </div>
                    <div class="modal-footer flex justify-content-center mb-3">
                        <button type="submit" class="btn btn-secondary px-10 mx-3">Guardar</button>
                        <button type="button" class="btn btn-secondary" id="btn-cerrar-modal-edit">Cancelar</button>
                    </div>
                </div>
            </form>
        </dialog> -->


        <dialog class="bg-slate-50 rounded px-10 py-2 border shadow-custom2" id="modalTablaDetallesOrden">
            <form id="frm_detalles_orden" enctype="multipart/form-data">
                <div class="mb-3">
                    <input class="border rounded text-accent form-control" type="hidden" name="orden_id_detalle" id="orden_id_detalle">
                </div>
                <div class="mb-3">
                    <label for="menu_detalle">Menu</label>
                    <select style="width: 30rem;" id="menu_detalle" name="menu_detalle"></select>
                </div>
                <div class="mb-0">
                    <label for="cantidad_detalle">Cantidad</label>
                    <input class="border rounded text-accent form-control" type="text" name="cantidad_detalle" id="cantidad_detalle">
                </div>
                <button onclick="guardarDetalleOrden()" style="margin-left: 15rem;" id="btn-agregarDetalle" type="submit" class="btn btn-success mb-3 mt-5">
                    <i class="bi bi-bag-plus-fill"></i>Añadir Detalle
                </button>
            </form>
            <h3 class="text-center py-2 text-2xl">Detalles de la Orden</h3>
            <div class="table-container">
                <table class="table table-bordered table-striped table-hover table-responsive">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre del Menú</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Accion</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoTablaDetallesOrden"></tbody>
                </table>
            </div>
            <div class="modal-footer flex justify-content-center mb-3">
                <button type="button" class="btn btn-secondary" id="btn-cerrar-modal-detalles">Cerrar</button>
            </div>
        </dialog>


        <button style="margin-left: 18rem;" id="btn-abrir-modal" type="button" class="btn btn-success mb-3 mt-5">
            <i class="bi bi-bag-plus-fill mx-2"></i> Añadir Orden
        </button>

        <br>

        <div class="table-container">
            <table class="table table-bordered table-striped table-hover table-responsive">
                <thead>
                    <tr>
                        <th scope="col">ID de la Orden</th>
                        <th scope="col">Identificacion_Cliente</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Total</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="cuerpoOrdenes">
                </tbody>
            </table>
        </div>
    </section>

    <script src="ordenes.js"></script>
</body>

</html>