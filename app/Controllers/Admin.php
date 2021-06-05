<?php

namespace App\Controllers;

use App\Models\Master_model;
use CodeIgniter\Controller;

class Admin extends Controller
{
	public function __construct()
	{
		$this->master = new Master_model();
	}

	public function index()
	{
		// helper timezone (jakarta)
		helper('my_timezone');
		$number_of_users = $this->master->count_data('users', ['level' => 'user', 'is_active' => '1']);
		$number_of_packages = $this->master->count_data('packages', []);
		$number_of_classes = $this->master->count_data('classes', []);

		// hitung jumlah transaksi yang terjadi hari ini
		$number_of_transactions = $this->master->count_data('transactions', [
			'order_date >=' => my_timezone()->format('Y-m-d 00:00:00'),
			'order_date <=' => my_timezone()->format('Y-m-d 23:59:59')
		]);

		// LINE CHART
		// data bulan yang memiliki transaksi
		$month_data = $this->master->getMonth()->getResult();
		$label_month = [];
		foreach ($month_data as $value) {
			$label_month[] = $value->bulan;
		}

		// total transaksi per bulan
		$transaction_data = $this->master->totalTransactionsPerMonth()->getResult();
		$label_transaction = [];
		foreach ($transaction_data as $value) {
			$label_transaction[] = $value->jml;
		}

		// PIE CHART
		// pembelian paket bulan ini
		$transaction_package_this_month = $this->master->get_select('transactions', 'count(id) as total', ['option' => 'package', 'is_paid' => '1', 'MONTH(payment_date)' => my_timezone()->format('m')])->getRow();
		// pembelian kelas bulan ini
		$transaction_class_this_month = $this->master->get_select('transactions', 'count(id) as total', ['option' => 'class', 'is_paid' => '1', 'MONTH(payment_date)' => my_timezone()->format('m')])->getRow();
		$data = [
			'title' => 'Admin',
			'segment' => $this->request->uri->getSegments(),
			'number_of_users' => $number_of_users,
			'number_of_packages' => $number_of_packages,
			'number_of_classes' => $number_of_classes,
			'number_of_transactions' => $number_of_transactions,
			'labelMonth' => json_encode($label_month),
			'labelTransaction' => json_encode($label_transaction),
			'transaction_package_this_month' => $transaction_package_this_month,
			'transaction_class_this_month' => $transaction_class_this_month,
		];
		echo view('dashboard/index', $data);
	}

	public function kelas()
	{
		$data = [
			'title' => 'Master Kelas',
			'segment' => $this->request->uri->getSegments(),
			'listKelas' => $this->master->get_all('classes')->getResult()
		];
		echo view('dashboard/master/kelas/view', $data);
	}

	public function tambah_kelas()
	{
		helper(['form', 'url']);
		$data = [
			'title' => 'Master Kelas',
			'segment' => $this->request->uri->getSegments(),
		];
		echo view('dashboard/master/kelas/add', $data);
	}

	public function proses_tambah_kelas()
	{
		helper(['form', 'url']);
		$validation = \Config\Services::validation();
		$input = [
			'class_name' => $this->request->getPost('class_name'),
			'price' => $this->request->getPost('price'),
			'img' => $this->request->getFile('img'),
			'detail' => $this->request->getPost('detail'),
			'duration' => $this->request->getPost('duration'),
		];
		if (!$validation->run($input, 'class')) {
			helper(['form', 'url']);
			$data = [
				'title' => 'Master Kelas',
				'segment' => $this->request->uri->getSegments(),
			];
			echo view('dashboard/master/kelas/add', $data);
		} else {
			// data terakhir dari table classes
			$last_id = $this->master->get_last_insert_id('classes', 'class_id')->getRow();
			// nama gambar yang diinsert
			$avatar = $this->request->getFile('img');
			// random nama
			$name = $avatar->getRandomName();
			$input = [
				// id kelas terakhir + 1
				'class_id' => $last_id->class_id + 1,
				'class_name' => $this->request->getPost('class_name'),
				'slug' => url_title(strtolower($this->request->getPost('class_name'))),
				'price' => $this->request->getPost('price'),
				'detail' => $this->request->getPost('detail'),
				'duration' => $this->request->getPost('duration'),
				'img' => $name
			];
			$avatar->move('assets/uploads/classes', $name);
			$query = $this->master->insert_data('classes', $input);
			if ($query) {
				session()->setFlashdata('message', '<div class="alert alert-success">Berhasil menambahkan kelas</div>');
				return redirect()->route('admin/kelas');
			} else {
				session()->setFlashdata('message', '<div class="alert alert-danger">Gagal menambahkan kelas</div>');
				return redirect()->route('admin/kelas/tambah');
			}
		}
	}

