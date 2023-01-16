@if (isset($products))
@foreach ($products as $product)
<tr>
    <td><a href="{{ route('product.show', $product->slug) }}">{{ $product->title }}
            </a></td>
        <td>{{ $product->short_description }}</td>
        <td>{{ $product->long_description }}</td>
        <td>{{ $product->status }}</td>
        <td>{{ $product->thecategory->title ?? '-' }}</td>
        <td>
            @if ($product->pImage != '')
            <a href="{{ asset(\Storage::url($product->pImage)) }}">
                <img src="{{ asset(\Storage::url($product->pImage)) }}" alt=""
                 style="height: 25px; width:25px; border: 1px solid red;">
            </a>
            @endif
        </td>
        <td>{{ $product->price }}</td>
        
        {{-- @dd($product->slug) --}}
        <td>
            <a href="{{ route('product.edit', $product->slug) }}" class="btn btn-primary">Edit</a>
        </td>
        <td>
            <form action="{{ route('product.destroy', $product->slug) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
@endforeach  
@endif
