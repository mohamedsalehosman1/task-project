<div class="dropdown d-none d-sm-inline-block">
    <button type="button" class="btn header-item waves-effect"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {!! Locales::current()->getSvgFlag(30, 16) !!}
    </button>

    <div class="dropdown-menu dropdown-menu-right">
        @foreach (Locales::get() as $locale)
            <a href="{{ route('dashboard.locale', $locale->getCode()) }}" class="dropdown-item notify-item">
                {!! $locale->getSvgFlag(16, 12) !!}
                <span class="align-middle">{{ $locale->getName() }}</span>
            </a>
        @endforeach
    </div>
</div>
