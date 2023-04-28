<?php
/** @var $this yii\web\View */
use yii\helpers\Html;
use crud\assets\AceAsset;

AceAsset::register($this);
$text =<<<TEXT
#!/bin/bash

# +----------------------------------------------------------------------
# ｜ubuntu 18.04 LAMP 环境搭建
# +----------------------------------------------------------------------
# win: "Ctrl+q", mac: "Ctrl+q" 设置样式

sudo apt-get install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install php7.4 -y
sudo apt-get install apache2 -y
sudo apt install mysql-server-5.7 -y
sudo apt-get install libapache2-mod-php7.4 -y
sudo apt-get install php7.4-fpm php7.4-mysql php7.4-gd php7.4-mbstring php7.4-bcmath -y
sudo apt-get install php7.4-xml php7.4-curl php7.4-redis php7.4-opcache php7.4-odbc  -y
sudo apt-get install zip php7.4-mysql php7.4-zip -y
sudo a2enmod rewrite

sudo mysql_secure_installation
CREATE USER \'wordpress\'@\'localhost\' IDENTIFIED BY \'****\';
GRANT ALL PRIVILEGES ON *.* TO \'wordpress\'@\'localhost\';
FLUSH PRIVILEGES;
TEXT;
?>
<div class="warp">
    <div class="nav">asdas</div>
    <?= Html::beginTag("pre",['id'=>'editor']).Html::endTag("pre") ?>
</div>
<?php


$css= <<<CSS
    body {
        /*overflow: hidden;*/
        width: 100%;height: 100%;
        margin: 0 0;
        padding: 0 0;
   
    }
    .warp{
        position: absolute;
        width: 100%;height: 100%;
        margin: 0 0;
        padding: 0 0;
    }
    .nav{
        height: 50px;
        padding: 0 30px;line-height: 50px;
        font-size: 18px;
        color: #d3d9df;
        background-color: #0082c9;
        background-image: linear-gradient(40deg, #0082c9 0%, #30b6ff 100%);
    }
    #editor { 
        margin: 0;
        position: absolute;
        top: 50px;
        bottom: 0;
        left: 0;
        right: 0;
    }
CSS;
$this->registerCss($css);

$js=<<<JS
    var editor = ace.edit("editor");
    ace.require('ace/ext/settings_menu').init(editor);
    editor.setTheme('ace/theme/ace/theme/eclipse');
    editor.session.setMode('ace/mode/sh');
    editor.setFontSize(18);
    editor.setFadeFoldWidgets(true);
    editor.setValue(`{$text}`);
	editor.commands.addCommands([{
		name: "showSettingsMenu",
		bindKey: {win: "Ctrl-q", mac: "Ctrl-q"},
		exec: function(editor) {
			editor.showSettingsMenu();
		},
		readOnly: true
	}]);
window.onload =function () {
    editor.resize();
}
JS;
$this->registerJs($js);

