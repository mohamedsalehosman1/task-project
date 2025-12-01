
@isset($category)
    <input type="file" name="image" class="dropify"  data-default-file="{{ $category->getImage() }}" />
@else
    <input type="file" name="image" class="dropify" data-height="200" multiple/>
@endisset

@push('js')
    <script>
        $('.dropify').dropify();
    </script>
@endpush


{{-- @isset($category)
    {{ BsForm::image('image')->collection('images')->files($category->getMediaResource('images'))->notes(trans('categories::categories.attributes.image')) }}
@else
    {{ BsForm::image('image')->collection('images')->notes(trans('categories::categories.attributes.image')) }}
@endisset --}}
