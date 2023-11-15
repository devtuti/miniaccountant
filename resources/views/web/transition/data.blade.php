
    <table class="table table-striped jambo_table bulk_action">
      <thead>
        <tr class="headings">
          <th>
            <input type="checkbox" id="check-all" class="flat">
          </th>
          <th class="column-title">Id </th>
          <th class="column-title">Name </th>
          <th class="column-title">Parent name </th>
          <th class="column-title">Created Date </th>
          <th class="column-title no-link last"><span class="nobr">Action</span>
          </th>
          <th class="bulk-actions" colspan="7">
            <a class="antoo" style="color:#fff; font-weight:500;">Transitions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
          </th>
        </tr>
      </thead>

      <tbody>
        @if (count($transitions) > 0)
          @foreach ($transitions as $transition)
          <tr class="even pointer">
            <td class="a-center ">
              <input type="checkbox" class="flat records" value="{{$transition->id ?? ''}}">
            </td>
            <td class=" "> {{$transition->id ?? ''}} </td>
            <td class=" "> {{$transition->name ?? ''}}</td>
            <td class=" ">{{$transition->parent->name ?? 'Parent Category'}} </td>
            <td class=" "> {{$transition->created_at ?? ''}} </td>
            <td class=" ">
              <button type="button" class="btn btn-round btn-success" data-control="edit" data-url="{{route('transitions.show', $transition->id)}}">Edit</button>
              <button type="button" class="btn btn-round btn-danger" data-control="delete" data-id="{{$transition->id}}">Delete</button>
            </td>

            </td>
          </tr>
          @endforeach
          @else
          <tr>
            <th colspan="6" style="text-align:center">Not result...</th>
          </tr>
        @endif
        
       
      </tbody>
    </table>
