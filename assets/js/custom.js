
    const darkLink = document.getElementById("darkTheme");
    const toggleBtn = document.getElementById("toggleTheme");
    if (localStorage.getItem("theme") === "dark") {
        darkLink.removeAttribute("disabled");
        toggleBtn.innerHTML = "light_mode";
    }

    toggleBtn.addEventListener("click", () => {
        if (darkLink.hasAttribute("disabled")) {
            darkLink.removeAttribute("disabled");
            toggleBtn.innerHTML = "light_mode";
            localStorage.setItem("theme", "dark");
        } else {
            darkLink.setAttribute("disabled", "true");
            toggleBtn.innerHTML = "dark_mode";
            localStorage.setItem("theme", "light");
        }
    });

    const btnFullscreen = document.getElementById("toggleFullscreen");
    btnFullscreen.addEventListener("click", () => {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
            btnFullscreen.textContent = "fullscreen_exit";
        } else {
            document.exitFullscreen();
            btnFullscreen.textContent = "fullscreen";
        }
    });
    document.addEventListener("fullscreenchange", () => {
        if (!document.fullscreenElement) {
            btnFullscreen.textContent = "fullscreen";
        }
    });

const body = document.body;
if (localStorage.getItem("modeSandik") === "on") {
    body.classList.add("bg-sandik-mode");
}
if (localStorage.getItem("modeDark") === "on") {
    body.classList.add("dark-mode");
}
document.getElementById("toggleSandik").addEventListener("click", function(){
    if (!body.classList.contains("bg-sandik-mode")) {
        body.classList.remove("dark-mode");
        localStorage.setItem("modeDark", "off");
    }

    body.classList.toggle("bg-sandik-mode");

    if (body.classList.contains("bg-sandik-mode")) {
        localStorage.setItem("modeSandik", "on");
    } else {
        localStorage.setItem("modeSandik", "off");
    }
});

document.getElementById("toggleTheme").addEventListener("click", function(){
    if (!body.classList.contains("dark-mode")) {
        body.classList.remove("bg-sandik-mode");
        localStorage.setItem("modeSandik", "off");
    }

    body.classList.toggle("dark-mode");

    if (body.classList.contains("dark-mode")) {
        localStorage.setItem("modeDark", "on");
    } else {
        localStorage.setItem("modeDark", "off");
    }
});
