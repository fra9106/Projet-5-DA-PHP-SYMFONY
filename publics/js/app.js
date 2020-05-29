const sr = ScrollReveal({
	scale: 0.5
	
});

const rt = ScrollReveal({
	duration: 2000,
	scale: 0.5,
	distance: '50px'
});

sr.reveal('.reveal', { //bienvenu
	origin: 'bottom',
	duration: 2000,
	distance: '50px',
	delay: 1000

});

sr.reveal('.reveal-name', { // name
	origin: 'left',
	duration: 1000,
	distance: '200px',
	delay: 500
	
});

sr.reveal('.reveal-dev', {//un developpeur... photo
	origin: 'left',
	duration: 2000,
	distance: '1000px',
	delay: 2500
	
});

sr.reveal('.reveal-fas', { // icon pc
	origin: 'top',
	
	distance: '200px',
	delay: 2000
	
});
// buttons slider
rt.reveal('.reveal1', {
	origin: 'left',
	
	
});

rt.reveal('.reveal2', {
	origin: 'right'
	
	
});
