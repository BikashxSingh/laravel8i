@extends('layout.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="invoice">
            
            @include('inc.messages')
            
            <form role="form" action="{{ route('product.update', $editProduct->slug) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @include('product.commonForm')

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
            $("#pImage").on('change', function() {
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
    </script>

    <script>
        //{{-- specifications script multiple add --}}

        function generateRandomInteger() {
            return Math.random() * 99999;
        }

        jQuery(document).on('click', '.btn-delete-specifications', function(e) {
            e.preventDefault();
            var $this = $(this);
            var id = $(this).attr("data-id");
            console.log(id);
            $('<input>').attr({
                type: 'hidden',
                name: 'deleted_ids[]',
                value: id
            }).appendTo('form');
            $this.closest("tr").remove();
        });

        jQuery(document).on('click', '.btn-add-specifications', function(e) {
            e.preventDefault();
            // console.log('tgd');
            var lastRow = $('table.table-specifications > tbody > tr').last().attr('data-row');
            var counter = lastRow ? parseInt(lastRow) + 1 : 1;
            var randomInteger = generateRandomInteger();
            // var i = counter-1;
            var newRow = jQuery('<tr data-row="' + counter + '">' +
                '<td>' + counter + '</td>' +
                '<td><textarea name="spec[title][' + randomInteger +
                ']" class="form-control" required></textarea></td>' +
                // '<td><textarea name="spec[' + i +
                // '][title]" class="form-control" required></textarea></td>' +

                // '<td><input type="text" name="features[feature][' + randomInteger + ']" class="form-control" required/></td>' +
                
                '<td>' + '<textarea name="spec[specification][' + randomInteger +
                ']" class="form-control" required></textarea>' +
                '</td>' +

                // '<td>' + '<textarea name="spec[' + i +
                // '][specification]" class="form-control" required></textarea>' +
                // '</td>' +
                '<td><button type="button" class="btn btn-danger btn-sm btn-delete-specifications" data-feature=""><i class="fa fa-minus-circle"></i></button></td>' +
                '</tr>');
            jQuery('table.table-specifications').append(newRow);
        });
    </script>
@endpush
