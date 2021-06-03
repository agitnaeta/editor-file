<!-- Record Audio Modal -->
<div class="modal fade" id="recordAudioModal" tabindex="-1" aria-labelledby="recordAudioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="recordAudioModalLabel">Record Audio</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col">
                    <div id="controls">
                        <div id="recordingsList" class="mb-3 audio-container"></div>
                        <button id="recordButton" class="btn btn-danger btn-block">Start Recording</button>
                        <button id="stopButton" class="btn btn-danger btn-block d-none" disabled>Stop Recording</button>
                        <button id="attachRecord" class="btn btn-success btn-block d-none" disabled>Attach Recording</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<!-- Record Video Modal -->
<div class="modal fade" id="recordVideoModal" tabindex="-1" aria-labelledby="recordVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="recordVideoModalLabel">Record Audio</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col">
                    <video id="myVideo" playsinline class="video-js vjs-default-skin"></video>
                    <button id="attachVideo" class="btn btn-success btn-block d-none">Attach Video</button>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<!-- Attach Document Modal -->
<div class="modal fade" id="attachDocumentModal" tabindex="-1" aria-labelledby="attachDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="attachDocumentModalLabel">Attach Document</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col">
                    <form id="documentForm" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="upload" accept=".xls,.xlsx,.doc,.docx,.pdf">
                            <label class="custom-file-label" name="upload">Choose file (Word, Excel, PDF)</label>
                        </div>
                        <button class="btn btn-success btn-block mt-2">Attach Document</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<!-- Attach Image Modal -->
<div class="modal fade" id="attachImageModal" tabindex="-1" aria-labelledby="attachImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="attachImageModalLabel">Attach Image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col">
                    <form id="imageForm" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="upload" accept=".jpg,.png,.webp,.gif">
                            <label class="custom-file-label" name="upload">Choose file (JPG, PNG, WEBP, GIF)</label>
                        </div>
                        <button class="btn btn-success btn-block mt-2">Attach Image</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<script>
        
    let editor = CKEDITOR.replace('content', {
        filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    // Button
    editor.ui.addButton('recordAudioButton', {
        label: "Record Audio",
        command: 'recordAudio',
        toolbar: 'insertCustom',
        icon: '{{ asset('icon/recordaudio.png') }}'
    });

    editor.ui.addButton('recordButton', {
        label: "Record Video",
        command: 'recordVideo',
        toolbar: 'insertCustom',
        icon: '{{ asset('icon/recordvideo.png') }}'
    });

    editor.ui.addButton('attachImage', {
        label: "Attach Image",
        command: 'attachImage',
        toolbar: 'insertCustom',
        icon: '{{ asset('icon/image.png') }}'
    });

    editor.ui.addButton('documentButton', {
        label: "Attach Document",
        command: 'attachDocument',
        toolbar: 'insertCustom',
        icon: '{{ asset('icon/document.png') }}'
    });
    
    // Command
    editor.addCommand("recordAudio", {
        exec: function(edt) {
            $("#recordingsList").html("");
            $("#recordButton").text("Start Recording");
            $("#attachRecord").addClass("d-none");
            $("#recordAudioModal").modal("show");
        }
    });

    editor.addCommand("recordVideo", {
        exec: function(edt) {
            $("#recordVideoModal").modal("show");
        }
    });

    editor.addCommand("attachImage", {
        exec: function(edt) {
            $("#attachImageModal").modal("show");
        }
    });

    editor.addCommand("attachDocument", {
        exec: function(edt) {
            $("#attachDocumentModal").modal("show");
        }
    });

    $("#documentForm").submit(function(e)
    {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: "{{ route('upload') }}",
            data: formData,                         
            cache: false,
            contentType: false,
            processData: false,
            success: function(response)
            {
                let html = `<p><a href="${response}">${response}</a><p></p>`;

                $("#attachDocumentModal").modal("hide");
                CKEDITOR.instances.content.insertHtml(html);
            }
        });
    });

    $("#imageForm").submit(function(e)
    {
        e.preventDefault();
        console.log('ok');
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: "{{ route('upload') }}",
            data: formData,                         
            cache: false,
            contentType: false,
            processData: false,
            success: function(response)
            {
                let html = `<p><img src="${response}"><p></p>`;

                $("#attachImageModal").modal("hide");
                CKEDITOR.instances.content.insertHtml(html);
            }
        });
    });

</script>