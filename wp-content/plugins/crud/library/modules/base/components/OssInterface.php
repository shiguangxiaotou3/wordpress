<?php


namespace crud\modules\base\components;


interface OssInterface
{

    public function getBucket();
    /**
     * 判断存储空间是否存在
     * @param $bucketName
     * @return bool
     */
    public function isBucketExist($bucketName);

    /**
     * 存储空间 存储信息
     * @param $bucketName
     * @return array|false
     */
    public function getBucketStat($bucketName);

    /**
     * 创建存储空间
     * @param $bucketName
     * @param string $aclType
     * @param array $options
     * @return null
     */
    public function createBucket($bucketName,$aclType,$options);

    /**
     * 删除存储空间
     * @param $bucketName
     * @return null
     */
    public function deleteBucket($bucketName);

    /**
     * 获取存储空间 访问权限
     * @param $bucketName
     * @return false|string
     */
    public function getBucketAcl($bucketName);

    /**
     * 设置存储空间 访问权限
     * @param $bucketName
     * @param $authorization
     * @return false|null
     */
    public function setBucketAcl($bucketName,$authorization);

    /**
     * 存储空间 添加标签
     * @param $bucketName
     * @param $tags
     * @return false|null
     */
    public function addBucketTag($bucketName,$tags);

    /**
     * 获取存储空间标签
     * @param $bucketName
     * @return mixed
     */
    public function getBucketTag($bucketName);

    /**
     * 删除获取存储空间所有标签
     * @param $bucketName
     * @return mixed
     * @throws OssException
     */
    public function deleteBucketTagAll($bucketName);

    /**
     * 删除获取存储空间所有标签
     * @param $bucketName
     * @param $tags
     * @return mixed
     * @throws OssException
     */
    public function deleteBucketTags($bucketName,$tags);

    /**
     * 上传文件
     * @param $bucketName
     * @param $path
     * @param $filePath
     */
    public function uploadFile($bucketName, $path, $filePath);

    /**
     * @param $bucketName
     * @param $path
     * @param $filePath
     * @throws OssException
     */
    public function multipartUpload($bucketName, $path, $filePath);

    /**
     * 分片上传目录
     * @param $bucketName
     * @param $prefix
     * @param $localDir
     */
    public function uploadDir($bucketName, $prefix, $localDir);
}