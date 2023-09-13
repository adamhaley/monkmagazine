const readMore = document.querySelector('.more-link');
const moreStuff = document.querySelector('.more-stuff-to-buy');
const moreThrills = document.querySelector('.more-thrills');
const overflowBottom = document.querySelectorAll('.overflow-bottom');

//hamburger nav
const hamburger = document.querySelector('.hamburger');
const nav = document.querySelector('ul.nav-menu');
const backToTop = document.querySelector('.back-to-top a');

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
