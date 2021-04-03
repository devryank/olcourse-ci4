<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Validation_user implements FilterInterface
{
    protected $session;

    public function before(RequestInterface $request, $arguments = null)
    {
        $this->session = \Config\Services::session();
        if(!$this->session->has('full_name'))
        {
            session()->setFlashdata('message', '<div class="alert alert-warning">Silahkan login terlebih dahulu</div>');
            return redirect()->route('user/login');
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
       
    }
    
}
