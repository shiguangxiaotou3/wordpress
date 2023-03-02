<?php
namespace crud\library\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use yii\console\controllers\HelpController as defaultController;

class HelpController extends defaultController
{
    /**
     * Displays all available commands.
     */
    protected function getDefaultHelp()
    {

        $commands = $this->getCommandDescriptions();
        $this->stdout($this->getDefaultHelpHeader());
        if (empty($commands)) {
            $this->stdout("\n". Yii::t("console","No commands are found.")."\n\n", Console::BOLD);
            return;
        }

        $this->stdout("\n". Yii::t("console","The following commands are available:")."\n\n", Console::BOLD);
        $maxLength = 0;
        foreach ($commands as $command => $description) {
            $result = Yii::$app->createController($command);
            /** @var $controller Controller */
            list($controller, $actionID) = $result;
            $actions = $this->getActions($controller);
            $prefix = $controller->getUniqueId();
            foreach ($actions as $action) {
                $string = $prefix . '/' . $action;
                if ($action === $controller->defaultAction) {
                    $string .= ' (default)';
                }
                $maxLength = max($maxLength, strlen($string));
            }
        }
        foreach ($commands as $command => $description) {
            $result = Yii::$app->createController($command);
            list($controller, $actionID) = $result;
            $actions = $this->getActions($controller);

            $this->stdout('- ' . $this->ansiFormat($command, Console::FG_YELLOW));
            $this->stdout(str_repeat(' ', $maxLength + 4 - strlen($command)));
            $this->stdout(Console::wrapText( Yii::t("console",$description), $maxLength + 4 + 2), Console::BOLD);
            $this->stdout("\n");
            $prefix = $controller->getUniqueId();
            foreach ($actions as $action) {
                $string = '  ' . $prefix . '/' . $action;
                $this->stdout('  ' . $this->ansiFormat($string, Console::FG_GREEN));
                if ($action === $controller->defaultAction) {
                    $string .= ' (default)';
                    $this->stdout(Yii::t("console",' (default)'), Console::FG_YELLOW);
                }
                $summary = $controller->getActionHelpSummary($controller->createAction($action));
                if ($summary !== '') {
                    $this->stdout(str_repeat(' ', $maxLength + 4 - strlen($string)));
                    $this->stdout(Console::wrapText(Yii::t("console",$summary), $maxLength + 4 + 2));
                }
                $this->stdout("\n");
            }
            $this->stdout("\n");
        }
        $scriptName = $this->getScriptName();
        $this->stdout("\n".Yii::t("console","To see the help of each command, enter:")."\n", Console::BOLD);
        $this->stdout("\n  $scriptName " . $this->ansiFormat('help', Console::FG_YELLOW) . ' '
            . $this->ansiFormat('<command-name>', Console::FG_CYAN) . "\n\n");
    }
}