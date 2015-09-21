<?php
namespace DeepFreezeSpi\IO\Stream;

/**
 * Interface StreamInterface
 *
 * Stream Interface.
 *
 * Based upon compatibility with MSDN Streams.
 *
 * This is a low level stream interface, and is generally not meant to be used directly in end-user
 * applications.  Reader and Writer classes should be used more generally, and to provide a more
 * convenient-to-use interface.
 *
 * @package DeepFreezeSpi\IO\Stream
 */
interface StreamInterface
{
  /**
   * File Mode: Append.
   * Writes are always appended to the end of the file, regardless of the internal file pointer.
   * If the file does not exist, it will be created.
   */
  const MODE_APPEND = 'append';
  /**
   * If the file exists, it will be truncated.
   * If the file does not exist, it will be created.
   * This is the equivalent to CREATE_NEW or TRUNCATE.
   */
  const MODE_CREATE = 'create';
  /**
   * If the file does not exist, it will be created.
   * If the file exists, throws FileExistsException.
   */
  const MODE_CREATE_NEW = 'create-new';
  /**
   * If the file does not exist, throw FileNotFoundException
   */
  const MODE_OPEN = 'open';
  /**
   * If the file does not exist, it will be created.
   * The semantics for this does not exist natively within PHP.
   * The main difference, is that if a file is opened as READ_ONLY,
   * and the requested file does not exist, the file will be created, and then
   * opened for READ access.  (The file contents would thus be empty)
   */
  const MODE_OPEN_OR_CREATE = 'open-create';
  /**
   * If the file exists, the file will be truncated..
   * If the file does not exist, throw FileNotFoundException.
   * This file mode requires WRITE access.
   */
  const MODE_TRUNCATE = 'truncate';
  /**
   * Request Read Access
   */
  const ACCESS_READ = 'read';
  /**
   * Request Read-Write Access
   */
  const ACCESS_READ_WRITE = 'read-write';
  /**
   * Request Write Access
   */
  const ACCESS_WRITE = 'write';
  /**
   * Seek relative to the current stream pointer.
   */
  const SEEK_CURRENT = 'current';
  /**
   * Seek relative to the beginning of the current stream.
   */
  const SEEK_ORIGIN = 'origin';
  /**
   * Seek relative from the end of the stream.
   */
  const SEEK_END = 'end';


  /**
   * Is the stream able to be read from.
   * @return bool
   */
  public function canRead();


  /**
   * Is the stream-pointer able to be adjusted.
   *
   * @return bool
   */
  public function canSeek();


  /**
   * Is the stream able to timeout.
   * @return bool
   */
  public function canTimeout();


  /**
   * Is the stream able to be written to.
   * @return bool
   */
  public function canWrite();


  /**
   * Return the length of the stream contents, in bytes.
   * If the length is unknown or indeterminate, this method will return NULL.
   *
   * @return int|null Length of the stream, NULL if unknown.
   */
  public function getLength();


  /**
   * Return the current position of the stream pointer, as on offset in bytes.
   *
   * If the stream is seekable, this method MUST return a value that is usable in subsequent seek()
   * operations.
   *
   * If the steam is not seekable, this method MAY return a value for informational purposes only.
   *
   * @return int|null current pointer within the stream, NULL if unknown.
   */
  public function getPosition();


  /**
   * Set the read timeout to the specified value, in milliseconds.
   *
   * If the stream does not support timeout, this method SHOULD throw an exception.
   *
   * @throws Exception\InvalidOperationException
   * @param int $ms
   * @return void
   */
  public function setReadTimeout($ms);


  /**
   * The current read timeout, in ms.
   *
   * If the stream does not support Timeout values, this method MUST return NULL.
   *
   * @return int|null
   */
  public function getReadTimeout();


  /**
   * Set the write timeout to the specified value, in milliseconds.
   *
   * If the stream does not support Timeout values, this method MUST throw an exception.
   *
   * @throws Exception\InvalidOperationException
   * @param int $ms
   * @return void
   */
  public function setWriteTimeout($ms);


