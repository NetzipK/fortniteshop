$(document).ready(function() {
    $(".item-link").click(function(e) {
        e.preventDefault();
        // $("#content-menu").html('<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>');
        link = $(this).attr('href');
        window.history.pushState("", "", link);
        $("#content-menu").load(link+" #profile-content", function(responseTxt, statusTxt, xhr){
            if(statusTxt == "success")
                document.getElementById("defaultOpen").click();
            // if(statusTxt == "error")
                // alert("Error: " + xhr.status + ": " + xhr.statusText);
          });
    });
});

document.getElementById("defaultOpen").click();

function openTab(evt, tabName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
    // $(evt).addClass("active");
}

function copyToClip() {
    var copyText = document.getElementById("copyInput");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");

    var tooltip = document.getElementById("myTooltip");
    tooltip.innerHTML = "Link Copied!";
}

function mouseOutCopy() {
    var tooltip = document.getElementById("myTooltip");
    tooltip.innerHTML = "Copy to clipboard";
}
