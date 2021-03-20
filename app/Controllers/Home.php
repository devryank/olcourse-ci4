<?php

namespace App\Controllers;

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

        if (!$validation->run($input, 'forgot')) {
            helper('form');
            $data = [
                'title' => 'Forgot Password',
            ];
            echo view('auth/forgot_user', $data);
        } else {
            // helper encrypt 
            helper('my_encrypt');
            $encrypt = here_encrypt($this->request->getPost('email'));
            $email = \Config\Services::email();
            $config = [
                'mailType'  => 'html',
                'charset'   => 'utf-8',
                'protocol'  => 'smtp',
                'SMTPHost' => 'smtp.gmail.com',
                'SMTPUser' => 'emailkamu@gmail.com',  // Email gmail
                'SMTPPass'   => 'passwordkamu',  // Password gmail
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
            <p><a href="http://localhost:8080/user/new-password/' . $encrypt['encode_replace'] . '">Reset Password</a></p>');

            if ($email->send()) {
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
        if (!$validation->run($input, 'new_password')) {
            echo view('auth/new_password_user', $data);
        } else {
            // hash inputan password
            $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            // update password berdasarkan email user
            $query = $this->master->update_data('users', ['email' => $email], ['password' => $password]);

            if ($query) {
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
        // form method get name="key"
        $search = $this->master->search($this->request->getGet('key'));
        $data = [
            'title' => 'Kursus - Online Course',
            'package_search' => $search['package_search'], // cari keyword di paket
            'class_search' => $search['class_search'], // cari keyword di kelas
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
        // list kelas berdasarkan paket
        $class_list = $this->master->get_join('classes', 'classes.class_id, classes.class_name, classes.slug, classes.img', 'class_packages', 'class_packages.class_id=classes.class_id', ['class_packages.package_id' => $course->package_id])->getResult();

        // cek user yang sedang login apakah sudah membeli paket
        $package = $this->master->get_select('transactions', 'id', [
            'option' => 'package',
            'user_id' => session()->get('user_id'),
            'course_end_date >=' => my_timezone()->format('Y-m-d H:i:s')
        ])->getRow();

        $check = is_object($package);

        if($check) {
            // jika ada data di transactions
            if($package->id == $course->package_id) {
                // sudah membeli paket
                $status = 1;
            } else {
                $status = 0;    
            }
        } else {
            // belum membeli paket
            $status = 0;
        }


        // menampilkan semua kelas dan topik dari paket
        $nama_kelas = array();
        $nama_topik = array();
        foreach ($class_list as $class_key => $class) {
            $nama_kelas[$class_key]['nama_kelas'] = $class->class_name;
            $topics = $this->master->get_select('topics', 'topic_name', ['class_id' => $class->class_id])->getResult();
            foreach ($topics as $topic) {
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
        $class = $this->master->get_select('transactions', 'id', [
            'option' => 'class',
            'id' => $course->class_id,
            'user_id' => session()->get('user_id'),
            'course_end_date >=' => my_timezone()->format('Y-m-d H:i:s')
        ])->getResult();
        $count_class = $this->master->count_data('transactions', [
            'option' => 'class',
            'id' => $course->class_id,
            'user_id' => session()->get('user_id'),
            'course_end_date >=' => my_timezone()->format('Y-m-d H:i:s')
        ]);
        // jika sudah membeli
        if ($count_class > 0) {
            for ($i = 0; $i < $count_class; $i++) {
                if ($class[$i]->id == $course->class_id) {
                    // sudah membeli
                    $status = '1';
                    break;
                }
            }
        } else {
            // belum membeli
            $status = '0';
        }


        // jika belum membeli kelas, maka cek di paket
        // apakah ada paket yang memiliki kelas ini?
        if ($status == '0') {
            $package = $this->master->get_select('transactions', 'id', [
                'option' => 'package',
                'user_id' => session()->get('user_id'),
                'course_end_date >=' => my_timezone()->format('Y-m-d H:i:s')
            ])->getResult();
            $count_package = $this->master->count_data('transactions', [
                'option' => 'package',
                'user_id' => session()->get('user_id'),
                'course_end_date >=' => my_timezone()->format('Y-m-d H:i:s')
            ]);

            // cek semua paket yang dibeli
            for ($i = 0; $i < $count_package; $i++) {
                $class_from_package[] = $this->master->get_select('class_packages', 'class_id', ['package_id' => $package[$i]->id])->getResult();

                // cek satu per satu kelas di dalam paket
                for ($j = 0; $j < count($class_from_package[$i]); $j++) {
                    // jika ada kelas di dalam paket yang sama id nya dengan kelas yang sedang dilihat
                    if ($class_from_package[$i][$j]->class_id == $course->class_id) {
                        // status sudah membeli kelas
                        $status = '1';
                        // keluar dari looping
                        break;
                    } else {
                        // belum membeli kelas
                        $status = '0';
                    }
                }
                if ($status == '1') {
                    // keluar dari looping
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
        if ($code == NULL) {
            $discount = 0;
            $data_sess = [
                'discount' => $discount,
                'discount_id' => NULL,
            ];
            session()->set($data_sess);
            return redirect()->route('cart');
        } else {
            // cari kode promo di db berdasarkan inputan
            $promo = $this->master->get_select('discounts', 'discount_id, promo_code, discount, from, to', ['promo_code' => $code])->getRow();
            if ($promo) {
                date_default_timezone_set("Asia/Jakarta");
                // jika ada promo yang tanggal awal nya lebih kecil dan tanggal berakhirnya lebih besar dari sekarang              
                if (($promo->from < date('Y-m-d H:i:s')) and ($promo->to > date('Y-m-d H:i:s'))) {
                    // masukkan data diskon ke session user
                    $discount = $promo->discount;
                    $data_sess = [
                        'discount' => $discount,
                        'discount_id' => $promo->discount_id,
                    ];
                    session()->set($data_sess);
                    // arahkan user ke cart
                    return redirect()->route('cart');
                } else {
                    session()->setFlashdata('message', '<div class="alert alert-danger">Kode promo tidak dapat digunakan!</div>');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('message', '<div class="alert alert-danger">Kode promo salah!</div>');
                return redirect()->back();
            }
        }
    }

    public function cart()
    {
        $url = $_SERVER['HTTP_REFERER']; // ambil url
        $url = array_filter(explode('/', $url)); // pisahkan url
        $category = $url[4];
        $slug = $url[5];
        $rand = rand(100, 199);
        // jika segmen url ke 4 == package
        if ($category == 'package') {
            // dapatkan data package
            $course = $this->master->get_select('packages', 'package_id, package_name, price, img', ['slug' => $slug])->getRow();
            // dapatkan list kelas dari package
            $class_list = $this->master->get_join('classes', 'classes.class_name, classes.slug, classes.img', 'class_packages', 'class_packages.class_id=classes.class_id', ['class_packages.package_id' => $course->package_id])->getResult();
            // total harga
            $total = $course->price + $rand - ($course->price * session()->get('discount') / 100);
            $data = [
                'title' => 'Pembelian Kursus - Online Course',
                'course' => $course,
                'class_list' => $class_list,
                'random_number' => $rand,
                'discount' => session()->get('discount'),
                'price' => $total
            ];
            // masukkan data berikut ke session
            $data_sess = [
                'type' => '01', // 01 untuk package (nantinya digunakan di transaction_id)
                'price' => $total,
                'package_id' => $course->package_id,
                'option' => 'package'
            ];
            session()->set($data_sess);
            echo view('user/cart-package', $data);

            // jika segmen url ke 4 == class
        } else if ($category == 'class') {
            // dapatkan data kelas
            $course = $this->master->get_select('classes', 'class_name, class_id, price, img', ['slug' => $slug])->getRow();
            // total harga
            $total = $course->price + $rand - ($course->price * session()->get('discount') / 100);
            $data = [
                'title' => 'Pembelian Kursus - Online Course',
                'course' => $course,
                'random_number' => $rand,
                'discount' => session()->get('discount'),
                'price' => $total
            ];
            // masukkan data berikut ke session
            $data_sess = [
                'type' => '02', // 02 untuk class (nantinya digunakan di transaction_id)
                'price' => $total,
                'class_id' => $course->class_id,
                'option' => 'class'
            ];
            session()->set($data_sess);
            echo view('user/cart-class', $data);
        } else {
            echo 'INVALID';
            die;
        }
    }

    public function buy()
    {
        if (session()->get('option') == 'package') {
            // ambil data package terakhir dari table transactions
            $transactions = $this->master->get_last_insert_id_where('transactions', 'transaction_id', ['option' => 'package'])->getRow();
            // jika 2 angka terakhir = 99
            if (substr($transactions->transaction_id, -2) == 99) {
                // id = 1
                $id = 1;
            } else {
                // jika tidak, maka digit terakhir + 1
                $id = substr($transactions->transaction_id + 1, -1);
            }
            $buy = [
                'transaction_id' => session()->get('type') . date("ymd") . str_pad($id, 4, '0', STR_PAD_LEFT),
                'user_id' => session()->get('user_id'),
                'id' => session()->get('package_id'),
                'option' => session()->get('option'),
                'order_date' => date("Y-m-d h:i:s"),
                'discount_id' => session()->get('discount_id'),
                'amount' => session()->get('price')
            ];
        } else if (session()->get('option') == 'class') {
            // ambil data package terakhir dari table transactions
            $transactions = $this->master->get_last_insert_id_where('transactions', 'transaction_id', ['option' => 'class'])->getRow();
            // jika 2 angka terakhir = 99
            if (substr($transactions->transaction_id, -2) == 99) {
                // id = 1
                $id = 1;
            } else {
                // jika tidak, maka digit terakhir + 1
                $id = substr($transactions->transaction_id + 1, -1);
            }
            $buy = [
                'transaction_id' => session()->get('type') . date("ymd") . str_pad($id, 4, '0', STR_PAD_LEFT),
                'user_id' => session()->get('user_id'),
                'id' => session()->get('class_id'),
                'option' => session()->get('option'),
                'order_date' => date("Y-m-d h:i:s"),
                'discount_id' => session()->get('discount_id'),
                'amount' => session()->get('price')
            ];
        }
        $query = $this->master->insert_data('transactions', $buy);
        session()->remove(['discount', 'discount_id', 'type', 'price', 'package_id', 'option']);
        if ($query) {
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
        if (!$validation->run($input, 'invoice')) {
            helper('form');
            $data = [
                'title' => 'Konfirmasi Pembayaran - Online Course',
            ];
            echo view('user/konfirmasi-pembayaran', $data);
        } else {
            // data transaksi berdasarkan id transaksi
            $query = $this->master->get_select('transactions', 'transaction_id', ['transaction_id' => $this->request->getPost('invoice_id')])->getRow();
            if ($query) {
                // update waiting confirmation ke 1
                // akan muncul di menu admin untuk dikonfirmasi
                $update = $this->master->update_data('transactions', ['transaction_id' => $this->request->getPost('invoice_id')], ['waiting_confirmation' => '1']);
                if ($update) {
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
        // cari token dari inputan user di table transactions
        $check = $this->master->get_select('transactions', 'id, option, token', ['token' => $this->request->getPost('token'), 'user_id' => session()->get('user_id')])->getRow();
        // jika ada
        if ($check) {
            // jika token dari transaksi package
            if ($check->option == 'package') {
                // ambil data durasi paket di table package
                $learning = $this->master->get_select('packages', 'duration', ['package_id' => $check->id])->getRow();
                // jika token dari transaksi package
            } else if ($check->option == 'class') {
                // ambil data durasi kelas di table classes
                $learning = $this->master->get_select('classes', 'duration', ['class_id' => $check->id])->getRow();
            } else {
                echo 'gagal';
            }

            // update data untuk table transactions
            $data = [
                'is_token_activated' => '1',
                'token_activated_date' => date("Y-m-d h:i:s"),
                'course_end_date' => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' + ' . $learning->duration . ' days')) // tanggal sekarang ditambah durasi paket/kelas
            ];
            $query = $this->master->update_data('transactions', ['token' => $this->request->getPost('token')], $data);
            if ($query) {
                session()->setFlashdata('message', '<div class="alert alert-success">Berhasil redeem kelas. <a href="' . site_url('home/dashboard') . '">Ke dashboard sekarang</a></div>');
                return redirect()->route('redeem');
            } else {
                session()->setFlashdata('message', '<div class="alert alert-danger">Gagal redeem token! Silahkan coba kembali</div>');
                return redirect()->route('redeem');
            }
        } else {
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
        // ambil data paket
        $package = $this->master->get_field('packages', ['slug' => $slug])->getRow();
        // cek tanggal berakhir paket 
        $end_date = $this->master->check_course_end_date(session()->get('user_id'), $package->package_id)->getRow();
        // jika tanggal berakhir paket sudah lewat
        if ($end_date->course_end_date < my_timezone()->format('Y-m-d H:i:s')) {
            $value_check = '1';
            // jika belum
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
            'listTopics' => $this->master->show_list_topics_left_passes(['topics.class_id' => $class->class_id])->getResult() // list topik yang belum dan sudah dilewati
        ];
        echo view('user/dashboard/topics', $data);
    }

    public function learn($class, $topic, $done = null)
    {
        $class = $this->master->get_field('classes', ['slug' => $class])->getRow();
        if ($done == FALSE) {
            $data = [
                'title' => 'Dashboard - Online Course',
                'className' => $class->class_name,
                'segment' =>  $this->request->uri->getSegments(),
                'topic' => $this->master->get_field('topics', ['slug' => $topic])->getRow()
            ];
            echo view('user/dashboard/learn', $data);
        } else {
            // jika segmen url 3 = done
            if ($this->request->uri->getSegments()[3] == 'done') {
                $arr_topics = [];
                $topics = $this->master->get_select('topics', 'topic_id, class_id, slug', ['class_id' => $class->class_id])->getResult();
                $this_topic = $this->master->get_select('topics', 'topic_id', ['slug' => $topic, 'class_id' => $class->class_id])->getRow();

                // insert data ke passes
                $data = [
                    'class_id' => $class->class_id,
                    'topic_id' => $this_topic->topic_id,
                    'user_id' => session()->get('user_id'),
                ];
                $query = $this->master->insert_data('passes', $data);
                // jika berhasil insert
                if ($query) {
                    foreach ($topics as $row) {
                        $arr_topics[] = $row->slug;
                    }
                    // cari slug topik di dalam arr_topics
                    $this_topic = array_search($this_topic->topic_id, $arr_topics, true);
                    // jika ada topik selanjutnya dari kelas ini
                    if (isset($arr_topics[$this_topic + 1])) {
                        // slug topik selanjutnya
                        $next = $arr_topics[$this_topic + 1];
                        // redirect ke topik selanjutnya
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
        // semua data paket yang sudah dibeli user
        $package = $this->master->get_select('transactions', 'id', ['option' => 'package', 'user_id' => session()->get('user_id')])->getResult();
        // hitung semua data paket yang sudah dibeli user
        $count_package = $this->master->count_data('transactions', ['option' => 'package', 'user_id' => session()->get('user_id')]);

        $class_data = []; // array penampung id kelas
        // cek setiap package
        for ($i = 0; $i < $count_package; $i++) {
            // ambil data kelas dari paket yang sedang dicek
            $class_from_package[] = $this->master->get_select('class_packages', 'class_id', ['package_id' => $package[$i]->id])->getResult();
            // hitung total kelas dari paket yang sedang dicek
            $count_class_from_package = $this->master->count_data('class_packages', ['package_id' => $package[$i]->id]);

            // looping kelas dari paket yang sedang dicek
            for ($j = 0; $j < $count_class_from_package; $j++) {
                // hitung topik dari kelas yang sedang dicek
                $count_topics_package[$i][$j] = $this->master->count_data('topics', ['class_id' => $class_from_package[$i][$j]->class_id]);
                // hitung topik yang sudah dilewati dari kelas yang sedang dicek
                $count_passes_package[$i][$j] = $this->master->count_data('passes', ['class_id' => $class_from_package[$i][$j]->class_id]);

                // jika jumlah topik dan jumlah topik yang sudah dilewati sama
                if ($count_topics_package[$i][$j] == $count_passes_package[$i][$j]) {
                    // jika tidak ada id kelas x di dalam array class_data
                    if (!(in_array($class_from_package[$i][$j]->class_id, $class_data))) {
                        // masukkan id kelas x ke class_data
                        $class_data[] = $class_from_package[$i][$j]->class_id;
                    }
                }
            }
        }

        // semua data paket yang sudah dibeli user
        $class = $this->master->get_select('transactions', 'id', ['option' => 'class', 'user_id' => session()->get('user_id')])->getResult();
        // hitung semua data paket yang sudah dibeli user
        $count_class = $this->master->count_data('transactions', ['option' => 'class', 'user_id' => session()->get('user_id')]);

        // cek setiap kelas
        for ($i = 0; $i < $count_class; $i++) {
            // hitung topik dari kelas yang sedang dicek
            $count_topics_class[] = $this->master->count_data('topics', ['class_id' => $class[$i]->id]);
            // hitung topik yang sudah dilewati dari kelas yang sedang dicek
            $count_passes_class[] = $this->master->count_data('passes', ['class_id' => $class[$i]->id]);

            // jika jumlah topik dan jumlah topik yang sudah dilewati sama
            if ($count_topics_class[$i] == $count_passes_class[$i]) {
                // jika tidak ada id kelas x di dalam array class_data
                if (!(in_array($class[$i]->id, $class_data))) {
                    // masukkan id kelas x ke class_data
                    $class_data[] = $class[$i]->id;
                }
            }
        }
        // jika jumlah data di dalam array class_data > 0
        if (count($class_data) > 0) {
            for ($i = 0; $i < count($class_data); $i++) {
                // ambil data kelas berdasarkan id kelas di dalam array class_data
                $class_list[] = $this->master->get_select('classes', 'classes.class_name, classes.slug, classes.img', ['class_id' => $class_data[$i]])->getRow();
            }
            // jika jumlah data di dalam array class_data == 0
        } else {
            // array class_list kosong
            $class_list = [];
        }
        $data = [
            'title' => 'Dashboard - Online Course',
            'class_list' => $class_list
        ];
        echo view('user/dashboard/lulus', $data);
    }
}
