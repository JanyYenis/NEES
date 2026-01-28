"use strict";

// Import Bootstrap
const bootstrap = window.bootstrap

// Initialize
document.addEventListener("DOMContentLoaded", () => {
    initializeTooltips();
    initializeNavigation();
    initializeAddressFields();
    initializePhoneFields();
    initializePasswordStrength();
    initializePasswordToggle();
    initializeFormValidation();
    iniciarComponente();
})

// Initialize Bootstrap Tooltips
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl))
}

// Step Navigation
let currentStep = 1
const totalSteps = 4

function initializeNavigation() {
    // Next buttons
    document.querySelectorAll(".btn-next").forEach((btn) => {
        btn.addEventListener("click", function () {
            const nextStep = Number.parseInt(this.dataset.next)
            if (validateStep(currentStep)) {
                goToStep(nextStep)
            }
        })
    })

    // Previous buttons
    document.querySelectorAll(".btn-prev").forEach((btn) => {
        btn.addEventListener("click", function () {
            const prevStep = Number.parseInt(this.dataset.prev)
            goToStep(prevStep)
        })
    })
}

function goToStep(step) {
    // Hide current section
    document.querySelector(`.form-section[data-section="${currentStep}"]`).classList.remove("active")
    document.querySelector(`.progress-step[data-step="${currentStep}"]`).classList.remove("active")
    document.querySelector(`.progress-step[data-step="${currentStep}"]`).classList.add("completed")

    // Show new section
    document.querySelector(`.form-section[data-section="${step}"]`).classList.add("active")
    document.querySelector(`.progress-step[data-step="${step}"]`).classList.add("active")
    document.querySelector(`.progress-step[data-step="${step}"]`).classList.remove("completed")

    currentStep = step

    // Scroll to top
    window.scrollTo({ top: 0, behavior: "smooth" })
}

// Address Fields
let visibleAddresses = 1
const maxAddresses = 4

function initializeAddressFields() {
    const addBtn = document.getElementById("addAddressBtn")

    addBtn.addEventListener("click", () => {
        if (visibleAddresses < maxAddresses) {
            visibleAddresses++
            const nextField = document.getElementById(`direccion${visibleAddresses}-field`)
            nextField.style.display = "block"
            nextField.style.animation = "slideIn 0.3s ease"

            if (visibleAddresses === maxAddresses) {
                addBtn.disabled = true
                addBtn.innerHTML = '<i class="fas fa-check me-2"></i>Máximo de direcciones alcanzado'
            }
        }
    })
}

// Phone Fields
let phoneCount = 1

function initializePhoneFields() {
    const addPhoneBtn = document.getElementById("addPhoneBtn")
    const phoneList = document.getElementById("phoneList")

    addPhoneBtn.addEventListener("click", () => {
        phoneCount++
        const phoneRow = createPhoneField(phoneCount)
        phoneList.insertAdjacentHTML("beforeend", phoneRow)

        // Add remove functionality
        const removeBtn = phoneList.querySelector(`.phone-row:last-child .remove-phone-btn`)
        if (removeBtn) {
            removeBtn.addEventListener("click", function () {
                this.closest(".phone-row").remove()
                phoneCount--
            })
        }
    })
}

function createPhoneField(index) {
    return `
    <div class="phone-row mb-3">
      <label class="form-label">Teléfono ${index}</label>
      <div class="input-wrapper phone-input-group">
        <i class="fas fa-phone input-icon"></i>
        <input
          type="tel"
          class="form-control phone-input"
          placeholder="+57 300 123 4567"
        />
        <button type="button" class="remove-phone-btn">
          <i class="fas fa-times"></i>
        </button>
        <div class="input-line"></div>
      </div>
    </div>
  `
}

