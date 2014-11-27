$(window).load(function() {
    $('#slider').nivoSlider({
        effect:'fold,sliceUpDown', // Specify sets like: 'fold,fade,sliceDown'
        animSpeed:500, // Slide transition speed
        pauseTime:6000, // How long each slide will show
        startSlide:0 // Set starting Slide (0 index)
    });
});