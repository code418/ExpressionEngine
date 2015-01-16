<?php extend_template('wrapper'); ?>

<?php if (isset($header)): ?>
	<div class="col-group">
		<div class="col w-16 last">
			<div class="box full mb">
				<div class="tbl-ctrls">
					<?php if (isset($header['form_url'])): ?>
						<?=form_open($header['form_url'])?>
							<fieldset class="tbl-search right">
								<input placeholder="<?=lang('type_phrase')?>" type="text" value="">
								<?php if (isset($header['search_button_value'])): ?>
								<input class="btn submit" type="submit" value="<?=$header['search_button_value']?>">
								<?php else: ?>
								<input class="btn submit" type="submit" value="<?=lang('search')?>">
								<?php endif; ?>
							</fieldset>
					<?php endif ?>
						<h1>
							<?=$header['title']?>
							<?php if (isset($header['toolbar_items']))
							{
								echo ee()->load->view('_shared/toolbar', $header, TRUE);
							} ?>
						</h1>
					<?php if (isset($header['form_url'])): ?>
						</form>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>

<div class="col-group">
	<div class="col w-16 last">
		<ul class="breadcrumb">
			<?php foreach ($cp_breadcrumbs as $link => $title): ?>
				<li><a href="<?=$link?>"><?=$title?></a></li>
			<?php endforeach ?>
			<li class="last"><?=$cp_page_title?></li>
		</ul>

		<div class="box">
			<h1><?=$cp_page_title?></h1>
			<div class="tab-bar">
				<ul>
					<li><a class="act" href="" rel="t-0"><?=lang('edit')?></a></li>
					<li><a href="" rel="t-1"><?=lang('notes')?></a></li>
					<li><a href="" rel="t-2"><?=lang('variables')?></a></li>
				</ul>
			</div>
			<?=form_open($form_url, 'class="settings"')?>
			<?=ee('Alert')->getAllInlines()?>
				<div class="tab t-0 tab-open">
					<fieldset class="col-group">
						<div class="setting-txt col w-16">
							<h3><?=lang('email_subject')?></h3>
							<em></em>
						</div>
						<div class="setting-field col w-16 last">
							<input type="text" name="data_title" value="<?=set_value('data_title', $template->data_title)?>">
						</div>
					</fieldset>
					<fieldset class="col-group last">
						<div class="setting-txt col w-16">
							<em><?=sprintf(lang('last_edit'), ee()->localize->human_time($template->edit_date), $author)?></em>
						</div>
						<div class="setting-field col w-16 last">
							<textarea class="template-edit" cols="" rows="" name="template_data"><?=set_value('template_data', $template->template_data)?></textarea>
						</div>
					</fieldset>
					<fieldset class="col-group last">
						<div class="setting-txt col w-8">
							<h3><?=lang('enable_template')?></h3>
							<em><?=lang('enable_template_desc')?></em>
						</div>
						<div class="setting-field col w-8 last">
							<?php $value = set_value('enable_template', $template->enable_template); ?>
							<label class="choice mr<?php if ($value == 'y' || $value === TRUE) echo ' chosen'?>"><input type="radio" name="enable_template" value="y"<?php if ($value == 'y' || $value === TRUE) echo ' checked="checked"'?>> <?=lang('enable')?></label>
							<label class="choice<?php if ($value == 'n' || $value === FALSE) echo ' chosen'?>"><input type="radio" name="enable_template" value="n"<?php if ($value == 'n' || $value === FALSE) echo ' checked="checked"'?>> <?=lang('disable')?></label>
							<?=form_error('cache')?>
						</div>
					</fieldset>
				</div>
				<div class="tab t-1">
					<fieldset class="col-group last">
						<div class="setting-txt col w-16">
							<h3><?=lang('template_notes')?></h3>
							<em><?=lang('template_notes_desc')?></em>
						</div>
						<div class="setting-field col w-16 last">
							<textarea cols="" rows="" name="template_notes"><?=set_value('template_notes', $template->template_notes)?></textarea>
						</div>
					</fieldset>
				</div>
				<div class="tab t-2">
					<fieldset class="col-group last">
						<div class="setting-txt col w-8">
							<h3><?=lang('variables')?></h3>
							<em><?=lang('variables_desc')?></em>
						</div>
						<div class="setting-field col w-8 last">
							<ul class="arrow-list">
								<?php foreach ($template->getAvailableVariables() as $variable): ?>
								<li><a href="">{<?=$variable?>}</a></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</fieldset>
				</div>
				<fieldset class="form-ctrls">
					<?php if (ee()->form_validation->errors_exist()): ?>
					<button class="btn disable" disabled="disabled" name="submit" type="submit" value="update" data-submit-text="<?=lang('btn_update_template')?>" data-work-text="<?=lang('btn_update_template_working')?>"><?=lang('btn_fix_errors')?></button>
					<button class="btn disable" disabled="disabled" name="submit" type="submit" value="finish" data-submit-text="<?=lang('btn_update_and_finish_editing')?>" data-work-text="<?=lang('btn_update_template_working')?>"><?=lang('btn_fix_errors')?></button>
					<?php else: ?>
					<button class="btn" name="submit" type="submit" value="update" data-submit-text="<?=lang('btn_update_template')?>" data-work-text="<?=lang('btn_update_template_working')?>"><?=lang('btn_update_template')?></button>
					<button class="btn" name="submit" type="submit" value="finish" data-submit-text="<?=lang('btn_update_and_finish_editing')?>" data-work-text="<?=lang('btn_update_template_working')?>"><?=lang('btn_update_and_finish_editing')?></button>
					<?php endif;?>
				</fieldset>
			</form>
		</div>

	</div>
</div>

<?php if (isset($blocks['modals'])) echo $blocks['modals']; ?>