<?php

namespace App\Core;

use App\Mail\MailController;

class Container
{
  private $tool = [];
  private $produce = [];

  public function __construct()
  {
    $this->produce = [
      'mailController' => function () {
        return new MailController();
      },
    ];
  }

  public function make($name)
  {
    if (!empty($this->tool[$name])) {
      return $this->tool[$name];
    }

    if (isset($this->produce[$name])) {
      $this->tool[$name] = $this->produce[$name]();
    }

    return $this->tool[$name];
  }
}
