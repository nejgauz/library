<?php


namespace App\Controller;


use App\Entity\Book;
use App\Form\Type\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class BooksController extends AbstractController
{
    /**
     * @Route("/", name="list_books")
     * @return Response
     */
    public function listBooks(): Response
    {
        $books = $this->getDoctrine()
            ->getRepository(Book::class)
            ->findAll();
        return $this->render('books.html.twig', [
            'title' => 'Список книг',
            'books' => $books,
        ]);
    }

    /**
     * @Route("/delete/book/{id}", name="delete_book")
     * @param int $id
     * @return Response
     */
    public function deleteBook(int $id): Response
    {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);

        if (!$book) {
            throw new NotFoundHttpException();
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('list_books');

    }

    /**
     * @Route("/add/book", name="add_book")
     * @param Request $request
     * @return Response
     */
    public function addBook(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book, [
            'action' => $this->generateUrl('add_book')
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('list_books');

        }
        return $this->render('add_book.html.twig', [
            'form' => $form->createView(),
            'title' => 'Добавление книги',
        ]);
    }

    /**
     * @Route("/edit/book/{id}", name="edit_book")
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function editBook(Request $request, int $id): Response
    {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);
        if (!$book) {
            throw new NotFoundHttpException();
        }
        $form = $this->createForm(BookType::class, $book, [
            'action' => $this->generateUrl('edit_book', ['id' => $id])
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('list_books');

        }
        return $this->render('add_book.html.twig', [
            'form' => $form->createView(),
            'title' => 'Редактирование книги',
        ]);
    }

}