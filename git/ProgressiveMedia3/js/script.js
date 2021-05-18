
let button = document.querySelector(".button");
let input = document.querySelector(".form__input-count");
let box_drag = document.querySelector('.box-drag');
function setAsDraggable() {
    //containment: ограничивает движение только в в блоке можно убрать и будет по всей странице
    $(".draggable" ).draggable({
        containment: $( ".box-drag")
    });
}
function create() {
    let count = input.value;
    let pictures = "";
    for (let i = 1; i <= count; i++) {
        pictures += `<img src="img/sun.png"   alt="sun" class="box-drag__el--sun pic draggable">`

    }
    box_drag.innerHTML = pictures;
    setAsDraggable();
}

button.addEventListener('click', (event) => {
    event.preventDefault();
    create();

});







