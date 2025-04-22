<nav class="navbar navbar-default">
	<div class="container">
		<div class="navbar-collapse collapse">
		<ul class="nav navbar-nav">
			<?php
			$is_active = (($this->name == 'Users') && ($this->params["action"] != 'admin_password')) ? ' active' : '';
			echo '<li class="'.$is_active.'">'.$this->Html->link(__('Usuarios'), ['controller' => 'users', 'action' => 'index']).'</li>';

			$is_active = ($this->name == 'Groups') ? ' active' : '';
			echo '<li class="'.$is_active.'">'.$this->Html->link(__('Grupos'), ['controller' => 'groups', 'action' => 'index']).'</li>';

			$is_active = (($this->name == 'Courses') || ($this->name == 'Contents') || ($this->name == 'ContentsQuestions') || ($this->name == 'EnquetesQuestions')) ? ' active' : '';
			echo '<li class="'.$is_active.'">'.$this->Html->link(__('Cursos'), ['controller' => 'courses', 'action' => 'index']).'</li>';

			$is_active = ($this->name == 'Infos') ? ' active' : '';
			echo '<li class="'.$is_active.'">'.$this->Html->link(__('Noticias'), ['controller' => 'infos', 'action' => 'index']).'</li>';

			$is_active = ($this->name == 'Records') ? ' active' : '';
			echo '<li class="'.$is_active.'">'.$this->Html->link(__('Historial de aprendizaje'), ['controller' => 'records', 'action' => 'index']).'</li>';

			if($loginedUser['role'] == 'admin')
			{
				$is_active = ($this->name == 'Settings') ? ' active' : '';
				echo '<li class="'.$is_active.'">'.$this->Html->link(__('Configuración del sistema'), ['controller' => 'settings', 'action' => 'index']).'</li>';
			}
			?>
		</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>
