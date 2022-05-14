<?php
class Paginator {
    private $currentUrl;
    private $postsPerPage;
    private $singlePage;
    private $currentPage = 1;
    private $numOfPages = 1;
    public $content;
    
    public function __construct($contentList, $postsPerPage, $currentUrl) {
        $this->postsPerPage = $postsPerPage;
        $this->currentUrl = $currentUrl;
        
        if(count($contentList) == 1) {
            $this->singlePage = true;
            $this->numOfPages = 1;
            $this->content = $contentList;
        }
        else if(count($contentList) <= $this->postsPerPage) {
            $this->singlePage = false;
            $this->numOfPages = 1;
            $this->content = $contentList;
        }
        else {
            $this->singlePage = false;
            $this->numOfPages = ceil(count($contentList) / $postsPerPage);
            $this->currentPage = $this->_obtainCurrentPage();
            $this->content = $this->_calculatePagination($contentList);
        }
    }
    
    private function _obtainCurrentPage() {
        if (!empty($_GET['page']) && is_numeric(filter_input(INPUT_GET, "page"))) {
            $page = (int) floor(filter_input(INPUT_GET, "page"));
            if($page > 0 && $page <= $this->numOfPages) {
                return $page;
            }
            else return 1;
        }
        return 1;
    }
    
    private function _calculatePagination($contentList) {
        $out = array();
        
        $start = ($this->currentPage - 1) * $this->postsPerPage;
        for ($i = $start; $i < $start + min(count($contentList) - $start, $this->postsPerPage); $i++) {
            $out[] = $contentList[$i];
        }
        
        return $out;
    }
    
    public function isSinglePage() {
        return $this->singlePage;
    }
    
    public function hasPagination() {
        return ($this->numOfPages > 1);
    }
    
    public function hasPrevPage() {
        return ($this->currentPage > 1);
    }
    
    public function getPrevPage() {
        return ($this->currentPage > 1)? $this->currentPage-1 : null;
    }
    
    public function getPrevLink() {
        return $this->hasPrevPage()? $this->getPageLink($this->getPrevPage()) : null;
    }
    
    public function hasNextPage() {
        return ($this->currentPage < $this->numOfPages);
    }
    
    public function getNextPage() {
        return ($this->currentPage < $this->numOfPages)? $this->currentPage+1 : null;
    }
    
    public function getNextLink() {
        return $this->hasNextPage()? $this->getPageLink($this->getNextPage()) : null;
    }
    
    public function getNumOfPages() {
        return $this->numOfPages;
    }
    
    public function getCurrentPage() {
        return $this->currentPage;
    }
    
    public function getPageLink($i) {
        $getVariables = $_GET;
        unset($getVariables['q']);
        $getVariables['page'] = $i;
        $getStr = http_build_query($getVariables);
        return ($i > 0 && $i <= $this->getNumOfPages())? ($this->currentUrl."?".$getStr) : null;
    }
}