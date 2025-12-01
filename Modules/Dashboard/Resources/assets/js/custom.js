$(document).ready(function () {
    $('[name="can_access"]').change(function (e) {
        e.preventDefault();
        var value = $('[name="can_access"]').is(':checked');
        if (value) {
            $("#login").show();
            $('input[name="username"], input[name="password"], input[name="password_confirmation"]')
                .attr("required", true);
        } else {
            $("#login").hide();
            $('input[name="username"], input[name="password"], input[name="password_confirmation"]')
                .val('').attr("required", false);
        }
    });
    $('[name="has_regions"]').change(function (e) {
        e.preventDefault();
        var value = $('[name="has_regions"]').is(':checked');
        if (value) {
            $("#select_region").css({'visibility': 'visible', 'height': '80px'});
            $('[name="regions[]"]').val('').attr("required", true);
        } else {
            $("#select_region").css({'visibility': 'hidden', 'height': '2px'});
            $('[name="regions[]"]').val('').attr("required", false);
        }
    });

    if ($('[name="has_regions"]').is(':checked')) {
        $("#select_region").css({'visibility': 'visible', 'height': '80px'});
        $('[name="regions[]"]').val('').attr("required", true);
    }

    // drag and drop
    dragula([
        document.getElementById("upcoming-task"),
        document.getElementById("inprogress-task"),
        document.getElementById("complete-task")
    ]);
});
