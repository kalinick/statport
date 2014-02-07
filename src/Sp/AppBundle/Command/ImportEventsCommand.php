<?php
/**
 * User: nikk
 * Date: 2/4/14
 * Time: 3:47 PM
 */

namespace Sp\AppBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Sp\AppBundle\Entity\EventTemplate;
use Sp\AppBundle\Model\CourseManager;
use Sp\AppBundle\Model\DistanceManager;
use Sp\AppBundle\Model\SwimmingStyleManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportEventsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sp:app:import-events')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $handle = fopen(__DIR__ . '\Event_ID.csv','r');
        $fields = fgetcsv($handle);

        $i = 0;
        $em = $this->getDoctrine()->getManager();
        while ( ($data = fgetcsv($handle) ) !== false ) {
            $data[0] = trim($data[0]);
            $params = explode(' ', $data[0]);
            if(count($params) === 4) {
                $params[1] = $params[1] . ' ' . $params[2];
                $params[2] = $params[3];
            }
            $distance = $this->getDistanceManager()->findOrCreate($params[0]);
            $swimmingStyle = $this->getSwimmingStyleManager()->findOrCreate($params[1]);
            $course = $this->getCourseManager()->findOrCreate($params[2]);

            $eventTemplate = new EventTemplate();
            $eventTemplate->setTitle($data[0]);
            $eventTemplate->setDistance($distance);
            $eventTemplate->setStyle($swimmingStyle);
            $eventTemplate->setCourse($course);

            $em->persist($eventTemplate);
            $em->flush();
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
     * @return CourseManager
     */
    protected function getCourseManager()
    {
        return $this->getContainer()->get('sp_app.course_manager');
    }

    /**
     * @return DistanceManager
     */
    protected function getDistanceManager()
    {
        return $this->getContainer()->get('sp_app.distance_manager');
    }

    /**
     * @return SwimmingStyleManager
     */
    protected function getSwimmingStyleManager()
    {
        return $this->getContainer()->get('sp_app.swimming_style_manager');
    }
}