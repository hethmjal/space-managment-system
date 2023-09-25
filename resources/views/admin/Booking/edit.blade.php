@extends('layouts.app')
@section('title')
{{__('Booking')}}
@endsection
@section('content')    

    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap align-items-center py-3">
            <div class="card-title">
                <div class=" w-100">
                    <h3 class="card-label bold-text">  {{__('Book')}}
                    </h3>
                    @if($errors->any())
                    <div class="alert alert-danger">
                      <ul>
                        @foreach ($errors->all() as $err)
                            <li>{{$err}}</li>
                        @endforeach
                      </ul>
                    </div>
                    @endif
                  
                </div>
                
            </div>
        </div>
        <div class="card-body">
            <form id="store_form" method="POST" enctype="multipart/form-data" action="{{route('bookings.update',$book->id)}}">
                @csrf
                @method("PUT")
                <div class="row">

                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold" for="space_id"> {{__('Spaces')}} </label>

                            <select class="form-control" name="space_id" id="space_id">
                                @foreach ($spaces as $space)
                                @php
                                    $days= $space->availability;
                                @endphp
                                    <option @selected($space->id == $book->space_id) value="{{$space->id}}">{{$space->name}} </option>
                                   
                                @endforeach
                            </select>

                        </div>
                    </div>

                    <div class="col-8 col-md-12">
                        <label style="font-weight: bold" for="type"> {{__('Available days')}} </label>
                        
                        <div class="form-group">
                            <div id="days" class="d-flex justify-content-arround">
                              
                              @foreach ($book->space->availability as $index => $day)
                                  
                           
                                <div class="mr-4">
                                    <input @checked(in_array($day,$book->days)) name="days[]" class="form-control" type="checkbox" value="{{$day}}" 
                                    id="{{$index}}">
                                    <label class="form-check-label" 
                                    for="${index}">
                                       {{$day}}
                                    </label>
                                </div>

                                @endforeach
                              
                              
                            </div>
                         
                           
                            
                        </div>
                    </div>

                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold" for="name"> {{__('Name')}} </label>
                            <input type="text" value="{{$book->name}}"  class="form-control @error('name') is-invalid @enderror" name="name">
                        </div>
                    </div>

                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold" for="email"> {{__('Email')}} </label>
                            <input type="email" value="{{$book->email}}" class="form-control @error('email') is-invalid @enderror" name="email">
                        </div>
                    </div>

                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold" for="program_name"> {{__('program name')}} </label>
                            <input type="text" value="{{$book->program_name}}" class="form-control @error('program_name') is-invalid @enderror" name="program_name">
                        </div>
                    </div>
                   

                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold" for="start_date"> {{__('Start  date')}} </label>
                            <input type="date" value="{{$book->start_date}}" name="start_date" class="form-control @error('start_date') is-invalid @enderror" >
                        </div>
                    </div>

                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold" for="end_date"> {{__('End date')}} </label>
                            <input type="date" value="{{$book->end_date}}" name="end_date" class="form-control @error('end_date') is-invalid @enderror" >
                        </div>
                    </div>

                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold" for="from"> {{__('From')}} </label>
                            <input type="time" value="{{$book->from}}" name="from" class="form-control @error('from') is-invalid @enderror" >
                        </div>
                    </div>


                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold" for="to"> {{__('To')}} </label>
                            <input type="time" value="{{$book->to}}" name="to" class="form-control @error('to') is-invalid @enderror" >
                        </div>
                    </div>



                   
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary mt-5" > {{__('Edit Book')}} </button>

                    </div>


                   
                    

                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
<script>
     $('#space_id').on('change', function() {
        $.ajax({
                url: `/getDays/${this.value}`,
                processData: false,
                contentType: false,
                type: 'get',
                success: function (data){
                    toastr.clear();
                    if(data.errors){
                        data.errors.forEach(error => {
                            toastr.error(error);
                        });
                    }else{
                        $('#days').html("");
                        for (let index = 0; index < data.length; index++) {
                            text = `<div class="mr-4">
                                    <input name="days[]" class="form-control" type="checkbox" value="${data[index]}" 
                                    id="${index}">
                                    <label class="form-check-label" 
                                    for="${index}">
                                        ${data[index]}
                                    </label>
                                </div>`
                            $('#days').append(text);
                        }
                       
                    }
                }
            });
     });

</script>
@endsection