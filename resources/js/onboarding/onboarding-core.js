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

// ── Utility ─────────────────────────────────────────────────────────────────

/**
 * Filter steps: skip steps whose CSS selector does not match any DOM element.
 * Spec: tour defensif terhadap elemen yang tidak ada.
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
 * Detects admin vs web route from pathname.
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

// ── Dashboard Tour ───────────────────────────────────────────────────────────

/**
 * Initialize the DASHBOARD onboarding tour.
 * Only runs if body `data-onboarding-pending="true"`.
 */
function initOnboarding(steps) {
  const pending = document.body.dataset.onboardingPending === 'true';
  if (!pending) return;

  const filtered = filterAvailableSteps(steps);
  if (filtered.length === 0) {
    sendComplete('completed');
    return;
  }

  const driverObj = driver({
    ...DRIVER_CONFIG,
    steps: filtered,
    onDestroyed: () => sendComplete('completed'),
  });

  setTimeout(() => driverObj.drive(), 600);
}

// ── Per-Page Tour ────────────────────────────────────────────────────────────

/**
 * Initialize a PER-PAGE onboarding tour.
 *
 * Tour fires automatically if `tourId` is NOT yet in the user's
 * `data-completed-tours` list (passed from Blade via body attribute).
 *
 * @param {string}  tourId  Unique page tour identifier (e.g. 'author.articles.create')
 * @param {Array}   steps   Driver.js step definitions
 */
function initPageTour(tourId, steps) {
  if (!tourId) return;

  // Read completed tours list from body data attribute (set by cms.blade.php)
  let completedTours = [];
  try {
    completedTours = JSON.parse(document.body.dataset.completedTours || '[]');
  } catch (_) {
    completedTours = [];
  }

  const alreadyDone = completedTours.includes(tourId);
  if (alreadyDone) return;

  const filtered = filterAvailableSteps(steps);
  if (filtered.length === 0) {
    sendComplete('completed', tourId);
    return;
  }

  const driverObj = driver({
    ...DRIVER_CONFIG,
    steps: filtered,
    onDestroyed: () => sendComplete('completed', tourId),
  });

  setTimeout(() => driverObj.drive(), 600);
}

// ── Manual Replay ────────────────────────────────────────────────────────────

/**
 * Manually replay any tour (dashboard or page).
 * Does NOT update the completion flag.
 *
 * @param {Array} steps
 */
function replayOnboarding(steps) {
  const filtered = filterAvailableSteps(steps);
  if (filtered.length === 0) {
    alert('Tutorial tidak tersedia untuk halaman ini.');
    return;
  }

  const driverObj = driver({ ...DRIVER_CONFIG, steps: filtered });
  driverObj.drive();
}

export { initOnboarding, initPageTour, replayOnboarding, filterAvailableSteps };
