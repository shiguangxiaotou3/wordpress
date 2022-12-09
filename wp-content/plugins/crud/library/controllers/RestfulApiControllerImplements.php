<?php


namespace crud\controllers;


interface RestfulApiControllerImplements
{

    /**
     * @return mixed
     */
    public function actionIndex();

    /**
     * 修改
     * @param $id
     * @return mixed
     */
    public function actionUpdate($id);

    /**
     * @param $id
     * @return mixed
     */
    public function actionView($id);

    /**
     * 创建
     * @param $id
     * @return mixed
     */
    public function actionCreate();

    /**
     * 查看支持的动词
     * @param string $id
     * @return mixed
     */
    public function actionOptions($id='');

    /**
     * 删除
     * @param $id
     * @return mixed
     */
    public function actionDelete($id);

}