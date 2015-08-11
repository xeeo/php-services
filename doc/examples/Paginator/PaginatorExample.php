<?php
require '../../../vendor/autoload.php';

require '../Resources/User/Mapper/User.php';

use \Xeeo\Services\Database\Mongo\Mapper as MongoMapper,
    \Xeeo\Services\Paginator\PaginatorApi,
    \Xeeo\Services\Database\Mongo\Filter;

MongoMapper::addConnection(array(
                                'name' => 'connectionName',
                                'url'  => 'mongodb://localhost:27017/databaseName'
                           ));


try {

    $users = UserMapper::find();

    /**
     * @var PaginatorApi $paginatorApi
     */
    $paginatorApi = PaginatorApi::getInstance();

    $paginatorApi->setCollection($users)
        ->setItemsPerPage(3)
        ->setCurrentPage(1)
        ->setUrlPattern("http://www.example.com/page/{#PAGE}")
        ->setHtmlTemplate('../Resources/Paginator/paginationTemplate.phtml');

    echo $paginatorApi->render();

} catch (\Exception $e) {
    print_r($e->getMessage());
}
