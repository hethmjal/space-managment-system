<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bokking system</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
     
    </head>
    <body class="">
        <div class="container">
          
            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="d-flex justify-content-center">
                   <img src="{{asset('logo.png')}}" width="200" alt="">
                 

                </div>

                <div class="d-flex justify-content-center">
                    @if($errors->any())
                    <div class="alert alert-danger">
                      <ul>
                        @foreach ($errors->all() as $err)
                            <li>{{$err}}</li>
                        @endforeach
                      </ul>
                    </div>
                    @endif
                @if(session('success'))
                <div class="alert alert-success" role="alert">
                  {{session('success')}}
                
                </div>    
                  @endif
                  @if(session('error'))
                  <div class="alert alert-danger" role="alert">
                    {{session('error')}}
                  
                  </div>    
                    @endif
                </div>
                <div class=" d-flex justify-content-center">
               

                    <div class="card card-custom gutter-b col-md-6">
                        <div class="card-body">
                            <form id="store_form" method="POST" enctype="multipart/form-data" action="{{route('user.book.store')}}">
                                @csrf
                                <div class="row">
                
                                    <div class="col-12 col-md-12 mb-2">
                                        <div class="form-group">
                                            <label style="font-weight: bold" for="space_id"> {{__('Spaces')}} </label>
                
                                            <select class="form-control" name="space_id" id="space_id">
                                                <option value="">choose space</option>

                                                @foreach ($spaces as $space)
                                                @php
                                                    $days= $space->availability;
                                                @endphp
                                                    <option class="space_id" value="{{$space->id}}">{{$space->name}} - <small>{{$days[0]}} to {{end($days)}}</small></option>
                                                   
                                                @endforeach
                                            </select>
                
                                        </div>
                                    </div>

                                    
                    <div class="col-12 col-md-12 mb-2">
                        <label style="font-weight: bold" for="type"> {{__('Available days')}} </label>
                        
                        <div class="form-group">
                            <div id="days" class="d-flex justify-content-arround">
                              
                              
                               

                               
                              
                              
                            </div>
                         
                           
                            
                        </div>
                    </div>


                
                                    <div class="col-12 col-md-12 mb-2">
                                        <div class="form-group">
                                            <label style="font-weight: bold" for="name"> {{__('Name')}} </label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name">
                                        </div>
                                    </div>
                
                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            <label style="font-weight: bold" for="email"> {{__('Email')}} </label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email">
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-12 mb-2">
                                        <div class="form-group">
                                            <label style="font-weight: bold" for="program_name"> {{__('program name')}} </label>
                                            <input type="text" class="form-control @error('program_name') is-invalid @enderror" name="program_name">
                                        </div>
                                    </div>
                                   
                
                                    <div class="col-12 col-md-12 mb-2">
                                        <div class="form-group">
                                            <label style="font-weight: bold" for="start_date"> {{__('Start  date')}} </label>
                                            <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" >
                                        </div>
                                    </div>
                
                                    <div class="col-12 col-md-12 mb-2">
                                        <div class="form-group">
                                            <label style="font-weight: bold" for="end_date"> {{__('End date')}} </label>
                                            <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" >
                                        </div>
                                    </div>
                
                                    <div class="col-12 col-md-12 mb-2">
                                        <div class="form-group">
                                            <label style="font-weight: bold" for="from"> {{__('From')}} </label>
                                            <input type="time" name="from" class="form-control @error('from') is-invalid @enderror" >
                                        </div>
                                    </div>
                
                
                                    <div class="col-12 col-md-12 mb-2">
                                        <div class="form-group">
                                            <label style="font-weight: bold" for="to"> {{__('To')}} </label>
                                            <input type="time" name="to" class="form-control @error('to') is-invalid @enderror" >
                                        </div>
                                    </div>
                
                
                
                                   
                                    <div class="col-md-12 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary mt-5" > {{__('Book')}} </button>
                
                                    </div>
                
                
                                   
                                    
                
                                </div>
                            </form>
                        </div>
                    </div>
                    


                </div>

                

            </div>
        </div>
       
        <script>
               $('#space_id').on('change', function() {
        $.ajax({
                url: `/getDays/${this.value}`,
                processData: false,
                contentType: false,
                type: 'get',
                success: function (data){
                    if(data.errors){
                        data.errors.forEach(error => {
                        });
                    }else{
                        $('#days').html("");
                        for (let index = 0; index < data.length; index++) {
                            text = `<div class="m-1">
                                    <input name="days[]" class="" type="checkbox" value="${data[index]}" 
                                    id="${index}">
                                    <label class="" 
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
    </body>
</html>
