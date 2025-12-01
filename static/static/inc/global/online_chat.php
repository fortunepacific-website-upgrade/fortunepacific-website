<?php !isset($c) && exit();?>
<?php 
$chat_row=db::get_all('chat', '1', '*', $c['my_order'].'CId asc');
foreach((array)$chat_row as $k=>$v){
    $type_row_ary[$v['Type']][]=$v;
}
?>
<div id="chat_window">
    <div class="chat_box<?=$c['is_responsive']?' is_respon':' pc_limit';?>">
        <div class="box trans_05">
           <div class="box_area">
            <?php foreach((array)$type_row_ary as $k => $v){ 
                ?>
                <?php if(count($v)>1 || $k==4){ ?>
                <div class="chat_item chat_<?=strtolower($c['chat']['type'][$k]); ?>" >
                    <div class="abs">
                        <div class="more_box">
                            <?php 
                            foreach((array)$v as $v1){ 
                                $link = $k==4 ? 'javascript:;' : sprintf($c['chat']['link'][$v1['Type']],$v1['Account']);
                                ?>
                                <a href="<?=$link; ?>" target="_blank" class="item">
                                    <?=$v1['Name'];?>
                                    <?php if($k==4){ ?>
                                        <div class="relimg"><img src="<?=$v1['PicPath']?>" alt=""></div>
                                    <?php } ?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>                
                </div>
                <?php }else{ ?>
                    <a href="<?=sprintf($c['chat']['link'][$v[0]['Type']],$v[0]['Account']); ?>" title="<?=$v[0]['Name']; ?>" target="_blank" class="chat_item chat_<?=strtolower($c['chat']['type'][$k]); ?>"><?=$v[0]['Name']; ?></a>
                <?php } ?>
            <?php } ?>
            </div>
            <span class="chat_close"></span>
        </div>
        <div class="chat_box_menu">
            <?php if($chat_row){ ?>
            <a href="javascript:;" class="more"></a>
            <?php } ?>
            <a href="javascript:;" id="go_top" class="top trans_05"></a>
        </div>
    </div>
</div>
<?php 
if((int)$c['config']['Platform']['Facebook']['PageId']['IsUsed']){
	$messenger_url='https://m.me/'.$c['config']['Platform']['Facebook']['PageId']['Data']['page_id'];
?>
	<div id="facebook-messenger" class="message_us"><a href="<?=$messenger_url;?>" target="_blank"><img src="/static/ico/message-us-blue.png" alt="Message Us" /></a></div>
<?php }?>