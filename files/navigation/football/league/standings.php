<div class="flex-shrink-0 mt-4 p-0 md:p-6 w-full" style="padding: 0; color: var(--neutral-light); overflow: hidden;">
    <nav class="flex items-center nav2-top gap-3 hidden">
        <a href="./?sec=countries&ref=league&league=39&ref2=standings&pg=standings" class="active">STANDINGS</a>
        <a href="./?sec=countries&ref=league&league=39&ref2=standings&pg=form">FORM</a>
        <a href="./?sec=countries&ref=league&league=39&ref2=standings&pg=over-under">OVER/UNDER</a>
        <a href="./?sec=countries&ref=league&league=39&ref2=standings&pg=ht-ft">HT/FT</a>
    </nav>
    <?php
    chdir("football/league/");
    // print_r(glob('*'));
    $pg = isset($_GET['pg']) && file_exists("standings/".$_GET['pg'].".php") ? $_GET['pg'] : 'standings';
    require "standings/$pg.php";
    chdir("../../");
    ?>
</div>