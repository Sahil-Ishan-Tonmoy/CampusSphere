@props(['inviteUrl'])

<div class="invite-btn-container">
    <button id="invite-btn-trigger" class="invite-btn-main" data-invite-url="{{ $inviteUrl }}">
        <svg class="invite-btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
        </svg>
        Invite & Share
    </button>
</div>

<!-- Popup Modal -->
<div id="invite-popup-overlay" class="invite-popup-overlay" style="display: none;">
    <div class="invite-popup-container">
        <div class="invite-popup-header">
            <h2 class="invite-popup-title">Share Invite</h2>
            <button id="invite-popup-close" class="invite-popup-close">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        
        <div class="invite-popup-content">
            <div class="invite-popup-qr-section">
                <div id="invite-popup-qr-display" class="invite-popup-qr-display">
                    <div class="invite-popup-loading">
                        <div class="invite-popup-spinner"></div>
                        <p>Generating QR Code...</p>
                    </div>
                </div>
            </div>
            
            <div class="invite-popup-share-section">
                <div class="invite-popup-link-container">
                    <input 
                        type="text" 
                        id="invite-popup-share-link" 
                        class="invite-popup-share-input" 
                        readonly
                        placeholder="Generating invite link..."
                    >
                    <button id="invite-popup-copy-btn" class="invite-popup-copy-btn" disabled>
                        <svg class="invite-popup-copy-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                            <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"></path>
                        </svg>
                        Copy Link
                    </button>
                </div>
                <div id="invite-popup-copy-feedback" class="invite-popup-copy-feedback"></div>
            </div>
        </div>
    </div>
</div>

