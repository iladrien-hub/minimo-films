<table>
    <thead>
    <tr>
        <td>id</td>
        <td>Title</td>
        <td>Description</td>
        <td>Director</td>
        <td>Price</td>
        <td>Bought</td>
        <td>Genres</td>
        <td>Actions</td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th colspan="100"><a href="{{ route("new-film") }}"><i class="fas fa-plus" style="margin: 10px;"></i></a></th>
    </tr>
    @foreach($films as $film)
        <tr>
            <td>{{ $film->id }}</td>
            <td>{{ $film->title }}</td>
            <td>{{ mb_strimwidth($film->description, 0, 100, "...") }}</td>
            <td>@isset($film->director) {{ $film->director->name }} @endif</td>
            <td style="text-align: center">
                @if($film->price == 0)
                    Free
                @else
                    {{ $film->price }} UAH
                @endif
            </td>
            <td style="text-align: center">{{ $film->bought }}</td>
            <td>
                @foreach($film->genres as $genre)
                    {{ $genre->title." " }}
                @endforeach
            </td>
            <td style="text-align: center">
                <a href="{{ route("page", ["id" => $film->id]) }}"><i class="fas fa-eye"></i></a>
                <a href="{{ route("update-film", ["id" => $film->id]) }}"><i class="fas fa-edit"></i></a>
                <a href="{{ route("remove-film", ["id" => $film->id]) }}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
