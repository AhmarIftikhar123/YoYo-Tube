$(".nav-link").click(function (e) {
  $(".nav-link").removeClass("active");
  $(this).addClass("active");
});

// Add active class to current page
(() => {
  let currentUrl = window.location.pathname;
  $(".nav-link").each(function () {
    const link = $(this).attr("href");
    if (link === currentUrl || link === currentUrl + "/") {
      $(this).addClass("active");
    }
  });
})();
$(".navbar-nav>li>a").on("click", function () {
  $(".navbar-collapse").collapse("hide");
});
$(document).on("click", function (e) {
  if (!$(e.target).closest(".navbar-collapse").length) {
    $(".navbar-collapse").collapse("hide");
  }
});
// Check for saved theme preference
const savedTheme = localStorage.getItem("theme");
if (savedTheme === "lime-theme") {
  document.body.classList.add("lime-theme");
  $("#themeToggler").attr("aria-label", "lime-theme");
}

// Save theme preference
$("#themeToggler").on("click", function () {
  $("body").toggleClass("lime-theme");

  $(this).children("i").toggleClass("fa-sun fa-moon");
  if ($(this).attr("aria-label") === "lime-theme") {
    // Reset aria-label
    $(this).attr("aria-label", "");
    // Set theme
    localStorage.setItem("theme", "lime");
  } else {
    $(this).attr("aria-label", "lime-theme");
    localStorage.setItem("theme", "lime-theme");
  }

  const isOnPaymentPage = localStorage.getItem("isOnPaymentPage");
  if (isOnPaymentPage) {
    updateCardStyles();
  }
});
function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
}
const offcanvas = new bootstrap.Offcanvas("#profileOffcanvas");
const profileToast = new bootstrap.Toast("#profileToast");

$("#profile").on("click", function (e) {
  const isUserRegistered = getCookie("user_id");
  if (isUserRegistered) {
    offcanvas.show();
  }
  getCookie("user_id") ? offcanvas.show() : profileToast.show();
});
