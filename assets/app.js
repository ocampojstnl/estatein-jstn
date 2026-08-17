// Estatein — global scripts
document.addEventListener('DOMContentLoaded', function () {
	// Scroll-reveal — any element marked .reveal fades/slides in the first time
	// it enters the viewport, then is left alone (no re-triggering on scroll up).
	var revealEls = document.querySelectorAll('.reveal');

	if (revealEls.length) {
		if ('IntersectionObserver' in window) {
			var revealObserver = new IntersectionObserver(function (entries, observer) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						entry.target.classList.add('is-visible');
						observer.unobserve(entry.target);
					}
				});
			}, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

			revealEls.forEach(function (el) {
				revealObserver.observe(el);
			});
		} else {
			revealEls.forEach(function (el) {
				el.classList.add('is-visible');
			});
		}
	}

	var topBannerClose = document.querySelector('.top-banner__close');
	var topBanner = document.querySelector('.top-banner');

	if (topBannerClose && topBanner) {
		topBannerClose.addEventListener('click', function () {
			topBanner.remove();
		});
	}

	var hamburger = document.querySelector('.hamburger');
	var mobileNav = document.querySelector('.mobile-nav');
	var mobileNavOverlay = document.querySelector('.mobile-nav-overlay');
	var mobileNavClose = document.querySelector('.mobile-nav__close');

	if (hamburger && mobileNav && mobileNavOverlay) {
		var openMobileNav = function () {
			hamburger.classList.add('is-active');
			mobileNav.classList.add('is-active');
			mobileNavOverlay.classList.add('is-active');
			hamburger.setAttribute('aria-expanded', 'true');
			document.body.classList.add('mobile-nav-open');
		};

		var closeMobileNav = function () {
			hamburger.classList.remove('is-active');
			mobileNav.classList.remove('is-active');
			mobileNavOverlay.classList.remove('is-active');
			hamburger.setAttribute('aria-expanded', 'false');
			document.body.classList.remove('mobile-nav-open');
		};

		hamburger.addEventListener('click', function () {
			if (hamburger.classList.contains('is-active')) {
				closeMobileNav();
			} else {
				openMobileNav();
			}
		});

		mobileNavOverlay.addEventListener('click', closeMobileNav);

		if (mobileNavClose) {
			mobileNavClose.addEventListener('click', closeMobileNav);
		}

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape') {
				closeMobileNav();
			}
		});
	}

	// Slider Section block — one carousel per .slider-section instance on the page.
	var sliders = document.querySelectorAll('.slider-section');

	sliders.forEach(function (section) {
		var track = section.querySelector('[data-slider-track]');
		if (!track) {
			return;
		}

		var slides = Array.prototype.slice.call(track.children);
		if (!slides.length) {
			return;
		}

		var counterCurrent = section.querySelector('[data-slider-counter-current]');
		var prevBtn = section.querySelector('[data-slider-prev]');
		var nextBtn = section.querySelector('[data-slider-next]');
		var total = slides.length;
		var currentIndex = 0;

		var pad = function (n) {
			return n < 10 ? '0' + n : String(n);
		};

		var update = function () {
			var firstSlide = slides[0];
			var slideStyle = window.getComputedStyle(firstSlide);
			var stepWidth = firstSlide.getBoundingClientRect().width + parseFloat(slideStyle.marginRight || 0);
			var viewportWidth = track.parentElement.getBoundingClientRect().width;
			var visibleCount = Math.max(1, Math.round(viewportWidth / stepWidth));
			var maxIndex = Math.max(0, total - visibleCount);

			if (currentIndex > maxIndex) {
				currentIndex = maxIndex;
			}

			track.style.transform = 'translateX(-' + (currentIndex * stepWidth) + 'px)';

			if (counterCurrent) {
				counterCurrent.textContent = pad(currentIndex + 1);
			}
			if (prevBtn) {
				prevBtn.disabled = currentIndex <= 0;
			}
			if (nextBtn) {
				nextBtn.disabled = currentIndex >= maxIndex;
			}
		};

		if (prevBtn) {
			prevBtn.addEventListener('click', function () {
				currentIndex = Math.max(0, currentIndex - 1);
				update();
			});
		}

		if (nextBtn) {
			nextBtn.addEventListener('click', function () {
				currentIndex += 1;
				update();
			});
		}

		window.addEventListener('resize', update);
		update();
	});

	// Property card description — "Read More" always sits inline, trailing the
	// text inside the paragraph. Below 1440px it also trims the (already
	// server-trimmed) text word-by-word so the whole thing fits 2 lines instead
	// of wrapping further; above 1440px it just trails the full text as-is.
	var descriptionWraps = document.querySelectorAll('.property-card__description-wrap');
	var READMORE_BREAKPOINT = 1440;

	var updateReadMore = function (wrap) {
		var description = wrap.querySelector('.property-card__description');
		var readMore = wrap.querySelector('.property-card__readmore');
		if (!description || !readMore) {
			return;
		}

		if (typeof description.dataset.fullText === 'undefined') {
			description.dataset.fullText = description.textContent.trim();
		}
		var fullText = description.dataset.fullText;

		description.textContent = fullText;
		description.appendChild(readMore);

		if (window.innerWidth > READMORE_BREAKPOINT) {
			return;
		}

		var lineHeight = parseFloat(window.getComputedStyle(description).lineHeight);
		if (isNaN(lineHeight)) {
			lineHeight = parseFloat(window.getComputedStyle(description).fontSize) * 1.5;
		}
		var maxHeight = lineHeight * 2 + 2;

		if (description.getBoundingClientRect().height <= maxHeight) {
			return;
		}

		var words = fullText.replace(/…$/, '').trim().split(' ');
		while (words.length > 1 && description.getBoundingClientRect().height > maxHeight) {
			words.pop();
			description.textContent = words.join(' ') + '…';
			description.appendChild(readMore);
		}
	};

	if (descriptionWraps.length) {
		var updateAllReadMore = function () {
			descriptionWraps.forEach(updateReadMore);
		};

		updateAllReadMore();

		// Text measurement above runs before the Urbanist webfont has necessarily
		// swapped in (it loads with display=swap), so re-measure once it's actually
		// active — otherwise truncation is computed against fallback-font metrics
		// and can be wrong depending on load timing.
		if (window.document.fonts && window.document.fonts.ready) {
			window.document.fonts.ready.then(updateAllReadMore);
		}

		window.addEventListener('load', updateAllReadMore);

		var readMoreResizeTimer;
		window.addEventListener('resize', function () {
			clearTimeout(readMoreResizeTimer);
			readMoreResizeTimer = setTimeout(updateAllReadMore, 150);
		});
	}

	// FAQ "Read More" modal — shared markup in footer.php, content cloned from
	// each faq-card's hidden <template> on click.
	var faqModal = document.getElementById('faq-modal');
	var faqModalOverlay = document.querySelector('[data-faq-modal-overlay]');
	var faqModalBody = document.querySelector('[data-faq-modal-body]');
	var faqModalClose = document.querySelector('[data-faq-modal-close]');

	if (faqModal && faqModalOverlay && faqModalBody) {
		var openFaqModal = function (template) {
			faqModalBody.innerHTML = '';
			faqModalBody.appendChild(template.content.cloneNode(true));
			faqModal.classList.add('is-active');
			faqModalOverlay.classList.add('is-active');
			document.body.classList.add('faq-modal-open');
		};

		var closeFaqModal = function () {
			faqModal.classList.remove('is-active');
			faqModalOverlay.classList.remove('is-active');
			document.body.classList.remove('faq-modal-open');
		};

		document.addEventListener('click', function (event) {
			var trigger = event.target.closest('[data-faq-trigger]');
			if (!trigger) {
				return;
			}
			var card = trigger.closest('.faq-card');
			var template = card ? card.querySelector('.faq-card__full') : null;
			if (template) {
				openFaqModal(template);
			}
		});

		if (faqModalClose) {
			faqModalClose.addEventListener('click', closeFaqModal);
		}

		faqModalOverlay.addEventListener('click', closeFaqModal);

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape') {
				closeFaqModal();
			}
		});
	}

	// Back to top
	var backToTop = document.getElementById('back-to-top');

	if (backToTop) {
		var toggleBackToTop = function () {
			if (window.scrollY > 400) {
				backToTop.classList.add('is-visible');
			} else {
				backToTop.classList.remove('is-visible');
			}
		};

		toggleBackToTop();
		window.addEventListener('scroll', toggleBackToTop);

		backToTop.addEventListener('click', function () {
			backToTop.classList.add('is-active');
			window.scrollTo({ top: 0, behavior: 'smooth' });
			setTimeout(function () {
				backToTop.classList.remove('is-active');
			}, 500);
		});
	}
});
