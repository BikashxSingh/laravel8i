
@foreach ($categories as $category)
<tr>
    <td><a href="{{ route('category.show', $category->slug) }}">{{ $category->title }}
    </a></td>
    <td>
        @if ($category->myfile != '')
            <a href="{{ asset(\Storage::url($category->myfile)) }}">
                <img src="{{ asset(\Storage::url($category->myfile)) }}" alt=""
                    style="height: 25px; width:25px; border: 1px solid red;">
            </a>
        @endif
    </td>
    <td>{{ $category->status }}</td>
    <td>{{ $category->parentCategory->title ?? '-' }}</td>

    <td><a href="{{ route('category.edit', $category->slug) }}"
            class="btn btn-primary">Edit</a></td>
    <td>
        <form action="{{ route('category.destroy', $category->slug) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </td>
</tr>
@endforeach