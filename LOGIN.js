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


    const registroPassword = document.getElementById("registroPassword");

    registroPassword.addEventListener("input", function () {
        const value = registroPassword.value;

        document.getElementById("rule-length").className = value.length >= 8 ? "valid" : "invalid";
        document.getElementById("rule-uppercase").className = /[a-z]/.test(value) && /[A-Z]/.test(value) ? "valid" : "invalid";
        document.getElementById("rule-number").className = /\d/.test(value) ? "valid" : "invalid";
        document.getElementById("rule-special").className = /[^A-Za-z0-9]/.test(value) ? "valid" : "invalid";
    });
