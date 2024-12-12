/* TICKETS */
function crearTicket() {
    document.getElementById('nuevoTicketPopup').style.display = 'block';
}

function cerrarCrearTicket(){
    document.getElementById('nuevoTicketPopup').style.display = 'none';
}

/* CATEGORIAS */ 
function crearCategoria() {
    document.getElementById('nuevaCategoriaPopup').style.display = 'block';
}

// Función para abrir el modal y rellenar los campos para modificar el nombre de la categoria
function editarCategoria(id, nombre) {
    document.getElementById('categoriaId').value = id;
    document.getElementById('categoriaNuevoNombre').value = nombre;
    document.getElementById('editarCategoriaPopup').style.display = 'block';
}

// Función para cerrar el modal
function cerrarEditarCategoria() {
    document.getElementById('editarCategoriaPopup').style.display = 'none';
}

function cerrarCrearCategoria() {
    document.getElementById('nuevaCategoriaPopup').style.display = 'none';
}

// Cerrar el modal si se hace clic fuera de él
window.onclick = function(event) {
    if (event.target === document.getElementById('editarCategoriaPopup')) {
        cerrarEditarCategoria();
    }
    if (event.target === document.getElementById('nuevaCategoriaPopup')) {
        cerrarCrearCategoria();
    }
}
