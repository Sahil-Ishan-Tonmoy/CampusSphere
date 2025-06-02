import "./bootstrap"

// Import all modules
import { ResultsInfoController } from "./modules/results-info.js"
import { QRGenerator } from "./modules/qr-generator.js"
import { InviteButton } from "./modules/invite-button.js"
import { Navbar } from "./modules/navbar.js"
import { SearchFilter } from "./modules/search-filter.js"

/**
 * Initialize all application modules when DOM is loaded
 */
document.addEventListener("DOMContentLoaded", () => {
  // Initialize Results Info Controller
  window.resultsInfoController = new ResultsInfoController()

  // Initialize QR Generator
  window.qrGenerator = new QRGenerator()

  // Initialize Invite Button
  window.inviteButton = new InviteButton()

  // Initialize Sidebar
  window.sidebar = new Sidebar()

  // Initialize Navbar
  window.navbar = new Navbar()

  // Initialize Search Filter
  window.searchFilter = new SearchFilter()

  console.log("🚀 CampusSphere application modules initialized")
})

// Global utility functions for external access
window.showResultsInfo = (state) => {
  window.resultsInfoController?.showWithState(state)
}

window.hideResultsInfo = () => {
  window.resultsInfoController?.hideWithAnimation()
}

window.toggleResultsInfo = () => {
  window.resultsInfoController?.toggleVisibility()
}

// Export modules for potential external use
export { ResultsInfoController, QRGenerator, InviteButton, Sidebar, Navbar, SearchFilter }
