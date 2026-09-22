/* Okie Heating & Cooling — site JS (vanilla, no dependencies) */
(function () {
  'use strict';
  document.documentElement.classList.remove('no-js');

  /* ---------- Sticky header shadow ---------- */
  var header = document.getElementById('site-header');
  if (header) {
    var onScroll = function () { header.classList.toggle('is-scrolled', window.scrollY > 20); };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ---------- Desktop dropdown (keyboard + hover) ---------- */
  document.querySelectorAll('.nav-item.has-dropdown').forEach(function (item) {
    var trigger = item.querySelector('.nav-link');
    var menu = item.querySelector('.dropdown');
    var open = function () { item.classList.add('is-open'); trigger.setAttribute('aria-expanded', 'true'); };
    var close = function () { item.classList.remove('is-open'); trigger.setAttribute('aria-expanded', 'false'); };
    item.addEventListener('mouseenter', open);
    item.addEventListener('mouseleave', close);
    item.addEventListener('focusin', open);
    item.addEventListener('focusout', function (e) { if (!item.contains(e.relatedTarget)) close(); });
    trigger.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowDown' || e.key === ' ') { e.preventDefault(); open(); var f = menu.querySelector('a'); if (f) f.focus(); }
      if (e.key === 'Escape') { e.preventDefault(); close(); }
    });
    menu.addEventListener('keydown', function (e) { if (e.key === 'Escape') { e.preventDefault(); close(); trigger.focus(); } });
  });

  /* ---------- Mobile menu ---------- */
  var menuBtn = document.getElementById('mobile-menu-btn');
  var menuEl = document.getElementById('mobile-menu');
  var backdrop = document.getElementById('mobile-menu-backdrop');
  var closeBtn = document.getElementById('mobile-menu-close');
  function setMenu(openState) {
    if (!menuEl) return;
    menuEl.classList.toggle('is-open', openState);
    menuEl.setAttribute('aria-hidden', openState ? 'false' : 'true');
    if (backdrop) backdrop.hidden = !openState;
    if (menuBtn) menuBtn.setAttribute('aria-expanded', openState ? 'true' : 'false');
    document.body.classList.toggle('menu-open', openState);
    if (openState) { var first = menuEl.querySelector('a, button'); if (first) first.focus(); }
    else if (menuBtn) menuBtn.focus();
  }
  if (menuBtn) menuBtn.addEventListener('click', function () { setMenu(true); });
  if (closeBtn) closeBtn.addEventListener('click', function () { setMenu(false); });
  if (backdrop) backdrop.addEventListener('click', function () { setMenu(false); });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && menuEl && menuEl.classList.contains('is-open')) setMenu(false); });

  /* ---------- Accordion ---------- */
  document.querySelectorAll('[data-accordion]').forEach(function (acc) {
    var triggers = acc.querySelectorAll('.accordion-trigger');
    triggers.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var expanded = btn.getAttribute('aria-expanded') === 'true';
        triggers.forEach(function (b) {
          b.setAttribute('aria-expanded', 'false');
          var p = document.getElementById(b.getAttribute('aria-controls'));
          if (p) p.hidden = true;
        });
        if (!expanded) {
          btn.setAttribute('aria-expanded', 'true');
          var panel = document.getElementById(btn.getAttribute('aria-controls'));
          if (panel) panel.hidden = false;
        }
      });
    });
  });

  /* ---------- Scroll reveal ---------- */
  /* Hero reveals animate in pure CSS, so the observer only handles what is below the fold. */
  var reveals = Array.prototype.filter.call(
    document.querySelectorAll('.reveal'),
    function (el) { return !el.closest('.hero'); }
  );
  if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) { if (en.isIntersecting) { en.target.classList.add('is-visible'); io.unobserve(en.target); } });
    }, { rootMargin: '0px 0px -60px 0px', threshold: 0.05 });
    reveals.forEach(function (el) { io.observe(el); });
  } else {
    reveals.forEach(function (el) { el.classList.add('is-visible'); });
  }

  /* ---------- Forms (AJAX with graceful fallback) ---------- */
  document.querySelectorAll('[data-request-form]').forEach(function (form) {
    var btn = form.querySelector('[data-submit-btn]');
    var label = form.querySelector('[data-submit-label]');
    var spinner = form.querySelector('.btn-spinner');
    var arrow = form.querySelector('.btn-arrow');
    var errBox = form.querySelector('[data-form-error]');
    var tpl = form.parentElement.querySelector('[data-success-template]');

    function showError(msg) {
      if (!errBox) return;
      errBox.textContent = msg;
      errBox.hidden = false;
      errBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    function setLoading(on) {
      if (btn) btn.disabled = on;
      if (label) label.textContent = on ? 'Submitting...' : (label.dataset.orig || label.textContent);
      if (spinner) spinner.hidden = !on;
      if (arrow) arrow.hidden = on;
    }
    if (label) label.dataset.orig = label.textContent;

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (errBox) errBox.hidden = true;

      // Native validation (form has novalidate so we can style it)
      var invalid = form.querySelector(':invalid');
      form.querySelectorAll('[aria-invalid]').forEach(function (el) { el.removeAttribute('aria-invalid'); });
      if (invalid) {
        invalid.setAttribute('aria-invalid', 'true');
        invalid.focus();
        showError(invalid.validationMessage || 'Please complete the required fields.');
        return;
      }

      setLoading(true);
      var fd = new FormData(form);
      fetch(form.action, {
        method: 'POST',
        body: fd,
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'fetch' },
        credentials: 'same-origin'
      }).then(function (r) { return r.json().catch(function () { return { success: r.ok, message: r.ok ? '' : 'Please try again in a moment.' }; }); })
        .then(function (data) {
          if (data && data.success) {
            if (window.gtag) { try { gtag('event', 'generate_lead', { form_source: fd.get('form_source') || '', service_type: fd.get('service_type') || '' }); } catch (e) {} }
            track('service_request_submitted', { form_source: fd.get('form_source') || '', service_type: fd.get('service_type') || '', properties: { urgency: fd.get('urgency') || '' } });
            if (tpl) {
              var node = tpl.content.cloneNode(true);
              form.replaceWith(node);
              tpl.remove();
            } else {
              form.innerHTML = '<div class="form-success"><h3 class="h3">Request Submitted!</h3><p class="muted">' + (form.dataset.successMessage || 'Thank you! We will contact you shortly.') + '</p></div>';
            }
          } else {
            setLoading(false);
            if (data && data.errors) {
              var firstKey = Object.keys(data.errors)[0];
              var field = form.querySelector('[name="' + firstKey + '"]');
              if (field) { field.setAttribute('aria-invalid', 'true'); field.focus(); }
            }
            showError((data && data.message) || 'Couldn’t submit request. Please try again in a moment.');
          }
        })
        .catch(function () {
          setLoading(false);
          showError('Network error. Please try again or call us directly.');
        });
    });
  });

  /* ---------- Telemetry (page views) ---------- */
  function uid() {
    if (window.crypto && crypto.randomUUID) return crypto.randomUUID();
    return Date.now().toString(36) + '-' + Math.random().toString(36).slice(2, 10);
  }
  function getId(store, key) {
    try { var v = store.getItem(key); if (v) return v; v = uid(); store.setItem(key, v); return v; } catch (e) { return uid(); }
  }
  function track(eventName, extra) {
    try {
      var q = new URLSearchParams(location.search);
      var payload = Object.assign({
        event_name: eventName,
        path: location.pathname,
        referrer: document.referrer || '',
        visitor_id: getId(localStorage, 'okie_visitor_id'),
        session_id: getId(sessionStorage, 'okie_session_id'),
        utm_source: q.get('utm_source') || '',
        utm_medium: q.get('utm_medium') || '',
        utm_campaign: q.get('utm_campaign') || ''
      }, extra || {});
      var body = JSON.stringify(payload);
      if (navigator.sendBeacon) {
        navigator.sendBeacon('/api/track', new Blob([body], { type: 'application/json' }));
      } else {
        fetch('/api/track', { method: 'POST', body: body, headers: { 'Content-Type': 'application/json' }, keepalive: true }).catch(function () {});
      }
    } catch (e) { /* never block UX */ }
  }
  if ('requestIdleCallback' in window) requestIdleCallback(function () { track('page_view'); }, { timeout: 4000 });
  else setTimeout(function () { track('page_view'); }, 1200);
})();
