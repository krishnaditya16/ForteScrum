/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

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


