<style>
    .cat-list-wrapper {
        display: flex;
        align-items: center;
        position: relative;
    }
    .cat-list {
        margin: 0 5px;
        padding: 0;
        list-style: none;
        white-space: nowrap;
        width: 100%;
        overflow: hidden;
        display: flex;
        scroll-behavior: smooth;
    }
    .cat-list li {
        display: inline-block;
    }
    .cat-list li a {
        color: #333;
        font-weight: 500;
        padding: 7px 15px;
    }
    .scroll-btn {
        background: transparent;
        border: none;
        color: #a7a7a7;
        z-index: 10;
    }
</style>

<header class="header">
		<!--Desktop Header-->
		<div class="header-desktop">
			<div class="container-fluid px-5">
				<div class="row">
					<div class="col-lg-2">
						<div class="logo">
							<a href="{{ url('/') }}">
                                <img src="https://shop.playoffz.in/public/media/09022025054603-400x400-PlayOffz Store logo (1).png" alt="logo">
{{--								<img src="{{ $gtext['front_logo'] ? asset('public/media/'.$gtext['front_logo']) : asset('public/frontend/images/logo.png') }}" alt="logo">--}}
							</a>
						</div>
					</div>
                    <div class="col-lg-8 align-self-center">
                        <div class="cat-list-wrapper">
                            <button class="scroll-btn left" onclick="scrollList(-1)"><i class="bi bi-chevron-left"></i></button>
                            <ul class="cat-list" id="cat-list">
                                @foreach(CategoryList() as $cat)
                                    <li>
                                        <a href="">{{$cat->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <button class="scroll-btn right" onclick="scrollList(1)"><i class="bi bi-chevron-right"></i></button>
                        </div>
                    </div>
					<div class="col-lg-2">
						<ul class="head-round-icon">
							<li>
								<a href="#">
									<i class="bi bi-search"></i>
								</a>
							</li>
                            <li>
								<a href="{{ route('frontend.login') }}">
									<i class="bi bi-person"></i>
								</a>
							</li>
                            <li>
								<a href="{{ route('frontend.wishlist') }}">
									<i class="bi bi-heart"></i>
									<span class="cart_count count_wishlist">0</span>
								</a>
							</li>
							<li class="shopingCart">
								<a href="javascript:void(0);" class="CartShowHide">
									<i class="bi bi-cart"></i>
									<span class="cart_count total_qty">0</span>
								</a>
								<div class="shoping-cart-card headerShopingCart">
									<div class="empty_card has_item_empty">
										<div class="empty_img">
											<img src="{{ asset('public/frontend/images/empty.png') }}" />
										</div>
										<h3>{{ __('Your cart is empty!') }}</h3>
									</div>

									<div class="shoping-cart-body has_cart_item">
										<ul class="cart_list" id="tp_cart_data"></ul>
									</div>

									<div class="shoping-cart-footer has_cart_item">
										<p>{{ __('Subtotal') }}<span class="sub_total">0</span></p>
										<p>{{ __('Tax') }}<span class="tax">0</span></p>
										<h6>{{ __('Total') }}<span class="tp_total">0</span></h6>
										<a href="{{ route('frontend.cart') }}" class="btn view-cart-btn">{{ __('View Cart') }}</a>
										<a href="{{ route('frontend.checkout') }}" class="btn checkout-btn">{{ __('Checkout') }}</a>
									</div>

								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div><!--/Desktop Header/-->

		<!--Mobile Header-->
		<div class="header-mobile" id="sticky-header">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="header-mobile-card">
							<div class="bars-search-card">
								<ul class="head-round-icon">
									<li class="off-canvas-btn">
										<a href="javascript:void(0);"><i class="bi bi-list"></i></a>
									</li>
									<li class="off-canvas-btn">
										<a href="javascript:void(0);"><i class="bi bi-search"></i></a>
									</li>
								</ul>
							</div>
							<div class="logo-card">
								<div class="logo">
									<a href="{{ url('/') }}">
										<img src="{{ $gtext['front_logo'] ? asset('public/media/'.$gtext['front_logo']) : asset('public/frontend/images/logo.png') }}" alt="logo">
									</a>
								</div>
							</div>
							<div class="head-round-card">
								<ul class="head-round-icon">
									<li>
										<a href="{{ route('frontend.wishlist') }}">
											<i class="bi bi-heart"></i>
											<span class="cart_count count_wishlist">0</span>
										</a>
									</li>
									<li class="shopingCart">
										<a href="javascript:void(0);" class="CartShowHide">
											<i class="bi bi-cart"></i>
											<span class="cart_count total_qty">0</span>
										</a>
										<div class="shoping-cart-card headerShopingCart">

											<div class="empty_card has_item_empty">
												<div class="empty_img">
													<img src="{{ asset('public/frontend/images/empty.png') }}" />
												</div>
												<h3>{{ __('Your cart is empty!') }}</h3>
											</div>

											<div class="shoping-cart-body has_cart_item">
												<ul class="cart_list" id="tp_cart_data_for_mobile"></ul>
											</div>

											<div class="shoping-cart-footer has_cart_item">
												<p>{{ __('Subtotal') }}<span class="sub_total">0</span></p>
												<p>{{ __('Tax') }}<span class="tax">0</span></p>
												<h6>{{ __('Total') }}<span class="tp_total">0</span></h6>
												<a href="{{ route('frontend.cart') }}" class="btn view-cart-btn">{{ __('View Cart') }}</a>
												<a href="{{ route('frontend.checkout') }}" class="btn checkout-btn">{{ __('Checkout') }}</a>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!--/Mobile Header/-->
	</header>

	<!-- off-canvas menu start -->
	<aside class="mobile-menu-wrapper">
		<div class="off-canvas-overlay"></div>
		<div class="offcanvas-body">
			<div class="offcanvas-top">
				<div class="offcanvas-btn-close">
					<i class="bi bi-x-lg"></i>
				</div>
			</div>
			<div class="search-for-mobile">
				<form method="GET" action="{{ route('frontend.search') }}">
					<input name="search" type="text" class="form-control" placeholder="{{ __('Search for Products') }}..." required />
					<button type="submit" class="btn theme-btn"><i class="bi bi-search"></i>{{ __('Search') }}</button>
				</form>
			</div>
			<div class="mobile-navigation">
				<nav>
					<ul class="mobile-menu">
						<li class="has-children-menu"><a href="#">{{ __('Browse Categories') }}</a>
							<ul class="dropdown">
								@php echo CategoryListForMobile(); @endphp
							</ul>
						</li>
						@php echo HeaderMenuList('HeaderMenuListForMobile'); @endphp
					</ul>
				</nav>
			</div>
		</div>
	</aside>
	<!-- /off-canvas menu start -->


<script>
    function scrollList(direction) {
        const list = document.getElementById('cat-list');
        const scrollAmount = 100;
        list.scrollLeft += direction * scrollAmount;
    }
</script>

