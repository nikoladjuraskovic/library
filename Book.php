<?php

namespace Books;

    class Book
    {
        public string $title {
            get {
                return $this->title;
            }
            set {
                $this->title = $value;
            }
        }
        public string $author {
            get {
                return $this->author;
            }
            set {
                $this->author = $value;
            }
        }
        public int $year {
            get {
                return $this->year;
            }
            set {
                $this->year = $value;
            }
        }

        public function __construct(string $title, string $author, int $year)
        {
            $this->title = $title;
            $this->author = $author;
            $this->year = $year;
        }


    }

