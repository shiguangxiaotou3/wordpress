<?php


namespace crud\modules\base\components;

use OSS\Model\Tag;
use OSS\OssClient;
use OSS\Core\OssUtil;
use yii\base\Component;
use OSS\Core\OssException;
use OSS\Model\TaggingConfig;



/**
 * 阿里云oss组件
 * @property $bucket 存储空间
 * @property $bucketList
 * @property OssClient $client
 * @package crud\modules\base\components
 */
class AliyuncsOss extends Component implements OssInterface
{

    public $accessKeyId;
    public $accessKeySecret;
    //访问域名
    public $endpoint;
    public $isCName = false;
    public $securityToken = NULL;
    public $requestProxy = NULL;

    private $_client;

    /**
     * 获取链接
     * @return OssClient
     */
    public function getClient()
    {
        if (!$this->_client) {
            $this->_client = new OssClient(
                $this->accessKeyId,
                $this->accessKeySecret,
                $this->endpoint,
                $this->isCName,
                $this->securityToken,
                $this->requestProxy
            );
        }
        return $this->_client;
    }

    /**
     * 设置链接
     * @param OssClient $client
     */
    public function setClient($client)
    {
        $this->_client = $client;
    }

    /**
     * 列举存储空间
     */
    public function getBucketList()
    {
        try {
            $bucketList = $this->client->listBuckets();
            $buckets = $bucketList->getBucketList();
            $results = [];
            foreach ($buckets as $bucket) {
                $results[] = [
                    //存储空间 区域
                    'location' => $bucket->getLocation(),
                    // 存储空间名称
                    "name" => $bucket->getName(),
                    //存储空间创建时间
                    'createDate' => $bucket->getCreatedate(),
                    // 存储空间类别
                    'storageClass' => $bucket->getStorageClass(),
                    // 存储空间外部网端点
                    'extranetEndpoint' => $bucket->getExtranetEndpoint(),
                    //存储空间内部网端点
                    'intranetEndpoint' => $bucket->getIntranetEndpoint(),
                    //区域
                    'region' => $bucket->getRegion()
                ];

            }
            return $results;

        } catch (OssException $e) {
            return false;
        }

    }

    /**
     * 判断存储空间是否存在
     * @param $bucketName
     * @return bool
     */
    public function isBucketExist($bucketName)
    {
        try {
            if ($this->client->doesBucketExist($bucketName)) {
                return true;
            }
            return false;
        } catch (OssException $e) {
            return false;
        }
    }

    public function getBucket()
    {
    }

    /**
     * 存储空间 存储信息
     * @param $bucketName
     * @return array|false
     */
    public function getBucketStat($bucketName)
    {
        try {
            $stat = $this->client->getBucketStat($bucketName);
            return [
                // 获取Bucket的总存储量，单位为字节。
                'storage' => $stat->getStorage(),
                // 获取Bucket中总的Object数量。
                'objectCount' => $stat->getObjectCount(),
                // 获取Bucket中已经初始化但还未完成（Complete）或者还未中止（Abort）的Multipart Upload数量。
                'multipartUploadCount' => $stat->getMultipartUploadCount(),
                // 获取Bucket中Live Channel的数量。
                'liveChannelCount' => $stat->getLiveChannelCount(),

                // 此次调用获取到的存储信息的时间点，格式为时间戳，单位为秒。
                'lastModifiedTime' => $stat->getLastModifiedTime(),

                // 获取标准存储类型Object的存储量，单位为字节。
                'standardStorage' => $stat->getStandardStorage(),
                // 获取标准存储类型的Object的数量。
                'standardObjectCount' => $stat->getStandardObjectCount(),

                // 获取低频访问类型Object的计费存储量，单位为字节。
                'infrequentAccessStorage' => $stat->getInfrequentAccessStorage(),
                // 获取低频访问类型Object的实际存储量，单位为字节。
                'infrequentAccessRealStorage' => $stat->getInfrequentAccessRealStorage(),
                // 获取低频访问类型的Object数量。
                'infrequentAccessObjectCount' => $stat->getInfrequentAccessObjectCount(),

                // 获取归档存储类型Object的计费存储量，单位为字节。
                'archiveStorage' => $stat->getArchiveStorage(),
                // 获取归档存储类型Object的实际存储量，单位为字节。
                'archiveDealStorage' => $stat->getArchiveRealStorage(),
                // 获取归档存储类型的Object数量。
                'archiveObjectCount' => $stat->getArchiveObjectCount(),
                // 获取冷归档存储类型Object的计费存储量，单位为字节。
                'coldArchiveStorage' => $stat->getColdArchiveStorage(),
                // 获取冷归档存储类型Object的实际存储量，单位为字节。
                'coldArchiveRealStorage' => $stat->getColdArchiveRealStorage(),
                // 获取冷归档存储类型的Object数量。
                'coldArchiveObjectCount' => $stat->getColdArchiveObjectCount(),
            ];
        } catch (OssException $e) {
            return false;
        }

    }

