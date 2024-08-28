function mostrarHorarioPorGrupo(grupo) {
    if (grupo) {
        $.ajax({
            url: 'obtener_horario_por_grupo.php',
            type: 'GET',
            data: { grupo: grupo },
            dataType: 'json',
            success: function(data) {
                llenarHorario(data);
            },
            error: function() {
                alert('Error al obtener el horario del grupo.');
            }
        });
    }
}

function llenarHorario(horario) {
    var dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];
    dias.forEach(function(dia, diaIndex) {
        horario[dia].forEach(function(materia, horaIndex) {
            document.getElementById(`${dia}_${horaIndex}`).textContent = materia || '';
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    var plantelNombre = localStorage.getItem('nombrePlantel');
    var region = localStorage.getItem('region');
    
    if (plantelNombre) {
        document.getElementById('plantel').value = plantelNombre;
    }
    if (region) {
        document.getElementById('region').value = region;
    }
});
