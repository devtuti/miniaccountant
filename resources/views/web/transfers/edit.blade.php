<div class="modal fade bs-example-modal-lg" id="editTransfer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
 
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Edit transfer</h4>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left" method="POST">
            @csrf
            <input type="hidden" class="form-control" name="id">
            <div class="form-group row ">
                <label class="control-label col-md-3 col-sm-3 ">Card no</label>
                <div class="col-md-9 col-sm-9 ">
                    <input type="text" class="form-control" name="card_no" placeholder="Card no">
                </div>
            </div>

            <div class="form-group row ">
              <label class="control-label col-md-3 col-sm-3 ">To Card no</label>
              <div class="col-md-9 col-sm-9 ">
                  <input type="text" class="form-control" name="to_card_no" placeholder="To Card no">
              </div>
          </div>

          <div class="form-group row ">
            <label class="control-label col-md-3 col-sm-3 ">Amount</label>
            <div class="col-md-9 col-sm-9 ">
                <input type="text" class="form-control" name="amount" placeholder="Amount">
            </div>
        </div>

            <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 ">Select exchange</label>
                <div class="col-md-9 col-sm-9 ">
                    <select class="select2_single form-control" tabindex="-1" name="exchange">
                        <option value="1">Rub</option>
                        <option value="2">USD</option>
                        <option value="3">Eur</option>
                        <option value="4">Azn</option>
                       
                    </select>
                </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 ">Record </label>
              <div class="col-md-9 col-sm-9 ">
                <textarea class="form-control" name="record" rows="3" placeholder="Comment" style="height: 94px;"></textarea>
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