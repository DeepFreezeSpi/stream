<?php
namespace DeepFreezeSpi\IO\Stream;

/**
 * Interface StreamReaderInterface
 *
 * Stream Reader Interface.
 *
 * This provides a basic framework for reading from a stream
 * @package DeepFreezeSpi\IO\Stream
 */
interface StreamReaderInterface
{
  /**
   * Returns the underlying stream that is being Read.
   *
   * Manipulating the base stream will lead to undefined behaviour in Readers.
   *
   * If changes to the underlying stream is required (such as re-reading the base stream)
   * then one should call flush() to purge the reader's internal buffers.
   *
   * @see flush()
   * @return StreamInterface
   */
  public function getBaseStream();


  /**
   * Has the end of stream been reached.
   *
   * @return bool
   */
  public function isEndOfStream();


  /**
   * Dispose of the current stream, and its allocated resources.
   *
   * @return void
   */
  public function dispose();


  /**
   * Flush any internal buffers.
   *
   * For readers, empty any internal buffered data, so that subsequent read calls should
   * re-populate the buffer.  This is generally the use-case if the underlying stream
   * cursor has been moved.
   *
   * @return void
   */
  public function flush();


  /**
   * Read characters from the underlying stream.
   *
   * Implementation note: this operates on characters, the underlying stream will operate
   * on a byte level.  For an equivalent of a binary reader, the text encoding should be
   * an equivalent to "8-bit".
   *
   * Readers MUST ensure that no invalid characters are ever
   * returned.  An example of this, using UTF-8, is to ensure that no code-point is
   * spliced (such as surrogate characters), and that no invalid sequences are returned
   * (they should be replaced by a fallback character, U+FFFD for instance.)
   *
   * Readers MAY return less than the requested length of characters.  This is often the case
   * for reaching end-of-stream, or if additional data is not available.
   *
   * If there is no further data to be read, readers SHOULD return NULL, but MAY return an
   * empty string.
   *
   * @param int $maxLength
   * @return string
   */
  public function read($maxLength = 1);


  /**
   * Read characters from the underlying stream until a line separator is reached.
   *
   * The returned string MUST NOT include the line separator in the returned value.
   * The line separator MUST be consumed from the underlying stream.
   *
   * Other restrictions of read() must be followed.
   * @return string
   */
  public function readLine();
}
