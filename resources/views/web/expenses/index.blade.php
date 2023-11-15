@extends('web.layout.app')
@section('title', __('Expenses'))
@section('search')
    @include('web.expenses.inc.search')
@endsection
@section('content')
 <!-- Add modal -->
 <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Add Expenses</button>
 <button type="button" class="btn btn-danger" data-delete="all">All Delete</button>
 <div class="table-responsive" data-table="expensesList">
 </div>

 @include('web.expenses.add')
 @include('web.expenses.edit')

@endsection
@push('css')
    <link href="{{ url('front/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
@endpush
@push('js')
 <!-- iCheck -->
 <script src="{{url('front/vendors/iCheck/icheck.min.js')}}"></script>

    <script>
        let $addExpenses = $('#addExpenses');
        let $editdExpenses = $('#editExpenses');

        var data = {
        _token: '{{ csrf_token() }}',
        };
        

         function table(data = {}){
            $.ajax({
                url: "{{route('expenses.data')}}",
                data: data,
                success: function(response){
                    console.log(response);
                    if(response.table !== undefined){
                        $('[data-table="expensesList"]').html(response.table);
                    }
                }
            })
        }

        $(document.body).ready(function(){
            table(data);
        });

        //Search
        $(document.body).on('click', '[data-click="search"]', function() {
           data.search = $('[name="search"]').val()
           console.log(data)
           table(data)
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
                url: "{{route('expenses.insert')}}",
                method: 'POST',
                data: {
                    name: $addExpenses.find('[name="name"]').val(),
                    parent_id : $addExpenses.find('[name="parent_id"]').val()
                },
                success: function(response){
                    console.log(response)
                    if(response.status){
                        Swal.fire(
                            'Notification',
                            response.message,
                            'error'
                        ).then(($result) => {
                            $addExpenses.modal('hide')
                            table();
                        })
                    }else{
                        Swal.fire(
                            response.message,
                            response.data,
                            'success'
                        ).then(($result) => {
                            $addExpenses.modal('hide')
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
                    $editdExpenses.find('[name="id"]').val(response.edit.id)
                    $editdExpenses.find('[name="name"]').val(response.edit.name)

                    //iwlemir
                    if(response.parent_id != null)
                    $editdExpenses.find('[name="parent_id"]:selected').val(response.edit.name)
                        
                    $editdExpenses.modal('show')

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
                url: "{{route('expenses.update')}}",
                method: 'POST',
                data: {
                    id: $editdExpenses.find('[name="id"]').val(),
                    name: $editdExpenses.find('[name="name"]').val(),
                    parent_id : $editdExpenses.find('[name="parent_id"]').val()
                },
                success: function(response){
                    console.log(response)
                    if(response.status){
                        Swal.fire(
                            'Notification',
                            response.message,
                            'success'
                        ).then(($result) => {
                            $editdExpenses.modal('hide')
                            table();
                        })
                    }else{
                        Swal.fire(
                            response.message,
                            response.data,
                            'error'
                        ).then(($result) => {
                            $editdExpenses.modal('hide')
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
                                url: "{{route('expenses.delete')}}",
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
                        url: "{{route('expenses.all.delete')}}",
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