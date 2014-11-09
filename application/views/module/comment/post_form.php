<div class="comments post-comment">

<fieldset>
	<legend><?=I18n::get('post-comment-title', $lang)?></legend>
	
	<?php if(!empty($sSuccessMessage)) { ?>
			<div class="validation-error"><?=$sSuccessMessage?></div>
		<br />	
	<?php } ?>
	
	<?php if(array_key_exists('botik', $aErrors)) { ?>
			<div class="validation-error"><?=$aErrors['botik']?></div>
		<br />	
	<?php } ?>
	
	<?php if(array_key_exists('ct_id', $aErrors)) { ?>
			<div class="validation-error"><?=$aErrors['ct_id']?></div>
		<br />	
	<?php } ?>
	
	<?php if(array_key_exists('id', $aErrors)) { ?>
			<div class="validation-error"><?=$aErrors['id']?></div>
		<br />	
	<?php } ?>
	
	<?php if(array_key_exists('cm_text', $aErrors)) { ?>
			<div class="validation-error"><?=$aErrors['cm_text']?></div>
		<br />	
	<?php } ?>
	
	
	<form action="/<?=$action?>" method="post">
		<input type="hidden" name="botik" value="" />
		<input type="hidden" name="ct_id" value="<?=$ct_id?>" />
		<input type="hidden" name="id" value="<?=$id?>" />
		
		<ul>
			<li class="editor">
				<textarea name="cm_text" id="cm_text"><?=array_key_exists('cm_text', $aCommentData) ? $aCommentData['cm_text'] : ''?></textarea>
			</li>
			<li class="recaptcha">
				<td colspan="3">
					<?php if(array_key_exists('recaptcha-fail', $aErrors)) { ?>
							<div class="validation-error"><?=$aErrors['recaptcha-fail']?></div>
						<br />	
					<?php } ?>
					
					<?=$sRecaptcha?>
			</li>
			<li>
				<ul class="user-info">
					<li>
						<?php if(array_key_exists('cm_name', $aErrors)) { ?>
								<div class="validation-error"><?=$aErrors['cm_name']?></div>
							<br />	
						<?php } ?>
						
						<input type="text" name="cm_name" placeholder="<?=I18n::get('post-comment-name-placeholder', $lang)?>" value="<?=array_key_exists('cm_name', $aCommentData) ? $aCommentData['cm_name'] : ''?>" />
					</li>
					
					<li>
						<?php if(array_key_exists('cm_email', $aErrors)) { ?>
								<div class="validation-error"><?=$aErrors['cm_email']?></div>
							<br />	
						<?php } ?>
						
						<input type="email" name="cm_email" placeholder="<?=I18n::get('post-comment-email-placeholder', $lang)?>" value="<?=array_key_exists('cm_email', $aCommentData) ? $aCommentData['cm_email'] : ''?>" />
					</li>
					
					<li>
						<input type="submit" value="<?=I18n::get('post-comment-post-button', $lang)?>" name="post" />
					</li>
				</ul>
			</li>
			
			<li style="clear: both;"></li>
		</ul>
		
	</form>
	
</fieldset>

</div>