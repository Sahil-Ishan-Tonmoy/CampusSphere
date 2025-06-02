/**
 * QR Code Generator Module
 * Handles QR code generation with various formats and sizes
 */
export class QRGenerator {
  constructor() {
    this.initElements()
    this.currentQRDataURL = null
    this.currentQRSVG = null
    this.init()
  }

  initElements() {
    this.urlInput = document.getElementById("qr-invite-url-input")
    this.sizeSelect = document.getElementById("qr-invite-size")
    this.formatSelect = document.getElementById("qr-invite-format")
    this.generateBtn = document.getElementById("qr-invite-generate-btn")
    this.resultsSection = document.getElementById("qr-invite-results")
    this.qrDisplay = document.getElementById("qr-invite-qr-display")
    this.downloadBtn = document.getElementById("qr-invite-download-btn")
    this.shareLink = document.getElementById("qr-invite-share-link")
    this.copyBtn = document.getElementById("qr-invite-copy-btn")
    this.copyFeedback = document.getElementById("qr-invite-copy-feedback")
    this.preview = document.getElementById("qr-invite-preview")
  }

  init() {
    if (!this.generateBtn) return

    this.setupEventListeners()
    this.initializeUI()
  }

  setupEventListeners() {
    this.generateBtn.addEventListener("click", () => this.generateQRAndLink())

    if (this.urlInput) {
      this.urlInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter") {
          this.generateQRAndLink()
        }
      })

      this.urlInput.addEventListener("input", () => this.handleInputChange())
    }

    if (this.downloadBtn) {
      this.downloadBtn.addEventListener("click", () => this.downloadQRCode())
    }

    if (this.copyBtn) {
      this.copyBtn.addEventListener("click", () => {
        this.copyToClipboard(this.shareLink.value)
      })
    }
  }

  initializeUI() {
    this.generateBtn.textContent = "Enter URL or Text"
    this.generateBtn.style.opacity = "0.7"

    setTimeout(() => {
      if (this.urlInput) {
        this.urlInput.placeholder = "Try: https://example.com or Hello World!"
      }
    }, 1000)
  }

  handleInputChange() {
    const value = this.urlInput.value.trim()
    if (value) {
      this.generateBtn.textContent = "Generate QR Code & Link"
      this.generateBtn.style.opacity = "1"
    } else {
      this.generateBtn.textContent = "Enter URL or Text"
      this.generateBtn.style.opacity = "0.7"
    }
  }

  async generateQRCode(text, size, format) {
    const encodedText = encodeURIComponent(text)
    const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=${size}x${size}&data=${encodedText}&format=${format}`

    if (format === "svg") {
      const response = await fetch(qrUrl)
      const svgText = await response.text()
      this.currentQRSVG = svgText
      return svgText
    } else {
      return new Promise((resolve) => {
        const img = new Image()
        img.crossOrigin = "anonymous"
        img.onload = () => {
          const canvas = document.createElement("canvas")
          canvas.width = size
          canvas.height = size
          const ctx = canvas.getContext("2d")
          ctx.drawImage(img, 0, 0, size, size)
          this.currentQRDataURL = canvas.toDataURL("image/png")
          resolve(qrUrl)
        }
        img.src = qrUrl
      })
    }
  }

  generateShareLink(originalUrl) {
    const baseUrl = window.location.origin
    const shortId = Math.random().toString(36).substr(2, 8)
    return `${baseUrl}/invite/${shortId}`
  }

  displayQRCode(qrUrl, format, size) {
    this.qrDisplay.innerHTML = ""

    if (format === "svg") {
      this.qrDisplay.innerHTML = this.currentQRSVG
      const svgElement = this.qrDisplay.querySelector("svg")
      if (svgElement) {
        svgElement.style.width = size + "px"
        svgElement.style.height = size + "px"
      }
    } else {
      const img = document.createElement("img")
      img.src = qrUrl
      img.alt = "Generated QR Code"
      img.style.maxWidth = "100%"
      img.style.height = "auto"
      img.style.border = "1px solid #e5e7eb"
      img.style.borderRadius = "8px"
      this.qrDisplay.appendChild(img)
    }
  }

  updatePreview(content) {
    this.preview.innerHTML = ""

    if (this.isValidURL(content)) {
      const link = document.createElement("a")
      link.href = content
      link.textContent = content
      link.target = "_blank"
      link.rel = "noopener noreferrer"
      link.style.color = "#3b82f6"
      link.style.textDecoration = "underline"
      this.preview.appendChild(link)
    } else {
      const text = document.createElement("p")
      text.textContent = content
      text.style.margin = "0"
      text.style.wordBreak = "break-word"
      this.preview.appendChild(text)
    }
  }

  isValidURL(string) {
    try {
      new URL(string)
      return true
    } catch (_) {
      return false
    }
  }

  downloadQRCode() {
    const format = this.formatSelect.value
    const filename = `qr-code-${Date.now()}.${format}`

    if (format === "svg") {
      const blob = new Blob([this.currentQRSVG], { type: "image/svg+xml" })
      const url = URL.createObjectURL(blob)
      const a = document.createElement("a")
      a.href = url
      a.download = filename
      document.body.appendChild(a)
      a.click()
      document.body.removeChild(a)
      URL.revokeObjectURL(url)
    } else {
      if (this.currentQRDataURL) {
        const a = document.createElement("a")
        a.href = this.currentQRDataURL
        a.download = filename
        document.body.appendChild(a)
        a.click()
        document.body.removeChild(a)
      }
    }
  }

  async copyToClipboard(text) {
    try {
      await navigator.clipboard.writeText(text)
      this.showCopyFeedback("Copied to clipboard!", "success")
    } catch (err) {
      // Fallback for older browsers
      const textArea = document.createElement("textarea")
      textArea.value = text
      document.body.appendChild(textArea)
      textArea.select()
      try {
        document.execCommand("copy")
        this.showCopyFeedback("Copied to clipboard!", "success")
      } catch (err) {
        this.showCopyFeedback("Failed to copy", "error")
      }
      document.body.removeChild(textArea)
    }
  }

  showCopyFeedback(message, type) {
    this.copyFeedback.textContent = message
    this.copyFeedback.className = `qr-invite-copy-feedback qr-invite-${type}`
    setTimeout(() => {
      this.copyFeedback.textContent = ""
      this.copyFeedback.className = "qr-invite-copy-feedback"
    }, 3000)
  }

  async generateQRAndLink() {
    const inputValue = this.urlInput.value.trim()

    if (!inputValue) {
      alert("Please enter a URL or text to generate QR code")
      return
    }

    this.generateBtn.innerHTML = '<span class="qr-invite-loading"></span> Generating...'
    this.generateBtn.disabled = true

    try {
      const size = Number.parseInt(this.sizeSelect.value)
      const format = this.formatSelect.value

      const qrUrl = await this.generateQRCode(inputValue, size, format)
      const shareLinkUrl = this.generateShareLink(inputValue)

      this.displayQRCode(qrUrl, format, size)
      this.shareLink.value = shareLinkUrl
      this.updatePreview(inputValue)

      this.resultsSection.style.display = "block"
      this.resultsSection.scrollIntoView({ behavior: "smooth", block: "start" })
    } catch (error) {
      alert("Error generating QR code. Please try again.")
      console.error("QR Generation Error:", error)
    } finally {
      this.generateBtn.innerHTML = "Generate QR Code & Link"
      this.generateBtn.disabled = false
    }
  }
}
