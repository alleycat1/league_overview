<?php
$acceptCookie = isset($_COOKIE['accept-cookie']) ? $_COOKIE['accept-cookie'] : 'no';
if($acceptCookie == 'no') {
    ?>
    <div id="cookie-consent" class="cookie-consent" style="background-color: #252e39;position: fixed;width: 100%;z-index: 9999;color: #fff;font-size: 17px;">
        <div class="wd mx-auto items-center flex py-10 px-8">
            <div class="pr-8">
                This website uses cookies to ensure you get the best experience on our website. <a href="./cookie-consent.html" target="_blank" class="def text-gray-500 underline">Learn more</a>
            </div>
            <button style="background-color: #006ec7;color: #fff;font-weight: bold;padding: 4px 10px;border-radius: 4px;" onclick="acceptCookie();">Got it</button>
        </div>
    </div>
    <?php
}


