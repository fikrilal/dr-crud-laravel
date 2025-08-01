import "./bootstrap";

// Bootstrap JavaScript - Import and expose globally
import * as bootstrap from "bootstrap";
window.bootstrap = bootstrap;

// Custom pharmacy management functionality
document.addEventListener("DOMContentLoaded", function () {
    // Initialize tooltips
    const tooltipTriggerList = document.querySelectorAll(
        '[data-bs-toggle="tooltip"]'
    );
    const tooltipList = [...tooltipTriggerList].map(
        (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
    );

    // Initialize popovers
    const popoverTriggerList = document.querySelectorAll(
        '[data-bs-toggle="popover"]'
    );
    const popoverList = [...popoverTriggerList].map(
        (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl)
    );

    // Sidebar toggle functionality
    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebar = document.getElementById("sidebar");

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener("click", function () {
            sidebar.classList.toggle("collapsed");
        });
    }

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll(".alert:not(.alert-permanent)");
    alerts.forEach((alert) => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            if (bsAlert) {
                bsAlert.close();
            }
        }, 5000);
    });

    // Form validation
    const forms = document.querySelectorAll(".needs-validation");
    forms.forEach((form) => {
        form.addEventListener("submit", function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add("was-validated");
        });
    });

    // Add fade-in animation to cards
    const cards = document.querySelectorAll(".card");
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add("fade-in");
        }, index * 100);
    });
});
