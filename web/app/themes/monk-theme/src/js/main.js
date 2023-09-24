
import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.start()
/**
 * Functions
 */

function detectResponsiveEnvironment() {

	let breakpoints = {
		'xs': 0,
		'sm': 576,
		'md': 768,
		'lg': 992,
		'xl': 1200
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
		document.body.classList.remove(['xs', 'sm', 'md', 'lg', 'xl']);

		document.body.classList.forEach(function(item) {
			if(item == breakpoint && !document.body.classList.contains(breakpoint)) {
				document.body.classList.add(item);
			}else{
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
	let backToTop = document.querySelector('.back-to-top');
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
	// const emailLinks = document.querySelectorAll('.email');

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


}


(function() {
	// window.addEventListener('load', detectResponsiveEnvironment, false);

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

	attachSocialLinks();
	detectResponsiveEnvironment();
}).call(this);

