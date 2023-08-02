function ConfigureLinks() {
    var links = $("a");
    for (var i = 0; i < links.length; i++) {
        var cls = links[i].className;
        // console.log(cls);
        if (cls.match(/def/gi, "")) continue;
        else {
            links[i].onclick = function (event) {
                event.preventDefault();
                pageReloadProgress = false;
                activeLink = true;
                if ($("#fixture").length) {
                    $("#fixture")[0].id = "fixture-1";
                    console.log($("#fixture")[0]);
                }
                var link = this;
                if (link.className.match("delete")) {
                    var c = window.confirm("Proceed with action?");
                    if (!c) {
                        return;
                    }
                }
                // console.log(link);
                var href = link.getAttribute("href");
                history.pushState({}, "", link);
                loadLink(href);
            };
        }
        links[i].setAttribute("draggable", "false");
    }
}

function loadLink(link, reload = false, resultElement = "") {
    console.log("New link");
    if (!reload) loader();
    var x = new Date();
    x.getTimezoneOffset();
    $.ajax({
        url: link,
        method: "POST",
        data: {
            async: 1,
            GMTOffset: x.toString().match(/\b\+[0-9]{4}/gi),
        },
    })
        .fail(function (error) {
            // console.log(error);
            loader(false);
            alert("There was an error.");
            return false;
        })
        // Appel OK
        .done(function (data) {
            // console.log(data);
            // if (!reload) loader(false);

            if ($(`${resultElement}`).length && reload)
                $(".main")[0].innerHTML = data;
            else if (!reload) $(".main")[0].innerHTML = data;

            dispatchEvent(new Event("load"));
            if (!window.location.search.match(/sec=countries/gi))
                window.scrollTo(0, 0); // scroll back to top
            activeLink = false;
        });
}

function pageReload(link, resultElement) {
    // if (activeLink) return;
    // pageReloadProgress = true;
    // console.log("Reloading ...", resultElement);
    var x = new Date();
    x.getTimezoneOffset();
    $.ajax({
        url: link,
        method: "POST",
        data: {
            async: 1,
            GMTOffset: x.toString().match(/\b\+[0-9]{4}/gi),
        },
    })
        .fail(function (error) {
            console.log(error);
            // alert("There was an error.");
            return false;
        })
        .done(function (data) {
            if (document.body.contains(resultElement)) {
                // console.log("Page reloaded successfully.");
                $(".main")[0].innerHTML = data;
                // if (!activeLink) {
                dispatchEvent(new Event("load"));
                // pageReloadProgress = false;
                // }
            } else {
                console.log("Element not found", resultElement);
            }
        });
}
