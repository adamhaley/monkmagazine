
import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.start()
/**
 * Functions
 */
//hamburger nav
const hamburger = document.querySelector('.hamburger');
const nav = document.querySelector('ul.nav-menu');
const backToTop = document.querySelector('.back-to-top-link a');

/**
 * Open Nav
 */
function openNav() {
	hamburger.classList.add('active'); //hamburger add active
	nav.classList.add('displayed');
	setTimeout(function() {
		nav.classList.add('active');
	}, 10);

	//attach social link events
	attachSocialLinks();
}

/**
 * Close Nav
 */
function closeNav() {
	hamburger.classList.remove('active');//hamburger remove active
	nav.classList.remove('active');
	nav.addEventListener('transitionend', function() {
		nav.classList.remove('displayed'); //wait for transition to finish to remove nav from the flow
	},{
		capture: false,
		once: true,
		passive: false
	});
}

/**
 * Close nav when clicking a link on it
 */
nav.addEventListener('click', function(e) {
	if(e.target.tagName === 'A') {
		closeNav();
	}
});

/**
 * Hamburger Menu Click
 */
hamburger.addEventListener('click', function() {
	if(this.classList.contains('active')) {
		closeNav();
	} else {
		openNav();
	}
});

backToTop.addEventListener('click', function(e) {
	e.preventDefault();
	window.scrollTo({
		top: 0,
		behavior: 'smooth'
	});
});

function detectResponsiveEnvironment() {

	let breakpoints = {
		xs: 0,
		sm: 576,
		md: 768,
		lg: 992,
		xl: 1200
	};

	let currentBreakpoint = 'xs';

	function getCurrentBreakpoint() {
		let width = window.innerWidth;
		console.log(width + 'px');
		let breakpoint = 'xs';
		for(let key in breakpoints) {
			if(width >= breakpoints[key]) {
				breakpoint = key;
			}
		}

		console.log('currentBreakpoint: ' + breakpoint);
		return breakpoint;
	}
	//add class to the body tag based on breakpoint
	function updateBodyClass() {
		let breakpoint = getCurrentBreakpoint();

		document.body.classList.remove(Object.keys(breakpoints));

		document.body.classList.forEach(function(item) {
			if( Object.keys(breakpoints).includes(item) && item != breakpoint ){
				document.body.classList.remove(item);
			}

		});
		document.body.classList.add(breakpoint);
	}

	updateBodyClass();

	console.log('running detect admin bar');
	//if wp admin bar is there, move hamburger down
	if(document.querySelector('#wpadminbar')) {
		document.querySelector('.hamburger').style.top = '32px';
	}


};

function detectScrollPos() {
	let scrollPos = window.scrollY;
	let backToTop = document.querySelector('.back-to-top-link');
	console.log(backToTop);
	console.log('scrollPos: ' + scrollPos);
	if(scrollPos > 100) {
		backToTop.classList.add('in');
		setTimeout(function() {
			backToTop.classList.add('visible');
		},10);
	} else {
		backToTop.classList.remove('visible');
		backToTop.addEventListener('transitionend', function() {
			backToTop.classList.remove('in');
		}, {
			capture: false,
			once: true,
			passive: false
		});
	}
}


//social links
function attachSocialLinks() {
	const facebookLinks = document.querySelectorAll('.facebook');
	const instagramLinks = document.querySelectorAll('.ig');
	const emailLinks = document.querySelectorAll('.email');

	facebookLinks.forEach(function(link) {
		link.addEventListener('click', function(e) {
			e.preventDefault();
			window.open('https://www.facebook.com/people/Monk-Magazine/100067147688530/', '_blank');
		});
	});

	instagramLinks.forEach(function(link) {
		link.addEventListener('click', function(e) {
			e.preventDefault();
			window.open('https://www.instagram.com/monk.magazine/', '_blank');
		});
	});

	emailLinks.forEach(function(link) {
		link.addEventListener('click', function(e) {
			e.preventDefault();
			window.location.href = 'mailto:info@monkmagazine.com';
		});
	});
}

function attachNavLinks() {

	let links = document.querySelectorAll('.nav-menu a[href^="#"]');
	links.forEach(function(link) {
		link.addEventListener('click', function(e) {
			e.preventDefault();
			let anchor = this.getAttribute('href').slice(1, this.getAttribute('href').length);
			//if we are on the homepage, scroll to the anchor
			if(document.body.classList.contains('home')) {
				let target = document.querySelector('.' + anchor);
				let offset = target.getBoundingClientRect();
				offset = offset.top;
				window.scrollTo({
					top: offset,
					behavior: 'smooth'
				});
			}else{
				//got home with anchor link
				window.location.href = window.location.origin + '/#' + anchor;
			}
		});
	});

}

(function() {
	window.addEventListener('load', detectResponsiveEnvironment, false);
	window.addEventListener('load', attachSocialLinks, false)
	window.addEventListener('load', attachNavLinks, false)

	var timeId = null;
	function startResize() {
		clearTimeout(timeId);
		timeId = setTimeout(detectResponsiveEnvironment, 250);
	}

	window.addEventListener('resize', startResize);

	var timeId2 = null;
	function startScroll() {
		clearTimeout(timeId2);
		timeId2 = setTimeout(detectScrollPos, 250);
	}

	window.addEventListener('scroll', startScroll);

}).call(this);

