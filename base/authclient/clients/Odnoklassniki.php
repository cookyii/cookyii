<?php
/**
 * Odnoklassniki.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\authclient\clients;

/**
 * Class Odnoklassniki
 * @package cookyii\authclient\clients
 */
class Odnoklassniki extends \yii\authclient\OAuth2
{
    /**
     * @var string
     */
    public $applicationKey;
    /**
     * @inheritdoc
     */
    public $authUrl = 'http://www.odnoklassniki.ru/oauth/authorize';
    /**
     * @inheritdoc
     */
    public $tokenUrl = 'https://api.odnoklassniki.ru/oauth/token.do';
    /**
     * @inheritdoc
     */
    public $apiBaseUrl = 'http://api.odnoklassniki.ru';
    /**
     * @inheritdoc
     */
    public $scope = 'VALUABLE_ACCESS';

    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        return $this->api('api/users/getCurrentUser', 'GET');
    }

    /**
     * @inheritdoc
     */
    protected function defaultNormalizeUserAttributeMap()
    {
        return [
            'id' => 'uid',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function apiInternal($accessToken, $url, $method, array $params, array $headers)
    {
        $params['method'] = $this->getMethod($url);
        $params['access_token'] = $accessToken->getToken();
        $params['application_key'] = $this->applicationKey;

        $params['sig'] = $this->getSig($params['method'], $params['access_token']);

        return $this->sendRequest($method, $url, $params, $headers);
    }

    /**
     * @param $url
     * @return mixed
     */
    protected function getMethod($url)
    {
        $method = str_replace('api/', '', $url);
        $method = str_replace('/', '.', $method);

        return $method;
    }

    /**
     * @param $method
     * @param $access_token
     * @return string
     */
    protected function getSig($method, $access_token)
    {
        return md5('application_key=' . $this->applicationKey . 'method=' . $method . md5($access_token . $this->clientSecret));
    }

    /**
     * @inheritdoc
     */
    protected function defaultName()
    {
        return 'odnoklassniki';
    }

    /**
     * @inheritdoc
     */
    protected function defaultTitle()
    {
        return 'Odnoklassniki';
    }
}