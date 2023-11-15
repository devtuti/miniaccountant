<table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Expenses</th>
        <th>Amount</th>
        <th>Comment</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      @if (count($expenses)>0)
        @foreach ($expenses as $expense)
          <tr>
            <th scope="row">{{$expense->id}}</th>
            <td>{{$expense->expenses->name}}</td>
            <td>{{$expense->amountformat}}</td>
            <td>{{$expense->comment}}</td>
            <td>{{$expense->created_at}}</td>
          </tr>
        @endforeach
        @else
        <tr><td colspan="5">Not data..</td></tr>
      @endif
      
     
    </tbody>
  </table>