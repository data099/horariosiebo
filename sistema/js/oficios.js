document.getElementById('addRowBtn').addEventListener('click', function() {
    // Obtener la tabla y su cuerpo
    const table = document.getElementById('signatureTable').getElementsByTagName('tbody')[0];

    // Crear una nueva fila
    const newRow = table.insertRow();

    // Crear y agregar las celdas correspondientes (puesto, nombre, firma)
    const puestoCell = newRow.insertCell(0);
    const nombreCell = newRow.insertCell(1);
    const firmaCell = newRow.insertCell(2);

    // Rellenar las celdas con inputs
    puestoCell.innerHTML = '<input type="text" name="puesto[]" placeholder="Puesto">';
    nombreCell.innerHTML = '<input type="text" name="nombre[]" placeholder="Nombre">';
    firmaCell.innerHTML = '<input type="text" name="firma[]" placeholder="Firma">';
});