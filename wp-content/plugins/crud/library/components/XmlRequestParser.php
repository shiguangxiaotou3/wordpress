<?php
namespace crud\components;

use SimpleXMLElement;
use yii\web\RequestParserInterface;
use yii\web\BadRequestHttpException;
use yii\helpers\Xml;
/**
 * Class XmlRequestParser
 * @package crud\components
 */
class XmlRequestParser implements RequestParserInterface{

    public $asArray = true;
    public $throwException = true;
    public function parse($rawBody, $contentType){
        try {
            $parameters = simplexml_load_string($rawBody, 'SimpleXMLElement' ,
                LIBXML_NOCDATA);

            $parameters = $this->asArray ? (array) $parameters : $parameters;
            if($parameters == null ){
                return [];
            }else{
                return $parameters;
            }
        } catch (InvalidParamException $e) {
            if ($this->throwException) {
                throw new BadRequestHttpException('Invalid XML data in request body: ' . $e->getMessage());
            }
            return [];
        }
    }


    public static function xmlToArray($xml)
    {

        if ($xml instanceof SimpleXMLElement) {
            $result =[];
            $children = $xml->children();
            if (count($children) === 0) {
                $result[strval($xml->getName())] = strval($xml);
            } else {
                foreach ($children as $child) {
                    $childName = strval($child->getName());

                    if (!isset($result[$childName])) {
                        $result[$childName] = self::xmlToArray($child);
                    } else {
                        if (!is_array($result[$childName])) {
                            $result[$childName] = array($result[$childName]);
                        }

                        $result[$childName][] =self:: xmlToArray($child);
                    }
                }
            }
            return $result;
        }else{
            return $xml;
        }
    }

}