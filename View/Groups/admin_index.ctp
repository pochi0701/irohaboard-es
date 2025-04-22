<?= $this->element('admin_menu');?>
<div class="admin-groups-index">
	<div class="ib-page-title"><?= __('Lista de grupos'); ?></div>
	<div class="buttons_container">
		<button type="button" class="btn btn-primary btn-add" onclick="location.href='<?= Router::url(['action' => 'add']) ?>'">+ Agregar</button>
	</div>
	<table>
	<thead>
	<tr>
		<th><?= $this->Paginator->sort('title', 'Nombre del grupo'); ?></th>
		<th nowrap class="col-course"><?= __('Cursos asignados'); ?></th>
		<th class="ib-col-date"><?= $this->Paginator->sort('created', __('Fecha de creación')); ?></th>
		<th class="ib-col-date"><?= $this->Paginator->sort('modified', __('Fecha de actualización')); ?></th>
		<th class="ib-col-action"><?= __('Acciones'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($groups as $group): ?>
	<tr>
		<td><?= h($group['Group']['title']); ?></td>
		<td><div class="reader" title="<?= h($group['GroupCourse']['course_title']); ?>"><p><?= h($group['GroupCourse']['course_title']); ?>&nbsp;</p></div></td>
		<td class="ib-col-date"><?= h(Utils::getYMDHN($group['Group']['created'])); ?>&nbsp;</td>
		<td class="ib-col-date"><?= h(Utils::getYMDHN($group['Group']['modified'])); ?>&nbsp;</td>
		<td class="ib-col-action">
			<button type="button" class="btn btn-success" onclick="location.href='<?= Router::url(['action' => 'edit', $group['Group']['id']]) ?>'"><?= __('Editar')?></button>
			<?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $group['Group']['id']], ['class'=>'btn btn-danger'], 
					__('¿Está seguro de que desea eliminar [%s]?', $group['Group']['title']));?>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<?= $this->element('paging');?>
</div>
