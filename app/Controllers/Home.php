<?php namespace App\Controllers;

use App\Models\Master_model;
use Class_model;
use Package_model;
class Home extends BaseController
{
    public function __construct()
    {
        $this->master = new Master_model();
    }

    public function index()
    {
        $data = [
            'title' => 'Online Course',
            'packages' => $this->master->show_popular_package()->getResult(),
            'countPackage' => $this->master->count_data_group('packages', [], 'package_name'),
            'countClass' => $this->master->count_data('classes', []),
            'countTopic' => $this->master->count_data('topics', []),
            'countUser' => $this->master->count_data('users', ['level' => 'user']),
        ];
        echo view('user/index', $data);
    }

    public function login()
    {
        helper('form');
        $data = [
            'title' => 'Login - Online Course',
        ];
        echo view('auth/login_user', $data);
    }

    public function register()
    {
        helper('form');
        $data = [
            'title' => 'Register - Online Course',
        ];
        echo view('auth/register_user', $data);
    }

    public function forgot()
    {
        helper('form');
        $data = [
            'title' => 'Forgot Password',
        ];
        echo view('auth/forgot_user', $data);
    }

    public function proses_forgot()
    {
        helper(['form', 'my_encrypt']);
        $data = [
            'title' => 'Forgot Password',
        ];
        $validation = \Config\Services::validation();
        $input = [
            'email' => $this->request->getPost('email')
        ];

        if(!$validation->run($input, 'forgot'))
        {
            helper('form');
            $data = [
                'title' => 'Forgot Password',
            ];
            echo view('auth/forgot_user', $data);
        }else
        {
            helper('my_encrypt');
            $encrypt = here_encrypt($this->request->getPost('email'));
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
            <p><a href="http://localhost:8080/user/new-password/'.$encrypt['encode_replace'].'">Reset Password</a></p>');

            if($email->send())
            {
                session()->setFlashdata('message', '<div class="alert alert-info">Cek E-mail kamu!</div>');
                return redirect()->route('user/login');
            } else {
                echo $email->printDebugger(['headers']);
                echo $email->printDebugger(['subject']);
                echo $email->printDebugger(['body']);
            }
        }
    }

    public function new_password($encode)
    {
        helper(['form', 'my_encrypt']);
        $data = [
            'title' => 'Forgot Password',
            'segment' =>  $this->request->uri->getSegments(),
        ];
        echo view('auth/new_password_user', $data);
    }

    public function proses_new_password($encode)
    {
        helper(['form', 'my_encrypt']);
        $email = here_decrypt($encode);
        
        $input = [
            'password' => $this->request->getPost('password'),
            're_password' => $this->request->getPost('re_password'),
        ];
        $validation = \Config\Services::validation();
        $data = [
            'title' => 'Forgot Password',
        ];
        if (!$validation->run($input, 'new_password'))
        {
            echo view('auth/new_password_user', $data);
        } else {
            $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            $query = $this->master->update_data('users', ['email' => $email], ['password' => $password]);

            if($query) 
            {
                session()->setFlashdata('message', '<div class="alert alert-success">Password berhasil diubah! Silahkan login.</div>');
                return redirect()->route('user/login');
            } else {
                session()->setFlashdata('message', '<div class="alert alert-danger">Password gagal diubah! Silahkan hubungi admin.</div>');
                return redirect()->route('user/login');
            }
        }
        
    }

    public function courses()
    {
        $data = [
            'title' => 'Kursus - Online Course',
            'packages' => $this->master->show_package_with_limit()->getResult(),
            'classes' => $this->master->show_class_with_limit()->getResult(),
        ];
        echo view('user/course', $data);
    }

    public function search()
    {
        $search = $this->master->search($this->request->getGet('key'));
        $data = [
            'title' => 'Kursus - Online Course',
            'package_search' => $search['package_search'],
            'class_search' => $search['class_search'],
        ];
        echo view('user/search', $data);
    }

    public function course_package()
    {
        $package_model = new Package_model();
        $data = [
            'title' => 'Kursus - Online Course',
            'packages' => $package_model->paginate(12, 'bootstrap'),
            'pager' => $package_model->pager,
        ];
        echo view('user/course-package', $data);
    }

    public function course_class()
    {
        $class_model = new Class_model();
        $data = [
            'title' => 'Kursus - Online Course',
            'classes' => $class_model->paginate(12, 'bootstrap'),
            'pager' => $class_model->pager,
        ];
        echo view('user/course-class', $data);
    }

