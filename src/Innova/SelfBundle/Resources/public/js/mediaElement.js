$(document).ready(function() {
    $('#situation').mediaelementplayer({
    // if set, overrides <video width>
        videoWidth: 164,
        // width of audio player
        audioWidth: 164,
        // the order of controls you want on the control bar (and other plugins below)
        features: ['current','duration']
    });
});
