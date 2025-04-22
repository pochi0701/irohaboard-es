<div class="admin-users-login">
	<div class="panel panel-default form-signin">
		<div class="panel-heading">
			<?= __('Inicio de sesión de administrador')?>
		</div>
		<div class="panel-body">
			<div class="text-right"><a href="<?= Router::url(['action' => 'login', 'admin' => false]) ?>"><?= __('Ir a inicio de sesión de estudiante')?></a></div>
			<?= $this->Flash->render('auth'); ?>
			<?= $this->Form->create('User'); ?>
			
			<div class="form-group">
				<?= $this->Form->input('username', ['label' => __('ID de inicio de sesión'), 'class'=>'form-control']); ?>
			</div>
			<div class="form-group">
				<?= $this->Form->input('password', ['label' => __('Contraseña'), 'class'=>'form-control']);?>
			</div>
			<?= $this->Form->end(['label' => __('Iniciar sesión'), 'class'=>'btn btn-lg btn-primary btn-block']); ?>
		</div>
	</div>
</div>
