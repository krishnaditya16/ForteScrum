/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$(window).on("load", function () {
    $("#preloader-active").delay(450).fadeOut("slow");
    $("body").delay(450).css({
        overflow: "visible",
    });
});

$(document).ready(function () {
    $(document).on("click", ".link-dropdown-kanban", function () {
        var form = $(this).closest("form");
        form.submit();
    });
});

function printContent(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}

$("#meetingType").change(function () {
    if ($(this).val() == "1") {
        $("#meetingLink").show();
        $("#link").attr("required", "");
        $("#link").attr("data-error", "This field is required.");
    } else {
        $("#meetingLink").hide();
        $("#link").removeAttr("required");
        $("#link").removeAttr("data-error");
    }
});
$("#meetingType").trigger("change");

$("#meetingType").change(function () {
    if ($(this).val() == "0") {
        $("#meetingLocation").show();
        $("#location").attr("required", "");
        $("#location").attr("data-error", "This field is required.");
    } else {
        $("#meetingLocation").hide();
        $("#location").removeAttr("required");
        $("#location").removeAttr("data-error");
    }
});
$("#meetingType").trigger("change");

$(document).ready(function () {
    $(document).on("click", ".notif-read", function () {
        var form = $(this).closest("form");
        form.submit();
        e.preventDefault();
    });
});

$(document).ready(function () {
    $(".btn-receipt").click(function () {
        $("#receipt_toggle").toggle();
    });
});

$(document).ready(function () {
    $(".btn-role").click(function () {
        var text = document.getElementById("role-answer");
        var role = document.getElementById("btn-role");
        var role2 = document.getElementById("role-hdn");
        if (text.innerHTML == "No") {
            text.innerHTML = "Yes";
            role.value = 1;
            role2.value = 1;
        } else {
            text.innerHTML = "No";
            role.value = 0;
            role2.value = 1;
        }
        console.log(role);
        console.log(role2);
    });
});

$("#paymentMethod").change(function () {
    if ($(this).val() == "0") {
        $("#transactionID").show();
        $("#transaction_id").attr("required", "");
        $("#transaction_id").attr("data-error", "This field is required.");
    } else {
        $("#transactionID").hide();
        $("#transaction_id").removeAttr("required");
        $("#transaction_id").removeAttr("data-error");
    }
});
$("#paymentMethod").trigger("change");
