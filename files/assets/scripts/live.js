let live_counter = 0;
let active_request = false;
function updateLiveFixtures() {
    if (active_request == true) {
        // console.log("Request in progress.");
        return;
    }
    if (!$("a.fixture").length) return;

    let endpoint = "fixtures?live=all";
    if (
        $(".calendar-navigator").length &&
        !$(".calendar-navigator")[0].className.match(/hidden/gi)
    ) {
        // console.log($(".calendar-navigator")[0]);
        endpoint =
            "fixtures?date=" +
            $(".calendar-navigator .menu a.active")[0].dataset.str;
    }
    // if (requestIsPending() != 1) return;
    live_counter++;
    // let a = $(".nav2-top")[0].children;
    // if (a[1].className.match(/active/gi) || live_counter < 6)
    //     endpoint = "fixtures?live=all";
    // alert(endpoint);
    // console.log(endpoint);
    active_request = true;
    $.ajax({
        url: "./?live_update",
        method: "POST",
        data: {
            endpoint,
        },
    })
        .fail(function (error) {
            requestIsPending(true);
            active_request = false;
            console.log("There was an error: " + error);
            setTimeout(updateLiveFixtures, 1000);
        })
        .done(function (data) {
            requestIsPending(true);
            active_request = false;
            // console.log(data);
            try {
                let links = $(".item.fixture");
                for (let x = 0; x < links.length; x++) {
                    try {
                        let fixtureId = links[x].dataset.id;
                        let json_object = JSON.parse(data);
                        // if (json_object["response"].length == 0) return;
                        let fixture = getFixture(fixtureId, json_object);
                        // console.log(
                        //     json_object,
                        //     json_object["response"][102],
                        //     fixture
                        // );
                        if (fixture == -1) {
                            // console.log("NFD.");
                            continue;
                        }
                        let l_span =
                            links[x].getElementsByClassName("live-match")[0];
                        let home = links[x].children[0].children[1].children[0];
                        let away = links[x].children[0].children[1].children[1];
                        if (!fixture["fixture"]) continue;

                        let status = fixture["fixture"]["status"];
                        // if (status["short"].match(/1H|2H/gi)) {
                        // l_span.children[1].style.display = "none";
                        // console.log(status["short"]);
                        let display_status = status["elapsed"];
                        if (status["short"] == "HT") {
                            display_status = "HT";
                            // console.log("half time");
                            // console.log(l_span.children);
                            l_span.children[1].style.display = "none";
                        } else if (status["short"] == "FT") {
                            display_status = "FT";
                            l_span.children[1].style.display = "none";
                        } else if (
                            !isNaN(display_status) &&
                            display_status > 0
                        ) {
                            l_span.children[1].style.display = "inline";
                        }

                        l_span.children[0].innerHTML = display_status;
                        // console.log(status["short"]);

                        l_span.children[0].style.color = "var(--secondary-one)";
                        l_span.children[1].style.color = "var(--secondary-one)";
                        // l_span.children[1].style.display = "inline";
                        // }
                        /*else if (
                            fixture["fixture"]["status"]["elapsed"] == 45
                        ) {
                            // l_span.children[0].innerHTML = "Half Time";
                            l_span.children[0].style.color = "inherit";
                            l_span.children[1].style.color = "inherit";
                            l_span.children[1].style.display = "inline";
                        }*/
                        // alert();
                        // updating the goals
                        home.children[2].innerHTML = `${
                            fixture["goals"]["home"] != null
                                ? fixture["goals"]["home"]
                                : 0
                        }`;
                        away.children[2].innerHTML = `${
                            fixture["goals"]["away"] != null
                                ? fixture["goals"]["away"]
                                : 0
                        }`;
                        home.children[2].style.color = "var(--secondary-one)";
                        away.children[2].style.color = "var(--secondary-one)";
                        let hm = 0;
                        let aw = 0;
                        // half time
                        if (fixture["score"]["halftime"]["away"] != null) {
                            let aw =
                                fixture["score"]["halftime"]["away"] == "null"
                                    ? 0
                                    : fixture["score"]["halftime"]["away"];
                        }

                        if (fixture["score"]["halftime"]["home"] != null) {
                            let hm =
                                fixture["score"]["halftime"]["home"] == "null"
                                    ? 0
                                    : fixture["score"]["halftime"]["home"];
                        }
                        // home.children[3].innerHTML = `${hm}`;
                        // away.children[3].innerHTML = `${aw}`;
                        home.children[3].innerHTML = "";
                        away.children[3].innerHTML = "";

                        if (status["short"] == "NS") {
                            const dateString = "2023-01-19T21:30:00+00:00";
                            const date = new Date(dateString);
                            const hours = date.getUTCHours();
                            const minutes = date.getUTCMinutes();
                            const seconds = date.getUTCSeconds();
                            let time = `${hours}:${minutes}`;
                            l_span.children[0].innerHTML =
                                fixture["fixture"]["time"];
                            // console.log("Fixture", fixture);
                            home.children[2].style.color = "var(--neutral-one)";
                            away.children[2].style.color = "var(--neutral-one)";
                            l_span.children[0].style.color =
                                "var(--neutral-one)";
                        }

                        // events
                        /*if (
                            fixture["events"].length &&
                            fixture["events"][fixture["events"].length - 1][
                                "time"
                            ]["elapsed"] == status["elapsed"] &&
                            fixture["events"].length &&
                            status["elapsed"] != 90
                        ) {
                            if (
                                home.children[1].dataset.id ==
                                fixture["events"][fixture["events"].length - 1][
                                    "team"
                                ]["id"]
                            ) {
                                home.children[1].innerHTML =
                                    fixture["events"][
                                        fixture["events"].length - 1
                                    ]["type"].toUpperCase();
                            } else {
                                home.children[0].innerHTML =
                                    fixture["events"][
                                        fixture["events"].length - 1
                                    ]["type"].toUpperCase();
                            }
                        } else {
                            home.children[1].innerHTML = "";
                        }*/
                    } catch (error) {
                        // console.log("lp", error);
                    }
                }
            } catch (error) {
                // console.log(error);
            }
            if (live_counter >= 7) live_counter = 0;
            setTimeout(updateLiveFixtures, 55000);
        });
}
/*function updateFixture() {
    if (!$("#fixture").length) return;
    let endpoint = "fixtures?id=" + $("#fixture")[0].dataset.id;
    $.ajax({
        url: "./?live_update",
        method: "POST",
        data: {
            endpoint,
        },
    })
        .fail(function (error) {
            requestIsPending(true);
            // console.log("There was an error: " + error);
            setTimeout(updateLiveFixtures, 1000);
        })
        .done(function (data) {
            requestIsPending(true);
            // console.log(JSON.parse(data));
            let fixture = JSON.parse(data);
            fixture = fixture["response"][0];
            let fx = fixture["fixture"];
            let league = fixture["league"];
            let teams = fixture["teams"];
            let goals = fixture["goals"];
            let score = fixture["score"];
            let events = fixture["events"];
            let lineups = fixture["lineups"];
            let statistics = fixture["statistics"];
            let players = fixture["players"];

            let parent = $("#fixture")[0];
            let g = goals["home"] + " - " + goals["away"];
            if (goals["home"] == null) g = "0 - 0";
            parent.children[0].children[1].children[1].innerHTML = g;

            // let sc = fx["status"]["long"].toUpperCase();
            // if (fx["status"]["short"] == "1H")
            //     sc = "1ST HALF: " + fx["status"]["elapsed"] + "'";
            // else if (fx["status"]["short"] == "2H")
            //     sc = "2ND HALF: " + fx["status"]["elapsed"] + "'";
            // else if (fx["status"]["short"] == "HT") sc = "HALF TIME";
            let short = fx["status"]["long"].toUpperCase();
            if (short == "CANC") short = "CANX";
            else if (short == "PST") short = "PP";
            else if (short == "TBD") short = "TBC";
            // else if (short == "HALF TIME" || short == "SECOND HALF") short = ;

            if (fx["status"]["short"].toUpperCase() == "HT")
                short = "HALF TIME";
            else if (fx["status"]["short"].toUpperCase() == "FT")
                short = "FULL TIME";
            else if (parseInt(fx["status"]["elapsed"]) > 0)
                short = fx["status"]["elapsed"] + "'";
            // else if (fx["status"]["short"].toUpperCase() == "1H")
            //     short = "SECOND HALF";
            // if (parseInt(fx["status"]["elapsed"]) > 0)
            //     short += " - " + fx["status"]["elapsed"] + "'";
            parent.children[0].children[1].children[2].innerHTML = short;

            setTimeout(updateFixture, 6000);
        });
}*/

function updateFixture() {
    let link = window.location.href;
    if (!$("#fixture").length) return;
    if (link.match(/predictions/gi, link)) return;
    // setTimeout(() => {
    //     pageReload(link, "fixture");
    // }, 3000);
}
function getFixture(fixtureId = 0, data) {
    let response = data["response"];
    // console.log(data);
    for (let x = 0; x < response.length; x++) {
        if (response[x]["fixture"]["id"] == fixtureId) {
            return response[x];
        }
    }
    return -1;
}
function requestIsPending(disable = false) {
    if (disable) window.localStorage.setItem("request_pending", 0);
    return window.localStorage.getItem("request_pending");
}
