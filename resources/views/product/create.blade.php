@extends('layout.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="invoice">
            
            @include('inc.messages')
            
            <form role="form" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('product.commonForm')

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </section>


    </div>
@endsection

@push('script')
    <script>
        $(document).ready(() => {
            $("#pImage").change(function() {
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
            return Math.floor(Math.random() * 90000) + 10000;
        }

        jQuery(document).on('click', '.btn-delete-specifications', function(e) {
            e.preventDefault();
            var $this = $(this);
            $this.closest("tr").remove();
        });

        jQuery(document).on('click', '.btn-add-specifications', function(e) {
            e.preventDefault();
            // console.log('tgd');
            var lastRow = $('table.table-specifications > tbody > tr').last().attr('data-row');
            var counter = lastRow ? parseInt(lastRow) + 1 : 1;
            // var randomInteger = generateRandomInteger();
            var newRow = jQuery('<tr data-row="' + counter + '">' +
                '<td>' + counter + '</td>' +
                '<td><textarea name="spec[title][]" class="form-control" required></textarea></td>' +
                // '<td><textarea name="spec[0][title]" class="form-control" required></textarea></td>' +

                // '<td><input type="text" name="features[feature][' + randomInteger + ']" class="form-control" required/></td>' +
                '<td>' + '<textarea name="spec[specification][]" class="form-control" required></textarea>' +
                '</td>' +
                '<td><button type="button" class="btn btn-danger btn-sm btn-delete-specifications" data-feature=""><i class="fa fa-minus-circle"></i></button></td>' +
                '</tr>');
            jQuery('table.table-specifications').append(newRow);
        });
    </script>

{{-- spec_title[$i][$j] --}}
{{-- spec_specification[$i][$j] --}}

    {{-- <script>
        $('.repeater-add-btn').on('click', function() {

        })
    </script> --}}
@endpush
