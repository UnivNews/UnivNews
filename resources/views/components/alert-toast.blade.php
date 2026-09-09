{{-- Global Alert Toast Notification Manager (ReUI Style) --}}
<div id="reui-alert-container"
     x-data="reuiAlertToastManager()"
     @reui-notify-alert.window="addAlert($event.detail)"
     class="fixed top-5 right-5 sm:right-6 z-[99999] max-w-[420px] w-[calc(100%-2.5rem)] flex flex-col gap-3 pointer-events-none"
     aria-live="assertive">
    
    <template x-for="item in alerts" :key="item.id">
        <div x-show="item.visible"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 -translate-y-2 sm:translate-x-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 -translate-y-2 sm:translate-x-8 scale-95"
             @mouseenter="pauseTimer(item)"
             @mouseleave="resumeTimer(item)"
             :class="getContainerClasses(item.variant)"
             class="pointer-events-auto relative w-full rounded-[12px] p-4 transition-all duration-200 select-none"
             role="alert">
            
            <div class="flex items-start gap-3">
                {{-- Left Icon --}}
                <div class="flex-shrink-0 mt-0.5" :class="getIconColor(item.variant)">
                    {{-- Info: Lucide CircleAlert --}}
                    <template x-if="item.variant === 'info'">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                    </template>

                    {{-- Success: Lucide CircleCheck --}}
                    <template x-if="item.variant === 'success'">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="m9 12 2 2 4-4" />
                        </svg>
                    </template>

                    {{-- Warning: Lucide TriangleAlert --}}
                    <template x-if="item.variant === 'warning'">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                            <line x1="12" y1="9" x2="12" y2="13" />
                            <line x1="12" y1="17" x2="12.01" y2="17" />
                        </svg>
                    </template>

                    {{-- Error/Destructive: Lucide CircleX --}}
                    <template x-if="item.variant === 'error' || item.variant === 'destructive'">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="m15 9-6 6" />
                            <path d="m9 9 6 6" />
                        </svg>
                    </template>
                </div>

                {{-- Content --}}
                <div class="flex-1 min-w-0 pr-1">
                    <template x-if="item.title">
                        <h5 class="font-heading font-semibold text-sm leading-snug tracking-normal text-white" x-text="item.title"></h5>
                    </template>
                    <div class="font-sans text-xs md:text-sm leading-relaxed mt-0.5 text-[#9ca3af]" x-text="item.message"></div>
                </div>

                {{-- Close Button --}}
                <button type="button"
                        @click="removeAlert(item.id)"
                        class="flex-shrink-0 -mr-1 -mt-1 p-1 text-gray-400 hover:text-white transition-colors rounded hover:bg-white/10 cursor-pointer"
                        aria-label="Close alert">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </template>
</div>

