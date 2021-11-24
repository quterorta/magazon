$(document).ready(function(){

    $('.specifications-multiple').select2();
    $('.multiple-select-2').select2();

    $(".delete-btn").click(function() {
        let title = $(this).data("title")
        var res = confirm('Вы действительно хотите удалить "' + title + '"? Это удалит также все дочерние записи');
        if (!res) {
            return false;
        }
    });

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

});
