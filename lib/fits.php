<?php
// fits.php
// The fits class collects all functions needed to read the metadata from fits files.

class Fits
{
  public function getHeader($filename) {
    global $objMetadata, $ftp_server;

    // We make a connection to the ftp server
          $handle = fopen("ftp://anonymous:'wim.demeester@ster.kuleuven.be'@" . $ftp_server . "/miri/CDP/" . $filename, "r");

          $toReturn = array();
          
          if($handle) {
            $end = false;
            $keys = $objMetadata->getKeys();
          
            while (!$end) {
              // This loops over the header, till we reach END in the fits file.
              $buffer = fgets($handle, 81);
              // Process buffer here..
              if (strpos($buffer, "END") === 0) {
                $end = true;
              } else {
                $fitsValue = explode("=", $buffer);
                $keyword = explode(" ", $fitsValue[0])[0];
                $value = rtrim(ltrim(explode("/", $fitsValue[1])[0]));

                $value = str_replace("'", "", $value);

                // Check in the database which keywords can be used and only add this metadata to the array to return
                foreach ($keys as $key) {
                  if ($keyword == $key["id"]) {
                    $toReturn[$keyword] = $value;
                  }
                }
              }
            }
            @fclose($handle);
          } else {
            $entryMessage = "Problem reading fits file!";
            return;
          }
        return $toReturn;
  }
}
?>