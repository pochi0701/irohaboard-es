<?= $this->element('admin_menu');?>
<?= $this->Html->css( 'select2.min.css');?>
<?= $this->Html->script( 'select2.min.js');?>
<?php $this->Html->scriptStart(['inline' => false]); ?>
	$(function (e) {
		$('#GroupGroup').select2({placeholder:   "<?= __('Si no se selecciona, todos los usuarios serán el objetivo.')?>", closeOnSelect: <?= (Configure::read('close_on_select') ? 'true' : 'false'); ?>,});
	});
<?php $this->Html->scriptEnd(); ?>

<div class="admin-infos-edit">
<?= $this->Html->link(__('<< Volver'), ['action' => 'index'])?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?= $this->isEditPage() ? __('Editar') :  __('Nuevo aviso'); ?>
		</div>
		<div class="panel-body">
		<?php
			echo $this->Form->create('Info', Configure::read('form_defaults'));
			echo $this->Form->input('id');
			echo $this->Form->input('title',	['label' => __('Título')]);
			echo $this->Form->input('body',		['label' => __('Contenido')]);
			echo $this->Form->input('Group',	['label' => __('Grupo objetivo'),	'size' => 20]);
			echo Configure::read('form_submit_before')
				.$this->Form->submit(__('Guardar'), Configure::read('form_submit_defaults'))
				.Configure::read('form_submit_after');
			echo $this->Form->end();
		?>
		</div>
	</div>
</div>
