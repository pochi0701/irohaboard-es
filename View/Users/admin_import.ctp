<?= $this->element('admin_menu');?>
<div class="admin-users-import">
<?= $this->Html->link(__('<< 戻る'), ['action' => 'index'])?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?= __('Import'); ?>
		</div>
		<div class="panel-body">
			<li><?= __('ユーザ情報が格納されたCSVファイルを選択し、インポートを行って下さい。'); ?></li>
			<li><?= __('CSVファイルの文字コードは「Shift-JIS」を使用してください。(UTF-8は使用できません。)'); ?></li>
			<li><?= __('1行目はヘッダー行として扱われます。'); ?></li>
			<li><?= __('パスワードの指定は任意です。指定されていない場合は、既存のパスワードが保持されます。'); ?></li>
			<li><?= __('インポート処理がタイムアウトする場合は、CSVファイルを分割してインポートしてください。'); ?></li>
			<br>
			<?= __('CSVの形式 ( * : 必須項目)'); ?>
			<table class="ib-table-csv">
			<tr>
				<th><?= __('ログインID'); ?>*</th>
				<th><?= __('パスワード'); ?></th>
				<th><?= __('氏名'); ?>*</th>
				<th><?= __('権限 (受講者 / 管理者)'); ?>*</th>
				<th><?= __('メールアドレス'); ?></th>
				<th><?= __('備考'); ?></th>
				<th><?= __('所属グループ・・・%d列', Configure::read('import_group_count')); ?></th>
				<th><?= __('受講コース・・・%d列', Configure::read('import_course_count')); ?></th>
			</tr>
			</table>
			<?php
				// PHP8.1対応
				$this->Form->unlockField('csvfile.full_path');
				
				echo $this->Form->create('User',['type'=>'file']);
				echo $this->Form->input('csvfile',['label'=>'','type'=>'file']);
				echo $this->Form->submit(__('Import'), Configure::read('form_submit_defaults'));
				echo $this->Form->end();
			?>
			<div style="color:red;">
			<?= $err_msg; ?>
			</div>
		</div>
	</div>
</div>
