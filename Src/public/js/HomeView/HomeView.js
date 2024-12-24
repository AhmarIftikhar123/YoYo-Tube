import { BASE_URL } from "../config.js";
function debounce(func, delay = 500) {
  let timer;
  return function (...args) {
    clearTimeout(timer);
    timer = setTimeout(() => {
      func.apply(this, args);
    }, delay);
  };
}
const searchDebounce = debounce((query) => {
  $.ajax({
    url: `${BASE_URL}/home/search`,
    method: "POST",
    data: {
      query: query,
    },
    success: function (response) {
      console.log(response);
      if (response.success && Array.isArray(response.suggestions)) {
        response.suggestions.forEach((suggestion) => {
          $("#filterDetails").append(`<option value='${suggestion}'></option>`);
        });
      } else {
        $("#searchError").text(response.message);
      }
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}, 500);
function redirectToSearch(query) {
  if (query) {
    window.location.href = `/home?filter=${query}`; // Redirect to search page with query
  }
}
const searchInput = $("#searchInput");
const searchBtn = $("#searchBtn");
// Event listener for input changes
searchInput.on("input", function (event) {
  event.preventDefault();
  const query = searchInput.val();
  if (query.length > 0) {
    $("#filterDetails").empty();
    $("#searchError").text(""); // Clear error message
    searchDebounce(query.toLowerCase());
  }
});

// Event listener for "Enter" key on the input field
searchInput.on("keypress", function (event) {
  if (event.key === "Enter") {
    const query = searchInput.val().trim();
    redirectToSearch(query);
  }
});
// Search Button
searchBtn.on("click", function () {
  const query = searchInput.val().trim();
  redirectToSearch(query);
});
