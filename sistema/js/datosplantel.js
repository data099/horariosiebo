document.getElementById('plantel').addEventListener('change', function() {
    var plantelId = this.value;
    if (plantelId) {
        fetch('datos_plantel.php?plantel_id=' + plantelId)
            .then(response => response.json())
            .then(data => {
                document.getElementById('region').value = data.region || '';
                // Guardar en localStorage
                localStorage.setItem('nombrePlantel', document.getElementById('plantel').options[document.getElementById('plantel').selectedIndex].text);
                localStorage.setItem('regionPlantel', data.region || '');
                localStorage.setItem('plantelId', plantelId);
            })
            .catch(error => console.error('Error:', error));
    } else {
        document.getElementById('region').value = '';
        // Limpiar localStorage
        localStorage.removeItem('nombrePlantel');
        localStorage.removeItem('regionPlantel');
        localStorage.removeItem('plantelId');
    }
});

document.getElementById('periodo').addEventListener('input', function() {
    localStorage.setItem('periodoPlantel', this.value);
});

// Al cargar la página, verificar si hay datos en localStorage
window.addEventListener('load', function() {
    var nombrePlantel = localStorage.getItem('nombrePlantel');
    var regionPlantel = localStorage.getItem('regionPlantel');
    var plantelId = localStorage.getItem('plantelId');
    var periodoPlantel = localStorage.getItem('periodoPlantel');
    
    if (plantelId) {
        document.getElementById('plantel').value = plantelId;
    }
    if (regionPlantel) {
        document.getElementById('region').value = regionPlantel;
    }
    if (periodoPlantel) {
        document.getElementById('periodo').value = periodoPlantel;
    }
});