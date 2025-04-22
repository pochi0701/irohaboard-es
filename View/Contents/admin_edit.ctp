<?= $this->element('admin_menu');?>
<?php $this->start('css-embedded'); ?>
<?= $this->Html->css('summernote.css');?>
<?php $this->end(); ?>
<?php $this->start('script-embedded'); ?>
<?= $this->Html->script('summernote.min.js');?>
<?= $this->Html->script('lang/summernote-ja-JP.js');?>
<script>
	$(document).ready(function()
	{
		// アップロードボタンを追加
		$('.form-control-upload').after('<input id="btnUpload" type="button" value="ファイルを指定">');

		// アップロードボタンクリック時の処理
		$("#btnUpload").click(function() {
			var content_kind = $('input[name="data[Content][kind]"]:checked').val();
			
			if(!content_kind)
				return false;
			
			// 動画以外の場合にはアップロードの種別を一律ファイルに変更
			if(content_kind != 'movie')
				content_kind = 'file';
			
			// アップロード画面を表示
			$('#uploadDialog').modal('show');

			// アップロード用のページを指定
			$('#uploadFrame').attr('src', '<?= Router::url(['controller' => 'contents', 'action' => 'upload'])?>/' + content_kind);
			return false;
		});

		// コンテンツ種別の変更時の処理
		$('input[name="data[Content][kind]"]:radio').change( function() {
			render();
		});

		// 保存時、コード表示モードの場合、解除する（編集中の内容を反映するため）
		$('form').submit( function() {
			var content_kind = $('input[name="data[Content][kind]"]:checked').val();
			
			if(content_kind == 'html')
			{
				if ($('#ContentBody').summernote('codeview.isActivated'))
				{
					$('#ContentBody').summernote('codeview.deactivate')
				}
			}
		});

		// 初期表示
		render();
	});
	
	// コンテンツ種別によって画面の表示要素を制御
	function render()
	{
		var content_kind = $('input[name="data[Content][kind]"]:checked').val();
		
		$('.kind').hide();
		$('.kind-' + content_kind).show(); // コンテンツ種別に紐づく項目のみを表示
		$('#btnPreview').hide();
		
		switch(content_kind)
		{
			case 'text': // テキスト
				$('#ContentBody').summernote('destroy');
				// テキストが存在しない場合、空文字にする。
				if($('<span>').html($('#ContentBody').val()).text() == '')
					$('#ContentBody').val('');
				$('#btnPreview').show();
				break;
			case 'html': // リッチテキスト
				// リッチテキストエディタを起動
				CommonUtil.setRichTextEditor('#ContentBody', <?= Configure::read('upload_image_maxsize') ?>, '<?= $this->webroot ?>');
				$('#btnPreview').show();
				break;
			case 'movie': // 動画
				$('.form-control-upload').css('width', '80%');
				$('#btnUpload').show();
				$('#btnPreview').show();
				break;
			case 'url': // URL
				$('.form-control-upload').css('width', '100%');
				$('#btnUpload').hide();
				$('#btnPreview').show();
				break;
			case 'file': // 配布資料
				$('.form-control-upload').css('width', '80%');
				$('#btnUpload').show();
				break;
			case 'test': // テスト
				break;
		}
	}
	
	// コンテンツのプレビュー
	function preview()
	{
		var content_kind = $('input[name="data[Content][kind]"]:checked').val();
		var content_key  = $('input[name="data[_Token][key]"]').val();
		
		// プレビュー内容を保存
		$.ajax({
			url  : '<?= Router::url(['action' => 'preview']) ?>',
			type : 'POST',
			data : {
				content_title : $('#ContentTitle').val(),
				content_kind  : $('input[name="data[Content][kind]"]:checked').val(),
				content_url   : $('#ContentUrl').val(),
				content_body  : $('#ContentBody').val(),
				_Token        : { key : content_key },
			},
			dataType: 'text',
			success : function(response) {
				//通信成功時の処理
				var url = '<?= Router::url(['controller' => 'contents', 'action' => 'preview', 'admin' => false])?>';
				
				window.open(url, '_preview', 'width=1200, height=700, resizable=yes');
			},
			error: function() {
				//通信失敗時の処理
				//alert('通信失敗');
			}
		});
	}
	
	// アップロードされたファイルのURLを設定
	function setURL(url, file_name)
	{
		$('.form-control-upload').val(url);
		
		if(file_name)
			$('.form-control-filename').val(file_name);

		$('#uploadDialog').modal('hide');
	}
	
	// アップロード画面を非表示にする
	function closeDialog()
	{
		$('#uploadDialog').modal('hide');
	}
