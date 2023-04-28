<?php
/**
 * This is the template for generating a controller class file.
 */
/** @var yii\web\View $this */
/** @var yii\gii\generators\controller\Generator $generator */

echo "<?php\n";
?>

namespace <?= $generator->getControllerNamespace() ?>;

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
class <?= StringHelper::basename($generator->controllerClass) ?> extends <?= '\\' . trim($generator->baseClass, '\\') . "\n" ?>
{
<?php foreach ($generator->getActionIDs() as $action): ?>
    public function action<?= Inflector::id2camel($action) ?>()
    {
        return $this->render('<?= $action ?>');
    }

<?php endforeach; ?>
}