	public function edit_kelas($slug)
	{
		helper(['form', 'url']);
		$data = [
			'title' => 'Master Kelas',
			'segment' => $this->request->uri->getSegments(),
			'slug' => $slug,
			'data' => $this->master->get_field('classes', ['slug' => $slug])->getRow(),
		];
		echo view('dashboard/master/kelas/edit', $data);
	}

	public function proses_edit_kelas($slug)
	{
		helper('form');
		$validation = \Config\Services::validation();
		$input = [
			'class_name' => $this->request->getPost('class_name'),
			'price' => $this->request->getPost('price'),
			'detail' => $this->request->getPost('detail'),
			'duration' => $this->request->getPost('duration'),
		];
		if (!$validation->run($input, 'edit_class')) {
			$data = [
				'title' => 'Master Kelas',
				'segment' => $this->request->uri->getSegments(),
			];
			echo view('dashboard/master/kelas/edit', $data);
		} else {
			// nama file gambar yang diinsert
			$avatar = $this->request->getFile('img');
			// jika user tidak input gambar
			if ($avatar->getName() == '') {
				// input data tanpa img
				$input = [
					'class_name' => $this->request->getPost('class_name'),
					'slug' => url_title(strtolower($this->request->getPost('class_name'))),
					'price' => $this->request->getPost('price'),
					'detail' => $this->request->getPost('detail'),
					'duration' => $this->request->getPost('duration'),
				];
			} else {
				$name = $avatar->getRandomName();
				$file_name = $this->master->get_field('classes', ['slug' => $slug])->getRow()->img;
				unlink('assets/uploads/' . $file_name);
				$input = [
					'class_name' => $this->request->getPost('class_name'),
					'slug' => url_title(strtolower($this->request->getPost('class_name'))),
					'price' => $this->request->getPost('price'),
					'img' => $name,
					'detail' => $this->request->getPost('detail'),
					'duration' => $this->request->getPost('duration'),
				];
				$avatar->move('assets/uploads/', $name);
			}
			$query = $this->master->update_data('classes', ['slug' => $slug], $input);
			if ($query) {
				session()->setFlashdata('message', '<div class="alert alert-success">Berhasil mengubah kelas</div>');
				return redirect()->route('admin/kelas');
			} else {
				session()->setFlashdata('message', '<div class="alert alert-danger">Gagal mengubah kelas</div>');
				return $this->response->redirect(site_url('admin/kelas/edit/' . $slug));
			}
		}
	}

	public function delete_kelas($slug)
	{
		$delete_file = $this->master->get_field('classes', ['slug' => $slug])->getRow();
		$file_name = $delete_file->img;
		unlink('assets/uploads/' . $file_name);
		$query = $this->master->delete_data('classes', ['slug' => $slug]);
		if ($query) {
			session()->setFlashdata('message', '<div class="alert alert-success">Berhasil menghapus kelas</div>');
			return redirect()->route('admin/kelas');
		} else {
			session()->setFlashdata('message', '<div class="alert alert-danger">Gagal menghapus kelas</div>');
			return redirect()->route('admin/kelas');
		}
	}

	public function topik()
	{
		$data = [
			'title' => 'Master Topik',
			'segment' => $this->request->uri->getSegments(),
			'listTopic' => $this->master->get_topik()->getResult()
		];
		echo view('dashboard/master/topik/view', $data);
	}

	public function tambah_topik()
	{
		helper('form');
		$data = [
			'title' => 'Master Topik',
			'segment' => $this->request->uri->getSegments(),
			'listClasses' => $this->master->get_all('classes')->getResult()
		];
		echo view('dashboard/master/topik/add', $data);
	}

	// FUNCTION UNTUK UPLOAD IMAGE MENGGUNAKAN CKEDITOR
	public function add_image()
	{
		if (isset($_FILES['upload']['name'])) {
			$file = $_FILES['upload']['tmp_name'];
			$file_name = $_FILES['upload']['name'];
			$file_name_array = explode(".", $file_name);
			$extension = end($file_name_array);
			$new_image_name = rand() . '.' . $extension;
			chmod('assets/uploads/topik', 0777);
			$allowed_extension = array("jpg", "gif", "png");
			if (in_array($extension, $allowed_extension)) {
				move_uploaded_file($file, 'assets/uploads/topik/' . $new_image_name);
				$function_number = $_GET['CKEditorFuncNum'];
				$url = 'assets/uploads/topik/' . $new_image_name;
				$message = '';
				echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
			}
		}
	}

