<?php
/**
 * User: Nikita
 * Date: 15.09.13
 * Time: 11:41
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

class ImportTimeStandartCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sp:app:import-time-standart')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        set_time_limit ( 0 );
        $handle = fopen(__DIR__ . '\Time Standards for Charts.csv','r');
        ini_set('auto_detect_line_endings',TRUE);
        $first = true;

        $i = 0;
        while ( ($data = fgetcsv($handle) ) !== FALSE ) {
            if ($first) {
                $first = false;
                continue;
            }

            $eventData = explode(' ', $data[0]);

            if (count($eventData) == 4) {
                $eventData[1] = 'IM';
                $eventData[2] = $eventData[3];
            }

            $aYears = array(
                '10 & Under' => array('min' => 0, 'max' => 10),
                '11 - 12' => array('min' => 11, 'max' => 12),
                '13 - 14' => array('min' => 13, 'max' => 14),
                '15 - 16' => array('min' => 15, 'max' => 16),
                '17 - 18' => array('min' => 17, 'max' => 18),
            );

            $oDistance = $this->getDoctrine()->getRepository('SpAppBundle:Distance')->findOneBy(array('length' => trim($eventData[0])));
            $oStyle = $this->getDoctrine()->getRepository('SpAppBundle:SwimmingStyle')->findOneBy(array('title' => trim($eventData[1])));
            $oCourse = $this->getDoctrine()->getRepository('SpAppBundle:Course')->findOneBy(array('title' => trim($eventData[2])));
            $oTimeStandart = $this->getDoctrine()->getRepository('SpAppBundle:TimeStandart')->findOneBy(array('title' => trim($data[4])));
            $gender = trim($data[2]);
            $years = $aYears[$data[3]];

            $i = strpos($data[5], ':');
            if ( $i === false) {
                $seconds = $data[5];
            } else {
                $seconds = substr($data[5], 0, $i) * 60 + substr($data[5], $i + 1);
            }


            if (
                !($oDistance instanceof Entity\Distance) ||
                !($oStyle instanceof Entity\SwimmingStyle) ||
                !($oCourse instanceof Entity\Course) ||
                !($gender == 'M' || $gender == 'F') ||
                count($years) != 2 ||
                !($oTimeStandart instanceof Entity\TimeStandart) ||
                empty($seconds)
            ) {
                throw new \Exception();
            }

            $oTimeStandartResult = new Entity\TimeStandartResult();
            $oTimeStandartResult->setDistance($oDistance);
            $oTimeStandartResult->setStyle($oStyle);
            $oTimeStandartResult->setCourse($oCourse);
            $oTimeStandartResult->setTimeStandart($oTimeStandart);
            $oTimeStandartResult->setGender($gender);
            $oTimeStandartResult->setMinAge($years['min']);
            $oTimeStandartResult->setMaxAge($years['max']);
            $oTimeStandartResult->setSeconds($seconds);

            $dm = $this->getDoctrine()->getManager();
            $dm->persist($oTimeStandartResult);
            //try {
            $dm->flush();
//            } catch(\Exception $ex){
//                throw new \Exception($seconds);
//            }

            $output->writeln('Processed ' . ++$i . ' records');
//            print 'Distance: ' . $oDistance->getId() . ' Style: ' . $oStyle->getId() .' Cource: ' . $oCourse->getId() .
//                ' Gender: ' . $gender;
//            print '<br>';
        }
        ini_set('auto_detect_line_endings',FALSE);
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