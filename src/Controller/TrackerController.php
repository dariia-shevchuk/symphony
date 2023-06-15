<?php

namespace App\Controller;

use App\Entity\Issue;
use App\Entity\Product;
use App\Entity\User;
use App\Form\Type\IssueType;
use App\Repository\IssueRepository;
use App\Repository\ProductRepository;
use App\Service\IssuesManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class TrackerController extends AbstractController
{
    #[Route('/')]
    public function home(): Response
    {
        return $this->render('tracker/index.html.twig', []);
    }

    #[Route('/issues', name: 'issues')]
    public function issues(IssueRepository $repository, IssuesManager $issueManager, #[CurrentUser] ?User $user,): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $myIssues = $repository->findAll();
        } else {
            $myIssues = $repository->findBy(['user' => $user]);
        }

        return $this->render('tracker/myissues.html.twig', [
            'trackerIssues' => $myIssues,
            'issueStatuses' => $issueManager->getStatuses()
        ]);
    }


    #[Route('/issue/view/{issueId}', name: 'issue')]
    public function showIssue(int $issueId, Request $request, IssueRepository $repository, #[CurrentUser] ?User $user,): Response
    {
        $issue = $repository->find($issueId);

        return $this->render('tracker/issueView.html.twig', [
            'issue' => $issue
        ]);
    }

    #[Route('/issue/view/{issueId}', name: 'issueManage')]
    public function manageIssue(int $issueId, Request $request, IssueRepository $repository, #[CurrentUser] ?User $user,): Response
    {
        var_dump($issueId, 'TODO!');
        die;
        return $this->render('tracker/issueView.html.twig', []);
    }

    #[Route('/newIssue', name: 'new_issue')]
    public function newIssue(#[CurrentUser] ?User $user, AuthenticationUtils $authenticationUtils, Request $request, EntityManagerInterface $entityManager): Response
    {
        $issue = new Issue();
        $form = $this->createForm(IssueType::class, $issue);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            /** @var Issue $issue */
            $issue = $form->getData();
            $issue->setStatus(IssuesManager::STATUS_NEW);
            $issue->setCreatedAt(new \DateTime());
            if ($user->getId()) {
                $issue->setUser($user);
            }
            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($issue);
            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('home');
        }

        return $this->render('tracker/newissue.html.twig', [
            'form' => $form
        ]);
    }
}