
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
            <a class="antoo" style="color:#fff; font-weight:500;">Expenses ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
          </th>
        </tr>
      </thead>

      <tbody>
        @if (count($expenses) > 0)
          @foreach ($expenses as $expense)
          <tr class="even pointer">
            <td class="a-center ">
              <input type="checkbox" class="flat records" name="table_records" value="{{$expense->id ?? ''}}">
            </td>
            <td class=" "> {{$expense->id ?? ''}} </td>
            <td class=" "> {{$expense->name ?? ''}}</td>
            <td class=" ">{{$expense->parent->name ?? 'Parent Category'}} </td>
            <td class=" "> {{$expense->created_at ?? ''}} </td>
            <td class=" ">
              <button type="button" class="btn btn-round btn-success" data-control="edit" data-url="{{route('expenses.show', $expense->id)}}">Edit</button>
              <button type="button" class="btn btn-round btn-danger" data-control="delete" data-id="{{$expense->id}}">Delete</button>
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
