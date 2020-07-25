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
            // ambil data user berdasarkan email
            $user = $this->master->get_field('users', ['email' => $this->request->getPost('email')])->getRow();
            // jika ada
            if($user)
            {
                // verify password
                if(password_verify($this->request->getPost('password'), $user->password))
                {
                    // jika akun user sudah aktif
                    if($user->is_active == '1')
                    {
                        // session user
                        $data_sess = [
                            'user_id' => $user->user_id,
                            'full_name' => $user->full_name,
                            'username' => $user->username,
                            'email' => $user->email,
                            'level' => $user->level
                        ];
                        session()->set($data_sess);
                        // jika level user == user
                        if($user->level == 'user')
                        {
                            session()->setFlashdata('message', '<div class="alert alert-success">Selamat datang, ' . $user->full_name . '</div>');
                            return redirect()->route('/');
                        // jika level user == admin
                        } else if($user->level == 'admin')
                        {
                            session()->setFlashdata('message', '<div class="alert alert-success">Selamat datang, ' . $user->full_name . '</div>');
                            return redirect()->route('admin');
                        // jika level user bukan user dan admin
                        } else {
                            session()->setFlashdata('message', '<div class="alert alert-danger">Gagal login! Silahkan coba kembali</div>');
                            return redirect()->route('auth');
                        }
                    // jika akun user belum aktif
                    } else {
                        session()->setFlashdata('message', '<div class="alert alert-danger">Akun kamu belum aktif! Silahkan cek email untuk verifikasi</div>');
                        return redirect()->route('auth');
                    }
                // jika password salah
                } else {
                    return redirect()->back()->with('message', '<div class="alert alert-danger">Password salah! Silahkan coba kembali</div>');
                }
            // jika akun tidak ditemukan
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
            // encode ubah username menjadi base64
            $encoded   = base64_encode($this->request->getPost('username'));
            
            // kirim email berisi link konfirmasi akun ke user
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
        // decode base64
        $username = base64_decode($encode);
        // verifikasi username user
        $query = $this->master->verification($username);
        // jika akun ditemukan dan berhasil update
        if($query)
        {
            session()->setFlashdata('message', '<div class="alert alert-success">Verifikasi berhasil! Silahkan login</div>');
            return redirect()->route('user/login');
        // jika akun tidak ditemukan
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
            // encode email menjadi base64
            $encoded = base64_encode($this->request->getPost('email'));
            
            // kirim email berisi link untuk membuat password ke user
            $email = \Config\Services::email();
            $config = [
                'mailType'  => 'html',
                'charset'   => 'utf-8',
                'protocol'  => 'smtp',
                'SMTPHost' => 'smtp.gmail.com',
                'SMTPUser' => 'emailkamu@gmail.com',  // Email gmail admin
                'SMTPPass'   => 'gantipassword',  // Password gmail admin
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
        // jika user logout
        if(session()->get('level') == 'user')
        {
            session()->destroy();
            // redirect ke user/login
            return redirect()->route('user/login');            
        // jika admin logout
        } else if(session()->get('level') == 'admin')
        {
            session()->destroy();
            // redirect ke auth
            return redirect()->route('auth');
        }else{
            echo 'ERROR';
        }
    } 
}