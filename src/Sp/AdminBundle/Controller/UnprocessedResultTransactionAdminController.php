<?php
/**
 * User: nikk
 * Date: 11/28/13
 * Time: 4:10 PM
 */

namespace Sp\AdminBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sp\AdminBundle\Model;

class UnprocessedResultTransactionAdminController extends Controller
{
    public function importAction()
    {
        $listUrl = $this->admin->generateUrl('list');

        /**
         * @var UploadedFile $file
         */
        $file = $this->getRequest()->files->get('file');

        if (!$file instanceof UploadedFile || $file->getClientMimeType() !== 'text/csv') {
            $this->get('session')->getFlashBag()->add('sonata_flash_error', 'Error, before import please select csv file');
            return $this->redirect($listUrl);
        } else {
            $id = $this->getEventManager()->import($file);
            return $this->generateUrl('admin_sp_app_unprocessedresulttransaction_unprocessedresult_list', array('id' => $id));
        }
    }

    /**
     * @return Model\UnprocessedResultManager
     */
    protected function getEventManager()
    {
        return $this->get('sp_admin.unprocessed_result_manager');
    }
}