/**
 * Invite Button Module
 * Handles invite popup with QR code generation and link sharing
 */
export class InviteButton {
  constructor() {
    this.initElements()
    this.isPopupOpen = false
    this.qrGenerated = false
    this.inviteUrl = this.trigger?.dataset?.inviteUrl || window.location.href
    this.init()
  }

  initElements() {
    this.trigger = document.getElementById("invite-btn-trigger")
    this.popupOverlay = document.getElementById("invite-popup-overlay")
    this.popupClose = document.getElementById("invite-popup-close")
    this.qrDisplay = document.getElementById("invite-popup-qr-display")
    this.shareLink = document.getElementById("invite-popup-share-link")
    this.copyBtn = document.getElementById("invite-popup-copy-btn")
    this.copyFeedback = document.getElementById("invite-popup-copy-feedback")
  }

  init() {
    if (!this.trigger) return

    this.setupEventListeners()
    console.log("Invite Button initialized with URL:", this.inviteUrl)
  }

  setupEventListeners() {
    this.trigger.addEventListener("click", () => this.openInvitePopup())

    if (this.popupClose) {
      this.popupClose.addEventListener("click", () => this.closeInvitePopup())
    }

    if (this.popupOverlay) {
      this.popupOverlay.addEventListener("click", (e) => {
        if (e.target === this.popupOverlay) {
          this.closeInvitePopup()
        }
      })
    }

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && this.isPopupOpen) {
        this.closeInvitePopup()
      }
    })

    if (this.copyBtn) {
      this.copyBtn.addEventListener("click", () => {
        const linkToCopy = this.shareLink.value
        if (linkToCopy) {
          this.copyToClipboard(linkToCopy)
        }
      })
    }

    if (this.shareLink) {
      this.shareLink.addEventListener("click", function () {
        this.select()
      })
    }
  }

  async generateQRCode(url) {
    try {
      const encodedUrl = encodeURIComponent(url)
      const qrApiUrl = `https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=${encodedUrl}&format=png`

      const img = new Image()
      img.crossOrigin = "anonymous"

      return new Promise((resolve, reject) => {
        img.onload = () => resolve(qrApiUrl)
        img.onerror = () => reject(new Error("Failed to load QR code"))
        img.src = qrApiUrl
      })
    } catch (error) {
      throw new Error("Failed to generate QR code")
    }
  }

  async generateInviteLink(originalUrl) {
    try {
      const response = await fetch("/generate-invite", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
        body: JSON.stringify({ original_url: originalUrl }),
      })

      const data = await response.json()
      return data.short_url
    } catch (error) {
      console.error("Failed to generate invite link", error)
      return originalUrl
    }
  }

  displayQRCode(qrUrl) {
    this.qrDisplay.innerHTML = ""

    const img = document.createElement("img")
    img.src = qrUrl
    img.alt = "Invite QR Code"
    img.style.maxWidth = "100%"
    img.style.height = "auto"
    img.style.opacity = "0"
    img.style.transition = "opacity 0.5s ease"

    img.onload = function () {
      this.style.opacity = "1"
    }

    this.qrDisplay.appendChild(img)
  }

  async copyToClipboard(text) {
    try {
      await navigator.clipboard.writeText(text)
      this.showCopyFeedback("Link copied to clipboard!", "success")

      this.copyBtn.classList.add("invite-popup-success-animation")
      setTimeout(() => {
        this.copyBtn.classList.remove("invite-popup-success-animation")
      }, 600)
    } catch (err) {
      // Fallback for older browsers
      const textArea = document.createElement("textarea")
      textArea.value = text
      textArea.style.position = "fixed"
      textArea.style.opacity = "0"
      document.body.appendChild(textArea)
      textArea.select()

      try {
        document.execCommand("copy")
        this.showCopyFeedback("Link copied to clipboard!", "success")
      } catch (err) {
        this.showCopyFeedback("Failed to copy link", "error")
      }

      document.body.removeChild(textArea)
    }
  }

  showCopyFeedback(message, type) {
    this.copyFeedback.textContent = message
    this.copyFeedback.className = `invite-popup-copy-feedback invite-popup-${type}`

    setTimeout(() => {
      this.copyFeedback.textContent = ""
      this.copyFeedback.className = "invite-popup-copy-feedback"
    }, 3000)
  }

  async openInvitePopup() {
    if (this.isPopupOpen) return

    this.isPopupOpen = true
    this.popupOverlay.style.display = "flex"
    document.body.style.overflow = "hidden"

    this.qrGenerated = false
    this.copyBtn.disabled = true
    this.shareLink.value = ""
    this.copyFeedback.textContent = ""
    this.copyFeedback.className = "invite-popup-copy-feedback"

    this.qrDisplay.innerHTML = `
            <div class="invite-popup-loading">
                <div class="invite-popup-spinner"></div>
                <p>Generating QR Code...</p>
            </div>
        `

    try {
      const [qrUrl, inviteLink] = await Promise.all([
        this.generateQRCode(this.inviteUrl),
        this.generateInviteLink(this.inviteUrl),
      ])

      this.displayQRCode(qrUrl)
      this.shareLink.value = inviteLink
      this.copyBtn.disabled = false
      this.qrGenerated = true
    } catch (error) {
      console.error("Error generating invite content:", error)
      this.qrDisplay.innerHTML = `
                <div class="invite-popup-loading" style="color: #ef4444;">
                    <p>❌ Failed to generate QR code</p>
                    <small>Please try again</small>
                </div>
            `

      this.shareLink.value = this.inviteUrl
      this.copyBtn.disabled = false
    }
  }

  closeInvitePopup() {
    if (!this.isPopupOpen) return

    this.isPopupOpen = false
    this.popupOverlay.style.display = "none"
    document.body.style.overflow = ""

    this.copyFeedback.textContent = ""
    this.copyFeedback.className = "invite-popup-copy-feedback"
  }
}
