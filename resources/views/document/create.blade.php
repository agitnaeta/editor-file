@extends('layout')
@section('title','Tambah Document')
@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Document</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('document.store') }}" method='POST'>
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">Judul</label>
                                <input type="text" class="form-control" name="title" id="title">
                            </div>
                            <div class="form-group">
                                <label for="content">Konten</label>
                                <textarea class="form-control" id="content" name="content"></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal -->
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
    
@endsection
@section('script')
    <script>
        
        let editor = CKEDITOR.replace('content', {
                filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
                filebrowserUploadMethod: 'form'
            });

        editor.addCommand("recordAudio", {
            exec: function(edt) {
                $("#recordingsList").html("");
                $("#recordButton").text("Start Recording");
                $("#attachRecord").addClass("d-none");
                $("#recordAudioModal").modal("show");
            }
        });

        editor.ui.addButton('SuperButton', {
            label: "Record Audio",
            command: 'recordAudio',
            toolbar: 'insert',
            icon: '{{ asset('icon/recordaudio.png') }}'
        });
        
    </script>
    <!-- inserting these scripts at the end to be able to use all the elements in the DOM -->
  	<script src="https://cdn.rawgit.com/mattdiamond/Recorderjs/08e7abd9/dist/recorder.js"></script>
  	<script>
        //webkitURL is deprecated but nevertheless
        URL = window.URL || window.webkitURL;

        var gumStream; 						//stream from getUserMedia()
        var rec; 							//Recorder.js object
        var input; 							//MediaStreamAudioSourceNode we'll be recording

        // shim for AudioContext when it's not avb. 
        var AudioContext = window.AudioContext || window.webkitAudioContext;
        var audioContext //audio context to help us record

        document.getElementById("recordButton").addEventListener("click", startRecording);
        document.getElementById("stopButton").addEventListener("click", stopRecording);

        function startRecording()
        {
            var constraints = { audio: true, video:false }

            $("#recordingsList").html('');
            $("#recordButton").addClass("d-none");
            $("#stopButton").removeClass("d-none");
            $("#attachRecord").addClass("d-none");

            recordButton.disabled = true;
            stopButton.disabled = false;

            navigator.mediaDevices.getUserMedia(constraints).then(function(stream)
            {
                audioContext = new AudioContext();
                gumStream = stream;
                input = audioContext.createMediaStreamSource(stream);

                rec = new Recorder(input,{numChannels:1})
                rec.record()

            }).catch(function(err)
            {
                recordButton.disabled = false;
                stopButton.disabled = true;
            });

            localStorage.setItem("countStatus", true);
            counting(0,0);
        }

        let setTimeoutCounting;
        function counting(sec, minute)
        {
            sec = sec+1;
            let secDisplay = sec;
            if(sec === 60)
            {
                minute = minute+1;
                sec = 0;
            }
            if(sec <= 9)
            {
                secDisplay = '0'+sec;
            }
            setTimeoutCounting = setTimeout(function(){
                $("#stopButton").text(`Stop Recording (${minute}:${secDisplay})`);
                counted(sec, minute);
            }, 1000);
        }

        let setTimeoutCounted;
        function counted(sec, minute)
        {
            sec = sec+1;
            let secDisplay = sec;
            if(sec === 60)
            {
                minute = minute+1;
                sec = 0;
            }
            if(sec <= 9)
            {
                secDisplay = '0'+sec;
            }
            setTimeoutCounted = setTimeout(function(){
                $("#stopButton").text(`Stop Recording (${minute}:${secDisplay})`);
                counting(sec, minute);
            }, 1000);
        }

        function stopRecording()
        {
            clearTimeout(setTimeoutCounting);
            clearTimeout(setTimeoutCounted);

            $("#recordButton").removeClass("d-none");
            $("#stopButton").addClass("d-none");
            $("#recordButton").text("Record Again");

            stopButton.disabled = true;
            recordButton.disabled = false;

            rec.stop();
            gumStream.getAudioTracks()[0].stop();
            rec.exportWAV(createDownloadLink);
        }

        function createDownloadLink(blob) {
            
            var url = URL.createObjectURL(blob);
            var au = document.createElement('audio');
            var li = document.createElement('div');
            var link = document.createElement('a');
            var filename = new Date().toISOString();

            au.controls = true;
            au.src = url;

            li.appendChild(au);
            li.appendChild(link);

            $("#recordingsList").html(li);
            $("#attachRecord").removeClass("d-none").attr("disabled", false);
            $("#attachRecord").click(function()
            {
                var fd = new FormData();                  
                fd.append("upload",blob, filename);
                fd.append("_token", "{{ csrf_token() }}");
                $.ajax({
                    type: "POST",
                    url: "{{ route('upload') }}",
                    data: fd,                         
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response)
                    {
                        let html = `<audio style="width: 100%" controls="" src="${response}"></audio><p></p>`;

                        $("#recordAudioModal").modal("hide");
                        CKEDITOR.instances.content.insertHtml(html);
                    }
                });
            });
        }

      </script>
@endsection