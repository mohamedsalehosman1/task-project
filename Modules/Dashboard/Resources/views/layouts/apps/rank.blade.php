<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-ui-dist@1.12.1/jquery-ui.min.js"></script>
{{-- <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script> --}}
<script>
    // Fix the width of the cells
    $('td, th', '#sortFixed').each(function() {
        var cell = $(this);
        cell.width(cell.width());
    });

    $('#sortFixed tbody').sortable().disableSelection();

    $('body').on('input', '.drag', function() {
        $('tbody tr').removeClass('marker');
        var currentEl = $(this);
        var index = parseInt(currentEl.val());
        if (index <= $('.drag').length) {
            currentEl.attr('value', index)
            var oldLoc = currentEl.parent().parent()
            var newLoc = $('tbody tr').eq(index - 1)
            newLoc.addClass('marker')
            var newLocHtml = newLoc.html()
            newLoc.html(oldLoc.html()).hide().fadeIn(1200);
            oldLoc.html(newLocHtml)
        }
    })
</script>
