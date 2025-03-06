document.addEventListener('DOMContentLoaded', function() {
    let choices = document.querySelectorAll(".choices");
    let initChoice;
    for (let i = 0; i < choices.length; i++) {
        if (choices[i].classList.contains("multiple-remove")) {
            initChoice = new Choices(choices[i], {
                delimiter: ",",
                editItems: true,
                maxItemCount: -1,
                removeItemButton: true,
            });
        } else {
            initChoice = new Choices(choices[i]);
        }
    }
});

document.addEventListener('DOMContentLoaded', e => {
for (let checkbox of document.querySelectorAll('input[type=checkbox]')) {
    checkbox.value = checkbox.checked ? 1 : 0;
    checkbox.addEventListener('change', e => {
        e.target.value = e.target.checked ? 1 : 0;
    });
    }
});
