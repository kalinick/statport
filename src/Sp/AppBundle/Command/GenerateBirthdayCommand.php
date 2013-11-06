<?php
/**
 * User: Nikita
 * Date: 15.09.13
 * Time: 15:47
 */

namespace Sp\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Bundle\DoctrineBundle\Registry;

use Sp\AppBundle\Entity;

class GenerateBirthdayCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sp:app:generate-birthday')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $aSwimmers =  $this->getDoctrine()->getRepository('SpAppBundle:Swimmer')->findAll();

        $i = 0;
        foreach($aSwimmers as $swimmer) {

            $d = new \DateTime('-' . rand(7, 16) . ' year');
            $swimmer->setBirthday($d);
            $this->getDoctrine()->getManager()->flush();

            $output->writeln('Processed ' . ++$i . ' row');
        }
    }

    /**
     * @return Registry
     */
    protected function getDoctrine()
    {
        return $this->getContainer()->get('doctrine');
    }

    protected function get($id)
    {
        return $this->getContainer()->get($id);
    }
}