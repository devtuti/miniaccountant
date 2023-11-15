
    <table class="table table-striped jambo_table bulk_action">
      <thead>
        <tr class="headings">
          <th>
            <input type="checkbox" id="check-all" class="flat">
          </th>
          <th class="column-title">Id </th>
          <th class="column-title">Expenses</th>
          <th class="column-title">Amount </th>
          <th class="column-title">Exchange </th>
          <th class="column-title">Created Date </th>
          <th class="column-title no-link last"><span class="nobr">Action</span>
          </th>
          <th class="bulk-actions" colspan="7">
            <a class="antoo" style="color:#fff; font-weight:500;">Transfers ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
          </th>
        </tr>
      </thead>

      <tbody>
        @if (count($payments) > 0)
          @foreach ($payments as $payment)
          <tr class="even pointer">
            <td class="a-center ">
              <input type="checkbox" class="flat records" value="{{$payment->id ?? ''}}">
            </td>
            <td class=" "> {{$payment->id ?? ''}} </td>
            <td class=" "> {{$payment->expenses->name ?? ''}}</td>
            <td class=" "> {{$payment->amountformat ?? ''}}</td>
            <td class=" "> {{$payment->exchangeformat ?? ''}}</td>
            <td class=" "> {{$payment->created_at ?? ''}} </td>
            <td class=" ">
              <button type="button" class="btn btn-round btn-success" data-control="edit" data-url="{{route('transfers.show', $payment->id)}}">Edit</button>
              <button type="button" class="btn btn-round btn-danger" data-control="delete" data-id="{{$payment->id}}">Delete</button>
            </td>

            </td>
          </tr>
          @endforeach
          @else
          <tr>
            <th colspan="6" style="text-align:center">Not result...</th>
          </tr>
        @endif
        <tr>
          <th colspan="8" style="text-align:right"><h4 style="color:brown"> {{number_format($sum, 2) ?? '0'}} Rub</h4></th>
        </tr>
        <tr>
          <th colspan="8" style="text-align:right"><h4 style="color:brown"> {{number_format($sum_usd, 2) ?? '0'}} USD</h4></th>
        </tr>
        <tr>
          <th colspan="8" style="text-align:right"><h4 style="color:brown"> {{number_format($sum_eur, 2) ?? '0'}} EUR</h4></th>
        </tr>
        <tr>
          <th colspan="8" style="text-align:right"><h4 style="color:brown"> {{number_format($sum_azn, 2) ?? '0'}} AZN</h4></th>
        </tr>
       
      </tbody>
    </table>
