<table>
    <thead>
    <tr>
        <th>User</th>
        <th>Payable Amount</th>
        <th>Created At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($wrs as $wr)
    <?php $user = \App\User::find($wr->user_id); ?>
    @if($user)
        <tr>
            <td>{{ $user->email }}</td>
            <td>{{ $wr->payable_amount }}</td>
            <td>{{ $wr->created_at }}</td>
        </tr>
    @endif
    @endforeach
    </tbody>
</table>