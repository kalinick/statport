<?php
/**
 * User: Nikita
 * Date: 07.11.13
 * Time: 20:39
 */

namespace Sp\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PageController extends Controller
{
    /**
     * @Route("/", name="index_page")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/sample", name="sample_page")
     * @Template()
     */
    public function sampleAction()
    {
        return array();
    }

    /**
     * @Route("/privacy", name="privacy_page")
     * @Template()
     */
    public function privacyAction()
    {
        return array();
    }

    /**
     * @Route("/terms-of-service", name="terms_page")
     * @Template()
     */
    public function termsAction()
    {
        return array();
    }

    /**
     * @Route("/legal-notice", name="legal_page")
     * @Template()
     */
    public function legalAction()
    {
        return array();
    }

    /**
     * @Route("/about", name="about_page")
     * @Template()
     */
    public function aboutAction()
    {
        return array();
    }

    /**
     * @Route("/contact-us", name="contact_page")
     * @Template()
     */
    public function contactAction()
    {
        return array();
    }
}