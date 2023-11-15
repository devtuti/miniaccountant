<div class="modal fade bs-example-modal-lg" id="editExpenses" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
 
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Edit expenses</h4>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left" method="POST">
            @csrf
            <input type="hidden" class="form-control" name="id">
            <div class="form-group row ">
                <label class="control-label col-md-3 col-sm-3 ">Name</label>
                <div class="col-md-9 col-sm-9 ">
                    <input type="text" class="form-control" name="name" placeholder="Expenses name">
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 ">Select expenses</label>
                <div class="col-md-9 col-sm-9 ">
                    <select class="select2_single form-control" tabindex="-1" name="parent_id">
                        <option value="">Parent Category</option>
                        @foreach ($expenses as $expense)
                            <option value="{{$expense->id ?? ''}}"> {{$expense->name ?? ''}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-control="update">Update changes</button>
        </div>
 
      </div>
    </div>
  </div>