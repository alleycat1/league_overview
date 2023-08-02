let menu, menu1;
var pageReloadProgress = false;
var activeLink = false;
const acceptCookie = () => {
    $("#cookie-consent")[0].style.display = "none";
    var date = new Date();
    date.setTime(date.getTime() + 90 * 24 * 60 * 60 * 1000);
    var expires = "expires=" + date.toUTCString();
    document.cookie = "accept-cookie=yes; " + expires + "; path=/;";
    

};

const loaded = () => {
    // console.log("Window loaded.");
    pageReloadProgress = false;

    ConfigureLinks();
    leagues_dropdown();
    // if ($(".main").length) $(".main")[0].removeAttribute("style");
    if ($(".calendar-navigator")[0]) {
        let calendar = $(".calendar-navigator")[0];
        let left = calendar.children[0];
        let right = calendar.children[2];
        menu = calendar.getElementsByClassName("dropdown-dates")[0];
        let txt = menu.children[1].children[0];
        menu1 = menu.children[2];
        left.onclick = function () {
            for (let x = menu1.children.length - 1; x >= 0; x--) {
                if (menu1.children[x].className == "active" && x > 0) {
                    menu1.children[x].className = "";
                    menu1.children[x - 1].className = "active";
                    txt.textContent = menu1.children[x - 1].innerText;
                    menu1.children[x - 1].click();
                    showdates();
                    return;
                } else if (menu1.children[x].className == "active" && x == 0) {
                    menu1.children[x].className = "";
                    menu1.children[menu1.children.length - 1].className =
                        "active";
                    txt.textContent =
                        menu1.children[menu1.children.length - 1].innerText;
                    menu1.children[menu1.children.length - 1].click();
                    showdates();
                    return;
                }
                // console.log("Clicked");
            }

            // return;
            // alert();
        };
        right.onclick = function () {
            for (let x = 0; x < menu1.children.length; x++) {
                if (
                    menu1.children[x].className == "active" &&
                    x < menu1.children.length - 1
                ) {
                    menu1.children[x].className = "";
                    menu1.children[x + 1].className = "active";
                    txt.textContent = menu1.children[x + 1].innerText;
                    menu1.children[x + 1].click();
                    showdates();
                    return;
                } else if (
                    menu1.children[x].className == "active" &&
                    x == menu1.children.length - 1
                ) {
                    menu1.children[x].className = "";
                    menu1.children[0].className = "active";
                    txt.textContent = menu1.children[0].innerText;
                    menu1.children[0].click();
                    showdates();
                    return;
                }
                // console.log("Clicked");
            }
            // showdates();
            // return;
            // alert();
        };
        // console.log(menu1);
        for (let x = 0; x < menu1.children.length; x++)
            menu1.children[x].addEventListener("click", showdates);
        // console.log(menu1.children);
        menu.children[0].onclick = showdates;
        menu.children[1].onclick = showdates;
    }
    config_table_wrapper();
    updateLiveFixtures();
    updateFixture();
    drawChart();
    if ($("#reload_page")[0]) {
        // page needs to be reloaded
        let id = $("#reload_page")[0].dataset.element;
        // console.log(id);
        let link = window.location.href;
        window.setTimeout(() => {
            new pageReload(link, $("#reload" + id)[0]);
        }, 5000);
    }
    // let league_images = $(".league-logo-home");
    // for (let x = 0; x < league_images.length; x++) {
    //     let parent = league_images[x].parentNode;
    //     parent.removeChild(league_images[x]);
    // }
    let league_titles = $(".league-title-home");
    for (let x = 0; x < league_titles.length; x++) {
        let parent = league_titles[x].parentNode;
        league_titles[x].onclick = () => {
            parent.getElementsByClassName("arrow-icons")[0].click();
        };
    }

    try {
        caches.keys().then(function (cacheNames) {
            cacheNames.forEach(function (cacheName) {
                console.log("Cache Name", cacheName);
                caches.delete(cacheName);
            });
        });
    } catch (error) {
        console.log("Can't clear cache.", error);
    }

    loader(false);
};

const config_table_wrapper = () => {
    if ($(".table-wrapper").length) {
        if (document.body.offsetWidth > 500) {
            // console.log("hhj");
            // $(".table-wrapper")[0].removeAttribute("style");
            $(".table-wrapper")[0].style.width = "initial";
            document.body.removeAttribute("style");
            return;
        }

        $(".table-wrapper")[0].style.width = $("main")[0].offsetWidth + "px";
        $(".table-wrapper")[0].children[0].style.width = "550px";
        $(".table-wrapper")[0].children[0].style.display = "block";
        document.body.style.overflowX = "hidden";
    }
};

const leagues_dropdown = () => {
    let containers = $(".league-container");
    if (!containers.length) return;
    for (let x = 0; x < containers.length; x++) {
        if (!containers[x].getElementsByClassName("arrow-icons").length)
            continue;
        // console.log(containers[x].getElementsByClassName("arrow-icons"));
        containers[x].getElementsByClassName("arrow-icons")[0].onclick =
            function () {
                // console.log(this);
                c = this.className;
                if (this.className.match(/active/gi)) {
                    this.className = c.replace(/active/gi, "");
                    this.parentNode.parentNode.getElementsByClassName(
                        "data"
                    )[0].className = "data mb-4 w-full hidden";
                } else {
                    this.className = c + " active";
                    this.parentNode.parentNode.getElementsByClassName(
                        "data"
                    )[0].className = "data mb-4 w-full";
                }
                // console.log(c);
            };
    }
};

function showdates() {
    let c = menu1.className;
    if (c.match(/active/gi)) menu1.className = "menu flex flex-col";
    else menu1.className = "menu active flex flex-col";
}

// window.addEventListener("DOMContentLoaded", loaded);
window.addEventListener("load", function () {
    setTimeout(() => {
        $(".main")[0].style.opacity = 1;
        $("header")[0].style.opacity = 1;
    }, 500);
    setTimeout(loaded, 1000);
    // loaded();
});
window.addEventListener("resize", () => {
    config_table_wrapper();
});
window.addEventListener("popstate", function (event) {
    loadLink(location.href);
});

const loader = (hidden = true) => {
    let loader = $("#loader")[0];
    if (hidden) {
        loader.style.display = "block";
        window.setTimeout(() => {
            loader.className = "show";
        }, 50);
    } else {
        loader.removeAttribute("class");
        window.setTimeout(() => {
            loader.style.display = "none";
        }, 500);
    }
};

const collapse_country = (element) => {
    let s = element.getElementsByClassName("secondary-list")[0];
    console.log(s, element);
    if (s.style.display == "none") {
        s.style.display = "block";
        element.className = "item";
    } else {
        s.style.display = "none";
        element.className = "item disabled";
    }
};

$(document).ready(function() {
    var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        console.log('Browser timezone: ' + timezone);  // added console.log for debugging

    
    $.ajax({
        url: 'files/navigation/football/set_timezone.php',
        type: 'post',
        data: {timezone: timezone},
        success: function(response) {
         console.log('Timezone sent: ' + timezone);
            console.log('Response from set_timezone.php: ' + response);  // added console.log for debugging

            // handle the response
        }
    });
});




