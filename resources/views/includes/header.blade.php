<div id="kt_header" class="header header-fixed">
						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-center justify-content-between">
							<!--begin::Header Menu Wrapper-->
							<div style="display: flex">
								
							</div>
							<!--end::Header Menu Wrapper-->
							<!--begin::Topbar-->
							<div class="m-auto text-center">
								 
								</div>
                        
							<div class="topbar">
								<div id="loading-spinner" class="spinner spinner-primary spinner-lg mr-15"></div>
								
								<!--begin::User-->
								<div class="topbar-item">
									<div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
										<span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">{{__('Hi')}},</span>
										<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{auth()->user()->name}}</span>
										<span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
											<span class="symbol-label font-size-h5 font-weight-bold"> {{Str::upper(substr(Auth::user()->name,0,2)) }} </span>
										</span>
									</div>
								</div>
								<!--end::User-->
							</div>
							<!--end::Topbar-->
						</div>
						<!--end::Container-->
					</div>