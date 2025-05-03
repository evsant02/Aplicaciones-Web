document.addEventListener('DOMContentLoaded', function() {
    try {
        // Obtener datos
        const chartDataElement = document.getElementById('chart-data');
        if (!chartDataElement) throw new Error('Elemento con datos no encontrado');
        
        const datosGrafico = JSON.parse(chartDataElement.textContent);
        const datosValidos = Array.isArray(datosGrafico) && datosGrafico.length === 12 
            ? datosGrafico 
            : Array(12).fill(0);

        // Crear el gráfico
        const ctx = document.getElementById('donacionesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Recaudación mensual (€)', // Texto de la leyenda
                    data: datosValidos,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    fill: true // Relleno bajo la línea
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: true, // Asegurar que la leyenda es visible
                        position: 'bottom',
                        labels: {
                            color: '#333', // Color del texto
                            font: {
                                size: 14, // Tamaño de fuente
                                weight: 'bold' // Negrita
                            },
                            padding: 10, // Espaciado
                            usePointStyle: true, // Usar icono de punto
                            pointStyle: 'circle' // Estilo del icono
                        }
                    },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                return context[0].label;
                            },
                            label: function(context) {
                                return 'Cantidad: ' + context.parsed.y.toLocaleString('es-ES', {
                                    style: 'currency',
                                    currency: 'EUR'
                                });
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + ' €';
                            }
                        }
                    }
                }
            }
        });

    } catch (error) {
        console.error('Error al cargar el gráfico:', error);
    }
});