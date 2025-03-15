
<table>
    <thead>
    <tr>
        <th>Proof Submission Date</th>
        <th>Candidate Name</th>
        <th>Candidate Phone</th>
        <th>Candidate Email</th>
        <th>Proof Text</th>
        <th>Proof</th>
    </tr>
    </thead>
    <tbody>
    @foreach($proofs as $proof)
    <?php
    $job = \App\Gig::find($proof->job_id);
    // die($proof);
?>
    <?php
    $user = \App\User::find($proof->user_id); ?>
    @if($user)
        <tr>
            <td>{{ $proof->created_at->format('Y-m-d') }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $proof->proof_text }}</td>
            <td>{{asset('assets/user/images/proof_file/'.$proof->proof_file)}}</td>
        </tr>
    @endif
    @endforeach
    </tbody>
</table>