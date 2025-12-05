@props(['name', 'values', 'label', 'columns'])

<div class="form-group {{ $columns }}">
    <label for="{{ $name }}" class="col-sm-12">{{ $label }}</label>
    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <button type="button" class="input-group-text" onclick="openFileManager('{{ $name }}')">
                    <i class="fa fa-chevron-up"> &nbsp;Click here to choose</i>
                </button>
            </div>
            <input type="hidden" name="{{ $name }}" id="{{ $name }}" value="{{ json_encode($values) }}">
            <div class="input-group-append">
                <button type="button" class="input-group-text" onclick="viewSelectedFiles('{{ $name }}')">
                    <i class="fa fa-eye"></i>
                </button>
            </div>
        </div>
        <div class="mt-2" id="preview-{{ $name }}">
            @if($values)
                @foreach($values as $value)
                    <div class="position-relative" style="display: inline-block; margin-right: 10px;">
                        <img src="{{ asset($value) }}" alt="" onerror="this.src='/img/logo.png';" style="height:30px;">
                        <button type="button" class="btn btn-sm btn-danger position-absolute" style="top:0; right:0;" onclick="removeImage('{{ $name }}', '{{ $value }}')">X</button>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

@push('script')
<script>
function openFileManager(inputId) {
    window.open('/laravel-filemanager', 'fm', 'width=900,height=600');
    window.SetUrl = function (items) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById('preview-' + inputId);

        let filePaths = items.map(item => item.url);
        input.value = JSON.stringify(filePaths);

        preview.innerHTML = '';
        filePaths.forEach(path => {
            let imgContainer = document.createElement('div');
            imgContainer.classList.add('position-relative', 'mr-2', 'mb-2');
            imgContainer.style.display = 'inline-block';

            let img = document.createElement('img');
            img.src = path;
            img.style.height = '50px';

            let removeButton = document.createElement('button');
            removeButton.classList.add('btn', 'btn-sm', 'btn-danger', 'position-absolute');
            removeButton.style.top = '0';
            removeButton.style.right = '0';
            removeButton.textContent = 'X';
            removeButton.onclick = function() { removeImage(inputId, path); };

            imgContainer.appendChild(img);
            imgContainer.appendChild(removeButton);

            preview.appendChild(imgContainer);
        });
    };
}

function removeImage(inputId, path) {
    const input = document.getElementById(inputId);
    let filePaths = JSON.parse(input.value || '[]');

    filePaths = filePaths.filter(p => p !== path);
    input.value = JSON.stringify(filePaths);

    const preview = document.getElementById('preview-' + inputId);
    preview.innerHTML = '';
    filePaths.forEach(p => {
        let imgContainer = document.createElement('div');
        imgContainer.classList.add('position-relative', 'mr-2', 'mb-2');
        imgContainer.style.display = 'inline-block';

        let img = document.createElement('img');
        img.src = p;
        img.style.height = '50px';

        let removeButton = document.createElement('button');
        removeButton.classList.add('btn', 'btn-sm', 'btn-danger', 'position-absolute');
        removeButton.style.top = '0';
        removeButton.style.right = '0';
        removeButton.textContent = 'X';
        removeButton.onclick = function() { removeImage(inputId, p); };

        imgContainer.appendChild(img);
        imgContainer.appendChild(removeButton);

        preview.appendChild(imgContainer);
    });
}

function viewSelectedFiles(inputId) {
    const input = document.getElementById(inputId);
    const filePaths = JSON.parse(input.value || '[]');
    if (filePaths.length > 0) {
        let imagesHtml = filePaths.map(path => '<img src="' + path + '" style="width:100%; margin-bottom: 10px;" />').join('');
        $('#fileViewModalBody').html(imagesHtml);
        $('#fileViewModal').modal('show');
    } else {
        alert('No files selected');
    }
}
</script>

@endpush