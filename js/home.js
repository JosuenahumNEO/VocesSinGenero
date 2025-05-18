const containerTabs = document.querySelectorAll('.tab');
const allContainerDishes = document.querySelectorAll('.container-dishes');

containerTabs.forEach(tab => {
	tab.addEventListener('click', e => {
		const tabName = e.target.dataset.name;

		containerTabs.forEach(tab => tab.classList.remove('active'));
		e.target.classList.add('active');

		allContainerDishes.forEach(containerDishes => {
			const dishName = containerDishes.dataset.name;

			if (tabName === dishName) {
				containerDishes.classList.add('active');
			} else {
				containerDishes.classList.remove('active');
			}
		});
	});
});

// Este código asume que los datos del usuario ya están guardados al iniciar sesión

let loggedIn = false;
let userName = "";
let userPhoto = "";

// Verifica si hay datos en localStorage (o cambia esto si usas cookies o fetch)
const userData = JSON.parse(localStorage.getItem("user"));

if (userData && userData.name && userData.photo) {
	loggedIn = true;
	userName = userData.name;
	userPhoto = userData.photo;
}

function toggleMenu() {
	const menu = document.getElementById("user-menu");
	menu.classList.toggle("hidden");

	menu.innerHTML = "";

	if (loggedIn) {
		menu.innerHTML = `
			<div class="user-profile">
				<img src="${userPhoto}" alt="Foto de perfil" />
				<div class="user-profile-name">${userName}</div>
			</div>
			<hr style="border: 0.5px solid #444; margin: 8px 0;" />
			<div class="user-menu-item" id="btn-ajustes">⚙ Ajustes</div>
			<div class="user-menu-item" id="btn-logout">➡ Cerrar sesión</div>
		`;
	} else {
		menu.innerHTML = `<div class="user-menu-item" id="btn-login">Iniciar sesión</div>`;
	}

	// Agregar eventos a los botones
	setTimeout(() => {
		const ajustesBtn = document.getElementById("btn-ajustes");
		const logoutBtn = document.getElementById("btn-logout");
		const loginBtn = document.getElementById("btn-login");

		if (ajustesBtn) ajustesBtn.addEventListener("click", () => window.location.href = "ajustes.html");

		if (logoutBtn) logoutBtn.addEventListener("click", () => {
			localStorage.removeItem("user"); // Elimina la sesión
			window.location.href = "index.html"; // Redirige a inicio
		});

		if (loginBtn) loginBtn.addEventListener("click", () => {
			window.location.href = "login.html";
		});
	}, 0);
}

// Cerrar menú si se hace clic fuera
window.addEventListener("click", function (event) {
	const menu = document.getElementById("user-menu");
	const container = document.querySelector(".user-menu-container");

	if (!event.composedPath().includes(container)) {
		menu.classList.add("hidden");
	}
});

// Explicación detallada de la función toggleMenu (versión final con datos reales):

// 1. Antes de la función, se obtiene la información del usuario desde localStorage.
//    Se busca un objeto "user" que contenga "name" y "photo".
//    Si se encuentra, se considera que el usuario está logueado.

// 2. Se declaran tres variables:
//    - loggedIn: true o false, dependiendo de si se detectó información del usuario.
//    - userName: el nombre del usuario (extraído del objeto guardado).
//    - userPhoto: la URL de la foto de perfil del usuario.

// 3. La función toggleMenu() se activa cuando se hace clic en el ícono de perfil.

// 4. Se obtiene el contenedor con ID "user-menu", que está oculto por defecto.

// 5. Se usa classList.toggle("hidden") para mostrar u ocultar el menú desplegable.
//    - Si el menú está oculto (tiene la clase "hidden"), se muestra.
//    - Si está visible, se vuelve a ocultar.

// 6. Se limpia el contenido del menú usando innerHTML = "" para evitar duplicados
//    y asegurar que el contenido mostrado siempre esté actualizado.

// 7. Luego:
//    - Si el usuario está logueado:
//        a. Se muestra una imagen de perfil (userPhoto) y el nombre del usuario (userName).
//        b. Se agregan dos opciones debajo:
//           • "Ajustes" (id="btn-ajustes")
//           • "Cerrar sesión" (id="btn-logout")
//    - Si el usuario NO está logueado:
//        a. Se muestra solo la opción "Iniciar sesión" (id="btn-login").

// 8. Se agregan eventos a cada botón del menú:
//    - "btn-ajustes": redirige a ajustes.html.
//    - "btn-logout": borra el objeto "user" de localStorage y redirige a index.html (cierra sesión).
//    - "btn-login": redirige a login.html.

// 9. El menú también se cierra automáticamente cuando el usuario hace clic fuera del área del menú.
//    Esto se logra usando window.addEventListener("click", ...) y el método event.composedPath().

// NOTA IMPORTANTE:
// Para que el menú funcione correctamente:
// - El backend debe guardar los datos del usuario en localStorage con este formato:
//     localStorage.set