// Password Strength
function initializePasswordStrength() {
    const passwordInput = document.getElementById("password")
    const strengthFill = document.querySelector(".strength-fill")
    const strengthText = document.querySelector(".strength-text span")

    const rules = {
        length: { regex: /.{8,}/, element: document.getElementById("rule-length") },
        uppercase: {
            regex: /[A-Z]/,
            element: document.getElementById("rule-uppercase"),
        },
        lowercase: {
            regex: /[a-z]/,
            element: document.getElementById("rule-lowercase"),
        },
        number: { regex: /[0-9]/, element: document.getElementById("rule-number") },
        special: {
            regex: /[!@#$%^&*(),.?":{}|<>]/,
            element: document.getElementById("rule-special"),
        },
    }

    passwordInput.addEventListener("input", function () {
        const password = this.value
        let validRules = 0

        // Check each rule
        for (const [key, rule] of Object.entries(rules)) {
            if (rule.regex.test(password)) {
                rule.element.classList.add("valid")
                validRules++
            } else {
                rule.element.classList.remove("valid")
            }
        }

        // Update strength indicator
        strengthFill.className = "strength-fill"
        if (validRules <= 2) {
            strengthFill.classList.add("weak")
            strengthText.textContent = "Débil"
            strengthText.style.color = "var(--primary-red)"
        } else if (validRules <= 4) {
            strengthFill.classList.add("medium")
            strengthText.textContent = "Media"
            strengthText.style.color = "#f59e0b"
        } else {
            strengthFill.classList.add("strong")
            strengthText.textContent = "Fuerte"
            strengthText.style.color = "#22c55e"
        }

        if (password.length === 0) {
            strengthFill.className = "strength-fill"
            strengthText.textContent = "-"
            strengthText.style.color = "var(--text-muted)"
        }
    })
}

// Password Toggle
function initializePasswordToggle() {
    document.querySelectorAll(".password-toggle").forEach((btn) => {
        btn.addEventListener("click", function () {
            const targetId = this.dataset.target
            const input = document.getElementById(targetId)
            const icon = this.querySelector("i")

            if (input.type === "password") {
                input.type = "text"
                icon.classList.remove("fa-eye")
                icon.classList.add("fa-eye-slash")
            } else {
                input.type = "password"
                icon.classList.remove("fa-eye-slash")
                icon.classList.add("fa-eye")
            }
        })
    })
}

// Form Validation
function initializeFormValidation() {
    const form = document.getElementById("registerForm")

    form.addEventListener("submit", (e) => {
        e.preventDefault()

        if (validateStep(4)) {
            // All steps valid, submit form
            // const formData = collectFormData()
            const formData = new FormData(document.getElementById("registerForm"));
            let inputTelefono = generalidades.darTelefonoInput(`#tel`);
            let tel = inputTelefono?.getNumber(intlTelInputUtils.numberFormat.NATIONAL);
            tel = tel.replace(/\((\w+)\)/g, "$1");
            tel = tel.replace(/-/g, "");
            tel = tel.replace(/\s/g, "");
            let codigo = inputTelefono?.getSelectedCountryData()?.dialCode ?? '';
            let nombre_tel = inputTelefono?.getSelectedCountryData()?.iso2 ?? '';
            formData.set('telefono', tel);
            formData.set('codigo_tel', codigo);
            formData.set('nombre_tel', nombre_tel);

            const config = {
                'method': 'POST',
                'headers': {
                    'Accept': generalidades.CONTENT_TYPE_JSON,
                },
                'body': formData
            }

            const success = (response) => {
                if (response.estado == 'success') {
                    // Show success message
                    showSuccessMessage();
                    window.location.href = route('home');
                }
            }

            const error = (response) => {
            }
            const ruta = route("register");
            generalidades.create(ruta, config, success, error);
        }
    })
}

function validateStep(step) {
    let isValid = true

    if (step === 1) {
        // Validate personal data
        const nombre = document.getElementById("nombre")
        const apellido = document.getElementById("apellido")
        const email = document.getElementById("email")

        isValid = validateField(nombre, nombre.value.trim().length > 0) && isValid
        isValid = validateField(apellido, apellido.value.trim().length > 0) && isValid
        isValid = validateField(email, isValidEmail(email.value)) && isValid
    } else if (step === 2) {
        // Validate location
        const direccion1 = document.getElementById("direccion1")
        isValid = validateField(direccion1, direccion1.value.trim().length > 0) && isValid
    } else if (step === 3) {
        // Validate phones
        const phoneInputs = document.querySelectorAll(".phone-input")
        phoneInputs.forEach((input, index) => {
            if (index === 0) {
                // First phone is required
                isValid = validateField(input, input.value.trim().length > 0) && isValid
            }
        })
    } else if (step === 4) {
        // Validate security
        const password = document.getElementById("password")
        const confirmPassword = document.getElementById("confirmPassword")
        const terms = document.getElementById("terms")

        const passwordValid = isValidPassword(password.value)
        const passwordsMatch = password.value === confirmPassword.value

        isValid = validateField(password, passwordValid) && isValid
        isValid = validateField(confirmPassword, passwordsMatch, "Las contraseñas no coinciden") && isValid

        if (!terms.checked) {
            alert("Debes aceptar los términos y condiciones")
            isValid = false
        }
    }

    return isValid
}

function validateField(input, condition, customMessage) {
    const errorMsg = input.closest(".input-wrapper").parentElement.querySelector(".error-message")

    if (condition) {
        input.classList.remove("is-invalid")
        input.classList.add("is-valid")
        if (errorMsg) errorMsg.classList.remove("show")
        return true
    } else {
        input.classList.remove("is-valid")
        input.classList.add("is-invalid")
        if (errorMsg) {
            if (customMessage) errorMsg.textContent = customMessage
            errorMsg.classList.add("show")
        }
        return false
    }
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    return emailRegex.test(email)
}

function isValidPassword(password) {
    return (
        password.length >= 8 &&
        /[A-Z]/.test(password) &&
        /[a-z]/.test(password) &&
        /[0-9]/.test(password) &&
        /[!@#$%^&*(),.?":{}|<>]/.test(password)
    )
}

function collectFormData() {
    const formData = {
        nombre: document.getElementById("nombre").value,
        apellido: document.getElementById("apellido").value,
        email: document.getElementById("email").value,
        codCiudad: document.getElementById("codCiudad").value,
        barrio: document.getElementById("barrio").value,
        direcciones: [document.getElementById("direccion1").value],
        telefonos: [],
        password: document.getElementById("password").value,
    }

    // Collect additional addresses
    for (let i = 2; i <= visibleAddresses; i++) {
        const direccion = document.getElementById(`direccion${i}`).value
        if (direccion.trim()) {
            formData.direcciones.push(direccion)
        }
    }

    // Collect phones
    document.querySelectorAll(".phone-input").forEach((input) => {
        if (input.value.trim()) {
            formData.telefonos.push(input.value)
        }
    })

    return formData
}

function showSuccessMessage() {
    const registerCard = document.querySelector(".register-card")
    registerCard.innerHTML = `
    <div class="text-center py-5">
      <div class="register-icon mb-4">
        <i class="fas fa-check"></i>
      </div>
      <h2 class="text-light mb-3">¡Cuenta Creada Exitosamente!</h2>
      <p class="text-muted mb-4">
        Tu cuenta ha sido creada. Revisa tu correo para verificar tu cuenta.
      </p>
      <a href="login.html" class="btn btn-register">
        <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
      </a>
    </div>
  `
}

const iniciarComponente = () => {
    generalidades.initTelefonoInput(`#tel`);

    Inputmask({
        mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
        greedy: false,
        onBeforePaste: function (pastedValue, opts) {
            pastedValue = pastedValue.toLowerCase();
            return pastedValue.replace("mailto:", "");
        },
        definitions: {
            "*": {
                validator: '[0-9A-Za-z!#$%&"*+/=?^_`{|}~\-]',
                cardinality: 1,
                casing: "lower"
            }
        }
    }).mask(`#email`);

    $("#registerForm #selectCiudad").select2({
        allowClear: true,
        dropdownParent: $('body'),
        placeholder: 'Seleccione la o las ciudades',
        ajax: {
            url: route('ciudades.buscar', { pais: 22 }),
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    busqueda: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.ciudades.map(function (item) {
                        return {
                            id: item.id,
                            text: item.text
                        };
                    })
                };
            },
            cache: true
        }
    });
}
