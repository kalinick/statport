<?php
/**
 * User: nikk
 * Date: 2/4/14
 * Time: 3:59 PM
 */

namespace Sp\AppBundle\Model;

use Sp\AppBundle\Repository\CourseRepository;
use Sp\AppBundle\Entity\Course;

use Doctrine\Bundle\DoctrineBundle\Registry;

class CourseManager
{
    /**
     * @var Registry
     */
    private $doctrine;
    /**
     * @var CourseRepository
     */
    private $repository;
    /**
     * @var Course[]
     */
    private $courses;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->repository = $this->doctrine->getRepository('SpAppBundle:Course');
    }

    /**
     * @return Course[]
     */
    public function &findCourses()
    {
        if ($this->courses === null) {
            $courses = $this->repository->findAll();
            $result = array();
            foreach($courses as $course) {
                $result[$course->getTitle()] = $course;
            }
            $this->courses = $result;
        }

        return $this->courses;
    }

    /**
     * @param $title
     * @return Course
     */
    public function findOrCreate($title)
    {
        $courses = &$this->findCourses();
        if (!isset($courses[$title])) {
            $course = new Course();
            $course->setTitle($title);

            $em = $this->doctrine->getManager();
            $em->persist($course);
            $em->flush();
            $courses[$course->getTitle()] = $course;
        }
        return $courses[$title];
    }
}