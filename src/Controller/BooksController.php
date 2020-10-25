<?php


namespace App\Controller;


use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @return Response
     */
    public function addBook(): Response
    {
        return $this->render('add_book.html.twig', [
            'title' => 'Добавление книги',
        ]);
    }

}