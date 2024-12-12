
    /* TICKETS */
    function crearTicket() {
        document.getElementById('nuevoTicketPopup').style.display = 'block';
    }

    function cerrarCrearTicket(){
        document.getElementById('nuevoTicketPopup').style.display = 'none';
    }

    // Función para abrir el modal y rellenar los campos para modificar el nombre del ticket
    function editarTicket(id, nombre) {
        document.getElementById('ticketId').value = id;
        document.getElementById('ticketNuevoNombre').value = nombre;
        document.getElementById('editarTicketPopup').style.display = 'block';
    }

    // Función para cerrar el modal
    function cerrarEditarTicket() {
        document.getElementById('editarTicketPopup').style.display = 'none';
    }

    /* CATEGORIAS */ 
    function crearCategoria() {
        document.getElementById('nuevaCategoriaPopup').style.display = 'block';
    }

    function cerrarCrearCategoria() {
        document.getElementById('nuevaCategoriaPopup').style.display = 'none';
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

    // Cerrar el modal si se hace clic fuera de él
    window.onclick = function(event) {
        if (event.target === document.getElementById('editarCategoriaPopup')) {
            cerrarEditarCategoria();
        }
        if (event.target === document.getElementById('nuevaCategoriaPopup')) {
            cerrarCrearCategoria();
        }
    }

    // Función para abrir el detalle de los tickets
    window.handleRowClick = function (event, row) {
        // Evita la acción si se hace clic en un enlace o botón dentro del <tr>
        if (event.target.closest('a') || event.target.closest('button')) {
            return;
        }

        // Navega a la URL especificada en el atributo data-url
        const url = row.getAttribute('data-url');
        if (url) {
            window.location.href = url;
        }

    };
