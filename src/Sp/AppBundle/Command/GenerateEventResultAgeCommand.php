<?php
/**
 * User: Nikita
 * Date: 21.09.13
 * Time: 20:05
 */

namespace Sp\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Bundle\DoctrineBundle\Registry;

use Sp\AppBundle\Classes\ContainerTrait;
use Sp\AppBundle\Entity;

class GenerateEventResultAgeCommand extends ContainerAwareCommand
{
    use ContainerTrait;

    protected function configure()
    {
        $this
            ->setName('sp:app:generate-event-result-age')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var Entity\Swimmer[] $aSwimmers*/
        $aSwimmers = $this->getDoctrine()->getRepository('SpAppBundle:Swimmer')->findAll();

        $i = 0;
        foreach($aSwimmers as $swimmer) {

            $j = 0;
            foreach($swimmer->getResults() as $result) {
                $age1 = $result->getAge();
                if (!empty($age1)) {
                    continue;
                }
                $age = $result->getEvent()->getMeet()->getDate()->diff($swimmer->getBirthday())->format('%y');

                $result->setAge($age);
                $this->getDoctrine()->getManager()->flush();
                $output->writeln('Processed ' . ++$j . ' result');
            }

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