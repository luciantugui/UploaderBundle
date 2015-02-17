<?php

namespace Gus\UploaderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Gus\UploaderBundle\Uploader\UploadHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UploaderController
 * @package Gus\UploaderBundle\Controller
 */
class UploaderController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws NotFoundHttpException
     */
    public function indexAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        /**
         * TODO: rework this
         *
         * hack for image_versions uploader settings
         * the original file upload settings is defined as an array element with '' key (in blueimp uploader),
         * which we cannot have in symfony config files, so rename the 'original' key to ''
         */
        $imageVersionsSettings = $this->container->getParameter('gus_uploader.settings.image_versions');
        $original = array('' => $imageVersionsSettings['original']);
        unset($imageVersionsSettings['original']);
        $imageVersionsSettings = $original + $imageVersionsSettings;

        try {
            $handler = new UploadHandler(array(
                'script_url' => $this->generateUrl($request->get('_route'), array(), UrlGeneratorInterface::ABSOLUTE_URL),
                'upload_dir' => $this->container->getParameter('gus_uploader.settings.upload_dir'),
                'upload_url' => $request->getUriForPath('') . $this->container->getParameter('gus_uploader.settings.upload_url'),
                'user_dirs' => $this->container->getParameter('gus_uploader.settings.user_dirs'),
                'download_via_php' => $this->container->getParameter('gus_uploader.settings.download_via_php'),
                'accept_file_types' => $this->container->getParameter('gus_uploader.settings.accept_file_types'),
                'inline_file_types' => $this->container->getParameter('gus_uploader.settings.inline_file_types'),
                'print_response' => $this->container->getParameter('gus_uploader.settings.print_response'),
                'mkdir_mode' => $this->container->getParameter('gus_uploader.settings.mkdir_mode'),
                'readfile_chunk_size' => $this->container->getParameter('gus_uploader.settings.readfile_chunk_size'),
                'max_file_size' => $this->container->getParameter('gus_uploader.settings.max_file_size'),
                'min_file_size' => $this->container->getParameter('gus_uploader.settings.min_file_size'),
                'max_number_of_files' => $this->container->getParameter('gus_uploader.settings.max_number_of_files'),
                'correct_image_extensions' => $this->container->getParameter('gus_uploader.settings.correct_image_extensions'),
                'max_width' => $this->container->getParameter('gus_uploader.settings.max_width'),
                'max_height' => $this->container->getParameter('gus_uploader.settings.max_height'),
                'min_width' => $this->container->getParameter('gus_uploader.settings.min_width'),
                'min_height' => $this->container->getParameter('gus_uploader.settings.min_height'),
                'discard_aborted_uploads' => $this->container->getParameter('gus_uploader.settings.discard_aborted_uploads'),
                'image_library' => $this->container->getParameter('gus_uploader.settings.image_library'),
                'image_versions' => $imageVersionsSettings,
            ), $request, $this->get('session')->getId());

            return $handler->controllerResponse->setData($handler->initialize());
        } catch (\Exception $e) {
            return new JsonResponse(array(
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'previous' => $e->getPrevious(),
                'trace' => $e->getTrace(),
            ), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}