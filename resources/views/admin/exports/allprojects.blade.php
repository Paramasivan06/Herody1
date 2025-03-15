<table>
    <thead>
    <tr>
        <th>Project title</th>
        <th>Project Brand</th>
        <th>Created At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($projects as $project)
    <?php $user = \App\Employer::find($project->user); ?>
        <tr>
            <td>{{ $project->title }}</td>
            <td>{{ $user->cname }}</td>
            <td>{{ $project->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>