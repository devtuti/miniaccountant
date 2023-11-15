<div class="title_right">
    <div class="col-md-5 col-sm-5  form-group pull-right">
      <div class="input-group">
       <select class="form-control" name="search" data-click="search">
        @foreach ($expenses_search as $exp)
          <option id="{{$exp->id ?? ''}}" value="{{$exp->id ?? ''}}">{{$exp->name ?? ''}}</option>
        @endforeach
       </select>
      </div>
    </div>
  </div>