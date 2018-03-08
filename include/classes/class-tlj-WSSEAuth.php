<?php
class tlj_WSSEAuth {
  private $Username;
  private $Password;

  function __construct($username, $password){
    $this->Username = $username;
    $this->Password = $password;
  }
}