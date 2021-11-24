    <div class="sales-products-grid products-grid">
        @foreach ($products as $product)
            <div class="sales-product-card product-card">
                <div class="add-to-card-container" data-product_id="{{ $product->id }}">
                    <div class="add-to-card-text">
                        <p><i class="fas fa-check"></i><br>Adăugat în coș</p>
                    </div>
                </div>
                @if ($product->product_in_sale == 1)
                <div class="sales-product-badge">
                    <span>{{ round((($product->price - $product->new_price)/$product->price)*100) }}%</span>
                </div>
                @elseif ( $product->view_count > 40)
                <div class="popular-product-badge">
                    <span>Popular</span>
                </div>
                @elseif ( $product->recommended == 1)
                <div class="recommended-product-badge">
                    <span><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 226 226" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,226v-226h226v226z" fill="none"></path><g fill="#1d257a"><path d="M113,9.04c-57.15746,0 -103.96,46.80254 -103.96,103.96c0,57.15746 46.80254,103.96 103.96,103.96c57.15746,0 103.96,-46.80254 103.96,-103.96c0,-57.15746 -46.80254,-103.96 -103.96,-103.96zM113,18.08c52.22654,0 94.92,42.69346 94.92,94.92c0,52.22654 -42.69346,94.92 -94.92,94.92c-52.22654,0 -94.92,-42.69346 -94.92,-94.92c0,-52.22654 42.69346,-94.92 94.92,-94.92zM109.42461,36.16883c-1.99017,-0.00298 -4.12186,0.54186 -5.89719,1.93336c-2.36709,1.85533 -3.65275,4.80175 -4.05211,8.1307c-0.00336,0.03528 -0.0063,0.07059 -0.00883,0.10594c-1.12383,11.8023 -5.62261,18.00082 -11.2382,23.19148c-5.61558,5.19067 -12.66227,8.9024 -17.95641,15.15789c-0.00888,0.01173 -0.01771,0.0235 -0.02648,0.03531c-4.24326,5.13241 -7.16476,10.53478 -9.79039,14.22211c-1.31282,1.84366 -2.54074,3.22317 -3.55773,3.99914c-1.0166,0.77602 -1.67428,1.01523 -2.65727,1.01523v9.04c3.10083,0 5.95057,-1.19895 8.13953,-2.86914c2.18896,-1.67019 3.87114,-3.74072 5.43813,-5.94133c3.13029,-4.39603 5.86819,-9.42664 9.3843,-13.68359c0.00414,-0.00498 0.00431,-0.01269 0.00883,-0.01766c3.69741,-4.35003 10.52289,-8.19076 17.15305,-14.31922c6.64492,-6.1421 12.77251,-15.04836 14.09852,-28.97391l-0.00883,0.11477c0.21312,-1.77639 0.65924,-2.09694 0.65328,-2.09227c-0.00588,0.00452 -0.01582,-0.09277 0.64445,0.02649c1.32053,0.23811 4.11601,2.22867 4.99672,3.76961c0.00871,0.01771 0.01754,0.03537 0.02648,0.05297c1.80123,3.04752 1.98148,7.51512 0.86516,12.6507c-1.11632,5.13558 -3.44345,10.65334 -5.62351,15.21086c-0.0151,0.0322 -0.02981,0.06457 -0.04414,0.09711c-1.15809,2.574 -1.72767,5.15838 -1.38601,7.70695c0.34166,2.54857 1.72953,4.88568 3.54891,6.42688c3.63874,3.0824 8.33978,3.76961 13.41875,3.76961h23.61523c3.07617,0 5.15218,0.66777 6.10906,1.27125c0.95688,0.60348 0.9093,0.71308 0.9093,1.20945c0,2.50802 -0.76805,7.88352 -0.76805,7.88352c-0.33584,2.18055 0.95145,4.285 3.0457,4.97906c0,0 4.25516,1.17256 4.25516,5.50875c0,4.10595 -4.03445,6.17086 -4.03445,6.17086c-1.60578,0.80471 -2.5828,2.48377 -2.489,4.27745c0.0938,1.79368 1.24063,3.36167 2.92158,3.9945c0,0 3.60187,1.0585 3.60187,5.16445c0,1.91698 -1.07621,3.30285 -2.61312,4.54648c-1.53692,1.24363 -3.0457,1.84508 -3.0457,1.84508c-1.32526,0.50463 -2.33692,1.6019 -2.73245,2.96371c-0.39553,1.36181 -0.1291,2.83031 0.71964,3.96636c0,0 1.54492,2.19989 1.54492,5.04969c0,1.09652 -0.02306,1.66101 -0.22953,2.18937c-0.20625,0.52837 -0.53536,1.1986 -2.22469,2.21586c-3.37866,2.03432 -12.37766,4.55531 -31.41047,4.55531c-25.46314,0 -36.4553,-2.18422 -44.03469,-4.34344c-7.57939,-2.15921 -12.80975,-4.69656 -24.45391,-4.69656v9.04c10.40893,0 13.69509,1.98265 21.98203,4.34344c8.28694,2.36078 20.51402,4.69656 46.50656,4.69656c19.76235,0 29.95498,-2.16975 36.07172,-5.85305c3.05838,-1.84165 5.05565,-4.29212 5.98547,-6.67406c0.92982,-2.38195 0.8475,-4.52692 0.8475,-5.47344c0,-2.41034 -0.68704,-4.22254 -1.31539,-5.92367c0.68492,-0.42777 0.73915,-0.27911 1.4743,-0.87398c2.7503,-2.22547 5.96781,-6.14113 5.96781,-11.57367c0,-4.3466 -1.92952,-7.35769 -4.00797,-9.5432c2.05828,-2.33353 4.00797,-5.57755 4.00797,-10.06406c0,-7.07095 -4.03612,-10.26163 -7.1243,-12.07687c0.25773,-1.83209 0.59149,-3.56271 0.59149,-6.29445c0,-3.58971 -2.14253,-6.97661 -5.12031,-8.85461c-2.97778,-1.878 -6.6647,-2.66609 -10.93805,-2.66609h-23.61523c-3.96103,0 -6.82322,-0.99677 -7.57453,-1.6332c-0.37566,-0.31821 -0.382,-0.34646 -0.43258,-0.72391c-0.05058,-0.37742 -0.00814,-1.2887 0.67094,-2.79852c2.30235,-4.82011 4.89217,-10.8114 6.25914,-17.10008c1.3728,-6.31545 1.58266,-13.19975 -1.90687,-19.13055c-2.38901,-4.16024 -6.32546,-7.27444 -11.22055,-8.15719c-0.6135,-0.11064 -1.26114,-0.17557 -1.92453,-0.17656z"></path></g></g></svg></span>
                </div>
                @endif
                @if (Auth::user())
                    @if ($product->user_favorites()->where('users.id', Auth::user()->id)->exists())
                    <div class="favorite-product-badge">
                        <span class="favorite-product-badge-active" data-product-id="{{ $product->id }}" data-user-id="{{ Auth::user()->id }}">
                            <i class="fas fa-heart"></i>
                        </span>
                        <span class="favorite-product-badge-clickable" style="display: none" data-product-id="{{ $product->id }}" data-user-id="{{ Auth::user()->id }}">
                            <i class="far fa-heart"></i>
                        </span>
                    </div>
                    @else
                    <div class="favorite-product-badge">
                        <span class="favorite-product-badge-clickable" data-product-id="{{ $product->id }}" data-user-id="{{ Auth::user()->id }}">
                            <i class="far fa-heart"></i>
                        </span>
                        <span class="favorite-product-badge-active" style="display: none" data-product-id="{{ $product->id }}" data-user-id="{{ Auth::user()->id }}">
                            <i class="fas fa-heart"></i>
                        </span>
                    </div>
                    @endif
                @else
                <div class="favorite-product-badge">
                    <span class="favorite-product-badge-inactive"><i class="fas fa-heart"></i></span>
                </div>
                @endif
                <div class="product-card-image-container">
                    <a href="{{ route('product-detail', [$product->category->alias, $product->sub_category->alias, $product->id]) }}" class="product-card-link">
                        <img class="product-card-image" src="{{ Storage::url($product->image_cover) }}" alt="">
                    </a>
                </div>
                <a href="{{ route('product-detail', [$product->category->alias, $product->sub_category->alias, $product->id]) }}" class="product-card-title">
                    {{ Str::limit($product->title, 22, '...') }}
                </a>
                <p class="product-card-price">
                    @if ( $product->new_price !== null and $product->product_in_sale == 1)
                    {{ $product->new_price }} mdl
                    <sup>{{ $product->price }}</sup>
                    @else
                    {{ $product->price }} mdl @endif
                </p>
                <p class="product-card-loan">@if ($product->loan_terms !== null){{ $product->loan_terms }}@else Стандартные условия кредита @endif</p>
                <button type="button" class="product_card__add_to_cart_btn" data-product_id="{{ $product->id }}">Adauga in cos</button>
            </div>
        @endforeach
    </div>
