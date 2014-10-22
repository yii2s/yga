<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "t_menu".
 *
 * @property integer $id
 * @property string $menuname
 * @property integer $parentid
 * @property string $route
 * @property string $menuicon
 * @property integer $level
 */
class TMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menuname'], 'required'],
            [['parentid', 'level'], 'integer'],
            [['menuname', 'route'], 'string', 'max' => 32],
            [['menuicon'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menuname' => '菜单名称',
            'parentid' => '父类ID',
            'route' => '路由',
            'menuicon' => '图标',
            'level' => '级别',
        ];
    }

    /**
     * 获取子菜单
     * @return static
     */
    public function getSon()
    {
        return $this->hasMany(TMenu::className(),['parentid'=>'id'])->orderBy('level desc');
    }
}