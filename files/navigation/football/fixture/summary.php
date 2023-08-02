<?php
$t_home = $teams['home']['id'];
$t_away = $teams['away']['id'];
$goal_home = 0;
$goal_away = 0;
$half = 0;
foreach($events as $event) {
    if($half == 0 && $event['time']['elapsed'] <= 45) {
        $fx_score = $config->countGoals(1, $events, $goal_home, $goal_away, $t_home, $t_away);
        ?>
        <p style="background-color: var(--primary-two); color: var(--neutral-light);" class="px-3 py-2 rounded-lg flex items-center font-bold">
            <span class="mr-2">1ST HALF</span>
            <span class="ml-auto"><?=$fx_score[0] . ' - ' . $fx_score[1]?></span>
        </p>
        <?php
        $half = 1;
    }
    else if($half == 1 && $event['time']['elapsed'] > 45) {
        $fx_score = $config->countGoals(2, $events, $fx_score[0], $fx_score[1], $t_home, $t_away);
        ?>
        <p style="background-color: var(--primary-two); color: var(--neutral-light);" class="px-3 py-2 rounded-lg flex items-center font-bold">
            <span class="mr-2">2ND HALF</span>
            <span class="ml-auto"><?=$fx_score[0] . ' - ' . $fx_score[1]?></span>
        </p>
        <?php
        $half = 2;
    }
    // if(preg_match('/Penalty/i', $event['detail'])) continue;
    $type = $event['type'];
    $class = '';
    $title = '';
    if($type == 'subst') {
        $_event = 'Substitution';
        $icon = 'substitution';
        $title = $event['time']['elapsed']."' ".$event['player']['name'];
    }
 if($type == 'Goal') {
        $_event = 'Goal';
        $icon = 'futbol';
        $title = $event['time']['elapsed']."' ".$event['player']['name'];
        // $class = 'goal';
    }
  
    
    if($event['detail'] == 'Yellow Card') {
        $_event = 'Yellow Card';
        $icon = 'card';
        $class = 'card-yellow';
        $title = $event['time']['elapsed']."' ".$event['player']['name'];
    }
    // echo  $event['type'];
    if($event['type'] == 'Var') {
        $_event = $event['detail'];
        $icon = 'var';
        // $class = 'card-yellow';
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
    $time .= $event['time']['extra'] != null ? "+".$event['time']['extra'] : '';
    ?>
    <div style="background-color: transparent; fill: var(--neutral-light);" class="flex items-center soccer-icons font-bold <?=$t_away == $event['team']['id'] ? 'ml-auto flex-row-reverse' : ''?>">
        <span class="mr-2"><?=$time?>'</span>
        <div style="border: 1px solid var(--primary-three); background-color: var(--primary-one); padding: 5px;" class="rounded-lg cursor-pointer mx-2 flex items-center gap-2 <?=$class?>" title="<?=$title?>">
            <span style="width: 15px;"><?=$svg[$icon]?></span>
            <?php
            if($type == 'Goal') {
                if($event['team']['id'] == $t_home){
                    $goal_home++;
                }
                if($event['team']['id'] == $t_away){
                    $goal_away++;
                }
                echo "$goal_home - $goal_away";
            }
            ?>
        </div>
        <span class="mx-1">
            <?=$event['player']['name']?>
            <!-- <span style="color: var(--neutral-one); font-100"> (<?=$event['detail']?>)</span> -->
        </span>
        <span class="mx-1">
            <?php
            echo $event['assist']['name'] != null ? '('.$event['assist']['name'].')' : '';
            ?>
        </span>
    </div>
    <?php
}
$str_id = $config->str_ord($_SERVER['QUERY_STRING']);
?>
<input type="hidden" id="reload_page" data-element="<?=$str_id?>">
<div id="reload<?=$str_id?>"></div>