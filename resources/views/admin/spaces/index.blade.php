@extends('layouts.app')
@section('title')
{{__('Spaces')}}
@endsection
@section('content')    

    <link href="{{asset('assets/control_panel/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />

    <div class="card card-custom gutter-b">
     
        
        @if(session('success'))
        <div class="alert alert-success" role="alert">
          {{session('success')}}
        
        </div>    
          @endif
  
  
        <div class="card-header flex-wrap align-items-center py-3">

            
            <div class="card-title">
                
                <div class="d-flex align-items-center justify-content-between w-100">
                    <h3 class="card-label bold-text">   {{__('Spaces')}} </h3>
                </div>
            </div>
            <div>
                <a href="{{route('spaces.create')}}" class="btn btn-primary">   {{__('Add Space')}} </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-checkable yajra-datatable">
                <thead>
                    <tr>
                        <th></th>
                        <th>{{ __('Space Name') }}</th>
                        <th>{{ __('Availability') }}</th>
                        <th> {{__("Location")}} </th>
                        <th> {{__("Capacity")}} </th>
                        <th> {{__("Type")}} </th>

                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($spaces as $space)
                    @php
                        $days = $space->availability;
                    @endphp
                        <a href="" style="color:rgb(248, 197, 197)"></a>
                    <tr >
                        <td>{{$loop->index+1}}</td>
                        <td>{{$space->name}}</td>
                        <td>{{$space->availability[0]}} to {{end($days)}}</td>
                        <td>{{$space->location}}</td>
                        <td>{{$space->capacity}}</td>
                        <td>{{$space->type}}</td>

                        <td>
                            <div class="d-flex justify-content-center">
                        
                                <div class="">
                                    <a  href="{{route('spaces.edit',$space->id)}}" class=" btn btn-sm btn-success success-shadow">
                                        <i class="fa-solid fa-pen px-0"></i>
                                    </a>
                                </div>
                            
                                   

                                <div class="ml-1">   <form action="{{route('spaces.destroy',$space->id)}}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-sm btn-danger danger-shadow "
                                    href="/employee/'.$row->id.'/edit">
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
        

     

        function deleteRow(id){
            swal({
                title: "هل أنت متأكد؟",
                text: "سيتم  الحذف !",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: {
                    confirm: "تأكيد",
                    cancel: "إغلاق",
                },
                closeOnConfirm: false,
                closeOnCancel: false
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "/leave-types/" + id,
                        type: 'delete',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (data){
                            toastr.clear();
                            if(data.errors){
                                data.errors.forEach(error => {
                                    toastr.error(error);
                                });
                            }else{
                                toastr.success('تم');
                                location.reload()

                            }
                        }
                    });
                    swal("تم الحذف بنجاح", {
                    icon: "success",
                    });
                }
            });
        }

    </script>
@endsection

