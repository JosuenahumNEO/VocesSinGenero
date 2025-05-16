// Constantes DOM
const containerTestimonials = document.querySelector(
	'.container-testimonials'
);
const allCardTestimonials = document.querySelectorAll('.testimonial');
const prevBtn = document.querySelector('.btn-prev');
const nextBtn = document.querySelector('.btn-next');
// Constantes
const totalCardTestimonials = allCardTestimonials.length;
// Variables
let currentIndex = 0;
let autoPlayInterval;

// Función para actualizar la posición del carrusel
const updateCarousel = () => {
	const offset = currentIndex * containerTestimonials.clientWidth;
	containerTestimonials.scrollTo({
		left: offset,
		behavior: 'smooth',
	});
};

// Botón Siguiente - Evento Click
nextBtn.addEventListener('click', () => {
	// Si llega al final, vuelve al principio
	currentIndex = (currentIndex + 1) % totalCardTestimonials;
	updateCarousel();
	resetAutoPlay();
});

// Botón Anterior - Evento Click
prevBtn.addEventListener('click', () => {
	// Si está al principio, vuelve al final

	currentIndex =
		(currentIndex - 1 + totalCardTestimonials) %
		totalCardTestimonials;
	updateCarousel();
	resetAutoPlay();
});

// Función para activar el autoplay cada 5 segundos
function startAutoPlay() {
	autoPlayInterval = setInterval(() => {
		currentIndex = (currentIndex + 1) % totalCardTestimonials;
		updateCarousel();
	}, 5000);
}

// Reiniciar autoplay cuando se navega manualmente
function resetAutoPlay() {
	clearInterval(autoPlayInterval);
	startAutoPlay();
}

// Iniciar autoplay
startAutoPlay();