  /**
   * The current write timeout, in milliseconds.
   *
   * If the stream does not support Timeout values, this method MUST return NULL.
   *
   * @return int|null
   */
  public function getWriteTimeout();


  /**
   * Reads bytes from the current stream, and writes them to another stream.
   *
   * @param StreamInterface $destination Stream to which the contents of the current stream will
   *          be copied.
   * @param int $bufferSize Buffer size to use in copying streams. Leave NULL, to use the default
   *          value.
   *
   * @throws Exception\NotSupportedException If the current stream does not support reading, or
   *         if the destination stream does not support writing.
   * @throws Exception\ObjectDisposedException If the current, or destination stream has been
   *         disposed before this call.
   * @throws Exception\ExceptionInterface Unspecified I/O Exception occurred.
   *
   * @return void
   */
  public function copyTo(StreamInterface $destination, $bufferSize = null);


  /**
   * Dispose of the current stream, and its allocated resources.
   *
   * @return void
   */
  public function dispose();


  /**
   * Clears all buffers for this stream.
   * Any buffered data pending to be written to the underlying device.

   * @return void
   */
  public function flush();


  /**
   * Reads a sequence of bytes from the stream.
   *
   * The read operation will advance the the position within the stream by the number of bytes read.
   *
   * This method SHOULD return NULL, but MAY return an Empty String (""), if the end-of-stream is reached.
   *
   * If an exception occurs, the current position within the stream SHOULD remains unchanged.
   *
   * The implementation will block until at least one byte can be read from the stream.
   *
   * This method will return a zero-length response (NULL or ""), only when there is no data in the
   * stream, and no more data is expected (such as a closed socket, or end-of-file).
   *
   * An implementation MAY return less than the requested number of bytes, even if the end-of-stream
   * has not ben reached.
   *
   * @param int $length The maximum number of bytes to read from the stream.
   *
   * @throws Exception\InvalidArgumentException If Count is zero or negative.
   * @throws Exception\NotSupportedException If the stream does not support reading.
   * @throws Exception\ObjectDisposedException If the stream has been disposed.
   * @throws Exception\ExceptionInterface If an unspecified I/O error occurs.
   * @return string Data read.
   */
  public function read($length);


  /**
   * Sets the position of the current stream.
   *
   * The value for $whence is one of the interface constants:
   *   - SEEK_ORIGIN
   *   - SEEK_CURRENT
   *   - SEEK_END
   *
   * Seeking to any location beyond the end of the stream is supported.
   * Seeking to a location beyond the beginning of the stream will result in an Exception.
   *
   * @param int $position
   * @param string $whence Reference point to use for the position.
   * @throws Exception\NotSupportedException If the stream does not support seeking.
   * @throws Exception\ObjectDisposedException If the stream has been disposed.
   * @throws Exception\ExceptionInterface If an unspecified I/O error occurs.
   * @return int The new position within the stream.
   */
  public function seek($position, $whence = null);


  /**
   * Set the length of the current stream.
   * If the length is less than the current length of the stream, the stream is truncated.
   *
   * If the length is greater than the current length of the stream, the stream is expanded.  In this
   * scenario, the content in the newly expanded section is undefined.
   *
   * @param int $length New length for the stream
   * @throws Exception\InvalidArgumentException If length is zero or negative.
   * @throws Exception\NotSupportedException If the stream does not support both writing and seeking.
   * @throws Exception\ObjectDisposedException If the stream has been disposed.
   * @throws Exception\ExceptionInterface If an unspecified I/O error occurs.
   * @return void
   */
  public function setLength($length);


  /**
   * Write data to the current stream.
   *
   * If an exception occurs, the position in the stream SHOULD remain unchanged.
   *
   * @param string $data
   * @param int $length
   * @throws Exception\InvalidArgumentException If length is negative.
   * @throws Exception\NotSupportedException If the stream does not support writing.
   * @throws Exception\ObjectDisposedException If the stream has been disposed.
   * @throws Exception\ExceptionInterface If an unspecified I/O error occurs.
   * @return void
   */
  public function write($data, $length = null);

}
