<?php


namespace crud\components;

use yii\web\RequestParserInterface;
use yii\web\BadRequestHttpException;






/**
 * Class XmlRequestParser
 * @package crud\components
 */
class XmlRequestParser implements RequestParserInterface{

    public $asArray = true;
    public $throwException = true;
    public function parse($rawBody, $contentType){
        try {
            $parameters = simplexml_load_string($rawBody, 'SimpleXMLElement', LIBXML_NOCDATA);
            $parameters = $this->asArray ? (array) $parameters : $parameters;
            return $parameters === null ? [] : $parameters;
        } catch (InvalidParamException $e) {
            if ($this->throwException) {
                throw new BadRequestHttpException('Invalid XML data in request body: ' . $e->getMessage());
            }
            return [];
        }
    }
}