<script>
(function() {
    function reuiAlertToastManager() {
        return {
            alerts: [],
            _lastDispatched: 0,
            _lastContent: '',
            addAlert(options) {
                if (!options) return;

                const title = options.title || '';
                const message = options.message || '';
                const contentKey = title + '::' + message;
                const now = Date.now();

                // Prevent duplicate alerts triggered within 400ms (e.g. double event/double click)
                if (this._lastContent === contentKey && (now - this._lastDispatched < 400)) {
                    return;
                }
                this._lastDispatched = now;
                this._lastContent = contentKey;

                const id = now + Math.random().toString(36).substr(2, 5);
                const alertItem = {
                    id: id,
                    title: title,
                    message: message,
                    variant: options.variant || 'info',
                    duration: options.duration !== undefined ? options.duration : 4500,
                    visible: true,
                    remainingTime: options.duration !== undefined ? options.duration : 4500,
                    timer: null,
                    startTime: now
                };

                this.alerts.push(alertItem);

                if (alertItem.duration > 0) {
                    alertItem.timer = setTimeout(() => {
                        this.removeAlert(id);
                    }, alertItem.duration);
                }
            },
            removeAlert(id) {
                const index = this.alerts.findIndex(a => a.id === id);
                if (index !== -1) {
                    this.alerts[index].visible = false;
                    setTimeout(() => {
                        this.alerts = this.alerts.filter(a => a.id !== id);
                    }, 220);
                }
            },
            pauseTimer(item) {
                if (item.timer) {
                    clearTimeout(item.timer);
                    item.timer = null;
                    item.remainingTime -= (Date.now() - item.startTime);
                }
            },
            resumeTimer(item) {
                if (item.duration > 0 && !item.timer) {
                    item.startTime = Date.now();
                    item.timer = setTimeout(() => {
                        this.removeAlert(item.id);
                    }, Math.max(item.remainingTime, 1000));
                }
            },
            getContainerClasses(variant) {
                switch(variant) {
                    case 'success':
                        return 'bg-[#09140e] border border-[#22c55e]/35 text-white shadow-[0_12px_32px_rgba(0,0,0,0.6),0_0_18px_rgba(34,197,94,0.18)]';
                    case 'warning':
                        return 'bg-[#141009] border border-[#f59e0b]/35 text-white shadow-[0_12px_32px_rgba(0,0,0,0.6),0_0_18px_rgba(245,158,11,0.18)]';
                    case 'error':
                    case 'destructive':
                        return 'bg-[#160a0a] border border-[#ef4444]/35 text-white shadow-[0_12px_32px_rgba(0,0,0,0.6),0_0_18px_rgba(239,68,68,0.18)]';
                    case 'info':
                    default:
                        return 'bg-[#0b0d14] border border-[#a855f7]/40 text-white shadow-[0_12px_32px_rgba(0,0,0,0.6),0_0_20px_rgba(168,85,247,0.2)]';
                }
            },
            getIconColor(variant) {
                switch(variant) {
                    case 'success': return 'text-[#22c55e]';
                    case 'warning': return 'text-[#f59e0b]';
                    case 'error':
                    case 'destructive': return 'text-[#ef4444]';
                    case 'info':
                    default: return 'text-[#a855f7]';
                }
            }
        };
    }

    // Expose Alpine component constructor
    window.reuiAlertToastManager = reuiAlertToastManager;

    // Expose Global Helper Methods
    window.showAlert = function(options) {
        if (typeof options === 'string') {
            options = { message: options, variant: 'info' };
        }
        window.dispatchEvent(new CustomEvent('reui-notify-alert', { detail: options }));
    };

    window.showInfoAlert = function(title, message, duration) {
        window.showAlert({
            title: title || 'Info! Something important',
            message: message || '',
            variant: 'info',
            duration: duration !== undefined ? duration : 4500
        });
    };

    window.showSuccessAlert = function(title, message, duration) {
        window.showAlert({
            title: title || 'Success',
            message: message || '',
            variant: 'success',
            duration: duration !== undefined ? duration : 4500
        });
    };

    window.showWarningAlert = function(title, message, duration) {
        window.showAlert({
            title: title || 'Warning',
            message: message || '',
            variant: 'warning',
            duration: duration !== undefined ? duration : 5000
        });
    };

    window.showErrorAlert = function(title, message, duration) {
        window.showAlert({
            title: title || 'Error',
            message: message || '',
            variant: 'error',
            duration: duration !== undefined ? duration : 5000
        });
    };

    // Gracefully handle native browser alert fallback
    if (!window._nativeAlert) {
        window._nativeAlert = window.alert;
        window.alert = function(msg) {
            // If message corresponds to link coming soon or feature coming soon
            if (typeof msg === 'string') {
                const lower = msg.toLowerCase();
                if (lower.includes('link coming soon')) {
                    window.showInfoAlert('Info! Link coming soon', 'This link is currently being prepared and will be available soon.');
                    return;
                }
                if (lower.includes('coming soon')) {
                    window.showInfoAlert('Info! Feature coming soon', 'This feature is currently under development. Please check back later!');
                    return;
                }
            }
            window.showInfoAlert('Info! Notification', String(msg));
        };
    }
})();
</script>
