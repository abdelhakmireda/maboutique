$(document).ready(function () {
    $('.add-to-wishlist form').submit(function (e) {
        e.preventDefault(); // Prevent default form submission

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Display success message (replace with your implementation)
                    alert(response.message);
                    // Optionally update wishlist content dynamically
                } else {
                    // Display error message (replace with your implementation)
                    alert('Une erreur est survenue.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error adding product to wishlist:', textStatus, errorThrown);
                // Handle errors (replace with your implementation)
            }
        });
    });
});