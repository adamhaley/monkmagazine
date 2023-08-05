require('../styl/reset.styl');
require('../styl/main.styl');

console.log('Hello World from main.js!');


//hamburger nav
const hamburger = document.querySelector('.hamburger');

hamburger.addEventListener('click', function() {
	this.classList.toggle('active');
});
