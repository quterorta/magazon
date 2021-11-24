$(document).ready(function(){
    $('.product__add_to_cart_btn').click(function(){
        addToCart();
    });

    $('.product_card__add_to_cart_btn').click(function(){
        var product_id = $(this).data("product_id");
        var clicked_button = $(this);
        addToCartMain(product_id, clicked_button);
    });

    $('.plus_product_in_cart').click(function(){
        var product_id = $(this).data("product_id");
        var product_qty = $(this).data("product_qty");
        plusProductInCart(product_id, product_qty);
    });

    $('.minus_product_in_cart').click(function(){
        var product_id = $(this).data("product_id");
        var product_qty = $(this).data("product_qty");
        minusProductInCart(product_id, product_qty);
    });
})

function addToCart() {

    let id = $('#product_id').val();
    let qty = parseInt($('#product_qty').val());

    let cart_text = $('.cart_product_counter');

    cart_text.each(function(){
        let cart_text_value = parseInt($(this).text());
        cart_text_value += qty;
        $(this).text(cart_text_value)
    });

    $.ajax({
        url: "/add-to-cart",
        type: "POST",
        data: {
            id: id,
            qty: qty,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
        },
        success: (data) => {
            console.log(data);
        },
        error: (data) => {
            console.log(data);
        }
    });
}

function addToCartMain(product_id, clicked_button) {

    let id = parseInt(product_id);
    let qty = 1;

    let cart_text = $('.cart_product_counter');

    cart_text.each(function(){
        let cart_text_value = parseInt($(this).text());
        cart_text_value += qty;
        $(this).text(cart_text_value)
    });

    let parent_block = clicked_button.parent('div');
    let animateBlock = parent_block.children('.add-to-card-container');

    for( let i = 0; i < animateBlock.length; i++){
        animateBlock[i].style.height = '100%';
        setTimeout(function(){animateBlock[i].style.height = '0%';}, 1100);
    };

    $.ajax({
        url: "/add-to-cart",
        type: "POST",
        data: {
            id: id,
            qty: qty,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
        },
        success: (data) => {
            console.log(data);
        },
        error: (data) => {
            console.log(data);
        }
    });
}

function plusProductInCart(product_id, product_qty) {
    let idForProductField = String("cart__field_for_id_"+product_id);
    let product_qty_field_value = parseInt($('#'+idForProductField).val());

    product_qty_field_value += 1;
    $('#'+idForProductField).val(product_qty_field_value);

    let cart_text = $('.cart_product_counter');

    cart_text.each(function(){
        let cart_text_value = parseInt($(this).text());
        cart_text_value += 1;
        $(this).text(cart_text_value)
    });

    $.ajax({
        url: "/add-to-cart",
        type: "POST",
        data: {
            id: product_id,
            qty: 1,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
        },
        success: (data) => {
            console.log(data);
        },
        error: (data) => {
            console.log(data);
        }
    });
}

function minusProductInCart(product_id, product_qty) {
    let idForProductField = String("cart__field_for_id_"+product_id);
    let product_qty_field_value = parseInt($('#'+idForProductField).val());

    product_qty_field_value -= 1;
    $('#'+idForProductField).val(product_qty_field_value);

    let cart_text = $('.cart_product_counter');

    cart_text.each(function(){
        let cart_text_value = parseInt($(this).text());
        cart_text_value -= 1;
        $(this).text(cart_text_value)
    });

    if (parseInt(product_qty_field_value) === 0) {
        window.location.href="/cart/cart-remove/"+product_id;
    }

    $.ajax({
        url: "/minus-product-in-cart",
        type: "POST",
        data: {
            id: product_id,
            new_qty: parseInt(product_qty_field_value),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
        },
        success: (data) => {
            console.log(data);
        },
        error: (data) => {
            console.log(data);
        }
    });
}


