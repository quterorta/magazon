<div class="admin_search_product_form">
    <form action="{{ route('search-products') }}" method="get" id="admin_search_product_form">
        <p class="admin_search_product_form__hint">Введите ID, код или название товара</p>
        <div class="admin_search_product_form__container">
            <input type="text" name="q" class="admin_search_product_form__input" placeholder="Поиск" @if (isset($request->q)) value="{{ $request->q }}" @endif>
            <button class="admin_search_product_form__btn" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </div>
        
        <p class="admin_search_product_form__header">Фильтр товаров</p>
        <div class="admin_search_product_form__filter_param_container">
            <button type="button" data-bs-toggle="collapse" data-bs-target="#moderate_filter" aria-expanded="false" aria-controls="moderate_filter" @if (isset($request->q_moderate)) class="collapsed" @endif>
                Прошли модерацию
            </button>
            <div class="collapse @if (isset($request->q_moderate)) show @endif" id="moderate_filter">
                <div class="admin_search_product_form__filter_params">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="q_moderate[]" id="moderate" value=1 @if (isset($request->q_moderate) and in_array(1, $request->q_moderate)) checked @endif>
                        <label class="form-check-label" for="moderate">Да</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="q_moderate[]" id="nonmoderate" value=0 @if (isset($request->q_moderate) and in_array(0, $request->q_moderate)) checked @endif>
                        <label class="form-check-label" for="nonmoderate">Нет</label>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <button class="admin_search_product_form__clear_btn" type="button">Очистить</button>
            <button class="admin_search_product_form__main_btn" type="submit">Применить</button>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    $('.admin_search_product_form__clear_btn').click(function() {
        $('#admin_search_product_form input:checkbox').prop('checked', false);
        $('#admin_search_product_form input:radio').prop('checked', false);
        $('#admin_search_product_form input').val('');
    });
});
</script>