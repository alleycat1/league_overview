<?php
require "env.inc";
class Config {
    private $api_key = '';
    private $host = 'api-football-v1.p.rapidapi.com';
    public $API_calls = 0;
    public function query($endpoint = '') {
        $this->API_calls++;
        global $key;
        $this->api_key = $key;
        $link = "https://api-football-v1.p.rapidapi.com/v3/$endpoint";
        
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $link,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: $this->host",
                "X-RapidAPI-Key: $this->api_key"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return array("error" => "cURL Error #:" . $err);
        } else {
            return $response;
        }
    }


    public function getCachedata() {
        $cache = glob('./cache/*.json');
        print_r($cache);
    }
    public function str_ord(string $string = '', $reverse = false) {
        $str_array = $reverse ? explode('-', $string) : str_split($string);
        $return_string = '';
        foreach($str_array as $key => $char) {
            $return_string .= $reverse ? chr(intval($char)) : ord($char);
            if($key < count($str_array)-1 && !$reverse) $return_string .= "-";
        }
        return $return_string;
    }

    //timezone code
    public function getUserTimezoneIndex() {
        $userTimezone = $_SESSION['user_timezone'] ?? 'BST'; // default to 'BST' if the timezone isn't set

        $timezoneData = $this->query('timezone');
        $timezoneData = json_decode($timezoneData, true);

        $timezoneIndex = array_search($userTimezone, $timezoneData['response']);
        
        error_log('User timezone: ' . $userTimezone);
        error_log('Timezone index: ' . $timezoneIndex);

        return $timezoneIndex !== false ? $timezoneIndex : null;
    }
    

        
    public function leagues($fixtures) {

        $fixtures = json_decode($fixtures,1);
        
        $timezoneIndex = $this->getUserTimezoneIndex();
        $timezoneData = $this->query('timezone');
        $timezoneData = json_decode($timezoneData, true);
        $userTimezone = $timezoneData['response'][$timezoneIndex] ?? 'BST';
        error_log('User timezone for DateTime: ' . $userTimezone);

        /*foreach($fixtures['response'] as &$fixture) {
            $datetime = new DateTime($fixture['fixture']['date'], new DateTimeZone('UTC'));
            $datetime->setTimezone(new DateTimeZone($userTimezone));
            $fixture['fixture']['date'] = $datetime->format('Y-m-d H:i:s');
            error_log('Adjusted date and time: ' . $fixture['fixture']['date']);
        }*/
        
        $array = array(
            "get" => $fixtures['get'],
            "parameters" => $fixtures['parameters'],
            "results" => $fixtures['results'],
            "paging" => $fixtures['paging'],
            "response" => array()
        );
        
        foreach($fixtures['response'] as &$fixture) {
            $fixtureId = $fixture['fixture']['id'];  // Get fixture ID
            
            $datetime = new DateTime($fixture['fixture']['date'], new DateTimeZone('UTC'));
            $datetime->setTimezone(new DateTimeZone($userTimezone));
            $fixture['fixture']['date'] = $datetime->format('Y-m-d H:i:s');
            error_log('Adjusted date and time: ' . $fixture['fixture']['date']);

            $x = $this->find_league($array, $fixture['league']['country'], $fixture['league']['name']);
            if($x[0] > -1) {
                if ($x[1] == -1) {
                    $array['response'][$x[0]]['leagues'][] = array(
                        'id' => $fixture['league']['id'],
                        'name' => $fixture['league']['name'],
                        'fixtures' => [$fixture]
                    );
                } else {
                    // Check if fixture ID already exists in the fixtures array
                    $found = array_filter(
                        $array['response'][$x[0]]['leagues'][$x[1]]['fixtures'],
                        function ($f) use ($fixtureId) {
                            return $f['fixture']['id'] === $fixtureId;
                        }
                    );
                    if (empty($found)) {
                        $array['response'][$x[0]]['leagues'][$x[1]]['fixtures'][] = $fixture;
                    }
                }
            } else {
                $array['response'][] = array(
                    'country' => $fixture['league']['country'],
                    'leagues' => array(
                        array(
                            'id' => $fixture['league']['id'],
                            'name' => $fixture['league']['name'],
                            'fixtures' => [$fixture]
                        )
                    )
                );
            }
        }
        //print_r(count($fixtures));
        //assert(count($fixtures)==0);
        file_put_contents('test.json',json_encode($array));
        return $array;
    }

    public function sort_leagues($fixtures) {
        global $top_leagues;
        global $f;
      //  $top_league_ids = [];
        foreach($top_leagues as $x) $top_league_ids[] = $x[0];
        // print_r($top_league_ids);
        //  date_default_timezone_set('Europe/London');
        // Set the timezone to the user's timezone
        if(isset($_SESSION['user_timezone']))
            date_default_timezone_set($_SESSION['user_timezone']);

        $arr1 = json_decode($fixtures, 1);
        // print_r($arr1);
        $arr2 = $arr1;
        $exceptions = [];
        $others = [];
        $arr2['response'] = [];
        $top = $arr2;
        $top['response'] = [];
        
        if($f != 'live') {
            // top leagues
            $lgs = [];
            foreach($top_leagues as $lg)
                $lgs[] = $lg[0];
            foreach($arr1['response'] as $fixture) {
                // echo "Hello";
                // Set the timezone to the user's timezone
                date_default_timezone_set($_SESSION['user_timezone']);
                $fixture['fixture']['time'] = date('H:i', strtotime($fixture['fixture']['date']));
                /*if($fixture['league']['id'] == $lg[0]) { 
                    // $fixture['fixture']['axxd'] = "-----"; 
                    $top['response'][] = $fixture;
                    $exceptions[] = $lg[0];
                }
                // else $others[] = $fixture['league']['name'] . '---' . $fixture['league']['id'];
                else */ 
                if(in_array($fixture['league']['id'], $lgs))
                    $others[] =  $fixture['league']['country'] . '---' . $fixture['league']['name'] . '---' . $fixture['league']['id'];
            }
        }
        else {
            // --- tmp
            foreach($arr1['response'] as $fixture) {
                // echo "Hello";
                // Set the timezone to the user's timezone
                date_default_timezone_set($_SESSION['user_timezone']);
                $fixture['fixture']['time'] = date('H:i', strtotime($fixture['fixture']['date']));
                $others[] =  $fixture['league']['country'] . '---' . $fixture['league']['name'] . '---' . $fixture['league']['id'];
            }
        }

        
        $others = array_unique($others);
        sort($others);
        // echo '<pre>';
        // print_r($others);
        // echo '</pre>';

        $league_ids = [];
        foreach($others as $lg) {
            $lg_arr = explode('---', $lg);
            // $league_name = $lg_arr[0];
            $league_ids[] = $lg_arr[2];
        }
        foreach($arr1['response'] as $fixture) {
            $fixture['fixture']['time'] = date('H:i', strtotime($fixture['fixture']['date']));
            if(in_array($fixture['league']['id'], $league_ids)) {
                $arr2['response'][] = $fixture;
            }
        }
        // echo '<pre>';
        // print_r(json_encode($arr2));
        // echo '</pre>';
        
        return [$top, $arr2];
    }



    public function find_league($array, $country = '', $league = '') {
        // global $array;
        for($i = 0; $i < count($array['response']); $i++) {
            $fixture = $array['response'][$i];
            if($fixture['country'] == $country) {
                // the array of countries is here
                foreach($fixture['leagues'] as $key => $__league) {
                    if($__league['name'] == $league) {
                        // found the league
                        return array($i, $key);
                    }
                }
                return [$i, -1]; // league not found
            }
            // break;
        }
        return [-1, -1];
    }
    public function getSurName($fullname = '') {
        $array = explode(' ', $fullname);
        $surName = $array[count($array)-1];
        if(preg_match_all('/[\.]/',$surName) && count($array) > 1) $surName = $array[count($array)-2];
        // if(strlen($surName) <= 7) $surName = 
        // if(strlen($surName) > 8) $surName = mb_substr($surName,0,8) . '...';
        // else if(count($array) > 1) $surName .= '...';
        return $surName; 
    }
    public function getEventForPlayer($events = [], $player_id = 0) {
        $title = '';
        $icon = '';
        $class = '';
        $time = '';
        $_event = '';
        $data = array();
        foreach($events as $event) {
            $class = '';
            $array = array($event['player']['id'], $event['assist']['id']);
            if($event['type'] == 'Goal') $array = array($event['player']['id']);
            if(in_array($player_id, $array)) {
                $type = $event['type'];
                if($type == 'subst') {
                    $_event = 'Substitution';
                    $icon = 'substitution';
                    $title = $event['time']['elapsed']."' ".$event['player']['name'];
                }
                if($type == 'Goal') {
                    $_event = 'Goal';
                    $icon = 'futbol';
                    $title = $event['time']['elapsed']."' ".$event['player']['name'];
                }
                if($event['detail'] == 'Yellow Card') {
                    $_event = 'Yellow Card';
                    $icon = 'card';
                    $class = 'card-yellow';
                    $title = $event['time']['elapsed']."' ".$event['player']['name'];
                }
                if($event['detail'] == 'Red Card') {
                    $_event = 'Red Card';
                    $icon = 'card';
                    $class = 'card-red';
                    $title = $event['time']['elapsed']."' ".$event['player']['name'];
                }
                $title .= " ". $event['assist']['name'] != "null" ? " (".$event['assist']['name'].")" : '';
                $assist = $event['assist']['name'];
                $time = $event['time']['elapsed'];
                $data[] = array(
                    'time' => $time,
                    'icon' => $icon,
                    'class' => $class,
                    'event' => $_event,
                    'title' => $title,
                    'assist' => $assist
                );
            }
        }
        return $data;
    }
    public function getLeagueInitials($league = '') {
        if($league == '') return '';
        else {
            $initials = '';
            foreach(explode(' ', $league) as $x) {
                $initials .= substr($x, 0, 1);
            }
            return strlen($initials) > 2 ? substr($initials, 0, 2) : $initials;
        }
    }
    public function countGoals($half = 1, $events = array(), $goal_home = 0, $goal_away = 0, $t_home = 0, $t_away = 0) {
        // print_r($events);
        foreach($events as $event) {
            if($half == 1) {
                if($event['time']['elapsed'] <= 45) {
                    // if($event['type'] == 'Goal' && !preg_match('/Penalty/',$event['detail'])) {
                    if($event['type'] == 'Goal') {
                        if($event['team']['id'] == $t_home) $goal_home++;
                        if($event['team']['id'] == $t_away) $goal_away++;
                        // echo "x";
                        // echo '<pre>';
                        // print_r($event);
                        // echo '</pre>';
                    }
                }
            }
            if($half == 2) {
                if($event['time']['elapsed'] > 45) {
                    if($event['type'] == 'Goal' && !preg_match('/Penalty/',$event['detail'])) {
                        if($event['team']['id'] == $t_home) $goal_home++;
                        if($event['team']['id'] == $t_away) $goal_away++;
                        // echo "x";
                        // echo '<pre>';
                        // print_r($event);
                        // echo '</pre>';
                    }
                }
            }
        }
        return [$goal_home, $goal_away];
    }
    public function sortH2H($response = [], $dates = []) {
        $h2h = [];
        // print_r($dates);
        foreach($dates as $d) {
            $arr = explode('-', $d);
            $str = $arr[0];
            $id = $arr[1];
            foreach($response as $res) {
                // print_r($res);
                if($res['fixture']['id'] == $id) $h2h[] = $res;
            }
        }
        return $h2h;
    }
    public function sortFIxturesByDate($response = [], $dates = []) {
        $resp = [];
        // print_r($dates);
        foreach($dates as $d) {
            $arr = explode('-', $d);
            $str = $arr[0];
            $id = $arr[1];
            foreach($response as $res) {
                // print_r($res);
                if($res['fixture']['id'] == $id) $resp[] = $res;
            }
        }
    }
    public function getPlayerPicture(int $player_id = 0, int $season = 0) {
        if($player_id == 0) return;
        else {
            $data = json_decode($this->query("players?id=$player_id&season=$season"), 1);
            return $data['response'][0]['player']['photo'];
        }
    }
    public function getLeagueLogo($image = '') {
        // https://media.api-sports.io/football/leagues/378.png
        $info = pathinfo($image);

        $existing_image = "../assets/league/logos/".$info['basename'];

        if(!file_exists($existing_image)) $existing_image = $image;
        else $existing_image = "files/assets/league/logos/".$info['basename'];
        // print_r(glob('../*'));
        // echo $existing_image;
        return $existing_image;
    }
    public function getImageResized($image, int $newWidth, int $newHeight) {
        $newImg = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($newImg, false);
        imagesavealpha($newImg, true);
        $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
        imagefilledrectangle($newImg, 0, 0, $newWidth, $newHeight, $transparent);
        $src_w = imagesx($image);
        $src_h = imagesy($image);
        imagecopyresampled($newImg, $image, 0, 0, 0, 0, $newWidth, $newHeight, $src_w, $src_h);
        return $newImg;
    }
    

    
}


$config = new Config;

