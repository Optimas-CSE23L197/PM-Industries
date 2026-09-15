$(document).ready(function () {
    $('#Form').on('submit', function (e) {
        e.preventDefault();

        const form = this;

        $('#saveBtn')
            .addClass('saving')
            .prop('disabled', true)
            .html(`
                <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
                Saving...
            `);

        // Submit form after 500ms delay to show animation
        setTimeout(function () {
            form.submit();
        }, 500);
    });
});