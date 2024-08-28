document.getElementById('agregar').addEventListener('click', function() {
    document.getElementById('form-docente').style.display = 'block';
    document.getElementById('form-docente').action = 'agregar_docente.php'; // Asegúrate de que el formulario usa la acción correcta
    document.getElementById('docente_id').value = '';
    document.getElementById('nombre_completo').value = '';
    document.getElementById('perfil').value = '';
    document.getElementById('posgrado').value = '';
    document.getElementById('categoria').value = '';
    document.getElementById('funcion').value = '';
});

document.querySelectorAll('.editar').forEach(button => {
    button.addEventListener('click', function() {
        const row = this.closest('tr');
        document.getElementById('docente_id').value = row.dataset.id;
        document.getElementById('nombre_completo').value = row.children[0].innerText;
        document.getElementById('perfil').value = row.children[1].innerText;
        document.getElementById('posgrado').value = row.children[2].innerText;
        document.getElementById('categoria').value = row.children[3].innerText;
        document.getElementById('funcion').value = row.children[4].innerText;

        document.getElementById('form-docente').style.display = 'block';
        document.getElementById('form-docente').action = 'editar_docente.php'; // Ajusta esto según tu archivo de edición
    });
});