    /**
     * 创建存储空间
     * @param $bucketName
     * @param string $aclType
     * @param array $options
     * @return null
     */
    public function createBucket($bucketName, $aclType = 'private', $options = [])
    {
        // private 私有
        // public-read-write 公共读写：任何人
        // public-read 公共读
        $aclTypeArr = ['private', 'public-read-write', 'public-read'];
        if (!in_array($aclType, $aclTypeArr)) {
            $aclType = 'private';
        }
        $storageType = ['Standard', 'IA', 'Archive', 'ColdArchive'];

        if (!isset($options['storage']) or !in_array($options['storage'], $storageType)) {
            $options["storage"] = 'IA';
        }
        return $this->client->createBucket($bucketName, $aclType, $options);
    }

    /**
     * 删除存储空间
     * @param $bucketName
     * @return null
     */
    public function deleteBucket($bucketName)
    {
        return $this->client->deleteBucket($bucketName);
    }

    /**
     * 获取存储空间 访问权限
     * @param $bucketName
     * @return false|string
     */
    public function getBucketAcl($bucketName)
    {
        try {
            return $this->client->getBucketAcl($bucketName);
        } catch (OssException $e) {
            return false;
        }
    }

    /**
     * 设置存储空间 访问权限
     * @param $bucketName
     * @param $authorization
     * @return false|null
     */
    public function setBucketAcl($bucketName, $authorization)
    {
        try {
            return $this->client->putBucketAcl($bucketName, $authorization);
        } catch (OssException $e) {
            return false;
        }
    }

    /**
     * 存储空间 添加标签
     * @param $bucketName
     * @param $tags
     * @return false|null
     */
    public function addBucketTag($bucketName, $tags)
    {
        $config = new TaggingConfig();
        if (is_array($tags)) {
            foreach ($tags as $key => $value) {
                try {
                    $config->addTag(new Tag($key, $value));
                } catch (OssException $e) {
                    return false;
                }
            }
            try {
                return $this->client->putBucketTags($bucketName, $config);
            } catch (OssException $e) {
                return false;
            }
        }

    }

    /**
     * 获取存储空间标签
     * @param $bucketName
     * @return mixed
     */
    public function getBucketTag($bucketName)
    {
        try {
            $config = $this->client->getBucketTags($bucketName);
        } catch (OssException $e) {
            return false;
        }
        return $config->getTags();
    }

    /**
     * 删除获取存储空间所有标签
     * @param $bucketName
     * @return mixed
     * @throws OssException
     */
    public function deleteBucketTagAll($bucketName)
    {
        return $this->client->deleteBucketTags($bucketName);
    }

    /**
     * 删除获取存储空间所有标签
     * @param $bucketName
     * @param $tags
     * @return mixed
     * @throws OssException
     */
    public function deleteBucketTags($bucketName, $tags)
    {
        $tmp = array();
        if (is_array($tags)) {
            foreach ($tags as $key => $value) {
                $tmp[] = new Tag($key, $value);
            }
        }

        return $this->client->deleteBucketTags($bucketName, $tmp);
    }

