/**
 * Search and Filter Module
 * Handles search input and filter button functionality
 */
export class SearchFilter {
  constructor() {
    this.initElements()
    this.init()
  }

  initElements() {
    this.resultsInfo = document.querySelector(".results-info")
    this.filterButtons = document.querySelectorAll(".filter-btn")
    this.searchInput = document.querySelector(".search-input")
    this.clearFilters = document.querySelector(".clear-filters")
  }

  init() {
    this.setupEventListeners()
    this.checkInitialState()
  }

  setupEventListeners() {
    // Handle filter button clicks
    this.filterButtons.forEach((button) => {
      button.addEventListener("click", (e) => this.handleFilterClick(e))
    })

    // Handle search input
    if (this.searchInput) {
      this.searchInput.addEventListener("input", () => this.handleSearchInput())
    }

    // Handle clear filters
    if (this.clearFilters) {
      this.clearFilters.addEventListener("click", (e) => this.handleClearFilters(e))
    }
  }

  checkInitialState() {
    // Initialize results info display if search or filter is active
    if (
      this.resultsInfo &&
      (window.location.search.includes("search=") || window.location.search.includes("department="))
    ) {
      this.resultsInfo.classList.add("show")
    }
  }

  handleFilterClick(e) {
    // Remove active class from all buttons
    this.filterButtons.forEach((btn) => {
      btn.classList.remove("active")
    })

    // Add active class to clicked button
    e.target.classList.add("active")

    // Show results info
    if (this.resultsInfo) {
      this.resultsInfo.classList.add("show")
    }
  }

  handleSearchInput() {
    if (this.searchInput.value.trim() !== "" && this.resultsInfo) {
      this.resultsInfo.classList.add("show")
    }
  }

  handleClearFilters(e) {
    e.preventDefault()

    // Clear search input
    if (this.searchInput) {
      this.searchInput.value = ""
    }

    // Remove active class from filter buttons
    this.filterButtons.forEach((btn) => {
      btn.classList.remove("active")
    })

    // Hide results info
    if (this.resultsInfo) {
      this.resultsInfo.classList.remove("show")
    }

    // Redirect to clean URL
    window.location.href = window.location.pathname
  }
}
