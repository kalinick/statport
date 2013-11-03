<?php
/**
 * User: Nikita
 * Date: 15.09.13
 * Time: 11:46
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

class ImportDataCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sp:app:import-data')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ini_set('memory_limit', '328M');
        /* @var \Doctrine\DBAL\Connection $db */
        $db = $this->get('database_connection');

        set_time_limit ( 0 );
        $handle = fopen(__DIR__ . '\Data 2011.csv','r');
        ini_set('auto_detect_line_endings',TRUE);
        $fields = fgetcsv($handle);
        //print '<pre>Fields:' . print_r($fields, true) . '</pre><br><br><br><br><br>';

        $aDistance = $this->getAllDistance();
        $aStyle = $this->getAllStyle();
        $aCourse = $this->getAllCourse();
        $aLsc = $this->getAllLsc();
        $aClub = $this->getAllClub();
        $aSwimmer = $this->getAllSwimmers();
        $aMeet = $this->getAllMeet();
        $aEvent = array();

        $em = $this->getDoctrine()->getManager();

        $i = 0;

        while ( ($data = fgetcsv($handle) ) !== FALSE ) {
            //print '<pre>' . print_r($data, true) . '</pre>';


            $res = array_combine($fields, $data);

            if (!isset($aMeet[$res['Meet']])) {
                if (empty($res['Meet']) || empty($res['Date'])) {
                    throw new \Exception('Cannot create meet');
                }

                $oMeet = new Entity\Meet();
                $oMeet->setTitle($res['Meet']);
                $oMeet->setDate(new \DateTime($res['Date']));
                $em->persist($oMeet);
                $em->flush();

                $aMeet[$res['Meet']] = $oMeet;
            }

            if(empty($res['Middle'])) {
                $res['Middle'] = '';
            }

            if($res['First'] == '#N/A' || $res['Last'] == '#N/A') {
                $res['Last'] = substr($res['Name'], 0, strpos($res['Name'], ','));

                $tmp = trim(substr($res['Name'], strpos($res['Name'], ',') + 2));

                if (strpos($tmp, ' ') != false) {
                    $res['First'] = substr($tmp, 0, strpos($tmp, ' '));
                    $res['Middle'] = substr($tmp, strpos($tmp, ' ') + 2);
                } else {
                    $res['First'] = $tmp;
                }

                if (empty($res['First']) || empty($res['Last'])) {
                    $res['Last'] = substr($res['Name'], 0, strpos($res['Name'], ' '));

                    $tmp = substr($res['Name'], strpos($res['Name'], ' ') + 2);

                    $res['First'] = substr($tmp, 0, strpos($tmp, ','));
                    $res['Middle'] = substr($tmp, strpos($tmp, ',') + 2);
                }
            }

            if (empty($res['First']) || empty($res['Last'])) {
                throw new \Exception('Wrong first last name ' . $i);
            }

            $nsm = $res['First'] . $res['Last'];

            if (!isset($aSwimmer[$nsm])) {
                if (empty($res['Gender'])) {
                    $output->writeln('No gender ' . $i++ . ' row');
                    continue;
                    throw new \Exception('Empty gender');
                }
                $oSwimmer = new Entity\Swimmer();
                $oSwimmer->setFirstName($res['First']);
                $oSwimmer->setLastName($res['Last']);
                $oSwimmer->setMiddleName($res['Middle']);
                $oSwimmer->setGender($res['Gender']);

                $em->persist($oSwimmer);
                $em->flush();

                $aSwimmer[$nsm] = $oSwimmer;
            }

            if (!isset($aLsc[$res['LSC']])) {
                if (empty($res['LSC'])) {
                    throw new \Exception('LSC is incorrect');
                }

                $oLsc = new Entity\Lsc();
                $oLsc->setTitle($res['LSC']);

                $em->persist($oLsc);
                $em->flush();

                $aLsc[$res['LSC']] = $oLsc;
            }

            if (!isset($aClub[$res['Club Code']])) {
                if (empty($res['Club Code'])) {
                    throw new \Exception('Club Code is incorrect');
                }

                $oClub = new Entity\Club();
                $oClub->setTitle($res['Club Code']);

                $em->persist($oClub);
                $em->flush();

                $aClub[$res['Club Code']] = $oClub;
            }

            if (empty($aDistance[$res['Distance']]) || empty($aStyle[$res['Stroke']]) || empty($aCourse[$res['Course']])) {
                continue;
                throw new \Exception('Event params is empty');
            }

            $eventStr = $aDistance[$res['Distance']]->getId() . '_' . $aStyle[$res['Stroke']]->getId() . '_' .
                $aCourse[$res['Course']]->getId() . '_' . $aMeet[$res['Meet']]->getId();

            if (!isset($aEvent[$eventStr])) {

                $db->insert('event', array(
                    'distance_id' => $aDistance[$res['Distance']]->getId(),
                    'style_id' => $aStyle[$res['Stroke']]->getId(),
                    'course_id' => $aCourse[$res['Course']]->getId(),
                    'meet_id' => $aMeet[$res['Meet']]->getId(),
                    'lsc_id' => $aLsc[$res['LSC']]->getId(),
                    'club_id' => $aClub[$res['Club Code']]->getId(),
                ));

                $aEvent[$eventStr] = $db->lastInsertId();
//                $oEvent = new Entity\Event();
//                $oEvent->setDistance($aDistance[$res['Distance']]);
//                $oEvent->setStyle($aStyle[$res['Stroke']]);
//                $oEvent->setCourse($aCourse[$res['Course']]);
//                $oEvent->setMeet($aMeet[$res['Meet']]);
//                $oEvent->setLsc($aLsc[$res['LSC']]);
//                $oEvent->setClub($aClub[$res['Club Code']]);
//
//                $em->persist($oEvent);
//                $em->flush();
//
//                $aEvent[$eventStr] = $oEvent;
            }

            if (!is_numeric($res['TimeCalc'])) {
                continue;
            }

            if (empty($res['TimeCalc']) || empty($res['Rank'])) {
                throw new \Exception('Time or rank invalid');
            }

            $db->insert('event_result', array(
                'event_id' => $aEvent[$eventStr],
                'swimmer_id' => $aSwimmer[$nsm]->getId(),
                'rank' => $res['Rank'],
                'seconds' => $res['TimeCalc']
            ));

//            $oEventResult = new Entity\EventResult();
//            $oEventResult->setEvent($aEvent[$eventStr]);
//            $oEventResult->setSwimmer($aSwimmer[$nsm]);
//            $oEventResult->setRank($res['Rank']);
//            $oEventResult->setSeconds($res['TimeCalc']);
//
//            $em->persist($oEventResult);
//            $em->flush();

            //if ($oEventResult->getId() % 100 == 0) {
                $output->writeln('Processed ' . ++$i . ' row');

            if($i === 65447) {
                $output->writeln('Done!');
                break;
            }
            //}
            //print '<pre>' . print_r($res, true) . '</pre>';
            //print '<br><br><br>';
        }
        ini_set('auto_detect_line_endings',FALSE);
    }

    public function getAllDistance()
    {
        $aResult = array();
        $aEntity =  $this->getDoctrine()->getRepository('SpAppBundle:Distance')->findAll();
        foreach($aEntity as $row) {
            $aResult[$row->getLength()] = $row;
        }

        return $aResult;
    }

    public function getAllStyle()
    {
        $aResult = array();
        $aEntity =  $this->getDoctrine()->getRepository('SpAppBundle:SwimmingStyle')->findAll();
        foreach($aEntity as $row) {
            $aResult[$row->getTitle()] = $row;
        }

        return $aResult;
    }

    public function getAllCourse()
    {
        $aResult = array();
        $aEntity =  $this->getDoctrine()->getRepository('SpAppBundle:Course')->findAll();
        foreach($aEntity as $row) {
            $aResult[$row->getTitle()] = $row;
        }

        return $aResult;
    }

    public function getAllLsc()
    {
        $aResult = array();
        $aEntity =  $this->getDoctrine()->getRepository('SpAppBundle:Lsc')->findAll();
        foreach($aEntity as $row) {
            $aResult[$row->getTitle()] = $row;
        }

        return $aResult;
    }

    public function getAllClub()
    {
        $aResult = array();
        $aEntity =  $this->getDoctrine()->getRepository('SpAppBundle:Club')->findAll();
        foreach($aEntity as $row) {
            $aResult[$row->getTitle()] = $row;
        }

        return $aResult;
    }

    public function getAllSwimmers()
    {
        $aResult = array();
        $aEntity =  $this->getDoctrine()->getRepository('SpAppBundle:Swimmer')->findAll();
        foreach($aEntity as $row) {
            $nsm = $row->getFirstName() . $row->getLastName();
            $aResult[$nsm] = $row;
        }

        return $aResult;
    }

    public function getAllMeet()
    {
        $aResult = array();
        $aEntity =  $this->getDoctrine()->getRepository('SpAppBundle:Meet')->findAll();
        foreach($aEntity as $row) {
            $aResult[$row->getTitle()] = $row;
        }

        return $aResult;
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