    /**
     * 上传文件
     * @param $bucketName
     * @param $path
     * @param $filePath
     * @return null
     */
    public function uploadFile($bucketName, $path, $filePath)
    {
        try {
            return $this->client->uploadFile($bucketName, $path, $filePath);
        } catch (OssException $e) {
            [
                'code'=>$e->getCode(),
                'message'=>$e->getMessage(),
                'line'=>$e->getLine(),
                'file'=>$e->getFile(),
                'trace'=>$e->getTraceAsString()
            ];
            print_r($e).PHP_EOL;
        }
    }

    /**
     * @param $bucketName
     * @param $path
     * @param $filePath
     * @return false|null
     * @throws OssException
     */
    public function multipartUpload($bucketName, $path, $filePath)
    {
        /**
         *  步骤1：初始化一个分片上传事件，获取uploadId。
         */
        $uploadId = $this->client->initiateMultipartUpload($bucketName, $path);
        if($uploadId){
            /**
             * 步骤2：上传分片。
             */
            $partSize = 10 * 1024 * 1024;
            $uploadFileSize = filesize($filePath);
            $pieces = $this->client->generateMultiuploadParts($uploadFileSize, $partSize);
            $responseUploadPart = array();
            $uploadPosition = 0;
            $isCheckMd5 = true;
            foreach ($pieces as $i => $piece) {
                $fromPos = $uploadPosition + (integer)$piece[OssClient::OSS_SEEK_TO];
                $toPos = (integer)$piece[OssClient::OSS_LENGTH] + $fromPos - 1;
                $upOptions = array(
                    // 上传文件。
                    OssClient::OSS_FILE_UPLOAD => $filePath,
                    // 设置分片号。
                    OssClient::OSS_PART_NUM => ($i + 1),
                    // 指定分片上传起始位置。
                    OssClient::OSS_SEEK_TO => $fromPos,
                    // 指定文件长度。
                    OssClient::OSS_LENGTH => $toPos - $fromPos + 1,
                    // 是否开启MD5校验，true为开启。
                    OssClient::OSS_CHECK_MD5 => $isCheckMd5,
                );
                // 开启MD5校验。
                if ($isCheckMd5) {
                    $contentMd5 = OssUtil::getMd5SumForFile($filePath, $fromPos, $toPos);
                    $upOptions[OssClient::OSS_CONTENT_MD5] = $contentMd5;
                }
                try {
                    // 上传分片。
                    $responseUploadPart[] = $this->client->uploadPart($bucketName, $path, $uploadId, $upOptions);
                } catch (OssException $e) {

                    return false;
                }
            }
            // $uploadParts是由每个分片的ETag和分片号（PartNumber）组成的数组。
            $uploadParts = array();
            foreach ($responseUploadPart as $i => $eTag) {
                $uploadParts[] = array(
                    'PartNumber' => ($i + 1),
                    'ETag' => $eTag,
                );
            }
            /**
             * 步骤3：完成上传。
             */
            try {
                // 执行completeMultipartUpload操作时，需要提供所有有效的$uploadParts。OSS收到提交的$uploadParts后，
                //会逐一验证每个分片的有效性。当所有的数据分片验证通过后，OSS将把这些分片组合成一个完整的文件。
                return $this->client->completeMultipartUpload($bucketName, $path, $uploadId, $uploadParts);
            } catch (OssException $e) {
                return false;
            }
        }
    }

    /**
     * 分片上传目录
     * @param $bucketName
     * @param $prefix
     * @param $localDir
     * @return array|array[]
     */
    public function uploadDir($bucketName, $prefix, $localDir){
        try {
            return $this->client->uploadDir($bucketName, $prefix, $localDir);
        } catch (OssException $e) {

           echo  $e->getMessage() .PHP_EOL;
        }
    }
}