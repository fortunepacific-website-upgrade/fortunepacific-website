<?php !isset($c) && exit();?>
<div class="info fr">
    <div class="box member">
        <p><?=$menuLang[$c['lang']]['title'];?></p>
        <div class="sign_btn"><a href="javascript:;" class="SignInButton signinbtn"><?=$c['lang_pack']['user']['sign_in'];?></a></div>
        <p class="forgot"><a href="/account/forgot.html" class="FontColor"><?=$c['lang_pack']['user']['forget'];?></a></p>
    </div>
</div>