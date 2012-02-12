<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Club\ConfiguratorBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * ConfiguratorController.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ConfiguratorController extends ContainerAware
{
    /**
     * @return Response A Response instance
     */
    public function stepAction($index = 0)
    {
        $configurator = $this->container->get('club.configurator.webconfigurator');

        $step = $configurator->getStep($index);
        $form = $this->container->get('form.factory')->create($step->getFormType(), $step);

        $request = $this->container->get('request');
        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $configurator->mergeParameters($step->update($form->getData()));
                $configurator->write();

                $index++;

                if ($index < $configurator->getStepCount()) {
                    return new RedirectResponse($this->container->get('router')->generate('_configurator_step', array('index' => $index)));
                }

                return new RedirectResponse($this->container->get('router')->generate('_configurator_final'));
            }
        }

        return $this->container->get('templating')->renderResponse($step->getTemplate(), array(
            'form'    => $form->createView(),
            'index'   => $index,
            'count'   => $configurator->getStepCount(),
            'version' => $this->getVersion(),
        ));
    }

    public function checkAction()
    {
        $configurator = $this->container->get('club.configurator.webconfigurator');

        // Trying to get as much requirements as possible
        $majors = $configurator->getRequirements();
        $minors = $configurator->getOptionalSettings();

        $url = $this->container->get('router')->generate('_configurator_step', array('index' => 0));

        if (empty($majors) && empty($minors)) {
            return new RedirectResponse($url);
        }

        return $this->container->get('templating')->renderResponse('ClubConfiguratorBundle::Configurator/check.html.twig', array(
            'majors'  => $majors,
            'minors'  => $minors,
            'url'     => $url,
            'version' => $this->getVersion(),
        ));
    }

    public function finalAction()
    {
        $configurator = $this->container->get('club.configurator.webconfigurator');
        $configurator->clean();

        $welcomeUrl = $this->container->get('router')->generate('club_installer_installer_index');

        return $this->container->get('templating')->renderResponse('ClubConfiguratorBundle::Configurator/final.html.twig', array(
            'welcome_url' => $welcomeUrl,
            'parameters'  => $configurator->render(),
            'ini_path'    => $this->container->getParameter('kernel.root_dir').'/config/parameters.ini',
            'is_writable' => $configurator->isFileWritable(),
            'version'     => $this->getVersion(),
        ));
    }

    public function getVersion()
    {
        $kernel = $this->container->get('kernel');

        return $kernel::VERSION;
    }
}