	public function proses_tambah_topik()
	{
		helper('form');
		$validation = \Config\Services::validation();
		$input = [
			'class_id' => $this->request->getPost('class_id'),
			'topic_name' => $this->request->getPost('topic_name'),
			'number' => $this->request->getPost('number'),
			'content' => $this->request->getPost('content'),
		];
		if (!$validation->run($input, 'topic')) {
			helper('form');
			$data = [
				'title' => 'Master Topik',
				'segment' => $this->request->uri->getSegments(),
				'listClasses' => $this->master->get_all('classes')->getResult()
			];
			echo view('dashboard/master/topik/add', $data);
		} else {
			$content_videos_link = $this->request->getPost('content_videos');
			$content_videos_replace = str_replace('https://www.youtube.com/watch?v=','https://www.youtube.com/embed/',$content_videos_link);
			
			$input = [
				'class_id' => $this->request->getPost('class_id'),
				'topic_name' => $this->request->getPost('topic_name'),
				'number' => $this->request->getPost('number'),
				'slug' => url_title(strtolower($this->request->getPost('topic_name'))),
				'content_videos' => $content_videos_replace,
				'content' => $this->request->getPost('content'),
			];

			// FITUR NUMBERING UNTUK TOPIK

			// hitung topik yang nomornya >= dengan nomor yang diinput
			$count_data_topics = $this->master->count_data('topics', ['number >=' => $this->request->getPost('number'), 'class_id' => $this->request->getPost('class_id')]);
			// jika ada nomor yang lebih besar dari nomor yang diinput
			if ($count_data_topics > 0) {
				$get_all_number = $this->master->get_select('topics', 'topic_id, number', ['class_id' => $this->request->getPost('class_id'), 'number >=' => $this->request->getPost('number')])->getResult();
				$topic_id = [];
				$number = [];
				foreach ($get_all_number as $row) {
					$topic_id[] = $row->topic_id;
					$number[] = $row->number;
				}
				for ($i = 0; $i < $count_data_topics; $i++) {
					$data[$i] = [
						'topic_id' => $topic_id[$i],
						// semua nomor yang >= dari inputan number ditambah 1 agar tidak ada yang bentrok
						'number' => $number[$i] + 1
					];
				}
				$query = $this->master->update_data_batch('topics', $data, 'topic_id');
			}
			$query = $this->master->insert_data('topics', $input);
			if ($query) {
				session()->setFlashdata('message', '<div class="alert alert-success">Berhasil menambahkan topik</div>');
				return redirect()->route('admin/topik');
			} else {
				session()->setFlashdata('message', '<div class="alert alert-danger">Gagal menambahkan topik</div>');
				return redirect()->route('admin/topik/tambah');
			}
		}
	}

	public function edit_topik($slug_class, $slug_topic)
	{
		helper('form');
		$data = [
			'title' => 'Master Topik',
			'segment' => $this->request->uri->getSegments(),
			'listClasses' => $this->master->get_all('classes')->getResult(),
			'topic' => $this->master->get_topik_by_slug($slug_class, $slug_topic)->getRow(),
			'slug_class' => $slug_class,
			'slug_topic' => $slug_topic,
		];
		echo view('dashboard/master/topik/edit', $data);
	}

	public function proses_edit_topik($slug_class, $slug_topic)
	{
		helper('form');
		$validation = \Config\Services::validation();
		$input = [
			'class_id' => $this->request->getPost('class_id'),
			'topic_name' => $this->request->getPost('topic_name'),
			'number' => $this->request->getPost('number'),
			'content' => $this->request->getPost('content'),
		];
		if (!$validation->run($input, 'topic')) {
			helper('form');
			$data = [
				'title' => 'Master Topik',
				'segment' => $this->request->uri->getSegments(),
				'listClasses' => $this->master->get_all('classes')->getResult(),
				'topic' => $this->master->get_topik_by_slug($slug_class, $slug_topic)->getRow(),
				'slug_class' => $slug_class,
				'slug_topic' => $slug_topic,
			];
			echo view('dashboard/master/topik/edit', $data);
		} else {
			$input = [
				'class_id' => $this->request->getPost('class_id'),
				'topic_name' => $this->request->getPost('topic_name'),
				'number' => $this->request->getPost('number'),
				'slug' => url_title(strtolower($this->request->getPost('topic_name'))),
				'content' => $this->request->getPost('content'),
			];
			$getIdClasses = $this->master->get_field('classes', ['slug' => $slug_class])->getRow();
			$getIdTopics = $this->master->get_field('topics', ['class_id' => $getIdClasses->class_id, 'slug' => $slug_topic])->getRow();

			// FITUR NUMBERING UNTUK TOPIK

			// hitung topik yang nomornya >= dengan nomor yang diinput
			$count_data_topics = $this->master->count_data('topics', ['number >=' => $this->request->getPost('number'), 'class_id' => $getIdClasses->class_id]);
			// jika ada nomor yang lebih besar dari nomor yang diinput
			if ($count_data_topics > 0) {
				$get_all_number = $this->master->get_select('topics', 'topic_id, number', ['class_id' => $this->request->getPost('class_id'), 'number >=' => $this->request->getPost('number')])->getResult();
				$topic_id = [];
				$number = [];
				foreach ($get_all_number as $row) {
					$topic_id[] = $row->topic_id;
					$number[] = $row->number;
				}
				for ($i = 0; $i < $count_data_topics; $i++) {
					$data[$i] = [
						'topic_id' => $topic_id[$i],
						// semua nomor yang >= dari inputan number ditambah 1 agar tidak ada yang bentrok
						'number' => $number[$i] + 1
					];
				}
				$query = $this->master->update_data_batch('topics', $data, 'topic_id');
			}
			$query = $this->master->update_data('topics', ['topic_id' => $getIdTopics->topic_id], $input);
			if ($query) {
				session()->setFlashdata('message', '<div class="alert alert-success">Berhasil mengubah topik</div>');
				return redirect()->route('admin/topik');
			} else {
				session()->setFlashdata('message', '<div class="alert alert-danger">Gagal mengubah topik</div>');
				return redirect()->route('admin/topik/edit');
			}
		}
	}

