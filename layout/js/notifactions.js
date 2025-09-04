$(document).ready(function() {
    $(".summary").click(function() {
        Push.create("Hello Code Pioneer", {
            body: "New Summary added",
            icon: '../images/LogoCp.png',
            timeout: 10000,
            onClick: function() {
                window.focus();
                this.close();
            }
        })
    });

    $(".program").click(function() {
        Push.create("Hello Code Pioneer", {
            body: "New Program added",
            icon: '../images/LogoCp.png',
            timeout: 10000,
            onClick: function() {
                window.focus();
                this.close();
            }
        })
    });

    $(".post").click(function() {
        Push.create("Hello Code Pioneer", {
            body: "New Post added",
            icon: '../images/LogoCp.png',
            timeout: 10000,
            onClick: function() {
                window.focus();
                this.close();
            }
        })
    });

    $(".event").click(function() {
        Push.create("Hello Code Pioneer", {
            body: "New Event added",
            icon: '../images/LogoCp.png',
            timeout: 10000,
            onClick: function() {
                window.focus();
                this.close();
            }
        })
    });



});