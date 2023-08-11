require('../styl/reset.styl');
require('../styl/main.styl');

console.log('Hello World from main.js!');


//hamburger nav
const hamburger = document.querySelector('.hamburger');
const nav = document.querySelector('ul.nav-menu');

hamburger.addEventListener('click', function() {
	if(this.classList.contains('active')) {
		this.classList.remove('active');//hamburger remove active
		nav.classList.remove('active');
		nav.addEventListener('transitionend', function() {
			nav.classList.remove('displayed'); //wait for transition to finish to remove nav from the flow
		},{
			capture: false,
			once: true,
			passive: false
		});
	} else {
		this.classList.add('active'); //hamburger add active
		nav.classList.add('displayed');
		setTimeout(function() {
			nav.classList.add('active');
		}, 10);
	}
});


