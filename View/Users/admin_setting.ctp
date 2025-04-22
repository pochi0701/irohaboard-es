<?= $this->element('admin_menu');?>
<div class="admin-users-setting">
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