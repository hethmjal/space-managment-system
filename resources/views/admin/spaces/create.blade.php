@extends('layouts.app')
@section('title')
{{__('Add Space')}}
@endsection
@section('content')    

    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap align-items-center py-3">
            <div class="card-title">
                <div class=" w-100">
                    <h3 class="card-label bold-text">  {{__('Add Space')}}
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
            <form id="store_form" method="POST" enctype="multipart/form-data" action="{{route('spaces.store')}}">
                @csrf
                <div class="row">
                   
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold" for="name"> {{__('Name')}} </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name">
                        </div>
                    </div>

                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold" for="location"> {{__('Location')}} </label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" name="location">
                        </div>
                    </div>
                   

                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold" for="capacity"> {{__('Capacity')}} </label>
                            <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror" >
                        </div>
                    </div>

                  

                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold" for="type"> {{__('Type')}} </label>
                            <select  class="form-control @error('type') is-invalid @enderror" name="type" >
                                <option value=""></option>
                                <option value="space">Space</option>
                                <option value="training room">Training room</option>
                            </select>
                        </div>
                    </div>

      
      
                    <div class="col-8 col-md-8">
                        <label style="font-weight: bold" for="type"> {{__('Available days')}} </label>
                        
                        <div class="form-group">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <input name="days[]" class="form-control" type="checkbox" value="saturday" id="flexCheckDefault1">
                                    <label class="form-check-label" for="flexCheckDefault1">
                                      Saturday
                                    </label>
                                </div>
                              
                                <div>
                                    <input name="days[]"class="form-control" type="checkbox" value="sunday" id="flexCheckDefault2">
                                    <label class="form-check-label" for="flexCheckDefault2">
                                      Sunday
                                    </label>
                                </div>

                                <div>
                                    <input name="days[]"class="form-control" type="checkbox" value="monday" id="flexCheckDefault3">
                                    <label class="form-check-label" for="flexCheckDefault3">
                                      Monday
                                    </label>
                                </div>

                                <div>
                                    <input name="days[]" class="form-control" type="checkbox" value="tuesday" id="flexCheckDefault4">
                                    <label class="form-check-label" for="flexCheckDefault4">
                                        Tuesday
                                    </label>
                                </div>

                                <div>
                                    <input name="days[]" class="form-control" type="checkbox" value="wednesday" id="flexCheckDefault5">
                                    <label class="form-check-label" for="flexCheckDefault5">
                                        Wednesday
                                    </label>
                                </div>

                                <div>
                                    <input name="days[]" class="form-control" type="checkbox" value="thursday" id="flexCheckDefault6">
                                    <label class="form-check-label" for="flexCheckDefault6">
                                        Thursday
                                    </label>
                                </div>
                              
                            </div>
                         
                           
                            
                        </div>
                    </div>


                   
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary mt-5" > {{__('Add')}} </button>

                    </div>


                   
                    

                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script type="text/javascript">
        
        // store user
        function send(form_id){
            let form = document.getElementById(form_id);
            let formData = new FormData(form);
            $.ajax({
                url: form.action,
                processData: false,
                contentType: false,
                type: 'post',
                data:formData,
                beforeSend: function() {
                    toastr.info("جاري الحفظ ..");
                },
                success: function (data){
                    toastr.clear();
                    if(data.errors){
                        data.errors.forEach(error => {
                            toastr.error(error);
                        });
                    }else{
                        toastr.success('تم');
                    }
                }
            });
        }
        
    </script>
@endsection