	public function delete_topik($slug_class, $slug_topic)
	{
		// ambil id kelas dari slug kelas
		$getIdClasses = $this->master->get_field('classes', ['slug' => $slug_class])->getRow();
		// ambil id topik dari id kelas dan slug topik
		$getIdTopics = $this->master->get_field('topics', ['class_id' => $getIdClasses->class_id, 'slug' => $slug_topic])->getRow();
		// delete topik
		$query = $this->master->delete_data('topics', ['topic_id' => $getIdTopics->topic_id]);
		if ($query) {
			session()->setFlashdata('message', '<div class="alert alert-success">Berhasil menghapus topik</div>');
			return redirect()->route('admin/topik');
		} else {
			session()->setFlashdata('message', '<div class="alert alert-danger">Gagal menghapus topik</div>');
			return redirect()->route('admin/topik');
		}
	}

	public function user()
	{
		$data = [
			'title' => 'Master User',
			'segment' => $this->request->uri->getSegments(),
			'listUser' => $this->master->get_all('users')->getResult()
		];
		echo view('dashboard/master/user/view', $data);
	}

	public function paket()
	{
		$data = [
			'title' => 'Master Paket',
			'segment' => $this->request->uri->getSegments(),
			'segment' => $this->request->uri->getSegments(),
			'listPackage' => $this->master->get_package('packages')->getResult()
		];
		echo view('dashboard/master/paket/view', $data);
	}

	public function tambah_paket()
	{
		helper(['form', 'url']);
		$data = [
			'title' => 'Master Paket',
			'segment' => $this->request->uri->getSegments(),
			'listClass' => $this->master->get_all('classes')->getResult()
		];
		echo view('dashboard/master/paket/add', $data);
	}

	public function proses_tambah_paket()
	{
		helper(['form']);
		$validation = \Config\Services::validation();
		$input = [
			'package_name' => $this->request->getPost('package_name'),
			'class_id' => $this->request->getPost('class_id'),
			'price' => $this->request->getPost('price'),
			'img' => $this->request->getFile('img'),
			'detail' => $this->request->getPost('detail'),
			'duration' => $this->request->getPost('duration')
		];
		if (!$validation->run($input, 'package')) {
			helper(['form', 'url']);
			$data = [
				'title' => 'Master Paket',
				'segment' => $this->request->uri->getSegments(),
				'listClass' => $this->master->get_all('classes')->getResult()
			];
			echo view('dashboard/master/paket/add', $data);
		} else {
			// ambil id terakhir dari table paket
			$last_id = $this->master->get_last_insert_id('packages', 'package_id')->getRow();
			// simpan semua id kelas dalam array
			$class[] = $this->request->getPost('class_id');
			// jumlah data dlm array class
			$length_class = count($class);
			$data = [];
			// ambil nama gambar yg diinput
			$avatar = $this->request->getFile('img');
			// random nama gambar
			$name[0] = $avatar->getRandomName();
			$insert_package = array(
				'package_id' => $last_id->package_id + 1,
				'package_name' => $this->request->getPost('package_name'),
				'slug' => url_title(strtolower($this->request->getPost('package_name'))),
				'img' => $name[0],
				'price' => $this->request->getPost('price'),
				'detail' => $this->request->getPost('detail'),
				'duration' => $this->request->getPost('duration')
			);

			// upload gambar ke direktori public/assets/uploads/packages/
			$avatar->move('assets/uploads/packages/', $name[0]);
			// insert data paket ke table packages
			$query = $this->master->insert_data('packages', $insert_package);
			// jika insert berhasil 
			if ($query) {
				$package_id[0] = $insert_package['package_id'];
				for ($i = 0; $i <= $length_class; $i++) {
					$data[$i] = array(
						'package_id' => $package_id[0],
						'class_id' => $class[0][$i],
					);
				}
				// insert masing-masing id kelas sesuai id paket yang sudah diinput ke table class_packages
				$query = $this->master->insert_data_batch('class_packages', $data);

				if ($query) {
					session()->setFlashdata('message', '<div class="alert alert-success">Berhasil menambahkan paket</div>');
					return redirect()->route('admin/paket');
				} else {
					session()->setFlashdata('message', '<div class="alert alert-danger">Gagal menambahkan paket</div>');
					return redirect()->route('admin/paket/tambah');
				}
			} else {
				session()->setFlashdata('message', '<div class="alert alert-danger">Gagal menambahkan paket</div>');
				return redirect()->route('admin/paket/tambah');
			}
		}
	}

