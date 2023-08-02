<p class="title font-semibold pb-3">TOP LEAGUES</p>
<div class="item-list flex flex-col pb-4">
    <?php
    foreach($top_leagues as $lg) {
        // $logo = 'https://media.api-sports.io/football/leagues/'.$lg[0].'.png';
        $logo = $lg[0].'.png';
        ?>
        <a href="./?sec=countries&ref=league&league=<?=$lg[0]?>" class="item disabled league-link">
            <span class="title px-2 py-1 flex items-center">
                <img src="<?=$config->getLeagueLogo($logo)?>" class="mr-2" style="width: 18px;">
                <span class="flex-grow"><?=$lg[1]?></span>
            </span>
        </a>
        <?php
    }
    ?>
</div>
<p class="title font-semibold pb-3">COUNTRIES</p>
<div class="item-list flex flex-col">
    <?php
    // $countries = $config->query("countries");
    $countries = json_decode(file_get_contents('../static/countries.json'),1);
    // print_r($countries);
    foreach($countries['response'] as $country) {
        $tag = isset($_GET['sec']) && isset($_GET['country_code']) && $_GET['country_code'] == $country['code'] ? 'div' : 'a' ;
        ?>
        <<?=$tag.' onclick="collapse_country(this)"'?> href="./?sec=countries&country_code=<?=$country['code']?>" class="item <?=$tag == 'a' ? 'disabled' : ''?>">
            <span class="title py-2 px-4 flex items-center">
                <img src="<?=$country['flag']?>" class="mr-2" style="width: 18px;">
                <span class="flex-grow"><?=$country['name']?></span>
                <span class="relative icons flex items-center justify-center">
                    <span class="up"><?=$svg['angle-up']?></span>
                    <span class="down"><?=$svg['angle-down']?></span>
                </span>
            </span>
            <?php
            if($tag != 'a') {
                $country_code = $_GET['country_code'];
                $country_name = $country['name'];
                $country_flag = $country['flag'];
                ?>
  <div class="secondary-list pl-4 pt-2">
    <?php
    // Adjust the query for 'World' or other countries
    if ($country['name'] == 'World') {
        $leagues = $config->query("leagues?country=World&season=2023");
    } else {
        $leagues = $config->query("leagues?code=$country_code");
    }

    if(!is_array($leagues)) {
        $leagues = json_decode($leagues,1);
        foreach($leagues['response'] as $league) {
            // Add a condition to check if league ID is 960 and country is 'World'
            if ($country['name'] == 'World' && $league['league']['id'] == 960) {
                $logo = 'https://latestscore.net/files/assets/img/eurologo.png'; 
            } else {
                $logo = $league['league']['logo'];
            }
            ?>
            <div class="s-item flex items-center mb-4">
                <img src="<?=$logo?>" class="mr-2" style="width: 18px;">
                <a href="./?sec=countries&ref=league&league=<?=$league['league']['id']?>" class="flex-grow league-link"><?=$league['league']['name']?></a>
            </div>
            <?php
        }
    }
    ?>
</div>


                <?php
            }
            ?>
        </<?=$tag?>>
        <?php
    }
    ?>
</div>

<script>
window.onload = function() {
    document.querySelectorAll('.league-link').forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            // We send the league ID to Swift
            window.webkit.messageHandlers.leagueSelected.postMessage(e.target.href);
        });
    });
}
</script>
