<?php
require_once 'HttpRequest.php';
require_once 'Toot.php';

class MastodonClient_scholarsocial {

  /**
   * Mastodon Instance Name, like 'mastodon.social'
   * @var string
   */
  protected $domain;

  /**
   * HttpRequest_scholarsocial Instance
   * @var \HttpRequest_scholarsocial
   */
  protected $http;

  /**
   * Defaults headers for HttpRequest_scholarsocial
   * @var array
   */
  protected $headers = [
    'Content-Type' => 'application/json; charset=utf-8',
    'Accept'       => '*/*'
  ];

  /**
   * Credentials to use Mastodon API
   * @var array
   */
  protected $appCredentials = [];

  /**
   * Setting Domain, like 'mastodon.social'
   * @param string $domain
   */
  public function __construct($domain, $token) {
    $this->domain = $domain;

    $this->http = new HttpRequest_scholarsocial($this->domain);

    $this->appCredentials['bearer'] = $token;
    $this->headers['Authorization'] = $token;
  }

  /**
   * Post a new status
   *
   * Post a new status in Mastodon instance
   *
   * Return entire status as an array
   *
   * @param string $content Toot_scholarsocial content
   * @param string $visibility Toot_scholarsocial visibility (optionnal)
   * Values are :
   * - public
   * - unlisted
   * - private
   * - direct
   * @param array $medias Medias IDs
   * @return array
   */
  public function postStatus (Toot_scholarsocial $toot) {
    $body = [
      'visibility' => 'public'
    ];

    if ($toot->hasContentWarning()) {
      $body = array_merge($body, [
        'status' => $toot->getContentWarningText(),
        'spoiler_text' => $toot->getMainText()
      ]);
    } else {
      $body['status'] = $toot->getText();
    }

    return $this->http->post(
      $this->http->apiURL . 'statuses',
      $this->headers,
      $body
    );
  }
}
