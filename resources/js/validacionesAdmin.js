document.addEventListener("DOMContentLoaded", function () {
    const nameInput = document.querySelector('input[name="name"]');
    const emailInput = document.querySelector('input[name="email"]');
    const passwordInput = document.querySelector('input[name="password"]');
    const form = document.querySelector('form');

    nameInput.addEventListener("input", function () {
        const errorDiv = this.nextElementSibling;
        if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(this.value)) {
            errorDiv.textContent = "El nombre solo debe contener letras y espacios.";
        } else {
            errorDiv.textContent = "";
        }
    });

    emailInput.addEventListener("input", function () {
        const errorDiv = this.nextElementSibling;
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value)) {
            errorDiv.textContent = "Por favor, ingresa un correo electrónico válido.";
        } else {
            errorDiv.textContent = "";
        }
    });

    passwordInput.addEventListener("input", function () {
        const errorDiv = this.nextElementSibling;
        if (this.value.length < 8) {
            errorDiv.textContent = "La contraseña debe tener al menos 8 caracteres.";
        } else if (!/[A-Z]/.test(this.value)) {
            errorDiv.textContent = "Debe incluir al menos una letra mayúscula.";
        } else if (!/[0-9]/.test(this.value)) {
            errorDiv.textContent = "Debe incluir al menos un número.";
        } else {
            errorDiv.textContent = "";
        }
    });

    form.addEventListener("submit", function (e) {
        if (
            nameInput.nextElementSibling.textContent ||
            emailInput.nextElementSibling.textContent ||
            passwordInput.nextElementSibling.textContent
        ) {
            e.preventDefault();
            alert("Por favor, corrige los errores antes de enviar el formulario.");
        }
    });
});
