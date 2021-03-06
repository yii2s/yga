<?php

namespace backend\base;

use kartik\widgets\ActiveForm;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\MethodNotAllowedHttpException;
use backend\modules\weixin\models\PublicAccount;

class BackendController extends Controller {
	
	public $session;
	public $auth;
	public $request;
	
	public function behaviors() {
		return [ 
				'access' => [ 
						'class' => AccessControl::className (),
						'rules' => [ 
								[ 
										'allow' => true,'roles' => [ 
												'@' 
										] 
								],[ 
										'actions' => [ 
												'error' 
										],'allow' => true 
								],[ 
										'actions' => [ 
												'login' 
										],'allow' => true,'roles' => [ 
												'?' 
										] 
								] 
						],'denyCallback' => function ($rules, $action) {
							Yii::$app->user->returnUrl = Yii::$app->request->url;
							return $this->redirect ( [ 
									'user/login' 
							] );
						} 
				]
		];
	}
	
	/**
	 * 初始化
	 */
	public function init() {
		$this->session = \Yii::$app->session;
		$this->auth = Yii::$app->authManager;
		$this->request = Yii::$app->request;
		Yii::$container->set ( 'yii\widgets\LinkPager', [ 
				'firstPageLabel' => '首页','lastPageLabel' => '尾页','prevPageLabel' => '上页','nextPageLabel' => '下页','hideOnSinglePage' => false,'options' => [ 
						'class' => 'pagination pull-right' 
				] 
		] );
		Yii::$container->set ( 'yii\data\Pagination', [ 
				'defaultPageSize' => 15 
		] );
		Yii::$container->set ( 'yii\grid\ActionColumn', [ 
				'template' => '{update} {delete}' 
		] );
		Yii::$container->set ( ActiveForm::className (), [ 
				'type' => ActiveForm::TYPE_HORIZONTAL 
		] );
		Yii::$container->set ( 'yii\captcha\Captcha', [ 
				'captchaAction' => 'home/captcha' 
		] );
		Yii::$container->set ( 'yii\captcha\CaptchaValidator', [ 
				'captchaAction' => 'home/captcha' 
		] );
		Yii::$container->set ( 'backend\behaviors\TestBehavior', [ 
				'msg' => 'xxxxxxx' 
		] );
	}
	
	/**
	 * 强制刷新菜单
	 * 
	 * @return \yii\web\Response
	 */
	public function actionReflushmenu() {
		Yii::$app->session->setFlash ( 'reflush' );
		return $this->goHome ();
	}
	public function beforeAction($action) {
		parent::beforeAction ( $action );
		// 访问非菜单里的action时，菜单保持打开(添加角色时角色管理保持打开状态)
		
		$user = yii::$app->user->getIdentity();
		if(!empty($user)){
			$cache = Yii::$app->getCache ();
			$cache->delete('accounts');
			$results = [];
			if (empty ( $cache->get ( 'accounts' ) )) {
					
				$accounts = PublicAccount::find()
				->joinWith('weixinUsers')->where(['user_id' => $user->id])->all();
				foreach($accounts as $account){
					$results[$account->type][] = $account;
				}
				Yii::$app->getCache()->set('accounts', $results);
			}
		}
		$refferroute = Yii::$app->request->referrer;
		$_referrer = parse_url ( $refferroute );
		Yii::$app->session->set ( 'referrerroute', $_referrer ['path'] );
		$route = Yii::$app->requestedRoute;
		// 未加入权限控制的所有路由允许访问
		if (! Yii::$app->authManager->getPermission ( $route )) {
			return true;
		}
		
		if (Yii::$app->user->id != 1 && ! Yii::$app->user->can ( $route )) {
			throw new MethodNotAllowedHttpException ( '未被授权！' );
		}
		
		return true;
	}
	public function afterAction($action, $result) {
		parent::afterAction ( $action, $result );
		return $result;
	}
}