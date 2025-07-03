let menuIcon =document.querySelector('#menu-icon');
let navbar =document.querySelector('.navbar')
let sections = document.querySelectorAll('sections')
let navLinks =document.querySelectorAll('header nav a');

window.onscroll=()=>{
let top=window.scrollY;
let offset=sec.offsetTop-150;
let height=sec.offsetHeight;
let id=sec.getAttribute('id');


if(top>=offset && top < offset +height){
    navLinks.forEach(links=>{
        links.classList.remove('active');
      //  document.querySelector('header nav a [href*='+ id +']').classList.add('active')
    })
}
}

menuIcon.onclick=()=>{
    menuIcon.classList.toggle('bx-x');
    navbar.classList.toggle('active')
}

document.getElementById('account-icon').addEventListener('click', function() {
    const dropdownMenu = document.getElementById('dropdown-menu');
    dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
});

window.onclick = function(event) {
    if (!event.target.matches('#account-icon')) {
        const dropdowns = document.getElementsByClassName("dropdown-content");
        for (let i = 0; i < dropdowns.length; i++) {
            const openDropdown = dropdowns[i];
            if (openDropdown.style.display === 'block') {
                openDropdown.style.display = 'none';
            }
        }
    }
}