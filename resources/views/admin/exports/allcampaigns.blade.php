<table>
    <thead>
    <tr>
        <th>Campaign title</th>
        <th>Campaign Brand</th>
        <th>Created At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($campaigns as $campaign)
        <tr>
            <td>{{ $campaign->title }}</td>
            <td>{{ $campaign->brand }}</td>
            <td>{{ $campaign->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>