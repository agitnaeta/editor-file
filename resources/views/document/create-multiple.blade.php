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
                        {{ csrf_field() }}
                    <div class="card-body">
                      <div class="block-editor-utama form-group">
                          <div class="form-editor-utama">
                              <div class="form-group">
                                  <label for="title">Judul</label>
                                  <input type="text" required class="form-control" name="title[]" id="title">
                              </div>
                              <div class="form-group">
                                  <label for="content">Konten Utama</label>
                                  <textarea class="form-control"
                                            required
                                            id="editor-utama"
                                            name="content[]"></textarea>
                              </div>
                          </div>
                      </div>




                      <div class="block-editor-dinamis">
{{--                         DISINI AKAN MASUK FORM DINAMIS--}}
                      </div>
                      <div class="form-group text-center">
                        <a href="#" id="tombol-tambah-form" class="btn btn-primary"> Tambah Pilihan </a>
                        <input type="readonly" disabled value="0" id="jumlah_form_dinamis"/>
                      </div>
                    </div>
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

        var editors = ['editor-utama'];
        var arrayOfEditor = [];
        // proses pembuatan Editor Pertama
        editors.map((editor)=>{
            // buat objek
            var objectCKEDITOR =  CKEDITOR.replace(editor,{})

            // tambahkan Button custom
            tambahkanButtonCustom(objectCKEDITOR, editor)

            // objet editor di koleksi di array
            arrayOfEditor.push(objectCKEDITOR)
        })




        // Fungsi membuat tombol form baru
        $('#tombol-tambah-form').click(function (e){
            e.preventDefault()

            let idform = Number($('#jumlah_form_dinamis').val()) + 1


            // gunakan template literal perhatikan ${idform}
            let formBaru  = `<div class="form-editor-dinamis" id="form-editor-dinamis-${idform}">
                                  <div class="form-group input-block">
                                      <label for="title">Judul</label>
                                      <input type="text" required class="form-control" name="title[]" id="title">
                                  </div>
                                  <div class="form-group textarea-block">
                                      <label for="content">Konten - <span class="content-title" ">${idform}</span></label>
                                      <textarea class="form-control text-editor-dinamis"
                                                required
                                                id="editor-dinamis-${idform}"
                                            name="content[]"></textarea>
                                </div>
                                <div class='form-group'>
                                       <a href="#" class='btn btn-danger' onclick="deleteBlock(${idform})"> Hapus Block</a>
                                </div>
                            </div>`

            // masukan ke block
            $('.block-editor-dinamis').append(formBaru)

            // masukan urutan terakhir ke jumlah_form_dinamis
            $('#jumlah_form_dinamis').val(idform)

            setTimeout(function (){
                var editorName = `editor-dinamis-${idform}`;
                if($(`#${editorName}`).length){
                   var editorDinamis =  $(`#${editorName}`).ckeditor()

                    // tambah kan button custom
                   tambahkanButtonCustom(editorDinamis.editor, editorName)

                    // Msukan Koleksi
                   arrayOfEditor.push(editorDinamis)
                }
                else{
                    alert(`Terjadi kesalahan Sistem`)
                }
            },300)
        })

        function deleteBlock(idform){


            // jika hanya ingin hapus saja
            // $(`#form-editor-dinamis-${idform}`).remove()

            // Jika ingin urutan namanya berubah dan ter reset


            $('.text-editor-dinamis').each(function (key,value){
                let editorName = `editor-dinamis-${key+1}`;
                CKEDITOR.instances[editorName].destroy()
            })

            $(`#form-editor-dinamis-${idform}`).remove()


            // reset id text area
            $('.text-editor-dinamis').each(function (key,value){
                $(this).attr('id',`editor-dinamis-${key+1}`)
            })

            // reset label
            $('.content-title').each(function (key,value){
                $(this).html(key+1)
            })

            // reset block id
            $('.form-editor-dinamis').each(function (key,value){
                $(this).attr('id',`form-editor-dinamis${key+1}`)

            })



            //reset jumlah form dinamis
             var jumlah = Number($("#jumlah_form_dinamis").val()) - 1
             $("#jumlah_form_dinamis").val(jumlah)






            setTimeout(function (){
                $('.text-editor-dinamis').each(function (key,value){
                    var editorName = `editor-dinamis-${key+1}`;
                    var editorDinamis =  $(`#${editorName}`).ckeditor()
                    console.log(editorName)

                    // tambah kan button custom
                    tambahkanButtonCustom(editorDinamis.editor, editorName)

                    // Msukan Koleksi
                    arrayOfEditor.push(editorDinamis)
                })
            },1000)

        }


        // Fungsi menambahkan tommbol dan fungsinya
        function tambahkanButtonCustom(objectCKEDITOR, editor){
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
        }






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
                    // Penempatan Dinamis
                    CKEDITOR.instances[editorName].insertHtml(html);
                }
            });
        });
    </script>
@endsection


