window.onload = function() {
    var loginForm = document.querySelector('.login-form');
    var startPos = window.innerHeight;
    var endPos = loginForm.offsetTop;
    var speed = 5;
    var pos = startPos;

    function moveForm() {
        if (pos > endPos) {
            pos -= speed;
            loginForm.style.top = pos + 'px';
            requestAnimationFrame(moveForm);
        }
    }

    moveForm();
}