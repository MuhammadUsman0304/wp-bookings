jQuery(document).ready(function ($) {
    var popup = $('.dd-wp-chat-popup');
    var icon = $('.dd-wp-chat-icon');

    // Hide the popup initially
    popup.hide();

    // Show/hide the popup when the icon is clicked
    icon.click(function (event) {
        event.stopPropagation();
        popup.toggle();
    });

    // Hide the popup when the user clicks anywhere else on the page
    $(document).click(function () {
        popup.hide();
    });

    // Prevent the popup from closing when the user clicks inside it
    popup.click(function (event) {
        event.stopPropagation();
    });
});
