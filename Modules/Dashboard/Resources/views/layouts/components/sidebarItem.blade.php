@if((isset($can['permission'])
    && auth()->user()->isAbleTo([$can['permission']]))
    || ! isset($can))

    <li class="{{ isset($isActive) && $isActive ? 'mm-active' : '' }}">
        <a href="{{ $url ?? 'javascript:void(0);' }}"
           class="{{ isset($tree) && is_array($tree) ? 'has-arrow' : '' }} waves-effect {{ isset($isActive) && $isActive ? 'active' : '' }}">
            @isset($icon)
                <i class="{{ $icon }}"></i>
            @endisset
            <span>{{ $name }}</span>

            {{-- لو فيه Badge (زي طلبات معلقة) --}}
            @if(isset($badge) && $badge > 0)
                <span class="badge rounded-pill bg-danger float-end">{{ $badge }}</span>
            @endif
        </a>

        @if(isset($tree) && is_array($tree) && count($tree))
            <ul class="sub-menu" aria-expanded="{{ isset($isActive) && $isActive ? 'true' : 'false' }}">
                @foreach($tree as $item)
                    @if(isset($item['module']) && \Module::collections()->has($item['module']))
                        @if((isset($item['can']['permission'])
                            && auth()->user()->isAbleTo($item['can']['permission']))
                            || ! isset($item['can']))
                            <li class="{{ isset($item['isActive']) && $item['isActive'] ? 'mm-active' : '' }}">
                                <a href="{{ $item['url'] ?? 'javascript:void(0);' }}"
                                   class="waves-effect {{ isset($item['isActive']) && $item['isActive'] ? 'active' : '' }}">
                                    @isset($item['icon'])
                                        <i class="{{ $item['icon'] }}"></i>
                                    @endisset

                                    {{ $item['name'] }}

                                    @if(isset($item['badge']) && $item['badge'] > 0)
                                        <span class="badge rounded-pill bg-danger float-end">{{ $item['badge'] }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif
                    @endif
                @endforeach
            </ul>
        @endif
    </li>
@endif
