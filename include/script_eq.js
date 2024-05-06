// ---------------------sideEquipment---------------//

var i;
var eqpId ="";
var path = "C:/xampp/htdocs/oui/";

var ajaxRequestSent = false;

var toggler = document.getElementsByClassName("caret");
for (i = 0; i < toggler.length; i++) {
toggler[i].addEventListener("click", function() {
    this.classList.toggle("caret-down");
    this.parentElement.querySelector(".nested").classList.toggle("active");
});
}

function openEQ(eq, item, element) {
    // Get the div element corresponding to the item
    var divId = eq + "-" + item + "-div";
    var divElement = document.getElementById(divId);

    // Check if the divElement exists
    if (divElement) {
        // Iterate over all elements with the same eq
        var elements = document.querySelectorAll("[id^='" + eq + "-']");
        elements.forEach(function(el) {
            // Toggle the visibility of the element
            if (el.id === divId) {
                // Show the current element
                el.style.display = "block";
            } else {
                // Hide other elements
                el.style.display = "none";
            }
        });

        // Add 'highlight' class to the clicked element
        document.querySelectorAll('.highlight').forEach(el => {
            el.classList.remove('highlight');
        });
        element.classList.add('highlight');
        updateVariable(item);
            // Send AJAX request to set session variable
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../set_session.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Handle the response if needed
                    console.log(xhr.responseText);
                    // Session variable set successfully
                    console.log(item);
                    
                    console.log('Session variable set successfully');
                } else {
                    // Error setting session variable
                    console.error('Error setting session variable');
                }
            };
            xhr.send("eqpId=" + item);
        }else {
            console.error("Div element not found:", divId);
        }
    }

function updateVariable(item){
    eqpId = item;
}

function checkLoggedIn(callback) {
    // Send an AJAX request to check the login status
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Response from the server
            var response = this.responseText;
            if (response === 'true') {
                callback()
            } else {
                alert('Please log in before you can perform this action.');
                // Perform actions for when the user is not logged in
            }
        }
    };
    xhttp.open("GET","../check_login.php", true);
    xhttp.send();
}


//Equipment page Login Form open/close
function openForm() {
    document.getElementById("myForm").style.display = "block";
}

function closeForm() {
    document.getElementById("myForm").style.display = "none";
}
function logout(){
    window.location.href ='/oui/logout.php';
}    function closeWindow() {
    // Close the pop-out window
    window.close();
}
function checkEmpty(event) {
    // Check if the event target is the submit button
    if (event.submitter && event.submitter.name === 'submit') {
        // Get the value of the lotId input field
        var lotId = document.querySelector('input[name="lotId"]').value;

        // Check if the value is empty
        if (lotId.trim() === '') {
            // Display an alert message
            alert("Please fill in the Lot ID.");
            // Prevent the form from submitting
            event.preventDefault();
            return false;
        }
    }
    // If the event target is not the submit button or the field is not empty, allow the form to submit
    return true;
}

function unloadLotPopoutWindow() {
    checkLoggedIn(openUnloadPage); // Check if logged in and open page if so
}

function openUnloadPage() {
    var info = "1";

    if (ajaxRequestSent) {
        return; // If so, exit the function
    }
    ajaxRequestSent = true;
    // Call the PHP function using AJAX
    $.ajax({
        type: 'POST',
        url: '../send_unload.php', // This will post to the same PHP file
        data: {info: info, eqpId: eqpId},
        success: function(response) {
            // Handle success response
            console.log(response);
            var url = "../window/unload_page.php";

            // Define the dimensions and position of the pop-out window
            var width = 600;
            var height = 400;
            var left = (screen.width - width) / 2;
            var top = (screen.height - height) / 2;

            // Open the pop-out window with specified dimensions and position
            window.open(url, "popoutWindow", "width=" + width + ", height=" + height + ", left=" + left + ", top=" + top);
            
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(error);
        },
        complete: function() {
            // Reset the flag after the request is complete (success or error)
            ajaxRequestSent = false;
        }
    });
}


function openLoadPopoutWindow() {
    // Define the URL of the pop-out window
    // Check if the user is logged in before opening the popout window

    var openWindowIfLoggedIn = function() {
    var url = "../window/load_page.php";

    // Define the dimensions and position of the pop-out window
    var width = 600;
    var height = 400;
    var left = (screen.width - width) / 2;
    var top = (screen.height - height) / 2;

    // Open the pop-out window with specified dimensions and position
    window.open(url, "popoutWindow", "width=" + width + ", height=" + height + ", left=" + left + ", top=" + top);
};
checkLoggedIn(openWindowIfLoggedIn);

}

function openCancelLotPopoutWindow() {
    // Define the URL of the pop-out window
    var openWindowIfLoggedIn = function() {
    var url = "../window/cancel_load_page.php"; 

    // Define the dimensions and position of the pop-out window
    var width = 600;
    var height = 400;
    var left = (screen.width - width) / 2;
    var top = (screen.height - height) / 2;

    // Open the pop-out window with specified dimensions and position
    window.open(url, "popoutWindow", "width=" + width + ", height=" + height + ", left=" + left + ", top=" + top);
};

// Check if the user is logged in before opening the popout window
checkLoggedIn(openWindowIfLoggedIn);
}
