<?php

namespace WAG;

class API
{
    var $server;
    var $get;
    var $post;
    var $files;

    function init()
    {
        date_default_timezone_set('UTC');
        $this->server = $_SERVER;
        $this->get = $_GET;
        $this->post = $_POST;
        if (empty($this->post)) {
            $this->post = json_decode(file_get_contents('php://input'), true);
        }

        spl_autoload_register(function ($class_name) {
            $file_name = str_replace('\\', '/', $class_name);
            if (file_exists(SERVER_ROOT . $file_name . '.php')) {
                include_once SERVER_ROOT . $file_name . '.php';
            } else {
                throw new \Exception("There was an error finding this class name: {$class_name}");
            }
        });
        if (DEBUG) {
            error_reporting(E_ALL); // Development Level (development)
        }
        set_error_handler(array($this, 'api_error'));
    }
    function api_error($errno, $errstr, $errfile, $errline, $errcontext)
    {
        $message = "A PHP script error occurred.<br/>";
        $message .= "The error occurred in file '$errfile'<br/>";
        $message .= "on line $errline: $errstr<br/><br/>";
        $message .= "The page being viewed was: ". $_SERVER['REQUEST_URI'].'<br/>';
        if (isset($_SERVER['HTTP_REFERER']) && strlen($_SERVER['HTTP_REFERER']) > 0) {
            $message .= "The referring page was: " . $_SERVER['HTTP_REFERER'] . '<br/>';
        }
        if (isset($_SESSION['REMOTE_ADDR']) && strlen($_SESSION['REMOTE_ADDR']) > 0) {
            $message .= "The IP Address was: ". $_SESSION['REMOTE_ADDR'] . '<br/>';
        }
        $message .= "The errno was : " . $errno;
        if (DEBUG) {
            echo $message;
        } else {
            error_log($message, 1, ADMIN_EMAIL);
            switch ($errno) {
                case E_NOTICE:
                case E_USER_NOTICE:
                case E_DEPRECATED:
                case E_USER_DEPRECATED:
                case E_STRICT:
                    break;
                case E_WARNING:
                case E_USER_WARNING:
                    break;
                case E_ERROR:
                case E_USER_ERROR:
                    $warning = "An error occurred. PLEASE NOTE: A message containing the nature of this problem has been sent to the admins of " . SITE_URL . ".";
                    echo $warning;
                    break;
                default:
                    break;
            }
        }
    }
    function getRequestController($service)
    {
        $controller_file = "\\core\\controllers\\{$service}Controller";

        try {
            $controller = new $controller_file();
            return $controller;
        }
        catch(\Exception $e) {
            var_dump($e);
        }
        return false;
    }
    function getPost()
    {
        return $this->post;
    }
    function getGet()
    {
        return $this->get;
    }
    function getFiles()
    {
        return $this->files;
    }
    function getServer()
    {
        return $this->server;
    }
    function getPostValue($field)
    {
        if ($this->isPost() && isset($this->post[$field]))
            return $this->post[$field];
        return '';
    }
    function getGetValue($field)
    {
        if (isset($this->get[$field]))
            return $this->get[$field];
        return '';
    }
    function shouldTrack()
    {
        if ($this->server['HTTP_DNT'] === 0)
            return true;
        return false;
    }
    function getRequestIP()
    {
        return $this->server['REMOTE_ADDR'];
    }
    function getRequestTime()
    {
        return $this->server['REQUEST_TIME_FLOAT'];
    }
    function isPost()
    {
        if ($this->server['REQUEST_METHOD'] == 'POST')
            return true;
        return false;
    }
    function isHTTPS()
    {
        if (isset($this->server['HTTPS']) && $this->server['HTTPS'] == 'on')
            return true;
        return false;
    }
    function getRequestURI()
    {
        return $this->server['REQUEST_URI'];
    }
    function getRequestFile()
    {
        $uri = $this->getRequestURI();
        return strtok($uri, '?');
    }
    function getServerValue($field)
    {
        if (isset($this->server[$field]))
            return $this->server[$field];
        return '';
    }
    function getMethod()
    {
        return $this->server['REQUEST_METHOD'];
    }

}