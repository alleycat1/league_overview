<div style="background-color: var(--neutral-light); max-width: 500px;" class="w-full rounded-lg p-2 my-10 mx-auto relative">
    <canvas id="predictions_chart"></canvas>
    <div id="predictions-data" style="display: none;"><?php
    $endpoint = "predictions?fixture=$fixture_id";
    // echo $endpoint;
    $response = json_decode($config->query($endpoint), 1);
    $response = $response['response'][0];
    // print_r($data['response']);
    // $data = array();
    $teams = $response['teams'];
    $comparison = $response['comparison'];
    $prediction = $response['predictions'];
    $home = $teams['home'];
    $away = $teams['away'];
    $labels = array(
        "Defense",
        "Attack",
        "Poisson Distribution",
        "H2H",
        "Wins the game",
        "Formation",
    );
    $data = array(
        'labels' => $labels,
        'datasets' => array(
            array(
                'label' => $home['name'],
                'data' => [
                    preg_replace('/[^0-9.]/','',$home['last_5']['def']),
                    preg_replace('/[^0-9.]/','',$home['last_5']['att']),
                    preg_replace('/[^0-9.]/','',$comparison['poisson_distribution']['home']),
                    preg_replace('/[^0-9.]/','',$comparison['h2h']['home']),
                    preg_replace('/[^0-9.]/','',$comparison['total']['home']),
                    preg_replace('/[^0-9.]/','',$comparison['form']['home']),
                ],
                'fill' => true,
                'backgroundColor' => "rgba(255, 99, 132, 0.2)",
                'borderColor' => "rgb(255, 99, 132)",
                'pointBackgroundColor' => "rgb(255, 99, 132)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgb(255, 99, 132)",
            ),
            array(
                // 'defense' => preg_replace('/[^0-9.]/','',$away['last_5']['def']),
                // 'attack' => preg_replace('/[^0-9.]/','',$away['last_5']['att']),
                // 'position_distribution' => preg_replace('/[^0-9.]/','',$comparison['position_distribution']['away']),
                // 'h2h' => preg_replace('/[^0-9.]/','',$comparison['h2h']['away']),
                // 'win' => preg_replace('/[^0-9.]/','',$prediction['percent']['away']),
                // 'form' => preg_replace('/[^0-9.]/','',$comparison['form']['away']),
                'label' => $away['name'],
                'data' => [
                    preg_replace('/[^0-9.]/','',$away['last_5']['def']),
                    preg_replace('/[^0-9.]/','',$away['last_5']['att']),
                    preg_replace('/[^0-9.]/','',$comparison['poisson_distribution']['away']),
                    preg_replace('/[^0-9.]/','',$comparison['h2h']['away']),
                    preg_replace('/[^0-9.]/','',$comparison['total']['away']),
                    preg_replace('/[^0-9.]/','',$comparison['form']['away']),
                ],
                'fill' => true,
                'backgroundColor' => "rgba(54, 162, 235, 0.2)",
                'borderColor' => "rgb(54, 162, 235)",
                'pointBackgroundColor' => "rgb(54, 162, 235)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgb(54, 162, 235)",
            )
        ),
    );
    // echo '<pre>';
    print_r(json_encode($data));
    // echo '</pre>';
    ?></div>
</div>
<?php
$home = $data['datasets'][0];
$away = $data['datasets'][1];
for($i = 0; $i < count($home['data']); $i++) {
    ?>
    <div class="flex flex-col font-bold py-2 px-1 text-white">
        <div class="flex justify-between">
            <span><?=$home['data'][$i]?>%</span>
            <span><?=$labels[$i]?></span>
            <span><?=$away['data'][$i]?>%</span>
        </div>
        <div style="background-color: var(--primary-main); border-radius: 4px; height: 10px;" class="justify-center flex mt-2 max-w-full">
            <div style="width: 50%;" class="flex justify-end">
                <div style="border-right: 1px solid var(--primary-main);background-color: rgba(255, 99, 132, 1);width: <?=$home['data'][$i]?>%;height: 100%;border-top-left-radius: 4px;border-bottom-left-radius: 4px;"></div>
            </div>
            <div style="width: 50%;" class="flex justify-start">
                <div style="border-left: 1px solid var(--primary-main); background-color: rgba(54, 162, 235, 1); width: <?=$away['data'][$i]?>%; height: 100%; border-top-right-radius: 4px;border-bottom-right-radius: 4px;"></div>
            </div>
        </div>
    </div>
    <?php
}
