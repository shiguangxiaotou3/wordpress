<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace crud\modules\crud\console;

use Yii;
use yii\helpers\Console;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class GenerateAction extends \yii\base\Action
{
    /**
     * @var \yii\gii\Generator
     */
    public $generator;
    /**
     * @var GenerateController
     */
    public $controller;
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        echo "Running '{$this->generator->getName()}'...\n\n";

        if ($this->generator->validate()) {
            $this->generateCode();
        } else {
            $this->displayValidationErrors();
        }
    }

    protected function displayValidationErrors()
    {
        $this->controller->stdout( Yii::t('console',"Code not generated. Please fix the following errors:").PHP_EOL.PHP_EOL, Console::FG_RED);
        foreach ($this->generator->errors as $attribute => $errors) {
            echo ' - ' . $this->controller->ansiFormat($attribute, Console::FG_CYAN) . ': ' . implode('; ', $errors) . "\n";
        }
        echo "\n";
    }

    protected function generateCode()
    {
        $files = $this->generator->generate();
        $n = count($files);
        if ($n === 0) {
            echo Yii::t('console',"No code to be generated.\n");
            return;
        }
        echo Yii::t('console',"The following files will be generated:")."\n";
        $skipAll = $this->controller->interactive ? null : !$this->controller->overwrite;
        $answers = [];
        foreach ($files as $file) {
            $path = $file->getRelativePath();
            if (is_file($file->path)) {
                $existingFileContents = file_get_contents($file->path);
                if ($existingFileContents === $file->content) {
                    echo '  ' . $this->controller->ansiFormat(Yii::t('console','[unchanged]'), Console::FG_GREY);
                    echo $this->controller->ansiFormat(" $path\n", Console::FG_CYAN);
                    $answers[$file->id] = false;
                } else {
                    echo '    ' . $this->controller->ansiFormat(Yii::t('console','[changed]'), Console::FG_RED);
                    echo $this->controller->ansiFormat(" $path\n", Console::FG_CYAN);
                    if ($skipAll !== null) {
                        $answers[$file->id] = !$skipAll;
                    } else {
                        do {
                            $answer = $this->controller->select(Yii::t('console',"Do you want to overwrite this file?"), [
                                'y' => Yii::t('console','Overwrite this file.'),
                                'n' => Yii::t('console','Skip this file.'),
                                'ya' => Yii::t('console','Overwrite this and the rest of the changed files.'),
                                'na' => Yii::t('console','Skip this and the rest of the changed files.'),
                                'v' => Yii::t('console','View difference'),
                            ]);

                            if ($answer === 'v') {
                                $diff = new \Diff(explode("\n", $existingFileContents), explode("\n", $file->content));
                                echo $diff->render(new \Diff_Renderer_Text_Unified());
                            }
                        } while ($answer === 'v');

                        $answers[$file->id] = $answer === 'y' || $answer === 'ya';
                        if ($answer === 'ya') {
                            $skipAll = false;
                        } elseif ($answer === 'na') {
                            $skipAll = true;
                        }
                    }
                }
            } else {
                echo '        ' . $this->controller->ansiFormat(Yii::t('console','[new]'), Console::FG_GREEN);
                echo $this->controller->ansiFormat(" $path\n", Console::FG_CYAN);
                $answers[$file->id] = true;
            }
        }

        if (!array_sum($answers)) {
            $this->controller->stdout(PHP_EOL.Yii::t('console',"No files were chosen to be generated.").PHP_EOL, Console::FG_CYAN);
            return;
        }

        if (!$this->controller->confirm("\n".Yii::t('console',"Ready to generate the selected files?"), true)) {
            $this->controller->stdout(PHP_EOL.Yii::t('console',"No file was generated.").PHP_EOL, Console::FG_CYAN);
            return;
        }
        if ($this->generator->save($files, (array) $answers, $results)) {
            $this->controller->stdout(Yii::t('console',"Files were generated successfully!").PHP_EOL, Console::FG_GREEN);
        } else {
            $this->controller->stdout(PHP_EOL.Yii::t('console',"Some errors occurred while generating the files.").PHP_EOL, Console::FG_RED);
        }
        echo preg_replace('%<span class="error">(.*?)</span>%', '\1', $results) . "\n";
    }
}
