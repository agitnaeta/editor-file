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
        $("#stopButton").removeClass("d-none").prop('disabled',false);
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
        rec.exportWAV(createPreview);
    }

    $("#attachRecord").click(function()
    {
        rec.exportWAV(uploadAudio);
    });

    function uploadAudio(blob)
    {
        var fd = new FormData();
        var filename = "nama-file-aurio";

        fd.append("upload", blob, filename);
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
                let html = `<p><audio style="width: 100%" controls="" src="${response}"></audio></p><p></p>`;

                $("#recordAudioModal").modal("hide");

                // mencari value
                var namaEditor
                if($('#audio-editor-name').val()){
                     namaEditor = $('#audio-editor-name').val();
                }
                else{
                    namaEditor = 'content'
                }

                CKEDITOR.instances[namaEditor].insertHtml(html);
            }
        });
    }

    function createPreview(blob)
    {
        var url = URL.createObjectURL(blob);
        var au = document.createElement('audio');

        au.controls = true;
        au.src = url;

        $("#recordingsList").html(au);
        $("#attachRecord").removeClass("d-none").attr("disabled", false);
    }

</script>
