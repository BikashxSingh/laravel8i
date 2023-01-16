@extends('layout.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="invoice">
            <form role="form" action="{{ route('category.update', $category->slug) }}" method="POST"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title"
                            value="{{ old('title', $category->title) }}">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="myfile">Feature image</label>
                        <div class="holder">
                            {{-- <img id="imgPreview" src="#" alt="pic" /> --}}
                            @if ($category->myfile != '')
                                <img id="imgPreview" src="{{ asset(\Storage::url($category->myfile)) }}" alt="pic"
                                    style="height: 100px; width:fit-content">
                            @endif
                            {{-- ????????????? --}}
                        </div>
                        <br>
                        <input type="file" name="myfile" id="myfile">
                        @error('myfile')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <p class="help-block">Size of image must be less than 1500KB </p>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <div>
                            <input type="radio" id="Active" name="status" value="Active"
                                @if ($category->status == 'Active') checked @endif>
                            {{-- checked --}}
                            {{-- ???????????????????? --}}
                            <label for="active">Active</label>
                        </div>
                        <div>
                            <input type="radio" id="Inactive" name="status" value="Inactive"
                                @if ($category->status == 'Inactive') checked @endif>

                            <label for="inactive">Inactive</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="parent_id">Main Category</label>
                        <select name="parent_id" id="parent_id">
                            <option value="">Select Parent Categories</option>
                            @foreach ($parentCategories as $item)
                                <option value="{{ $item->id }}" @if ($item->id == $category->parent_id) selected @endif>
                                    {{ $item->title }}
                                </option>
                                @if ($item->childCategories)
                                    {{-- ???????????????????? --}}
                                    @foreach ($item->childCategories as $child)
                                        <option value="{{ $child->id }}"
                                            @if ($child->id == $category->parent_id) selected @endif>-{{ $child->title }}
                                        </option>
                                        @if ($child->childCategories)
                                            @foreach ($child->childCategories as $gchild)
                                                <option value="{{ $gchild->id }}"
                                                    @if ($gchild->id == $category->parent_id) selected @endif>
                                                    --{{ $gchild->title }}</option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                        {{-- <input type="number" name="parent_id" class="form-control" id="parent_id" placeholder="Enter Main Category" value="{{ old('parent_id') }}"> --}}
                        @error('parent_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>



                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </section>
    </div>
@endsection

@push('script')
    <script>
        // console.log('check')
        $(document).ready(() => {
            $("#myfile").on('change', function() {
                const file = this.files[0];
                console.log(file);
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        $("#imgPreview")
                            .attr("src", event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        //Plain JS
        // var element = document.getElementById("myfile");
        // element.addEventListener("change", function(e) {
        //     console.log(e, 'event')

        //     const file = e.target.files[0];
        //     if (file) {
        //         let reader = new FileReader();
        //         reader.onload = function(event) {
        //             var image = document.getElementById("imgPreview");
        //             image.setAttribute('src', event.target.result)

        //         };
        //         reader.readAsDataURL(file);
        //     }

        // })
    </script>
@endpush
