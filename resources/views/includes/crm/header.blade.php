<style>
	#load{
		width:100%;
		height:100%;
		position:fixed;
		z-index:9999;
		background: url("/loader.gif") no-repeat center center white;
	}
	#print_msg_zip{
        word-break: break-all;
    }
	.toast .toast-message {
		padding-right: 40px;
	}
</style>
<script>
	document.onreadystatechange = function () {
	var state = document.readyState;
	if (state == 'interactive') {
		 document.getElementById('contents').style.visibility="hidden";
	} else if (state == 'complete') {
		setTimeout(function(){
		   document.getElementById('interactive');
		   document.getElementById('load').style.visibility="hidden";
		   document.getElementById('contents').style.visibility="visible";
		},10);
	}
  }
</script>

<base href="">
		<meta charset="utf-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<meta name="description" content="Metronic admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="shortcut icon" href="{{asset('images/logo.png')}}" type="image/x-icon">	
		<link rel="canonical" href="https://keenthemes.com/metronic" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	
		<!-- <link rel="stylesheet" href="{{asset('assets/control_panel/local/css/all.min.css')}}" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
		
		<!--begin::Fonts-->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Tajawal&display=swap" rel="stylesheet">
		<!--end::Fonts-->
		
{{-- 
		@if(App::getLocale() == 'ar')
	<!--begin::Page Vendors Styles(used by this page)-->
	<link href="{{asset('assets/control_panel/plugins/custom/fullcalendar/fullcalendar.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
	<!--end::Page Vendors Styles-->
	<!--begin::Global Theme Styles(used by all pages)-->
	<link href="{{asset('assets/control_panel/plugins/global/plugins.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/control_panel/plugins/custom/prismjs/prismjs.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/control_panel/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
	<!--end::Global Theme Styles-->
	<!--begin::Layout Themes(used by all pages)-->
	<link href="{{asset('assets/control_panel/css/themes/layout/header/base/light.rtl.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/control_panel/css/themes/layout/header/menu/light.rtl.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/control_panel/css/themes/layout/brand/dark.rtl.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/control_panel/css/themes/layout/aside/dark.rtl.css')}}" rel="stylesheet" type="text/css" />
	<!--end::Layout Themes-->
		@else --}}
			<!--begin::Page Vendors Styles(used by this page)-->
			<link href="{{asset('assets/control_panel/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
			<!--end::Page Vendors Styles-->
			<!--begin::Global Theme Styles(used by all pages)-->
			<link href="{{asset('assets/control_panel/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
			<link href="{{asset('assets/control_panel/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css" />
			<link href="{{asset('assets/control_panel/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
			<!--end::Global Theme Styles-->
			<!--begin::Layout Themes(used by all pages)-->
			<link href="{{asset('assets/control_panel/css/themes/layout/header/base/light.css')}}" rel="stylesheet" type="text/css" />
			<link href="{{asset('assets/control_panel/css/themes/layout/header/menu/light.css')}}" rel="stylesheet" type="text/css" />
			<link href="{{asset('assets/control_panel/css/themes/layout/brand/dark.css')}}" rel="stylesheet" type="text/css" />
			<link href="{{asset('assets/control_panel/css/themes/layout/aside/dark.css')}}" rel="stylesheet" type="text/css" />
			<!--end::Layout Themes-->
	
		 

		<link href="{{asset('assets/control_panel/css/app.css')}}" rel="stylesheet" type="text/css" />


		<!-- Start Select All Buttons cdn -->
		<link href="{{asset('assets/control_panel/js/select2_1.min.css')}}" rel="stylesheet">
		<script src="{{asset('assets/control_panel/js/jquery-3.3.1.min.js')}}"></script>
		<script src="{{asset('assets/control_panel/js/pages/crud/forms/widgets/select2.js')}}"></script>
		<link href="{{asset('assets/control_panel/js/select2.min.css')}}" rel="stylesheet">