<?php
class getAdvertisementById {
  protected $postingTargetId;
  protected $langCode;

  function __construct( $postingTargetId, $langCode ) {
    $this->postingTargetId = $postingTargetId;
    $this->langCode = $langCode;
  }
}