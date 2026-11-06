let radios = document.querySelectorAll('input[name="id_groupe"]');
radios.forEach(radio => {
    radio.addEventListener('change', function () {
        this.form.submit();
    });
});