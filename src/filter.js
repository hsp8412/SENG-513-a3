function filterTable() {
  const searchInput = document.getElementById("search-bar").value.toLowerCase();
  const rows = document.querySelectorAll("#user-table tbody tr");

  rows.forEach((row) => {
    const username = row.cells[1].textContent.toLowerCase();
    if (username.includes(searchInput)) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  });
}
