<?= $this->element('admin_menu');?>
<?php $this->start('script-embedded'); ?>
<script>
	function openRecord(course_id, user_id)
	{
		window.open(
			'<?= Router::url(['controller' => 'contents', 'action' => 'record']) ?>/'+course_id+'/'+user_id,
			'irohaboard_record',
			'width=1100, height=700, menubar=no, toolbar=no, scrollbars=yes'
		);
	}
	
	function openTestRecord(content_id, record_id)
	{
		window.open(
			'<?= Router::url(['controller' => 'contents_questions', 'action' => 'record']) ?>/'+content_id+'/'+record_id,
			'irohaboard_record',
			'width=1100, height=700, menubar=no, toolbar=no, scrollbars=yes'
		);
	}
	
	function openRecordEnquete(content_id, record_id)
	{
		window.open(
			'<?= Router::url(['controller' => 'enquetes_questions', 'action' => 'record']) ?>/'+content_id+'/'+record_id,
			'irohaboard_record',
			'width=1100, height=700, menubar=no, toolbar=no, scrollbars=yes'
		);
	}
	
	function downloadCSV()
	{
		$("#RecordCmd").val("csv");
		$("#RecordAdminIndexForm").submit();
		$("#RecordCmd").val("");
	}
	
	function downloadCSVDetail()
	{
		var url = '<?= Router::url(['action' => 'csv']) ?>/' + $('#MembersEventEventId').val() + '/' + $('#MembersEventStatus').val() + '/' + $('#MembersEventUsername').val();
		$("#RecordCmd").val("csv_detail");
		$("#RecordAdminIndexForm").submit();
		$("#RecordCmd").val("");
	}
</script>
<?php $this->end(); ?>
<div class="admin-records-index">
	<div class="ib-page-title"><?= __('Lista de historial de estudio'); ?></div>
	<div class="ib-horizontal">
	<?php
		echo $this->Form->create('Record');
		echo '<div class="ib-search-buttons">';
		echo $this->Form->submit(__('Buscar'),	['class' => 'btn btn-info', 'div' => false]);
		echo $this->Form->hidden('cmd');
		echo '<button type="button" class="btn btn-default" onclick="downloadCSV()">'.__('Exportar CSV').'</button>';
		echo '<button type="button" class="btn btn-default" onclick="downloadCSVDetail()">'.__('Exportar CSV (detallado)').'</button>';
		echo '</div>';
		
		echo '<div class="ib-row">';
		echo $this->Form->searchField('course_id',			['label' => __('Curso'), 'options' => $courses, 'empty' => '全て']);
		echo $this->Form->searchField('content_category',	['label' => __('Tipo de contenido'), 'options' => Configure::read('content_category'), 'empty' => '全て', 'selected' => $content_category]);
		echo $this->Form->searchField('content_title',		['label' => __('Nombre del contenido')]);
		echo '</div>';
		
		echo '<div class="ib-row">';
		echo $this->Form->searchField('group_id',	['label' => __('Grupo'), 'options' => $groups, 'empty' => '全て', 'selected' => $group_id]);
		echo $this->Form->searchField('username',	['label' => __('ID de inicio de sesión')]);
		echo $this->Form->searchField('name',		['label' => __('Nombre completo')]);
		echo '</div>';
		
		echo '<div class="ib-search-date-container">';
		echo $this->Form->searchDate('from_date', ['label'=> __('Fecha y hora objetivo'), 'value' => $from_date]);
		echo $this->Form->searchDate('to_date',   ['label'=> __('a'), 'value' => $to_date]);
		echo '</div>';
		echo $this->Form->end();
	?>
	</div>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
		<th nowrap><?= $this->Paginator->sort('User.username', __('ID de inicio de sesión')); ?></th>
		<th nowrap><?= $this->Paginator->sort('User.name', __('Nombre completo')); ?></th>
		<th nowrap><?= $this->Paginator->sort('course_id', __('Curso')); ?></th>
		<th nowrap><?= $this->Paginator->sort('content_id', __('Contenido')); ?></th>
		<th nowrap class="ib-col-center"><?= $this->Paginator->sort('score', __('Puntuación')); ?></th>
		<th class="ib-col-center" nowrap><?= $this->Paginator->sort('pass_score', __('Puntuación de aprobación')); ?></th>
		<th nowrap class="ib-col-center"><?= $this->Paginator->sort('is_passed', __('Resultado')); ?></th>
		<th class="ib-col-center" nowrap><?= $this->Paginator->sort('understanding', __('Nivel de comprensión')); ?></th>
		<th class="ib-col-center"><?= $this->Paginator->sort('study_sec', __('Tiempo de estudio')); ?></th>
		<th class="ib-col-datetime"><?= $this->Paginator->sort('created', __('Fecha y hora de estudio')); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($records as $record): ?>
	<tr>
		<td><?= h($record['User']['username']); ?>&nbsp;</td>
		<td><?= h($record['User']['name']); ?>&nbsp;</td>
		<td><a href="javascript:openRecord(<?= h($record['Course']['id']); ?>, <?= h($record['User']['id']); ?>);"><?= h($record['Course']['title']); ?></a></td>
		<td><?= h($record['Content']['title']); ?>&nbsp;</td>
		<td class="ib-col-center"><?= h($record['Record']['score']); ?>&nbsp;</td>
		<td class="ib-col-center"><?= h($record['Record']['pass_score']); ?>&nbsp;</td>
		<?php if ($record['Content']['kind'] == 'enquete') {?>
		<td class="ib-col-center"><a href="javascript:openRecordEnquete(<?= h($record['Content']['id']); ?>, <?= h($record['Record']['id']); ?>);">回答</a></td>
		<?php } else {?>
		<td nowrap class="ib-col-center"><a href="javascript:openTestRecord(<?= h($record['Content']['id']); ?>, <?= h($record['Record']['id']); ?>);"><?= Configure::read('record_result.'.$record['Record']['is_passed']); ?></a></td>
		<?php }?>
		<td nowrap class="ib-col-center"><?= h(Configure::read('record_understanding.'.$record['Record']['understanding'])); ?>&nbsp;</td>
		<td class="ib-col-center"><?= h(Utils::getHNSBySec($record['Record']['study_sec'])); ?>&nbsp;</td>
		<td class="ib-col-date"><?= h(Utils::getYMDHN($record['Record']['created'])); ?>&nbsp;</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<?= $this->element('paging');?>
</div>
