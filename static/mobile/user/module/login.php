<?php !isset($c) && exit();?>
<?php
$regset_row=db::get_one('config', "GroupId='user' and Variable='RegSet'");
$reg_ary=str::json_data($regset_row['Value'], 'decode');
$set_row=str::str_code(db::get_all('user_reg_set', '1', '*', "{$c[my_order]} SetId asc"));
$jumpUrl=$_POST['jumpUrl']?$_POST['jumpUrl']:$_GET['jumpUrl'];
$jumpUrl=='' && $jumpUrl=$_SERVER['HTTP_REFERER'];	//进入登录页面之前的页面

if($jumpUrl){
	$_SESSION['LoginReturnUrl']=$jumpUrl;
}else{
	$jumpUrl = '/';
	unset($_SESSION['LoginReturnUrl']);
}
?>
<script type="text/javascript">$(function (){user_obj.user_login();});</script>
<div class="wrapper">
    <div class="page_title"><?=!strpos($_SERVER['REQUEST_URI'],'sign-up.html') ? $c['lang_pack']['mobile']['sign_in'] : $c['lang_pack']['user']['register']['creat_account'] ; ?></div>
    <?php if(!strpos($_SERVER['REQUEST_URI'],'sign-up.html')){ ?>
        <div class="user_login">
            <form name="" method="post" class="user_login_form" id="login_form">
                <div class="user_login_t"><?=$c['lang_pack']['mobile']['email'];?></div>
                <div class="user_input"><input class="form_input" type="email" name="Email" placeholder2="mail@example.com" notnull=""></div>
                <div class="user_login_t"><?=$c['lang_pack']['mobile']['password'];?></div>
                <div class="user_input"><input class="form_input" type="password" name="Password" autocomplete="off" placeholder2="<?=$c['lang_pack']['mobile']['enter_psw'];?>" notnull=""></div>
                <div class="user_login_btn">
                	<input type="hidden" name="jumpUrl" value="<?=$jumpUrl;?>" />
                	<input type="hidden" name="do_action" value="user.login" />
                    <div class="global_btn btn submit global_button"><?=$c['lang_pack']['mobile']['sign_in'];?></div>
                </div>
            </form>
            <div class="user_login_tab">
                <div><span><?=$c['lang_pack']['user']['register']['reg_account']; ?></span></div>
                <a href="/account/sign-up.html" class="global_btn btn global_button"><?=$c['lang_pack']['mobile']['sign_up'];?></a>
            </div>
        </div>
    <?php }else{ ?>
        <div class="user_login">
            <form action="?" method="post" class="user_login_form" id="reg_form">
            	<?php if($reg_ary['Name'][0]){?>
                <div class="user_reg_row clean">
                    <div class="reg_a form_laber"><?=$c['lang_pack']['review']['name'];?><span>*</span></div>
                    <div class="reg_b reg_b_name">
                        <input type="text" class="input form_input fl" name="FirstName" placeholder="<?=$c['lang_pack']['user']['f_name'];?>" notnull="">
                        <input type="text" class="input form_input fr" name="LastName" placeholder="<?=$c['lang_pack']['user']['l_name'];?>" notnull="">
                        <div class="clear"></div>
                    </div>
                </div>
                <?php }?>
                <div class="user_reg_row clean">
                    <div class="reg_a form_laber"><?=$c['lang_pack']['mobile']['email'];?><span>*</span></div>
                    <div class="reg_b">
                        <input type="email" class="input form_input" name="Email" autocomplete="off" placeholder2="you@domain.com" notnull="">
                    </div>
                </div>
                <div class="user_reg_row clean">
                    <div class="reg_a form_laber"><?=$c['lang_pack']['mobile']['password'];?><span>*</span></div>
                    <div class="reg_b">
                        <input type="password" class="input form_input" name="Password" autocomplete="off" placeholder2="<?=$c['lang_pack']['mobile']['at_6_char'];?>" notnull="">
                    </div>
                </div>
                <div class="user_reg_row clean">
                    <div class="reg_a form_laber"><?=$c['lang_pack']['mobile']['confirm'];?><span>*</span></div>
                    <div class="reg_b">
                        <input type="password" class="input form_input" name="Password2" autocomplete="off" placeholder2="<?=$c['lang_pack']['mobile']['confirm_pwd'];?>" notnull="">
                    </div>
                </div>
                <?php
                foreach((array)$reg_ary as $k=>$v){
                    if($k=='Name' || $k=='Email' || !$v[0] || !isset($v[1])) continue;
    				if ($k=='Gender'){
                ?>
                    <div class="user_reg_row clean">
                        <div class="reg_a form_laber"><?=$k?></div>
                        <div class="reg_b form_select_arrow">
                            <select name="<?=$k?>" class="form_select" style="width:100%;">
                            	<?php foreach ($c['gender'] as $k=>$v){?>
                                <option value="<?=$k;?>"><?=$v?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                <?php
                    }else{
                    $kn = $k;
                    if($k=='Birthday'){
                        $kn=$c['lang_pack']['user']['Birthday'];
                    }
                ?>
                    <div class="user_reg_row clean">
                        <div class="reg_a form_laber"><?=$kn; ?><?=$v[1]?'<span>*</span>':'';?></div>
                        <div class="reg_b">
                            <input type="<?=$k=='Birthday' ? 'date' : 'text'; ?>" value="<?=$k=='Birthday' ? date('Y-m-d',$c['time']) : ''; ?>"  class="input form_input" name="<?=$k?>" placeholder2="<?=$c['lang_pack']['mobile']['your'];?> <?=strtolower($k)?>" <?=$v[1]?'notnull=""':'';?>>
                        </div>
                    </div>
                <?php
    				}
                }
    			foreach((array)$set_row as $k=>$v){
    				if ($v['TypeId']){
                ?>
                    <div class="user_reg_row clean">
                        <div class="reg_a form_laber"><?=$v['Name'.$c['lang']]?></div>
                        <div class="reg_b form_select_arrow">
                            <select name="Other[<?=$v['SetId'];?>]" class="form_select" style="width:100%;">
                            	<?php
    							foreach ((array)explode("\r\n", $v['Option'.$c['lang']]) as $k=>$v){?>
                                <option value="<?=$k;?>"><?=$v?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                <?php
    				}else{?>
                    <div class="user_reg_row clean">
                        <div class="reg_a form_laber"><?=$v['Name'.$c['lang']];?></div>
                        <div class="reg_b">
                            <input type="text" class="input form_input" name="Other[<?=$v['SetId'];?>]" placeholder2="<?=$v['Name'.$c['lang']];?>">
                        </div>
                    </div>
                <?php
    				}
    			}?>
                <div class="user_login_btn">
                	<input type="hidden" name="jumpUrl" value="<?=$jumpUrl;?>" />
                	<input type="hidden" name="do_action" value="user.register" />
                    <div class="global_btn btn submit global_button"><?=$c['lang_pack']['mobile']['sign_up'];?></div>
                </div>
            </form>
            <div class="user_login_tab">
                <div><span><?=$c['lang_pack']['user']['title'];?></span></div>
                <a href="/account/" class="global_btn btn global_button"><?=$c['lang_pack']['mobile']['sign_in'];?></a>
            </div>
        </div>
    <?php } ?>
    
</div><!-- end of .wrapper -->