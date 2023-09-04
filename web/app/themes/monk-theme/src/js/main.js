

require('../styl/reset.styl');
require('../styl/main.styl');

console.log('Hello World from main.js!');



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

let links = document.querySelectorAll('.nav-menu a[href^="#"]');
links.forEach(function(link) {
	link.addEventListener('click', function(e) {
		e.preventDefault();
		console.log(this.getAttribute('href'));
		let anchor = this.getAttribute('href').slice(1, this.getAttribute('href').length);
		let target = document.querySelector('.' + anchor);
		let offset = target.getBoundingClientRect();
		offset = offset.top;
		window.scrollTo({
			top: offset,
			behavior: 'smooth'
		});
	});
});

/**
 * Event Listeners
 */
//hamburger nav
const hamburger = document.querySelector('.hamburger');
const nav = document.querySelector('ul.nav-menu');
const backToTop = document.querySelector('.back-to-top a');
const readMore = document.querySelector('.more-link');
const moreStuff = document.querySelector('.more-stuff-to-buy');
const moreThrills = document.querySelector('.more-thrills');
const overflowBottom = document.querySelectorAll('.overflow-bottom');

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

readMore.addEventListener('click', function(e) {
	e.preventDefault();
	//add expanded class to .overflow
	let overflow = document.querySelector('.overflow');
	if(overflow.classList.contains('in')) {
		overflow.classList.remove('in');
	}else{
		overflow.classList.add('in');
	}

});

moreStuff.addEventListener('click', function(e) {
	e.preventDefault();
	//add expanded class to .overflow
	let overflow = document.querySelector('.buy-overflow');
	if(overflow.classList.contains('in')) {
		overflow.classList.remove('in');
	}else{
		overflow.classList.add('in');
	}
});

moreThrills.addEventListener('click', function(e) {
	e.preventDefault();
	//add expanded class to .overflow
	let overflow = document.querySelector('.thrills-overflow');
	if(overflow.classList.contains('in')) {
		overflow.classList.remove('in');
	}else{
		overflow.classList.add('in');
	}
});

//delegate click event off close icon
overflowBottom.forEach(( item ) => {
	item.addEventListener('click', function(e) {
		e.preventDefault();
		console.log(e.target.closest('.overflow'));
		let overflow = e.target.closest('.overflow');
		overflow.classList.remove('in');
	});
});

(function() {
	window.addEventListener('load', detectResponsiveEnvironment, false);

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

