<?php

namespace TerraMonitoring\Web;

use TerraMonitoring\Web\Application;

class ApplicationTest extends \PHPUnit_Framework_TestCase {
  /**
   * @test
   */
  public function classExists() {
    self::assertInstanceOf(Application::class, new Application());
  }
}
