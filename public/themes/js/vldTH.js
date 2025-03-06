var vldTH = function(id, arrayVld, buttonId) {
    const form = document.getElementById(id);
    const submitButton = document.getElementById(buttonId);
    const originalButtonText = submitButton.innerHTML;

    function validateForm() {
        let formIsValid = true;

        arrayVld.forEach(({ input, error }) => {
            const inputElement = document.getElementById(input);
            const errorElement = document.getElementById(error);

            if (inputElement.value.trim() === '') {
                errorElement.style.display = 'flex';
                inputElement.classList.add("is-invalid");
                formIsValid = false;
            } else {
                errorElement.style.display = 'none';
                inputElement.classList.remove("is-invalid");
            }
        });

        return formIsValid;
    }

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        if (validateForm()) {
            DisableButtonSubmit.disableButton(submitButton);
            form.submit();
        }
    });

    arrayVld.forEach(item => {
        document.getElementById(item.input).addEventListener('input', function() {
            const errorElement = document.getElementById(item.error);
            if (this.value) {
                errorElement.style.display = 'none';
                this.classList.remove("is-invalid");
            }
        });
    });

    DisableButtonSubmit.init(buttonId, originalButtonText);
};

var DisableButtonSubmit = (function() {
    function init(buttonId, originalText) {
        var button = document.getElementById(buttonId);
        if (!button) {
            console.error('Button with id ' + buttonId + ' not found');
            return;
        }

        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                enableButton(button, originalText);
            }
        });
    }

    function disableButton(button) {
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...';
    }

    function enableButton(button, text) {
        button.disabled = false;
        button.innerHTML = text;
    }

    return {
        init: init,
        disableButton: disableButton,
        enableButton: enableButton
    };
})();