    <!-- jQuery 2.1.4 -->
    <script src="{{ asset('plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.4 -->
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- jvectormap -->
    <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('plugins/knob/jquery.knob.js') }}"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- datepicker -->
    <script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <!-- Slimscroll -->
    <script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('plugins/fastclick/fastclick.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/app.min.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>

    <script>
        jQuery.fn.extend({
    createRepeater: function (options = {}) {
        var hasOption = function (optionKey) {
            return options.hasOwnProperty(optionKey);
        };

        var option = function (optionKey) {
            return options[optionKey];
        };

        var generateId = function (string) {
            return string
                .replace(/\[/g, '_')
                .replace(/\]/g, '')
                .toLowerCase();
        };

        var addItem = function (items, key, fresh = true) {
            var itemContent = items;
            var group = itemContent.data("group");
            var item = itemContent;
            var input = item.find('input,select,textarea');

            input.each(function (index, el) {
                var attrName = $(el).data('name');
                var skipName = $(el).data('skip-name');
                if (skipName != true) {
                    $(el).attr("name", group + "[" + key + "]" + "[" + attrName + "]");
                } else {
                    if (attrName != 'undefined') {
                        $(el).attr("name", attrName);
                    }
                }
                if (fresh == true) {
                    $(el).attr('value', '');
                }

                $(el).attr('id', generateId($(el).attr('name')));
                $(el).parent().find('label').attr('for', generateId($(el).attr('name')));
            })

            var itemClone = items;

            /* Handling remove btn */
            var removeButton = itemClone.find('.remove-btn');

            if (key == 0) {
                removeButton.attr('disabled', true);
            } else {
                removeButton.attr('disabled', false);
            }

            removeButton.attr('onclick', '$(this).parents(\'.items\').remove()');

            var newItem = $("<div class='items'>" + itemClone.html() + "<div/>");
            newItem.attr('data-index', key)

            newItem.appendTo(repeater);
        };

        /* find elements */
        var repeater = this;
        var items = repeater.find(".items");
        var key = 0;
        var addButton = repeater.find('.repeater-add-btn');

        items.each(function (index, item) {
            items.remove();
            if (hasOption('showFirstItemToDefault') && option('showFirstItemToDefault') == true) {
                addItem($(item), key);
                key++;
            } else {
                if (items.length > 1) {
                    addItem($(item), key);
                    key++;
                }
            }
        });

        /* handle click and add items */
        addButton.on("click", function () {
            addItem($(items[0]), key);
            key++;
        });
    }
});
    </script>
