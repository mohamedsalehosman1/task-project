@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@bsMultilangualFormTabs
    {{-- حقل اسم القسم --}}
    {{ BsForm::text('name')->label('اسم القسم')->required() }}

    {{-- حقل النوع --}}
    {{ BsForm::select('type')
        ->options([
            'main' => 'رئيسي',
            'sub' => 'فرعي'
        ])
        ->label('النوع')
        ->required()
    }}
@endBsMultilangualFormTabs

{{ BsForm::select('type')
    ->label(__('categories::categories.attributes.type'))
    ->options([
        'project' =>   __('categories::categories.attributes.project') ,
        'product' =>  __('categories::categories.attributes.product') ,
    ])
    ->placeholder('Select one')
    ->required() }}


{{-- <label>{{ __('categories::categories.attributes.image') }}</label>

@isset($category)
    @include('dashboard::layouts.apps.file', [
        'file' => $category->getImage(),
        'name' => 'image'
    ])
@else
    @include('dashboard::layouts.apps.file', ['name' => 'image'])
@endisset --}}
