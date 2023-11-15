<table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Transition</th>
        <th>Amount</th>
        <th>Comment</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      @if (count($transitions)>0)
      @foreach ($transitions as $transition)
        <tr>
          <th scope="row">{{$transition->id}}</th>
          <td>{{$transition->transition->name}}</td>
          <td>{{$transition->amountformat}}</td>
          <td>{{$transition->comment}}</td>
          <td>{{$transition->created_at}}</td>
        </tr>
      @endforeach
      @else
      <tr><td colspan="5">Not data..</td></tr>
    @endif
     
    </tbody>
  </table>