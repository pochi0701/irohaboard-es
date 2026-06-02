<div class="ib-page-title"><?= $message; ?></div>
<p class="error">
	<strong><?= __('エラー'); ?>: </strong>
	<?= __('内部エラーが発生しました。'); ?>
</p>
<?php
if (Configure::read('debug') > 0):
	echo $this->element('exception_stack_trace');
endif;
