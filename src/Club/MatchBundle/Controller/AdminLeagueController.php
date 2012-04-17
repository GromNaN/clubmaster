<?php

namespace Club\MatchBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminLeagueController extends Controller
{
  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $leagues = $em->getRepository('ClubMatchBundle:League')->findAll();

    return array(
      'leagues' => $leagues
    );
  }

  /**
   * @Route("/new")
   * @Template()
   */
  public function newAction()
  {
    $start = new \DateTime(date('Y-m-d 00:00:00'));
    $end = clone $start;
    $i = new \DateInterval('P1Y');
    $end->add($i);

    $league = new \Club\MatchBundle\Entity\League();
    $league->setStartDate($start);
    $league->setEndDate($end);

    $res = $this->process($league);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $league = $em->find('ClubMatchBundle:League',$id);

    $res = $this->process($league);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'league' => $league,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/delete/{id}")
   */
  public function deleteAction($id)
  {
    try {
      $em = $this->getDoctrine()->getEntityManager();
      $league = $em->find('ClubMatchBundle:League',$this->getRequest()->get('id'));

      $em->remove($league);
      $em->flush();

      $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
    } catch (\PDOException $e) {
      $this->get('session')->setFlash('error', $this->get('translator')->trans('You cannot delete league which is already being used.'));
    }

    return $this->redirect($this->generateUrl('club_match_adminleague_index'));
  }

  /**
   * @Route("/users/add/{id}")
   * @Template()
   */
  public function usersAddAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $res = array();
    $form = $this->getForm($res);

    $form->bindRequest($this->getRequest());
    if ($form->isValid()) {
      $res = $form->getData();
      $user = $em->find('ClubUserBundle:User', $res['user_id']);
      if (!$user)
        $user = $em->getRepository('ClubUserBundle:User')->getOneBySearch(array('query' => $res['user']));

      $league = $em->find('ClubMatchBundle:League', $id);

      $league->addUser($user);
      $em->persist($league);
      $em->flush();

      $team = $em->getRepository('ClubMatchBundle:Team')->getTeamByUser($user);
      $em->getRepository('ClubMatchBundle:LeagueTable')->getTeam($league, $team);
      $em->flush();

      $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your changes are saved.'));
    }

    return $this->redirect($this->generateUrl('club_match_adminleague_users', array(
      'id' => $id
    )));
  }

  /**
   * @Route("/users/delete/{id}/{user_id}")
   */
  public function usersDeleteAction($id, $user_id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $league = $em->find('ClubMatchBundle:League', $id);
    $user = $em->find('ClubUserBundle:User', $user_id);

    $league->getUsers()->removeElement($user);
    $em->persist($league);
    $em->flush();

    $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_match_adminleague_users', array(
      'id' => $id
    )));
  }

  /**
   * @Route("/users/{id}")
   * @Template()
   */
  public function usersAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $res = array();
    $form = $this->getForm($res);

    $league = $em->find('ClubMatchBundle:League', $id);

    return array(
      'league' => $league,
      'form' => $form->createView()
    );
  }

  protected function process($league)
  {
    $form = $this->createForm(new \Club\MatchBundle\Form\League(), $league);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($league);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_match_adminleague_index'));
      }
    }

    return $form;
  }

  protected function getForm($res)
  {
    $form = $this->createFormBuilder($res)
      ->add('user', 'text', array(
        'label' => 'Player'
      ))
      ->add('user_id', 'hidden')
      ->getForm();

    return $form;
  }
}
