<?= $this->element('admin_menu');?>
<?= $this->Html->css( 'select2.min.css');?>
<?= $this->Html->script( 'select2.min.js');?>
<?php $this->Html->scriptStart(['inline' => false]); ?>
	$(function (e) {
		$('#CourseCourse').select2({placeholder: "<?= __('Seleccione los cursos a tomar. (Selección múltiple permitida)')?>", closeOnSelect: <?= (Configure::read('close_on_select') ? 'true' : 'false'); ?>,});
	});
<?php $this->Html->scriptEnd(); ?>
<div class="admin-groups-edit">
<?= $this->Html->link(__('<< Volver'), ['action' => 'index'])?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?= $this->isEditPage() ? __('Editar') :  __('Nuevo grupo'); ?>
		</div>
		<div class="panel-body">
		<?php
			echo $this->Form->create('Group', Configure::read('form_defaults'));
			echo $this->Form->input('id');
			echo $this->Form->input('title',	['label' => __('Nombre del grupo')]);
			echo $this->Form->input('Course',	['label' => __('Cursos a tomar'),		'size' => 20]);
			echo $this->Form->input('comment',	['label' => __('Observaciones')]);
			echo Configure::read('form_submit_before')
				.$this->Form->submit(__('Guardar'), Configure::read('form_submit_defaults'))
				.Configure::read('form_submit_after');
			echo $this->Form->end();
		?>
		</div>
	</div>
</div>