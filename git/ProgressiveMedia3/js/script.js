let button = document.querySelector(".button");
let input = document.querySelector(".form__input-count");
let box_drag = document.querySelector('.box-drag');

function create() {
    let count = input.value;
    let pictures = "";
    for (let i = 1; i <= count; i++) {
        pictures += `<img src="img/sun.png"   alt="sun" class="box-drag__el--sun pic">`
    }
    box_drag.innerHTML = pictures;

}

button.addEventListener('click', (event) => {
    event.preventDefault();
    create();

});
box_drag.onmousedown = function (e) {
    if (e.target.className == "box-drag__el--sun pic") {
        let drag_sun = e.target;
        drag_sun.style.position = 'absolute';
        moveAt(e);
        box_drag.append(drag_sun);

        drag_sun.style.zIndex = 10;

        function moveAt(e) {
            if (e.pageY > 100 + drag_sun.offsetWidth / 2 && e.pageX > drag_sun.offsetWidth / 2) {
                drag_sun.style.left = e.pageX - drag_sun.offsetWidth / 2 + 'px';
                drag_sun.style.top = e.pageY - drag_sun.offsetHeight / 2 + 'px';
            }

        }

        box_drag.onmousemove = function (e) {
            moveAt(e);
        }
        drag_sun.onmouseup = function () {
            box_drag.onmousemove = null;
            drag_sun.onmouseup = null;
        }
        drag_sun.ondragstart = function () {
            return false;
        };
    }
}






