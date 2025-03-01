document.addEventListener("DOMContentLoaded", function () {
    const toggleSwitch = document.getElementById("theme-toggle");
    const currentTheme = localStorage.getItem("theme");

    if (currentTheme === "dark") {
        document.body.classList.add("dark-mode");
        toggleSwitch.checked = true;
    }

    toggleSwitch.addEventListener("change", function () {
        if (toggleSwitch.checked) {
            document.body.classList.add("dark-mode");
            localStorage.setItem("theme", "dark");
        } else {
            document.body.classList.remove("dark-mode");
            localStorage.setItem("theme", "light");
        }
    });
});