	public function edit_paket($slug)
	{
		helper('form');
		$data = [
			'title' => 'Master Paket',
			'segment' => $this->request->uri->getSegments(),
			'slug' => $slug,
			'package' => $this->master->get_to_edit_package(['packages.slug' => $slug])->getResult(),
			'listClass' => $this->master->get_all('classes')->getResult(),
		];
		echo view('dashboard/master/paket/edit', $data);
	}

	public function proses_edit_paket($slug)
	{
		helper(['form']);
		$validation = \Config\Services::validation();
		$input = [
			'package_name' => $this->request->getPost('package_name'),
			'class_id' => $this->request->getPost('class_id'),
			'price' => $this->request->getPost('price'),
			'duration' => $this->request->getPost('duration'),
			'detail' => $this->request->getPost('detail'),
		];
		if (!$validation->run($input, 'edit_package')) {
			helper('form');
			$data = [
				'title' => 'Master Paket',
				'segment' => $this->request->uri->getSegments(),
				'slug' => $slug,
				'package' => $this->master->get_field('packages', ['slug' => $slug])->getRow(),
				'class_package' => $this->master->get_field('packages', ['slug' => $slug])->getResult(),
				'listClass' => $this->master->get_all('classes')->getResult()
			];
			echo view('dashboard/master/paket/edit', $data);
		} else {
			// ambil data paket berdasarkan slug
			$package = $this->master->get_field('packages', ['slug' => $slug])->getRow();
			// hitung jumlah kelas dari paket tersebut
			$count_data_db = $this->master->count_data('class_packages', ['package_id' => $package->package_id]);
			// hitung jumlah id kelas yang diinput
			$length_class = count($this->request->getPost('class_id'));
			// ambil nama gambar yg diinput
			$avatar = $this->request->getFile('img');
			// random nama gambar
			$name[0] = $avatar->getRandomName();
			// simpan semua id kelas ke dalam array
			$class[] = $this->request->getPost('class_id');
			$update_class = [];
			$insert_class = [];
			// ambil nama gambar dari paket yang akan diedit
			$file_name = $this->master->get_select('packages', 'img', ['slug' => $slug])->getRow()->img;

			// jika jumlah id kelas di table class_packages < jumlah id kelas yang diinput
			// update satu per satu id kelas di table class_packages
			// kemudian insert id kelas (karena jumlah di db < jumlah inputan)
			if ($count_data_db < $length_class) {
				$class_packages = $this->master->get_field('class_packages', ['package_id' => $package->package_id])->getResult();
				$class_package_id = [];
				foreach ($class_packages as $row) {
					$class_package_id[] = $row->class_package_id;
				}
				if ($avatar->getName() == '') {
					$update_package = array(
						'package_name' => $this->request->getPost('package_name'),
						'slug' => url_title(strtolower($this->request->getPost('package_name'))),
						'price' => $this->request->getPost('price'),
						'detail' => $this->request->getPost('detail'),
						'duration' => $this->request->getPost('duration'),
					);

					for ($i = 0; $i <= ($count_data_db - 1); $i++) {
						$update_class[$i] = array(
							'class_package_id' => $class_package_id[$i],
							'package_id' => $package->package_id,
							'class_id' => $class[0][$i],
						);
					}
					for ($i = $count_data_db; $i <= ($length_class - 1); $i++) {
						$insert_class[$i] = array(
							'package_id' => $package->package_id,
							'class_id' => $class[0][$i],
						);
					}
				} else {
					if ($file_name != NULL) {
						unlink('assets/uploads/packages/' . $file_name);
					}
					$update_package = array(
						'package_name' => $this->request->getPost('package_name'),
						'slug' => url_title(strtolower($this->request->getPost('package_name'))),
						'price' => $this->request->getPost('price'),
						'detail' => $this->request->getPost('detail'),
						'duration' => $this->request->getPost('duration'),
						'img' => $name[0]
					);
					for ($i = 0; $i <= ($count_data_db - 1); $i++) {
						$update_class[$i] = array(
							'class_package_id' => $class_package_id[$i],
							'package_id' => $package->package_id,
							'class_id' => $class[0][$i],
						);
					}
					for ($i = $count_data_db; $i <= ($length_class - 1); $i++) {
						$insert_class[$i] = array(
							'package_id' => $package->package_id,
							'class_id' => $class[0][$i],
						);
					}
					$avatar->move('assets/uploads/packages/', $name[0]);
				}
				$query_update_package = $this->master->update_data('packages', ['package_id' => $package->package_id], $update_package);
				if ($query_update_package) {
					if ($class_package_id[0] == $update_class[0]['class_package_id']) {
						$query = $this->master->update_data_batch('class_packages', $update_class, 'class_package_id');
						$query = $this->master->insert_data_batch('class_packages', $insert_class);
					} else {
						$query = $this->master->update_data_batch('class_packages', $update_class, 'class_package_id');
						$query = $this->master->insert_data_batch('class_packages', $insert_class);
					}
				}
			} else if ($count_data_db > $length_class) {
				// jika jumlah id kelas di table class_packages > jumlah id kelas yang diinput
				// masukkan semua id kelas yang ada di class_packages dan id kelas yang diinput ke dalam array
				// cek id kelas yang hanya ada di array yang menampung data dari db
				// hapus id kelas tersebut
				// kemudian update semua id kelas dari paket tersebut
				$class_packages = $this->master->get_field('class_packages', ['package_id' => $package->package_id])->getResult();
				$class_id = [];
				foreach ($class_packages as $row) {
					$class_id[] = $row->class_id;
				}
				$diff = array_diff($class_id, $class[0]);
				$arr_diff = [];
				foreach ($diff as $row) {
					$arr_diff[] = $row;
				};
				$delete = $this->master->delete_array('class_packages', 'class_id', $arr_diff);
				if ($delete) {
					$class_packages = $this->master->get_field('class_packages', ['package_id' => $package->package_id])->getResult();
					$class_package_id = [];
					foreach ($class_packages as $row) {
						$class_package_id[] = $row->class_package_id;
					}
				}
				if ($avatar->getName() == '') {
					$update_package = array(
						'package_name' => $this->request->getPost('package_name'),
						'slug' => url_title(strtolower($this->request->getPost('package_name'))),
						'price' => $this->request->getPost('price'),
						'detail' => $this->request->getPost('detail'),
						'duration' => $this->request->getPost('duration'),
					);
					for ($i = 0; $i <= ($length_class - 1); $i++) {
						$update_class[$i] = array(
							'class_package_id' => $class_package_id[$i],
							'package_id' => $package->package_id,
							'class_id' => $class[0][$i],
						);
					}
				} else {
					$file_name = $this->master->get_field('packages', ['slug' => $slug])->getRow()->img;
					if ($file_name != NULL) {
						unlink('assets/uploads/packages/' . $file_name);
					}
					$update_package = array(
						'package_name' => $this->request->getPost('package_name'),
						'slug' => url_title(strtolower($this->request->getPost('package_name'))),
						'price' => $this->request->getPost('price'),
						'detail' => $this->request->getPost('detail'),
						'duration' => $this->request->getPost('duration'),
						'img' => $name[0]
					);
					for ($i = 0; $i <= ($length_class - 1); $i++) {
						$update_class[$i] = array(
							'class_package_id' => $class_package_id[$i],
							'package_id' => $package->package_id,
							'class_id' => $class[0][$i],
						);
					}
					$avatar->move('assets/uploads/packages/', $name[0]);
				}
				$query = $this->master->update_data('packages', ['slug' => $slug], $update_package);

				$query = $this->master->update_data_batch('class_packages', $update_class, 'class_package_id');
				$query = TRUE;
			} else if ($count_data_db == $length_class) {
				// jika jumlah id kelas di table class_packages == jumlah id kelas yang diinput
				// update semua id kelas dari paket tersebut
				$class_packages = $this->master->get_field('class_packages', ['package_id' => $package->package_id])->getResult();
				$class_package_id = [];
				$package_id = [];
				foreach ($class_packages as $row) {
					$class_package_id[] = $row->class_package_id;
					$package_id[] = $row->package_id;
				}
				if ($avatar->getName() == '') {
					$update_package = array(
						'package_name' => $this->request->getPost('package_name'),
						'slug' => url_title(strtolower($this->request->getPost('package_name'))),
						'price' => $this->request->getPost('price'),
						'detail' => $this->request->getPost('detail'),
						'duration' => $this->request->getPost('duration'),
					);
					for ($i = 0; $i <= ($length_class - 1); $i++) {
						$update_class[$i] = array(
							'class_package_id' => $class_package_id[$i],
							'package_id' => $package->package_id,
							'class_id' => $class[0][$i],
						);
					}
				} else {
					$file_name = $this->master->get_field('packages', ['slug' => $slug])->getRow()->img;
					if ($file_name != NULL) {
						unlink('assets/uploads/packages/' . $file_name);
					}
					$update_package = array(
						'package_name' => $this->request->getPost('package_name'),
						'slug' => url_title(strtolower($this->request->getPost('package_name'))),
						'price' => $this->request->getPost('price'),
						'detail' => $this->request->getPost('detail'),
						'duration' => $this->request->getPost('duration'),
						'img' => $name[0]
					);
					for ($i = 0; $i <= ($length_class - 1); $i++) {
						$update_class[$i] = array(
							'class_package_id' => $class_package_id[$i],
							'package_id' => $package->package_id,
							'class_id' => $class[0][$i],
						);
					}
					$avatar->move('assets/uploads/packages/', $name[0]);
				}

				$query = $this->master->update_data('packages', ['slug' => $slug], $update_package);
				$query = $this->master->update_data_batch('class_packages', $update_class, 'class_package_id');
				$query = TRUE;
			}

			if ($query) {
				session()->setFlashdata('message', '<div class="alert alert-success">Berhasil mengedit paket</div>');
				return redirect()->route('admin/paket');
			} else {
				session()->setFlashdata('message', '<div class="alert alert-danger">Gagal mengedit paket</div>');
				return $this->response->redirect(site_url('admin/paket/edit/' . $slug));
			}
		}
	}

