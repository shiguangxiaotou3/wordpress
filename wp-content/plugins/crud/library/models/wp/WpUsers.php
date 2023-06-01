<?php

namespace crud\models\wp;

use \Yii;
use \WP_User;
use \WP_Error;
use \yii\db\ActiveRecord;
use crud\modules\market\models\Money;

/**
 * This is the model class for table "wp_users".
 *
 * @property-read  int $id
 * @property-read  int $ID
 * @property string $user_login
 * @property string $user_pass
 * @property string $user_nicename
 * @property string $user_email
 * @property string $user_url
 * @property string $user_registered
 * @property string $user_activation_key
 * @property int $user_status
 * @property string $display_name

 * @property string $phone
 * @property WP_User $wpUser
 * @property string $nickName
 * @property string $token
 * @property-read array $userInfo
 * @property string $money
 * @property string $avatarUrl
 * @property string $gender
 * @property string $language
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $unionid
 * @property string $applet_session_key
 * @property string $applet_openid
 */
class WpUsers extends ActiveRecord
{

    /**
     * 小程序
     */
    const LOGIN_TYPE_APPLET = 'applet';

    /**
     * 公众号
     */
    const LOGIN_TYPE_SUBSCRIPTION ='subscription';
    /**
     * H5
     */
    const LOGIN_TYPE_H5 ='h5';

