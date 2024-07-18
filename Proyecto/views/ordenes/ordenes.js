const btnAbrirModal = document.querySelector('#btn-abrir-modal');
const btnCerrarModal = document.querySelector('#btn-cerrar-modal');
const modal1 = document.querySelector('#modalOrdenes');
const modalEdit = document.querySelector('#EditmodalOrdenes');

btnAbrirModal.addEventListener('click', () => {
    modal1.showModal();
});

btnCerrarModal.addEventListener('click', () => {
    modal1.close();
});

function init() {
    cargaTabla();
    cargarClienteCombo();
    mostrarMenuDisponible();

    $("#frm_ordenes").off('submit').on("submit", function (e) {
        guardarOrden(e);
    });

    $("#btn-cerrar-modal-detalles").on("click", function () {
        $("#modalTablaDetallesOrden").get(0).close();
    });

    $('#frm_detalles_orden').off('submit').on("submit", function (e) {
        guardarDetalleOrden(e);
    });

    $(document).on("click", ".btn-actualizar-cantidad", function () {
        var detalle_id = $(this).data("detalle-id");
        actualizarCantidad(detalle_id);
    });
}

$(document).ready(() => {
    init();
});

var cargaTabla = () => {
    var html = "";

    $.get("/Proyecto/controllers/orden.controller.php?op=listar", (response) => {
        try {
            var listaOrdenes = JSON.parse(response);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return;
        }

        if (Array.isArray(listaOrdenes)) {
            $.each(listaOrdenes, (indice, unaOrden) => {
                html += `
                    <tr> 
                        <td>${unaOrden.orden_id}</td>
                        <td>${unaOrden.cliente_id}</td>
                        <td>${unaOrden.nombre}</td>
                        <td>${unaOrden.apellido}</td>
                        <td>${unaOrden.fecha}</td>
                        <td>${unaOrden.total}</td>
                        <td>
                            <button onclick="mostrarDetallesOrden(${unaOrden.orden_id})" class="btn btn-primary btn-abrir-modal">Detalles</button>
                            <button class="btn btn-danger" onclick="eliminarOrden(${unaOrden.orden_id})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $("#cuerpoOrdenes").html(html);
        } else {
            console.error("Expected an array but got:", listaOrdenes);
        }
    });
};


var cargarClienteCombo = () => {
    var ruta = "/Proyecto/controllers/cliente.controller.php?op=listar";
    $.get(ruta, (response) => {
        var listaClientes = JSON.parse(response);
        var html = "<option value=''>Seleccione un cliente</option>";
        $.each(listaClientes, (indice, unoCliente) => {
            html += `<option value='${unoCliente.id_cliente}'> ${unoCliente.id_cliente} - ${unoCliente.nombre} ${unoCliente.apellido}</option>`;
        });
        $("#cliente_id").html(html);
    });
}


var guardarOrden = (e) => {
    e.preventDefault();

    var frm_ordenes = new FormData($("#frm_ordenes")[0]);
    var ruta = "/Proyecto/controllers/orden.controller.php?op=insertar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_ordenes,
        contentType: false,
        processData: false,

        success: (response) => {
            console.log("Respuesta del servidor:", response);
            Swal.fire({
                title: "Órdenes",
                text: "La orden ha sido insertada con éxito.",
                icon: "success",
            });
            modal1.close();
            cargaTabla();
        },
        error: () => {
            Swal.fire({
                title: "Órdenes",
                text: "Ocurrió un error al insertar la orden.",
                icon: "error",
            });
        }
    });
};


var eliminarOrden = (orden_id) => {
    Swal.fire({
        title: "Órdenes",
        text: "¿Está seguro que desea eliminar la orden?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/Proyecto/controllers/orden.controller.php?op=eliminar",
                type: "POST",
                data: {
                    orden_id: orden_id
                },
                success: (response) => {
                    console.log("Respuesta del servidor:", response);
                    Swal.fire({
                        title: "Órdenes",
                        text: "La orden ha sido eliminada.",
                        icon: "success",
                    });
                    cargaTabla();
                },
                error: () => {
                    Swal.fire({
                        title: "Órdenes",
                        text: "Ocurrió un error al intentar eliminar la orden.",
                        icon: "error",
                    });
                }
            });
        }
    });
};


var mostrarDetallesOrden = (orden_id) => {
    var ruta = "/Proyecto/controllers/orden.controller.php?op=obtenerDetallesOrden&orden_id=" + orden_id;
    $.get(ruta, (response) => {
        try {
            var listaDetalles = JSON.parse(response);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return;
        }

        if (Array.isArray(listaDetalles)) {
            var html = "";
            $.each(listaDetalles, (indice, unDetalle) => {
                html += `
                    <tr id="detalle-${unDetalle.detalle_id}">
                        <td>${indice + 1}</td>
                        <td>${unDetalle.nombre}</td>
                        <td>${unDetalle.precio}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="cambiarCantidad(${unDetalle.detalle_id}, 1)">+</button>
                            <span id="cantidad-${unDetalle.detalle_id}">${unDetalle.cantidad}</span>
                            <button class="btn btn-primary btn-sm" onclick="cambiarCantidad(${unDetalle.detalle_id}, -1)">-</button>
                        </td>
                        <td id="subtotal-${unDetalle.detalle_id}">${unDetalle.subtotal}</td>
                        <td>
                            <button class="btn btn-danger" onclick="eliminarDetalle(${unDetalle.detalle_id})">Eliminar</button>
                        </td>
                        <td>
                            <button class="btn btn-success btn-actualizar-cantidad" data-detalle-id="${unDetalle.detalle_id}">Modificar</button>
                        </td>
                    </tr>
                `;
            });
            $("#orden_id_detalle").val(orden_id);
            $("#cuerpoTablaDetallesOrden").html(html);
            document.getElementById("modalTablaDetallesOrden").showModal();
        } else {
            console.error("Expected an array but got:", listaDetalles);
        }
    }).fail((jqXHR, textStatus, errorThrown) => {
        console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
    });
};



var cambiarCantidad = (detalle_id, cambio) => {
    var cantidadElemento = $(`#cantidad-${detalle_id}`);
    var nuevaCantidad = parseInt(cantidadElemento.text()) + cambio;
    if (nuevaCantidad < 1) {
        nuevaCantidad = 1;  // Evitar cantidades menores a 1
    }
    cantidadElemento.text(nuevaCantidad);
};


var actualizarCantidad = (detalle_id) => {
    var nueva_cantidad = parseInt($(`#cantidad-${detalle_id}`).text());
    console.log("Detalle ID:", detalle_id);
    console.log("Nueva cantidad:", nueva_cantidad);

    var ruta = "/Proyecto/controllers/orden.controller.php?op=actualizarDetalle";
    $.ajax({
        url: ruta,
        type: "POST",
        data: {
            detalle_id: detalle_id,
            cantidad: nueva_cantidad
        },
        success: (response) => {
            console.log("Respuesta del servidor:", response);
            var respuesta = JSON.parse(response);
            if (respuesta.message) {
                Swal.fire({
                    title: "Órdenes",
                    text: "El detalle del pedido ha sido actualizado con éxito.",
                    icon: "success",
                });

                // Actualizar la tabla principal
                mostrarDetallesOrden($("#orden_id_detalle").val());
                cargaTabla();
            } else {
                Swal.fire({
                    title: "Órdenes",
                    text: "Ocurrió un error al actualizar el detalle del pedido.",
                    icon: "error",
                });
            }
        },
        error: () => {
            Swal.fire({
                title: "Órdenes",
                text: "Ocurrió un error al actualizar el detalle del pedido.",
                icon: "error",
            });
        }
    });
};


var guardarDetalleOrden = (e) => {
    e.preventDefault();

    var frm_detalles_orden = new FormData($("#frm_detalles_orden")[0]);
    var ruta = "/Proyecto/controllers/orden.controller.php/?op=insertarDetalleOrden";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_detalles_orden,
        contentType: false,
        processData: false,

        success: (response) => {
            console.log("Respuesta del servidor:", response);
            Swal.fire({
                title: "Órdenes",
                text: "El detalle del pedido ha sido insertado con éxito.",
                icon: "success",
            });
            cargaTabla();
            // Extraer el ID de la orden del formulario
            var orden_id = $("#orden_id_detalle").val();

            // Recargar la tabla de detalles
            mostrarDetallesOrden(orden_id);
        },
        error: () => {
            Swal.fire({
                title: "Órdenes",
                text: "Ocurrió un error al insertar el detalle del pedido.",
                icon: "error",
            });
        }
    });
};


var eliminarDetalle = (detalle_id) => {
    console.log("Detalle ID:", detalle_id);
    $.ajax({
        url: "/Proyecto/controllers/orden.controller.php?op=eliminarDetalle",
        type: "POST",
        data: {
            detalle_id: detalle_id
        },
        success: (response) => {
            console.log("Respuesta del servidor:", response);
            var orden_id = $("#orden_id_detalle").val();
            mostrarDetallesOrden(orden_id);
            cargaTabla();
        },
        error: () => {
            console.error("Ocurrió un error al intentar eliminar el detalle del pedido.");
        }
    });
};

var mostrarMenuDisponible = () => {
    var ruta = "/Proyecto/controllers/menu.controller.php?op=listarMenuDisponible";
    $.get(ruta, (response) => {
        var listaMenu = JSON.parse(response);
        var html = "<option value=''>Seleccione un plato</option>";
        $.each(listaMenu, (indice, unMenu) => {
            html += `<option value='${unMenu.nombre}'> ${unMenu.nombre} - ${unMenu.precio}</option>`;
        });
        $("#menu_detalle").html(html);
    });
};


init();