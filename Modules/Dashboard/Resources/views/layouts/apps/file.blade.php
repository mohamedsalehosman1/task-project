@isset($file)
    <input type="file" name="{{ $name }}" class="dropify" data-default-file="{{ $file }}" />
@else
    <input type="file" name="{{ $name }}" class="dropify" data-height="200" />
@endisset

@push('js')
    <script>
        $('.dropify').dropify();
    </script>
@endpush
