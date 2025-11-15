<div class="modal-custom-wrapper" id="modal-custom">
	<div class="modal-custom-body card rounded-0">
		{{-- <div class="modal-custom-header">
			<h2 class="heading">Modal Header</h2>
			<a href="#!" role="button" class="close" aria-label="close this modal">
				<svg viewBox="0 0 24 24">
					<path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z" />
				</svg>
			</a>
		</div> --}}
		<div class="">
            <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="p-0 m-0">@yield('modal_header_text', 'Modal Header Text')</h5>
                <a href="#"><i class="mdi mdi-close"></i></a>
            </div>
            <div class="px-4" style="padding: 30px 10px 45px 10px;">
                @yield('modal_body')
            </div>
        </div>
	</div>
	<a href="#!" class="modal-custom-outside-trigger"></a>
</div>