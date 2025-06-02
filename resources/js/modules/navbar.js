/**
 * Navbar Module
 * Handles mobile navbar toggle and menu interactions
 */
export class Navbar {
  constructor() {
    this.initElements()
    this.init()
  }

  initElements() {
    this.navToggle = document.getElementById("nav-toggle")
    this.navMenu = document.getElementById("nav-menu")
  }

  init() {
    if (!this.navToggle || !this.navMenu) return

    this.setupEventListeners()
  }

  setupEventListeners() {
    this.navToggle.addEventListener("click", () => this.toggleMobileMenu())

    // Close mobile menu when clicking on a link
    const navLinks = this.navMenu.querySelectorAll(".nav-link")
    navLinks.forEach((link) => {
      link.addEventListener("click", () => this.closeMobileMenu())
    })

    // Close mobile menu when clicking outside
    document.addEventListener("click", (e) => {
      if (!this.navToggle.contains(e.target) && !this.navMenu.contains(e.target)) {
        this.closeMobileMenu()
      }
    })
  }

  toggleMobileMenu() {
    this.navToggle.classList.toggle("active")
    this.navMenu.classList.toggle("active")
  }

  closeMobileMenu() {
    this.navToggle.classList.remove("active")
    this.navMenu.classList.remove("active")
  }
}
