const btnAbrirModal = document.querySelector('#btn-abrir-modal');
const btnCerrarModal = document.querySelector('#btn-cerrar-modal');
const modal1 = document.querySelector('#modalMenus');
const modalEdit = document.querySelector('#EditmodalMenus');

btnAbrirModal.addEventListener('click', () => {
    modal1.showModal();
});

btnCerrarModal.addEventListener('click', () => {
    modal1.close();
});

function init() {
    $("#frm_menus").off("submit").on("submit", function (e) {
        guardarMenu(e);
    });

    $("#frm_edit_menus").off("submit").on("submit", function (e) {
        actualizarMenu(e);
    });

    cargaTabla();
}

$(document).ready(() => {
    init();
});

// Cargar la tabla de menús
var cargaTabla = () => {
    var html = "";

    $.get("/Proyecto/controllers/menu.controller.php?op=listar", (response) => {
        try {
            var listaMenus = JSON.parse(response);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            return;
        }

        if (Array.isArray(listaMenus)) {
            $.each(listaMenus, (indice, unMenu) => {
                html += `
                    <tr>
                        <td>${indice + 1}</td>
                        <td>${unMenu.menu_id}</td>  
                        <td>${unMenu.nombre}</td>
                        <td>${unMenu.descripcion}</td>
                        <td>${unMenu.precio}</td>
                        <td>${unMenu.disponible == 1 ? 'Sí' : 'No'}</td>
                        <td>
                            <button onclick="cargarMenu(${unMenu.menu_id})" class="btn btn-primary">Editar</button>
                            <button onclick="eliminarMenu(${unMenu.menu_id})" class="btn btn-danger">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $("#cuerpoMenus").html(html);
        } else {
            console.error("Expected an array but got:", listaMenus);
        }
    });
};

var guardarMenu = (e) => {
    e.preventDefault();

    var frm_menus = new FormData($("#frm_menus")[0]);
    var ruta = "/Proyecto/controllers/menu.controller.php?op=insertar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_menus,
        contentType: false,
        processData: false,
        
        success: (response) => {
            console.log("Respuesta del servidor:", response);
            Swal.fire({
                title: "Menús",
                text: "El menú ha sido insertado con éxito.",
                icon: "success",
            });
            modal1.close();
            cargaTabla();
        },
        error: () => {
            Swal.fire({
                title: "Menús",
                text: "Ocurrió un error al insertar el menú.",
                icon: "error",
            });
        }
    });
}; 


var actualizarMenu = (e) => {
    e.preventDefault();
    
    var formData = {
        menu_id: $("#Editmenu_id").val(),
        nombre: $("#Editnombre").val(),
        descripcion: $("#Editdescripcion").val(),
        precio: $("#Editprecio").val(),
        disponible: $("#Editdisponible").val()
    };

    $.ajax({
        url: "/Proyecto/controllers/menu.controller.php?op=actualizar",
        type: "POST",
        data: JSON.stringify(formData),
        contentType: "application/json; charset=utf-8",
        success: (response) => {
            console.log("Respuesta del servidor:", response);
            Swal.fire({
                title: "Menús",
                text: "El menú ha sido actualizado con éxito.",
                icon: "success",
            });
            modalEdit.close();
            cargaTabla();
        },
        error: () => {
            Swal.fire({
                title: "Menús",
                text: "Ocurrió un error al actualizar el menú.",
                icon: "error",
            });
        }
    });
};

var eliminarMenu = (menu_id) => {
    Swal.fire({
        title: "Menús",
        text: "¿Está seguro que desea eliminar el menú?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/Proyecto/controllers/menu.controller.php?op=eliminar",
                type: "POST",
                data: JSON.stringify({ menu_id: menu_id }),
                contentType: "application/json; charset=utf-8",
                success: (response) => {
                    console.log("Respuesta del servidor:", response);
                    Swal.fire({
                        title: "Menús",
                        text: "El menú ha sido eliminado.",
                        icon: "success",
                    });
                    cargaTabla();
                },
                error: () => {
                    Swal.fire({
                        title: "Menús",
                        text: "Ocurrió un error al intentar eliminar el menú.",
                        icon: "error",
                    });
                }
            });
        }
    });
};

var cargarMenu = (menu_id) => {
    $.get("/Proyecto/controllers/menu.controller.php?op=uno&menu_id=" + menu_id, (response) => {
        var menu = JSON.parse(response);
        console.log("Menú encontrado:", menu);
        $("#Editmenu_id").val(menu.menu_id);
        $("#Editnombre").val(menu.nombre);
        $("#Editdescripcion").val(menu.descripcion);
        $("#Editprecio").val(menu.precio);
        $("#Editdisponible").val(menu.disponible ? 1 : 0);
        modalEdit.showModal();
    }).fail(() => {
        Swal.fire({
            title: "Menús",
            text: "Ocurrió un error al intentar obtener los datos del menú.",
            icon: "error",
        });
    });
};

init();
