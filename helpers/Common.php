<?php

/**
 * Common Helper Functions
 *
 * PHP Version 5.3
 * 
 * @category  Helpers
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2012 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.carltonsoftware.co.uk
 */
 
/**
 * Function to generate a json response
 *
 * @param array $responseArray The array to encode as json
 *
 * @return void
 */
function generateResponse($responseArray) 
{
    if (function_exists('json_encode')) {
        die(json_encode($responseArray));
    } else {
        die("json_encode function does not exist");
    }   
}


/**
 * Function to get a included file stream
 *
 * @param string $filename    The path to the file
 * @param mixed  $objectArray Any object you want to pass by reference
 *
 * @return mixed
 */
function getIncludeContents($filename, $objectArray = array())
{
    if (is_file($filename)) {
        ob_start();
        include $filename;
        return ob_get_clean();
    }
    return false;
}

/**
* Function used to check a global variable and return a default if not
* 
* @param string $global  the string of the global you want to check
* @param string $default the string of the default you want to use
* 
* @return string
*/
function checkGlobal($global, $default)
{
    $constants = get_defined_constants(true);
    $userconstants = $constants['user'];    
    if (checkArrayKeyExistsAndHasAValue($constants, $global, "")) {
        return $userconstants[$global];
    } else {
        return $default;
    }
}

/**
 * Function used to test the validity of an array
 * 
 * @param array $array the array to check
 * 
 * @return boolean
 */
function checkArray($array) 
{
    if (is_array($array)) {
        if (count($array) > 0) {
            return true;
        }
    }
    return false;
}

/**
 * Function used to assign a variable a valur if it exists in an array 
 * else, assign failed value
 * 
 * @param array  $array            the array to validate
 * @param string $key              the key to check exisitence
 * @param string $failed_key_value the value to use if check has failed
 * 
 * @return boolean
 */
function assignArrayValue($array, $key, $failed_key_value)
{
    if (checkKeyExists($array, $key)) {
        return $array[$key];
    } else {
        return $failed_key_value;
    }
}

/**
 * Function used to test to see a key is in an array and has a specific value
 * 
 * @param array  $array     the array to validate
 * @param string $key       the key to check exisitence
 * @param string $key_value the comparison value
 * 
 * @return boolean
 */
function checkArrayKeyExistsAndHasAValue($array, $key, $key_value)
{
    if (checkKeyExists($array, $key)) {
        return ($array[$key] == $key_value);
    }
    
    return false;
}

/**
 * Function used to test to see a key is in an array and is greater then a 
 * certain string length
 * 
 * @param array  $array      the array to validate
 * @param string $key        the key to check exisitence
 * @param string $min_length the min length comparison value
 * @param string $max_length the max length comparison value
 * 
 * @return boolean
 */
