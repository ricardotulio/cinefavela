<?php
namespace CineFavela\TestCase;

use PDO;
use PHPUnit\Framework\TestCase;
use Respect\Relational\Mapper;

class RelationalRepositoryTestCase extends TestCase
{

    protected $mapper;

    public function __construct()
    {
        parent::__construct();
        $db = new PDO("mysql:host=localhost;dbname=cinefavela_test", "root", "123456");
        $this->mapper = new Mapper($db);
        $this->mapper->entityNamespace = "CineFavela\\Model\\";
    }
}