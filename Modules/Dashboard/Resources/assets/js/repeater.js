jQuery(document).ready(function ($) {
    $('.repeater').repeater({
        initEmpty: false,
        defaultValues: {
            'text-input': 'phone'
        },
        show: function () {
            $(this).slideDown();
        },
        hide: function (e) {
            // toast.fire({
            //     title: "Are you sure?",
            //     text: "You won't be able to revert this",
            //     type: "warning",
            //     showCancelButton: !0,
            //     confirmButtonColor: "#3b5de7",
            //     cancelButtonColor: "#f46a6a",
            //     confirmButtonText: "Confirm",
            // }).then((result) => {
            //     $(this).fadeOut(1000, e);
            // })

            $(this).fadeOut(1000, e);

        },
        isFirstItemUndeletable: true
    });

    $(".dayRepeater").repeater({
        show: function () {
            $(this).fadeIn(1000);
        },
        hide: function (e) {
            toast.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3b5de7",
                cancelButtonColor: "#f46a6a",
                confirmButtonText: "Confirm",
            }).then((result) => {
                $(this).fadeOut(1000, e);
            })
        },
        ready: function (e) {
        },
        repeaters: [{
            // (Required)
            // Specify the jQuery selector for this nested repeater
            selector: '.inner-repeater',
            isFirstItemUndeletable: true,
            show: function () {
                $(this).fadeIn(1000);
            },
            hide: function () {
                $(this).fadeOut(1000);
            },
        }]
    });
});
