<?php
class Book {
    public $id;
    public $title;
    public $author;
    public $review;

    public function __construct($id, $title, $author, $review) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->review = $review;
    }
}
?>
