// Set the default active tab
$("#login").addClass("active");
$('.tabs-trigger[data-tab="login"]').addClass("active");

// Handle tab switching
$(".tabs-trigger").click(function () {
  const tab = $(this).data("tab");

  // Remove active class from all tabs and contents
  $(".tabs-trigger").removeClass("active");
  $(".tabs-content").removeClass("active");

  // Add active class to the selected tab and corresponding content
  $(this).addClass("active");
  $("#" + tab).addClass("active");
});
