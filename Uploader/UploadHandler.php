<?php

namespace Gus\UploaderBundle\Uploader;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UploadHandler
 * @package Gus\UploaderBundle\Uploader
 */
class UploadHandler extends \UploadHandler
{
    /**
     * @var JsonResponse
     */
    public $controllerResponse;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var
     */
    private $sessionId;

    /**
     * @param $options
     * @param Request $request
     * @param $sessionId
     */
    public function __construct($options, Request $request, $sessionId)
    {
        $this->controllerResponse = new JsonResponse();

        $this->request = $request;

        $this->sessionId = $sessionId;

        parent::__construct($options, false);
    }

    /**
     * @return JsonResponse
     */
    public function getJsonResponse()
    {
        return $this->controllerResponse;
    }

    /**
     * @param $str
     * @return mixed
     */
    protected function body($str)
    {
        return $str;
    }

    /**
     * @param $str
     * @throws \LogicException
     */
    protected function header($str)
    {
        try {
            list ($key, $value) = explode(': ', $str, 2);
        } catch (\Exception $e) {

            preg_match('#HTTP/\d+\.\d+ (\d+)#', $str, $matches);

            $reflect = new \ReflectionClass("Symfony\\Component\\HttpFoundation\\Response");

            $httpStatuses = array_reverse($reflect->getConstants());

            if (in_array($matches[1], $httpStatuses)) {
                $this->controllerResponse->setStatusCode($matches[1]);

                return;
            }
            throw new \LogicException('HTTP status code retrieval failed');
        }

        $this->controllerResponse->headers->set($key, $value);
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function get_server_var($id)
    {
        return $this->request->server->get($id, '');
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function get_query_param($id) {
        return $this->request->query->get($id);
    }

    /**
     * @return mixed
     */
    protected function get_full_url()
    {
        return $this->request->getUriForPath('');
    }

    /**
     * @return mixed
     */
    public function initialize()
    {
        switch ($this->get_server_var('REQUEST_METHOD')) {
            case 'OPTIONS':
            case 'HEAD':
                $this->head();
                break;
            case 'GET':
                return $this->get($this->options['print_response']);
                break;
            case 'PATCH':
            case 'PUT':
            case 'POST':
                return $this->post($this->options['print_response']);
                break;
            case 'DELETE':
                return $this->delete($this->options['print_response']);
                break;
            default:
                $this->header('HTTP/1.1 405 Method Not Allowed');
        }
        return;
    }

    /**
     * @return mixed
     */
    protected function get_user_id()
    {
        return $this->sessionId;
    }

    /**
     * @param $file_path
     * @return float|int|void
     */
    protected function readfile($file_path)
    {
        $this->controllerResponse->sendHeaders();
        parent::readfile($file_path);
    }

    /**
     * @param $file
     * @param $index
     */
    protected function handle_form_data($file, $index)
    {
        // Handle form data, e.g. $_REQUEST['description'][$index]
    }

    /**
     * @param $file
     */
    protected function set_additional_file_properties($file)
    {
        parent::set_additional_file_properties($file);
        $file->uniqueId = sha1(uniqid(mt_rand(), true));
    }
}