function checkArrayKeyExistsAndIsGreaterThanLength(
    $array, 
    $key, 
    $min_length = 0, 
    $max_length = 0
) {
    if (checkKeyExists($array, $key)) {
        if (strlen($array[$key]) > $min_length) {
            if ($max_length > 0) {
                return (strlen($array[$key]) < $max_length);
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
    
    return false;
}


/**
 * Function used to test to see a key is in an array
 * 
 * @param array  $array the array to validate
 * @param string $key   the key to check existence
 * 
 * @return boolean
 */
function checkKeyExists($array, $key)
{
    return isset($array[$key]);
}

/**
 * Function used to save a flash message
 *
 * @param string $status  The status/class you was temporarily saved
 * @param string $message The message you was temporarily saved
 * 
 * @return void
 */
function saveFlashMessage($status, $message)
{
    @session_start();
    $_SESSION['flash_status'] = $status;
    $_SESSION['flash'] = $message;
}

/**
 * Function used to save a flash message
 *
 * @return string
 */
function getFlashMessage()
{
    @session_start();
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    } else {
        return "";
    }
}

/**
 * Function used to save a flash message
 *
 * @return string
 */
function getFlashStatus()
{
    @session_start();
    if (isset($_SESSION['flash_status'])) {
        $flash_status = $_SESSION['flash_status'];
        unset($_SESSION['flash_status']);
        return $flash_status;
    } else {
        return "";
    }
}

/**
 * Function used to save a flash status message
 *
 * @return string
 */
function getFlashStatusMessage()
{
    $flash_status = getFlashStatus();
    $flash_message = getFlashMessage();
    
    if ($flash_status != "" && $flash_message != "") {
        return sprintf(
            '<div id="status-message" class="alert alert-block %s">
                <button type="button" class="close" data-dismiss="alert">×</button>
                %s
            </div>',
            $flash_status,
            $flash_message
        );
    } else {
        return "";
    }
}

if (!function_exists('redirect')) {
    /**
     * Header Redirect
     *
     * Header redirect in two flavors
     * For very fine grained control over headers, you could use the Output
     * Library's set_header() function.
     * 
     * @param string  $uri      the URL
     * @param string  $method   the method: location or redirect
     * @param integer $httpCode HTTP Response code to be used
     *
     * @access public
     * 
     * @return string
     */
    function redirect($uri = '', $method = 'location', $httpCode = 302)
    {
        if (!headers_sent()) {
            switch($method) {
            case 'refresh': 
                header("Refresh:0;url=" . $uri);
                break;
            default: 
                header("Location: " . $uri, true, $httpCode);
                break;
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.$uri.'";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url='.$uri.'" />';
            echo '</noscript>';
        }
        exit;
    }
}

/**
 * Return the full http path of the script
 * 
 * @param string $fileName File name
 * 
 * @return string 
 */
function getAbsPath($fileName)
{
    $requestUri = explode('?', $_SERVER['REQUEST_URI'], 2);
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $protocol = substr(
        strtolower($_SERVER["SERVER_PROTOCOL"]), 
        0, 
        strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")
    ) . $s;
    
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    
    return $protocol . "://" . $_SERVER['SERVER_NAME'] . 
            $port . str_replace($fileName, "", $requestUri[0]);
}

/**
 * Function to output a url with a prepended ROOTURL
 * 
 * @param string  $url    Url
 * @param boolean $return Return or echo, default to echo
 * 
 * @return void
 */
function _u($url, $return = false)
{
    if (defined('ROOTURL')) {
        _e(trim(ROOTURL, '/') . '/' . trim($url, '/'), $return);
    } else {
        _e(trim($url, '/'), $return);
    }
}

/**
 * Echo function
 * 
 * @param string  $str    String to output
 * @param boolean $return Return or echo, default to echo
 * 
 * @return void
 */
function _e($str, $return = false)
{
    if ($return) {
        return $str;
    } else {
        echo $str;
    }
}

/**
 * Check whether a request is an ajax request or not
 * 
 * @return boolean
 */
function isAjaxRequest()
{
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        return strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    
    return false;
}

/**
 * Update a customer based on a given array of key/value pairs
 *
 * @param \Person &$person API Person Object
 * @param array   $data    Key/Value array of data which has been
 *                         validated already
 *
 * @return void
 */
function updatePersonObject(&$person, $data)
{
    // Set the customer main fields
    foreach ($data as $key => $val) {
        $func = "set" . ucfirst($key);
        if ($val != "") {
            // Set the email optin boolean
            if ($key == 'emailOptIn') {
                $val = true;
            }
            // Set the customer data
            if (method_exists($person, $func)) {
                $person->$func($val);
            }
            // Set Customer address fields
            if (method_exists($person->getAddress(), $func)) {
                $person->getAddress()->$func($val);
            }
        }
    }
}

/**
 * Slug builder, sanitises arguments and returns slug format
 *
 * @param string $string String to slugify
 *
 * @return string
 */
function slugify($string)
{
    $string = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $string);
    $string = strtolower(trim($string, '-'));
    $string = preg_replace("/[\/_|+ -]+/", '-', $string);
    return $string;
}

/**
 * Simple language replacement
 * 
 * @param string $string    Language sentance to check and output if no 
 * replacements are found.
 * @param string $lang      Language
 * @param array  $langArray Array of language replacements
 * 
 * @return string 
 */
function lang($string, $lang = 'EN', $langArray = array())
{
    if (array_key_exists($lang, $langArray)) {
        if (is_array($langArray[$lang]) 
            && array_key_exists($string, $langArray[$lang])
        ) {
            return $langArray[$lang][$string];
        }
    }
    return $string;
}