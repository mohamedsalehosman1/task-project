
@isset($file)
    <input type='file' name='{{ $name }}' class='dropify' data-show-remove='false'  data-default-file='{{ $file }}'  @isset ($mimes) data-allowed-file-extensions='{{ $mimes }}' @endisset />
@else
    <input type='file' name='{{ $name }}' class='dropify' data-show-remove='false'  data-height='200' @isset ($mimes) data-allowed-file-extensions='{{ $mimes }}' @endisset  />
@endisset

@push('js')
    <script>
        $('.dropify').dropify();
    </script>
@endpush
