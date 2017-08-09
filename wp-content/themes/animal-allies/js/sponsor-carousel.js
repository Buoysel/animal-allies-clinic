var ss1Index = 0;
var ss2Index = 0;
var ss3Index = 0;
var ss4Index = 0;


// make sure we wait until the DOM is ready to run this.
// this is short for $(document).ready(function() {});
$(carousel());


/**
 * Function used to animate the images on the sponsors page, along with css
 * animations in style.css
 */
function carousel() {
    var i;
    var ss1 = $(".slideShow1");
    var ss2 = $(".slideShow2");
    var ss3 = $(".slideShow3");
    var ss4 = $(".slideShow4");

    for (i = 0; i < ss1.length; i++) {
        ss1[i].style.display = "none";
    }
    ss1Index++;
    if (ss1Index > ss1.length) {ss1Index = 1}
    ss1[ss1Index-1].style.display = "block";

    for (i = 0; i < ss2.length; i++) {
        ss2[i].style.display = "none";
    }
    ss2Index++;
    if (ss2Index > ss2.length) {ss2Index = 1}
    ss2[ss2Index-1].style.display = "block";

    for (i = 0; i < ss3.length; i++) {
        ss3[i].style.display = "none";
    }
    ss3Index++;
    if (ss3Index > ss3.length) {ss3Index = 1}
    ss3[ss3Index-1].style.display = "block";

    for (i = 0; i < ss4.length; i++) {
        ss4[i].style.display = "none";
    }
    ss4Index++;
    if (ss4Index > ss4.length) {ss4Index = 1}
    ss4[ss4Index-1].style.display = "block";

    setTimeout(carousel, 6000);
}
