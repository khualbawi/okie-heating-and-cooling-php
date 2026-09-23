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

  /* ---------- Desktop dropdown / mega-menu (hover-intent + click + keyboard) ---------- */
  document.querySelectorAll('.nav-item.has-dropdown, .nav-item.has-megamenu').forEach(function (item) {
    var caret = item.querySelector('.nav-caret');
    var menu = item.querySelector('.dropdown, .megamenu');
    if (!caret || !menu) return;
    var hoverTimer = null;

    var open = function () {
      clearTimeout(hoverTimer);
      document.querySelectorAll('.nav-item.is-open').forEach(function (other) { if (other !== item) closeItem(other); });
      item.classList.add('is-open');
      caret.setAttribute('aria-expanded', 'true');
    };
    var close = function () { closeItem(item); };
    function closeItem(el) {
      var c = el.querySelector('.nav-caret');
      el.classList.remove('is-open');
      if (c) c.setAttribute('aria-expanded', 'false');
    }

    item.addEventListener('mouseenter', function () {
      clearTimeout(hoverTimer);
      hoverTimer = setTimeout(open, 150);
    });
    item.addEventListener('mouseleave', function () {
      clearTimeout(hoverTimer);
      hoverTimer = setTimeout(close, 150);
    });

    caret.addEventListener('click', function () {
      if (item.classList.contains('is-open')) close(); else open();
    });
    caret.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowDown' || e.key === ' ' || e.key === 'Enter') {
        e.preventDefault(); open();
        var f = menu.querySelector('a'); if (f) f.focus();
      }
      if (e.key === 'Escape') { e.preventDefault(); close(); }
    });

    item.addEventListener('focusout', function (e) {
      if (!item.contains(e.relatedTarget)) close();
    });
    menu.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') { e.preventDefault(); close(); caret.focus(); }
    });
  });
  document.addEventListener('click', function (e) {
    document.querySelectorAll('.nav-item.is-open').forEach(function (item) {
      if (!item.contains(e.target)) {
        item.classList.remove('is-open');
        var c = item.querySelector('.nav-caret');
        if (c) c.setAttribute('aria-expanded', 'false');
      }
    });
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

// Service Areas hub: ZIP checker, List/Map toggle, dot<->card hover sync.
(function () {
  var form = document.querySelector('[data-zip-form]');
  if (!form) return;

  var input = form.querySelector('[data-zip-input]');
  var resultBox = form.querySelector('[data-zip-result]');
  var dataEl = document.getElementById('zip-lookup-data');
  var zipMap = {};
  try { zipMap = dataEl ? JSON.parse(dataEl.textContent) : {}; } catch (e) { zipMap = {}; }
  var phoneHref = form.getAttribute('data-phone-href') || 'tel:';
  var phone = form.getAttribute('data-phone') || '';

  function setActiveCity(slug) {
    document.querySelectorAll('.is-active').forEach(function (el) {
      if (el.matches('[data-city]')) el.classList.remove('is-active');
    });
    if (!slug) return;
    document.querySelectorAll('[data-city="' + slug + '"]').forEach(function (el) {
      el.classList.add('is-active');
    });
  }

  function renderResult(zip) {
    var digits = zip.replace(/\D/g, '');
    if (digits.length !== 5) {
      resultBox.innerHTML = '<div class="zip-result-box zip-result-invalid">Enter a 5-digit ZIP code.</div>';
      resultBox.hidden = false;
      setActiveCity(null);
      return;
    }
    var match = zipMap[digits];
    if (match) {
      resultBox.innerHTML =
        '<div class="zip-result-box zip-result-match">' +
        '<p>&#10003; Yes, we serve ' + digits + ' (' + escapeHtml(match.name) + ')</p>' +
        '<div class="btn-row"><a href="/book?city=' + encodeURIComponent(match.slug) + '" class="btn btn-primary btn-sm">Book in ' + escapeHtml(match.name) + '</a>' +
        '<a href="' + escapeHtml(phoneHref) + '" class="btn btn-outline btn-sm">Call</a></div></div>';
      setActiveCity(match.slug);
    } else {
      resultBox.innerHTML =
        '<div class="zip-result-box zip-result-miss"><p>' + digits + ' is outside our usual area. Call and we\'ll see what we can do.</p>' +
        '<a href="' + escapeHtml(phoneHref) + '" class="btn btn-outline btn-sm">Call ' + escapeHtml(phone) + '</a></div>';
      setActiveCity(null);
    }
    resultBox.hidden = false;
  }

  function escapeHtml(s) {
    var d = document.createElement('div');
    d.textContent = s;
    return d.innerHTML;
  }

  if (input) {
    input.addEventListener('input', function () {
      input.value = input.value.replace(/\D/g, '').slice(0, 5);
      resultBox.hidden = true;
      resultBox.innerHTML = '';
      setActiveCity(null);
    });
  }

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    renderResult(input ? input.value : '');
  });

  // List / Map toggle (mobile) --------------------------------------------
  var tabs = document.querySelectorAll('[data-area-tab]');
  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      var target = tab.getAttribute('data-area-tab');
      tabs.forEach(function (t) {
        var active = t === tab;
        t.classList.toggle('is-active', active);
        t.setAttribute('aria-selected', active ? 'true' : 'false');
      });
      document.querySelectorAll('[data-area-panel]').forEach(function (panel) {
        panel.hidden = panel.getAttribute('data-area-panel') !== target;
      });
    });
  });

  // Dot <-> card/row hover sync (event delegation) -------------------------
  function setHover(slug, on) {
    if (!slug) return;
    document.querySelectorAll('[data-city="' + slug + '"]').forEach(function (el) {
      el.classList.toggle('is-hover', on);
    });
  }
  document.addEventListener('mouseover', function (e) {
    var el = e.target.closest('[data-city]');
    if (el) setHover(el.getAttribute('data-city'), true);
  });
  document.addEventListener('mouseout', function (e) {
    var el = e.target.closest('[data-city]');
    if (el) setHover(el.getAttribute('data-city'), false);
  });
  document.addEventListener('focusin', function (e) {
    var el = e.target.closest('[data-city]');
    if (el) setHover(el.getAttribute('data-city'), true);
  });
  document.addEventListener('focusout', function (e) {
    var el = e.target.closest('[data-city]');
    if (el) setHover(el.getAttribute('data-city'), false);
  });
})();
