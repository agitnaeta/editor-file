
<!-- 3. Include the RecordRTC library and the latest adapter -->
<script src="https://cdn.webrtc-experiment.com/RecordRTC.js"></script>
<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>



<script>

    // Store a reference of the preview video element and a global reference to the recorder instance
    var video = document.getElementById('my-preview');
    if(video!==null){
        var recorder;

        // When the user clicks on start video recording
        document.getElementById('btn-start-recording').addEventListener("click", function(){
            // Disable start recording button
            this.disabled = true;

            // Request access to the media devices
            navigator.mediaDevices.getUserMedia({
                audio: true,
                video: true
            }).then(function(stream) {
                // Display a live preview on the video element of the page
                setSrcObject(stream, video);

                // Start to display the preview on the video element
                // and mute the video to disable the echo issue !
                video.play();
                video.muted = true;

                // Initialize the recorder
                recorder = new RecordRTCPromisesHandler(stream, {
                    mimeType: 'video/webm',
                    bitsPerSecond: 4096
                });

                // Start recording the video
                recorder.startRecording().then(function() {
                    document.getElementById('btn-start-recording').innerHTML = 'Recording Video'
                }).catch(function(error) {
                    console.error('Cannot start video recording: ', error);
                });

                // release stream on stopRecording
                recorder.stream = stream;

                // Enable stop recording button
                document.getElementById('btn-stop-recording').disabled = false;
            }).catch(function(error) {
                console.error("Cannot access media devices: ", error);
            });
        }, false);

        // When the user clicks on Stop video recording
        document.getElementById('btn-stop-recording').addEventListener("click", function(){
            this.disabled = true;

            recorder.stopRecording().then(function() {
                console.log(recorder)
                console.info('stopRecording success');

                // Retrieve recorded video as blob and display in the preview element
                var blob = recorder.blob
                video.src  = window.URL.createObjectURL(recorder.blob)
                upload(recorder.blob)

                video.play();

                // Unmute video on preview
                video.muted = false;

                // Stop the device streaming
                recorder.stream.stop();

                // Enable record button again !
                document.getElementById('btn-start-recording').disabled = false;
            }).catch(function(error) {
                console.error('stopRecording failure', error);
            });
        }, false);


        function upload(blob){
            var fd = new FormData();

            fd.append("upload",blob, 'file-name');
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

                    $("#attachVideoRTC").modal("hide");

                    var namaEditor
                    if($('#video-rtc-editor-name').val()){
                        namaEditor = $('#video-rtc-editor-name').val();
                    }
                    else{
                        namaEditor = 'content'
                    }
                    CKEDITOR.instances[namaEditor].insertHtml(html);
                }
            });
        }
    }
</script>