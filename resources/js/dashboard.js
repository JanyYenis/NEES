// import { Chart } from "@/components/ui/chart"
// Dashboard Data and Functionality

// Sample Data
const pedidosRecientes = [
  {
    id: "PED-001",
    cliente: "Juan Pérez",
    estado: "produccion",
    fechaEntrega: "2024-01-25",
    total: 3500,
  },
  {
    id: "PED-002",
    cliente: "María García",
    estado: "listo",
    fechaEntrega: "2024-01-23",
    total: 5200,
  },
  {
    id: "PED-003",
    cliente: "Carlos López",
    estado: "pendiente",
    fechaEntrega: "2024-01-28",
    total: 2800,
  },
  {
    id: "PED-004",
    cliente: "Ana Martínez",
    estado: "entregado",
    fechaEntrega: "2024-01-20",
    total: 4100,
  },
  {
    id: "PED-005",
    cliente: "Luis Rodríguez",
    estado: "produccion",
    fechaEntrega: "2024-01-26",
    total: 6300,
  },
]

const cotizacionesPendientes = [
  {
    id: "COT-015",
    cliente: "Roberto Silva",
    total: 4500,
    estado: "enviada",
    antiguedad: "nueva", // nueva, reciente, antigua
  },
  {
    id: "COT-016",
    cliente: "Patricia Gómez",
    total: 3200,
    estado: "enviada",
    antiguedad: "reciente",
  },
  {
    id: "COT-017",
    cliente: "Fernando Torres",
    total: 7800,
    estado: "borrador",
    antiguedad: "antigua",
  },
  {
    id: "COT-018",
    cliente: "Laura Díaz",
    total: 5600,
    estado: "enviada",
    antiguedad: "nueva",
  },
]

const alertas = [
  {
    tipo: "danger",
    icon: "exclamation-triangle",
    titulo: "Pedido vencido",
    mensaje: "PED-001 debió entregarse hace 2 días",
    tiempo: "Hace 2h",
  },
  {
    tipo: "warning",
    icon: "clock",
    titulo: "Entrega próxima",
    mensaje: "PED-003 se entrega mañana",
    tiempo: "Hace 5h",
  },
  {
    tipo: "info",
    icon: "file-text",
    titulo: "Cotización sin respuesta",
    mensaje: "COT-017 tiene 15 días sin respuesta",
    tiempo: "Hace 1d",
  },
  {
    tipo: "warning",
    icon: "box-seam",
    titulo: "Material crítico",
    mensaje: "Acero inoxidable con stock bajo",
    tiempo: "Hace 2d",
  },
]

// Estado Badge Helper
function getEstadoBadge(estado) {
  const badges = {
    pendiente: '<span class="badge-pedido badge-pendiente"><i class="bi bi-clock"></i> Pendiente</span>',
    produccion: '<span class="badge-pedido badge-produccion"><i class="bi bi-gear"></i> En Producción</span>',
    listo: '<span class="badge-pedido badge-listo"><i class="bi bi-check-circle"></i> Listo</span>',
    entregado: '<span class="badge-pedido badge-entregado"><i class="bi bi-truck"></i> Entregado</span>',
  }
  return badges[estado] || badges.pendiente
}

// Antiguedad Badge Helper
function getAntiguedadBadge(antiguedad) {
  const badges = {
    nueva: '<span class="badge badge-nueva">Nueva</span>',
    reciente: '<span class="badge badge-reciente">7+ días</span>',
    antigua: '<span class="badge badge-antigua">15+ días</span>',
  }
  return badges[antiguedad] || badges.nueva
}

// Format Currency
function formatCurrency(amount) {
  return new Intl.NumberFormat("es-MX", {
    style: "currency",
    currency: "MXN",
  }).format(amount)
}

// Format Date
function formatDate(dateString) {
  const date = new Date(dateString)
  return new Intl.DateTimeFormat("es-MX", {
    day: "2-digit",
    month: "short",
    year: "numeric",
  }).format(date)
}

