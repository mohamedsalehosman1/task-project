<div class="user-wid text-center py-4">
    <div class="user-img">
        <img src="{{ auth()->user()->getAvatar() }}" alt="" class="avatar-md mx-auto rounded-circle">
    </div>

    <div class="mt-3">

        <a href="{{ route('dashboard.admins.show',auth()->user()) }}" class="text-dark font-weight-medium font-size-16">{{ auth()->user()->name }}</a>
{{--        <p class="text-body mt-1 mb-0 font-size-13">UI/UX Designer</p>--}}

    </div>
</div>
