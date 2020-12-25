<table>
    <thead>
    <tr>
        <td>p_code</td>
        <td>Title</td>
        <td>Actions</td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th colspan="5"><a href="{{ route("new-genre") }}"><i class="fas fa-plus" style="margin: 10px;"></i></a></th>
    </tr>
    @foreach(\App\Models\Genre::getAllGenres() as $genre)
        <tr>
            <td>{{ $genre->p_code }}</td>
            <td>{{ $genre->title }}</td>
            <td style="text-align: center">
                <a href="{{ \App\Models\Genre::getFilterRoute($genre->p_code) }}"><i class="fas fa-eye"></i></a>
                <a href="{{ route("update-genre", ["id" => $genre->p_code]) }}"><i class="fas fa-edit"></i></a>
                <a href="{{ route("remove-genre", ["id" => $genre->p_code]) }}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
