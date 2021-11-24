<div class="admin_review_card">
    <div class="admin_review_card__info">
        <p class="admin_review_card__info__id"><b>ID:</b> {{ $review->id }}</p>
        <p class="admin_review_card__info__product">Отзывы к товару: <a href="{{ route('product.edit', $product->id) }}">{{ $product->title }}</a></p>
    </div>
    <div class="admin_review_card__user">
        <p>Пользователь: <a href="{{ route('user.edit', $review->user->id) }}">{{ $review->user->email }}</a></p>
    </div>
    <div class="admin_review_card__time">
        <p>{{ $review->created_at }}</p>
    </div>
    <div class="admin_review_card__body">
        <p>{{ $review->rewiew }}</p>
    </div>
    <div class="admin_review_card__controll">
        <a href="{{ route('rewiew.edit', $review->id) }}" class="admin_review_card__controll__edit_btn" title="Редактировать"><i class="fas fa-pen-square"></i></a>
        <form action="{{ route('rewiew.destroy', $review->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-btn admin_review_card__controll__delete_btn" data-title="{{ $review->id }}"><i class="fas fa-trash-alt"></i></button>
        </form>
    </div>
</div>