$(document).ready(function() {
    // Función para agregar filas en el segundo oficio
    $('#addRowBtnDos').on('click', function() {
        $('#signatureTableDos tbody').append('<tr><td><input type="text" name="puesto_dos[]" placeholder="Puesto"></td><td><input type="text" name="nombre_dos[]" placeholder="Nombre"></td><td><input type="text" name="firma_dos[]" placeholder="Firma"></td></tr>');
    });
});