	public function delete_paket($slug)
	{
		// nama gambar
		$file_name = $this->master->get_field('packages', ['slug' => $slug])->getRow()->img;
		// hapus gambar di direktori public/assets/uploads/packages
		unlink('assets/uploads/packages/' . $file_name);

		$query = $this->master->delete_data('packages', ['slug' => $slug]);
		if ($query) {
			session()->setFlashdata('message', '<div class="alert alert-success">Berhasil menghapus paket</div>');
			return redirect()->route('admin/paket');
		} else {
			session()->setFlashdata('message', '<div class="alert alert-danger">Gagal menghapus paket</div>');
			return redirect()->route('admin/paket');
		}
	}

	public function diskon()
	{
		$data = [
			'title' => 'Diskon',
			'segment' => $this->request->uri->getSegments(),
			'discounts' => $this->master->get_select('discounts', 'promo_code, discount, from, to', [])->getResult()
		];
		echo view('dashboard/master/diskon/view', $data);
	}

	public function tambah_diskon()
	{
		helper('form');
		$data = [
			'title' => 'Tambah Diskon',
			'segment' => $this->request->uri->getSegments(),
		];
		echo view('dashboard/master/diskon/add', $data);
	}

	public function proses_tambah_diskon()
	{
		helper('form');
		$validation = \Config\Services::validation();
		$input = [
			'promo_code' => $this->request->getPost('promo_code'),
			'discount' => $this->request->getPost('discount'),
			'from' => $this->request->getPost('from'),
			'to' => $this->request->getPost('to'),
		];
		// validasi inputan
		if (!$validation->run($input, 'promo')) {
			helper('form');
			$data = [
				'title' => 'Master Diskon',
				'segment' => $this->request->uri->getSegments(),
			];
			echo view('dashboard/master/diskon/add', $data);
		} else {
			// cek apakah ada kode promo yang sama di db
			$check = $this->master->get_select('discounts', 'promo_code', ['promo_code' => $this->request->getPost('promo_code')])->getRow();
			// jika tidak ada
			if (!$check) {
				// insert ke db
				$query = $this->master->insert_data('discounts', $input);
				if ($query) {
					session()->setFlashdata('message', '<div class="alert alert-success">Berhasil menambahkan promo</div>');
					return redirect()->route('admin/diskon');
				} else {
					session()->setFlashdata('message', '<div class="alert alert-danger">Gagal menambahkan promo</div>');
					return redirect()->route('admin/diskon/tambah');
				}
			} else {
				session()->setFlashdata('message', '<div class="alert alert-danger">Kode promo sudah ada</div>');
				return redirect()->route('admin/diskon/tambah');
			}
		}
	}

