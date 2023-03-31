<?php

namespace App\Controller;

use App\Entity\Employes;
use App\Event\AddEmployeEvent;
use App\Event\AllEmployeEvent;
use App\Services\UploadServices;
use App\Form\EmployesType;
use App\Form\SearchDataType;
use App\model\SearchData;
use App\Repository\EmployesRepository;
use App\Services\Helpers;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[
    Route('/employes'),
    IsGranted('ROLE_USER')
]
class EmployesController extends AbstractController
{
public function __construct(
    private EventDispatcherInterface $dispatcher,
    private EntityManagerInterface $entityManager,
    private EmployesRepository $employesRepository,
    private Helpers $SearchService,
)
{}

    #[
        Route('/', name: 'app_employes_index', methods: ['GET'])
    ]
    public function index(
        Request $request
        ): Response
    {
        $nbemployes =  $this->employesRepository->count([]);
        $AllEmployeEvent = new AllEmployeEvent($nbemployes);
        $this->dispatcher->dispatch($AllEmployeEvent, AllEmployeEvent::All_Employe_Event);
        $searchdata = new SearchData();
        $formSearch = $this->createForm(SearchDataType::class,$searchdata);
        $formSearch->handleRequest($request);
        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            //$searchTerm = $request->query->get("".$search_data[Search]);
            $Empls = $this->employesRepository->findBySearch($searchdata->getSearch());
            return $this->render('employes/index.html.twig',[
                'formSearch'=>$formSearch->createView(),
                'employes'=>$Empls
            ]);
        }
        return $this->render('employes/index.html.twig', [
            'employes' => $this->employesRepository->findAll(),
            'formSearch'=>$formSearch->createView()
        ]);
    }

    #[Route('/new', name: 'app_employes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EmployesRepository $employesRepository): Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $employe = new Employes();
        $form = $this->createForm(EmployesType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employesRepository->save($employe, true);
            return $this->redirectToRoute('app_employes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employes/new.html.twig', [
            'employe' => $employe,
            'form' => $form,
        ]);
    }
    #[Route('/add',name:'app_employes_add')]
    public function addEmploye(
        PersistenceManagerRegistry $doctrine, 
        Request $request,
        UploadServices $uploadServices):Response
    { 
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $employe = new Employes();
        $form = $this->createForm(EmployesType::class, $employe);
        //$form->remove('nome');
        // mn formulaire va aller traiter la requete 
        $form->handleRequest($request);
        $searchdata = new SearchData();
        $formSearch = $this->createForm(SearchDataType::class,$searchdata);
        $formSearch->handleRequest($request);
        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            //$searchTerm = $request->query->get("".$search_data[Search]);
            $Empls = $this->employesRepository->findBySearch($searchdata->getSearch());
            return $this->render('employes/index.html.twig',[
                'formSearch'=>$formSearch->createView(),
                'employes'=>$Empls
            ]);
        }
        // Est ce que le fomulaire a été soumis
        if($form->isSubmitted()&& $form->isValid())
        {
            // si oui,
            // on va ajouter l'objet personne dans la base de données 
            $photo = $form->get('photo')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($photo) {
                $directory= $this->getParameter('employes_directory');
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $employe->setImage($uploadServices->uploadFile($photo,$directory));
            } 
            //dd($employe);
            //dd($form->getData());
            $employe->setCreatedBy($this->getUser());
            $manager=$doctrine->getManager();
            $manager->persist($employe);
            $manager->flush();

            // on va créer l'evenement
            $addEmployeEvent = new AddEmployeEvent($employe);
            // on va dispatcher cet événement
            $this->dispatcher->dispatch($addEmployeEvent,AddEmployeEvent::Add_Employe_Event);
            //Afficher un message de succés
            $this->addFlash('succes',"".$employe->getNom()." ".$employe->getPrenom()." a été ajouté avec succés");
            // Rediger verts la liste des personne
            return $this->redirectToRoute('app_employes_index');
        }
        else
        {
            // si non 
            // on affiche notre formulaire
            return $this->render('employes/new.html.twig',[
                'form' => $form->createView(),
                'formSearch'=>$formSearch->createView(),
            ]);
        }
    }

    #[Route('/{id}/show', name: 'app_employes_show', methods: ['GET','POST'])]
    public function show(Employes $employe,Request $request): Response
    {
        $searchdata = new SearchData();
        $formSearch = $this->createForm(SearchDataType::class,$searchdata);
        $formSearch->handleRequest($request);
        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            //$searchTerm = $request->query->get("".$search_data[Search]);
            $Empls = $this->employesRepository->findBySearch($searchdata->getSearch());
            return $this->render('employes/index.html.twig',[
                'formSearch'=>$formSearch->createView(),
                'employes'=>$Empls
            ]);
        }
        return $this->render('employes/show.html.twig', [
            'employe' => $employe,
            'formSearch'=>$formSearch->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_employes_edit', methods: ['GET', 'POST'])]
    public function edit(
        Employes $employe, 
        Request $request,
        UploadServices $uploadServices): Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        // creation une form adapté a l'employee

        $form = $this->createForm(EmployesType::class, $employe);
        $form->handleRequest($request);
        $searchdata = new SearchData();
        $formSearch = $this->createForm(SearchDataType::class,$searchdata);
        $formSearch->handleRequest($request);
        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            //$searchTerm = $request->query->get("".$search_data[Search]);
            $Empls = $this->employesRepository->findBySearch($searchdata->getSearch());
            return $this->render('employes/index.html.twig',[
                'formSearch'=>$formSearch->createView(),
                'employes'=>$Empls
            ]);
        }
        // test si déja submit ou valid
        if ($form->isSubmitted() && $form->isValid()) {
            // si oui, on save la modification dans la base de donnée
            $photo = $form->get('photo')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($photo) {
                $directory= $this->getParameter('employes_directory');
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $employe->setImage($uploadServices->uploadFile($photo,$directory));
            }
            $this->employesRepository->save($employe, true);
            //Afficher un message de succés
            $this->addFlash('succes',"".$employe->getNom()." ".$employe->getPrenom()." a été Modifié avec succés");
            // rediger dans la page all Employes
            return $this->redirectToRoute('app_employes_index', [], Response::HTTP_SEE_OTHER);
        }
        //sinon, on afficher la formulaire pour fait la modification
        return $this->render('employes/edit.html.twig', [
            'employe' => $employe,
            'form' => $form->createView(),
            'formSearch'=>$formSearch->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_employes_delete', methods: ['POST'])]
    public function delete(Employes $employe,Request $request): Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        if ($this->isCsrfTokenValid('delete'.$employe->getId(), $request->get('_token'))) {
            // delete l'employe 
            $this->employesRepository->remove($employe, true);
            //Afficher un message de suppression
            $this->addFlash('delete',"".$employe->getNom()." ".$employe->getPrenom()." a été supprimé");
        }
        // rediger dans la page all Employes
        return $this->redirectToRoute('app_employes_index', [], Response::HTTP_SEE_OTHER);
    }
}
