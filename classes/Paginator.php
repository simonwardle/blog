<?php

/**
 * Paginator
 * For selecting a page of records
 */
class Paginator
{    
    /**
     * limit Number of records to return
     *
     * @var integer
     */
    public $limit;    
    /**
     * offset Number of records to skip before the page
     *
     * @var integer
     */
    public $offset;
    
    /**
     * __construct
     *
     * @param  integer $page Page number
     * @param  integer $records_per_page Number of records per page
     * @return void
     */
    public function __construct($page, $records_per_page)
    {
        $this->limit = $records_per_page;
        $this->offset = $records_per_page * ($page - 1);
    }

}