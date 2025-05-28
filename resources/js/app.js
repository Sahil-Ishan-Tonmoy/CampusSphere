import './bootstrap';
// Results Info Controller
class ResultsInfoController {
    constructor() {
        this.resultsInfo = document.querySelector('.results-info');
        this.init();
    }

    init() {
        if (!this.resultsInfo) return;
        
        // Check initial state
        this.updateVisibility();
        
        // Listen for search/filter changes
        this.setupEventListeners();
        
        // Check URL parameters on page load
        this.checkUrlParameters();
    }

    setupEventListeners() {
        // Listen for form submissions
        const searchForms = document.querySelectorAll('.search-filter-form');
        searchForms.forEach(form => {
            form.addEventListener('submit', () => {
                this.showLoading();
            });
        });

        // Listen for filter button clicks
        const filterButtons = document.querySelectorAll('.filter-btn');
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                this.showLoading();
            });
        });

        // Listen for search input changes
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', () => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.updateVisibility();
                }, 300);
            });
        }

        // Listen for clear filters click
        const clearFilters = this.resultsInfo?.querySelector('.clear-filters');
        if (clearFilters) {
            clearFilters.addEventListener('click', () => {
                this.hide();
            });
        }
    }

    checkUrlParameters() {
        const urlParams = new URLSearchParams(window.location.search);
        const hasSearch = urlParams.get('search');
        const hasDepartment = urlParams.get('department');
        const hasFilters = hasSearch || hasDepartment;

        if (hasFilters) {
            this.show();
            this.updateState();
        }
    }

    updateVisibility() {
        const urlParams = new URLSearchParams(window.location.search);
        const hasSearch = urlParams.get('search');
        const hasDepartment = urlParams.get('department');
        const hasFilters = hasSearch || hasDepartment;

        if (hasFilters) {
            this.show();
            this.updateState();
        } else {
            this.hide();
        }
    }

    show() {
        if (!this.resultsInfo) return;
        
        this.resultsInfo.classList.remove('fade-out');
        this.resultsInfo.classList.add('show');
        
        // Trigger reflow for animation
        this.resultsInfo.offsetHeight;
    }

    hide() {
        if (!this.resultsInfo) return;
        
        this.resultsInfo.classList.add('fade-out');
        
        setTimeout(() => {
            this.resultsInfo.classList.remove('show', 'fade-out');
        }, 300);
    }

    showLoading() {
        if (!this.resultsInfo) return;
        
        this.resultsInfo.classList.add('loading');
    }

    hideLoading() {
        if (!this.resultsInfo) return;
        
        this.resultsInfo.classList.remove('loading');
    }

    updateState() {
        if (!this.resultsInfo) return;

        // Remove all state classes
        this.resultsInfo.classList.remove('has-results', 'no-results', 'filtered');

        // Get results count (you'll need to pass this from your backend)
        const resultsText = this.resultsInfo.querySelector('.results-text');
        const hasResults = !resultsText?.textContent.includes('No faculty members found');
        const hasFilters = new URLSearchParams(window.location.search).toString() !== '';

        if (hasResults && hasFilters) {
            this.resultsInfo.classList.add('filtered');
        } else if (hasResults) {
            this.resultsInfo.classList.add('has-results');
        } else {
            this.resultsInfo.classList.add('no-results');
        }

        this.hideLoading();
    }

    // Public methods for external control
    showWithState(state = 'default') {
        this.show();
        this.resultsInfo?.classList.add(state);
    }

    hideWithAnimation() {
        this.hide();
    }

    toggleVisibility() {
        if (this.resultsInfo?.classList.contains('show')) {
            this.hide();
        } else {
            this.show();
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.resultsInfoController = new ResultsInfoController();
});

// Utility functions for manual control
window.showResultsInfo = (state) => {
    window.resultsInfoController?.showWithState(state);
};

window.hideResultsInfo = () => {
    window.resultsInfoController?.hideWithAnimation();
};

window.toggleResultsInfo = () => {
    window.resultsInfoController?.toggleVisibility();
};


