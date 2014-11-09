<div class="wrap">
	<div class="login-page">
		<table class="login-table">
			<tr>
				<td class="login-block">
					<div>

						<div class="language-selector">
							<div class="language-selector-items">

								<?php foreach($languages as $lang) 
								{
									if($lang->la_id != $la_id) { ?>
									<div class="language-item">
										<a href="/<?=str_replace($la_code, $lang->la_code, $url)?>" class="language-item-container">
											<span class="language-icon <?=$lang->la_code?>"></span>
											<span class="language-title"><?=empty($lang->la_own_title) ? $lang->la_title : $lang->la_own_title?></span>
										</a>
									</div>
								<?php }
								} ?>
							</div>
							<div class="language-selector-selected">
								<?php foreach($languages as $lang) 
								{
									if($lang->la_id == $la_id) { ?>
									<div class="language-item selected">
										<div class="language-item-container">
											<span class="language-icon <?=$lang->la_code?>"></span>
											<span class="language-title"><?=empty($lang->la_own_title) ? $lang->la_title : $lang->la_own_title?></span>
										</div>
									</div>
									
								<?php }
								} ?>
								<div class="arrow-item"><span class="arrow"></span></div>
							</div>
						</div>
					</div>
					<br />
					<div class="login-form-container">
						<form action="/<?=$form_url?>" method="post">
							<?/*<input type="hidden" name="email" value="kolombetam@gmail.com" />*/?>
							<table class="table-form">
								<tr>
									<td class="label"><?=__('username')?>:</td>
									<td class="field">
										<input type="text" name="username" />
									</td>										
								</tr>
								<tr>
									<td class="label"><?=__('password')?>:</td>
									<td class="field">
										<input type="password" name="password" />
										<?/*<input type="password" name="password_confirm" />*/?>										
								</tr>
								<tr>
									<td></td>
									<td class="form-buttons">
										<input type="submit" value="<?=__('login-button')?>" class="button" />									
									</td>
								</tr>
							</table>
						</form>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>


