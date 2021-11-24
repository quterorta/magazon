<div class="admin_product_card">
    @if($product->moderate == 0)
    <div class="admin_product_card__nonmoderated_product" title="Не прошел модерацию">
        <i class="fas fa-ban"></i>
    </div>
    @endif
    <div class="admin_product_card__image">
        <a href="{{ route('product.edit', $product->id) }}"><img src="{{ Storage::url($product->image_cover) }}" alt="Изображение товара"></a>
    </div>
    <div class="admin_product_card__category">
        <p class="admin_product_card__category__category_title">{{ $product->category->title }}</p>
        <p class="admin_product_card__category__subcategory_title">{{ $product->sub_category->title }}</p>
    </div>
    <div class="admin_product_card__id_article">
        <p class="admin_product_card__category__id"><b>ID:</b> {{ $product->id }}</p>
        <p class="admin_product_card__category__article">Код товара: {{ $product->article }}</p>
    </div>
    <div class="admin_product_card__title">
        <a href="{{ route('product.edit', $product->id) }}">{{ $product->title }}</a>
    </div>
    <div class="admin_product_card__controll">
        <a href="{{ route('product.edit', $product->id) }}" class="admin_product_card__controll__edit_btn" title="Редактировать"><i class="fas fa-pen-square"></i></a>
        @if($product->moderate==0)
        <a href="{{ route('product.moderate', $product->id) }}" class="admin_product_card__controll__moderate_btn" title="Подтвердить модерацию"><i class="fas fa-check-square"></i></a>
        @else
        <a href="{{ route('product.nonmoderate', $product->id) }}" class="admin_product_card__controll__non_moderate_btn" title="Снять модерацию"><i class="fas fa-ban"></i></a>
        @endif
        <a href="{{ route('product.reviews', $product->id) }}" class="admin_product_card__controll__review_btn" title="Отзывы к товару"><i class="fas fa-eye"></i></a>
        <form action="{{ route('product.destroy', $product->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-btn admin_product_card__controll__delete_btn" data-title="{{ $product->title }}"><i class="fas fa-trash-alt"></i></button>
        </form>
    </div>
</div>