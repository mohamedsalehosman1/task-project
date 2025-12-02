<div class="user-wid text-center py-4">
    <div class="user-img">
        <img src="{{ auth()->user()->getAvatar() }}" alt="" class="avatar-md mx-auto rounded-circle">
    </div>

    <div class="mt-3">

        @php
            $vendor = auth()->user()->vendor;
            $isVendor = (bool) auth()->user()->hasRole('vendor');
        @endphp

        @if ($isVendor)
            <a href="{{ route('dashboard.vendors.profile') }}"
                class="text-dark font-weight-medium font-size-16">{{ optional(auth()->user()->admin)->name ?? (auth()->user()->name ?? 'اسم المستخدم') }}</a>
        @else
            {{-- <a href="{{ route('dashboard.admins.profile') }}"
                class="text-dark font-weight-medium font-size-16">{{ optional(auth()->user()->admin)->name ?? (auth()->user()->name ?? 'اسم المستخدم') }}
            </a> --}}
        @endif

    </div>
</div>
