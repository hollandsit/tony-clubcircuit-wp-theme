/**
 * Tony Club Circuit — front-end behaviour.
 * Dependency-free (no jQuery). Replaces Owl Carousel, the jQuery scrollbar
 * and the old toggle-menu script.
 *
 * @package tony-clubcircuit
 */
(function () {
	'use strict';

	var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	function ready(fn) {
		if (document.readyState !== 'loading') {
			fn();
		} else {
			document.addEventListener('DOMContentLoaded', fn);
		}
	}

	/* ------------------------------------------------------------------ */
	/* Slider                                                             */
	/* ------------------------------------------------------------------ */
	function arrowSvg(rotate) {
		return '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" ' +
			'stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"' +
			(rotate ? ' style="transform:rotate(180deg)"' : '') + '><path d="M9 6l6 6-6 6"/></svg>';
	}

	function Slider(root, options) {
		var opts = options || {};
		var breakpoints = opts.perView || { 0: 1 };
		var autoplay = !!opts.autoplay && !prefersReducedMotion;
		var interval = opts.interval || 5000;

		var slides = Array.prototype.filter.call(root.children, function (c) {
			return c.classList && c.classList.contains('item');
		});
		// Fallback: if no .item children, treat every element child as a slide.
		if (!slides.length) {
			slides = Array.prototype.filter.call(root.children, function (c) {
				return c.nodeType === 1;
			});
		}
		if (slides.length < 1) {
			return;
		}

		var index = 0;
		var perView = 1;
		var maxIndex = 0;
		var timer = null;

		// Build DOM scaffold.
		root.classList.add('cc-slider');
		var viewport = document.createElement('div');
		viewport.className = 'cc-slider__viewport';
		var track = document.createElement('div');
		track.className = 'cc-slider__track';
		viewport.appendChild(track);

		slides.forEach(function (slide) {
			track.appendChild(slide);
		});
		root.insertBefore(viewport, root.firstChild);

		// Controls.
		var prevBtn = document.createElement('button');
		prevBtn.type = 'button';
		prevBtn.className = 'cc-slider__btn cc-slider__btn--prev';
		prevBtn.setAttribute('aria-label', 'Previous slide');
		prevBtn.innerHTML = arrowSvg(true);

		var nextBtn = document.createElement('button');
		nextBtn.type = 'button';
		nextBtn.className = 'cc-slider__btn cc-slider__btn--next';
		nextBtn.setAttribute('aria-label', 'Next slide');
		nextBtn.innerHTML = arrowSvg(false);

		var dotsWrap = document.createElement('div');
		dotsWrap.className = 'cc-slider__dots';

		root.appendChild(prevBtn);
		root.appendChild(nextBtn);
		root.appendChild(dotsWrap);

		function currentPerView() {
			var width = window.innerWidth;
			var chosen = 1;
			Object.keys(breakpoints)
				.map(Number)
				.sort(function (a, b) { return a - b; })
				.forEach(function (bp) {
					if (width >= bp) {
						chosen = breakpoints[bp];
					}
				});
			return Math.min(chosen, slides.length);
		}

		function layout() {
			perView = currentPerView();
			maxIndex = Math.max(0, slides.length - perView);
			if (index > maxIndex) {
				index = maxIndex;
			}
			var basis = 100 / perView;
			slides.forEach(function (slide) {
				slide.style.flex = '0 0 ' + basis + '%';
				slide.style.maxWidth = basis + '%';
			});
			buildDots();
			update();

			var hasOverflow = slides.length > perView;
			prevBtn.style.display = hasOverflow ? '' : 'none';
			nextBtn.style.display = hasOverflow ? '' : 'none';
			dotsWrap.style.display = hasOverflow ? '' : 'none';
		}

		function buildDots() {
			dotsWrap.innerHTML = '';
			for (var i = 0; i <= maxIndex; i++) {
				(function (i) {
					var dot = document.createElement('button');
					dot.type = 'button';
					dot.className = 'cc-slider__dot';
					dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
					dot.addEventListener('click', function () {
						goTo(i);
						restart();
					});
					dotsWrap.appendChild(dot);
				})(i);
			}
		}

		function update() {
			var basis = 100 / perView;
			track.style.transform = 'translateX(' + (-index * basis) + '%)';
			var dots = dotsWrap.children;
			for (var i = 0; i < dots.length; i++) {
				dots[i].classList.toggle('is-active', i === index);
			}
		}

		function goTo(i) {
			if (i < 0) {
				i = maxIndex;
			} else if (i > maxIndex) {
				i = 0;
			}
			index = i;
			update();
		}

		function next() { goTo(index + 1); }
		function prev() { goTo(index - 1); }

		function start() {
			if (!autoplay || slides.length <= perView) { return; }
			stop();
			timer = window.setInterval(next, interval);
		}
		function stop() {
			if (timer) { window.clearInterval(timer); timer = null; }
		}
		function restart() { stop(); start(); }

		prevBtn.addEventListener('click', function () { prev(); restart(); });
		nextBtn.addEventListener('click', function () { next(); restart(); });

		root.addEventListener('mouseenter', stop);
		root.addEventListener('mouseleave', start);
		root.addEventListener('focusin', stop);
		root.addEventListener('focusout', start);
		document.addEventListener('visibilitychange', function () {
			if (document.hidden) { stop(); } else { start(); }
		});

		/* Touch / pointer swipe */
		var startX = 0, deltaX = 0, dragging = false;
		function pointerDown(e) {
			dragging = true;
			startX = (e.touches ? e.touches[0].clientX : e.clientX);
			deltaX = 0;
			track.style.transition = 'none';
			stop();
		}
		function pointerMove(e) {
			if (!dragging) { return; }
			var x = (e.touches ? e.touches[0].clientX : e.clientX);
			deltaX = x - startX;
			var basis = 100 / perView;
			var pct = (deltaX / viewport.offsetWidth) * 100;
			track.style.transform = 'translateX(' + ((-index * basis) + pct) + '%)';
		}
		function pointerUp() {
			if (!dragging) { return; }
			dragging = false;
			track.style.transition = '';
			var threshold = viewport.offsetWidth * 0.15;
			if (deltaX > threshold) {
				prev();
			} else if (deltaX < -threshold) {
				next();
			} else {
				update();
			}
			start();
		}

		viewport.addEventListener('touchstart', pointerDown, { passive: true });
		viewport.addEventListener('touchmove', pointerMove, { passive: true });
		viewport.addEventListener('touchend', pointerUp);
		viewport.addEventListener('mousedown', function (e) { e.preventDefault(); pointerDown(e); });
		window.addEventListener('mousemove', pointerMove);
		window.addEventListener('mouseup', pointerUp);

		var resizeTimer;
		window.addEventListener('resize', function () {
			window.clearTimeout(resizeTimer);
			resizeTimer = window.setTimeout(layout, 150);
		});

		layout();
		// Reveal (templates start hidden to avoid flash of unstyled slides).
		root.style.display = 'block';
		root.classList.add('is-ready');
		start();
	}

	/* ------------------------------------------------------------------ */
	/* Navigation                                                         */
	/* ------------------------------------------------------------------ */
	function initNav() {
		var toggle = document.querySelector('.cc-nav-toggle');
		var nav = document.getElementById('site-navigation');
		if (!toggle || !nav) { return; }

		toggle.addEventListener('click', function () {
			var open = nav.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		});

		// Inject submenu toggles for accessible mobile accordions.
		var parents = nav.querySelectorAll('.menu-item-has-children');
		Array.prototype.forEach.call(parents, function (li) {
			var link = li.querySelector(':scope > a');
			var btn = document.createElement('button');
			btn.type = 'button';
			btn.className = 'cc-submenu-toggle';
			btn.setAttribute('aria-label', 'Toggle submenu');
			btn.setAttribute('aria-expanded', 'false');
			btn.innerHTML = '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>';
			btn.addEventListener('click', function (e) {
				e.preventDefault();
				var open = li.classList.toggle('is-open');
				btn.setAttribute('aria-expanded', open ? 'true' : 'false');
			});
			if (link) {
				link.insertAdjacentElement('afterend', btn);
			}
		});

		// Close menu on Escape.
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && nav.classList.contains('is-open')) {
				nav.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
				toggle.focus();
			}
		});

		// Reset state when resizing up to desktop.
		window.addEventListener('resize', function () {
			if (window.innerWidth >= 992) {
				nav.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
			}
		});
	}

	/* ------------------------------------------------------------------ */
	/* Sticky header shadow                                               */
	/* ------------------------------------------------------------------ */
	function initStickyHeader() {
		var header = document.querySelector('.site-header');
		if (!header) { return; }
		function onScroll() {
			header.classList.toggle('is-scrolled', window.scrollY > 10);
		}
		onScroll();
		window.addEventListener('scroll', onScroll, { passive: true });
	}

	/* ------------------------------------------------------------------ */
	ready(function () {
		initNav();
		initStickyHeader();

		document.querySelectorAll('.owl-carousel-home').forEach(function (el) {
			new Slider(el, { perView: { 0: 1 }, autoplay: true, interval: 5000 });
		});

		document.querySelectorAll('.announcement-owl-carousel').forEach(function (el) {
			new Slider(el, {
				perView: { 0: 1, 768: 2, 1024: 3 },
				autoplay: true,
				interval: 4500
			});
		});
	});
})();
