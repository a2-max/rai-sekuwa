$('#contactForm').on('submit', function (e) {
    e.preventDefault();
    const btn = $(this).find('button[type="submit"]');
    btn.prop('disabled', true).html('Sending...');

    $.ajax({
        type: 'POST',
        url: 'contact-handler.php',
        data: $(this).serialize(),
        success(response) {
            if (response.success) {
                $('#contactForm')[0].reset();
                Swal.fire({
                    title: "Message Sent!",
                    text: "We'll get back to you shortly.",
                    icon: "success"
                });
            } else {
                Swal.fire({
                    title: "Failed!",
                    text: response.message,
                    icon: "error"
                });
            }
        },
        error() {
            Swal.fire({
                title: "Failed!",
                text: "Unexpected Error! Please try again later.",
                icon: "error"
            });
        },
        complete() {
            btn.prop('disabled', false).text('Send Message');
        }
    });
});