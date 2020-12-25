<table>
    <thead>
    <tr>
        <td>id</td>
        <td>Name</td>
        <td>About</td>
        <td>Actions</td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th colspan="6"><a href="{{ route("new-person") }}"><i class="fas fa-plus" style="margin: 10px;"></i></a></th>
    </tr>
    @foreach(\Illuminate\Support\Facades\DB::table("person")->get() as $person)
        <tr>
            <td>{{ $person->id }}</td>
            <td>{{ $person->name }}</td>
            <td>{{ $person->description }}</td>
            <td style="text-align: center">
                <a href="{{ route("page", ["id" => $person->id]) }}"><i class="fas fa-eye"></i></a>
                <a href="{{ route("update-person", ["id" => $person->id]) }}"><i class="fas fa-edit"></i></a>
                <a href="{{ route("remove-person", ["id" => $person->id]) }}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
