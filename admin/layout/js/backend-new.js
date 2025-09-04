$(document).ready(function() {


    $("#menu-btn").click(function() {
        $("#menu").toggleClass("active");
    });


    var url_string = window.location;
    var url = new URL(url_string);
    var name = url.searchParams.get("do");
    if (name == null) {
        $("#menu .items li:nth-child(1)").css("borderLeft", "4px solid #fff");
    } else if (name == "manage-workers") {
        $("#menu .items li:nth-child(2)").css("borderLeft", "4px solid #fff");
    } else if (name == "manage-salaries") {
        $("#menu .items li:nth-child(3)").css("borderLeft", "4px solid #fff");
    } else if (name == "manage-companies") {
        $("#menu .items li:nth-child(4)").css("borderLeft", "4px solid #fff");
    } else if (name == "manage-fields") {
        $("#menu .items li:nth-child(5)").css("borderLeft", "4px solid #fff");
    } else if (name == "manage") {
        $("#menu .items li:nth-child(6)").css("borderLeft", "4px solid #fff");
    }else if (name == "manage-rates") {
        $("#menu .items li:nth-child(7)").css("borderLeft", "4px solid #fff");
    }else if (name == "manage-socialmedia") {
        $("#menu .items li:nth-child(8)").css("borderLeft", "4px solid #fff");
    }else if (name == "manage-information") {
        $("#menu .items li:nth-child(9)").css("borderLeft", "4px solid #fff");
    }else if (name == "manage-aboutus") {
        $("#menu .items li:nth-child(10)").css("borderLeft", "4px solid #fff");
    }





});