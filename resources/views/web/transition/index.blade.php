@extends('web.layout.app')
@section('title', __('Transitions'))
@section('search')
    @include('web.transition.inc.search')
@endsection
@section('content')
 <!-- Add modal -->
 <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Add transition</button>
 <button type="button" class="btn btn-danger" data-delete="all">All Delete</button>
 <div class="table-responsive" data-table="transitionList">
 </div>

 @include('web.transition.add')
 @include('web.transition.edit')

@endsection
@push('css')
    <link href="{{ url('front/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
@endpush
@push('js')
 <!-- iCheck -->
 <script src="{{url('front/vendors/iCheck/icheck.min.js')}}"></script>

    <script>
        let $addTransition = $('#addTransition');
        let $editTransition = $('#editTransition');

        $(document.body).ready(function(){
            table();
        });

         function table(data = {}){
            $.ajax({
                url: "{{route('transitions.data')}}",
                data: data,
                success: function(response){
                    console.log(response);
                    if(response.table !== undefined){
                        $('[data-table="transitionList"]').html(response.table);
                    }
                }
            })
        }

        //Search
        $(document.body).on('click', ['data-click="search"'], function() {
            table({
                search: $('[name="search"]').val(),
                _token: '{{ csrf_token() }}',
            });
        });
        

var checkState = "";
function countChecked() {
    "all" === checkState && $(".bulk_action input[name='table_records']").iCheck("check"),
    "none" === checkState && $(".bulk_action input[name='table_records']").iCheck("uncheck");
    var e = $(".bulk_action input[name='table_records']:checked").length;
    e ? ($(".column-title").hide(),
    $(".bulk-actions").show(),
    $(".action-cnt").html(e + " Records Selected")) : ($(".column-title").show(),
    $(".bulk-actions").hide())
}
$(".bulk_action input").on("ifChecked", function() {
    checkState = "",
    $(this).parent().parent().parent().addClass("selected"),
    countChecked()
}),
$(".bulk_action input").on("ifUnchecked", function() {
    checkState = "",
    $(this).parent().parent().parent().removeClass("selected"),
    countChecked()
}),
$(".bulk_action input#check-all").on("ifChecked", function() {
    checkState = "all",
    countChecked()
}),
$(".bulk_action input#check-all").on("ifUnchecked", function() {
    checkState = "none",
    countChecked()
})   

        $(document.body).on('click','[data-control="insert"]', function(){
            //console.log('hi')
            $.ajax({
                url: "{{route('transitions.insert')}}",
                method: 'POST',
                data: {
                    name: $addTransition.find('[name="name"]').val(),
                    parent_id : $addTransition.find('[name="parent_id"]').val()
                },
                success: function(response){
                    console.log(response)
                    if(response.status){
                        Swal.fire(
                            'Notification',
                            response.message,
                            'error'
                        ).then(($result) => {
                            $addTransition.modal('hide')
                            table();
                        })
                    }else{
                        Swal.fire(
                            response.message,
                            response.data,
                            'success'
                        ).then(($result) => {
                            $addTransition.modal('hide')
                            table();
                        });
                    }
                }
            });
        });

        $(document.body).on('click','[data-control="edit"]', function(){
            $.ajax({
                url: $(this).data('url'),
                success: function(response){
                    console.log(response)
                    $editTransition.find('[name="id"]').val(response.edit.id)
                    $editTransition.find('[name="name"]').val(response.edit.name)

                    //iwlemir
                    if(response.parent_id != null)
                    $editTransition.find('[name="parent_id"]:selected').val(response.edit.name)
                        
                    $editTransition.modal('show')

                    /*
                    $.each(data.subcategories[0].subcategories,function(index,subcategory){
$('#subcategory').append('<option value="'+subcategory.id+'">'+subcategory.name+'</option>');
})
                    */
                }
            });
        });

        $(document.body).on('click','[data-control="update"]', function(){
            //console.log('hi')
            $.ajax({
                url: "{{route('transitions.update')}}",
                method: 'POST',
                data: {
                    id: $editTransition.find('[name="id"]').val(),
                    name: $editTransition.find('[name="name"]').val(),
                    parent_id : $editTransition.find('[name="parent_id"]').val()
                },
                success: function(response){
                    console.log(response)
                    if(response.status){
                        Swal.fire(
                            'Notification',
                            response.message,
                            'success'
                        ).then(($result) => {
                            $editTransition.modal('hide')
                            table();
                        })
                    }else{
                        Swal.fire(
                            response.message,
                            response.data,
                            'error'
                        ).then(($result) => {
                            $editTransition.modal('hide')
                            table();
                        });
                    }
                }
            });
        });

        $(document.body).on('click','[data-control="delete"]', function(){

                     Swal.fire({
                        title: 'Are you sure?',
                       // text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{route('transitions.delete')}}",
                                method: 'POST',
                                data: {
                                    id: $(this).data('id')        
                                },
                                success: function(response){
                                    console.log(response)
                                    table()
                                    Swal.fire(
                                        'Deleted!',
                                        response.message,
                                        'success'
                                    )
                                }
                            });
                           
                        }
                    })
   
        });



        //ALL DELETE
        

        $(document.body).on('click','[data-delete="all"]', function(){
            var t_ids = [];
            $('.records').each(function(){
                if($(this).is(':checked')){
                    t_ids.push($(this).val())
                }
            })

            if(t_ids.length > 0){
                Swal.fire({
                title: 'Are you sure?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('transitions.all.delete')}}",
                        method: 'POST',
                        data: {
                            tIds : t_ids  
                        },
                        success: function(response){
                            console.log(response)
                            table()
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            )
                        }
                    });
                    
                }
                })
            }

        });
    </script>
@endpush