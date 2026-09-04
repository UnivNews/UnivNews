import { driver } from 'driver.js';
import 'driver.js/dist/driver.css';

// ── Shared Driver config ────────────────────────────────────────────────────

const DRIVER_CONFIG = {
  showProgress: true,
  animate: true,
  smoothScroll: true,
  overlayOpacity: 0.65,
  popoverClass: 'univnews-tour-popover',
  nextBtnText: 'Lanjut →',
  prevBtnText: '← Kembali',
  doneBtnText: 'Selesai ✓',
};

let activeDriver = null;

// ── Utility ─────────────────────────────────────────────────────────────────

/**
 * Filter steps: skip steps whose CSS selector does not match any DOM element.
 */
function filterAvailableSteps(steps) {
  return steps.filter(step => {
    if (!step.element) return true; // popover without anchor — always show
    try {
      return document.querySelector(step.element) !== null;
    } catch (_) {
      return false;
    }
  });
}

/**
 * Build POST body and call the onboarding complete endpoint.
 */
function sendComplete(status = 'completed', pageTourId = null) {
  const isAdminRoute = window.location.pathname.startsWith('/admin');
  const endpoint = isAdminRoute ? '/admin/onboarding/complete' : '/onboarding/complete';
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

  if (!csrfToken) {
    console.warn('[Onboarding] No CSRF token found.');
    return;
  }

  const body = { status };
  if (pageTourId) body.page = pageTourId;

  fetch(endpoint, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken,
    },
    body: JSON.stringify(body),
  }).catch(err => console.error('[Onboarding] Failed to mark complete:', err));
}

// Global dismiss function for the 'Always Ignore' and 'Dismiss for now' buttons
window.dismissAllTours = function(mode = 'session', tourId = null) {
  const role = document.body.dataset.userRole || 'default';
  const storageKey = `univnews_ignore_tours_${role}`;

  if (mode === 'permanent') {
    localStorage.setItem(storageKey, 'true');
    // Mark both dashboard and page tours complete on backend
    sendComplete('completed');
    if (tourId) sendComplete('completed', tourId);
  } else {
    sessionStorage.setItem(storageKey, 'true');
  }

  if (activeDriver) {
    activeDriver.destroy();
    activeDriver = null;
  }
};

function showHelpPrompt(tourId = null) {
  const role = document.body.dataset.userRole || 'default';
  const storageKey = `univnews_ignore_tours_${role}`;

  // Check if ignored permanently or for this session
  if (localStorage.getItem(storageKey) === 'true' || sessionStorage.getItem(storageKey) === 'true') {
     if (tourId && localStorage.getItem(storageKey) === 'true') {
         sendComplete('completed', tourId);
     }
     return;
  }

  if (activeDriver) {
    activeDriver.destroy();
  }

  activeDriver = driver({
    ...DRIVER_CONFIG,
    showProgress: false,
    doneBtnText: 'Tutup ✕',
    steps: [
      {
        element: '[data-tour="help-button"]',
        popover: {
          title: '💡 Tips Panduan',
          description: `Klik tombol bantuan ini kapan saja untuk melihat tutorial interaktif halaman ini.<br><br>
            <div style="display:flex; gap:12px; margin-top:12px; font-size:12px;">
              <a href="#" onclick="window.dismissAllTours('session', '${tourId || ''}'); return false;" style="color:#6b7280; text-decoration:underline;">Tutup sementara</a>
              <a href="#" onclick="window.dismissAllTours('permanent', '${tourId || ''}'); return false;" style="color:#ef4444; font-decoration:underline; font-weight:600;">Jangan tampilkan lagi</a>
            </div>`,
          side: 'bottom',
          align: 'end',
        }
      }
    ],
    onDestroyed: () => {
      activeDriver = null;
    }
  });

  setTimeout(() => {
    if (activeDriver) activeDriver.drive();
  }, 600);
}

// ── Dashboard Tour ───────────────────────────────────────────────────────────

function initOnboarding(steps) {
  const pending = document.body.dataset.onboardingPending === 'true';
  if (!pending) return;

  showHelpPrompt(null);
}

// ── Per-Page Tour ────────────────────────────────────────────────────────────

function initPageTour(tourId, steps) {
  if (!tourId) return;

  let completedTours = [];
  try {
    completedTours = JSON.parse(document.body.dataset.completedTours || '[]');
  } catch (_) {
    completedTours = [];
  }

  if (completedTours.includes(tourId)) return;

  showHelpPrompt(tourId);
}

// ── Manual Replay ────────────────────────────────────────────────────────────

function replayOnboarding(steps) {
  if (activeDriver) {
    activeDriver.destroy();
  }

  const filtered = filterAvailableSteps(steps);
  if (filtered.length === 0) {
    alert('Tutorial tidak tersedia untuk halaman ini.');
    return;
  }

  activeDriver = driver({
    ...DRIVER_CONFIG,
    steps: filtered,
    onDestroyed: () => {
      activeDriver = null;
    }
  });
  
  activeDriver.drive();
}

export { initOnboarding, initPageTour, replayOnboarding, filterAvailableSteps };
