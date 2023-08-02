<?php
$_title = "Today's matches. The Latest Football Scores, LineUps, News and Stats";
$title = $_title;
$desc = "Latestscore brings you fast and reliable flashscores, stats, news and more, covering over 850 leagues around the world.  Latestscore is the place you need to be when looking for tonights scores in live time.";
$description = $desc;
if(isset($_GET['ref'])) {
    $ref = $_GET['ref'];
    if($ref == 'fixture') {
        $fixture_id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 838269;
        $fixture = $config->query("fixtures?id=$fixture_id");
        // print_r(glob('*'));
        $ref2 = isset($_GET['ref2']) && file_exists("./files/navigation/football/fixture/".$_GET['ref2'].".php") ? $_GET['ref2'] : 'match';
        $fixture    = json_decode($fixture, 1);
        $fixture    = $fixture['response'][0];
        $fx         = $fixture['fixture'];
        $league     = $fixture['league'];
        $teams      = $fixture['teams'];
        $goals      = $fixture['goals'];
        $score      = $fixture['score'];
        $events     = $fixture['events'];
        $lineups    = $fixture['lineups'];
        $statistics = $fixture['statistics'];
        $players    = $fixture['players'];

        $league_id = $league['id'];
        $season_yr = $league['season'];
        $teams_array = [$teams['home']['name'],$teams['away']['name']];
        // echo '<pre>';
        // print_r($lineups);
        // echo '</pre>';
        /************* country *************/
        $country = json_decode($config->query("countries?name=".$league['country']), 1);
        $country_code = $country['response'][0]['code'];
        $country_name = $country['response'][0]['name'];
        $country_flag = $country['response'][0]['flag'];

        // title and description
        if(strtoupper($fx['status']['short']) == 'FT') {
            $title = $teams['home']['name'] . " vs " . $teams['away']['name'] . " (". $goals['home'] ."-" . $goals['away'] . ") highlights | " . $league['country']. " " . $league['name'] . " | $_title - $fixture_id";
            $description = $teams['home']['name'] . " vs " . $teams['away']['name'] . " on " . date('l jS M. Y', $fx['timestamp']) . ". Match summary, H2H, Standings, Statistics, Lineups and more. $desc";
            if($ref2 == 'h2h') {
                $title = $teams['home']['name'] . " vs " . $teams['away']['name'] . " (". $goals['home'] ."-" . $goals['away'] . ") H2H | " . $league['country']. " " . $league['name'] . " | $_title - $fixture_id";
                $description = $teams['home']['name'] . " vs " . $teams['away']['name'] . " H2H on " . date('l jS M. Y', $fx['timestamp']) . ". Match summary, H2H, Standings, Statistics, Lineups and more. $desc";
            }

            else if($ref2 == 'standings') {
                $title = $teams['home']['name'] . " vs " . $teams['away']['name'] . " (". $goals['home'] ."-" . $goals['away'] . ") standings | " . $league['country']. " " . $league['name'] . " | $_title - $fixture_id";
                $description = $teams['home']['name'] . " vs " . $teams['away']['name'] . " standings on " . date('l jS M. Y', $fx['timestamp']) . ". Match summary, H2H, Standings, Statistics, Lineups and more. $desc";
            }

            else if($ref2 == 'predictions') {
                $title = $teams['home']['name'] . " vs " . $teams['away']['name'] . " (". $goals['home'] ."-" . $goals['away'] . ") predictions | " . $league['country']. " " . $league['name'] . " | $_title - $fixture_id";
                $description = $teams['home']['name'] . " vs " . $teams['away']['name'] . " predictions on " . date('l jS M. Y', $fx['timestamp']) . ". Match summary, H2H, Standings, Statistics, Lineups and more. $desc";
            }
        }
        else {
            $title = $teams['home']['name'] . " vs " . $teams['away']['name'] . " highlights | " . $league['country']. " " . $league['name'] . " | $_title - $fixture_id";
            if($ref2 == 'predictions') {
                $title = $teams['home']['name'] . " vs " . $teams['away']['name'] . " predictions | " . $league['country']. " " . $league['name'] . " | $_title - $fixture_id";
                $description = $teams['home']['name'] . " vs " . $teams['away']['name'] . " predictions on " . date('l jS M. Y', $fx['timestamp']) . ". Match summary, H2H, Standings, Statistics, Lineups and more. $desc";
            }
        }
    }
    else if($ref == 'league') {
        $league_id = isset($_GET['league']) && is_numeric($_GET['league']) ? $_GET['league'] : 39;
        $endpoint = "leagues?id=$league_id";
        // echo $endpoint;
        $league = $config->query($endpoint);

        $league = json_decode($league, 1);
        $season_yr = $league['response'][0]['seasons'][count($league['response'][0]['seasons'])-1]['year'];
        $country_code = $league['response'][0]['country']['code'];
        $country_name = $league['response'][0]['country']['name'];
        $country_flag = $league['response'][0]['country']['flag'];

        $ref2 = isset($_GET['ref2']) && file_exists("./files/navigation/football/league/".$_GET['ref2'].".php") ? $_GET['ref2'] : 'results';

        $title = $league['response'][0]['league']['name'] . " results | $title";
        if($ref2 == 'fixtures') $title = $league['response'][0]['league']['name'] . " fixtures | $title";
        else if($ref2 == 'standings') $title = $league['response'][0]['league']['name'] . " standings | $title";
    }
    else if($ref == 'team') {
        $team_id = $_GET['id'];
        $team_data = json_decode($config->query("teams?id=".$team_id), 1);
        // print_r($team_data);
        $team = $team_data['response'][0]['team'];
        $venue = $team_data['response'][0]['venue'];
        $team_name = $team['name'];
        $country = json_decode($config->query("countries?name=".$team['country']), 1);
        $country_code = $country['response'][0]['code'];
        $country_name = $country['response'][0]['name'];
        $country_flag = $country['response'][0]['flag'];
        $ref2 = isset($_GET['ref2']) && file_exists("./files/navigation/football/team/".$_GET['ref2'].".php") ? $_GET['ref2'] : 'summary';
        $title = $team['name'] ." summary | $_title";
        if($ref2 == 'results') $title = $team['name'] ." results | $_title";
        if($ref2 == 'fixtures') $title = $team['name'] ." fixtures | $_title";
        if($ref2 == 'standings') $title = $team['name'] ." standings | $_title";
        $description = $team['name'] . " insights, scheduled matches and transfers | $desc";
    }
}
else if(isset($_GET['date'])) {
    $date_str = date('l jS M. Y', $_GET['date']);
    $title = "All fixtures on " . $date_str . ". | The Latest Football Scores, LineUps, News and Stats";
}
else if(isset($_GET['h']) && $_GET['h'] == 'live') {
    $title = "Live fixtures for today on latestscore . | The Latest Football Scores, LineUps, News and Stats";
}