<?php
/**
 * User: Nikita
 * Date: 26.01.14
 * Time: 11:46
 */

namespace Sp\AppBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Sp\AppBundle\Entity\Swimmer;
use Sp\AppBundle\Model\ClubManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportSwimmersCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sp:app:import-swimmers')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $handle = fopen(__DIR__ . '\Swimmer_ID_012214.csv','r');
        $fields = fgetcsv($handle);

        $i = 0;
        $em = $this->getDoctrine()->getManager();
        while ( ($data = fgetcsv($handle) ) !== false ) {
            $swimmer = new Swimmer();
            $swimmer->setId($data[1]);
            $swimmer->setFirstName($data[3]);
            $swimmer->setLastName($data[2]);
            $swimmer->setMiddleName($data[4]);
            $swimmer->setGender($data[7]);
            if (!empty($data[8])) {
                $swimmer->setClub($this->getClubManager()->findOrCreate($data[8]));
            }
            if (!empty($data[9])) {
                $swimmer->setClubEnteredDate(new \DateTime($data[9]));
            }

            $em->persist($swimmer);
            $i++;

            if ($i >= 100) {
                $i = 0;
                $em->flush();
            }
        }
        $output->writeln('Done');
    }

    /**
     * @return Registry
     */
    protected function getDoctrine()
    {
        return $this->getContainer()->get('doctrine');
    }

    /**
     * @return ClubManager
     */
    protected function getClubManager()
    {
        return $this->getContainer()->get('sp_app.club_manager');
    }
}