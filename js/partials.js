document.addEventListener("DOMContentLoaded", () => {
  // BOTÓN MENÚ RESPONSIVE
  const btnToggleResponsive = document.querySelector('.btn-toggle');
  const menuResponsive = document.querySelector('.menu-responsive');
  const header = document.querySelector('header');

  if (btnToggleResponsive) {
    btnToggleResponsive.addEventListener('click', () => {
      const iconBars = document.querySelector('.fa-bars');
      const iconClose = document.querySelector('.fa-xmark');

      if (iconBars.classList.contains('active')) {
        iconBars.classList.remove('active');
        iconClose.classList.add('active');
        menuResponsive.classList.add('show');
        menuResponsive.style.top = `${header.clientHeight}px`;
      } else {
        iconBars.classList.add('active');
        iconClose.classList.remove('active');
        menuResponsive.classList.remove('show');
      }
    });
  }

  // DATOS DE USUARIO Y MENÚ
  const user = JSON.parse(localStorage.getItem("user"));

  if (user && user.rol === "admin") {
    const nav = document.querySelector("nav ul");
    if (nav) {
      const li = document.createElement("li");
      li.innerHTML = `<a href="admin_panel.php">Admin</a>`;
      nav.appendChild(li);
    }

    const menuResponsiveList = document.querySelector(".menu-responsive ul");
    if (menuResponsiveList) {
      const li = document.createElement("li");
      li.innerHTML = `<a href="admin_panel.php">Admin</a>`;
      menuResponsiveList.appendChild(li);
    }
  }

  // 👇 ACTUALIZA LA IMAGEN DEL BOTÓN DE PERFIL
	const avatarIcon = document.querySelector(".profile-btn img");
	if (user && user.photo && avatarIcon) {
	avatarIcon.src = user.photo;
	}

  // PERFIL USUARIO
  function toggleMenu() {
    const menu = document.getElementById("user-menu");
    menu.classList.toggle("hidden");
    menu.innerHTML = "";

    if (user && user.name && user.photo) {
      menu.innerHTML = `
        <div class="user-profile">
          <img src="${user.photo}" alt="Foto de perfil" />
          <div class="user-profile-name">${user.name}</div>
        </div>
        <hr style="border: 0.5px solid #444; margin: 8px 0;" />
        <div class="user-menu-item" id="btn-ajustes">⚙ Ajustes</div>
        <div class="user-menu-item" id="btn-logout">➡ Cerrar sesión</div>
      `;
    } else {
      menu.innerHTML = `<div class="user-menu-item" id="btn-login">Iniciar sesión</div>`;
    }

    setTimeout(() => {
      document.getElementById("btn-ajustes")?.addEventListener("click", () => window.location.href = "ajustes.html");
      document.getElementById("btn-logout")?.addEventListener("click", () => {
        localStorage.removeItem("user");
        window.location.href = "logout.php";
      });
      document.getElementById("btn-login")?.addEventListener("click", () => window.location.href = "login.php");
    }, 0);
  }

  // CERRAR MENÚ FUERA DEL ÁREA
  window.addEventListener("click", function (event) {
    const menu = document.getElementById("user-menu");
    const container = document.querySelector(".user-menu-container");
    if (!event.composedPath().includes(container)) {
      menu.classList.add("hidden");
    }
  });

  // Asigna toggleMenu globalmente (lo usas en el HTML)
  window.toggleMenu = toggleMenu;
});

document.addEventListener("DOMContentLoaded", () => {
  if (!localStorage.getItem("cookies_accepted")) {
    document.getElementById("cookie-banner").style.display = "block";
  }

  document.getElementById("accept-cookies")?.addEventListener("click", () => {
    localStorage.setItem("cookies_accepted", "true");
    document.getElementById("cookie-banner").style.display = "none";
  });
});
