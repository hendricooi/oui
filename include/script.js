
// ---------horizontal-navbar-menu-----------
var tabsNewAnim = $('#navbar-animmenu');
var selectorNewAnim = $('#navbar-animmenu').find('li').length;
var selectorNewAnim = $(".tabs").find(".selector");
var activeItemNewAnim = tabsNewAnim.find('.active');
var activeWidthNewAnimWidth = activeItemNewAnim.innerWidth();
var itemPosNewAnimLeft = activeItemNewAnim.position();
$(".hori-selector").css({
    "left": itemPosNewAnimLeft.left + "px",
    "width": activeWidthNewAnimWidth + "px"
});
$("#navbar-animmenu").on("click", "li", function (e) {
    $('#navbar-animmenu ul li').removeClass("active");
    $(this).addClass('active');
    var activeWidthNewAnimWidth = $(this).innerWidth();
    var itemPosNewAnimLeft = $(this).position();
    $(".hori-selector").css({
        "left": itemPosNewAnimLeft.left + "px",
        "width": activeWidthNewAnimWidth + "px"
    });
});

$("#navbar-animmenu").on("click", "#dashboardLink", function (e) {
            $('#navbar-animmenu ul li').removeClass("active");
            $(this).closest('li').addClass('active');

            var activeWidthNewAnimWidth = $(this).innerWidth();
            var itemPosNewAnimLeft = $(this).position();
            $(".hori-selector").css({
                "left": itemPosNewAnimLeft.left + "px",
                "width": activeWidthNewAnimWidth + "px"
            });

            $("#dashboardContent").show();
            $("#addressBookContent").hide();
        });

$("#navbar-animmenu").on("click", "#addressBookLink", function (e) {
            $('#navbar-animmenu ul li').removeClass("active");
            $(this).closest('li').addClass('active');

            var activeWidthNewAnimWidth = $(this).innerWidth();
            var itemPosNewAnimLeft = $(this).position();
            $(".hori-selector").css({
                "left": itemPosNewAnimLeft.left + "px",
                "width": activeWidthNewAnimWidth + "px"
            });

            $("#addressBookContent").show();
            $("#dashboardContent").hide();
        });
// ---------------------sideEquipment---------------//
var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".nested").classList.toggle("active");
    this.classList.toggle("caret-down");
});
}

//------------------Section Navigation----------//
function cellController(section){
    if(section == "P n P"){
        section = "PnP";
    }
    else if(section =="Single Reflow")
    {
        section = "Single_Reflow";
    }
    else if(section =="Indium Fluxer")
    {
        section = "Indium_Fluxer";
    }
    else if(section =="Indium Reflow")
    {
        section = "Indium_Reflow";
    }
    window.location.href = "\section\\" + section+".php";
}
