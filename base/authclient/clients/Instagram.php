<?php
/**
 * Instagram.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\authclient\clients;

/**
 * Class Instagram
 * @package cookyii\authclient\clients
 */
class Instagram extends \yii\authclient\OAuth2
{
    /**
     * @inheritdoc
     */
    public $authUrl = 'https://api.instagram.com/oauth/authorize';
    /**
     * @inheritdoc
     */
    public $tokenUrl = 'https://api.instagram.com/oauth/access_token';
    /**
     * @inheritdoc
     */
    public $apiBaseUrl = 'https://api.instagram.com/v1';
    /**
     * @inheritdoc
     */
    public $scope;

    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        $response = $this->api('users/self', 'GET');

        return empty($response) ? null : $response['data'];
    }

    /**
     * @inheritdoc
     */
    protected function defaultName()
    {
        return 'instagram';
    }

    /**
     * @inheritdoc
     */
    protected function defaultTitle()
    {
        return 'Instagram';
    }

    /**
     * @inheritdoc
     */
    protected function defaultViewOptions()
    {
        return [
            'popupWidth' => 860,
            'popupHeight' => 480,
        ];
    }
}