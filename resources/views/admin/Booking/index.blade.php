@extends('layouts.app')
@section('title')
{{__('Bookings')}}
@endsection
@section('content')    

    <link href="{{asset('assets/control_panel/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    
    <div class="card card-custom gutter-b">
     
        
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
  
         
        <div class="card-header flex-wrap align-items-center py-3">
           
            <div class="card-title">
                
                <div class="d-flex flex-col align-items-start justify-content-between w-100">
                   <div class="mb-4">
                    <h3 class="card-label bold-text d-flex justify-content-start">   {{__('Bookings')}} </h3>

                   </div>
                   <div class="d-flex justify-content-end  ">
                  
                    <div class="form-group mr-3">
                        <label  for="to"> {{__('Search')}} </label>
                        <br>
                        <input oninput="search()" placeholder="search..." type="text" id="search_value">
                    </div>

                        <div class="form-group mr-3">
                            <label for="searchstatus"> {{__('Status')}} </label>
                            <br>
                            <select name="status" id="searchstatus" onchange="search()">
                                <option  value="">choose status</option>
                                <option  value="accepted">accepted</option>
                                <option value="pending">pending</option>
                                <option  value="rejected">rejected</option>
                                <option value="expired">expired</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label  for="searchspace"> {{__('Space')}} </label>
                            <br>
                            <select name="space" id="searchspace" onchange="search()">
                                <option  value="">choose space</option>
                                @foreach ($spaces as $space)
                                    
                             
                                <option  value="{{$space->id}}">{{$space->name}}</option>
                                @endforeach
                            </select>
                        </div>

                       
            </div>

                    
                </div>
                <br>
                

                
            </div>
        
            <div>
                <a href="{{route('bookings.create')}}" class="btn btn-primary">   {{__('Add Book')}} </a>
            </div>
            
        </div>
        <div class="card-body">
            <table class="table table-bordered table-checkable yajra-datatable">
                <thead>
                    <tr>
                        <th></th>

                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Program name') }}</th>
                        <th>{{ __('Space Name') }}</th>
                        <th>{{ __('Days') }}</th>
                        <th>{{ __('Start data') }}</th>
                        <th> {{__("End date")}} </th>
                        <th> {{__("from - to")}} </th>
                        <th> {{__("Status")}} </th>

                        <th></th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @foreach ($bookings as $index => $book)
                   
                    <tr >
                        <td>{{$loop->index+1}}</td>
                        <td>{{$book->name}}</td>
                        <td>{{$book->email}}</td>

                        <td>{{$book->program_name}}</td>

                        <td>{{$book->space->name}}</td>
                        <td>@foreach ($book->days as $day)
                            {{$day}} -
                        @endforeach</td>

                        <td>{{$book->start_date}}</td>
                        <td>{{$book->end_date}}</td>
                        <td>{{$book->from .' - '. $book->to}}</td>
                        <td>
                            <form action="{{route('change-status')}}" id="status" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$book->id}}">
                                <input type="hidden" name="stat{{$index}}" id="stat{{$index}}" value="">
                                <select name="status" id="thestatus{{$index}}" onchange="send('status',{{$index}},{{$book->id}})">
                                    <option @selected($book->status == 'accepted') value="accepted">accepted</option>
                                    <option @selected($book->status == 'pending') value="pending">pending</option>
                                    <option @selected($book->status == 'rejected') value="rejected">rejected</option>
                                    <option @selected($book->status == 'expired') value="expired">expired</option>
                                </select>
                            </form>
                         </td>
                        <td>
                            <div class="d-flex justify-content-center">
                        
                                <div class="">
                                    <a  href="{{route('bookings.edit',$book->id)}}" 
                                        class=" btn btn-sm btn-success success-shadow">
                                        <i class="fa-solid fa-pen px-0"></i>
                                    </a>
                                </div>
                            
                                   

                                <div class="ml-1">   
                                    <form action="{{route('bookings.destroy',$book->id)}}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-sm btn-danger danger-shadow "
                                   >
                                    <i class="fa-solid fa-trash-can  px-0"></i></button>
                                </form>  
                            </div>
                             
                            </div>
                          
                               
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

@endsection
@section('js')
    <script type="text/javascript">
        
        function send(form_id,index,id){
            let selectedValue = $(`#thestatus${index} option:selected`).val();
            let input = document.getElementById('stat'+index);
            console.log("id: "+id);
            console.log("status: " + selectedValue);
            input.value = selectedValue;
     
            $.ajax({
                url:`/changestatus?status=${selectedValue}&id=${id}`,
                processData: false,
                contentType: false,
                type: 'get',
                data:{
                    "status":selectedValue,
                    "id":id,
                    "_token": $('#csrf-token')[0].content
                },
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
                        $('.select2-selection__rendered').html('');
                    }
                }
            });
           
        }

    </script>










<script type="text/javascript">
        
    function search(){
        
      
        
        clearTimeout(this.delay);
   this.delay = setTimeout(function(){
    let status =  $(`#searchstatus option:selected`).val();
        let value =   $(`#search_value`).val();
        let space =  $(`#searchspace option:selected`).val();
    $.ajax({
            url:`/search?status=${status}&value=${value}&space=${space}`,
            processData: false,
            contentType: false,
            type: 'get',
           
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
                    console.log(data['html']);
                    toastr.success('تم');
                    $('#tbody').html("");
                     $('#tbody').append(data['html']);                        
        }
        
    
        }
        }
        )
   }.bind(this), 800);

       
    };







    function searchBySpace(){
        
        let status =  $(`#searchByspace option:selected`).val();
        let email = null;
        let space = null;
     
        $.ajax({
            url:`/search?status=${status}&email=${email}&space=${space}`,
            processData: false,
            contentType: false,
            type: 'get',
           
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
                    console.log(data['html']);
                    toastr.success('تم');
                    $('#tbody').html("");
                     $('#tbody').append(data['html']);                        
        }
        
    
        }
        }
        )
    };
    

</script>
@endsection