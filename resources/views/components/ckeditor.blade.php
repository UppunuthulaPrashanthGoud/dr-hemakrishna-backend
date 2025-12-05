<div {{ $attributes }}>
    <textarea id="{{ $id }}" name="{{ $name }}" class="ckeditor">{{ htmlspecialchars_decode($value) }}</textarea>
</div>

@push('scripts')
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        CKEDITOR.replace('{{ $id }}', {
            on: {
                instanceReady: function (evt) {
                    evt.editor.setData(`{!! $value !!}`);
                }
            }
        });
    });
</script>
@endpush
