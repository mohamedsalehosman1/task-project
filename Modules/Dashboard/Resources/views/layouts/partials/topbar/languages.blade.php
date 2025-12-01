<div class="dropdown d-none d-sm-inline-block">
    <button type="button" class="btn header-item waves-effect" data-toggle="dropdown">
        {!! Locales::current()->getSvgFlag(20, 20) !!}
    </button>

    <div class="dropdown-menu dropdown-menu-right">

        @foreach (Locales::get() as $locale)
            <a href="{{ route('dashboard.locale', $locale->getCode()) }}"
               class="dropdown-item notify-item d-flex align-items-center">

                {!! $locale->getSvgFlag(20, 20) !!}

                <span class="align-middle ml-2">{{ $locale->getName() }}</span>
            </a>
        @endforeach
    </div>
</div>
