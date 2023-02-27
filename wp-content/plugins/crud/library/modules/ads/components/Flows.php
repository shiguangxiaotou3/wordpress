<?php
namespace crud\modules\ads\components;

use yii\base\Component;


/**
 * @property-read $_ch
 * @package crud\library\components
 */
class Flows extends Component{

    public $apiKey="";
    public $domain="";
    private $ch;
    /**
     * @link $_ch
     * @return \CurlHandle|false|resource
     */
    public function get_ch(){
        if(!isset($this->ch) and empty($this->ch)){
            $this->ch = curl_init();
        }
        return $this->ch;
    }

    /**
     * Get flows 获取流量s
     * @param integer $campaign_id
     * @return bool|string
     */
    public function getFlowsById(int $campaign_id){
        curl_setopt($this->_ch, CURLOPT_URL, $this->domain.'campaigns/'.$campaign_id.'/streams');
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array('Api-Key: '.$this->apiKey));
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        return json_decode( curl_exec($this->_ch) ,true);
    }

    /**
     * 获取可用的流量过滤器 Get available flow filters
     */
    public function get_available_flow_filters(){
        curl_setopt($this->_ch, CURLOPT_URL, $this->domain.'stream_filters');
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array('Api-Key: '.$this->apiKey));
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        return json_decode( curl_exec($this->_ch) ,true);
    }

    /**
     * 获取可用的流架构 Get available flow schemas
     */
    public function get_available_flow_schemas(){
        ///admin_api/v1/stream_schemas
        curl_setopt($this->_ch, CURLOPT_URL, $this->domain . 'stream_schemas');
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array('Api-Key: ' . $this->apiKey));
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        return json_decode( curl_exec($this->_ch) ,true);
    }

    /**
     * 获取流量类型列表 Get list of flows types
     */
    public function get_list_of_flows_types(){
        curl_setopt($this->_ch, CURLOPT_URL, $this->domain . 'stream_types');
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array('Api-Key: ' . $this->apiKey));
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        return json_decode( curl_exec($this->_ch) ,true);
    }

    /**
     * 获取可用流量操作 Get available flows actions
     */
    public function get_available_flows_actions(){
        curl_setopt($this->_ch, CURLOPT_URL, $this->domain . 'stream_schemas');
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array('Api-Key: ' . $this->apiKey));
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        return json_decode( curl_exec($this->_ch) ,true);
    }

    /**
     * 创建流量 Create flow
     * @param string $campaign_id
     * @param string $schema 模式 枚居: "landings" "redirect" "action"
     * @param string $type 类型 枚居: "forced" "regular" "default"
     * @param string $name 名称
     * @param string $action_type Action to perform (see 'Retrieve available flow action types')
     * @return bool|string
     */
    public function create_flow($campaign_id, $schema, $type, $name, $action_type){
        curl_setopt($this->_ch, CURLOPT_URL, $this->domain . 'streams');
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array('Api-Key: ' . $this->apiKey));
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->_ch, CURLOPT_POST, 1);
        $data =getParams();
        curl_setopt($this->_ch,CURLOPT_POSTFIELDS, json_encode( $data));
        return json_decode( curl_exec($this->_ch) ,true);
    }

    /**
     * 获取流量 Get flow
     * @param $flow_id
     * @return bool|string
     */
    public function get_flow($flow_id){
        curl_setopt($this->_ch, CURLOPT_URL, $this->domain . 'streams/'.$flow_id);
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array('Api-Key: ' . $this->apiKey));
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        return json_decode( curl_exec($this->_ch) ,true);
    }

    /**
     * 更新流程 Update flow
     * @param $id
     * @param $name
     * @param $mode
     * @param $payload
     */
    public function update_flow($id,$name,$mode,$payload=[]){
        $data = [
            "id" => $id,
            "type" => "forced",
            "name" => $name,
            "campaign_id" => 1,
            "position" => 3,
            "action_options" => null,
            "comments" => "",
            "state" => "active",
            "action_type" => "iframe",
            "action_payload" => "https://hop.clickbank.net/?affiliate=isuyee88&vendor=slimcore&tid={subid}&cbpage=inspired",
            "schema" => "landings",
            "collect_clicks" => true,
            "filter_or" => true,
            "weight" => 2,
            "filters" => [
                ["id" => 1858, "stream_id" =>$id, "name" => "keyword", "mode" => $mode, "payload" => $payload, "oid" => 1858],
                ["id" => 1845, "stream_id" => $id, "name" => "sub_id_2", "mode" => $mode, "payload" => $payload, "oid" => 1845]
            ],
            "triggers" => [],
            "landings" => [],
            "offers" => [
                ["id" => 775, "stream_id" => $id, "offer_id" => 1, "state" => "active", "share" => 100,
                    "created_at" => "2022-10-04 23:06:58", "updated_at" => "2022-11-05 12:16:01"]
            ]
        ];
        curl_setopt($this->_ch, CURLOPT_URL, $this->domain . 'streams/'.$id);
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array('Api-Key: '.$this->apiKey));
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->_ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($this->_ch, CURLOPT_POST, 1);
        curl_setopt($this->_ch,CURLOPT_POSTFIELDS, json_encode( $data));
        return json_decode( curl_exec($this->_ch) ,true);
    }

    /**
     *  删除流量 Delete flow
     * @param $id
     * @return bool|string
     */
    public function delete_flow($id){
        curl_setopt($this->_ch, CURLOPT_URL, $this->domain . 'streams/'.$id);
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array('Api-Key: '.$this->apiKey));
        curl_setopt($this->_ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->_ch, CURLOPT_POST, 1);
        curl_setopt($this->_ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($this->_ch, CURLOPT_POSTFIELDS, json_encode(['id' => $id]));
        return json_decode( curl_exec($this->_ch) ,true);
    }

    /**
     * 禁用流量 Disable flow
     * @param $id
     * @return bool|string
     */
    public function disable_flow($id){
        curl_setopt($this->_ch, CURLOPT_URL, $this->domain . 'streams/'.$id.'/disable');
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array('Api-Key: ' . $this->apiKey));
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->_ch, CURLOPT_POST, 1);
        $data =getParams();
        curl_setopt($this->_ch,CURLOPT_POSTFIELDS, json_encode( $data));
        return json_decode( curl_exec($this->_ch) ,true);
    }

    /**
     * 启用流量 Enable flow
     * @param $id
     * @return bool|string
     */
    public function enable_flow($id){
        curl_setopt($this->_ch, CURLOPT_URL, $this->domain . 'streams/'.$id.'/enable');
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array('Api-Key: ' . $this->apiKey));
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->_ch, CURLOPT_POST, 1);
        $data =getParams();
        curl_setopt($this->_ch,CURLOPT_POSTFIELDS, json_encode( $data));
        return json_decode( curl_exec($this->_ch) ,true);
    }

    /**
     * 获取流量事件 Get flow events
     * @param $id
     * @return bool|string
     */
    public function get_flow_events($id){

        curl_setopt($this->_ch, CURLOPT_URL, $this->domain . 'streams/'.$id.'/enable');
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array('Api-Key: ' . $this->apiKey));
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        return json_decode( curl_exec($this->_ch) ,true);
    }

    /**
     * 恢复存档流量 Restore an Archived Flow
     * @param $id
     * @return bool|string
     */
    public function restore_an_archived_flow($id){
        curl_setopt($this->_ch, CURLOPT_URL, $this->domain .  'streams/'.$id.'/restore');
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array('Api-Key: ' . $this->apiKey));
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->_ch, CURLOPT_POST, 1);
        $data =getParams();
        curl_setopt($this->_ch,CURLOPT_POSTFIELDS, json_encode( $data));
        return json_decode( curl_exec($this->_ch) ,true);
    }

    /**
     * 获取已删除的流量 Get deleted flows
     * @return bool|string
     */
    public function get_deleted_flows(){
        ///admin_api/v1/streams/deleted
        curl_setopt($this->_ch, CURLOPT_URL, $this->domain . 'streams//deleted');
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array('Api-Key: ' . $this->apiKey));
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        return json_decode( curl_exec($this->_ch) ,true);
    }

    /**
     * 在流量中搜索 Search in flows
     * @param $query
     * @return bool|string
     */
    public function search_in_flows($query){
        $ch = curl_init();
        curl_setopt($this->_ch, CURLOPT_URL, $this->domain .  'streams/search?query='.$query);
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array('Api-Key: ' . $this->apiKey));
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        return json_decode( curl_exec($this->_ch) ,true);
    }
}