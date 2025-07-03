$(document).on('click', '#add_to_cart', function(e) {
    e.preventDefault();

    var product_id = $(this).attr('data-id');

    fetch("add_cart.php", {
        "method": "POST",
        "headers": {
            "Content-Type": "application/json; charset=utf-8"
        },
        "body": JSON.stringify(product_id)
    }).then(function(response) {
        return response.text();
    }).then(function(data) {
        alert('Added to cart successfully')

        $('.cart-count').text(data)
    })
})