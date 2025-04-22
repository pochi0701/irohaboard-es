<div class="text-center">
<?php
echo $this->Paginator->counter([
	'format' => __('Total').' : {:count}'.__('registros').'　{:page} / {:pages}'.__('páginas')
]);
?>
</div>
<div class="text-center">
	<?= $this->Paginator->pagination(['ul' => 'pagination']); ?>
</div>

