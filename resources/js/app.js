import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// ── Onboarding Walkthrough (Driver.js) ─────────────────────────────────────
// Covers ALL CMS pages for author & admin roles.
// Dashboard tour: uses has_completed_onboarding flag (data-onboarding-pending).
// Per-page tours: uses completed_page_tours array (data-completed-tours + data-page-tour-id).

import { initOnboarding, initPageTour, replayOnboarding } from './onboarding/onboarding-core';

// Dashboard tours
import { authorSteps }      from './onboarding/onboarding-author';
import { adminSteps }       from './onboarding/onboarding-admin';

// Per-page tours — Author
import { authorArticlesIndexSteps }  from './onboarding/pages/author-articles-index';
import { authorArticlesCreateSteps } from './onboarding/pages/author-articles-create';
import { authorArticlesEditSteps }   from './onboarding/pages/author-articles-edit';
import { authorArticlesBoostSteps }  from './onboarding/pages/author-articles-boost';
import { authorSettingsSteps }       from './onboarding/pages/author-settings';

// Per-page tours — Admin
import { adminArticlesIndexSteps }       from './onboarding/pages/admin-articles-index';
import { adminArticlesCreateSteps }      from './onboarding/pages/admin-articles-create';
import { adminArticlesReviewSteps }      from './onboarding/pages/admin-articles-review';
import { adminAuthorsIndexSteps }        from './onboarding/pages/admin-authors-index';
import { adminUniversitiesIndexSteps }   from './onboarding/pages/admin-universities-index';
import { adminAppSettingsSteps }         from './onboarding/pages/admin-app-settings';
import { adminSettingsSteps }            from './onboarding/pages/admin-settings';

// Map: page tour ID → steps array
const PAGE_TOUR_MAP = {
  // Author pages
  'author.articles.index':  authorArticlesIndexSteps,
  'author.articles.create': authorArticlesCreateSteps,
  'author.articles.edit':   authorArticlesEditSteps,
  'author.articles.boost':  authorArticlesBoostSteps,
  'author.settings':        authorSettingsSteps,

  // Admin pages
  'admin.articles.index':       adminArticlesIndexSteps,
  'admin.articles.create':      adminArticlesCreateSteps,
  'admin.articles.review':      adminArticlesReviewSteps,
  'admin.authors.index':        adminAuthorsIndexSteps,
  'admin.universities.index':   adminUniversitiesIndexSteps,
  'admin.app-settings.index':   adminAppSettingsSteps,
  'admin.settings':             adminSettingsSteps,
};

document.addEventListener('DOMContentLoaded', () => {
  const body       = document.body;
  const role       = body.dataset.userRole;       // 'author' | 'admin' | ''
  const pageTourId = body.dataset.pageTourId;     // e.g. 'author.articles.create' | ''

  // ── 1. Dashboard tour (only on dashboard pages) ──────────────────────────
  let dashboardSteps = null;
  if (role === 'author')      dashboardSteps = authorSteps;
  else if (role === 'admin')  dashboardSteps = adminSteps;

  if (dashboardSteps) {
    initOnboarding(dashboardSteps);
  }

  // ── 2. Per-page tour ────────────────────────────────────────────────────
  const currentPageSteps = pageTourId ? PAGE_TOUR_MAP[pageTourId] : null;

  if (pageTourId && currentPageSteps) {
    initPageTour(pageTourId, currentPageSteps);
  }

  // ── 3. Expose replay globally for help button & settings buttons ─────────
  // Replay current page tour if on a known page, otherwise replay dashboard tour.
  window.replayOnboarding = () => {
    const stepsToReplay = currentPageSteps || dashboardSteps;
    if (stepsToReplay) {
      replayOnboarding(stepsToReplay);
    }
  };
});
