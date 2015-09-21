<?php
namespace DeepFreezeSpi\IO\Stream\Exception;

interface InvalidArgumentException extends ExceptionInterface {
  /**
   * The name of the argument that is invalid.
   * @return string
   */
  public function getArgumentName();
}
