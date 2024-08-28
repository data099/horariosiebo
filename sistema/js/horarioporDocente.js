function generarHorarios() {
    var horarios = [];
    var horaActual = new Date();
    horaActual.setHours(8, 0, 0, 0); // Hora de inicio: 8:00 AM

    var claseDuration = 60; // Duración de una clase en minutos
    var recesoDuration = 30; // Duración del receso en minutos
    var claseCount = 7; // Número total de clases (sin incluir el receso)

    for (var i = 0; i < claseCount; i++) {
        // Añadir clase
        var inicioClase = horaActual.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        horaActual.setMinutes(horaActual.getMinutes() + claseDuration);
        var finClase = horaActual.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        horarios.push(inicioClase + ' - ' + finClase);

        // Añadir receso a las 10:00 AM
        if (i === 1) {
            var inicioReceso = horaActual.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            horaActual.setMinutes(horaActual.getMinutes() + recesoDuration);
            var finReceso = horaActual.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            horarios.push(inicioReceso + ' - ' + finReceso + ' (Receso)');
        }
    }

    return horarios;
}

function mostrarPerfil(nombreCompleto) {
    if (nombreCompleto === "") {
        document.getElementById("categoria").value = "";
        document.getElementById("funcion").value = "";
        limpiarHorario();
        return;
    }

    $.ajax({
        url: 'obtener_perfil.php',
        type: 'GET',
        data: { nombre_completo: nombreCompleto },
        success: function(response) {
            var data = JSON.parse(response);
            document.getElementById("categoria").value = data.categoria || '';
            document.getElementById("funcion").value = data.funcion || '';

            limpiarHorario(); // Limpiar la tabla antes de llenarla

            $.ajax({
                url: 'obtener_horario.php',
                type: 'GET',
                data: { asesor: nombreCompleto },
                success: function(response) {
                    var data = JSON.parse(response);

                    // Limpiar todos los campos primero
                    limpiarHorario();

                    var tbody = $('#tabla-horario tbody');
                    tbody.empty();  // Vaciar la tabla para llenarla de nuevo

                    var horarios = generarHorarios(); // Genera los horarios con recesos

                    horarios.forEach(function(horario, index) {
                        var tr = $('<tr></tr>');
                        tr.append('<td class="hora">' + horario + '</td>');

                        // Si es un receso, no rellenar con materias
                        if (horario.includes('(Receso)')) {
                            for (var j = 0; j < 10; j++) {
                                tr.append('<td class="dia"></td>');
                            }
                        } else if (data[index]) {
                            var dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];
                            dias.forEach(function(dia) {
                                tr.append('<td class="dia">' + (data[index][dia] !== '' ? data[index].uac : '') + '</td>');
                                tr.append('<td class="grupo">' + (data[index][dia] !== '' ? data[index].gpo : '') + '</td>');
                            });
                        } else {
                            // Si no hay datos para esta hora, agregar celdas vacías
                            for (var j = 0; j < 10; j++) {
                                tr.append('<td class="dia"></td>');
                            }
                        }

                        tbody.append(tr);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener el horario:', error);
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener el perfil:', error);
        }
    });
}

function limpiarHorario() {
    $('#tabla-horario tbody').empty(); // Limpiar todas las filas de la tabla
}

$(document).ready(function() {
    const localData = {
        plantel: localStorage.getItem('nombrePlantel'),
        region: localStorage.getItem('region'),
        categoria: localStorage.getItem('tipo_periodo'),
        titular: localStorage.getItem('titular'),
        asesor: localStorage.getItem('asesorNombre'),
        horaInicio: localStorage.getItem('hora_inicio_clases')
    };

    if (localData.plantel) $('#plantel').val(localData.plantel);
    if (localData.region) $('#region').val(localData.region);
    if (localData.categoria) $('#categoria').val(localData.categoria);
    if (localData.titular) $('#nombre-director').val(localData.titular);
    if (localData.asesor) $('#asesor').val(localData.asesor);

    if (localData.horaInicio) generarTablaHorarios(localData.horaInicio);
});

$('#export-pdf').on('click', function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('landscape');

    // Agregar el logo
    const logo = new Image();
    logo.src = 'imagenes/iebo.png';
    logo.onload = function() {
        doc.addImage(logo, 'PNG', 10, 10, 30, 30);

        // Agregar el encabezado de texto centrado
        doc.setFontSize(14);
        doc.text("Instituto de Estudios de Bachillerato del Estado de Oaxaca", 140, 20, { align: "center" });
        doc.setFontSize(12);
        doc.text("Dirección Académica", 140, 30, { align: "center" });
        doc.text("Departamento de Docencia e Investigación", 140, 40, { align: "center" });

        // Información adicional en un cuadro verde
        const infoInicioY = 50;
        const infoHeight = 30;

        doc.setFillColor(22, 160, 133);
        doc.rect(10, infoInicioY, 280, infoHeight, 'F');
        doc.setDrawColor(0, 0, 0);
        doc.rect(10, infoInicioY, 280, infoHeight);

        doc.setFontSize(12);
        const plantel = $('#plantel').val();
        const region = $('#region').val();
        const nombreDirector = $('#nombre-director').val();
        const docente = $('#asesor').val();
        const categoria = $('#categoria').val();
        const funcion = $('#funcion').val();

        const labels = ['Plantel:', 'Región:', 'Nombre del Director:', 'Docente:', 'Categoria:', 'Función:'];
        const values = [plantel, region, nombreDirector, docente, categoria, funcion];
        const infoX = 14;
        const infoY = infoInicioY + 10;
        const cellWidth = 45;
        const cellHeight = 8;

        doc.setTextColor(255, 255, 255);

        labels.forEach((label, index) => {
            const rowIndex = Math.floor(index / 3);
            const colIndex = index % 3;
            const extraSpace = label === 'Categoria:' ? 20 : 0;
            const labelX = infoX + colIndex * (cellWidth + 30 + extraSpace);
            const valueX = labelX + doc.getTextWidth(label) + 2;
            const labelY = infoY + rowIndex * (cellHeight + 12);
            const valueY = labelY;

            doc.text(label, labelX, labelY);
            doc.text(values[index], valueX, valueY);
        });

        const columns = ["Hora", "Lunes", "Grupo Escolar", "Martes", "Grupo Escolar", "Miércoles", "Grupo Escolar", "Jueves", "Grupo Escolar", "Viernes", "Grupo Escolar"];
        const rows = [];

        $('#tabla-horario tbody tr').each(function() {
            const rowData = [];
            $(this).find('td').each(function() {
                rowData.push($(this).text());
            });
            rows.push(rowData);
        });

        doc.autoTable({
            head: [columns],
            body: rows,
            startY: infoInicioY + infoHeight + 10,
            styles: { fontSize: 8, cellPadding: 2 },
            headStyles: { fillColor: [22, 160, 133] },
            theme: 'grid'
        });

        doc.save("horario_docente.pdf");
    };
});
