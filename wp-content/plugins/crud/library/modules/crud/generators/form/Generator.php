<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace crud\modules\crud\generators\form;

use Yii;
use yii\base\Model;
use crud\modules\crud\CodeFile;
use crud\modules\crud\Generator as BaseGenerator;

/**
 * This generator will generate an action view file based on the specified model class.
 *
 * @property-read array $modelAttributes List of safe attributes of [[modelClass]].
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends BaseGenerator
{
    public $modelClass;
    public $viewPath = '@app/views';
    public $viewName;
    public $scenarioName;
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return Yii::t('console','Form Generator');
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return Yii::t('console','This generator generates a view script file that displays a form to collect input for the specified model class.');
    }

    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        $files = [];
        $files[] = new CodeFile(
            Yii::getAlias($this->viewPath) . '/' . $this->viewName . '.php',
            $this->render('form.php')
        );

        return $files;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['modelClass', 'viewName', 'scenarioName', 'viewPath'], 'filter', 'filter' => 'trim'],
            [['modelClass', 'viewName', 'viewPath'], 'required'],
            [['modelClass'], 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => Yii::t('console','Only word characters and backslashes are allowed.')],
            [['modelClass'], 'validateClass', 'params' => ['extends' => Model::className()]],
            [['viewName'], 'match', 'pattern' => '/^\w+[\\-\\/\w]*$/', 'message' => Yii::t('console','Only word characters, dashes and slashes are allowed.')],
            [['viewPath'], 'match', 'pattern' => '/^@?\w+[\\-\\/\w]*$/', 'message' => Yii::t('console','Only word characters, dashes, slashes and @ are allowed.')],
            [['viewPath'], 'validateViewPath'],
            [['scenarioName'], 'match', 'pattern' => '/^[\w\\-]+$/', 'message' => Yii::t('console','Only word characters and dashes are allowed.')],
            [['enableI18N'], 'boolean'],
            [['messageCategory'], 'validateMessageCategory', 'skipOnEmpty' => false],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'modelClass' => Yii::t('console','Model Class'),
            'viewName' =>Yii::t('console', 'View Name'),
            'viewPath' => Yii::t('console','View Path'),
            'scenarioName' => Yii::t('console','Scenario'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function requiredTemplates()
    {
        return ['form.php', 'action.php'];
    }

    /**
     * {@inheritdoc}
     */
    public function stickyAttributes()
    {
        return array_merge(parent::stickyAttributes(), ['viewPath', 'scenarioName']);
    }

    /**
     * {@inheritdoc}
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'modelClass' => Yii::t('console','This is the model class for collecting the form input. You should provide a fully qualified class name, e.g., <code>app\models\Post</code>.'),
            'viewName' =>Yii::t('console', 'This is the view name with respect to the view path. For example, <code>site/index</code> would generate a <code>site/index.php</code> view file under the view path.'),
            'viewPath' =>Yii::t('console', 'This is the root view path to keep the generated view files. You may provide either a directory or a path alias, e.g., <code>@app/views</code>.'),
            'scenarioName' =>Yii::t('console', 'This is the scenario to be used by the model when collecting the form input. If empty, the default scenario will be used.'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function successMessage()
    {
        $code = highlight_string($this->render('action.php'), true);

        return <<<EOD
<p>The form has been generated successfully.</p>
<p>You may add the following code in an appropriate controller class to invoke the view:</p>
<pre>$code</pre>
EOD;
    }

    /**
     * Validates [[viewPath]] to make sure it is a valid path or path alias and exists.
     */
    public function validateViewPath()
    {
        $path = Yii::getAlias($this->viewPath, false);
        if ($path === false || !is_dir($path)) {
            $this->addError('viewPath', Yii::t('console','View path does not exist.'));
        }
    }

    /**
     * @return array list of safe attributes of [[modelClass]]
     */
    public function getModelAttributes()
    {
        /* @var $model Model */
        $model = new $this->modelClass();
        if (!empty($this->scenarioName)) {
            $model->setScenario($this->scenarioName);
        }

        return $model->safeAttributes();
    }
}
