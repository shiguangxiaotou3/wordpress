<?php


namespace crud\widgets;

use yii\base\Widget;
use yii\helpers\Html;


/**
 * 打印表格
 * @package crud\widgets
 */
class WpTableWidget extends Widget
{

    public $tableOptions =["class"=>"wp-list-table widefat fixed striped table-view-list"];
    public $columnClass ="manage-column";
    public $columns=[];
    public $data =[];

    /**
     * @return string
     */
    public function run(){
        $th=[];
        foreach ($this->columns as $column ){
            if(!isset( $column["options"]['class']) ){
                $column['options']['class']= $this->columnClass;
            }
            if (!isset( $column["options"]['id'])){
                $column['options']['id']= $column["field"];
            }
            $column['options']["scope"]="col";
            $title = !isset($column['title']) ? ucwords($column['field']) :$column['title'];
            $th[] = Html::beginTag("td",$column['options'])."<span>$title</span>".Html::endTag("td");
        }
        $th_str = join("",$th);
        $thead =<<<HTML
<thead>
	<tr>
        <td id="cb" class="manage-column column-cb check-column">
		    <label class="screen-reader-text" for="cb-select-all-1">全选</label>
		    <input id="cb-select-all-1" type="checkbox">
        </td>
       {$th_str}
    </tr>
</thead>
HTML;
        $foot =<<<HTML
<tfoot>
    <tr>
         <td id="cb" class="manage-column column-cb check-column">
            <label class="screen-reader-text" for="cb-select-all-1">全选</label>
            <input id="cb-select-all-1" type="checkbox">
        </td>
        {$th_str}
    </tr>
</tfoot>
HTML;
        return Html::beginTag('table',$this->tableOptions).
                $thead. $this->item() .$foot
            .Html::endTag("table");
    }

    /**
     * @return string
     */
    public function item(){
        $row =[];
        $i=1;
        foreach ($this->data as $item){
            $td=[];
            $td[] =<<<HTML
<th scope="row" class="check-column">			
    <label class="screen-reader-text" for="cb-select-{$i}">选择</label>
        <input id="cb-select-{$i}" type="checkbox" name="post[]" value="1">
        <div class="locked-indicator">
            <span class="locked-indicator-icon" aria-hidden="true"></span>
       </div>
</th>
HTML;
            foreach ($this->columns as $column){
                $options=[
                    "class"=>$column['field']." column-". $column['field'],
                    "data-colname"=>$column['title'],
                ];
                $value = $this->getValue($item,$column);


                $td[] =Html::beginTag("td",$options).  $value.Html::endTag("td");
            }
            $row []= "<tr id='post-{$i}'>".join("",$td)."</tr>";
            $i++;
        }
        $rows=join("",$row);
        return <<<HTML
    <tbody id="the-list">
        {$rows}
    </tbody>
HTML;
    }


    /**
     * @param $row
     * @param $field
     * @return mixed
     */
    public function getValue($row,$field){
        if(isset($field["callback"])){
            return $this->toString( $field["callback"]($row));
        }
        if(isset($row[$field["field"]])){
            return $this->toString($row[$field["field"]]);
        }else{
            return '';
        }
    }


    /**
     * @param $value
     * @return false|string
     */
    public function toString($value){
       if(is_array($value)){
           return $this->getArrayString($value);
       }elseif (is_object($value)){
           return $this->getObjectString($value);
       }else{
           return  $value;
       }

    }

    /**
     * @param $object
     * @return false|string
     */
    protected function getObjectString($object){
        return get_class($object);
    }

    /**
     * @param $array
     * @return string
     */
    protected function getArrayString($array){
        return "array";
    }
}