<?= $this->element('admin_menu');?>
<?php $this->start('script-embedded'); ?>
<script>
	$(document).ready(function()
	{
		$('option').each(function(){
			console.log($(this).val());
			$(this).css('color',		'white');
			$(this).css('background',	$(this).val());
			$(this).css('font-weight',	'bold');
		});
	});
</script>
<?php $this->end(); ?>
<div class="admin-settings-index">
	<div class="panel panel-default">
		<div class="panel-heading">
			<?= __('Configuración del sistema'); ?>
		</div>
		<div class="panel-body">
		<?php
			echo $this->Form->create('Setting', Configure::read('form_defaults'));
			echo $this->Form->input('title',		['label' => __('Nombre del sistema'),		'value'=>$settings['title']]);
			echo $this->Form->input('copyright',	['label' => __('Derechos de autor'),		'value'=>$settings['copyright']]);
			echo $this->Form->input('color',		['label' => __('Color del tema'),		'options'=>$colors, 'selected'=>$settings['color']]);
			echo $this->Form->input('information',	['label' => __('Aviso general'),	'value'=>$settings['information'], 'type' => 'textarea']);
			echo Configure::read('form_submit_before')
				.$this->Form->submit(__('Guardar'), Configure::read('form_submit_defaults'))
				.Configure::read('form_submit_after');
			echo $this->Form->end();
		?>
		</div>
	</div>
</div>
