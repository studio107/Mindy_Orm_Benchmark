<?php

require_once __DIR__ . '/../../bootstrap.php';

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Model;
use Mindy\Query\Connection;

require_once(__DIR__ . '/../lib/BaseBenchmark.php');


class Author extends Model
{
    public function getFields()
    {
        return [
            'first_name' => ['class' => CharField::className()],
            'last_name' => ['class' => CharField::className()],
            'email' => ['class' => CharField::className()]
        ];
    }
}

class Book extends Model
{
    public function getFields()
    {
        return [
            'title' => ['class' => CharField::className()],
            'isbn' => ['class' => CharField::className()],
            'price' => ['class' => CharField::className()],
            'author' => ['class' => ForeignField::className(), 'modelClass' => Author::className()]
        ];
    }
}

class Mindy_Benchmark extends BaseBenchmark
{
    public function setUp()
    {
        Model::setConnection(new Connection([
            'dsn' => 'mysql:host=' . $this->host . ';dbname=' . $this->database,
            'username' => $this->user,
            'password' => $this->password,
            'charset' => 'utf8',
        ]));
    }

    public function benchInsert($author, $book)
    {
        $author = Author::objects()->getOrCreate([
            'id' => $author->id,
            'first_name' => $author->first_name,
            'last_name' => $author->last_name,
            'email' => $author->email
        ]);

        Book::objects()->getOrCreate([
            'id' => $book->id,
            'title' => $book->title,
            'isbn' => $book->isbn,
            'price' => $book->price,
            'author' => $author
        ]);
    }

    public function benchPkSearch($id)
    {
        $book = Book::objects()->filter(['pk' => $id])->get();
        $title = $book->title;
    }

    public function benchEnumerate()
    {
        $books = Book::objects()->paginate(1)->all();
        foreach ($books as $book) {
            $title = $book->title;
        }
    }

    public function benchSearch()
    {
        for ($i = 1; $i <= 10; $i++) {
            // count(a.id) as num replaced by max(a.id) as num
            $max = Author::objects()
                ->filter(['first_name' => 'John' . $i])
                ->orFilter(['last_name' => 'Doe' . $i])
                ->orFilter(['id__gt' => $i])->max('id');
        }
    }

    public function benchNPlus1()
    {
        $result = Book::objects()->paginate(1)->all();
        foreach ($result as $r) {
            $author = Author::objects()->filter(['id' => $r->author_id])->get();
        }
    }
}


