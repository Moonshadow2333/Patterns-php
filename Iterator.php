<?php
interface Aggregate
{
    public function iterator();
}
interface It
{
    public function hasNext();
    public function next();
}
class BookShelf implements Aggregate
{
    protected $books = array();
    protected $length;
    public function appendBook(Book $book)
    {
        $this->books[] = $book;
    }
    public function getLength()
    {
        return count($this->books);
    }
    public function getBookAt($index)
    {
        return $this->books[$index];
    }
    public function iterator()
    {
        return new BookShelfIterator($this);
    }
}
class Book
{
    protected $name;
    public function __construct($name)
    {
        $this->name = $name;
    }
    public function getBookName()
    {
        return $this->name;
    }
}
class BookShelfIterator implements It
{
    public $index = 0;
    public $bookShelf;
    public function __construct(BookShelf $bookShelf)
    {
        $this->bookShelf = $bookShelf;
    }
    public function hasNext()
    {
        if ($this->index<$this->bookShelf->getLength()) {
            return true;
        } else {
            return false;
        }
    }
    public function next()
    {
        $book = $this->bookShelf->getBookAt($this->index);
        $this->index++;
        return $book;
    }
}
class Main
{
    public static function client()
    {
        $bookShelf = new BookShelf();
        $bookShelf->appendBook(new Book('《book1》'));
        $bookShelf->appendBook(new Book('《book2》'));
        $bookShelf->appendBook(new Book('《book3》'));
        $bookShelf->appendBook(new Book('《book4》'));
        $iterator = $bookShelf->iterator();
        while ($iterator->hasNext()) {
            $book = $iterator->next();
            echo $book->getBookName().'<br/>';
        }
    }
}
Main::client();
