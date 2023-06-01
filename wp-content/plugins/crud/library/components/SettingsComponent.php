<?php

namespace crud\components;

use Yii;
use yii\base\Component;
use crud\models\Settings;
class SettingsComponent extends Component
{

    /**
     * 注册设置
     *
     * @param string $moduleId
     */
    public function registerSettings($moduleId = '')
    {
        if (empty($moduleId)) {
            $settings = Yii::$app->params["settings"];
        } else {
            $module = Yii::$app->getModule($moduleId);
            $settings = $module->params["settings"];
        }
        foreach ($settings as $setting) {
            $option = new Settings($setting);
            $option->registerSettings();
        }
    }

}