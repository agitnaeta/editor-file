@extends('layout')
@section('title','Tambah Multuple Dokumen')
@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Document</h4>
                    </div>

{{--
    Cukup gunakan blade function
    tidak peru echo "<element>" untuk lebih enak di liat
    $editors plural / array
    $editor satu string
--}}
                    <form action="{{ route('document.storeMultiple') }}" method='POST'>
                    @foreach($editors as $editor)
                    <div class="card-body">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" required class="form-control" name="title[]" id="title">
                        </div>
                        <div class="form-group">
                            <label for="content">Konten - {{$editor}}</label>
                            <textarea class="form-control"
                                      required
                                      id="{{$editor}}"  {{-- Nama Editor Dinamis --}}
                                      name="content[]"></textarea>
                        </div>
                    </div>
                    @endforeach
                        <div class="card-footer">
                            <div class="form-group">
                                <button class="btn btn-primary">Masukan Semua</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



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
                                <input id="audio-editor-name" disabled readonly type="text">
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
                    <h5 class="modal-title" id="recordVideoModalLabel">Record Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <input id="video-editor-name" disabled readonly type="text">
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
                                    <input type="text" readonly disabled id="file-editor-name">
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
                                    <input type="text" readonly disabled id="image-editor-name">
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


    <!-- Attach Video RTC Modal -->
    <div class="modal fade" id="attachVideoRTC" tabindex="-1" aria-labelledby="attachImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attachVideoRTC">Upload Video RTC</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <!-- 1. Include action buttons play/stop -->

                            <video id="my-preview" controls autoplay style="width: 100%"></video>
                            <div class="form-inline">
                                <button id="btn-start-recording" class="btn btn-primary">Start Recording</button>
                                <button id="btn-stop-recording" class="btn btn-danger">Stop Recording</button>
                            </div>
                            <input type="text" readonly disabled id="video-rtc-editor-name">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('script')
    <script>

{{--   $editors dapat dari backend yang sama nge load di text area      --}}
        var editors = @json($editors);
        var arrayOfEditor = [];


        // proses pembuatan objek
        editors.map((editor)=>{
            // buat objek
            var objectCKEDITOR =  CKEDITOR.replace(editor,{})

            // objet editor di koleksi di array
            arrayOfEditor.push(objectCKEDITOR)

            // menambahkan button
            objectCKEDITOR.ui.addButton('recordAudioButton', {
                label: "Record Audio",
                command: 'recordAudio',
                toolbar: 'insertCustom',
                icon: '{{ asset('icon/recordaudio.png') }}'
            });

            objectCKEDITOR.ui.addButton('recordButton', {
                label: "Record Video",
                command: 'recordVideo',
                toolbar: 'insertCustom',
                icon: '{{ asset('icon/recordvideo.png') }}'
            });

            objectCKEDITOR.ui.addButton('recordButtonVideoRTC', {
                label: "Record Video RTC",
                command: 'recordVideoRTC',
                toolbar: 'insertCustom',
                icon: '{{ asset('icon/recordvideo.png') }}'
            });


            objectCKEDITOR.ui.addButton('attachImage', {
                label: "Attach Image",
                command: 'attachImage',
                toolbar: 'insertCustom',
                icon: '{{ asset('icon/image.png') }}'
            });

            objectCKEDITOR.ui.addButton('documentButton', {
                label: "Attach Document",
                command: 'attachDocument',
                toolbar: 'insertCustom',
                icon: '{{ asset('icon/document.png') }}'
            });




            // Mendambahkan Command
            objectCKEDITOR.addCommand("recordAudio", {
                exec: function(edt) {
                    $("#recordingsList").html("");
                    $("#recordButton").text("Start Recording");
                    $("#attachRecord").addClass("d-none");
                    $("#recordAudioModal").modal("show");
                    // editor dari variable dinamis
                    $("#audio-editor-name").val(editor);
                }
            });

            objectCKEDITOR.addCommand("recordVideo", {
                exec: function(edt) {
                    $("#recordVideoModal").modal("show");

                    // editor dari variable dinamis
                    $("#video-editor-name").val(editor);
                }
            });

            objectCKEDITOR.addCommand("attachImage", {
                exec: function(edt) {
                    $("#attachImageModal").modal("show");

                    // editor dari variable dinamis
                    $("#image-editor-name").val(editor);
                }
            });

            objectCKEDITOR.addCommand("attachDocument", {
                exec: function(edt) {
                    $("#attachDocumentModal").modal("show");

                    // editor dari variable dinamis
                    $("#file-editor-name").val(editor);
                }
            });


            objectCKEDITOR.addCommand("recordVideoRTC", {
                exec: function(edt) {
                    $("#attachVideoRTC").modal("show");

                    // editor dari variable dinamis
                    $("#video-rtc-editor-name").val(editor);
                }
            });


        })


        // Untuk Melihat kumpulan objek
        console.log(arrayOfEditor)



        // Kumpulan Fungsi nya

        // Upload Image
        $("#imageForm").submit(function(e)
        {

            e.preventDefault();

            // cari name editor
            let editorName = $('#image-editor-name').val()
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

                    // Penempatan Dinamis
                    CKEDITOR.instances[editorName].insertHtml(html);
                }
            });
        });



        // Upload File

        $("#documentForm").submit(function(e)
        {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            // cari name editor
            let editorName = $('#file-editor-name').val()
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
                    CKEDITOR.instances[editorName].insertHtml(html);
                }
            });
        });
    </script>
@endsection


