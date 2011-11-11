<?php

namespace Club\TeamBundle\Listener;

class MenuListener
{
  private $router;
  private $security_context;
  private $translator;

  public function __construct($router, $security_context, $translator)
  {
    $this->router = $router;
    $this->security_context = $security_context;
    $this->translator = $translator;
  }

  public function onLeftMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    $menu = $event->getMenu();

    if ($this->security_context->isGranted('ROLE_TEAM_ADMIN')) {
      $menu['team'] = array(
        'name' => $this->translator->trans('Team'),
        'route' => $this->router->generate('club_team_adminteam_index'),
        'items' => array(
          array(
            'name' => $this->translator->trans('Level'),
            'route' => $this->router->generate('club_team_adminlevel_index')
          )
        )
      );
    }

    $event->setMenu($menu);
  }

  public function onTopMenuRender(\Club\MenuBundle\Event\FilterMenuEvent $event)
  {
    $menu = $event->getMenu();

    $menu[] = array(
      'name' => $this->translator->trans('Team'),
      'route' => $this->router->generate('club_team_team_index')
    );

    $event->setMenu($menu);
  }
}
