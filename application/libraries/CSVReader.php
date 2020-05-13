<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CSVReader {

    var $fields;/** columns names retrieved after parsing */
    var $separator = ';';/** separator used to explode each line */
    var $enclosure = '"';/** enclosure used to decorate each field */
    var $max_row_size = 4096;/** maximum row size to be used for decoding */

    function parse_file($p_Filepath) {
        $file = fopen($p_Filepath, 'r');
        $this->fields = fgetcsv($file, $this->max_row_size, $this->separator, $this->enclosure);

        $keys = str_getcsv($this->fields[0]);
        // $buffer = fgets($file, $this->max_row_size);
        $i = 1;
        while (($row = fgetcsv($file, $this->max_row_size, $this->separator, $this->enclosure)) != false) {
            if ($row != null) { // skip empty lines
                $values = str_getcsv($row[0]);
                if (count($keys) == count($values)) {
                    $arr = array();
                    for ($j = 0; $j < count($keys); $j++) {
                        if ($keys[$j] != "") {
                            // $buffer = $this->autoUTF($values[$j]);

                            /* if ($keys[$j] == "admission_date(dd-mm-yyyy)" || $keys[$j] == "dob(dd-mm-yyyy)") {
                              $search = "(dd-mm-yyyy)";
                              $trimmed = str_replace($search, '', $keys[$j]);
                              $arr[$trimmed] = date('Y-m-d', strtotime($values[$j]));
                              } else {
                              $arr[$keys[$j]] = $values[$j];
                              // $arr[$keys[$j]] = $this->autoUTF($values[$j]);
                              } */
                            $arr[$keys[$j]] = $values[$j];
                        }
                    }
                    $content[$i] = $arr;
                    $i++;
                }
            }
        }
        fclose($file);
        return $content;
    }

    public function fgetcsvUTF8($handle, $length = 4096, $separator = ';') {
        $handler = fopen($handle, "r");
        if (($buffer = fgets($handler, $length)) !== false) {
            $buffer = $this->autoUTF($buffer);
            $keys = str_getcsv('Name');
            while (($row = fgetcsv($handler, 2, $separator, '"')) != false) {
                //  $r =  str_getcsv($buffer, $separator);
                // return $r[0];
                if ($row != null) { // skip empty lines
                    $values = str_getcsv($row[0]);
                    if (count($keys) == count($values)) {
                        $arr = array();
                        for ($j = 0; $j < count($keys); $j++) {
                            if ($keys[$j] != "") {
                                /*  if ($keys[$j] == "admission_date(dd-mm-yyyy)" || $keys[$j] == "dob(dd-mm-yyyy)") {
                                  $search = "(dd-mm-yyyy)";
                                  $trimmed = str_replace($search, '', $keys[$j]);
                                  $arr[$trimmed] = date('Y-m-d', strtotime($values[$j]));
                                  } else {
                                  $arr[$keys[$j]] = $values[$j];
                                  } */
                                $arr[$keys[$j]] = $values[$j];
                            }
                        }
                        $content[$i] = $arr;
                        $i++;
                    }
                }
            }
            return $content;
        }
        return false;
    }

    /**
     * automatic convertion windows-1250 and iso-8859-2 info utf-8 string
     *
     * @param   string  $s
     *
     * @return  string
     */
    private function autoUTF($s) {
        // detect UTF-8
        if (preg_match('#[\x80-\x{1FF}\x{2000}-\x{3FFF}]#u', $s))
            return $s;

        // detect WINDOWS-1250
        if (preg_match('#[\x7F-\x9F\xBC]#', $s))
            return iconv('WINDOWS-1250', 'UTF-8', $s);

        // assume ISO-8859-2
        return iconv('ISO-8859-2', 'UTF-8', $s);
    }

}

?>