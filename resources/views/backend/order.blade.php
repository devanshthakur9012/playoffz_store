@extends('layouts.backend')

@section('title', __('Order'))
@php $gtext = gtext(); @endphp
@section('content')
<!-- main Section -->
<div class="main-body">
	<div class="container-fluid">
		@php $vipc = vipc(); @endphp
		@if($vipc['bkey'] == 0) 
		@include('backend.partials.vipc')
		@else
		<div class="row mt-25">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body">
					<ul class="status_list">
						<li class="order_no_date"><strong>{{ __('Order#') }}</strong>: {{ $mdata->order_no }}</li>
						<li class="order_no_date"><strong>{{ __('Order Date') }}</strong>: {{ date('d-m-Y', strtotime($mdata->created_at)) }}</li>
						<li class="order_no_date"><strong>{{ __('Payment Method') }}</strong>: {{ $mdata->method_name }}</li>
						<li id="payment_status_class" class="pstatus_{{ $mdata->payment_status_id }}"><strong>{{ __('Payment Status') }}</strong>: <span id="pstatus_name">{{ $mdata->pstatus_name }}</span></li>
						<li id="order_status_class" class="ostatus_{{ $mdata->order_status_id }}"><strong>{{ __('Order Status') }}</strong>: <span id="ostatus_name">{{ $mdata->ostatus_name }}</span></li>
					</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-25">
			<div class="col-lg-8">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table order">
								<thead>
									<tr>
										<th style="width:70%">{{ __('Product') }}</th>
										<th class="text-center" style="width:15%">{{ __('Price') }}</th>
										<th class="text-right" style="width:15%">{{ __('Total') }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach($datalist as $row)
									@php
										if($gtext['currency_position'] == 'left'){
											$price = $gtext['currency_icon'].NumberFormat($row->price);
											$total_price = $gtext['currency_icon'].NumberFormat($row->total_price);
										}else{
											$price = NumberFormat($row->price).$gtext['currency_icon'];
											$total_price = NumberFormat($row->total_price).$gtext['currency_icon'];
										}
				
										if($row->variation_size == '0'){
											$size = '';
										}else{
											$size = $row->quantity.' '.$row->variation_size;
										}
										
									@endphp
									<tr>
										<td>
											<h5>{{ $row->title }}</h5>
											<p>@php echo $size @endphp</p>
										</td>
										<td class="text-center">{{ $price }} x {{ $row->quantity }}</td>
										<td class="text-right">{{ $total_price }}</td>
									</tr>
									@endforeach
									
									@php
										$total_amount_shipping_fee = $mdata->total_amount+$mdata->shipping_fee+$mdata->tax;
										
										if($gtext['currency_position'] == 'left'){
											$shipping_fee = $gtext['currency_icon'].NumberFormat($mdata->shipping_fee);
											$tax = $gtext['currency_icon'].NumberFormat($mdata->tax);
											$discount = $gtext['currency_icon'].NumberFormat($mdata->discount);
											$subtotal = $gtext['currency_icon'].NumberFormat($mdata->total_amount);
											$total_amount = $gtext['currency_icon'].NumberFormat($total_amount_shipping_fee);
										}else{
											$shipping_fee = NumberFormat($mdata->shipping_fee).$gtext['currency_icon'];
											$tax = NumberFormat($mdata->tax).$gtext['currency_icon'];
											$discount = NumberFormat($mdata->discount).$gtext['currency_icon'];
											$subtotal = NumberFormat($mdata->total_amount).$gtext['currency_icon'];
											$total_amount = NumberFormat($total_amount_shipping_fee).$gtext['currency_icon'];
										}
									@endphp
										
									<tr>
										<td>{{ $mdata->shipping_title }}: {{ $shipping_fee }}</td>
										<td><strong>{{ __('Shipping Fee') }}</strong></td>
										<td class="text-right"><strong>{{ $shipping_fee }}</strong></td>
									</tr>
									<tr>
										<td></td>
										<td><strong>{{ __('Tax') }}</strong></td>
										<td class="text-right"><strong>{{ $tax }}</strong></td>
									</tr>
									<tr>
										<td></td>
										<td><strong>{{ __('Subtotal') }}</strong></td>
										<td class="text-right"><strong>{{ $subtotal }}</strong></td>
									</tr>
									<tr>
										<td></td>
										<td><strong>{{ __('Total') }}</strong></td>
										<td class="text-right"><strong>{{ $total_amount }}</strong></td>
									</tr>
									
								</tbody>
							</table>
						</div>
						
						<form novalidate="" data-validate="parsley" id="DataEntry_formId">
						<div class="row mt-25">
							<div class="col-lg-4">
								<div class="form-group">
									<label for="payment_status_id">{{ __('Payment Status') }}<span class="red">*</span></label>
									<select name="payment_status_id" id="payment_status_id" class="chosen-select form-control">
									@foreach($payment_status_list as $row)
										<option {{ $row->id == $mdata->payment_status_id ? "selected=selected" : '' }} value="{{ $row->id }}">
											{{ $row->pstatus_name }}
										</option>
									@endforeach
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label for="order_status_id">{{ __('Order Status') }}<span class="red">*</span></label>
									<select name="order_status_id" id="order_status_id" class="chosen-select form-control">
									@foreach($order_status_list as $row)
										<option {{ $row->id == $mdata->order_status_id ? "selected=selected" : '' }} value="{{ $row->id }}">
											{{ $row->ostatus_name }}
										</option>
									@endforeach
									</select>
								</div>
							</div>
							<div class="col-lg-4"></div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="tw_checkbox checkbox_group">
									<input id="isnotify" name="isnotify" type="checkbox">
									<label for="isnotify">{{ __('Send confirmation email to customer') }}</label>
									<span></span>
								</div>
							</div>
						</div>
						<div class="row mt-25">
							<div class="col-lg-12">
								<input class="dnone" id="order_master_id" name="order_master_id" type="text" value="{{ $mdata->id }}" />
								<a id="submit-form" href="javascript:void(0);" class="btn btn-theme mr-10 update_btn">{{ __('Update') }}</a>
								<a href="{{ route('frontend.order-invoice', [$mdata->id, $mdata->order_no]) }}" class="btn btn-theme mr-10">{{ __('Invoice Download') }}</a>
								<a href="{{ route('backend.orders') }}" class="btn warning-btn"><i class="fa fa-reply"></i> {{ __('Back to List') }}</a>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card">
					<div class="card-header">{{ __('Customer') }}</div>
					<div class="card-body">
						@if ($mdata->customer_id != '')
						<p>{{ $mdata->name }}</p>
						@else
						<p>{{ __('Guest User') }}</p>
						@endif
					</div>
				</div>
				<div class="card mt-25">
					<div class="card-header">{{ __('Store') }}</div>
					<div class="card-body">
						@if ($mdata->shop_name != '')
						<p><a href="{{ route('frontend.stores', [$mdata->seller_id, str_slug($mdata->shop_url)]) }}" target="_blank">{{ $mdata->shop_name }}</a></p>
						@endif
					</div>
				</div>
				<div class="card mt-25">
					<div class="card-header">{{ __('Shipping Information') }}</div>
					<div class="card-body">
						@if ($mdata->customer_name != '')
						<p><strong>{{ __('Name') }}</strong>: {{ $mdata->customer_name }}</p>
						@endif
						
						@if ($mdata->customer_email != '')
						<p><strong>{{ __('Email') }}</strong>: {{ $mdata->customer_email }}</p>
						@endif
						
						@if ($mdata->customer_phone != '')
						<p><strong>{{ __('Phone') }}</strong>: {{ $mdata->customer_phone }}</p>
						@endif
						
						@if ($mdata->country != '')
						<p><strong>{{ __('Country') }}</strong>: {{ $mdata->country }}</p>
						@endif
						
						@if ($mdata->state != '')
						<p><strong>{{ __('State') }}</strong>: {{ $mdata->state }}</p>
						@endif
						
						@if ($mdata->zip_code != '')
						<p><strong>{{ __('Zip Code') }}</strong>: {{ $mdata->zip_code }}</p>
						@endif
						
						@if ($mdata->city != '')
						<p><strong>{{ __('City') }}</strong>: {{ $mdata->city }}</p>
						@endif
						
						@if ($mdata->customer_address != '')
						<p><strong>{{ __('Address') }}</strong>: {{ $mdata->customer_address }}</p>
						@endif
						
						@if ($mdata->comments != '')
						<p><strong>{{ __('Comments') }}</strong>: {{ $mdata->comments }}</p>
						@endif
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>
</div>
<!-- /main Section -->
@endsection

@push('scripts')
<!-- css/js -->

<script type="text/javascript">
var TEXT = [];
	TEXT['Please select action'] = "{{ __('Please select action') }}";
	TEXT['Please select record'] = "{{ __('Please select record') }}";
</script>
<script src="{{asset('backend/pages/orders.js')}}"></script>
@endpush