	public function edit_diskon($code)
	{
		helper('form');
		$data = [
			'title' => 'Tambah Diskon',
			'segment' => $this->request->uri->getSegments(),
			'discount' => $this->master->get_select('discounts', 'promo_code, discount, from, to', ['promo_code' => $code])->getRow()
		];
		echo view('dashboard/master/diskon/edit', $data);
	}

	public function proses_edit_diskon($code)
	{
		helper('form');
		$validation = \Config\Services::validation();
		$input = [
			'promo_code' => $this->request->getPost('promo_code'),
			'discount' => $this->request->getPost('discount'),
			'from' => $this->request->getPost('from'),
			'to' => $this->request->getPost('to'),
		];
		// validasi inputan
		if (!$validation->run($input, 'promo')) {
			helper('form');
			$data = [
				'title' => 'Master Diskon',
				'segment' => $this->request->uri->getSegments(),
			];
			echo view('dashboard/master/diskon/add', $data);
		} else {
			$query = $this->master->update_data('discounts', ['promo_code' => $code], $input);
			if ($query) {
				session()->setFlashdata('message', '<div class="alert alert-success">Berhasil mengubah promo</div>');
				return redirect()->route('admin/diskon');
			} else {
				session()->setFlashdata('message', '<div class="alert alert-danger">Gagal mengubah promo</div>');
				return redirect()->route('admin/diskon/edit');
			}
		}
	}

