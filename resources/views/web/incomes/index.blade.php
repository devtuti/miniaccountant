@extends('web.layout.app')
@section('title', __('Incomes'))
@section('search')
    @include('web.incomes.inc.search')
@endsection
@section('content')
 <!-- Add modal -->
 <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Add income</button>
 <button type="button" class="btn btn-danger" data-delete="all">All Delete</button>

 <div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align">First date 
    </label>
    <div class="col-md-6 col-sm-6 ">
        <input id="firstdate" class="date-picker form-control" data-click="firstdate" placeholder="dd-mm-yyyy" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" name="firstdate">
        <script>
            function timeFunctionLong(input) {
                setTimeout(function() {
                    input.type = 'text';
                }, 2000);
            }
        </script>
    </div>
</div>

<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align">Last date 
    </label>
    <div class="col-md-6 col-sm-6 ">
        <input id="lastdate" class="date-picker form-control" data-click="lastdate" placeholder="dd-mm-yyyy" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong2(this)" name="lastdate">
        <script>
            function timeFunctionLong2(input) {
                setTimeout(function() {
                    input.type = 'text';
                }, 2000);
            }
        </script>
    </div>
</div>
 <div class="table-responsive" data-table="incomeList">
 </div>

 @include('web.incomes.add')
 @include('web.incomes.edit')

@endsection
@push('css')
    <link href="{{ url('front/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
@endpush
@push('js')
 <!-- iCheck -->
 <script src="{{url('front/vendors/iCheck/icheck.min.js')}}"></script>

    <script>
        let $addIncome = $('#addIncome');
        let $editIncome = $('#editIncome');

        var data = {
        _token: '{{ csrf_token() }}',
        };

        $(document.body).ready(function(){
            table(data);
        });

         function table(data = {}){
            $.ajax({
                url: "{{route('incomes.data')}}",
                data: data,
                success: function(response){
                    console.log(response);
                    if(response.table !== undefined){
                        $('[data-table="incomeList"]').html(response.table);
                    }
                }
            })
        }

        //Search
        $(document.body).on('change', '[name="search"]', function() {
           data.search = $(this).val()
           table(data);
        });

        // First date
        $(document.body).on('change', '[name="firstdate"]', function() {
            data.firstdate = $(this).val()
            table(data);
        });

        // Last date
        $(document.body).on('change', '[name="lastdate"]', function() {
            data.lastdate = $(this).val()
            table(data);
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
                url: "{{route('incomes.insert')}}",
                method: 'POST',
                data: {
                    transition: $addIncome.find('[name="transition"]').val(),
                    amount : $addIncome.find('[name="amount"]').val(),
                    record : $addIncome.find('[name="record"]').val(),
                    exchange : $addIncome.find('[name="exchange"]').val(),
                },
                success: function(response){
                    console.log(response)
                    if(response.status){
                        Swal.fire(
                            'Notification',
                            response.message,
                            'error'
                        ).then(($result) => {
                            $addIncome.modal('hide')
                            table();
                        })
                    }else{
                        Swal.fire(
                            response.message,
                            response.data,
                            'success'
                        ).then(($result) => {
                            $addIncome.modal('hide')
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
                    $editIncome.find('[name="id"]').val(response.edit.id)
                   // $editPayment.find('[name="expenses"]').val(response.edit.expenses)
                    $editIncome.find('[name="amount"]').val(response.edit.amount)
                    $editIncome.find('[name="record"]').val(response.edit.record)

                    //iwlemir
                    if(response.expenses != null)
                    $editIncome.find('[name="transition"]:selected').val(response.edit.transition)
                  //iwlemir
                  if(response.exchange != null)
                    $editIncome.find('[name="exchange"]:selected').val(response.edit.exchange)
                        
                    $editIncome.modal('show')

                }
            });
        });

        $(document.body).on('click','[data-control="update"]', function(){
            //console.log('hi')
            $.ajax({
                url: "{{route('incomes.update')}}",
                method: 'POST',
                data: {
                    id: $editIncome.find('[name="id"]').val(),
                    expenses: $editIncome.find('[name="transition"]').val(),
                    amount: $editIncome.find('[name="amount"]').val(),
                    record: $editIncome.find('[name="record"]').val(),
                    exchange: $editIncome.find('[name="exchange"]').val()
                },
                success: function(response){
                    console.log(response)
                    if(response.status){
                        Swal.fire(
                            'Notification',
                            response.message,
                            'success'
                        ).then(($result) => {
                            $editIncome.modal('hide')
                            table();
                        })
                    }else{
                        Swal.fire(
                            response.message,
                            response.data,
                            'error'
                        ).then(($result) => {
                            $editIncome.modal('hide')
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
                                url: "{{route('incomes.delete')}}",
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
                        url: "{{route('incomes.all.delete')}}",
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