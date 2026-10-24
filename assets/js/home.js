/* The Whalebone Inn — home page interactions. No dependencies. */
(function () {
	'use strict';

	var doc = document, body = doc.body, win = window;
	var reduce = win.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var finePointer = win.matchMedia('(hover: hover) and (pointer: fine)').matches;
	var $ = function (s, c) { return (c || doc).querySelector(s); };
	var $$ = function (s, c) { return Array.prototype.slice.call((c || doc).querySelectorAll(s)); };

	/* ---------- Split hero title into characters ---------- */
	var ci = 0;
	$$('.wb-split').forEach(function (el) {
		var text = el.textContent; el.textContent = ''; el.setAttribute('aria-label', text);
		text.split(' ').forEach(function (word, wi) {
			if (wi) { var sp = doc.createElement('span'); sp.className = 'wb-sp'; el.appendChild(sp); }
			var w = doc.createElement('span'); w.className = 'wb-w'; w.setAttribute('aria-hidden', 'true');
			word.split('').forEach(function (ch) {
				var s = doc.createElement('span'); s.className = 'wb-ch'; s.textContent = ch; s.style.setProperty('--i', ci++); w.appendChild(s);
			});
			el.appendChild(w);
		});
	});

	/* ---------- Preloader ---------- */
	var started = false;
	function start() {
		if (started) return; started = true;
		body.classList.remove('is-loading');
		body.classList.add('is-loaded');
		setTimeout(typeKicker, 900);
		setTimeout(startAuto, 2600);
		setTimeout(function () { $$('.wb-hero .wb-count').forEach(countUp); }, 1700);
	}
	if (doc.readyState === 'complete') setTimeout(start, 500);
	else win.addEventListener('load', function () { setTimeout(start, 400); });
	setTimeout(start, 3500); // safety net on slow images

	/* ---------- Typewriter kicker ---------- */
	function typeKicker() {
		var el = $('.wb-type'); if (!el) return;
		var t = el.getAttribute('data-text'), i = 0;
		if (reduce) { el.textContent = t; el.classList.add('is-done'); return; }
		(function step() {
			el.textContent = t.slice(0, ++i);
			if (i < t.length) setTimeout(step, 28 + Math.random() * 40); else el.classList.add('is-done');
		})();
	}

	/* ---------- Counters ---------- */
	function countUp(el) {
		if (el.dataset.done) return; el.dataset.done = 1;
		var to = +el.dataset.to, t0 = null, dur = 1400;
		if (reduce) { el.textContent = to; return; }
		requestAnimationFrame(function f(ts) {
			if (!t0) t0 = ts;
			var p = Math.min((ts - t0) / dur, 1), e = 1 - Math.pow(1 - p, 4);
			el.textContent = Math.round(to * e);
			if (p < 1) requestAnimationFrame(f);
		});
	}

	/* ---------- Dish picker (hero) ---------- */
	var thumbs = $$('.wb-thumb'), plates = $$('.wb-hero__plate img'), label = $('.wb-hero__label'), current = 0, autoTimer = null, AUTO = 5000;
	function pick(i, user) {
		if (i === current) { if (user) restartAuto(); return; }
		var old = plates[current];
		old.classList.remove('is-active'); old.classList.add('is-leaving');
		setTimeout(function () { old.classList.remove('is-leaving'); }, 750);
		plates[i].classList.add('is-active');
		thumbs.forEach(function (t, k) { t.classList.toggle('is-active', k === i); t.classList.remove('is-timing'); });
		label.classList.add('is-swap');
		setTimeout(function () { label.querySelector('span').textContent = thumbs[i].dataset.name; label.classList.remove('is-swap'); }, 300);
		current = i;
		restartAuto();
	}
	function restartAuto() {
		clearTimeout(autoTimer);
		if (reduce) return;
		var t = thumbs[current];
		t.style.setProperty('--auto', AUTO + 'ms');
		t.classList.remove('is-timing'); void t.offsetWidth; t.classList.add('is-timing');
		autoTimer = setTimeout(function () { pick((current + 1) % thumbs.length); }, AUTO);
	}
	function startAuto() { restartAuto(); }
	thumbs.forEach(function (t) { t.addEventListener('click', function () { pick(+t.dataset.pick, true); }); });
	var heroPlate = $('.wb-hero__plate');
	if (heroPlate) heroPlate.addEventListener('click', function () { pick((current + 1) % thumbs.length, true); });
	var heroSection = $('.wb-hero');

	/* ---------- In-page navigation only (no links leave this page) ---------- */
	var header = $('.wb-header'), menu = $('.wb-mobile-menu'), burger = $('.wb-burger');
	function goTo(sel) {
		var el = sel === '#top' ? null : $(sel);
		var y = el ? el.getBoundingClientRect().top + win.pageYOffset - (header ? 90 : 0) : 0;
		win.scrollTo({ top: Math.max(0, y), behavior: reduce ? 'auto' : 'smooth' });
		if (sel === '#book') {
			var panel = $('#book');
			setTimeout(function () { panel.classList.remove('is-flash'); void panel.offsetWidth; panel.classList.add('is-flash'); }, 700);
		}
	}
	$$('[data-goto]').forEach(function (b) {
		b.addEventListener('click', function (e) { e.preventDefault(); toggleMenu(false); goTo(b.dataset.goto); });
	});
	function toggleMenu(open) {
		if (!menu) return;
		menu.classList.toggle('is-open', open);
		menu.setAttribute('aria-hidden', String(!open));
		burger.setAttribute('aria-expanded', String(open));
		body.style.overflow = open ? 'hidden' : '';
	}
	if (burger) burger.addEventListener('click', function () { toggleMenu(!menu.classList.contains('is-open')); });

	/* Book button: no booking page yet, so give friendly feedback */
	var toast = $('.wb-toast'), toastT;
	function say(msg) {
		toast.textContent = msg; toast.classList.add('is-show');
		clearTimeout(toastT); toastT = setTimeout(function () { toast.classList.remove('is-show'); }, 3200);
	}
	$$('.wb-book-now').forEach(function (b) { b.addEventListener('click', function () { say('Online booking is coming soon. Pop in and see us!'); burst(b); }); });
	$$('.wb-copy').forEach(function (b) {
		b.addEventListener('click', function () {
			var txt = b.dataset.copy;
			var done = function () { say('Address copied ✓'); };
			if (navigator.clipboard) navigator.clipboard.writeText(txt).then(done, done); else done();
			burst(b);
		});
	});

	/* Confetti diamonds on click */
	function burst(el) {
		if (reduce) return;
		var r = el.getBoundingClientRect(), cols = ['#C9A44C', '#F3EDE2', '#6F8F85', '#D8B663'];
		for (var i = 0; i < 18; i++) {
			var d = doc.createElement('span');
			var a = Math.random() * Math.PI * 2, dist = 60 + Math.random() * 90;
			d.style.cssText = 'position:fixed;z-index:95;pointer-events:none;width:9px;height:9px;left:' + (r.left + r.width / 2) + 'px;top:' + (r.top + r.height / 2) + 'px;background:' + cols[i % 4] + ';transform:rotate(45deg)';
			body.appendChild(d);
			d.animate([
				{ transform: 'translate(0,0) rotate(45deg) scale(1)', opacity: 1 },
				{ transform: 'translate(' + Math.cos(a) * dist + 'px,' + (Math.sin(a) * dist + 40) + 'px) rotate(' + (360 + Math.random() * 360) + 'deg) scale(.3)', opacity: 0 }
			], { duration: 900 + Math.random() * 400, easing: 'cubic-bezier(.22,1,.36,1)' }).onfinish = (function (n) { return function () { n.remove(); }; })(d);
		}
	}

	/* ---------- Scroll reveal: enter AND exit ---------- */
	var animEls = $$('[data-anim]');
	animEls.forEach(function (el) { if (el.dataset.delay) el.style.setProperty('--delay', el.dataset.delay + 'ms'); });
	if ('IntersectionObserver' in win && !reduce) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (en) {
				var el = en.target;
				if (en.isIntersecting) {
					el.classList.add('is-in'); el.classList.remove('is-out-up');
					$$('.wb-count', el).forEach(countUp);
				} else {
					el.classList.remove('is-in');
					// left the top of the viewport → exit upwards; otherwise reset below
					el.classList.toggle('is-out-up', en.boundingClientRect.top < 0);
				}
			});
		}, { threshold: 0.15, rootMargin: '0px 0px -8% 0px' });
		animEls.forEach(function (el) { io.observe(el); });
	} else {
		animEls.forEach(function (el) { el.classList.add('is-in'); });
		$$('.wb-count').forEach(function (el) { el.textContent = el.dataset.to; });
	}

	/* ---------- Active nav pill follows sections ---------- */
	var navBtns = $$('.wb-nav button'), pill = $('.wb-nav__pill');
	function movePill(btn) {
		if (!pill || !btn) return;
		pill.style.left = btn.offsetLeft + 'px'; pill.style.width = btn.offsetWidth + 'px';
		navBtns.forEach(function (b) { b.classList.toggle('is-active', b === btn); });
	}
	function activeSection() {
		var y = win.innerHeight * 0.4, active = navBtns[0];
		navBtns.forEach(function (b) {
			var s = b.dataset.goto; if (s === '#top') return;
			var el = $(s); if (el && el.getBoundingClientRect().top < y) active = b;
		});
		return active;
	}
	win.addEventListener('load', function () { movePill(navBtns[0]); });
	if (doc.fonts && doc.fonts.ready) doc.fonts.ready.then(function () { movePill(activeSection()); });
	win.addEventListener('resize', function () { movePill(activeSection()); });

	/* ---------- Scroll loop: progress, header, parallax, marquees ---------- */
	var bar = $('.wb-progress span'), sticky = $('.wb-sticky'), giant = $('.wb-footer__giant');
	var parallax = $$('[data-parallax]'), parallaxX = $$('[data-parallax-x]'), spinners = $$('.wb-spin-scroll');
	var marquees = $$('.wb-marquee').map(function (m) {
		return { el: m, x: 0, base: +(m.dataset.speed || 40), dir: m.classList.contains('wb-marquee--rev') ? 1 : -1, w: 0 };
	});
	var lastY = win.pageYOffset, velocity = 0, ticking = false, lastPill = null;

	function onScroll() {
		var y = win.pageYOffset, h = doc.documentElement.scrollHeight - win.innerHeight;
		velocity = y - lastY;
		if (bar) bar.style.transform = 'scaleX(' + (h > 0 ? y / h : 0) + ')';
		if (header) {
			header.classList.toggle('is-stuck', y > 40);
			header.classList.toggle('is-hidden', y > 500 && velocity > 4 && !menu.classList.contains('is-open'));
			if (velocity < -2) header.classList.remove('is-hidden');
		}
		if (sticky) sticky.classList.toggle('is-show', y > win.innerHeight * 0.7 && y < h - 200);

		if (!reduce) {
			parallax.forEach(function (el) { el.style.translate = '0 ' + (y * +el.dataset.parallax).toFixed(1) + 'px'; });
			parallaxX.forEach(function (el) {
				var r = el.parentNode.getBoundingClientRect(), c = r.top + r.height / 2 - win.innerHeight / 2;
				el.style.transform = 'translateX(' + (c * +el.dataset.parallaxX).toFixed(1) + 'px)';
			});
			spinners.forEach(function (el) {
				var r = el.getBoundingClientRect();
				el.style.transform = 'rotate(' + ((r.top - win.innerHeight / 2) * (+el.dataset.spin || 0.3)).toFixed(1) + 'deg)';
			});
			if (giant) {
				var gr = giant.getBoundingClientRect(), p = 1 - (gr.top - win.innerHeight * 0.45) / (win.innerHeight * 0.5);
				giant.style.setProperty('--fill', Math.max(0, Math.min(1, p)) * 100 + '%');
			}
		}
		var a = activeSection(); if (a !== lastPill) { movePill(a); lastPill = a; }
		lastY = y; ticking = false;
	}
	win.addEventListener('scroll', function () { if (!ticking) { ticking = true; requestAnimationFrame(onScroll); } }, { passive: true });
	onScroll();

	/* Marquees run continuously and speed up with scroll velocity */
	if (!reduce) {
		var prev = performance.now(), boost = 0;
		(function loop(now) {
			var dt = Math.min((now - prev) / 1000, 0.05); prev = now;
			boost += (Math.min(Math.abs(velocity), 80) - boost) * 0.08; velocity *= 0.9;
			marquees.forEach(function (m) {
				if (!m.w) m.w = m.el.firstElementChild.offsetWidth;
				m.x += m.dir * (m.base + boost * 6) * dt;
				if (m.x <= -m.w) m.x += m.w; if (m.x > 0) m.x -= m.w;
				m.el.style.transform = 'translate3d(' + m.x.toFixed(2) + 'px,0,0)';
			});
			requestAnimationFrame(loop);
		})(prev);
		win.addEventListener('resize', function () { marquees.forEach(function (m) { m.w = 0; }); });
	}

	if (!finePointer || reduce) return;

	/* ---------- Pointer-only effects ---------- */
	// Custom cursor
	var cur = $('.wb-cursor'), cx = 0, cy = 0, tx = 0, ty = 0;
	win.addEventListener('mousemove', function (e) { tx = e.clientX; ty = e.clientY; });
	(function follow() { cx += (tx - cx) * 0.2; cy += (ty - cy) * 0.2; cur.style.transform = 'translate(' + cx + 'px,' + cy + 'px)'; requestAnimationFrame(follow); })();
	doc.addEventListener('mouseover', function (e) { cur.classList.toggle('is-hover', !!e.target.closest('button, .wb-dish, .wb-card')); });
	doc.addEventListener('mousedown', function () { cur.classList.add('is-down'); });
	doc.addEventListener('mouseup', function () { cur.classList.remove('is-down'); });

	// Magnetic buttons
	$$('.wb-magnetic').forEach(function (b) {
		b.addEventListener('mousemove', function (e) {
			var r = b.getBoundingClientRect(), x = e.clientX - r.left - r.width / 2, y = e.clientY - r.top - r.height / 2;
			b.style.transform = 'translate(' + x * 0.25 + 'px,' + y * 0.35 + 'px)';
			b.firstElementChild.style.transform = 'translate(' + x * 0.12 + 'px,' + y * 0.12 + 'px)';
		});
		b.addEventListener('mouseleave', function () { b.style.transform = ''; b.firstElementChild.style.transform = ''; });
	});

	// 3D tilt on event cards
	$$('.wb-tilt').forEach(function (c) {
		var g = doc.createElement('span'); g.className = 'wb-card__glare'; c.appendChild(g);
		c.addEventListener('mousemove', function (e) {
			if (!c.classList.contains('is-in')) return;
			var r = c.getBoundingClientRect(), px = (e.clientX - r.left) / r.width, py = (e.clientY - r.top) / r.height;
			c.style.transform = 'perspective(900px) rotateX(' + (0.5 - py) * 10 + 'deg) rotateY(' + (px - 0.5) * 12 + 'deg) translateY(-8px)';
			c.style.setProperty('--gx', px * 100 + '%'); c.style.setProperty('--gy', py * 100 + '%');
		});
		c.addEventListener('mouseleave', function () { c.style.transform = ''; });
	});

	// Hero plate leans toward the pointer
	var wrap = $('.wb-hero__plate-wrap');
	if (heroSection && wrap) {
		heroSection.addEventListener('mousemove', function (e) {
			var r = heroSection.getBoundingClientRect(), x = (e.clientX - r.left) / r.width - 0.5, y = (e.clientY - r.top) / r.height - 0.5;
			wrap.style.transform = 'translate(' + (x * 30) + 'px,' + (y * 24) + 'px) rotate(' + (x * 10) + 'deg)';
		});
		heroSection.addEventListener('mouseleave', function () { wrap.style.transform = ''; });
	}
})();
