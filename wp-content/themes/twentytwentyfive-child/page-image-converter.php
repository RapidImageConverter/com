<?php
/**
 * Template Name: Image Converter
 *
 * A custom page template that allows users to upload up to 10 images and convert them
 * to various formats using Imagick (if available) or the GD library.
 */
get_header();
?>

<div class="image-converter-wrapper">
  <h1>Image Converter</h1>
  <form method="post" enctype="multipart/form-data">
    <?php wp_nonce_field('image_converter_action', 'image_converter_nonce'); ?>
    <label for="ic_images">Select up to 10 images:</label>
    <input type="file" name="ic_images[]" id="ic_images" accept="image/*" multiple required>
    <br>
    <label for="ic_format">Choose output format:</label>
    <select name="ic_format" id="ic_format">
      <option value="png">PNG</option>
      <option value="jpg">JPG</option>
      <option value="gif">GIF</option>
      <option value="bmp">BMP</option>
      <option value="tiff">TIFF</option>
      <option value="webp">WEBP</option>
    </select>
    <br>
    <input type="submit" name="ic_submit" value="Convert Images">
  </form>

  <?php
  if ( isset($_POST['ic_submit']) && check_admin_referer('image_converter_action', 'image_converter_nonce') ) {
      $output_format = sanitize_text_field($_POST['ic_format']);
      $allowed_formats = array('png', 'jpg', 'gif', 'bmp', 'tiff', 'webp');
      if ( !in_array($output_format, $allowed_formats) ) {
          echo '<p>Invalid output format selected.</p>';
      } else {
          $files = $_FILES['ic_images'];
          $num_files = count($files['name']);
          if ( $num_files > 10 ) {
              echo '<p>You can upload up to 10 images only.</p>';
          } else {
              echo '<div class="conversion-results">';
              for ( $i = 0; $i < $num_files; $i++ ) {
                  if ( $files['error'][$i] === UPLOAD_ERR_OK ) {
                      $tmp_name = $files['tmp_name'][$i];
                      $original_name = sanitize_file_name($files['name'][$i]);
                      $new_name = pathinfo($original_name, PATHINFO_FILENAME) . '.' . $output_format;
                      $upload_dir = wp_upload_dir();
                      $target_dir = trailingslashit($upload_dir['basedir']) . 'image-converter/';
                      if ( !file_exists($target_dir) ) {
                          wp_mkdir_p($target_dir);
                      }
                      $target_path = $target_dir . $new_name;
                      
                      // Use Imagick if available
                      if ( extension_loaded('imagick') ) {
                          try {
                              $img = new Imagick($tmp_name);
                              $img->setImageFormat($output_format);
                              $img->writeImage($target_path);
                              $img->clear();
                              $img->destroy();
                              echo '<p>Converted: ' . esc_html($original_name) . ' → <a href="' . esc_url(trailingslashit($upload_dir['baseurl']) . 'image-converter/' . $new_name) . '" target="_blank">' . esc_html($new_name) . '</a></p>';
                          } catch ( Exception $e ) {
                              echo '<p>Error converting ' . esc_html($original_name) . ': ' . esc_html($e->getMessage()) . '</p>';
                          }
                      } else {
                          // Fallback to GD Library for JPEG, PNG, GIF.
                          $img_info = getimagesize($tmp_name);
                          if ( $img_info === false ) {
                              echo '<p>Invalid image file: ' . esc_html($original_name) . '</p>';
                              continue;
                          }
                          switch ( $img_info[2] ) {
                              case IMAGETYPE_JPEG:
                                  $source = imagecreatefromjpeg($tmp_name);
                                  break;
                              case IMAGETYPE_PNG:
                                  $source = imagecreatefrompng($tmp_name);
                                  break;
                              case IMAGETYPE_GIF:
                                  $source = imagecreatefromgif($tmp_name);
                                  break;
                              default:
                                  echo '<p>Unsupported image type: ' . esc_html($original_name) . '</p>';
                                  continue 2;
                          }
                          if ( !$source ) {
                              echo '<p>Failed to process image: ' . esc_html($original_name) . '</p>';
                              continue;
                          }
                          switch ( $output_format ) {
                              case 'jpg':
                                  $result = imagejpeg($source, $target_path, 90);
                                  break;
                              case 'png':
                                  $result = imagepng($source, $target_path);
                                  break;
                              case 'gif':
                                  $result = imagegif($source, $target_path);
                                  break;
                              default:
                                  echo '<p>GD conversion for format ' . esc_html($output_format) . ' is not supported.</p>';
                                  imagedestroy($source);
                                  continue 2;
                          }
                          imagedestroy($source);
                          if ( $result ) {
                              echo '<p>Converted: ' . esc_html($original_name) . ' → <a href="' . esc_url(trailingslashit($upload_dir['baseurl']) . 'image-converter/' . $new_name) . '" target="_blank">' . esc_html($new_name) . '</a></p>';
                          } else {
                              echo '<p>Error converting ' . esc_html($original_name) . '</p>';
                          }
                      }
                  } else {
                      echo '<p>Error uploading file: ' . esc_html($files['name'][$i]) . '</p>';
                  }
              }
              echo '</div>';
          }
      }
  }
  ?>
</div>

<!-- Inline CSS for styling the page -->
<style>
.image-converter-wrapper {
  max-width: 800px;
  margin: 40px auto;
  padding: 40px;
  background: #ffffff;
  border: 1px solid #ddd;
  border-radius: 8px;
  text-align: center;
  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
}
.image-converter-wrapper h1 {
  font-size: 2.5rem;
  margin-bottom: 20px;
  color: #333;
}
.image-converter-wrapper form {
  margin-bottom: 30px;
}
.image-converter-wrapper label {
  font-size: 1.2rem;
  color: #555;
  margin: 10px 0;
}
.image-converter-wrapper input[type="file"],
.image-converter-wrapper select,
.image-converter-wrapper input[type="submit"] {
  width: 100%;
  max-width: 400px;
  padding: 10px;
  margin: 10px auto;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.image-converter-wrapper input[type="submit"] {
  background-color: #0073aa;
  color: #fff;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s ease;
}
.image-converter-wrapper input[type="submit"]:hover {
  background-color: #005177;
}
.conversion-results p {
  font-size: 1.1rem;
  color: #333;
  margin: 15px 0;
}
.conversion-results a {
  color: #0073aa;
  text-decoration: none;
  font-weight: bold;
}
.conversion-results a:hover {
  text-decoration: underline;
}
</style>

<?php get_footer(); ?>
