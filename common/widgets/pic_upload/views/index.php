<?php
/**
 * @see Yii中文网  http://www.yii-china.com
 * @author Xianan Huang <Xianan_huang@163.com>
 * 图片上传组件
 * 如何配置请到官网（Yii中文网）查看相关文章
 */

use yii\helpers\Html;
?>
<div class="col-lg-10 control-label per_upload_con" data-url="<?=$config['serverUrl']?>">
    <div class="nper_real_img <?=$attribute?>" domain-url = "<?=$config['domain_url']?>"><?=isset($inputValue)?'<img src="'.$config['domain_url'].$inputValue.'">':''?></div>
    <div class="nper_upload_img">营业执照图片上传</div>
    <div class="nper_upload_text">
        <p class="upbtn" ><a id="<?=$attribute?>" href="javascript:;" class="btn btn-login choose_btn">营业执照图片上传</a></p>
    </div>
    <input up-id="<?=$attribute?>" type="hidden" name="<?=$inputName?>" upname='<?=$config['fileName']?>' value="<?=isset($inputValue)?$inputValue:''?>" filetype="img" />
</div>