    public function single_course_package($slug)
    {
        helper(['form', 'my_timezone']);
        $course = $this->master->get_field('packages', ['slug' => $slug])->getRow();
        $class_list = $this->master->get_join('classes', 'classes.class_id, classes.class_name, classes.slug, classes.img', 'class_packages', 'class_packages.class_id=classes.class_id', ['class_packages.package_id' => $course->package_id])->getResult();
        
        $package = $this->master->get_select('transactions', 'id', ['option' => 'package',
                                                                    'user_id' => session()->get('user_id'),
                                                                    'course_end_date >=' => my_timezone()->format('Y-m-d H:i:s')
                                                                    ])->getRow();
        
        if($package->id == $course->package_id)
        {
            $status = '1';
        } else {
            $status = '0';
        }

        $nama_kelas = array();
        $nama_topik = array();
        foreach ($class_list as $class_key => $class) 
        {
            $nama_kelas[$class_key]['nama_kelas'] = $class->class_name;
            $topics = $this->master->get_select('topics', 'topic_name', ['class_id' => $class->class_id])->getResult();
            foreach ($topics as $topic) 
            {
                $nama_topik[$class_key][] = $topic->topic_name;
            }
        }

        $data = [
            'title' => 'Paket ' . $course->package_name . ' - Online Course',
            'course' => $course,
            'class_list' => $class_list,
            'status' => $status,
            'class_curriculum' => $nama_kelas,
            'topic_curriculum' => $nama_topik
        ];
        echo view('user/single-course-package', $data);
    }
    
    public function single_course_class($slug)
    {
        helper(['form', 'my_timezone']);
        
        $course = $this->master->get_field('classes', ['slug' => $slug])->getRow();

        // cek apakah kelas sudah dibeli
        $class = $this->master->get_select('transactions', 'id', ['option' => 'class',
                                                                      'id' => $course->class_id,
                                                                      'user_id' => session()->get('user_id'),
                                                                      'course_end_date >=' => my_timezone()->format('Y-m-d H:i:s')
                                                                    ])->getResult();
            $count_class = $this->master->count_data('transactions', ['option' => 'class',
                                                                      'id' => $course->class_id,
                                                                      'user_id' => session()->get('user_id'),
                                                                      'course_end_date >=' => my_timezone()->format('Y-m-d H:i:s')
                                                                      ]);
            if($count_class > 0)
            {
                for ($i=0; $i < $count_class; $i++) 
                { 
                    if($class[$i]->id == $course->class_id)
                    {
                        $status = '1';
                        break;
                    }
                }
            } else {
                $status = '0';
            }      

        if($status == '0')
        {
            $package = $this->master->get_select('transactions', 'id', ['option' => 'package',
                                                                    'user_id' => session()->get('user_id'),
                                                                    'course_end_date >=' => my_timezone()->format('Y-m-d H:i:s')
                                                                    ])->getResult();
            $count_package = $this->master->count_data('transactions', ['option' => 'package',
                                                                        'user_id' => session()->get('user_id'),
                                                                        'course_end_date >=' => my_timezone()->format('Y-m-d H:i:s')
                                                                        ]);
            for ($i=0; $i < $count_package; $i++) 
            { 
                $class_from_package[] = $this->master->get_select('class_packages', 'class_id', ['package_id' => $package[$i]->id])->getResult();

                for ($j=0; $j < count($class_from_package[$i]); $j++) 
                { 
                    if($class_from_package[$i][$j]->class_id == $course->class_id)
                    {
                        $status = '1';
                        break;
                    } else {
                        $status = '0';
                    }
                }
                if($status == '1')
                {
                    break;
                }
            }
        }
        $curriculum = $this->master->get_select('topics', 'topic_name', ['class_id' => $course->class_id])->getResult();
        $data = [
            'title' => 'Paket ' . $course->class_name . ' - Online Course',
            'course' => $course,
            'status' => $status,
            'topics' => $curriculum
        ];
        echo view('user/single-course-class', $data);
    }

