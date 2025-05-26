document.addEventListener("DOMContentLoaded", () => {
  const filtros = document.querySelectorAll('input[name="categorias"]');
  const posts = document.querySelectorAll('.post');

  filtros.forEach(filtro => {
    filtro.addEventListener("change", () => {
      const categoriaSeleccionada = filtro.value.toUpperCase();

      posts.forEach(post => {
        const etiquetas = post.getAttribute("data-category").toUpperCase();
        if (categoriaSeleccionada === "TODOS" || etiquetas.includes(categoriaSeleccionada)) {
          post.style.display = "block";
        } else {
          post.style.display = "none";
        }
      });
    });
  });
});
