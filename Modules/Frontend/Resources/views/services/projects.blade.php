<div class="projects">

    @forelse ($projects as $project)
        <!-- singl card -->
        <a class="card mix data-{{ $project->service_id }}" href="{{ route('project.details', $project->slug) }}" >
            <div class="img_card">
                <img class="lazyImage" src="{{ $project->getCover() }}" data-src="{{ $project->getFirstMediaUrl('cover') }}"  alt="" />
            </div>
            <div class="text">
                <div class="content">
                    <div class="title_card mb-1">{{ $project->name }}</div>
                    <div class="content_text">
                        {{ $project->short_brief }}
                    </div>
                </div>
            </div>
        </a>
    @empty
    @endforelse
        {{-- <script>
            addEventListener('load',function () {
                lazyImages.forEach(e => {
                    e.src = getAttribute('data-src')
                })
            })
        </script> --}}
</div>
