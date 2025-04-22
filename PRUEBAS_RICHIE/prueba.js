const singInBtnLink = document.querySelector('.singInBtn-link');
const singUpBtnLink = document.querySelector('.singUpBtn-link');
const wrapper = document.querySelector('.wrapper');

singUpBtnLink.addEventListener('click', () => {
    wrapper.classList.toggle('active');
});

singInBtnLink.addEventListener('click', () => {
    wrapper.classList.toggle('active');
});

function togglePassword() {
    const passwordInput = document.getElementById("password");
    const showPasswordBtn = document.getElementById("showPasswordBtn");

    if (passwordInput.type === "password") {
        passwordInput.type = "text"; // Cambia el tipo a texto para mostrar la contraseña
        showPasswordBtn.textContent = "Hide Password"; // Cambia el texto del botón
    } else {
        passwordInput.type = "password"; // Revertir a contraseña
        showPasswordBtn.textContent = "Show Password"; // Cambia el texto del botón
    }
}

function toggleSignUpPassword() {
    const passwordInput = document.getElementById("signUpPassword");
    const showPasswordBtn = document.getElementById("showSignUpPasswordBtn");

    if (passwordInput.type === "password") {
        passwordInput.type = "text"; // Cambia el tipo a texto para mostrar la contraseña
        showPasswordBtn.textContent = "Hide Password"; // Cambia el texto del botón
    } else {
        passwordInput.type = "password"; // Revertir a contraseña
        showPasswordBtn.textContent = "Show Password"; // Cambia el texto del botón
    }
}
