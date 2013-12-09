<?php
/**
 * User: Nikita
 * Date: 04.12.13
 * Time: 21:50
 */

namespace Sp\AdminBundle\Model;

use Sp\AdminBundle\Entity\UnprocessedResultTransaction;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Sp\AppBundle\Model\ProcessStateModel;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Persistence\ObjectRepository;

class UnprocessedResultManager
{
    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var ObjectRepository
     */
    private $repositoryProcessState;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->repositoryProcessState = $this->doctrine->getRepository('SpAppBundle:ProcessState');
    }

    /**
     * @param UploadedFile $file
     * @return int
     */
    public function import(UploadedFile $file)
    {
        $oTransaction = new UnprocessedResultTransaction();

        $oTransaction->setTitle($file->getClientOriginalName());
        $oTransaction->setProcessState($this->repositoryProcessState->find(ProcessStateModel::STARTED));

        $this->doctrine->getManager()->persist($oTransaction);
        $this->doctrine->getManager()->flush();

        return $oTransaction->getId();
    }
}