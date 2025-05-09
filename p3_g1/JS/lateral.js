document.addEventListener("DOMContentLoaded", () => {
    const boton = document.getElementById("botonFiltro");
  
    if (boton) {
      boton.addEventListener("click", () => {
        const inicio = document.getElementById("fechaInicio").value;
        const final = document.getElementById("fechaFinal").value;
        const texto = document.getElementById("texto").value;
        const tipos = Array.from(document.querySelectorAll('input[name="tipo"]:checked'))
                     .map(el => el.value)
                     .join(',');
  
        filtrarActividadesPorFecha(inicio, final, texto, tipos);
    });
  }
});

  function filtrarActividadesPorFecha(inicio, final, texto, tipos) {
    console.log(tipos);
    const params = new URLSearchParams({ inicio, final, texto }).toString();
    const rutaPHP = 'includes/actividadesFiltradas/ajaxfiltro.php';
    fetch(rutaPHP+'?'+params)
      .then(response => response.text())
      .then(data => {
        document.getElementById("resultadoActividades").innerHTML = data;
      })
      .catch(error => console.error('Error al filtrar:', error));
  }