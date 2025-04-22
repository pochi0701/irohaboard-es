<?= $this->element('admin_menu');?>
<?= $this->Html->css( 'select2.min.css');?>
<?= $this->Html->script( 'select2.min.js');?>
<?php $this->Html->scriptStart(['inline' => false]); ?>
	$(function (e) {
		$('#GroupGroup').select2({placeholder:   "<?= __('Seleccione el grupo al que pertenece (selección múltiple)')?>", closeOnSelect: <?= (Configure::read('close_on_select') ? 'true' : 'false'); ?>,});
		$('#CourseCourse').select2({placeholder: "<?= __('Seleccione el curso a tomar (selección múltiple)')?>", closeOnSelect: <?= (Configure::read('close_on_select') ? 'true' : 'false'); ?>,});
		// パスワードの自動復元を防止
		setTimeout('$("#UserNewPassword").val("");', 500);
	});
<?php $this->Html->scriptEnd(); ?>
<div class="admin-users-edit">
<?= $this->Html->link(__('<< Volver'), ['action' => 'index'])?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?= $this->isEditPage() ? __('Editar') :  __('Nuevo usuario'); ?>
		</div>
		<div class="panel-body">
		<?php
			echo $this->Form->create('User', Configure::read('form_defaults'));
			
			$password_label = $this->isEditPage() ? __('Nueva contraseña') : __('Contraseña');
			
			echo $this->Form->input('id');
			echo $this->Form->input('username',				['label' => __('ID de inicio de sesión')]);
			echo $this->Form->input('User.new_password',	['label' => $password_label, 'type' => 'password', 'autocomplete' => 'new-password']);
			echo $this->Form->input('name',					['label' => __('Nombre completo')]);
			
			// root アカウント、もしくは admin 権限以外の場合、権限変更を許可しない
			$disabled = (($username == 'root') || ($loginedUser['role'] != 'admin'));
			
			echo $this->Form->inputRadio('role',	['label' => __('Permisos'), 'options' => Configure::read('user_role')]);
			
			echo $this->Form->input('email',				['label' => __('Correo electrónico')]);
			echo $this->Form->input('Group',				['label' => __('Grupo de pertenencia')]);
			echo $this->Form->input('Course',				['label' => __('Curso inscrito')]);
			echo $this->Form->input('comment',				['label' => __('Notas')]);
			echo Configure::read('form_submit_before')
				.$this->Form->submit(__('Guardar'), Configure::read('form_submit_defaults'))
				.Configure::read('form_submit_after');
			echo $this->Form->end();
			
			// 編集の場合のみ、学習履歴削除ボタンを表示
			if($this->isEditPage())
			{
				echo $this->Form->postLink(__('Eliminar historial de estudio'),
					['action' => 'clear', $this->request->data['User']['id']],
					['class' => 'btn btn-default pull-right btn-clear'],
					__('¿Está seguro de que desea eliminar el historial de estudio?', $this->request->data['User']['name']));
			}
		?>
		</div>
	</div>
</div>
