const readMore = document.querySelector('.more-link');
const moreStuff = document.querySelector('.more-stuff-to-buy');
const moreThrills = document.querySelector('.more-thrills');
const overflowBottom = document.querySelectorAll('.overflow-bottom');


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

