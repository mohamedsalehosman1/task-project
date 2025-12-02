<!-- App js -->
<script src="{{ asset(mix('js/backend.js')) }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.map.map_key') }}&libraries=places" async
    defer></script>

<script type="module">
    import Echo from 'https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/+esm';
    import Pusher from 'https://cdn.jsdelivr.net/npm/pusher-js@7.0.3/+esm';

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: "{{ env('PUSHER_APP_KEY') }}",
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        encrypted: true,
        forceTLS: true
    });

    const url = "{{ url('') }}";
    const id = "{{ auth()?->id() }}";
    const lang = "{{ app()->getLocale() }}";

    window.Echo.channel(`notification-channel.${id}`)
        .listen('.notification-event', (data) => {
            const title = data.title[lang];
            const body = data.message[lang];

            $.notify(body, "success");
            $.playSound("{{ asset('sounds/notification.mp3') }}");

            $.ajax({
                type: "GET",
                url: url + "/api/dashboard/render-notifications/" + id,
                success: function(response) {
                    $(".notification-render").empty().append(response.messageHtml);
                }
            });
        })
        .error((error) => {
            console.error('Error:', error);
        });
</script>

<!-- JAVASCRIPT -->
@stack('js')

<script>
    (function($) {
        $.extend({
            playSound: function() {
                console.log('asdasdasdasdasd');

                return $(
                    '<audio class="sound-player" autoplay="autoplay" style="position:fixed">' +
                    '<source src="' + arguments[0] + '" />' +
                    '<embed src="' + arguments[0] +
                    '" hidden="true" autostart="true" loop="false"/>' +
                    '</audio>'
                ).prependTo('body');
            },
            stopSound: function() {
                $(".sound-player").remove();
            }
        });
    })(jQuery);


    // 🔻 هنا تفعيل الـ sidebar (metisMenu) + إخفاء اللودر
    $(document).ready(function () {

        // إخفاء الـ page loader لو لسه ظاهر
        $('#preloader, #preloader-status').fadeOut('slow', function () {
            $('body').css('overflow', 'visible');
        });

        // تفعيل metisMenu على السايدبار
        if ($('#side-menu').length) {
            $('#side-menu').metisMenu();
        }

        // نخلي كل parent مفتوح لو تحته عنصر active
        $('ul.metismenu li.mm-active').each(function () {
            $(this).parents('li').addClass('mm-active');
            $(this).parents('ul.sub-menu')
                .addClass('mm-show')
                .attr('aria-expanded', 'true');
        });
    });
</script>
