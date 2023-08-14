

require('../styl/reset.styl');
require('../styl/main.styl');

console.log('Hello World from main.js!');


//hamburger nav
const hamburger = document.querySelector('.hamburger');
const nav = document.querySelector('ul.nav-menu');

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

	updateBodyClass()

};

/**
 * Open Nav
 */
function openNav() {
	hamburger.classList.add('active'); //hamburger add active
	nav.classList.add('displayed');
	setTimeout(function() {
		nav.classList.add('active');
	}, 10);
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
 * Event Listeners
 */

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

(function() {
	$(document).ready(detectResponsiveEnvironment);

	var timeId = null;
	function startResize() {
		clearTimeout(timeId);
		timeId = setTimeout(detectResponsiveEnvironment, 250);
	}

	window.addEventListener('resize', startResize);
}).call(this);

