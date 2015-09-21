<?php
namespace DeepFreezeSpi\IO\Stream;

/**
 * Interface StreamWriterInterface
 *
 * Stream Writing Interface.
 *
 * This provides a basic framework for writing from a stream.
 * @package DeepFreezeSpi\IO\Stream
 */
interface StreamWriterInterface
{
  /**
   * Returns the underlying stream that is being Written.
   *
   * Manipulating the base stream will lead to undefined behaviour in Readers.
   *
   * If changes to the underlying stream is required then one should call flush() to
   * flush any internal write buffers to the underlying stream.
   *
   * @see flush()
   * @return StreamInterface
   */
  public function getBaseStream();


  /**
   * Dispose of the current stream, and its allocated resources.
   *
   * @return void
   */
  public function dispose();


  /**
   * Flush any internal buffers.

   * For writers, this usually implies writing any buffered data to the underlying stream.
   *
   * @return void
   */
  public function flush();


  /**
   * Write characters from the underlying stream.
   *
   * Implementation note: this operates on characters, the underlying stream will operate
   * on a byte level.  For an equivalent of a binary writer, the text encoding should be
   * an equivalent to "8-bit".
   *
   * Writers MUST ensure that no invalid characters are ever written.  An example of this,
   * using UTF-8, is to ensure that no code-point is spliced (such as surrogate characters),
   * and that no invalid sequences are written (they should be replaced by a fallback
   * character, U+FFFD for instance.)
   *
   * @param string $content
   * @return void
   */
  public function write($content='');


  /**
   * Write characters to the underlying stream, appending a line-separator.
   *
   * The written string MUST include the line separator.
   *
   * Other restrictions of write() must be followed.
   *
   * @param string $content Content to write to the underlying stream.
   * @return void
   */
  public function writeLine($content='');
}