    public function check_promo()
    {
        $code = $this->request->getPost('promo_code');
        if($code == NULL)
        {
            $discount = 0;
            $data_sess = [
                'discount' => $discount,
                'discount_id' => NULL,
            ];
            session()->set($data_sess);
            return redirect()->route('cart');
        }else{
            $promo = $this->master->get_select('discounts', 'discount_id, promo_code, discount, from, to', ['promo_code' => $code])->getRow();
            if($promo)
            {
                date_default_timezone_set("Asia/Jakarta");                
                if(($promo->from < date('Y-m-d H:i:s')) AND ($promo->to > date('Y-m-d H:i:s')))
                {
                    $discount = $promo->discount;
                    $data_sess = [
                        'discount' => $discount,
                        'discount_id' => $promo->discount_id,
                    ];
                    session()->set($data_sess);
                    return redirect()->route('cart');
                }else{
                    session()->setFlashdata('message', '<div class="alert alert-danger">Kode promo tidak dapat digunakan!</div>');
                    return redirect()->back();
                }
            }else {
                session()->setFlashdata('message', '<div class="alert alert-danger">Kode promo salah!</div>');
                return redirect()->back();
            }
        }
    }

    public function cart()
    {
        $url = $_SERVER['HTTP_REFERER'];
        $url = array_filter(explode('/', $url));
        $category = $url[4];
        $slug = $url[5];
        $rand = rand(100, 199);
        if($category == 'package')
        {
            $course = $this->master->get_select('packages', 'package_id, package_name, price, img', ['slug' => $slug])->getRow();
            $class_list = $this->master->get_join('classes', 'classes.class_name, classes.slug, classes.img', 'class_packages', 'class_packages.class_id=classes.class_id', ['class_packages.package_id' => $course->package_id])->getResult();
            $total = $course->price + $rand - ($course->price * session()->get('discount') / 100);
            $data = [
                    'title' => 'Pembelian Kursus - Online Course',
                    'course' => $course,
                    'class_list' => $class_list,
                    'random_number' => $rand,
                    'discount' => session()->get('discount'),
                    'price' => $total
                ];
            $data_sess = [
                'type' => '01',
                'price' => $total,
                'package_id' => $course->package_id,
                'option' => 'package'
            ];
            session()->set($data_sess);
            echo view('user/cart-package', $data);
        }else if($category == 'class')
        {
            $course = $this->master->get_select('classes', 'class_name, class_id, price, img', ['slug' => $slug])->getRow();
            $total = $course->price + $rand - ($course->price * session()->get('discount') / 100);
            $data = [
                'title' => 'Pembelian Kursus - Online Course',
                'course' => $course,
                'random_number' => $rand,
                'discount' => session()->get('discount'),
                'price' => $total
            ];
            $data_sess = [
                'type' => '02',
                'price' => $total,
                'class_id' => $course->class_id,
                'option' => 'class'
            ];
            session()->set($data_sess);
            echo view('user/cart-class', $data);
        }else{
            echo 'INVALID';
            die;
        }
    }

    public function buy()
    {
        $count_transaction_id = $this->master->count_data('transactions', ['option' => 'package']);
        $buy = [
            'transaction_id' => session()->get('type') . date("ymd") . str_pad($count_transaction_id + 1, 4, '0', STR_PAD_LEFT),
            'user_id' => session()->get('user_id'),
            'id' => session()->get('package_id'),
            'option' => session()->get('option'),
            'order_date' => date("Y-m-d h:i:s"),
            'discount_id' => session()->get('discount_id'),
            'amount' => session()->get('price')
        ];
        $query = $this->master->insert_data('transactions', $buy);
        session()->remove(['discount', 'discount_id', 'type', 'price', 'package_id', 'option']);
        if($query) 
        {
            session()->setFlashdata('message', '<div class="alert alert-success">Berhasil melakukan pemesanan. Silahkan lakukan pembayaran kemudian isi form berikut. <a href="' . site_url('user/konfirmasi-pembayaran') . '">Klik disini</a></div>');
            return redirect()->route('user/invoice');
        } else {
            session()->setFlashdata('message', '<div class="alert alert-danger">Gagal melakukan pemesanan. Silahkan coba lagi.</div>');
            return redirect()->route('user/invoice');
        }
    }

    public function invoice()
    {
        $data = [
            'title' => 'Invoice - Online Course',
            'invoice' => $this->master->get_invoice(session()->get('user_id'))->getResult()
        ];
        echo view('user/invoice', $data);
    }

    public function konfirmasi_pembayaran()
    {
        helper('form');
        $data = [
            'title' => 'Konfirmasi Pembayaran - Online Course',
        ];
        echo view('user/konfirmasi-pembayaran', $data);
    }

