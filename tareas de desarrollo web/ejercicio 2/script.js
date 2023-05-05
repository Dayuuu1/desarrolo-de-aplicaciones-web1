const form = document.querySelector("form"),
    nextBtn = form.querySelector(".nextBtn"),
    nextBtnii = form.querySelector(".nextBtnii"),
    backBtn = form.querySelector(".backBtn"),
    backBtnk = form.querySelector(".backBtnk"),
    allInput = form.querySelectorAll(".first input");


nextBtnii.addEventListener("click", () => {
    allInput.forEach(input => {
        if (input.value != "") {
            form.classList.add('terActive');
        } else {
            form.classList.remove('terActive');
        }
    })
})

nextBtn.addEventListener("click", () => {
    allInput.forEach(input => {
        if (input.value != "") {
            form.classList.add('secActive');
        } else {
            form.classList.remove('secActive');
        }
    })
})

backBtn.addEventListener("click", () => form.classList.remove('secActive'));
backBtnk.addEventListener("click", () => form.classList.remove('terActive'));