</script>
<?php $this->end(); ?>

<div class="admin-contents-edit">
	<?php
		$this->Html->addCrumb(__('コース一覧'), ['controller' => 'courses', 'action' => 'index']);
		$this->Html->addCrumb($course['Course']['title'],  ['controller' => 'contents', 'action' => 'index', $course['Course']['id']]);

		echo $this->Html->getCrumbs(' / ');
	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?= $this->isEditPage() ? __('Editar') :  __('Nuevo contenido'); ?>
		</div>
		<div class="panel-body">
		<?php
			echo $this->Form->create('Content', Configure::read('form_defaults'));
			echo $this->Form->input('id');
			echo $this->Form->input('title', ['label' => __('Título')]);
			echo $this->Form->inputRadio('kind', ['label' => __('Tipo de contenido'), 'separator'=>"<br>", 'options' => Configure::read('content_kind_comment')]);

			// URL
			echo '<div class="kind kind-movie kind-url kind-file">';
			echo $this->Form->input('url', ['label' => __('URL'), 'class' => 'form-control form-control-upload']);
			echo '</div>';
			
			// 配布資料
			echo '<div class="kind kind-file">';
			echo $this->Form->input('file_name', ['label' => __('Nombre del archivo'), 'class' => 'form-control-filename', 'readonly' => 'readonly']);
			echo '</div>';

			// リッチテキスト
			echo '<div class="kind kind-text kind-html">';
			echo $this->Form->input('body',		['label' => __('Contenido')]);
			echo '</div>';

			// テスト用設定 start
			echo '<span class="kind kind-test">';
			echo $this->Form->inputExp('timelimit', ['label' => __('Tiempo límite (1-100 minutos)')], __('Si se especifica, se calificará automáticamente después de que se haya agotado el tiempo.'));
			echo $this->Form->inputExp('pass_rate', ['label' => __('Porcentaje de puntuación para aprobar (1-100%)')], __('Si se especifica, se determinará si se aprueba o no, y si no se especifica, se aprueba automáticamente.'));
			
			// ランダム出題用
			echo $this->Form->inputExp('question_count', ['label' => __('Cantidad de preguntas (1-100)')], __('Si se especifica, se seleccionará aleatoriamente entre las preguntas registradas, y si no se especifica, se presentarán todas las preguntas en el orden de la lista de la pantalla de preguntas.'));
			
			// 問題が不正解時の表示
			echo $this->Form->inputRadio('wrong_mode', ['label' => __('Mostrar cuando la respuesta es incorrecta'), 'options' => Configure::read('wrong_mode'), 'default' => 2],
				__('Especifique cómo se muestra la pregunta incorrecta en la pantalla de resultados del examen. Solo se muestra la explicación correcta cuando la respuesta es correcta.'));
			
			echo '</span>';
			// テスト用設定 end

			// ステータス
			echo $this->Form->inputRadio('status', ['label' => __('Estado'), 'options' => Configure::read('content_status'), 'default' => 1],
				__('[No publicado] Si se establece, solo se mostrará para los usuarios que inicien sesión con permisos de administrador.'));

			// コンテンツ移動用（編集の場合のみ）
			if($this->isEditPage())
			{
				echo $this->Form->inputExp('course_id', ['label' => __('Curso asociado'), 'value' => $course['Course']['id']],
					__('Cambiarlo permitirá mover el contenido a otro curso.'));
			}

			// 備考
			echo '<span class="kind kind-text kind-html kind-movie kind-url kind-file kind-test">';
			echo $this->Form->input('comment', ['label' => __('Observaciones')]);
			echo '</span>';
			
			// 保存ボタン
			echo Configure::read('form_submit_before')
				.'<button id="btnPreview" class="btn btn-default" onclick="preview(); return false;">Vista previa</button> '
				.$this->Form->submit(__('Guardar'), Configure::read('form_submit_defaults'))
				.Configure::read('form_submit_after');
			echo $this->Form->end();
		?>
		</div>
	</div>
</div>

<!--ファイルアップロードダイアログ-->
<div class="modal fade" id="uploadDialog">
	<div class="modal-dialog">
		<div class="modal-content" style="width:660px;">
			<div class="modal-body">
				<iframe id="uploadFrame" width="100%" style="height: 440px;" scrolling="no" frameborder="no"></iframe>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
