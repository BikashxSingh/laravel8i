@extends('layout.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="invoice">

            @include('inc.messages')
            {{-- /search --}}
            <form action="" method="POST" role="search" id="searchform">
                @csrf
                <div class="row">
                    <div class="col-3">
                        <div class="input-group">
                            <div class="row">
                                <div class="col-xs-4">
                                    <select id="selectCategory" name="selectCategory" style="width: 200px;">
                                        <option value="" id="clear">Select Category</option>
                                        {{-- @foreach ($products as $item) --}}
                                        {{-- @if ($item->category_id != $item->id)
                                        
                                    @endif --}}
                                        {{-- <option value={{ $item->thecategory->id }}>{{ $item->thecategory->title }}
    
                                        </option>
                                    @endforeach --}}
                                        @foreach ($categories as $item)
                                            @if ($item->childCategories)
                                                @foreach ($item->childCategories as $child)
                                                    @if ($child->childCategories)
                                                        @foreach ($child->childCategories as $gchild)
                                                            <option value="{{ $gchild->id ?? '-' }}">
                                                                {{ $gchild->title ?? '' }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>

                                </div>

                                <div class="col-xs-4">
                                    <select id="selectStatus" name="selectStatus" style="width: 200px;">
                                        <option value="" id="clear">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>

                                </div>
                                <div class="col-xs-4">
                                    {{-- <select id="selectPrice" name="selectPrice" style="width: 200px;">
                                    <option value="" id="clear">Select Price Range</option>
                                   
                                </select> --}}
                                    <label for="Price">Price Range</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <label for="from">From</label>
                                            {{-- <input type="text" id="from" name="from" value=""> --}}
                                            <input type="number" name="fromprice" class="form-control" id="fromprice"
                                                placeholder="From Price" value="{{ old('fromprice') }}">
                                        </div>
                                        <div class="col-xs-6">

                                            <label for="to">To</label>
                                            {{-- <input type="text" id="from" name="to"> --}}
                                            <input type="number" name="toprice" class="form-control" id="toprice"
                                                placeholder="To Price" value="{{ old('toprice') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <select class="livesearch form-control p-3" id="livesearch" name="livesearch">

                            </select> --}}
                            <br>
                            <div class="form-inline">
                                <input type="text" class="form-control" name="searchP" id="searchP"
                                    placeholder="Search Products" class="input-group-btn col-3">
                            </div>

                            {{-- <i class="glyphicon glyphicon-user form-control-feedback"></i> --}}
                            {{-- <i class="fas fa-search"></i> --}}
                            {{-- <button type="submit" class="btn btn-default">
                                <span class="glyphicon glyphicon-search"></span>
                            </button> --}}
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
                                    <th>Short Desription</th>
                                    <th>Long Description</th>
                                    <th>Status</th>
                                    <th>Category</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="dynamic-row">

                            </tbody>
                        </table>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>

            <div class="container">
                <td><a href="{{ route('product.create') }}" class="btn btn-primary">Create</a></td>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script>
        getData();

        $('body').on('change', '#selectCategory', function() {
            // console.log('lkjhgfd');
            // $(document).on('click','#clear', function(){
            // $('#selectCategory').empty();
            // getData(); 
            // )};

            getData();
        });
        $('body').on('change', '#selectStatus', function() {

            getData();
        });
        $('body').on('keyup', '#fromprice, #toprice', function() {

            getData();
        });
        // $(document).on('keyup', , function() {

        // getData();
        // });
        $('body').on('keyup', '#searchP', function() {
            getData();
        });

        function getData() {
            var searchdata = $('#searchform').serialize(); //form data
            // console.log(searchdata);

            $.ajax({
                method: 'POST',
                url: "{{ route('product.search') }}",
                data: searchdata,
                processData: false,
                processContent: false,
                success: function(res) {
                    // console.log(res);
                    //    document.getElementById('dynamic-row').innerHTML = res;
                    $('#dynamic-row').html(res);
                },
                error: function(err) {
                    console.log(err)
                }
            });
        }

        // function getDataC() {
        //     $value = $('#selectCategory').val();
        //     // console.log(value);
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });

        //     $.ajax({
        //         method: 'POST',
        //         url: "{{ route('product.searchCat') }}",
        //         data: {
        //             'selectCategory': $value
        //         },
        //         processData: false,
        //         processContent: false,
        //         success: function(res) {
        //             console.log(res);
        //             //    document.getElementById('dynamic-row').innerHTML = res;
        //             $('#dynamic-row').html(res);


        //         },
        //         error: function(err) {
        //             console.log(err)
        //         }
        //     });
        // }


        // $('.livesearch').select2({
        //         placeholder: 'Select an item',
        //         ajax: {
        //             url: "{{ route('select2.search') }}",
        //             dataType: 'json',
        //             delay: 250,
        //             processResults: function(data) {
        //                 console.log(data);
        //                 return {
        //                     results: $.map(data, function(item) {
        //                         return {
        //                             text: item.title,
        //                             id: item.id
        //                         }
        //                     })
        //                 };
        //             },
        //             cache: true
        //         }
        //     });
    </script>
@endpush
