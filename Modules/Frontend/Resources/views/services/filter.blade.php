<ul class="controls d-flex align-items-center justify-content-evenly mb-4">
    <li class="control" data-filter="all">
        <span>All</span>
    </li>

    @forelse ($services as $service)
        <li class="control" data-filter=".data-{{ $service->id }}">
            @if (pathinfo($service->getImage(), PATHINFO_EXTENSION) == 'svg')
                <svg viewBox="0 0 100 100">
                    {!! file_get_contents($service->getImage()) !!}
                </svg>
            @else
                <img src="{{ $service->getImage() }}" style="height:30px; width:30px;">
            @endif
            <span>{{ $service->name }}</span>
        </li>
    @empty
    @endforelse

</ul>
