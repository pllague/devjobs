const toggle = document.getElementById("default-toggle");

if (localStorage.getItem("dark_theme") === "true") {
  document.documentElement.classList.add('dark');

  toggle.setAttribute("checked", "");

} else {
  document.documentElement.classList.remove('dark');
}

toggle.addEventListener('change', (e) => {
  let val = e.target.checked;
  localStorage.setItem("dark_theme", `${val}`);

  if (e.target.checked) {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }
});