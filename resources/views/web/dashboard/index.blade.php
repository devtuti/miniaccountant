@extends('web.layout.app')
@section('title', __('Icmal'))
@section('content')
<div class="col-md-3 col-sm-3  tile">
    <span>{{$date}}</span>
    <h2> {{number_format($totalmonth, 2) ?? '0'}} Руб</h2>
    <h2> {{number_format($totalmonth_usd, 2) ?? '0'}} $</h2>
    <h2> {{number_format($totalmonth_eur, 2) ?? '0'}} Э</h2>
    <h2> {{number_format($totalmonth_azn, 2) ?? '0'}} Azn</h2>
</div>
<div class="col-md-9 col-sm-9  tile">
<div class="form-group row">
    <label class="control-label col-md-3 col-sm-3 col-xs-3">First Date</label>
    <div class="col-md-9 col-sm-9 col-xs-9">
      <input type="text" class="form-control" data-inputmask="'mask': '99/99/99'" name="first_date" id="first_date" value="">
      <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
    </div>
  </div>

  <div class="form-group row">
    <label class="control-label col-md-3 col-sm-3 col-xs-3">Last Date</label>
    <div class="col-md-9 col-sm-9 col-xs-9">
      <input type="text" class="form-control" data-inputmask="'mask': '99/99/99'" name="last_date" id="last_date" value="">
      <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
    </div>
  </div>

</div>
  <div class="col-md-12 col-sm-12  ">
    <div class="x_panel">

      <div class="x_content">
        <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="expenses-tab" data-toggle="tab" href="#expenses" role="tab" aria-controls="expenses" aria-selected="true">Expenses</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="transitions-tab" data-toggle="tab" href="#transitions" role="tab" aria-controls="transitions" aria-selected="false">Transitions</a>
            </li>
           
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="expenses" data-control="data-table-expenses" role="tabpanel" aria-labelledby="expenses-tab">
                

            </div>
            <div class="tab-pane fade" id="transitions" data-control="data-table-transitions" role="tabpanel" aria-labelledby="transitions-tab">
                
            </div>
            
          </div>
      </div>

    </div>
  </div>
@endsection
@push('css')


@endpush
@push('js')
    <!-- bootstrap-daterangepicker -->
    <script src="{{url('front/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{url('front/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="{{url('front/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
    
    <!-- jquery.inputmask -->
    <script src="{{url('front/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
   

    <!-- Initialize datetimepicker -->
<script>
    $(function () {
                 $('#myDatepicker').datetimepicker();
                 table_expenses();
             });
     
     $('#myDatepicker2').datetimepicker({
         format: 'DD.MM.YY'
     });
     
     $('#myDatepicker3').datetimepicker({
         format: 'hh:mm A'
     });
     
     $('#myDatepicker4').datetimepicker({
         ignoreReadonly: true,
         allowInputToggle: true
     });
 
     $('#datetimepicker6').datetimepicker();
     
     $('#datetimepicker7').datetimepicker({
         useCurrent: false
     });
     
     $("#datetimepicker6").on("dp.change", function(e) {
         $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
     });
     
     $("#datetimepicker7").on("dp.change", function(e) {
         $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
     });

     
    /*const d = new Date();
    document.getElementById("last_date").val(d.toDateString());*/


    function table_expenses(data ={}){
        $.ajax({
            url: '{{route('data')}}',
            data: data,
            success: function(response){
                console.log(response)
                $('[data-control="data-table-expenses"]').html(response.table)
                $('[data-control="data-table-transitions"]').html(response.table_t)
            }
        });
     }

     //SEARCH FIRST

     $(document).on('keyup', '#first_date', function() {
            var query = $(this).val();
            table_expenses({
                first_search: query,
                last_search: $('#last_date').find('[name="last_date"]').val(),
                _token: '{{ csrf_token() }}'
            });
        });

        //SEARCH LAST

        $(document).on('keyup', '#last_date', function() {
            var query = $(this).val();
            table_expenses({
                last_search: query,
                first_search: $('#first_date').find('[name="first_date"]').val(),
                _token: '{{ csrf_token() }}'
            });
        });
    </script>
@endpush
