const singInBtnLink = document.querySelector('.singInBtn-link');
const singUpBtnLink = document.querySelector('.singUpBtn-link');
const wrapper = document.querySelector('.wrapper');

singUpBtnLink.addEventListener('click', () => {
    wrapper.classList.toggle('active');
});

singInBtnLink.addEventListener('click', () => {
    wrapper.classList.toggle('active');
});