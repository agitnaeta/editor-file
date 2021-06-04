<script>
    var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
    var isEdge = /Edge/.test(navigator.userAgent);
    var isOpera = !!window.opera || navigator.userAgent.indexOf('OPR/') !== -1;

    function applyAudioWorkaround() {
        if (isSafari || isEdge) {
            if (isSafari && window.MediaRecorder !== undefined) {
                // this version of Safari has MediaRecorder
                // but use the only supported mime type
                options.plugins.record.audioMimeType = 'audio/mp4';
            } else {
                // support recording in safari 11/12
                // see https://github.com/collab-project/videojs-record/issues/295
                options.plugins.record.audioRecorderType = StereoAudioRecorder;
                options.plugins.record.audioSampleRate = 44100;
                options.plugins.record.audioBufferSize = 4096;
                options.plugins.record.audioChannels = 2;
            }

            console.log('applied audio workarounds for this browser');
        }
    }

    function applyVideoWorkaround() {
        // use correct video mimetype for opera
        if (isOpera) {
            options.plugins.record.videoMimeType = 'video/webm\;codecs=vp8'; // or vp9
        }
    }

    function applyScreenWorkaround() {
        // Polyfill in Firefox.
        // See https://blog.mozilla.org/webrtc/getdisplaymedia-now-available-in-adapter-js/
        if (adapter.browserDetails.browser == 'firefox') {
            adapter.browserShim.shimGetDisplayMedia(window, 'screen');
        }
    }
    var options = {
        controls: true,
        bigPlayButton: false,
        fluid: true,
        plugins: {
            record: {
                audio: true,
                video: true,
                maxLength: 3600,
                debug: true
            }
        }
    };

    // apply some workarounds for opera browser
    applyVideoWorkaround();

    var player = videojs('myVideo', options, function() {
        // print version information at startup
        var msg = 'Using video.js ' + videojs.VERSION +
            ' with videojs-record ' + videojs.getPluginVersion('record') +
            ' and recordrtc ' + RecordRTC.version;
        videojs.log(msg);
    });

    // error handling
    player.on('deviceError', function() {
        console.log('device error:', player.deviceErrorCode);
    });

    player.on('error', function(element, error) {
        console.error(error);
    });

    // user clicked the record button and started recording
    player.on('startRecord', function() {
        console.log('started recording!');
    });

    // user completed recording and stream is available
    player.on('finishRecord', function()
    {
        $("#attachVideo").removeClass("d-none");
    });

    $("#attachVideo").click(function()
    {
        let blob = player.recordedData;
        console.log(blob)
        let filename = 'sdfgsdfg';
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
                let html = `<p><video width="100%" controls><source src="${response}" type="video/mp4"></video></p><p></p>`;

                player.record().reset();

                $("#attachVideo").addClass("d-none");
                $("#recordVideoModal").modal("hide");

                var namaEditor
                if($('#video-editor-name').val()){
                    namaEditor = $('#video-editor-name').val();
                }
                else{
                    namaEditor = 'content'
                }
                CKEDITOR.instances[namaEditor].insertHtml(html);
            }
        });
    });
</script>