    public function proses_konfirmasi_pembayaran()
    {
        $validation = \Config\Services::validation();
        $input = [
            'invoice_id' => $this->request->getPost('invoice_id')
        ];
        if(!$validation->run($input, 'invoice'))
        {
            helper('form');
            $data = [
                'title' => 'Konfirmasi Pembayaran - Online Course',
            ];
            echo view('user/konfirmasi-pembayaran', $data);
        } else {
            $query = $this->master->get_select('transactions', 'transaction_id', ['transaction_id' => $this->request->getPost('invoice_id')])->getRow();
            if($query)
            {
                $update = $this->master->update_data('transactions', ['transaction_id' => $this->request->getPost('invoice_id')], ['waiting_confirmation' => '1']);
                if($update)
                {
                    session()->setFlashdata('message', '<div class="alert alert-success">Berhasil submit invoice. Silahkan tunggu.</div>');
                    return redirect()->route('user/invoice');
                } else {
                    session()->setFlashdata('message', '<div class="alert alert-success">Gagal submit invoice. Silahkan coba lagi.</div>');
                    return redirect()->route('user/invoice');
                }
            } else {
                session()->setFlashdata('message', '<div class="alert alert-success">Invoice tidak ditemukan. Silahkan coba lagi.</div>');
                return redirect()->route('user/konfirmasi-pembayaran');
            }
        }
        
    }

    public function redeem()
    {
        helper('form');
        $data = [
            'title' => 'Redeem Token - Online Course',
        ];
        echo view('user/redeem', $data);
    }

