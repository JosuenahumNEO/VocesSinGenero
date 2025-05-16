/* ********************************** */
/*               HEADER               */
/* ********************************** */
const btnToggleResponsive = document.querySelector('.btn-toggle');
const menuResponsive = document.querySelector('.menu-responsive');
const header = document.querySelector('header');

btnToggleResponsive.addEventListener('click', () => {
	const iconBars = document.querySelector('.fa-bars');
	const iconClose = document.querySelector('.fa-xmark');

	// Activar el menú responsive
	if (iconBars.classList.contains('active')) {
		iconBars.classList.remove('active');
		iconClose.classList.add('active');
		menuResponsive.classList.add('show');
		menuResponsive.style.top = `${header.clientHeight}px`;
	}
	// Cerrar el menú responsive
	else {
		iconBars.classList.add('active');
		iconClose.classList.remove('active');
		menuResponsive.classList.remove('show');
	}
});