// Combined App.js - QR Invite Generator & Invite Button
document.addEventListener('DOMContentLoaded', function() {
    
    // ========================================
    // QR INVITE GENERATOR MODULE
    // ========================================
    
    // QR Generator DOM Elements
    const qrGenUrlInput = document.getElementById('qr-invite-url-input');
    const qrGenSizeSelect = document.getElementById('qr-invite-size');
    const qrGenFormatSelect = document.getElementById('qr-invite-format');
    const qrGenGenerateBtn = document.getElementById('qr-invite-generate-btn');
    const qrGenResultsSection = document.getElementById('qr-invite-results');
    const qrGenQrDisplay = document.getElementById('qr-invite-qr-display');
    const qrGenDownloadBtn = document.getElementById('qr-invite-download-btn');
    const qrGenShareLink = document.getElementById('qr-invite-share-link');
    const qrGenCopyBtn = document.getElementById('qr-invite-copy-btn');
    const qrGenCopyFeedback = document.getElementById('qr-invite-copy-feedback');
    const qrGenPreview = document.getElementById('qr-invite-preview');

    // QR Generator State
    let qrGenCurrentQRDataURL = null;
    let qrGenCurrentQRSVG = null;

    // QR Generator Functions
    function qrGenGenerateQRCode(text, size, format) {
        const encodedText = encodeURIComponent(text);
        const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=${size}x${size}&data=${encodedText}&format=${format}`;
        
        if (format === 'svg') {
            return fetch(qrUrl)
                .then(response => response.text())
                .then(svgText => {
                    qrGenCurrentQRSVG = svgText;
                    return svgText;
                });
        } else {
            return new Promise((resolve) => {
                const img = new Image();
                img.crossOrigin = 'anonymous';
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    canvas.width = size;
                    canvas.height = size;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, size, size);
                    qrGenCurrentQRDataURL = canvas.toDataURL('image/png');
                    resolve(qrUrl);
                };
                img.src = qrUrl;
            });
        }
    }

    function qrGenGenerateShareLink(originalUrl) {
        const baseUrl = window.location.origin;
        const shortId = Math.random().toString(36).substr(2, 8);
        return `${baseUrl}/invite/${shortId}`;
    }

    function qrGenDisplayQRCode(qrUrl, format, size) {
        qrGenQrDisplay.innerHTML = '';
        
        if (format === 'svg') {
            qrGenQrDisplay.innerHTML = qrGenCurrentQRSVG;
            const svgElement = qrGenQrDisplay.querySelector('svg');
            if (svgElement) {
                svgElement.style.width = size + 'px';
                svgElement.style.height = size + 'px';
            }
        } else {
            const img = document.createElement('img');
            img.src = qrUrl;
            img.alt = 'Generated QR Code';
            img.style.maxWidth = '100%';
            img.style.height = 'auto';
            img.style.border = '1px solid #e5e7eb';
            img.style.borderRadius = '8px';
            qrGenQrDisplay.appendChild(img);
        }
    }

    function qrGenUpdatePreview(content) {
        qrGenPreview.innerHTML = '';
        
        if (qrGenIsValidURL(content)) {
            const link = document.createElement('a');
            link.href = content;
            link.textContent = content;
            link.target = '_blank';
            link.rel = 'noopener noreferrer';
            link.style.color = '#3b82f6';
            link.style.textDecoration = 'underline';
            qrGenPreview.appendChild(link);
        } else {
            const text = document.createElement('p');
            text.textContent = content;
            text.style.margin = '0';
            text.style.wordBreak = 'break-word';
            qrGenPreview.appendChild(text);
        }
    }

    function qrGenIsValidURL(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }

    function qrGenDownloadQRCode() {
        const format = qrGenFormatSelect.value;
        const filename = `qr-code-${Date.now()}.${format}`;
        
        if (format === 'svg') {
            const blob = new Blob([qrGenCurrentQRSVG], { type: 'image/svg+xml' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        } else {
            if (qrGenCurrentQRDataURL) {
                const a = document.createElement('a');
                a.href = qrGenCurrentQRDataURL;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            }
        }
    }

    async function qrGenCopyToClipboard(text) {
        try {
            await navigator.clipboard.writeText(text);
            qrGenCopyFeedback.textContent = 'Copied to clipboard!';
            qrGenCopyFeedback.className = 'qr-invite-copy-feedback qr-invite-success';
            setTimeout(() => {
                qrGenCopyFeedback.textContent = '';
                qrGenCopyFeedback.className = 'qr-invite-copy-feedback';
            }, 3000);
        } catch (err) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            try {
                document.execCommand('copy');
                qrGenCopyFeedback.textContent = 'Copied to clipboard!';
                qrGenCopyFeedback.className = 'qr-invite-copy-feedback qr-invite-success';
            } catch (err) {
                qrGenCopyFeedback.textContent = 'Failed to copy';
                qrGenCopyFeedback.className = 'qr-invite-copy-feedback qr-invite-error';
            }
            document.body.removeChild(textArea);
            setTimeout(() => {
                qrGenCopyFeedback.textContent = '';
                qrGenCopyFeedback.className = 'qr-invite-copy-feedback';
            }, 3000);
        }
    }

    async function qrGenGenerateQRAndLink() {
        const inputValue = qrGenUrlInput.value.trim();
        
        if (!inputValue) {
            alert('Please enter a URL or text to generate QR code');
            return;
        }

        qrGenGenerateBtn.innerHTML = '<span class="qr-invite-loading"></span> Generating...';
        qrGenGenerateBtn.disabled = true;

        try {
            const size = parseInt(qrGenSizeSelect.value);
            const format = qrGenFormatSelect.value;
            
            const qrUrl = await qrGenGenerateQRCode(inputValue, size, format);
            const shareLinkUrl = qrGenGenerateShareLink(inputValue);
            
            qrGenDisplayQRCode(qrUrl, format, size);
            qrGenShareLink.value = shareLinkUrl;
            qrGenUpdatePreview(inputValue);
            
            qrGenResultsSection.style.display = 'block';
            qrGenResultsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            
        } catch (error) {
            alert('Error generating QR code. Please try again.');
            console.error('QR Generation Error:', error);
        } finally {
            qrGenGenerateBtn.innerHTML = 'Generate QR Code & Link';
            qrGenGenerateBtn.disabled = false;
        }
    }

    // QR Generator Event Listeners
    if (qrGenGenerateBtn) {
        qrGenGenerateBtn.addEventListener('click', qrGenGenerateQRAndLink);
        
        if (qrGenUrlInput) {
            qrGenUrlInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    qrGenGenerateQRAndLink();
                }
            });
            
            qrGenUrlInput.addEventListener('input', function() {
                const value = this.value.trim();
                if (value) {
                    qrGenGenerateBtn.textContent = 'Generate QR Code & Link';
                    qrGenGenerateBtn.style.opacity = '1';
                } else {
                    qrGenGenerateBtn.textContent = 'Enter URL or Text';
                    qrGenGenerateBtn.style.opacity = '0.7';
                }
            });
        }

        if (qrGenDownloadBtn) {
            qrGenDownloadBtn.addEventListener('click', qrGenDownloadQRCode);
        }
        
        if (qrGenCopyBtn) {
            qrGenCopyBtn.addEventListener('click', function() {
                qrGenCopyToClipboard(qrGenShareLink.value);
            });
        }

        // QR Generator Initialize
        qrGenGenerateBtn.textContent = 'Enter URL or Text';
        qrGenGenerateBtn.style.opacity = '0.7';

        setTimeout(() => {
            if (qrGenUrlInput) {
                qrGenUrlInput.placeholder = 'Try: https://example.com or Hello World!';
            }
        }, 1000);
    }

    // ========================================
    // INVITE BUTTON MODULE
    // ========================================
    
    
    

    
    // Invite Button DOM Elements
    const inviteBtnTrigger = document.getElementById('invite-btn-trigger');

    const INVITE_BTN_URL = inviteBtnTrigger?.dataset?.inviteUrl || window.location.href;

    // Modify the URL to insert "/invite" after the domain
    



    const inviteBtnPopupOverlay = document.getElementById('invite-popup-overlay');
    const inviteBtnPopupClose = document.getElementById('invite-popup-close');
    const inviteBtnQrDisplay = document.getElementById('invite-popup-qr-display');
    const inviteBtnShareLink = document.getElementById('invite-popup-share-link');
    const inviteBtnCopyBtn = document.getElementById('invite-popup-copy-btn');
    const inviteBtnCopyFeedback = document.getElementById('invite-popup-copy-feedback');

    // Invite Button State
    let inviteBtnIsPopupOpen = false;
    let inviteBtnQrGenerated = false;

    // Invite Button Functions
    async function inviteBtnGenerateQRCode(url) {
        try {
            const encodedUrl = encodeURIComponent(url);
            const qrApiUrl = `https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=${encodedUrl}&format=png`;
            
            const img = new Image();
            img.crossOrigin = 'anonymous';
            
            return new Promise((resolve, reject) => {
                img.onload = function() {
                    resolve(qrApiUrl);
                };
                img.onerror = function() {
                    reject(new Error('Failed to load QR code'));
                };
                img.src = qrApiUrl;
            });
        } catch (error) {
            throw new Error('Failed to generate QR code');
        }
    }

    async function inviteBtnGenerateInviteLink(originalUrl) {
    try {
        const response = await fetch('/generate-invite', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ original_url: originalUrl }),
        });

        const data = await response.json();
        return data.short_url;
    } catch (error) {
        console.error('Failed to generate invite link', error);
        return originalUrl;
    }
}


    function inviteBtnDisplayQRCode(qrUrl) {
        inviteBtnQrDisplay.innerHTML = '';
        
        const img = document.createElement('img');
        img.src = qrUrl;
        img.alt = 'Invite QR Code';
        img.style.maxWidth = '100%';
        img.style.height = 'auto';
        
        img.style.opacity = '0';
        img.style.transition = 'opacity 0.5s ease';
        
        img.onload = function() {
            this.style.opacity = '1';
        };
        
        inviteBtnQrDisplay.appendChild(img);
    }

    async function inviteBtnCopyToClipboard(text) {
        try {
            await navigator.clipboard.writeText(text);
            inviteBtnShowCopyFeedback('Link copied to clipboard!', 'success');
            
            inviteBtnCopyBtn.classList.add('invite-popup-success-animation');
            setTimeout(() => {
                inviteBtnCopyBtn.classList.remove('invite-popup-success-animation');
            }, 600);
            
        } catch (err) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.opacity = '0';
            document.body.appendChild(textArea);
            textArea.select();
            
            try {
                document.execCommand('copy');
                inviteBtnShowCopyFeedback('Link copied to clipboard!', 'success');
            } catch (err) {
                inviteBtnShowCopyFeedback('Failed to copy link', 'error');
            }
            
            document.body.removeChild(textArea);
        }
    }

    function inviteBtnShowCopyFeedback(message, type) {
        inviteBtnCopyFeedback.textContent = message;
        inviteBtnCopyFeedback.className = `invite-popup-copy-feedback invite-popup-${type}`;
        
        setTimeout(() => {
            inviteBtnCopyFeedback.textContent = '';
            inviteBtnCopyFeedback.className = 'invite-popup-copy-feedback';
        }, 3000);
    }

    async function inviteBtnOpenInvitePopup() {
        if (inviteBtnIsPopupOpen) return;
        
        inviteBtnIsPopupOpen = true;
        inviteBtnPopupOverlay.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        inviteBtnQrGenerated = false;
        inviteBtnCopyBtn.disabled = true;
        inviteBtnShareLink.value = '';
        inviteBtnCopyFeedback.textContent = '';
        inviteBtnCopyFeedback.className = 'invite-popup-copy-feedback';
        
        inviteBtnQrDisplay.innerHTML = `
            <div class="invite-popup-loading">
                <div class="invite-popup-spinner"></div>
                <p>Generating QR Code...</p>
            </div>
        `;
        
        try {
            const [qrUrl, inviteLink] = await Promise.all([
                inviteBtnGenerateQRCode(INVITE_BTN_URL),
                Promise.resolve(inviteBtnGenerateInviteLink(INVITE_BTN_URL))
            ]);
            
            inviteBtnDisplayQRCode(qrUrl);
            inviteBtnShareLink.value = inviteLink;
            inviteBtnCopyBtn.disabled = false;
            inviteBtnQrGenerated = true;
            
        } catch (error) {
            console.error('Error generating invite content:', error);
            inviteBtnQrDisplay.innerHTML = `
                <div class="invite-popup-loading" style="color: #ef4444;">
                    <p>❌ Failed to generate QR code</p>
                    <small>Please try again</small>
                </div>
            `;
            
            inviteBtnShareLink.value = INVITE_BTN_URL;
            inviteBtnCopyBtn.disabled = false;
        }
    }

    function inviteBtnCloseInvitePopup() {
        if (!inviteBtnIsPopupOpen) return;
        
        inviteBtnIsPopupOpen = false;
        inviteBtnPopupOverlay.style.display = 'none';
        document.body.style.overflow = '';
        
        inviteBtnCopyFeedback.textContent = '';
        inviteBtnCopyFeedback.className = 'invite-popup-copy-feedback';
    }

    // Invite Button Event Listeners
    if (inviteBtnTrigger) {
        inviteBtnTrigger.addEventListener('click', inviteBtnOpenInvitePopup);
        
        if (inviteBtnPopupClose) {
            inviteBtnPopupClose.addEventListener('click', inviteBtnCloseInvitePopup);
        }
        
        if (inviteBtnPopupOverlay) {
            inviteBtnPopupOverlay.addEventListener('click', function(e) {
                if (e.target === inviteBtnPopupOverlay) {
                    inviteBtnCloseInvitePopup();
                }
            });
        }
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && inviteBtnIsPopupOpen) {
                inviteBtnCloseInvitePopup();
            }
        });
        
        if (inviteBtnCopyBtn) {
            inviteBtnCopyBtn.addEventListener('click', function() {
                const linkToCopy = inviteBtnShareLink.value;
                if (linkToCopy) {
                    inviteBtnCopyToClipboard(linkToCopy);
                }
            });
        }
        
        if (inviteBtnShareLink) {
            inviteBtnShareLink.addEventListener('click', function() {
                this.select();
            });
        }

        // Invite Button Initialize
        console.log('Invite Button initialized with URL:', INVITE_BTN_URL);
        console.log('⚠️ Remember to change the INVITE_BTN_URL constant to your actual invite URL');
    }
});