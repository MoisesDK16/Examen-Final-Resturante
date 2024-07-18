const btnAbrirModal = document.querySelector('#btn-abrir-modal');
const btnCerrarModal = document.querySelector('#btn-cerrar-modal');
const modal1 = document.querySelector('#modalClientes');
const modalEdit = document.querySelector('#EditmodalClientes');

btnAbrirModal.addEventListener('click', () => {
    modal1.showModal();
});

btnCerrarModal.addEventListener('click', () => {
    modal1.close();
});

function init() {
    cargaTabla();

    $("#frm_clientes").on("submit", function (e) {
        insertar(e);
    });

    $("#frm_edit_clientes").on("submit", function (e) {
        editar(e);
    });
}

$(document).ready(() => {
    init();
});


// Cargar la tabla de clientes
var cargaTabla = () => {
    var html = "";

    $.get("/Proyecto/controllers/cliente.controller.php?op=listar", (response) => {
        try {
            var listaClientes = JSON.parse(response);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return;
        }

        if (Array.isArray(listaClientes)) {
            $.each(listaClientes, (indice, unoCliente) => {
                html += `
                    <tr>
                        <td>${indice + 1}</td>  
                        <td>${unoCliente.id_cliente}</td>  
                        <td>${unoCliente.nombre}</td>
                        <td>${unoCliente.apellido}</td>
                        <td>${unoCliente.email}</td>
                        <td>${unoCliente.telefono}</td>
                        <td>
                            <button onclick="cargarCliente('${unoCliente.id_cliente}')" class="btn btn-primary">Editar</button>
                            <button onclick="eliminarCliente('${unoCliente.id_cliente}')" class="btn btn-danger">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $("#cuerpoClientes").html(html);
        } else {
            console.error("Expected an array but got:", listaClientes);
        }
    });
};

var cargarCliente = (id_cliente) => {
    $.get("/Proyecto/controllers/cliente.controller.php?op=uno&id_cliente=" + id_cliente, (response) => {
        var cliente;
        try {
            cliente = JSON.parse(response);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return;
        }

        if (cliente) {
            console.log("Cliente encontrado:", cliente);
            $("#Editid_cliente").val(cliente.id_cliente);
            $("#Editnombre").val(cliente.nombre);
            $("#Editapellido").val(cliente.apellido);
            $("#Editemail").val(cliente.email);
            $("#Edittelefono").val(cliente.telefono);
            modalEdit.showModal();
        } else {
            console.error("Cliente no encontrado");
        }
    });
};


var insertar = (e) => {
    e.preventDefault();
    var frm_clientes = new FormData($("#frm_clientes")[0]);
    var ruta = "/Proyecto/controllers/cliente.controller.php?op=insertar";


    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_clientes,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            $("#frm_clientes")[0].reset();
            modal1.close();
            cargaTabla();
        }
    });
};


var editar = (e) => {
    e.preventDefault();
    var frm_edit_clientes = new FormData($("#frm_edit_clientes")[0]);
    var ruta = "/Proyecto/controllers/cliente.controller.php?op=actualizar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_edit_clientes,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            modalEdit.close();
            cargaTabla();
        }
    });
};


var eliminarCliente = (id_cliente) => {
    Swal.fire({
        title: "Clientes",
        text: "¿Está seguro que desea eliminar el cliente?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/Proyecto/controllers/cliente.controller.php?op=eliminar",
                type: "POST",
                data: { id_cliente: id_cliente},
                success: (resultado) => {
                    console.log("Respuesta del servidor:", resultado);
                    try {
                        let response = JSON.parse(resultado);
                        if (response.message.includes("éxito")) {
                            Swal.fire({
                                title: "Clientes",
                                text: "El Cliente ha sido eliminado.",
                                icon: "success",
                            });
                            cargaTabla();
                        } else {
                            Swal.fire({
                                title: "Clientes",
                                text: response.message || "No se pudo eliminar el Cliente.",
                                icon: "error",
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            title: "Clientes",
                            text: "No se pudo eliminar el cliente debido a un error.",
                            icon: "error",
                        });
                        console.error("Error al parsear JSON:", e);
                    }
                },
                error: () => {
                    Swal.fire({
                        title: "Clientes",
                        text: "Ocurrió un error al intentar eliminar el cliente",
                        icon: "error",
                    });
                }
            });
        }
    });
};


init();