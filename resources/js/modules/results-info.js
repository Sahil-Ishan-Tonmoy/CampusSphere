/**
 * Results Info Controller
 * Manages the visibility and state of search/filter results information
 */
export class ResultsInfoController {
  constructor() {
    this.resultsInfo = document.querySelector(".results-info")
    this.init()
  }

  init() {
    if (!this.resultsInfo) return

    // Check initial state
    this.updateVisibility()

    // Listen for search/filter changes
    this.setupEventListeners()

    // Check URL parameters on page load
    this.checkUrlParameters()
  }

  setupEventListeners() {
    // Listen for form submissions
    const searchForms = document.querySelectorAll(".search-filter-form")
    searchForms.forEach((form) => {
      form.addEventListener("submit", () => {
        this.showLoading()
      })
    })

    // Listen for filter button clicks
    const filterButtons = document.querySelectorAll(".filter-btn")
    filterButtons.forEach((button) => {
      button.addEventListener("click", () => {
        this.showLoading()
      })
    })

    // Listen for search input changes
    const searchInput = document.querySelector(".search-input")
    if (searchInput) {
      let searchTimeout
      searchInput.addEventListener("input", () => {
        clearTimeout(searchTimeout)
        searchTimeout = setTimeout(() => {
          this.updateVisibility()
        }, 300)
      })
    }

    // Listen for clear filters click
    const clearFilters = this.resultsInfo?.querySelector(".clear-filters")
    if (clearFilters) {
      clearFilters.addEventListener("click", () => {
        this.hide()
      })
    }
  }

  checkUrlParameters() {
    const urlParams = new URLSearchParams(window.location.search)
    const hasSearch = urlParams.get("search")
    const hasDepartment = urlParams.get("department")
    const hasFilters = hasSearch || hasDepartment

    if (hasFilters) {
      this.show()
      this.updateState()
    }
  }

  updateVisibility() {
    const urlParams = new URLSearchParams(window.location.search)
    const hasSearch = urlParams.get("search")
    const hasDepartment = urlParams.get("department")
    const hasFilters = hasSearch || hasDepartment

    if (hasFilters) {
      this.show()
      this.updateState()
    } else {
      this.hide()
    }
  }

  show() {
    if (!this.resultsInfo) return

    this.resultsInfo.classList.remove("fade-out")
    this.resultsInfo.classList.add("show")

    // Trigger reflow for animation
    this.resultsInfo.offsetHeight
  }

  hide() {
    if (!this.resultsInfo) return

    this.resultsInfo.classList.add("fade-out")

    setTimeout(() => {
      this.resultsInfo.classList.remove("show", "fade-out")
    }, 300)
  }

  showLoading() {
    if (!this.resultsInfo) return

    this.resultsInfo.classList.add("loading")
  }

  hideLoading() {
    if (!this.resultsInfo) return

    this.resultsInfo.classList.remove("loading")
  }

  updateState() {
    if (!this.resultsInfo) return

    // Remove all state classes
    this.resultsInfo.classList.remove("has-results", "no-results", "filtered")

    // Get results count (you'll need to pass this from your backend)
    const resultsText = this.resultsInfo.querySelector(".results-text")
    const hasResults = !resultsText?.textContent.includes("No faculty members found")
    const hasFilters = new URLSearchParams(window.location.search).toString() !== ""

    if (hasResults && hasFilters) {
      this.resultsInfo.classList.add("filtered")
    } else if (hasResults) {
      this.resultsInfo.classList.add("has-results")
    } else {
      this.resultsInfo.classList.add("no-results")
    }

    this.hideLoading()
  }

  // Public methods for external control
  showWithState(state = "default") {
    this.show()
    this.resultsInfo?.classList.add(state)
  }

  hideWithAnimation() {
    this.hide()
  }

  toggleVisibility() {
    if (this.resultsInfo?.classList.contains("show")) {
      this.hide()
    } else {
      this.show()
    }
  }
}
