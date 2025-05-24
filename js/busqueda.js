const searchForm = document.querySelector('.search-form');
    const searchButton = searchForm.querySelector('button');

    searchButton.addEventListener('click', function (e) {
        if (window.innerWidth <= 768 && !searchForm.classList.contains('active')) {
            e.preventDefault(); // Prevenir el envío si solo estamos abriendo el campo
            searchForm.classList.add('active');
        }
    });

    // Opcional: cerrar al hacer clic fuera
    document.addEventListener('click', function (e) {
        if (!searchForm.contains(e.target)) {
            searchForm.classList.remove('active');
        }
    });
