<table>
    <thead>
    <tr>
        <th>Gig title</th>
        <th>Gig Brand</th>
        <th>Created At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($gigs as $gig)
        <tr>
            <td>{{ $gig->campaign_title }}</td>
            <td>{{ $gig->brand }}</td>
            <td>{{ $gig->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>