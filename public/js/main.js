$(document).ready(function() {

    $('.specifications-multiple').select2();

    $(".delete-btn").click(function() {
        let title = $(this).data("title")
        var res = confirm('Вы действительно хотите удалить товар"' + title + '"?');
        if (!res) {
            return false;
        }
    });

    $('.shop_page__dropdown_menu__collapse_button').click(function() {

        if ($(this).hasClass('active') == true ) {
            $(this).removeClass('active');
        } else {
            $(this).addClass('active');
        }
    });

    $('.shop_page__review__collapse_btn').click(function() {

        if ($(this).hasClass('active') == true ) {
            $(this).removeClass('active');
        } else {
            $(this).addClass('active');
        }
    });

    $('.chapter-menu-link').click(function() {

        if ($(this).hasClass('active') == true ) {
            $(this).removeClass('active');
        } else {
            $(this).addClass('active');
        }
    });

    $('.category-menu-link').click(function() {

        if ($(this).hasClass('active') == true ) {
            $(this).removeClass('active');
        } else {
            $(this).addClass('active');
        }
    });

    $('.catalog_page__side_filter__spec_btn').click(function() {

        if ($(this).hasClass('active') == true ) {
            $(this).removeClass('active');
        } else {
            $(this).addClass('active');
        }
    });

    $('.catalog_page__side_filter__clear_btn').click(function() {
        $('.catalog_page__side_filter__spec_collapse_block input:checkbox').prop('checked', false);
    });

    function filterCheck() {
        var filterBlocks = $('.catalog_page__side_filter__spec_collapse_block__checkboxes');
        filterBlocks.each(function() {
            if ($(this).children('input:checkbox').is(':checked')) {
                $(this).parent().removeClass('collapsed');
                $(this).parent('.catalog_page__side_filter__spec_collapse_block').addClass('show');
                $(this).parent('.catalog_page__side_filter__spec_collapse_block').prev($('.catalog_page__side_filter__spec_btn')).addClass('active');
            }
        });
    }

    jQuery(function(){
        filterCheck();
    });

    $('.favorite-product-badge-inactive').click(function() {
        alert('Pentru a adăuga un produs la favorite, trebuie să vă autentificați sau să vă înregistrați!');
    });

    $('.favorite-product-badge-clickable').click(function() {
        let user_id = $(this).data('user-id');
        let product_id = $(this).data('product-id');

        $.ajax({
            url: "/add-favorite-product",
            type: "POST",
            data: {
                user_id: user_id, product_id: product_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
            },
            success: (data) => {
                $(this).hide();
                $(this).parent('.favorite-product-badge').children('.favorite-product-badge-active').removeAttr('style');
            },
            dataType: "json",
            error: (data) => {
                console.log(data);
            }
        });
    });

    $('.favorite-product-badge-active').click(function() {
        let user_id = $(this).data('user-id');
        let product_id = $(this).data('product-id');

        $.ajax({
            url: "/remove-favorite-product",
            type: "POST",
            data: {
                user_id: user_id, product_id: product_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
            },
            success: (data) => {
                $(this).hide();
                $(this).parent('.favorite-product-badge').children('.favorite-product-badge-clickable').removeAttr('style');
            },
            dataType: "json",
            error: (data) => {
                console.log(data);
            }
        });
    });


// ------------------------------------------------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------ФУНКЦИЯ РЕЙТИНГА ----------------------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------------
const ratings = document.querySelectorAll('.rating');
    if (ratings.length > 0) {
        initRatings();
    }

    // Основная функция
    function initRatings() {
        let ratingActive, ratingValue;
        // Проход по всем рейтингам на странице
        for (let index = 0; index < ratings.length; index++) {
            const rating = ratings[index];
            initRating(rating);
        }

        // Инициализируем конкретный рейтинг
        function initRating(rating) {

            initRatingVars(rating);

            setRatingActiveWidth();

            if (rating.classList.contains('rating_set')) {
                setRating(rating);
            }

        }

        // Инициализируем переменные
        function initRatingVars(rating) {
            ratingActive = rating.querySelector('.rating__active');
            ratingValue = rating.querySelector('.rating__value');
        }

        // Изменяем ширину активных звезд
        function setRatingActiveWidth(index = ratingValue.innerHTML) {
            const ratingActiveWidth = index / 0.05;
            ratingActive.style.width = `${ratingActiveWidth}%`;
        }

        // Возможность указать оценку
        function setRating(rating) {
            const ratingItems = rating.querySelectorAll('.rating__item');
            for (let index = 0; index < ratingItems.length; index++) {
                const ratingItem = ratingItems[index];
                ratingItem.addEventListener("mouseenter", function(e) {
                    // Обновление переменных
                    initRatingVars(rating);
                    // Обновление активных звезд
                    setRatingActiveWidth(ratingItem.value);
                });
                ratingItem.addEventListener("mouseleave", function(e) {
                    // Обновление активных звезд
                    setRatingActiveWidth();
                });
                ratingItem.addEventListener("click", function(e) {
                    // Обновление переменных
                    initRatingVars(rating);
                    if (rating.dataset.ajax) {
                        // Отправка на сервер
                        setRatingValue(ratingItem.value, rating);
                    } else {
                        // Отобразить указанную оценку
                        ratingValue.innerHTML = Number(index + 1).toFixed(1);
                        setRatingActiveWidth();
                    }
                });
            }
        }

    }


// ------------------------------------------------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------КНОПКА ДОБАВЛЕНИЯ В КОРЗИНУ -----------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------------
    const cartButtons = document.querySelectorAll('.cart-button');

    cartButtons.forEach(button => {
        button.addEventListener('click', cartClick);
    });

    function cartClick() {
        let button = this;
        button.classList.add('clicked');
    }









});
