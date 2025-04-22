<div class="users-login">
	<div class="panel panel-info form-signin">
		<div class="panel-heading">
			<?= __('Inicio de sesión de estudiante')?>
		</div>
		<div class="panel-body">
			<?php if(Configure::read('show_admin_link')) {?>
			<div class="text-right"><a href="<?= Router::url(['action' => 'login', 'admin' => true]) ?>"><?= __('Ir a inicio de sesión de administrador')?></a></div>
			<?php }?>
			<?= $this->Flash->render('auth'); ?>
			<?= $this->Form->create('User'); ?>
			
			<div class="form-group">
				<?= $this->Form->input('username', ['label' => __('ID de inicio de sesión'), 'class'=>'form-control', 'value' => $username]); ?>
			</div>
			<div class="form-group">
				<?= $this->Form->input('password', ['label' => __('Contraseña'), 'class'=>'form-control', 'value' => $password]);?>
				<input type="checkbox" name="data[User][remember_me]" checked="checked" value="1" id="remember_me"><?= __('Mantener sesión iniciada')?>
				<?= $this->Form->unlockField('remember_me'); ?>
			</div>
			<?= $this->Form->end(['label' => __('Iniciar sesión'), 'class'=>'btn btn-lg btn-primary btn-block']); ?>
		</div>
	</div>
</div>
