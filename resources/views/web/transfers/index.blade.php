@extends('web.layout.app')
@section('title', __('Transfers'))
@section('search')
    @include('web.transfers.inc.search')
@endsection
@section('content')
 <!-- Add modal -->
 <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Add transfer</button>
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
                }, 60000);
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
                }, 60000);
            }
        </script>
    </div>
</div>
 <div class="table-responsive" data-table="transferList">
 </div>

 @include('web.transfers.add')
 @include('web.transfers.edit')

@endsection
@push('css')
    <link href="{{ url('front/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
@endpush
@push('js')
 <!-- iCheck -->
 <script src="{{url('front/vendors/iCheck/icheck.min.js')}}"></script>

    <script>
        let $addTransfer = $('#addTransfer');
        let $editTransfer = $('#editTransfer');

        var data = {
        _token: '{{ csrf_token() }}',
        };

        $(document.body).ready(function(){
            table(data);
        });

         function table(data = {}){
            $.ajax({
                url: "{{route('transfers.data')}}",
                data: data,
                success: function(response){
                    console.log(response);
                    if(response.table !== undefined){
                        $('[data-table="transferList"]').html(response.table);
                    }
                }
            })
        }

        //Search
        $(document.body).on('click', '[name="search"]', function() {
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
                url: "{{route('transfers.insert')}}",
                method: 'POST',
                data: {
                    card_no: $addTransfer.find('[name="card_no"]').val(),
                    to_card_no : $addTransfer.find('[name="to_card_no"]').val(),
                    amount : $addTransfer.find('[name="amount"]').val(),
                    exchange : $addTransfer.find('[name="exchange"]').val(),
                    record : $addTransfer.find('[name="record"]').val(),
                },
                success: function(response){
                    console.log(response)
                    if(response.status){
                        Swal.fire(
                            'Notification',
                            response.message,
                            'error'
                        ).then(($result) => {
                            $addTransfer.modal('hide')
                            table();
                        })
                    }else{
                        Swal.fire(
                            response.message,
                            response.data,
                            'success'
                        ).then(($result) => {
                            $addTransfer.modal('hide')
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
                    $editTransfer.find('[name="id"]').val(response.edit.id)
                    $editTransfer.find('[name="card_no"]').val(response.edit.card_no)
                    $editTransfer.find('[name="to_card_no"]').val(response.edit.to_card_no)
                    $editTransfer.find('[name="amount"]').val(response.edit.amount)
                    $editTransfer.find('[name="record"]').val(response.edit.record)

                    //iwlemir
                    if(response.exchange != null)
                    $editTransfer.find('[name="exchange"]:selected').val(response.edit.exchange)
                        
                    $editTransfer.modal('show')

                }
            });
        });

        $(document.body).on('click','[data-control="update"]', function(){
            //console.log('hi')
            $.ajax({
                url: "{{route('transfers.update')}}",
                method: 'POST',
                data: {
                    id: $editTransfer.find('[name="id"]').val(),
                    card_no: $editTransfer.find('[name="card_no"]').val(),
                    to_card_no : $editTransfer.find('[name="to_card_no"]').val(),
                    amount: $editTransfer.find('[name="amount"]').val(),
                    record: $editTransfer.find('[name="record"]').val(),
                    exchange: $editTransfer.find('[name="exchange"]').val()
                },
                success: function(response){
                    console.log(response)
                    if(response.status){
                        Swal.fire(
                            'Notification',
                            response.message,
                            'success'
                        ).then(($result) => {
                            $editTransfer.modal('hide')
                            table();
                        })
                    }else{
                        Swal.fire(
                            response.message,
                            response.data,
                            'error'
                        ).then(($result) => {
                            $editTransfer.modal('hide')
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
                                url: "{{route('transfers.delete')}}",
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
                        url: "{{route('transfers.all.delete')}}",
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