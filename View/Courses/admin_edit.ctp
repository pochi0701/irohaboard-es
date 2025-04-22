<?= $this->element('admin_menu');?>
<div class="admin-courses-edit">
<?= $this->Html->link(__('<< Volver'), ['action' => 'index'])?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?= $this->isEditPage() ? __('Editar') :  __('Nuevo curso'); ?>
		</div>
		<div class="panel-body">
		<?php
			echo $this->Form->create('Course', Configure::read('form_defaults'));
			echo $this->Form->input('id');
			echo $this->Form->input('title',	['label' => __('Nombre del curso')]);
			echo $this->Form->input('introduction',	['label' => __('Introducción del curso')]);
			echo $this->Form->input('comment',		['label' => __('Observaciones')]);
			echo Configure::read('form_submit_before')
				.$this->Form->submit(__('Guardar'), Configure::read('form_submit_defaults'))
				.Configure::read('form_submit_after');
			echo $this->Form->end();
		?>
		</div>
	</div>
</div>