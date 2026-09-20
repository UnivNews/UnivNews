{{-- Custom Alert Dialog Component (Based on shadcn/ui Alert-Dialog Pattern) --}}
{{-- Themed with UnivNews Crimson (#b71032) & Deep Navy (#00081e) --}}
<div id="global-alert-dialog"
     role="alertdialog"
     aria-modal="true"
     aria-labelledby="alert-dialog-title"
     aria-describedby="alert-dialog-description"
     class="fixed inset-0 z-[999998] flex items-center justify-center p-4 transition-all duration-200 ease-out select-none opacity-0 pointer-events-none"
     style="display: none;">
    
    <!-- Backdrop with frosted blur and website dark navy tone -->
    <div id="alert-dialog-backdrop"
         class="fixed inset-0 bg-[#00081E]/60 backdrop-blur-sm transition-opacity duration-200"></div>

    <!-- Dialog Content Container (size="sm" / max-w-md) -->
    <div id="alert-dialog-content"
         class="relative w-full max-w-md rounded-[20px] sm:rounded-[24px] bg-white p-6 sm:p-7 shadow-2xl border border-gray-100 dark:border-gray-800 transition-all duration-200 transform scale-95 opacity-0 z-10">
        
        <!-- Header -->
        <div class="flex flex-col items-start">
            <!-- Media Badge (Icon container) with destructive / theme crimson style -->
            <div id="alert-dialog-media"
                 class="flex h-12 w-12 items-center justify-center rounded-[16px] bg-crimson/10 text-crimson mb-4 border border-crimson/15 shadow-sm">
                <!-- Lucide Trash2Icon -->
                <svg id="alert-dialog-icon-trash" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-[2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18"/>
                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                    <line x1="10" x2="10" y1="11" y2="17"/>
                    <line x1="14" x2="14" y1="11" y2="17"/>
                </svg>
                <!-- Alert Triangle Icon for Warning Variant -->
                <svg id="alert-dialog-icon-warning" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-[2] hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </div>

            <!-- Title -->
            <h2 id="alert-dialog-title" class="font-heading text-lg sm:text-xl font-bold text-[#00081E] tracking-tight">
                Delete item?
            </h2>

            <!-- Description -->
            <p id="alert-dialog-description" class="mt-2 font-sans text-sm text-gray-600 leading-relaxed">
                This action cannot be undone. Are you sure you want to proceed?
            </p>
        </div>

        <!-- Footer -->
        <div class="mt-6 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2.5">
            <!-- Cancel Button (Ghost / Neutral) -->
            <button type="button"
                    id="alert-dialog-cancel"
                    class="w-full sm:w-auto px-4 py-2.5 rounded-[12px] border border-gray-200 text-sm font-semibold font-sans text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-200">
                Cancel
            </button>
            <!-- Action Button (Destructive / Website Crimson) -->
            <button type="button"
                    id="alert-dialog-action"
                    class="w-full sm:w-auto px-5 py-2.5 rounded-[12px] bg-crimson hover:bg-red-800 text-white text-sm font-semibold font-sans shadow-md shadow-crimson/25 transition-all focus:outline-none focus:ring-2 focus:ring-crimson/40 active:scale-[0.98] flex items-center justify-center gap-2">
                <span id="alert-dialog-action-text">Delete</span>
            </button>
        </div>
    </div>
</div>

<script>
(function() {
    const dialogEl = document.getElementById('global-alert-dialog');
    const contentEl = document.getElementById('alert-dialog-content');
    const backdropEl = document.getElementById('alert-dialog-backdrop');
    const titleEl = document.getElementById('alert-dialog-title');
    const descEl = document.getElementById('alert-dialog-description');
    const cancelBtn = document.getElementById('alert-dialog-cancel');
    const actionBtn = document.getElementById('alert-dialog-action');
    const actionTextEl = document.getElementById('alert-dialog-action-text');
    const mediaEl = document.getElementById('alert-dialog-media');
    const trashIcon = document.getElementById('alert-dialog-icon-trash');
    const warningIcon = document.getElementById('alert-dialog-icon-warning');

    let currentResolver = null;
    let isOpen = false;

    // Show Alert Dialog Function (Returns Promise<boolean>)
    window.showAlertDialog = function(options) {
        if (!dialogEl || !contentEl) return Promise.resolve(false);

        const opts = options || {};
        const title = opts.title || 'Delete item?';
        const description = opts.description || 'This will permanently delete this item. This action cannot be undone.';
        const confirmText = opts.confirmText || 'Delete';
        const cancelText = opts.cancelText || 'Cancel';
        const variant = opts.variant || 'destructive'; // 'destructive' | 'warning' | 'primary'
        const icon = opts.icon || (variant === 'warning' ? 'warning' : 'trash');

        // Populate Content
        if (titleEl) titleEl.textContent = title;
        if (descEl) descEl.innerHTML = description;
        if (cancelBtn) cancelBtn.textContent = cancelText;
        if (actionTextEl) actionTextEl.textContent = confirmText;

        // Configure Variant / Styling
        if (mediaEl) {
            if (variant === 'warning') {
                mediaEl.className = 'flex h-12 w-12 items-center justify-center rounded-2xl rounded-[16px] bg-amber-50 text-amber-600 mb-4 border border-amber-200 shadow-sm';
                if (actionBtn) actionBtn.className = 'w-full sm:w-auto px-5 py-2.5 rounded-xl rounded-[12px] bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold font-sans shadow-md shadow-amber-600/25 transition-all focus:outline-none focus:ring-2 focus:ring-amber-500/40 active:scale-[0.98] flex items-center justify-center gap-2';
            } else if (variant === 'primary') {
                mediaEl.className = 'flex h-12 w-12 items-center justify-center rounded-2xl rounded-[16px] bg-navy/10 text-navy mb-4 border border-navy/15 shadow-sm';
                if (actionBtn) actionBtn.className = 'w-full sm:w-auto px-5 py-2.5 rounded-xl rounded-[12px] bg-navy hover:bg-[#152238] text-white text-sm font-semibold font-sans shadow-md shadow-navy/25 transition-all focus:outline-none focus:ring-2 focus:ring-navy/40 active:scale-[0.98] flex items-center justify-center gap-2';
            } else {
                // Destructive (UnivNews Crimson)
                mediaEl.className = 'flex h-12 w-12 items-center justify-center rounded-2xl rounded-[16px] bg-crimson/10 text-crimson mb-4 border border-crimson/15 shadow-sm';
                if (actionBtn) actionBtn.className = 'w-full sm:w-auto px-5 py-2.5 rounded-xl rounded-[12px] bg-crimson hover:bg-red-800 text-white text-sm font-semibold font-sans shadow-md shadow-crimson/25 transition-all focus:outline-none focus:ring-2 focus:ring-crimson/40 active:scale-[0.98] flex items-center justify-center gap-2';
            }
        }

        // Toggle Icons
        if (icon === 'warning') {
            if (trashIcon) trashIcon.classList.add('hidden');
            if (warningIcon) warningIcon.classList.remove('hidden');
        } else {
            if (trashIcon) trashIcon.classList.remove('hidden');
            if (warningIcon) warningIcon.classList.add('hidden');
        }

        // Return Promise
        return new Promise(function(resolve) {
            currentResolver = resolve;

            // Display Dialog
            dialogEl.style.display = 'flex';
            void dialogEl.offsetWidth; // Force reflow

            dialogEl.classList.remove('opacity-0', 'pointer-events-none');
            dialogEl.classList.add('opacity-100');

            contentEl.classList.remove('scale-95', 'opacity-0');
            contentEl.classList.add('scale-100', 'opacity-100');

            isOpen = true;

            // Auto-focus cancel button for safe keyboard UX
            setTimeout(function() {
                if (cancelBtn) cancelBtn.focus();
            }, 50);
        });
    };

    // Close Dialog Helper
    function closeDialog(result) {
        if (!isOpen) return;
        isOpen = false;

        if (contentEl) {
            contentEl.classList.remove('scale-100', 'opacity-100');
            contentEl.classList.add('scale-95', 'opacity-0');
        }

        if (dialogEl) {
            dialogEl.classList.remove('opacity-100');
            dialogEl.classList.add('opacity-0', 'pointer-events-none');
        }

        setTimeout(function() {
            if (!isOpen && dialogEl) {
                dialogEl.style.display = 'none';
            }
            if (currentResolver) {
                currentResolver(result);
                currentResolver = null;
            }
        }, 200);
    }

    // Event Handlers
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            closeDialog(false);
        });
    }

    if (actionBtn) {
        actionBtn.addEventListener('click', function() {
            closeDialog(true);
        });
    }

    if (backdropEl) {
        backdropEl.addEventListener('click', function() {
            closeDialog(false);
        });
    }

    // Keyboard navigation (Escape key to cancel, Enter to confirm if focus not on Cancel)
    window.addEventListener('keydown', function(e) {
        if (!isOpen) return;
        if (e.key === 'Escape') {
            e.preventDefault();
            closeDialog(false);
        }
    });

    // Test query parameter bypass: ?test_alert_dialog=1
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('test_alert_dialog') === '1') {
        window.showAlertDialog({
            title: 'Delete chat?',
            description: 'This will permanently delete this chat conversation. View <a href="#" class="underline font-semibold text-crimson">Settings</a> to delete any memories saved during this chat.',
            confirmText: 'Delete',
            cancelText: 'Cancel'
        });
    }

    // Global Form Interceptor (Capture Phase)
    // Automatically catches delete forms and forms with data-confirm
    document.addEventListener('submit', function(e) {
        const form = e.target;
        if (!form) return;

        // Skip if explicitly confirmed by our dialog
        if (form.dataset.dialogConfirmed === 'true') {
            delete form.dataset.dialogConfirmed;
            return;
        }

        // Check if form is a DELETE form or has confirm attribute
        const isDeleteMethod = form.querySelector('input[name="_method"][value="DELETE"]') !== null;
        const hasConfirmAttr = form.hasAttribute('data-confirm') || form.hasAttribute('data-confirm-title');

        if (isDeleteMethod || hasConfirmAttr) {
            // Cancel native submit & native confirm dialog
            e.preventDefault();
            e.stopImmediatePropagation();

            const title = form.getAttribute('data-confirm-title') || form.getAttribute('data-confirm') || 'Delete item?';
            const description = form.getAttribute('data-confirm-description') || 
                'This will permanently delete this item. This action cannot be undone.';
            const confirmBtnText = form.getAttribute('data-confirm-btn') || 'Delete';
            const variant = form.getAttribute('data-confirm-variant') || 'destructive';

            window.showAlertDialog({
                title: title,
                description: description,
                confirmText: confirmBtnText,
                cancelText: 'Cancel',
                variant: variant,
                icon: variant === 'warning' ? 'warning' : 'trash'
            }).then(function(confirmed) {
                if (confirmed) {
                    form.dataset.dialogConfirmed = 'true';
                    // Trigger loader if present
                    if (window.showPageLoader) {
                        window.showPageLoader('Deleting...');
                    }
                    form.submit();
                }
            });
        }
    }, true);
})();
</script>
