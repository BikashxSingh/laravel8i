@extends('layout.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="invoice">
            <form action="/search" method="POST" role="search" id="searchform">
                @csrf
                <div class="row">
                    <div class="col-3">
                        <div class="input-group">
                            <div class="row">
                                <div class="col-xs-6">
                                    <select id="selectCategory" name="selectCategory" style="width: 200px;">
                                        <option value="" id="clear">Select Main Category</option>
                                        {{-- @foreach ($products as $item) --}}
                                        {{-- @if ($item->category_id != $item->id)
                                        
                                    @endif --}}
                                        {{-- <option value={{ $item->thecategory->id }}>{{ $item->thecategory->title }}
    
                                        </option>
                                    @endforeach --}}
                                        @foreach ($parentCategories as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                            @if ($item->childCategories)
                                                @foreach ($item->childCategories as $child)
                                                    <option value="{{ $child->id }}">-{{ $child->title }}</option>
                                                    @if ($child->childCategories)
                                                        @foreach ($child->childCategories as $gchild)
                                                            <option value="{{ $gchild->id ?? '-' }}">
                                                                --{{ $gchild->title ?? '' }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xs-6">
                                    <select id="selectStatus" name="selectStatus" style="width: 200px;">
                                        <option value="" id="clear">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="form-inline">
                                <input type="text" class="form-control" name="searchC" id="searchC"
                                    placeholder="Search Categories" class="input-group-btn col-3">

                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Table row -->
            <div class="contaner">
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Main Category</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="dynamic-row">
                                {{-- @foreach ($categories as $category)
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
                                    @endforeach --}}
                            </tbody>
                        </table>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>

            <div class="container">
                <td><a href="{{ route('category.create') }}" class="btn btn-primary">Create</a></td>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script>
        getData();
        $('body').on('change', '#selectCategory', function() {
            getData();
        });
        $('body').on('change', '#selectStatus', function() {

            getData();
        });

        $('body').on('keyup', '#searchC', function() {
            getData();
        });

        function getData() {
            var searchdata = $('#searchform').serialize();
            // console.log(searchdata);
            //can do with GET
            $.ajax({
                method: 'POST',
                url: "{{ route('category.search') }}",
                data: searchdata,
                processData: false,
                processContent: false,
                success: function(res) {
                    console.log(res);
                    $('#dynamic-row').html(res);
                    //    document.getElementById('dynamic-row').innerHTML = res;

                },
                error: function(err) {
                    console.log(err)
                }
            });
        }
    </script>
@endpush
