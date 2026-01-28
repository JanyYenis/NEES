document.addEventListener("DOMContentLoaded", () => {
  // Elements
  const loginForm = document.getElementById("loginForm")
  const emailInput = document.getElementById("email")
  const passwordInput = document.getElementById("password")
  const togglePasswordBtn = document.getElementById("togglePassword")
  const emailError = document.getElementById("emailError")
  const passwordError = document.getElementById("passwordError")

  // Password Toggle Functionality
  togglePasswordBtn.addEventListener("click", function () {
    const type = passwordInput.getAttribute("type") === "password" ? "text" : "password"
    passwordInput.setAttribute("type", type)

    // Toggle icon
    const icon = this.querySelector("i")
    icon.classList.toggle("bi-eye")
    icon.classList.toggle("bi-eye-slash")
  })

  // Real-time Email Validation
  emailInput.addEventListener("input", function () {
    validateEmail(this.value)
  })

  emailInput.addEventListener("blur", function () {
    validateEmail(this.value)
  })

  // Real-time Password Validation
  passwordInput.addEventListener("input", function () {
    validatePassword(this.value)
  })

  passwordInput.addEventListener("blur", function () {
    validatePassword(this.value)
  })

  // Email Validation Function
  function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/

    if (email === "") {
      showError(emailInput, emailError, "")
      return false
    } else if (!emailRegex.test(email)) {
      showError(emailInput, emailError, "Por favor, ingresa un correo válido")
      return false
    } else {
      showSuccess(emailInput, emailError)
      return true
    }
  }

  // Password Validation Function
  function validatePassword(password) {
    if (password === "") {
      showError(passwordInput, passwordError, "")
      return false
    } else if (password.length < 6) {
      showError(passwordInput, passwordError, "La contraseña debe tener al menos 6 caracteres")
      return false
    } else {
      showSuccess(passwordInput, passwordError)
      return true
    }
  }

  // Show Error
  function showError(input, errorElement, message) {
    input.classList.remove("is-valid")
    input.classList.add("is-invalid")
    errorElement.textContent = message
    errorElement.classList.add("show")
  }

  // Show Success
  function showSuccess(input, errorElement) {
    input.classList.remove("is-invalid")
    input.classList.add("is-valid")
    errorElement.textContent = ""
    errorElement.classList.remove("show")
  }

  // Form Submit
  loginForm.addEventListener("submit", function (e) {
    e.preventDefault()

    const isEmailValid = validateEmail(emailInput.value)
    const isPasswordValid = validatePassword(passwordInput.value)

    if (isEmailValid && isPasswordValid) {
      // Show loading state
      const btnText = this.querySelector(".btn-text")
      const btnLoader = this.querySelector(".btn-loader")
      const submitBtn = this.querySelector('button[type="submit"]')

      btnText.classList.add("d-none")
      btnLoader.classList.remove("d-none")
      submitBtn.disabled = true

      // Simulate login process
      setTimeout(() => {
        // Reset button state
        btnText.classList.remove("d-none")
        btnLoader.classList.add("d-none")
        submitBtn.disabled = false

        // Show success message (in a real app, you would redirect)
        alert("¡Inicio de sesión exitoso! Redirigiendo...")

        // In a real application, you would redirect to the dashboard
        // window.location.href = "dashboard.html";
      }, 2000)
    } else {
      // Force validation on both fields
      validateEmail(emailInput.value)
      validatePassword(passwordInput.value)
    }
  })

  // Add focus animations
  const formControls = document.querySelectorAll(".form-control")
  formControls.forEach((control) => {
    control.addEventListener("focus", function () {
      this.parentElement.style.transform = "translateY(-2px)"
    })

    control.addEventListener("blur", function () {
      this.parentElement.style.transform = "translateY(0)"
    })
  })

  // Prevent form submission on Enter for social login
  document.querySelector(".btn-social").addEventListener("click", (e) => {
    e.preventDefault()
    alert("Funcionalidad de Google Sign-In próximamente")
  })
})
