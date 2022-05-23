const backtoTop = document.querySelector("#backtoTop");
const dropdownButton = document.querySelector("#showMenu");

backtoTop.addEventListener("click", function(e) {
    e.preventDefault();
    window.scroll({
        top: 0,
        left: 0,
        behavior: "smooth"
    });
});
window.addEventListener("scroll", function() {
    if (window.scrollY >= 500) {
        backtoTop.classList.remove("hidden");
    } else {
        backtoTop.classList.add("hidden");
    }
});


// dropdownButton.addEventListener('click', function(e) {
//   const isDropdownButton = e.target.matches('[data-dropdown-button]')
//   if(!isDropdownButton && e.target.closest('[data-dropdown]') != null ) return
//
//   let currentDropdown
//
//   if(isDropdownButton){
//     currentDropdown = e.target.closest('[data-dropdown]')
//     currentDropdown.classList.toggle("active")
//
//   }
//
//   const dropdownSelect = document.querySelectorAll("[data-dropdown].active")
//
//   console.log(dropdownSelect)
//   dropdownSelect.forEach(dropdown => {
//     if(dropdown === currentDropdown) return
//     dropdown.classList.remove('active')
//     console.log(dropdown)
//   })
// });
