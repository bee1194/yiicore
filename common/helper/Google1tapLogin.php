<?php

namespace common\helper;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\httpclient\Client;

/**
 * Class Google1tapLogin
 * @package common\helper
 */
class Google1tapLogin extends Action
{

    const STATUS_RESPONSE_OK = 200;

    public $successCallback;

    public $urlToken = 'https://oauth2.googleapis.com/tokeninfo';

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $this->controller->enableCsrfValidation = FALSE;
        $this->httpClient = new Client();
        parent::init();
    }

    /**
     * @return \yii\web\Response
     * @throws InvalidConfigException
     * @throws \Exception
     */
    public function run()
    {
        $post = Yii::$app->request->post();
        $credential = $post['credential'] ?? '';
        $g_csrf_token = $post['g_csrf_token'] ?? '';
        if ($credential) {
            /** @var yii\httpclient\Response $response */
            $response = $this->httpClient->createRequest()
                ->setUrl($this->urlToken)
                ->setMethod('GET')
                ->setData(['id_token' => $credential])
                ->send();
            if ($response->statusCode == self::STATUS_RESPONSE_OK) {
                try {
                    $client = Json::decode($response->content);

                    return $this->authSuccess($client);
                } catch (\Exception $exception) {
                    throw $exception;
                }
            }
        }

        return $this->controller->goHome();
    }

    /**
     * @param $client
     *
     * @return mixed
     * @throws InvalidConfigException
     */
    protected function authSuccess($client)
    {
        if (!is_callable($this->successCallback)) {
            throw new InvalidConfigException('"' . get_class($this) . '::$successCallback" should be a valid callback.');
        }

        return call_user_func($this->successCallback, $client);
    }
}
