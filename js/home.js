const containerTabs = document.querySelectorAll('.tab');
const allContainerDishes = document.querySelectorAll('.container-dishes');

containerTabs.forEach(tab => {
	tab.addEventListener('click', e => {
		const tabName = e.target.dataset.name;

		containerTabs.forEach(tab => tab.classList.remove('active'));
		e.target.classList.add('active');

		allContainerDishes.forEach(container => {
			container.classList.toggle('active', container.dataset.name === tabName);
		});
	});
});