// Load Pedidos Recientes
function loadPedidosRecientes() {
  const tbody = document.getElementById("pedidosRecientesBody")
  tbody.innerHTML = pedidosRecientes
    .map(
      (pedido) => `
    <tr>
      <td><strong>${pedido.id}</strong></td>
      <td>${pedido.cliente}</td>
      <td>${getEstadoBadge(pedido.estado)}</td>
      <td>${formatDate(pedido.fechaEntrega)}</td>
      <td><strong>${formatCurrency(pedido.total)}</strong></td>
      <td>
        <div class="d-flex gap-2">
          <button class="btn-action btn-view" onclick="verPedido('${pedido.id}')" title="Ver detalles">
            <i class="bi bi-eye"></i>
          </button>
          <button class="btn-action btn-edit" onclick="cambiarEstado('${pedido.id}')" title="Cambiar estado">
            <i class="bi bi-arrow-repeat"></i>
          </button>
        </div>
      </td>
    </tr>
  `,
    )
    .join("")
}

// Load Cotizaciones Pendientes
function loadCotizacionesPendientes() {
  const grid = document.getElementById("cotizacionesGrid")
  grid.innerHTML = cotizacionesPendientes
    .map(
      (cot) => `
    <div class="cotizacion-card">
      <div class="cotizacion-info">
        <h6>${cot.id} - ${cot.cliente}</h6>
        <p class="cotizacion-total">${formatCurrency(cot.total)}</p>
      </div>
      <div class="cotizacion-actions">
        ${getAntiguedadBadge(cot.antiguedad)}
        <button class="btn-convert" onclick="convertirPedido('${cot.id}')">
          <i class="bi bi-arrow-right"></i> Convertir en Pedido
        </button>
      </div>
    </div>
  `,
    )
    .join("")
}

// Load Alertas
function loadAlertas() {
  const alertsList = document.getElementById("alertsList")
  alertsList.innerHTML = alertas
    .map(
      (alerta) => `
    <div class="alert-item">
      <div class="alert-item-header">
        <div class="alert-title">
          <div class="alert-icon ${alerta.tipo}">
            <i class="bi bi-${alerta.icon}"></i>
          </div>
          ${alerta.titulo}
        </div>
        <span class="alert-time">${alerta.tiempo}</span>
      </div>
      <p class="alert-message">${alerta.mensaje}</p>
    </div>
  `,
    )
    .join("")
}

