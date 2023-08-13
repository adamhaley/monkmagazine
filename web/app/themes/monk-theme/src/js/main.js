require('../styl/main.styl');

require('../styl/reset.styl');
console.log('Hello World from main.js!');


//hamburger nav
const hamburger = document.querySelector('.hamburger');
const nav = document.querySelector('ul.nav-menu');

/**
 * Functions
 */

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
