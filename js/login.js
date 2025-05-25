const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');

registerBtn.addEventListener('click', () => {
    container.classList.add('active');
});

loginBtn.addEventListener('click', () => {
    container.classList.remove('active');
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

function togglePasswordVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

const registroPassword = document.getElementById("registroPassword");

if (registroPassword) {
    registroPassword.addEventListener("input", function () {
        const value = registroPassword.value;
        document.getElementById("rule-length").className = value.length >= 8 ? "valid" : "invalid";
        document.getElementById("rule-uppercase").className = /[a-z]/.test(value) && /[A-Z]/.test(value) ? "valid" : "invalid";
        document.getElementById("rule-number").className = /\d/.test(value) ? "valid" : "invalid";
        document.getElementById("rule-special").className = /[^A-Za-z0-9]/.test(value) ? "valid" : "invalid";
    });
}

const confirmarPassword = document.getElementById("confirmarPassword");

if (registroPassword && confirmarPassword) {
    confirmarPassword.addEventListener("input", function () {
        const errorMsg = document.getElementById("passwordMismatchMsg");

        if (!errorMsg && confirmarPassword.value !== "" && confirmarPassword.value !== registroPassword.value) {
            const error = document.createElement("p");
            error.id = "passwordMismatchMsg";
            error.style.color = "red";
            error.textContent = "Las contraseñas no coinciden.";
            confirmarPassword.parentNode.insertBefore(error, confirmarPassword.nextSibling);
        } else if (confirmarPassword.value === registroPassword.value) {
            const msg = document.getElementById("passwordMismatchMsg");
            if (msg) msg.remove();
        }
    });

    registroPassword.addEventListener("input", function () {
        const msg = document.getElementById("passwordMismatchMsg");
        if (confirmarPassword.value === registroPassword.value && msg) {
            msg.remove();
        }
    });
}




