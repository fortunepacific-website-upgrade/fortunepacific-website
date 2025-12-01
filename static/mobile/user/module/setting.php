<?php !isset($c) && exit();?>
<?php
$regset_row=db::get_one('config', "GroupId='user' and Variable='RegSet'");
$reg_ary=str::json_data($regset_row['Value'], 'decode');
$set_row=str::str_code(db::get_all('user_reg_set', '1', '*', "{$c[my_order]} SetId asc"));
?>
<script type="text/javascript">$(function (){user_obj.user_setting();});</script>
<div class="wrapper">
    <div class="m_editAddr">
    	<form action="/account/" method="post" id="setting_form0">
        	<div class="subtitle first" onclick="window.history.back();"><?=$c['lang_pack']['mobile']['c_profile'];?></div>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['review']['name'];?>:</div>
                <div class="input clean input_span_name">
                    <span class="input_span fl">
                        <input type="text" class="input_text form_input " value="<?=$user_row['FirstName'];?>" placeholder="<?=$c['lang_pack']['mobile']['fir_name'];?>" name="FirstName" notnull="notnull" />
                    </span>
                    <span class="input_span fr">
                        <input type="text" class="input_text form_input" value="<?=$user_row['LastName'];?>" placeholder="<?=$c['lang_pack']['mobile']['last_name'];?>" name="LastName" notnull="notnull" />
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <?php
            foreach((array)$reg_ary as $k=>$v){
                if($k=='Name' || $k=='Email' || !$v[0] || !isset($v[1])) continue;
				if ($k=='Gender'){
            ?>
            <div class="addr_row">
                <div class="form_laber"><?=$k;?>:</div>
                <div class="input clean form_select_arrow">
                    <select name="<?=$k;?>" class="addr_select form_select">
                        <?php foreach ($c['gender'] as $k=>$v){?>
                        <option value="<?=$k;?>"><?=$v;?></option>
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
            <div class="addr_row">
                <div class="form_laber"><?=$kn;?>:</div>
                <div class="input clean">
                    <span class="input_span"><input type="<?=$k=='Birthday' ? 'date' : 'text'; ?>" class="input_text form_input" value="<?=$k=='Birthday' ? date('Y-m-d',$user_row[$k]) : $user_row[$k]; ?>" name="<?=$k;?>" <?=$v[1]?'notnull=""':'';?> /></span>
                </div>
            </div>
			<?php }
			}
			$Other = json_decode($user_row['Other'], true);
			foreach((array)$set_row as $k=>$v){
				if ($v['TypeId']){
            ?>
            	<div class="addr_row">
                    <div class="form_laber"><?=$v['Name'.$c['lang']]?>:</div>
                    <div class="input clean form_select_arrow">
                        <select name="Other[<?=$v['SetId'];?>]" class="addr_select form_select">
                            <?php
							foreach ((array)explode("\r\n", $v['Option'.$c['lang']]) as $k=>$v){?>
                            <option value="<?=$k;?>" <?=$Other[$v['SetId']]==$k?'selected="selected"':'';?>><?=$v?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
            <?php
				}else{?>
                <div class="addr_row">
                    <div class="form_laber"><?=$v['Name'.$c['lang']];?>:</div>
                    <div class="input clean">
                        <span class="input_span"><input type="text" class="input_text form_input" value="<?=$Other[$v['SetId']];?>" name="Other[<?=$v['SetId'];?>]" placeholder="<?=$v['Name'.$c['lang']];?>"></span>
                    </div>
                </div>
            <?php
				}
			}?>
            <div class="addr_row">
                <div class="input clean">
                    <span class="input_btn global_button global_btn sub_btn"><?=$c['lang_pack']['mobile']['save'];?></span>
                </div>
            </div>
            <input type="hidden" name="do_action" value="user.mod_profile" />
		</form>
        <form action="/account/" method="post" id="setting_form1">
        	<div class="subtitle"><?=$c['lang_pack']['mobile']['c_email'];?></div>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['ex_pwd'];?>:</div>
                <div class="input clean">
                    <span class="input_span"><input type="password" class="input_text form_input" name="ExtPassword" autocomplete="off" notnull="notnull" /></span>
                </div>
            </div>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['new_email'];?>:</div>
                <div class="input clean">
                    <span class="input_span"><input type="email" class="input_text form_input" name="NewEmail" autocomplete="off" notnull="notnull" /></span>
                </div>
            </div>
            <div class="addr_row">
                <div class="input clean">
                    <span class="input_btn global_button global_btn sub_btn"><?=$c['lang_pack']['mobile']['save'];?></span>
                </div>
            </div>
            <input type="hidden" name="do_action" value="user.mod_email" />
		</form>
        <form action="/account/" method="post" id="setting_form2">
        	<div class="subtitle"><?=$c['lang_pack']['mobile']['c_pwd'];?></div>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['ex_pwd'];?>:</div>
                <div class="input clean">
                    <span class="input_span"><input type="password" class="input_text form_input" name="ExtPassword" autocomplete="off" notnull="notnull" /></span>
                </div>
            </div>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['new_pwd'];?>:</div>
                <div class="input clean">
                    <span class="input_span"><input type="password" class="input_text form_input" name="NewPassword" autocomplete="off" notnull="notnull" /></span>
                </div>
            </div>
            <div class="addr_row">
                <div class="form_laber"><?=$c['lang_pack']['mobile']['re_pwd'];?>:</div>
                <div class="input clean">
                    <span class="input_span"><input type="password" class="input_text form_input" name="NewPassword2" autocomplete="off" notnull="notnull" /></span>
                </div>
            </div>
            <div class="addr_row">
                <div class="input clean">
                    <span class="input_btn global_button global_btn sub_btn"><?=$c['lang_pack']['mobile']['save'];?></span>
                </div>
            </div>
            <input type="hidden" name="do_action" value="user.mod_password" />
		</form>
    </div><!-- end of .m_editAddr -->
</div><!-- end of .wrapper -->