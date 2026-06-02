<?php
/**
 * iroha Board Project
 *
 * @author        Kotaro Miura
 * @copyright     2015-2021 iroha Soft, Inc. (https://irohasoft.jp)
 * @link          https://irohaboard.irohasoft.jp
 * @license       https://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */
?>
<!DOCTYPE html>
<html lang="<?= h(isset($currentHtmlLang) ? $currentHtmlLang : 'es-PY'); ?>">
<head>
	<?= $this->Html->charset(); ?>
	
	<title><?= h($this->readSession('Setting.title')); ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<?php
		// 管理画面か確認、ただしログイン画面は例外とする
		$is_admin_page = $this->isAdminPage() && !$this->isLoginPage();
		
		// 受講者向け画面及び、管理システムのログイン画面のみ viewport を設定（スマートフォン対応）
		if(!$is_admin_page)
			echo '<meta name="viewport" content="width=device-width,initial-scale=1">';
		
		echo $this->Html->meta('icon');

		// CSSの読み込み
		echo $this->Html->css('jquery-ui');
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('common.css?20210701');
		
		// 管理画面用CSS
		if($is_admin_page)
			echo $this->Html->css('admin.css?20200701');

		// カスタマイズ用CSS
		echo $this->Html->css('custom.css?20200701');
		
		// スクリプトの読み込み
		$jsMessagesJson = json_encode(isset($jsMessages) ? $jsMessages : [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		$currentUiLanguageJson = json_encode(isset($currentUiLanguage) ? $currentUiLanguage : 'spa', JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		$currentEditorLangJson = json_encode(isset($currentEditorLang) ? $currentEditorLang : 'en-US', JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		echo '<script>window.IB_LANG = '.$currentUiLanguageJson.'; window.IB_EDITOR_LANG = '.$currentEditorLangJson.'; window.IB_MESSAGES = '.$jsMessagesJson.';</script>';
		echo $this->Html->script('jquery-1.9.1.min.js');
		echo $this->Html->script('jquery-ui-1.9.2.min.js');
		echo $this->Html->script('bootstrap.min.js');
		echo $this->Html->script('common.js?20220401');
		
		// 管理画面用スクリプト
		if($is_admin_page)
			echo $this->Html->script('admin.js?20200701');
		
		// デモモード用スクリプト
		if(Configure::read('demo_mode'))
			echo $this->Html->script('demo.js');
		
		// カスタマイズ用スクリプト
		echo $this->Html->script('custom.js?20200701');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->fetch('css-embedded');
		echo $this->fetch('script-embedded');
	?>
	<style>
		.ib-theme-color
		{
			background-color	: <?= h($this->readSession('Setting.color')); ?>;
			color				: white;
		}
		
		.ib-logo a
		{
			color				: white;
			text-decoration		: none;
		}

		.ib-lang-switcher
		{
			float: right;
			padding: 10px 15px 0 0;
		}

		.ib-lang-switcher a,
		.ib-lang-switcher span
		{
			color: white;
			margin-left: 8px;
			text-decoration: none;
		}

		.ib-lang-switcher .active
		{
			font-weight: bold;
			text-decoration: underline;
		}
	</style>
</head>
<body>
	<header class="header ib-theme-color">
		<div class="ib-logo ib-left">
			<a href="<?= $this->Html->url('/')?>"><?= h($this->readSession('Setting.title')); ?></a>
		</div>
		<?php if(!empty($availableUiLanguages)) {?>
		<div class="ib-lang-switcher">
			<?php foreach($availableUiLanguages as $language) {?>
				<?php if($language['active']) {?>
					<span class="active"><?= h($language['label']); ?></span>
				<?php } else {?>
					<a href="<?= h($language['url']); ?>"><?= h($language['label']); ?></a>
				<?php }?>
			<?php }?>
		</div>
		<?php }?>
		<?php if(isset($loginedUser)) {?>
		<nav class="ib-navi">
			<div class="ib-navi-item ib-right ib-navi-logout">
				<span class="glyphicon glyphicon-log-out"></span>
				<?= $this->Html->link(__('ログアウト'), ['controller' => 'users', 'action' => 'logout']); ?>
			</div>
			<div class="ib-navi-sepa ib-right ib-navi-sepa-1"></div>
			<div class="ib-navi-item ib-right ib-navi-setting">
				<span class="glyphicon glyphicon-cog"></span>
				<?= $this->Html->link(__('設定'), ['controller' => 'users', 'action' => 'setting']); ?>
			</div>
			<div class="ib-navi-sepa ib-right ib-navi-sepa-2"></div>
			<div class="ib-navi-item ib-right ib-navi-welcome"><?= sprintf(__('ようこそ %s さん'), h($loginedUser['name'])); ?></div>
		</nav>
		<?php }?>
	</header>
	
	<main id="container">
		<div id="content" class="row">
			<?= $this->Session->flash(); ?>
			<?= $this->fetch('content'); ?>
		</div>
	</main>
	
	<footer class="footer ib-theme-color text-center">
		<?= h($this->readSession('Setting.copyright')); ?>
	</footer>
	
	<?php if(isset($loginedUser) && $this->isAdminPage()) {?>
	<div class="irohasoft">
		Powered by <a href="https://irohaboard.irohasoft.jp/"><?= APP_NAME; ?></a>
	</div>
	<?php }?>
	
	<?= $this->element('sql_dump'); ?>
</body>
</html>
