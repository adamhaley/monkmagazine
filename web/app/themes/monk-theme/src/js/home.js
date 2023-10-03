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
