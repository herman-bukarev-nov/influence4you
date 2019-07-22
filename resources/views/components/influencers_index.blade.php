<table class="table table-striped">
    <thead class="thead-dark">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">E-mail</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($influencers as $influencer)
        <tr>
            <th scope="row">{{ $influencer->id }}</th>
            <td>{{ $influencer->name }}</td>
            <td>{{ $influencer->email }}</td>
        </tr>
    @empty
        <tr><td colspan="3">No influencers</td></tr>
    @endforelse
    </tbody>
</table>