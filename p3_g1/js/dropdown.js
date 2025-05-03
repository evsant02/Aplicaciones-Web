// js/dropdown.js
document.addEventListener('DOMContentLoaded', function() {
    var dropdowns = document.getElementsByClassName("dropdown");
    
    for (var i = 0; i < dropdowns.length; i++) {
        dropdowns[i].addEventListener("click", function(e) {
            e.stopPropagation(); // Evita que el clic se propague
            var dropdownContent = this.querySelector(".dropdown-content");
            
            // Cierra otros dropdowns abiertos
            var allDropdowns = document.querySelectorAll('.dropdown-content');
            allDropdowns.forEach(function(item) {
                if (item !== dropdownContent) {
                    item.style.display = 'none';
                }
            });
            
            // Abre o cierra el dropdown actual
            if (dropdownContent.style.display === 'block') {
                dropdownContent.style.display = 'none';
            } else {
                dropdownContent.style.display = 'block';
            }
        });
    }
    
    // Cierra el menú al hacer clic fuera
    document.addEventListener('click', function() {
        var dropdowns = document.querySelectorAll('.dropdown-content');
        dropdowns.forEach(function(item) {
            item.style.display = 'none';
        });
    });
});