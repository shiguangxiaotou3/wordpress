<?php


namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use crud\library\components\Ads;
use crud\library\components\Flows;
use yii\web\Response;
use crud\widgets\WpTableWidget;
class AdsController extends Controller{

    public $layout=false;
    public $enableCsrfValidation=false;

    public function actions(){
        return [
            "index","redirect-uri","test"
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(){
        session_start();
        $ads = Yii::$app->ads;
        $token=[] ;
        $code ="";
        // 第一次获取token
        if(isset($_SESSION["code"])){
            $code =$_SESSION["code"];
            $token = $this->getToken();
            $token['code']=$code;
        }
        // 非第一次 过去刷新令牌
        if(empty($token)){
            $token["RefreshToken"]= file_get_contents(Yii::getAlias($ads->oAuthRefreshTokenPath));
        }
        return $this->render("index",[
            "url"=> $ads->getTokenUrlByCli(),
            "token"=>$token,
            "code"=>$code
        ]);
    }

    /**
     * @return mixed|string
     */
    public function actionRedirectUri(){
        $require = Yii::$app->request;
        if($require->isAjax){
            /** @var Flows $flows */
            $flows = Yii::$app->flows;
            $data =$require->post('data');
            return $flows->update_flow( $data["stream_id"], $data["name"],$data["mode"],$data["payload"]);
        }else{
            return $this->render("redirect_uri");
        }
    }

    /**
     * @return string
     */
    public function actionTest(){
        return $this->render("test");
    }

    /**
     * @return array
     */
    private function getToken(){
        $code = $_SESSION["code"];
        unset($_SESSION["code"]);
        $ads = Yii::$app->ads;
        $res = $ads->authorizationData->Authentication->RequestOAuthTokensByResponseUri("https://www.shiguangxiaotou.com/?code=".$code);
        $ads->WriteOAuthRefreshToken($ads->authorizationData->Authentication->OAuthTokens->RefreshToken);
        session_destroy();
        return get_object_vars($res);
    }

    public function actionUpdate(){
        $request =Yii::$app->request;
        $adGroupId=$request->get('adGroupId');
        $campaignId=$request->get('campaignId');
        $id = $request->get('id');
        $name = $request->get('name');
        $mode = $request->get('mode',"accept");
        if(!empty($adGroupId) and !empty($campaignId) and
            !empty($id) and !empty( $name ) and !empty($mode)){
            $flows = Yii::$app->flows;
            $ads = Yii::$app->ads;
            $payload = self::payload();
            $results=  $flows->update_flow($id,$name,$mode,$payload);
            $results2=$ads->UpdateAdGroups($campaignId, $adGroupId,end($payload));
            $this->sandJson(1,"跟新成功", ['flows'=> $results,"ads"=>$results2]);
        }else{
            $this->sandJson(0,"数据提交不完整");
        }
        return $this->sandJson("asda","adsas");
    }
    public function actionUpdateKey(){
        $request =Yii::$app->request;
        $adGroupId=$request->get('adGroupId');
//        $campaignId=$request->get('campaignId');
        $n = $request->get('n');
        $data = json_decode( json_encode(  Yii::$app->ads->GetKeywordsByAdGroupId( $adGroupId)),true);
        if(isset($data['Keywords']['Keyword'])){
            $keywords = array_column($data['Keywords']['Keyword'],"Id");
            if(count($keywords) >= $n){
                $idsKey = array_rand($keywords,$n);
                $ids = [];
                foreach ($idsKey as $value){
                    $ids[] = $keywords[$value];
                }
                $results =array_diff($keywords,$ids);
                $tmp =[];
                foreach ($ids as $id){
                    $tmp[]=["Id"=>$id,"Status"=>"Active"];
                }
                foreach ($results as $result){
                    $tmp[]=["Id"=>$result,"Status"=>"Paused"];
                }
               $res= Yii::$app->ads-> UpdateKeywords($adGroupId, $tmp);
                $this->sandJson(1,"更新成功",$res);
            }else{
                $this->sandJson(0,"n必须小于:".count($keywords));
            }
            $this->sandJson(0,"获取关键词词失败", $keywords );
        }else{
            $this->sandJson(0,"获取关键词词失败");
        }

    }
    public function actionGetAdGroupsByCampaignId(){
        $request =Yii::$app->request;
        $ads = Yii::$app->ads;
        $campaignId=$request->get('campaignId');
        $data = json_decode( json_encode( $ads->GetAdGroupsByCampaignId( $campaignId)),true);
        /*
         * "AdRotation": null,
                    "AudienceAdsBidAdjustment": null,
                    "BiddingScheme": {
                        "Type": "InheritFromParent",
                        "InheritedBidStrategyType": "EnhancedCpc"
                    },
                    "CpcBid": {
                        "Amount": 0.3
                    },
                    "EndDate": null,
                    "FinalUrlSuffix": null,
                    "ForwardCompatibilityMap": [],
                    "Id": 1229254305018244,
                    "Language": null,
                    "Name": "291f1029-6d73-11ed-aa4a-00163e006044",
                    "Network": "OwnedAndOperatedAndSyndicatedSearch",
                    "PrivacyStatus": null,
                    "Settings": null,
                    "StartDate": {
                        "Day": 11,
                        "Month": 10,
                        "Year": 2022
                    },
                    "Status": "Active",
                    "TrackingUrlTemplate": null,
                    "UrlCustomParameters": null
                }
         */
        if(isset($data["AdGroups"]['AdGroup']) and !empty($data["AdGroups"]['AdGroup'])){
            $html=  WpTableWidget::widget([
                "columns" => [
                    ['field' => 'Id', 'title' => 'Id'],
                    ['field' => 'Name', 'title' => 'Name'],
                    ['field' => 'StartDate', 'title' => 'StartDate',"callback"=>function($row){ return $row['StartDate']['Year']."-" .$row['StartDate']['Month']."-".$row['StartDate']['Day'];}],
                    ['field' => 'Network', 'title' => 'Network'],
                    ['field' => 'MatchType', 'title' => 'MatchType'],
                    ['field' => 'Status', 'title' => 'Status'],
                    ['field' => 'actions', 'title' => '关键词',"callback"=>function($row){
                        return "<button data-adGroupId='".$row['Id']."' class='button adGroupId'>关键词</button>";
//                        return Html::('关键词',"#",[/*'data-adGroupId'=>$row['Id'],*/"class"=>"adGroupId"]);
                    }],
                ], 'data' => $data["AdGroups"]['AdGroup']
            ]);
            $this->sandJson(1,"查询广告组成功",$html );
        }else{
            $this->sandJson(0,"查询失败" );
        }
    }
    public function actionKeyWord(){
        $request =Yii::$app->request;
        $ads = Yii::$app->ads;
        $adGroupId=$request->get('adGroupId');
        $data = json_decode( json_encode( $ads->GetKeywordsByAdGroupId( $adGroupId)),true);
        /*
         * "AdRotation": null,
                    "AudienceAdsBidAdjustment": null,
                    "BiddingScheme": {
                        "Type": "InheritFromParent",
                        "InheritedBidStrategyType": "EnhancedCpc"
                    },
                    "CpcBid": {
                        "Amount": 0.3
                    },
                    "EndDate": null,
                    "FinalUrlSuffix": null,
                    "ForwardCompatibilityMap": [],
                    "Id": 1229254305018244,
                    "Language": null,
                    "Name": "291f1029-6d73-11ed-aa4a-00163e006044",
                    "Network": "OwnedAndOperatedAndSyndicatedSearch",
                    "PrivacyStatus": null,
                    "Settings": null,
                    "StartDate": {
                        "Day": 11,
                        "Month": 10,
                        "Year": 2022
                    },
                    "Status": "Active",
                    "TrackingUrlTemplate": null,
                    "UrlCustomParameters": null
                }
         */
        if(isset($data["Keywords"]['Keyword']) and !empty($data["Keywords"]['Keyword'])){
            $html=  WpTableWidget::widget([
                //"Status": "Active",
                //                    "Text": "macys com official site",
                "columns" => [
                    ['field' => 'Id', 'title' => 'Id'],
                    ['field' => 'Status', 'title' => 'Status'],
                    ['field' => 'Text', 'title' => 'Text'],
                    ['field' => 'actions', 'title' => '关键词',"callback"=>function($row)use($adGroupId){
                        return "<button class='button keyword' data-adGroupId='".$adGroupId."' data-Id='".$row['Id']."' data-Status='". $row['Status']."'> 开关 </a>";
                    }],
                ], 'data' => $data["Keywords"]['Keyword']
            ]);
            $this->sandJson(1,"查询广告组成功",$html );
        }else{
            $this->sandJson(0,"查询失败" );
        }
    }
    public function actionUpdateKeyWordOne(){
        $request =Yii::$app->request;
        $ads = Yii::$app->ads;
        $adGroupId=$request->get('adGroupId');
        $Id=$request->get('Id');
        $Status=$request->get('Status');
        $keywords=[
            ['Id'=>$Id,"Status"=>($Status == "Paused") ? "Active" : "Paused"]
        ];
        $data = object_array( $ads->UpdateKeywords($adGroupId, $keywords));
        if(empty($data["PartialErrors"]) ){
            $this->sandJson(1,"更新成功",$data );
        }else{
            $this->sandJson(0,"更新失败",$data );
        }
    }
    public static function  payload(){
        $payload = array_filter( explode("\n",get_option("crud_group_flows_payload")));
        $n= count($payload );
        if($n>=2){
            $tmp =[
                $payload[$n-2] ,$payload[$n-1],self::uuid()
            ];
        }elseif ($n==1){
            $tmp =[
                $payload[$n-1],self::uuid()
            ];
        }else{
            $tmp =[self::uuid()];
        }
        update_option("crud_group_flows_payload",join("\n",$tmp));
        return $tmp;
    }
    public static function uuid(){
        return Yii::$app->db->createCommand("select uuid() as uuid")->queryOne()['uuid'];
    }
    public function sandJson($code,$message,$data=[]){
        $response= Yii::$app->response;
        $response->format= Response::FORMAT_JSON;
        $response->data=[
            "code"=>$code,
            "message"=>$message,
            "data"=>$data,
        ];
        $response->send();
    }

}