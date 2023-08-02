<?php
if(isset($country_code)) {
    ?>
    <p class="title font-semibold pb-3 flex items-center" style="border-bottom: 1px solid var(--item-bg);">
        <img class="w-6 mr-2" src="<?=$country_flag?>">
        <?=strtoupper($country_name)?>
    </p>
    <div class="item-list flex flex-col pb-4">
        <?php
        $leagues = json_decode($config->query("leagues?code=$country_code"),1);
        foreach($leagues['response'] as $league) {
            // if($league['league']['type'] != 'League') continue;
            ?>
            <a href="./?sec=countries&ref=league&league=<?=$league['league']['id']?>" class="item disabled">
                <span class="title px-2 py-1 flex items-center">
                    <!-- <span style="width: 19px;" class="flex justify-center items-center"> -->
                        <img src="<?=$league['league']['logo']?>" class="mr-2" style="width: 18px;">
                    <!-- </span> -->
                    <span class="flex-grow"><?=$league['league']['name']?></span>
                </span>
            </a>
            <?php
        }
        ?>
    </div>
    <?php
}