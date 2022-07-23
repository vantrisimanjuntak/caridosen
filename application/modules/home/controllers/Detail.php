<?php class Detail extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    function detail()
    {
        $nipDosen = $this->uri->segment(2);
        echo $nipDosen;
    }
}
