<?= $this->element('admin_menu');?>
<?php $this->start('script-embedded'); ?>
<script>
	$(function(){
		$('#sortable-table tbody').sortable(
		{
			helper: function(event, ui)
			{
				var children = ui.children();
				var clone = ui.clone();

				clone.children().each(function(index)
				{
					$(this).width(children.eq(index).width());
				});
				return clone;
			},
			update: function(event, ui)
			{
				var id_list = new Array();

				$('.target_id').each(function(index)
				{
					id_list[id_list.length] = $(this).val();
				});

				$.ajax({
					url: "<?= Router::url(['action' => 'order']) ?>",
					type: "POST",
					data: { id_list : id_list },
					dataType: "text",
					success : function(response){
						//通信成功時の処理
						//alert(response);
					},
					error: function(){
						//通信失敗時の処理
						//alert('通信失敗');
					}
				});
			},
			cursor: "move",
			opacity: 0.5
		});
	});
</script>
<?php $this->end(); ?>

<div class="admin-contents-questions-index">
	<div class="ib-breadcrumb">
	<?php 
		$this->Html->addCrumb(__('Lista de cursos'), ['controller' => 'courses', 'action' => 'index']);
		$this->Html->addCrumb($content['Course']['title'], ['controller' => 'contents', 'action' => 'index', $content['Course']['id']]);
		$this->Html->addCrumb(h($content['Content']['title']));
		
		echo $this->Html->getCrumbs(' / ');
	?>
	</div>
	<div class="ib-page-title"><?= __('Lista de preguntas del examen'); ?></div>
	
	<div class="buttons_container">
		<button type="button" class="btn btn-primary btn-add" onclick="location.href='<?= Router::url(['action' => 'add', $content['Content']['id']]) ?>'">+ Agregar</button>
	</div>
	
	<div class="alert alert-warning"><?= __('Puede cambiar el orden de las preguntas arrastrando y soltando.'); ?></div>
	<table id='sortable-table' cellpadding="0" cellspacing="0">
	<thead>
	<tr>
		<th><?= __('Título'); ?></th>
		<th><?= __('Pregunta'); ?></th>
		<th><?= __('Opciones'); ?></th>
		<th width="40" nowap><?= __('Correcta'); ?></th>
		<th width="40" nowap><?= __('Puntos'); ?></th>
		<th class="ib-col-date"><?= __('Fecha de creación'); ?></th>
		<th class="ib-col-date"><?= __('Fecha de actualización'); ?></th>
		<th class="actions text-center"><?= __('Acciones'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($contentsQuestions as $contentsQuestion): ?>
	<tr>
		<td class="td-reader"><?= h($contentsQuestion['ContentsQuestion']['title']); ?>&nbsp;</td>
		<td class="td-reader"><?= h(strip_tags($contentsQuestion['ContentsQuestion']['body'])); ?>&nbsp;</td>
		<td class="td-reader"><?= h($contentsQuestion['ContentsQuestion']['options']); ?>&nbsp;</td>
		<td><?= h($contentsQuestion['ContentsQuestion']['correct']); ?>&nbsp;</td>
		<td><?= h($contentsQuestion['ContentsQuestion']['score']); ?>&nbsp;</td>
		<td class="ib-col-date"><?= Utils::getYMDHN($contentsQuestion['ContentsQuestion']['created']); ?>&nbsp;</td>
		<td class="ib-col-date"><?= Utils::getYMDHN($contentsQuestion['ContentsQuestion']['modified']); ?>&nbsp;</td>
		<td class="actions text-center">
			<button type="button" class="btn btn-success" onclick="location.href='<?= Router::url(['action' => 'edit', $contentsQuestion['Content']['id'], $contentsQuestion['ContentsQuestion']['id']]) ?>'">Editar</button>
			<?php if($loginedUser['role'] == 'admin') {?>
			<?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $contentsQuestion['ContentsQuestion']['id']], ['class'=>'btn btn-danger'], 
					__('¿Está seguro de que desea eliminar [%s]?', $contentsQuestion['ContentsQuestion']['title'])); ?>
			<?php }?>
			<?= $this->Form->hidden('id', ['id'=>'', 'class'=>'target_id', 'value'=>$contentsQuestion['ContentsQuestion']['id']]);?>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
</div>