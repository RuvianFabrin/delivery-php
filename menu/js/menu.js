$(".sidebar-dropdown > a").click(function () {
    $(".sidebar-submenu").slideUp(200);
    if (
        $(this)
        .parent()
        .hasClass("active-menu")
        ) {
        $(".sidebar-dropdown").removeClass("active-menu");
    $(this)
    .parent()
    .removeClass("active-menu");
} else {
    $(".sidebar-dropdown").removeClass("active-menu");
    $(this)
    .next(".sidebar-submenu")
    .slideDown(200);
    $(this)
    .parent()
    .addClass("active-menu");
}
});
$("#close-sidebar").click(function () {
    $(".page-wrapper").removeClass("toggled");
});
$("#show-sidebar").click(function () {
    $(".page-wrapper").addClass("toggled");
});