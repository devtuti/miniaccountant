<div class="title_right">
    <div class="col-md-5 col-sm-5  form-group pull-right">
      <div class="input-group">
       <select class="form-control" name="search" data-click="search">
       
          @foreach ($transition_search as $transi)
            <option id="{{$transi->id ?? ''}}" value="{{$transi->id ?? ''}}">{{$transi->name ?? ''}}</option>
          @endforeach
      
       </select>
      </div>
    </div>
  </div>