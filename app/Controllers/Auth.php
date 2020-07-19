<?php namespace App\Controllers;

use App\Models\Master_model;
use CodeIgniter\Controller;
class Auth extends Controller {

    protected $master;

    public function __construct()
    {
        $this->master = new Master_model();
    }

    public function index()
    {
        helper('form');
        $data = [
            'title' => 'Login',
        ];
        echo view('auth/login', $data);
    }

    public function proses_login()
    {
        helper('form');
        $validation = \Config\Services::validation();
        $input = [
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ];
        if(!$validation->run($input, 'login'))
        {
            $data = [
                'title' => 'Login'
            ];
            helper('form');
            echo view('auth/login', $data);
        } else {
            $user = $this->master->get_field('users', ['email' => $this->request->getPost('email')])->getRow();
            if($user)
            {
                if(password_verify($this->request->getPost('password'), $user->password))
                {
                    if($user->is_active == '1')
                    {
                        $data_sess = [
                            'user_id' => $user->user_id,
                            'full_name' => $user->full_name,
                            'username' => $user->username,
                            'email' => $user->email,
                            'level' => $user->level
                        ];
                        session()->set($data_sess);
                        if($user->level == 'user')
                        {
                            session()->setFlashdata('message', '<div class="alert alert-success">Selamat datang, ' . $user->full_name . '</div>');
                            return redirect()->route('/');
                        } else if($user->level == 'admin')
                        {
                            session()->setFlashdata('message', '<div class="alert alert-success">Selamat datang, ' . $user->full_name . '</div>');
                            return redirect()->route('admin');
                        } else {
                            session()->setFlashdata('message', '<div class="alert alert-danger">Gagal login! Silahkan coba kembali</div>');
                            return redirect()->route('auth');
                        }
                    } else {
                        session()->setFlashdata('message', '<div class="alert alert-danger">Akun kamu belum aktif! Silahkan cek email untuk verifikasi</div>');
                        return redirect()->route('auth');
                    }
                } else {
                    return redirect()->back()->with('message', '<div class="alert alert-danger">Password salah! Silahkan coba kembali</div>');
                }
            } else {
                return redirect()->back()->with('message', '<div class="alert alert-danger">Akun tidak terdaftar! Silahkan mendaftar terlebih dahulu</div>');
            }
        }
    }

    public function proses_register()
    {
        helper('form');
        $validation = \Config\Services::validation();
        $input = [
            'full_name' => $this->request->getPost('full_name'),
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            're_password' => $this->request->getPost('re_password'),
        ];
        if(!$validation->run($input, 'register'))
        {
            $data = [
                'title' => 'Registrasi'
            ];
            helper('form');
            echo view('auth/register', $data);
        } else {
            $input = [
                'full_name' => $this->request->getPost('full_name'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            ];
            $encoded   = base64_encode($this->request->getPost('username'));
            
            $email = \Config\Services::email();
            $config = [
                'mailType'  => 'html',
                'charset'   => 'utf-8',
                'protocol'  => 'smtp',
                'SMTPHost' => 'smtp.gmail.com',
                'SMTPUser' => 'emailkamu@gmail.com',  // Email gmail
                'SMTPPass'   => 'gantipassword',  // Password gmail
                'smtpCrypto' => 'ssl',
                'smtpPort'   => 465,
                'CRLF'    => "\r\n",
                'newline' => "\r\n"
            ];
            $email->initialize($config);
            $email->setFrom('emailkamu@gmail.com', 'Ryan Course');
            $email->setTo($this->request->getPost('email'));

            $email->setSubject('Konfirmasi E-mail');
            $email->setMessage('
            <p>Terima kasih telah mendaftar! Silahkan klik link berikut untuk mengaktifkan akun</p>
            <p><a href="http://localhost:8080/auth/confirmation/' . $encoded . '">Klik disini</a></p>
            ');

            if($email->send())
            {
                echo 'berhasil';
            } else {
                echo 'gagal';
            }
            $query = $this->master->insert_data('users', $input);
            if($query)
            {
                return redirect()->back()->with('message', '<div class="alert alert-success">Berhasil mendaftar! Silahkan cek email kamu</div>');
            } else {
                return redirect()->back()->with('message', '<div class="alert alert-danger">Gagal mendaftar! Silahkan coba kembali</div>');
            }
        }
    }

    public function confirmation($encode)
    {
        $username = base64_decode($encode);
        $query = $this->master->verification($username);
        if($query)
        {
            session()->setFlashdata('message', '<div class="alert alert-success">Verifikasi berhasil! Silahkan login</div>');
            return redirect()->route('user/login');
        } else {
            session()->setFlashdata('message', '<div class="alert alert-danger">Verifikasi gagal! Silahkan hubungi admin</div>');
            return redirect()->route('user/login');
        }
    }

    public function forgot_password()
    {
        helper('form');
        $data = [
            'title' => 'Forgot Password',
        ];
        echo view('auth/forgot', $data);
    }

    public function proses_forgot_password()
    {
        helper('form');
        $data = [
            'title' => 'Forgot Password',
        ];
        $validation = Config\Services::Validation();
        $input = [
            'email' => $this->request->getPost('email')
        ];

        if(!$validation->run($input, 'forgot'))
        {
            helper('form');
            $data = [
                'title' => 'Forgot Password',
            ];
            echo view('auth/forgot', $data);
        }else
        {
            $encoded = base64_encode($this->request->getPost('email'));
            
            $email = \Config\Services::email();
            $config = [
                'mailType'  => 'html',
                'charset'   => 'utf-8',
                'protocol'  => 'smtp',
                'SMTPHost' => 'smtp.gmail.com',
                'SMTPUser' => 'emailkamu@gmail.com',  // Email gmail
                'SMTPPass'   => 'gantipassword',  // Password gmail
                'smtpCrypto' => 'ssl',
                'smtpPort'   => 465,
                'CRLF'    => "\r\n",
                'newline' => "\r\n"
            ];
            $email->initialize($config);
            $email->setFrom('emailkamu@gmail.com', 'Ryan Course');
            $email->setTo($this->request->getPost('email'));

            $email->setSubject('Verification Link - Forgot Password');
            $email->setMessage('
            <p>Klik link di bawah ini untuk membuat password baru.</p>
            <p><a href="http://localhost:8080/auth/new-password/' . $encoded . '">Reset Password</a></p>
            ');

            if($email->send())
            {
                session()->setFlashdata('message', '<div class="alert alert-info">Silahkan cek email kamu!</div>');
                return redirect()->route('user/login');
            } else {
                echo $email->printDebugger(['headers']);
                echo $email->printDebugger(['subject']);
                echo $email->printDebugger(['body']);
            }
        }
    }

    public function logout()
    {
        if(session()->get('level') == 'user')
        {
            session()->destroy();
            return redirect()->route('user/login');            
        } else if(session()->get('level') == 'admin')
        {
            session()->destroy();
            return redirect()->route('auth');
        }else{
            echo 'ERROR';
        }
    } 
}