<?php

namespace Club\UserBundle\Listener;

class LocationListener
{
    protected $container;
    protected $em;
    protected $session;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->session = $container->get('session');
    }

    public function onKernelRequest()
    {
        if ($this->container->get('club_installer.installer')->installerOpen()) {
            return;
        }

        try {
            if ($this->session->get('location_id')) return;

            $location = $this->em->getRepository('ClubUserBundle:Location')->getFirstLocation();
            if ($location) $this->session->set('location_id', $location->getId());
        } catch (\Exception $e) {
            $this->container->get('logger')->err($e->getMessage());
        }
    }
}