	public function delete_diskon($code)
	{
		$query = $this->master->delete_data('discounts', ['promo_code' => $code]);
		if ($query) {
			session()->setFlashdata('message', '<div class="alert alert-success">Berhasil menghapus promo</div>');
			return redirect()->route('admin/diskon');
		} else {
			session()->setFlashdata('message', '<div class="alert alert-danger">Gagal menghapus promo</div>');
			return redirect()->route('admin/diskon');
		}
	}

	public function transaksi()
	{
		$data = [
			'title' => 'Transaksi',
			'segment' => $this->request->uri->getSegments(),
			'transaksi' => $this->master->get_transaksi()->getResult(),
		];
		echo view('dashboard/transaksi', $data);
	}

	public function verify_payment($id)
	{
		// ambil email user dari id user di table transactions
		$user = $this->master->get_join('transactions', 'users.email', 'users', 'users.user_id=transactions.user_id', ['transactions.transaction_id' => $id])->getRow();

		// START BUAT TOKEN AIKTIVASI
		$seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
		shuffle($seed);
		$rand = '';
		foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];
		
		$data = [
			'waiting_confirmation' => '0',
			'is_paid' => '1',
			'payment_date' => date('Y-m-d h:i:s'),
			'course_end_date' => date('Y-m-d H:i:s', time() + (60 * 60 * 24 * 30)), 
			'token' => $rand
		];
		$query = $this->master->update_data('transactions', ['transaction_id' => $id], $data);
		// END BUAT TOKEN AIKTIVASI

		if ($query) {
			// kirim token ke email
			$email = \Config\Services::email();
			$config = [
				'mailType'  => 'html',
				'charset'   => 'utf-8',
				'protocol'  => 'smtp',
				'SMTPHost' => 'smtp.gmail.com',
				'SMTPUser' => 'francescovanboteng@gmail.com',  // Email gmail
				'SMTPPass'   => 'd1d1nw0lescuy',  // Password gmail
				'smtpCrypto' => 'ssl',
				'smtpPort'   => 465,
				'CRLF'    => "\r\n",
				'newline' => "\r\n"
			];
			$email->initialize($config);
			$email->setFrom('francescovanboteng@gmail.com', 'OL Course');
			$email->setTo($user->email);

			$email->setSubject('Token kamu');
			$email->setMessage('
			<p>Terima kasih telah melakukan pembayaran. Silahkan redeem token di bawah ini di halaman redeem.</p>
			<p style="color:red;"><b>' . $rand . '</b></p>
			');

			if ($email->send()) {
				session()->setFlashdata('message', '<div class="alert alert-success">Proses transaksi berhasil!</div>');
				return redirect()->route('admin/transaksi');
			} else {
				echo $email->printDebugger(['headers']);
				echo $email->printDebugger(['subject']);
				echo $email->printDebugger(['body']);
			}
		} else {
			session()->setFlashdata('message', '<div class="alert alert-danger">Proses transaksi gagal</div>');
			return redirect()->route('admin/transaksi');
		}
	}
}
