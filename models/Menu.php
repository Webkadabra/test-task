<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $title
 * @property string $link
 */
class Menu extends \yii\db\ActiveRecord
{
    public $children;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['title'], 'required'],
            [['link'], 'url'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'title' => 'Title',
            'link' => 'Link',
        ];
    }

    /**
     * @return array
     */
    public static function getTree() {
        $data = self::find()->indexBy('id')->orderBy('parent_id DESC')->all();
        return static::travTree($data);
    }

    /**
     * helper method to make simple tree from flat data
     *
     * @param array $elements
     * @param int $parentId
     * @return array
     */
    public static function travTree(array &$elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {

            if ($element->parent_id == $parentId) {
                $children = static::travTree($elements, $element->id);
                if ($children) {
                    $element->children = $children;
                }
                $branch[$element->id] = $element;
                unset($elements[$element->id]);
            }
        }
        return $branch;
    }

    /**
     * Delete all children when root is deleted
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function afterDelete()
    {
        foreach (static::find()->where(['parent_id' => $this->id])->all() as $item) {
            $item->delete();
        }
    }
}