// Initialize Charts
function initCharts() {
//   // Cotizaciones vs Pedidos Chart
//   const ctxCotPed = document.getElementById("cotizacionesPedidosChart")
//   new Chart(ctxCotPed, {
//     type: "bar",
//     data: {
//       labels: ["Ago", "Sep", "Oct", "Nov", "Dic", "Ene"],
//       datasets: [
//         {
//           label: "Cotizaciones",
//           data: [18, 22, 20, 25, 24, 28],
//           backgroundColor: "rgba(14, 165, 233, 0.8)",
//           borderRadius: 8,
//           borderSkipped: false,
//         },
//         {
//           label: "Pedidos",
//           data: [12, 15, 14, 18, 19, 15],
//           backgroundColor: "rgba(16, 185, 129, 0.8)",
//           borderRadius: 8,
//           borderSkipped: false,
//         },
//       ],
//     },
//     options: {
//       responsive: true,
//       maintainAspectRatio: true,
//       aspectRatio: 2.5,
//       plugins: {
//         legend: {
//           display: false,
//         },
//         tooltip: {
//           backgroundColor: "#1a1d24",
//           titleColor: "#e5e5e5",
//           bodyColor: "#9ca3af",
//           borderColor: "#2a2e38",
//           borderWidth: 1,
//           padding: 12,
//           displayColors: true,
//           boxWidth: 10,
//           boxHeight: 10,
//         },
//       },
//       scales: {
//         x: {
//           grid: {
//             color: "rgba(42, 46, 56, 0.5)",
//             drawBorder: false,
//           },
//           ticks: {
//             color: "#9ca3af",
//           },
//         },
//         y: {
//           grid: {
//             color: "rgba(42, 46, 56, 0.5)",
//             drawBorder: false,
//           },
//           ticks: {
//             color: "#9ca3af",
//           },
//           beginAtZero: true,
//         },
//       },
//     },
//   })

//   // Ingresos Chart
//   const ctxIngresos = document.getElementById("ingresosChart")
//   new Chart(ctxIngresos, {
//     type: "line",
//     data: {
//       labels: ["Ago", "Sep", "Oct", "Nov", "Dic", "Ene"],
//       datasets: [
//         {
//           label: "Ingresos",
//           data: [32000, 38000, 35000, 42000, 39100, 48500],
//           borderColor: "#0ea5e9",
//           backgroundColor: "rgba(14, 165, 233, 0.1)",
//           borderWidth: 3,
//           fill: true,
//           tension: 0.4,
//           pointBackgroundColor: "#0ea5e9",
//           pointBorderColor: "#0f1115",
//           pointBorderWidth: 2,
//           pointRadius: 5,
//           pointHoverRadius: 7,
//         },
//       ],
//     },
//     options: {
//       responsive: true,
//       maintainAspectRatio: true,
//       aspectRatio: 1.2,
//       plugins: {
//         legend: {
//           display: false,
//         },
//         tooltip: {
//           backgroundColor: "#1a1d24",
//           titleColor: "#e5e5e5",
//           bodyColor: "#9ca3af",
//           borderColor: "#2a2e38",
//           borderWidth: 1,
//           padding: 12,
//           displayColors: false,
//           callbacks: {
//             label: (context) => formatCurrency(context.parsed.y),
//           },
//         },
//       },
//       scales: {
//         x: {
//           grid: {
//             color: "rgba(42, 46, 56, 0.5)",
//             drawBorder: false,
//           },
//           ticks: {
//             color: "#9ca3af",
//           },
//         },
//         y: {
//           grid: {
//             color: "rgba(42, 46, 56, 0.5)",
//             drawBorder: false,
//           },
//           ticks: {
//             color: "#9ca3af",
//             callback: (value) => "$" + value / 1000 + "k",
//           },
//         },
//       },
//     },
//   })
}

// Time Filter Functionality
document.addEventListener("DOMContentLoaded", () => {
  // Load all data
  loadPedidosRecientes()
  loadCotizacionesPendientes()
  loadAlertas()
  initCharts()

  // Time Filter
  const filterButtons = document.querySelectorAll(".btn-filter")
  filterButtons.forEach((btn) => {
    btn.addEventListener("click", function () {
      filterButtons.forEach((b) => b.classList.remove("active"))
      this.classList.add("active")
      const period = this.dataset.period
      console.log("[v0] Filtering by period:", period)
      // Here you would update the data based on the selected period
    })
  })

  // Sidebar Toggle
  const toggleBtn = document.getElementById("toggleSidebar")
  const sidebar = document.getElementById("sidebar")
  if (toggleBtn) {
    toggleBtn.addEventListener("click", () => {
      sidebar.classList.toggle("show")
    })
  }
})

// Action Functions (placeholders for Laravel integration)
function verPedido(id) {
  console.log("[v0] Ver pedido:", id)
  window.location.href = `pedidos.html?id=${id}`
}

function cambiarEstado(id) {
  console.log("[v0] Cambiar estado pedido:", id)
  // Open modal or redirect
}

function convertirPedido(id) {
  console.log("[v0] Convertir cotización a pedido:", id)
  if (confirm(`¿Desea convertir la cotización ${id} en pedido?`)) {
    // Process conversion
    alert("Cotización convertida exitosamente")
  }
}