    /**
     * @var WP_User
     */
    private $_wpUser;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wp_users';
    }

    /**
     * {@inheritdoc}
     */
    public function fields() {
        $fields = parent::fields();
        $fields[] = ['avatarUrl'=>function (){return $this->avatarUrl;}];
        return  $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_registered'], 'safe'],
            [['user_status'], 'integer'],
            [['user_login'], 'string', 'max' => 60],
            [['user_pass', 'user_activation_key'], 'string', 'max' => 255],
            [['user_nicename'], 'string', 'max' => 50],
            [['user_email', 'user_url'], 'string', 'max' => 100],
            [['display_name'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'user_login' => 'User Login',
            'user_pass' => 'User Pass',
            'user_nicename' => 'User Nicename',
            'user_email' => 'User Email',
            'avatarUrl'=>'Avatar Url',
            'user_url' => 'User Url',
            'user_registered' => 'User Registered',
            'user_activation_key' => 'User Activation Key',
            'user_status' => 'User Status',
            'display_name' => 'Display Name',
        ];
    }

    /**
     * @return array[]
     */
    public function columns()
    {
        return [
            ['field' =>'ID', 'title' =>Yii::t('market',  'ID')],
            ['field' =>'user_login', 'title' => Yii::t('market', 'User Login')],
            ['field' =>'user_pass', 'title' => Yii::t('market', 'User Pass')],
            ['field' =>'avatarUrl', 'title' => Yii::t('market', 'Avatar Url')],
            ['field' =>'user_nicename', 'title' => Yii::t('market', 'User Nicename')],
            ['field' =>'user_email', 'title' =>Yii::t('market',  'User Email')],
            ['field' =>'user_url', 'title' => Yii::t('market', 'User Url')],
            ['field' =>'user_registered', 'title' => Yii::t('market', 'User Registered')],
            ['field' =>'user_activation_key', 'title' => Yii::t('market', 'User Activation Key')],
            ['field' =>'user_status', 'title' =>Yii::t('market',  'User Status')],
            ['field' =>'display_name', 'title' => Yii::t('market', 'Display Name')],
        ];
    }

    public function getId(){
        return $this->ID;
    }

    public function getWpUser(){
        if($this->_wpUser instanceof  WP_User){
            return $this->_wpUser;
        }

        return get_user_by( 'id', $this->ID );
    }

    public function setWpUser($user){
        $this->_wpUser = $user;
    }

    public function getAvatarUrl(){
        return $this->getUserMeta('avatarUrl');
    }
    public function setAvatarUrl($value){
        return $this->setUserMeta('avatarUrl',$value,true);
    }

    public function getPhone(){
        return $this->getUserMeta('phone');
    }
    public function setPhone($value){
        return $this->setUserMeta('phone',$value,true,true);
    }

    public function getNickName(){
        return $this->getUserMeta('nickName');
    }
    public function setNickName($value){
        return $this->setUserMeta('nickName',$value,true);
    }

    public function getToken(){
        return $this->getUserMeta('token');
    }
    public function setToken($value){
        if(empty($value)){
            $value = generateUuid(32);
        }
        return $this->setUserMeta('token',$value,true,true);
    }

    public function getMoney(){
        return (float) $this->getUserMeta('money');
    }
    public function setMoney($value){
        return $this->setUserMeta('money',$value,true);
    }

    public function getGender(){
        return $this->getUserMeta('gender');
    }
    public function setGender($value){
        return $this->setUserMeta('gender',$value,true);
    }

    public function getLanguage(){
        return $this->getUserMeta('language');
    }
    public function setLanguage($value){
        return $this->setUserMeta('language',$value,true);
    }

    public function getCity(){
        return $this->getUserMeta('city');
    }
    public function setCity($value){
        return $this->setUserMeta('city',$value,true);
    }

    public function getProvince(){
        return $this->getUserMeta('province');
    }
    public function setProvince($value){
        return $this->setUserMeta('province',$value,true);
    }

    public function getCountry(){
        return $this->getUserMeta('country');
    }
    public function setCountry($value){
        return $this->setUserMeta('country',$value,true);
    }

    public function getUnionid(){
        return $this->getUserMeta('unionid');
    }
    public function setUnionid($value){
        return $this->setUserMeta('unionid',$value,true);
    }

    public function getApplet_session_key(){
        return $this->getUserMeta(self::LOGIN_TYPE_APPLET.'_session_key');
    }
    public function setApplet_session_key($value){
        return $this->setUserMeta(self::LOGIN_TYPE_APPLET.'_session_key',$value,true);
    }

    public function getApplet_openid(){
        return $this->getUserMeta(self::LOGIN_TYPE_APPLET.'_openid');
    }
    public function setApplet_openid($value){
        return $this->setUserMeta(self::LOGIN_TYPE_APPLET.'_openid',$value,true);
    }

    public function getSubscription_openid(){
        return $this->getUserMeta(self::LOGIN_TYPE_SUBSCRIPTION.'_openid');
    }
    public function setSubscription_openid($value){
        return $this->setUserMeta(self::LOGIN_TYPE_SUBSCRIPTION.'_openid',$value,true);
    }

    public function getSubscription_session_key(){
        return $this->getUserMeta(self::LOGIN_TYPE_SUBSCRIPTION.'_session_key');
    }
    public function setSubscription_session_key($value){
        return $this->setUserMeta(self::LOGIN_TYPE_SUBSCRIPTION.'_session_key',$value,true);
    }
    /**
     * 通过用户名或邮箱登录
     * @param $username
     * @param $password
     * @param bool $remember
     * @return WP_Error|WP_User
     */
    public function loginByUserName($username,$password,$remember =true){
        return wp_signon(['user_login' => $username, 'user_password' => $password, 'remember' => $remember], $remember);

    }

    /**
     * 通过token登录
     * @param $token
     * @param bool $remember
     * @return bool
     */
    public function loginByToken($token,$remember =true){
        $user = WpUserMeta::find()
            ->where(['meta_key'=>"token"])
            ->andWhere(['meta_value'=>$token])
            ->one();
        if($user){
            return  $this->loginById($user->user_id,$remember);
        }else{
            return false;
        }
    }

    /**
     * 通过session_key登录
     * @param $session_key
     * @param string $type
     * @param bool $remember
     * @return bool
     */
    public function loginBySessionKey($session_key,$type = self::LOGIN_TYPE_APPLET,$remember =true){
        $user = WpUserMeta::find()
            ->where(['meta_key'=>$type."_session_key"])
            ->andWhere(['meta_value'=>$session_key])
            ->one();
        if($user){
            return  $this->loginById($user->user_id,$remember);
        }else{
            return false;
        }
    }

    /**
     * 通过openid登录
     * @param $open_id
     * @param string $type
     * @param bool $remember
     * @return bool
     */
    public function loginByOpenId($open_id,$type= self::LOGIN_TYPE_APPLET,$remember =true){
        $user = WpUserMeta::find()
            ->where(['meta_key'=>$type."_openid"])
            ->andWhere(['meta_value'=>$open_id])
            ->one();
        if($user){
            return  $this->loginById($user->user_id,$remember);
        }else{
            return false;
        }
    }

    /**
     * 手机号登录
     * @param $phone
     * @param bool $remember
     * @return bool
     */
    public function loginByPhone($phone,$remember =true){
        $user = WpUserMeta::find()
            ->where(['meta_key'=>"phone"])
            ->andWhere(['meta_value'=>$phone])
            ->one();
        if($user){
            return  $this->loginById($user->user_id,$remember);
        }else{
            return false;
        }
    }

    /**
     * 模型登录
     * @param bool $remember
     */
    public function login($remember =true){
        $this->loginById($this->ID,$remember);
    }

    /**
     * 通过id登录
     * @param $user_id
     * @param bool $remember
     * @return bool
     */
    public function loginById( $user_id,$remember =true){
        $user = get_user_by( 'id', $user_id );
        if ( $user ) {
            $user_login = $user->user_login;
            $user = new \WP_User( $user_id );
            wp_set_current_user( $user_id, $user_login );
            wp_set_auth_cookie( $user->ID, $remember, is_ssl());
            wp_set_auth_cookie( $user_id );
            do_action( 'wp_login', $user_login, $user );
            return true;
        }
        return false;

    }

    /**
     * 获取用户信息
     * @return array
     */
    public function getUserInfo(){
        $avatarUrl =$nickname ='';
        if($this->ID ==1){
            $this->phone ='17762482477';
            $this->avatarUrl='https://www.shiguangxiaotou.com/wp-content/uploads/2023/03/WechatIMG586.jpeg';
            $this->token='';
            $nickname ='时光小偷';
            $avatarUrl = 'https://www.shiguangxiaotou.com/wp-content/uploads/2023/03/WechatIMG586.jpeg';
        }else{
            $avatarUrl = $this->getAvatarUrl();
            $nickname =$this->getNickName();
        }
        return [
            'id'=>$this->id,
            'phone'=>$this->getPhone(),
            'nickName'=>$nickname ,
            'token'=>$this->getToken(),
            'money'=>$this->getMoney(),
            'avatarUrl'=>$avatarUrl,
            'gender'=>$this->getGender(),
            'language'=>$this->getLanguage(),
            'city'=>$this->getCity(),
            'province'=>$this->getProvince(),
            'country'=>$this->getCountry(),
            'unionid'=>$this->getUnionid(),
            'applet_session_key'=>$this->getApplet_session_key(),
            'applet_openid'=>$this->getApplet_openid(),
            'subscription_session_key'=>$this->getSubscription_session_key(),
            'subscription_openid'=>$this->getSubscription_openid()
        ];
    }

    /**
     * @param $phone
     * @return array|WpUsers|false|ActiveRecord|null
     */
    public  function getUserByPhone($phone){
        return $this->getUserByMeta('phone',$phone);
    }

    /**
     * @param $user_id
     * @return array|WpUsers|ActiveRecord|null
     */
    public  function getUserById($user_id){
        return self::find()->where(['ID'=>$user_id])->one();
    }

    /**
     * 通过token 获取用户
     * @param $token
     * @return array|false|ActiveRecord|null
     */
    public  function getUserByToken($token){
        return $this->getUserByMeta('token',$token);
    }

    /**
     * 通过用户自定义字段查询用户
     * @param $field
     * @param $value
     * @return array|false|ActiveRecord|null
     */
    private function getUserByMeta($field,$value){
        $result= WpUserMeta::find()
            ->where(['meta_key'=>$field])
            ->andWhere(['meta_value'=>$value])
            ->one();
        if($result){
            return self::find()->where(['ID'=>$result->user_id])->one();
        }else{
            return false;
        }
    }

    /**
     * 获取用户的自定义属性
     * @param $field
     * @param bool $single
     * @return mixed
     */
    public function getUserMeta($field,$single=true){
        return get_user_meta($this->ID,$field,$single);
    }

    /**
     * 跟新用户的自定义属性
     * @param $field
     * @param $value
     * @param false $unique
     * @return bool|int
     */
    private function setUserMeta($field,$value,$unique=false){
        $UserMeta = WpUserMeta::find()
            ->where(['user_id'=>$this->ID])
            ->andWhere(['meta_key'=>$field])
            ->one();
        if($UserMeta ){
            if($UserMeta->meta_value == $value){
                return true;
            }else{
                return update_user_meta($this->ID,$field,$value);
            }
        }else{
            return  add_user_meta($this->ID,$field,$value,$unique);
        }
    }
    /**
     * 更新用户余额
     * @param $money
     * @param $remarks
     * @return bool
     */
    public function updateUserMoney($money,$remarks =''){
        $user_id =(int) $this->ID;
        $before = $this->money;
        $after= $before + (float) $money;
        $model = new Money();
        $model->user_id = $user_id;
        $model->before = $before;
        $model->after = $after;
        $model->remarks =$remarks;
        if($model->validate() and $model->save()){
          $this->money =   $after;
          return true;
        }
    }

    public function integralPay(){

    }
}
