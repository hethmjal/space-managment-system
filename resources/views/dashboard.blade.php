@extends('layouts.app')
@section('title')
Dashboard    
@endsection
@section('content')    

    <link href="{{asset('assets/control_panel/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />

    <div class="card card-custom gutter-b text-center">
        
        <div class="card-body ">
            <h1 style="font-weight:bold; font-size: 20px"> 
                {{__("Welcome in Space Booking Managemnet System")}}
            </h1>
            <h4>
            </h4>
            <div class="mt-3 svg-icon svg-icon-primary svg-icon-2x d-flex justify-content-center">
                <img src="{{asset('logo.png')}}" width="430" alt="">
			</div>
        </div>
    </div>

@endsection

@section('js')
@endsection

