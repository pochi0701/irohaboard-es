<?= $this->element('admin_menu');?>
<?= $this->Html->css('summernote.css');?>
<?php $this->start('script-embedded'); ?>
<?= $this->Html->script('summernote.min.js');?>
<?php if(isset($currentEditorLang) && $currentEditorLang === 'ja-JP') {?>
<?= $this->Html->script('lang/summernote-ja-JP.js');?>
<?php }?>
<script>
	$(document).ready(function()
	{
		init();
	});

	function add_option()
	{
		var messages = window.IB_MESSAGES || {};
		txt	= document.all("option");
		opt	= document.all("data[ContentsQuestion][option_list][]").options;
		
		if(txt.value == '')
		{
			alert(messages.enterOption || "Please enter an option");
			return false;
		}
		
		if(txt.value.length > 100)
		{
			alert(messages.optionTooLong || "Please enter an option within 100 characters");
			return false;
		}
		
		if(opt.length == 10)
		{
			alert(messages.tooManyOptions || "The number of options exceeds the maximum");
			return false;
		}
		
		opt[opt.length] = new Option( txt.value, txt.value )
		txt.value = "";
		update_options();

		return false;
	}

	function del_option()
	{
		var opt = document.all("data[ContentsQuestion][option_list][]").options;
		
		if( opt.selectedIndex > -1 )
		{
			opt[opt.selectedIndex] = null;
			update_options();
		}
	}

	function update_options()
	{
		var opt = document.all("data[ContentsQuestion][option_list][]").options;
		var txt = document.all("ContentsQuestionOptions");
		
		txt.value = "";
		
		for(var i=0; i<opt.length; i++)
		{
			if(txt.value == '')
			{
				txt.value = opt[i].value;
			}
			else
			{
				txt.value += "|" + opt[i].value;
			}
		}
		
	}

	function update_correct()
	{
		var opt = document.all("data[ContentsQuestion][option_list][]").options;
		
		if( opt.selectedIndex < 0 )
		{
			document.all("ContentsQuestionCorrect").value = "";
		}
		else
		{
			var corrects = new Array();
			
			for(var i=0; i<opt.length; i++)
			{
				if(opt[i].selected)
					corrects.push(i+1);
			}
			
			document.all("ContentsQuestionCorrect").value = corrects.join(',');
		}
	}

	function init()
	{
		// リッチテキストエディタを起動
		CommonUtil.setRichTextEditor('#ContentsQuestionBody', <?= Configure::read('upload_image_maxsize') ?>, '<?= $this->webroot ?>');
		CommonUtil.setRichTextEditor('#ContentsQuestionExplain', <?= Configure::read('upload_image_maxsize') ?>, '<?= $this->webroot ?>');
		
		// 保存時、コード表示モードの場合、解除する（編集中の内容を反映するため）
		$("form").submit( function() {
			if ($('#ContentsQuestionExplain').summernote('codeview.isActivated')) {
				$('#ContentsQuestionExplain').summernote('codeview.deactivate')
			}
			
			if($('#ContentsQuestionBody').val() == '')
			{
				alert((window.IB_MESSAGES || {}).questionRequired || 'The question text has not been entered');
				return false;
			}
			
			if($("#ContentsQuestionOptions").val() == '')
			{
				alert((window.IB_MESSAGES || {}).optionsRequired || 'No options have been added');
				return false;
			}
		});
		
		if($("#ContentsQuestionOptions").val() == '')
			return;
		
		var options = $("#ContentsQuestionOptions").val().split('|');
		
		for(var i=0; i<options.length; i++)
		{
			var isSelected = false;
			$option = $('<option>')
				.val(options[i])
				.text(options[i])
				.prop('selected', isSelected);
			
			$("#ContentsQuestionOptionList").append($option);
		}
		
		render();
	}
	
	function render()
	{
		if($('input[name="data[ContentsQuestion][question_type]"]:checked').val() == 'text')
		{
			$('#ContentsQuestionOptions').val('none');
			$('.row-options').hide();
		}
		else
		{
			if($('#ContentsQuestionOptions').val()=='none')
				$('#ContentsQuestionOptionList').children().remove();
			
			$('.row-options').show();
		}
	}
	
	function question_type_onchange()
	{
		update_options();
		render();
	}
</script>
<?php $this->end(); ?>
<div class="admin-contents-questions-edit">
	<div class="ib-breadcrumb">
	<?php 
		$this->Html->addCrumb(__('コース一覧'),  ['controller' => 'courses', 'action' => 'index']);
		$this->Html->addCrumb($content['Course']['title'],  ['controller' => 'contents', 'action' => 'index', $content['Course']['id']]);
		$this->Html->addCrumb($content['Content']['title'], ['controller' => 'enquetes_questions', 'action' => 'index', $content['Content']['id']]);
		
		echo $this->Html->getCrumbs(' / ');
	?>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?= $this->isEditPage() ? __('編集') :  __('新規質問'); ?>
		</div>
		<div class="panel-body">
			<?php
				echo $this->Form->create('ContentsQuestion', Configure::read('form_defaults'));;
				echo $this->Form->input('id');
				echo $this->Form->input('title',	['label' => __('タイトル')]);
				echo $this->Form->input('body',		['label' => __('質問文')]);
				echo $this->Form->inputRadio('question_type', ['label' => __('回答形式'), 'options' => Configure::read('question_type'), 'default' => 'single', 'onchange' => 'render()']);
			?>
			<div class="form-group row-options required">
				<label for="ContentsQuestionOptions" class="col col-sm-3 control-label"><?= __('選択肢／正解'); ?></label>
				<div class="col col-sm-9 required">
				<?= __('「＋」で選択肢の追加、「−」で選択された選択肢を削除します。（※最大10個まで）'); ?><br>
				<input type="text" size="20" name="option" style="width: 80%;display:inline-block;">
				<button class="btn" onclick="add_option();return false;">＋</button>
				<button class="btn" onclick="del_option();return false;">−</button><br>
			<?php
				echo $this->Form->input('option_list',	['label' => __('選択肢／正解'), 
					'type' => 'select',
					'label' => false,
					'multiple' => true,
					'size' => 5,
				]);
				echo $this->Form->hidden('options',		['label' => __('選択肢')]);
			?>
				</div>
			</div>
			<?php
				echo $this->Form->input('comment',	['label' => __('備考')]);
				echo Configure::read('form_submit_before')
					.$this->Form->submit(__('保存'), Configure::read('form_submit_defaults'))
					.Configure::read('form_submit_after');
				echo $this->Form->end();
			?>
		</div>
	</div>
</div>