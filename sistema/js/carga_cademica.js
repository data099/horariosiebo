document.getElementById('exportButton').addEventListener('click', function() {
    document.querySelector('.button-container').style.display = 'none';

    html2canvas(document.getElementById('content-to-export'), {
        scale: 2,
        useCORS: true
    }).then(function(canvas) {
        var imgData = canvas.toDataURL('image/png', 1.0);
        var pdf = new jsPDF('landscape', 'mm', 'a4');
        var imgWidth = 297;
        var pageHeight = 210;
        var imgHeight = (canvas.height * imgWidth) / canvas.width;
        var heightLeft = imgHeight;
        var position = 0;

        pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;

        while (heightLeft > 0) {
            position = heightLeft - imgHeight;
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
        }
        pdf.save('carga_academica.pdf');

        document.querySelector('.button-container').style.display = 'flex';
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var nombrePlantel = localStorage.getItem('nombrePlantel');
    var regionPlantel = localStorage.getItem('regionPlantel');
    var periodoPlantel = localStorage.getItem('periodoPlantel');
    if (nombrePlantel) {
        document.getElementById('plantel').value = nombrePlantel;
    }
    if (regionPlantel) {
        document.getElementById('region').value = regionPlantel;
    }
    if (periodoPlantel) {
        document.getElementById('ciclo-semestral').value = periodoPlantel;
    }

    var primerDocenteId = document.getElementById('asesor').value;
    if (primerDocenteId) {
        mostrarCargaAcademica(primerDocenteId);
    }
});

function mostrarCargaAcademica(nombre_completo) {
    if (nombre_completo !== '') {
        $.ajax({
            url: 'obtener_perfil.php',
            type: 'GET',
            data: { nombre_completo: nombre_completo },
            dataType: 'json',
            success: function(data) {
                $('#perfil').val(data.perfil);
                $('#posgrado').val(data.posgrado);
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los datos:', error);
            }
        });
    } else {
        // Limpiar los campos si no hay asesor seleccionado
        $('#perfil').val('');
        $('#posgrado').val('');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var nombrePlantel = localStorage.getItem('nombrePlantel');
    var regionPlantel = localStorage.getItem('regionPlantel');
    var periodoPlantel = localStorage.getItem('periodoPlantel');
    if (nombrePlantel) {
        document.getElementById('plantel').value = nombrePlantel;
    }
    if (regionPlantel) {
        document.getElementById('region').value = regionPlantel;
    }
    if (periodoPlantel) {
        document.getElementById('ciclo-semestral').value = periodoPlantel;
    }

    var primerDocenteId = document.getElementById('asesor').value;
    if (primerDocenteId) {
        mostrarCargaAcademica(primerDocenteId);
    }
});

// Función para calcular los totales de horas semanales
function calcularTotales() {
    const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];
    let totalHorasSemanales = 0;

    dias.forEach(dia => {
        const inputs = document.querySelectorAll(`input[name="${dia}[]"]`);
        let total = 0;
        inputs.forEach(input => {
            if (input.value.trim() !== '') {
                total += parseFloat(input.value);
            }
        });
        document.getElementById(`total-${dia}`).value = total;
    });

    const filas = document.querySelectorAll("#tabla-horario tbody tr");
    filas.forEach(fila => {
        let totalFila = 0;
        dias.forEach(dia => {
            const input = fila.querySelector(`input[name="${dia}[]"]`);
            if (!isNaN(input.value) && input.value.trim() !== '') {
                totalFila += parseFloat(input.value);
            }
        });
        fila.querySelector('input[name="horas[]"]').value = totalFila;
        totalHorasSemanales += totalFila;
    });

    document.getElementById('total-horas').value = totalHorasSemanales;
}

// Asociar la función de cálculo de totales a los inputs de los días
document.querySelectorAll('.dia').forEach(input => {
    input.addEventListener('input', calcularTotales);
});

// Calcular los totales inicialmente
calcularTotales();



// Función para calcular los totales de horas semanales
function calcularTotales() {
    const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];
    let totalHorasSemanales = 0;

    dias.forEach(dia => {
        const inputs = document.querySelectorAll(`input[name="${dia}[]"]`);
        let total = 0;
        inputs.forEach(input => {
            if (input.value.trim() !== '') {
                total += parseFloat(input.value);
            }
        });
        document.getElementById(`total-${dia}`).value = total;
    });

    const filas = document.querySelectorAll("#tabla-horario tbody tr");
    filas.forEach(fila => {
        let totalFila = 0;
        dias.forEach(dia => {
            const input = fila.querySelector(`input[name="${dia}[]"]`);
            if (!isNaN(input.value) && input.value.trim() !== '') {
                totalFila += parseFloat(input.value);
            }
        });
        fila.querySelector('input[name="horas[]"]').value = totalFila;
        totalHorasSemanales += totalFila;
    });

    document.getElementById('total-horas').value = totalHorasSemanales;
}

// Asociar la función de cálculo de totales a los inputs de los días
document.querySelectorAll('.dia').forEach(input => {
    input.addEventListener('input', calcularTotales);
});

// Calcular los totales inicialmente
calcularTotales();
function mostrarCargaAcademica(asesor) {
    if (asesor !== '') {
        $.ajax({
            url: 'obtener_horario.php',
            type: 'GET',
            data: { asesor: asesor },
            dataType: 'json',
            success: function(data) {
                // Limpiar todos los campos primero
                limpiarFormulario();

                // Si hay datos para el asesor, llenar el formulario con ellos
                if (data.length > 0) {
                    for (let i = 0; i < data.length; i++) {
                        $('select[name="uac[]"]').eq(i).val(data[i].uac);
                        $('select[name="sem[]"]').eq(i).val(data[i].sem);
                        $('select[name="gpo[]"]').eq(i).val(data[i].gpo);
                        $('input[name="lunes[]"]').eq(i).val(data[i].lunes);
                        $('input[name="martes[]"]').eq(i).val(data[i].martes);
                        $('input[name="miercoles[]"]').eq(i).val(data[i].miercoles);
                        $('input[name="jueves[]"]').eq(i).val(data[i].jueves);
                        $('input[name="viernes[]"]').eq(i).val(data[i].viernes);
                        $('input[name="horas[]"]').eq(i).val(data[i].horas_semanales);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los datos:', error);
            }
        });
    } else {
        limpiarFormulario();
    }
}

function limpiarFormulario() {
    $('select[name="uac[]"]').val('');
    $('select[name="sem[]"]').val('');
    $('select[name="gpo[]"]').val('');
    $('input[name="lunes[]"]').val('');
    $('input[name="martes[]"]').val('');
    $('input[name="miercoles[]"]').val('');
    $('input[name="jueves[]"]').val('');
    $('input[name="viernes[]"]').val('');
    $('input[name="horas[]"]').val('');
}

