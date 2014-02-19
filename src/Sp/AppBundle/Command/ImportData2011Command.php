<?php
/**
 * User: nikk
 * Date: 2/4/14
 * Time: 4:46 PM
 */

namespace Sp\AppBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Sp\AppBundle\Model\ClubManager;
use Sp\AppBundle\Model\EventManager;
use Sp\AppBundle\Model\EventTemplateManager;
use Sp\AppBundle\Model\LscManager;
use Sp\AppBundle\Model\MeetManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportData2011Command extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sp:app:import-data-2011')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ini_set('memory_limit', '1024M');
        $handle = fopen(__DIR__ . '\Data 2011_Jan1614.csv','r');
        $fields = fgetcsv($handle);

        $i = 0;
        while ( ($data = fgetcsv($handle) ) !== false ) {
            $i++;
            if ($data[0] === '') {
                break;
            }

            try {
                $meetData = explode(' - ', $data[0]);

                $meet = $this->getMeetManager()->findOrCreate($meetData[0], $meetData[1]);
                $data[6] = trim(preg_replace('/\s+/', ' ', $data[6]));
                $data[6] = str_ireplace('Breastroke', 'Breaststroke', $data[6]);
                $data[6] = str_ireplace('BreaststrokeLCM', 'Breaststroke LCM', $data[6]);
                $data[6] = str_ireplace(' utterfly', ' Butterfly', $data[6]);
                $data[6] = str_ireplace('F Freestyle', 'Freestyle', $data[6]);

                if (strpos($data[6], 'IM') !== false) {
                    if (count(explode(' ', $data[6])) === 2) {
                        $data[6] .= ' ' . $data[9];
                    }

                    $data[6] = str_ireplace('IM', 'Individual Medley', $data[6]);
                }
                $eventTemplate = $this->getEventTemplateManager()->findByTitle($data[6]);
                $event = $this->getEventManager()->findOrCreate($meet, $eventTemplate, $data[10]);
                $club = $this->getClubManager()->findOrCreate($data[14]);
                $lsc = $this->getLscManager()->findOrCreate($data[13]);
                $swimmerId = (int) $data[20];
                $seconds = (float) $data[19];
                $rank = (int) $data[11];
                $ts = $data[16];
                $relay = $data[18];

                $swimmersIdFix = array(2838 => 2839, 450 => 451, 1912 => 1913, 4153 => 4154, 381 => 382, 651 => 652,
                    2660 => 2661, 90 => 5177, 2378 => 2379, 120 => 5178, 4113 => 4114, 1385 => 1386, 1388 => 1389,
                    944 => 945, 48 => 5176, 285 => 5180, 4408 => 4409, 3332 => 3333, 749 => 750, 4410 => 4411,
                    3797 => 3798, 1251 => 1252, 2179 => 2180, 692 => 693, 2181 => 2182, 2159 => 2160, 694 => 695,
                    2005 => 2006, 1968 => 1969, 2023 => 2024, 286 => 287, 2908 => 2909, 874 => 875, 2840 => 2841,
                    3571 => 3572, 1272 => 1273, 1677 => 1678
                );
                if (isset($swimmersIdFix[$swimmerId])) {
                    $swimmerId = $swimmersIdFix[$swimmerId];
                }

                if (empty($swimmerId)) {
                    $emptySwimmers = array('Desroches' => 991, 'Roggenstein, Mara' => 3572, 'Hall, Sidnee' => 1597,
                        'Evans, Reece' => 1161, 'Kaijser, Anna' => 2062, 'Babich Morrow' => 151, 'Chu, Cameron' => 737,
                        'Kardinal, Galen' => 2077, 'Viceconte, Madeleine' => 4337, 'Garrard, Yizhuang' => 1363,
                        'Ortega-Riek, Sabrina' => 3162, 'Russell-Cheung, Jesse' => 3636, 'Orbach-Mandel, Hannah' => 3151,
                        'MacDonald, Bridget' => 2554, 'Ishmael, Bayleigh' => 1922, 'Campbell-Dowdy, Brissy' => 595,
                        'Houltram, Madison Laura' => 1845, 'Peterson, Lauren' => 3305, 'Gianiorio, Brooke' => 1402,
                        'Heck, Aidan' => 1689, 'Velitchkov, Sophie' => 4331, 'To, Samuel' => 4187, 'Van de Graaf, Megan' => 4293,
                        'Littlemore, Ethan' => 2463, 'Lee, Lily' => 2354, 'Norton-Abad, Aleja' => 3083, 'Thorn, Taylor' => 4174,
                        'Alarcio-Caldon, Meredith' => 31, 'Dangremond, Courtney' => 929, 'Bolin, Madeline' => 399,
                        'Kaijser, Cecilia' => 2063, 'Smith, Shannon' => 3899, 'Cecchetti, Zachary' => 659, 'Ronai, Catherine' => 3585,
                        'Chan, Jeremy' => 671, 'Lorson, Courtney' => 2494, 'Bayardo, Brenna' => 250, 'Dearmon-Moore, Cole' => 955,
                        'Shipman, Mary' => 3831, 'Scooler, Filemon' => 3756, 'Matulic, Katherine' => 2672,
                        'Millsap-Campbell, Rylli' => 2847, 'Rice, Kimiko' => 3510, 'Barber, Scott' => 201,
                        'Davidson, Elijah' => 938, 'Algarate-Carter, Sara' => 43, 'Hughes-Carrera, Michael' => 1880,
                        'Modesto-Abbud' => 2874, 'Spires-Robertson, Kathleen' => 3943, 'Alf-Huynh, Maranda' => 38,
                        'Redwine-Hixson, Emma' => 5025, 'Jablon, Stephanie' => 1931, 'Johnson, Carly' => 1985,
                        'Blik, Naomi' => 376, 'Krivokapic-Zhou, Sophie' => 2229, 'Lew-Koga, Alika' => 2402,
                        'Dal Porto, Sophia' => 916, 'Ha-Hoang, Olivia' => 1582, 'Min, Rachel Kyung' => 2856,
                        'Vejar-Richter, Fernanda' => 4327, 'Hilde-Jones, Milan' => 1757, 'Rhee, Rachel' => 3507,
                        'Van Den Ende, Sophia' => 4299, 'Tanizaki-Hudson, Derek' => 4092, 'Tsai, Aaron' => 4234,
                        'Isleta, Chloe Kennedy' => 1924, 'Lee, Danielle' => 2343, 'Sun, Jerome' => 4049,
                        'Ma, Kimberly' => 2544, 'Yoo, Ethan' => 4647, 'Tran, Alexander' => 4205, 'Ha, Christopher' => 1581,
                        'Phillips, Zoe' => 3328, 'Cowie-Braccini, Mattia' => 859, 'Dimagmaliw, Naomi' => 1015,
                        'Prebel-Jackert, Ella' => 3377, 'Tu, Kevin' => 4239, 'Vos Alfaro, Marlon' => 4352,
                        'Sun, Beatrice' => 4045, 'Johnson, Keely' => 1995, 'Fromson-Ho, Ally' => 1311,
                        'Lum, Claudia' => 2521, 'Nguyen, Kristine' => 3048, 'Kim, Brandon' => 2132, 'Carrillo-Zazueta, Tanner' => 632,
                        'Van De Hey, Lauren' => 4294, 'Calleja-Harris, Skylar' => 584, 'Pham, Adrienne' => 3313,
                        'Graves, Joshua' => 1504, 'Vaughn-Hulbert, Rachel' => 4321, 'Jones, Jed' => 2021,
                        'Baynes-Tadena, Julienne' => 254, 'Liu, Sasha' => 2466, 'Van Linge, Kindle' => 4300, 'Lam, Rachel' => 2280,
                        'Harris-Holden, Naomi' => 1647, 'Luu, Bryant' => 2527, 'Tran, Krystal' => 4209, 'Ip, Brian' => 1921,
                        'Kim, Hannah' => 2134, 'Yee-Yanagishita, Christian' => 4638, 'Swenson Kamani, Amina' => 4062,
                        'Coverdale, Zachariah' => 858, 'Ramirez, Rachael' => 3441, 'Tozzi, Maria' => 4203, 'Hostal, Jonathan' => 5345,
                        'Scholz, Frank' => 3731, 'Lee, Justin' => 2352, 'Gault-Crabb, Nathan' => 1373, 'Corey, Morgan' => 836,
                        'Magat, Stephen' => 2572, 'Solache Nishizaki' => 3916, 'Lansing, Marissa' => 2301, 'Cabinian, Charrissa' => 561,
                        'Lindhag, Mckenzi' => 2441, 'Khoo, Katrina' => 2124, 'Pohlmann, Jonah' => 3353, 'Dunlap, Ariana' => 1086,
                        'Wing, Mahinalani' => 4545, 'Jamison, Daniel' => 1946, 'Kaijser, Johan' => 2064
                    );

                    foreach($emptySwimmers as $needle => $value) {
                        if (strpos($data[12], $needle) !== false) {
                            $swimmerId = $value;
                            break;
                        }
                    }
                }

                $skipList = array('Sto. Domingo, Noa', 'Sto. Domingo, Mia');
                foreach($skipList as $needle ) {
                    if (strpos($data[12], $needle) !== false) {
                        continue 2;
                    }
                }

                if (empty($ts) || $ts[0] != '"') {
                    $ts = '"' . $ts . '"';
                }

                $query = 'INSERT INTO event_result
                (event_id, swimmer_id, seconds, rank, lsc_id, club_id, ts, relay) VALUES (' . $event->getId() .
                    ", {$swimmerId}, {$seconds}, {$rank}, " . $lsc->getId() . ', ' . $club->getId() .
                    ', ' . $ts . ', "' . $relay . '")';

                $this->getDoctrine()->getConnection()->exec($query);
            } catch(\Exception $ex) {
                $output->writeln('Row: ' . ($i + 1));
                $output->writeln('Error: ' . $ex->getMessage());
                throw $ex;
            }

            if ($i % 100 === 0) {
                $output->writeln('Processed: ' . $i . ' rows');
            }
        }

        $output->writeln("Processed {$i} rows");
    }

    /**
     * @return Registry
     */
    protected function getDoctrine()
    {
        return $this->getContainer()->get('doctrine');
    }

    /**
     * @return MeetManager
     */
    protected function getMeetManager()
    {
        return $this->getContainer()->get('sp_app.meet_manager');
    }

    /**
     * @return EventTemplateManager
     */
    protected function getEventTemplateManager()
    {
        return $this->getContainer()->get('sp_app.event_template_manager');
    }

    /**
     * @return EventManager
     */
    protected function getEventManager()
    {
        return $this->getContainer()->get('sp_app.event_manager');
    }

    /**
     * @return ClubManager
     */
    protected function getClubManager()
    {
        return $this->getContainer()->get('sp_app.club_manager');
    }

    /**
     * @return LscManager
     */
    protected function getLscManager()
    {
        return $this->getContainer()->get('sp_app.lsc_manager');
    }
}