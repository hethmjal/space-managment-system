@extends('layouts.app')
@section('title')
{{__('Show Request')}}
@endsection
@section('content')    

    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap align-items-center py-3">
            <div class="card-title">
                <div class="w-100">
                    <h3 class="card-label bold-text">  {{__('Show Space')}}
                    </h3>
        
                </div>
            </div>
            <div>
                <a href="{{route('spaces.index')}}" class="btn btn-primary">   {{__('Back')}} </a>
            </div>
        </div>
        <div class="card-body">
         
                <div class="row">

                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold" for="note"> {{__('Name')}}: </label>
                            <div> {{$space->name}}  </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold" for="note"> {{__('Description')}}: </label>
                            <div> {{$space->description}}  </div>
                        </div>
                    </div>


                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold" for="note"> {{__('Capacity')}}: </label>
                            <div> {{$space->capacity}}  </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold" for="note"> {{__('Price ')}}: </label>
                            <div> {{$space->price}}  </div>
                        </div>
                    </div>





              







                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold" for="note"> {{__('Images')}}: </label>
                            <div>
                                <ul>
                                   
                                   
                                    
                                </ul>
                            </div>
                        </div>
                    </div>


                  

            
      
                   

                   
                
                </div>
           
        </div>
    </div>

<script>currentSlide(1)</script>
@endsection



