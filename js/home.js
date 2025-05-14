const containerTabs = document.querySelectorAll('.tab');
const allContainerDishes = document.querySelectorAll('.container-dishes');

containerTabs.forEach(tab => {
	tab.addEventListener('click', e => {
		const tabName = e.target.dataset.name;

		containerTabs.forEach(tab => tab.classList.remove('active'));
		e.target.classList.add('active');

		allContainerDishes.forEach(containerDishes => {
			const dishName = containerDishes.dataset.name;

			if (tabName === dishName) {
				containerDishes.classList.add('active');
			} else {
				containerDishes.classList.remove('active');
			}
		});
	});
});
