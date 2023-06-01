<?php
namespace crud\modules\movie\controllers;

use Yii;
use yii\web\Controller;
use crud\modules\movie\models\Movie;

class IndexController extends Controller
{

    public $layout= 'webslides';

    /**
     * @return string
     */
    public function actionIndex(){
        $model = Movie::find()
            ->orderBy('RAND()')
            ->orderBy(['year' => SORT_DESC,'created_at'=>SORT_DESC,'updated_at'=>SORT_DESC])
            ->limit(8)
            ->all();
        return $this->render("index", ['model' => $model]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionList($id=''){
        $limit = Yii::$app->request ->get('limit',30);
       if(!empty($id) ){
           $model =[ Movie::findOne($id)];

       }else{
           $model = Movie::find()
               ->orderBy(['year' => SORT_DESC,'created_at'=>SORT_DESC,'updated_at'=>SORT_DESC])
               ->limit($limit)
               ->all();
       }
        return  $this->render("list",['model'=>$model]);
    }

    /**
     * @return string
     */
    public function actionCategory(){
        $config =[
            ['category' => '科幻', 'img' => '', 'url' => ''],
            ['category' => '灾难', 'img' => '', 'url' => ''],
            ['category' => '魔幻', 'img' => '', 'url' => ''],
            ['category' => '奇幻', 'img' => '', 'url' => ''],

            ['category' => '战争', 'img' => '', 'url' => ''],
            ['category' => '动作', 'img' => '', 'url' => ''],
            ['category' => '动画', 'img' => '', 'url' => ''],
            ['category' => '音乐', 'img' => '', 'url' => ''],

            ['category' => '传记', 'img' => '', 'url' => ''],
            ['category' => '冒险', 'img' => '', 'url' => ''],
            ['category' => '剧情', 'img' => '', 'url' => ''],
            ['category' => '同性', 'img' => '', 'url' => ''],

            ['category' => '喜剧', 'img' => '', 'url' => ''],
            ['category' => '爱情', 'img' => '', 'url' => ''],
            ['category' => '犯罪', 'img' => '', 'url' => ''],
            ['category' => '历史', 'img' => '', 'url' => ''],

//    ['category' => '犯罪', 'img' => '', 'url' => ''],
        ];
        foreach ($config as $key=> $item){
            /** @var $model Movie */
            $model =Movie::find()
                ->where(['not', ['img' => null]])
                ->andWhere(['like', 'keywords',$item['category']])
                ->orWhere(['like', 'movie_name', $item['category']])
                ->orderBy(['year' => SORT_DESC,'created_at'=>SORT_DESC,'updated_at'=>SORT_DESC])
                ->one();
          if($model && !empty($model->img)){
              $config[$key]['img']=$model->img;
          }

        }
        return  $this->render("category",['config'=>$config]);
    }

    /**
     * @return string
     */
    public function actionSearch(){
        $request = Yii::$app->request;
        $limit = $request ->get('limit',30);
        if($request->isGet){
            $search = $request->get('category','');
        }
        if($request->isPost){
            $search = $request->post('category','');
        }

        if(empty($search)){
            $model = Movie::find()
                ->orderBy(['year' => SORT_DESC,'created_at'=>SORT_DESC,'updated_at'=>SORT_DESC])
                ->limit( $limit )
                ->all();
        }else{
            $model = Movie::find()
                ->where(['like', 'movie_name', $search])
                ->orWhere(['like', 'translated_name', $search])
                ->orWhere(['like', 'country',$search])
                ->orWhere(['like', 'keywords', $search])
                ->orWhere(['like', 'director',$search])
                ->orWhere(['like', 'describe',$search])
                ->orWhere(['like', 'keywords',$search])
                ->orderBy(['year' => SORT_DESC,'created_at'=>SORT_DESC,'updated_at'=>SORT_DESC])
                ->limit( $limit )
                ->all();
        }
        return  $this->render("list",['model'=>$model]);
    }

    public function actionTrends(){
        $limit = Yii::$app->request->get('limit',30);
        $model = Movie::find()
            ->where( ['in','year',[2023,2022,2021,2020,2019]])
            ->andWhere(['not', ['img' => null]])
            ->orderBy(['year' => SORT_DESC,'created_at'=>SORT_DESC,'updated_at'=>SORT_DESC])
            ->limit($limit)
            ->all();
        return  $this->render("list",['model'=>$model]);
    }
}