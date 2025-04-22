<div class="users-setting">
	<div class="breadcrumb">
	<?php
	$this->Html->addCrumb(
		'<span class="glyphicon glyphicon-home" aria-hidden="true"></span> HOME',
		['controller' => 'users_courses','action' => 'index'],
		['escape' => false]
	);
	echo $this->Html->getCrumbs(' / ');
	?>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?= __('Configuración')?>
		</div>
		<div class="panel-body">
		<?php
			echo $this->Form->create('User', Configure::read('form_defaults'));
			echo $this->Form->input('User.new_password', [
				'label' => __('Nueva contraseña'),
				'type' => 'password',
				'autocomplete' => 'new-password'
			]);
			
			echo $this->Form->input('User.new_password2', [
				'label' => __('Nueva contraseña (confirmación)'),
				'type' => 'password',
				'autocomplete' => 'new-password'
			]);
			echo Configure::read('form_submit_before')
				.$this->Form->submit(__('Guardar'), Configure::read('form_submit_defaults'))
				.Configure::read('form_submit_after');
			echo $this->Form->end();
		?>
		</div>
	</div>
</div>