    public function redeem_token()
    {
        $check = $this->master->get_select('transactions', 'id, option, token', ['token' => $this->request->getPost('token'), 'user_id' => session()->get('user_id')])->getRow();
        if($check)
        {
            if($check->option == 'package')
            {
                $learning = $this->master->get_select('packages', 'duration', ['package_id' => $check->id])->getRow();
            } else if($check->option == 'class'){
                $learning = $this->master->get_select('classes', 'duration', ['class_id' => $check->id])->getRow();
            } else {
                echo 'gagal';
            }

            $data = [
                'is_token_activated' => '1',
                'token_activated_date' => date("Y-m-d h:i:s"),
                'course_end_date' => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' + ' . $learning->duration . ' days'))
            ];
            $query = $this->master->update_data('transactions', ['token' => $this->request->getPost('token')], $data);
            if ($query) {
				session()->setFlashdata('message', '<div class="alert alert-success">Berhasil redeem kelas. <a href="' . site_url('home/dashboard') . '">Ke dashboard sekarang</a></div>');
				return redirect()->route('redeem');
			} else {
				session()->setFlashdata('message', '<div class="alert alert-danger">Gagal redeem token! Silahkan coba kembali</div>');
				return redirect()->route('redeem');
			}
        }else{
            session()->setFlashdata('message', '<div class="alert alert-danger">Gagal redeem token! Silahkan coba kembali</div>');
            return redirect()->route('redeem');
        }
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard - Online Course',
            'packages' => $this->master->show_package_or_class_user('packages', 'packages.package_id=transactions.id')->get()->getResult(),
            'count_packages' => $this->master->show_package_or_class_user('packages', 'packages.package_id=transactions.id')->countAllResults(),
            'classes' => $this->master->show_package_or_class_user('classes', 'classes.class_id=transactions.id')->get()->getResult(),
            'count_classes' => $this->master->show_package_or_class_user('classes', 'classes.class_id=transactions.id')->countAllResults(),
        ];
        echo view('user/dashboard/index', $data);
    }

    public function my_package($slug)
    {
        helper('my_timezone');
        $package = $this->master->get_field('packages', ['slug' => $slug])->getRow();
        $end_date = $this->master->check_course_end_date(session()->get('user_id'), $package->package_id)->getRow();
        if($end_date->course_end_date <= my_timezone()->format('Y-m-d H:i:s'))
        {
            $value_check = '1';
        } else {
            $value_check = '0';
        }
        $data = [
            'title' => 'Dashboard - Online Course',
            'packageName' => $package->package_name,
            'listClass' => $this->master->show_list_class($package->package_id)->getResult(),
            'value_check' => $value_check,
            'end_date' => $end_date,
        ];
        echo view('user/dashboard/list_class', $data);
    }

    public function topics($slug)
    {
        $class = $this->master->get_field('classes', ['slug' => $slug])->getRow();
        $data = [
            'title' => 'Dashboard - Online Course',
            'className' => $class->class_name,
            'segment' =>  $this->request->uri->getSegments(),
            'listTopics' => $this->master->show_list_topics_left_passes(['topics.class_id' => $class->class_id])->getResult()
        ];
        echo view('user/dashboard/topics', $data);
    }

    public function learn($class, $topic, $done = null)
    {
        $class = $this->master->get_field('classes', ['slug' => $class])->getRow();
        if($done == FALSE)
        {
            $data = [
                'title' => 'Dashboard - Online Course',
                'className' => $class->class_name,
                'segment' =>  $this->request->uri->getSegments(),
                'topic' => $this->master->get_field('topics', ['slug' => $topic])->getRow()
            ];
            echo view('user/dashboard/learn', $data);
        } else {
            if($this->request->uri->getSegments()[3] == 'done')
            {
                $arr_topics = [];
                $topics = $this->master->get_select('topics', 'topic_id, class_id, slug', ['class_id' => $class->class_id])->getResult();
                $this_topic = $this->master->get_select('topics', 'topic_id', ['slug' => $topic, 'class_id' => $class->class_id])->getRow();
                
                $data = [
                    'class_id' => $class->class_id,
                    'topic_id' => $this_topic->topic_id,
                    'user_id' => session()->get('user_id'),
                ];
                $query = $this->master->insert_data('passes', $data);
                if($query)
                {
                    foreach ($topics as $row) {
                        $arr_topics[] = $row->slug;
                    }
                    $this_topic = array_search($this_topic->topic_id, $arr_topics, true);
                    if(isset($arr_topics[$this_topic + 1]))
                    {
                        $next = $arr_topics[$this_topic + 1];
                        return $this->response->redirect(site_url('learn/' . $class->slug . '/' . $next)); 
                    } else {
                        return $this->response->redirect(site_url('topics/' . $class->slug)); 
                    }
                } else {
                    echo 'gagal';
                }
                               
            } else {
				return $this->response->redirect(site_url('learn/' . $class->slug . '/' . $topic));
            }
        }
    }

    public function lulus()
    {
        $package = $this->master->get_select('transactions', 'id', ['option' => 'package', 'user_id' => session()->get('user_id')])->getResult();
        $count_package = $this->master->count_data('transactions', ['option' => 'package', 'user_id' => session()->get('user_id')]);
        
        $class_data = [];
        for ($i=0; $i < $count_package; $i++) 
        { 
            $class_from_package[] = $this->master->get_select('class_packages', 'class_id', ['package_id' => $package[$i]->id])->getResult();
            $count_class_from_package = $this->master->count_data('class_packages', ['package_id' => $package[$i]->id]);
            
            for ($j=0; $j < $count_class_from_package; $j++) 
            { 
                $count_topics_package[$i][$j] = $this->master->count_data('topics', ['class_id' => $class_from_package[$i][$j]->class_id]);
                $count_passes_package[$i][$j] = $this->master->count_data('passes', ['class_id' => $class_from_package[$i][$j]->class_id]);

                if($count_topics_package[$i][$j] == $count_passes_package[$i][$j])
                {
                    if(!(in_array($class_from_package[$i][$j]->class_id, $class_data)))
                    {
                        $class_data[] = $class_from_package[$i][$j]->class_id;
                    }
                }
            }
        }
        
        $class = $this->master->get_select('transactions', 'id', ['option' => 'class', 'user_id' => session()->get('user_id')])->getResult();
        $count_class = $this->master->count_data('transactions', ['option' => 'class', 'user_id' => session()->get('user_id')]);

        for ($i=0; $i < $count_class; $i++) 
        { 
            $count_topics_class[] = $this->master->count_data('topics', ['class_id' => $class[$i]->id]);
            $count_passes_class[] = $this->master->count_data('passes', ['class_id' => $class[$i]->id]);
            
            if($count_topics_class[$i] == $count_passes_class[$i])
            {
                if(!(in_array($class[$i]->id, $class_data)))
                {
                    $class_data[] = $class[$i]->id;
                }
            }
        }
        if(count($class_data) > 0)
        {
            for ($i=0; $i < count($class_data); $i++) { 
                $class_list[] = $this->master->get_select('classes', 'classes.class_name, classes.slug, classes.img', ['class_id' => $class_data[$i]])->getRow();
            }
        } else {
            $class_list = [];
        }
        $data = [
            'title' => 'Dashboard - Online Course',
            'class_list' => $class_list
        ];
        echo view('user/dashboard/lulus', $data);
    }
}