<?php namespace Config;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var array
	 */
	public $ruleSets = [
		\CodeIgniter\Validation\Rules::class,
		\CodeIgniter\Validation\FormatRules::class,
		\CodeIgniter\Validation\FileRules::class,
		\CodeIgniter\Validation\CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------

	public $login = [
		'email' => 'required|min_length[3]|max_length[50]',
		'password' => 'required|min_length[3]|max_length[255]'
	];
	public $login_errors = [
		'email' => [
			'required' => 'wajib diisi',
			'min_length' => 'minimal 3 karakter',
			'max_length' => 'maksimal 50 karakter',
		],
		'password' => [
			'required' => 'wajib diisi',
			'min_length' => 'minimal 3 karakter',
			'max_length' => 'maksimal 255 karakter',
		]
	];

	public $register = [
		'full_name' => 'required|min_length[3]|max_length[100]',
		'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
		'email' => 'required|min_length[10]|max_length[50]|is_unique[users.email]',
		'password' => 'required|min_length[3]|max_length[255]',
		're_password' => 'required|min_length[3]|max_length[255]|matches[password]',
	];
	public $register_errors = [
		'full_name' => [
			'required' => 'wajib diisi',
			'min_length' => 'minimal 3 karakter',
			'max_length' => 'maksimal 100 karakter',
		],
		'username' => [
			'required' => 'wajib diisi',
			'min_length' => 'minimal 3 karakter',
			'max_length' => 'maksimal 50 karakter',
			'is_unique' => 'username sudah digunakan',
		],
		'email' => [
			'required' => 'wajib diisi',
			'min_length' => 'minimal 10 karakter',
			'max_length' => 'maksimal 50 karakter',
			'is_unique' => 'email sudah digunakan',
		],
		'password' => [
			'required' => 'wajib diisi',
			'min_length' => 'minimal 3 karakter',
			'max_length' => 'maksimal 255 karakter',
		],
		're_password' => [
			'required' => 'wajib diisi',
			'min_length' => 'minimal 3 karakter',
			'max_length' => 'maksimal 50 karakter',
			'matches' => 'password tidak cocok',
		],
	];

	public $forgot = [
		'email' => 'required|min_length[10]|max_length[50]'
	];

	public $forgot_errors = [
		'email' => [
			'required' => 'wajib diisi',
			'min_length' => 'minimal 10 karakter',
			'max_length' => 'maksimal 50 karakter',
		],
	];

	public $new_password = [
		'password' => 'required|min_length[3]|max_length[255]',
		're_password' => 'required|min_length[3]|max_length[255]|matches[password]',
	];

	public $new_password_errors = [
		'password' => [
			'required' => 'wajib diisi',
			'min_length' => 'minimal 3 karakter',
			'max_length' => 'maksimal 255 karakter',
		],
		're_password' => [
			'required' => 'wajib diisi',
			'min_length' => 'minimal 3 karakter',
			'max_length' => 'maksimal 50 karakter',
			'matches' => 'password tidak cocok',
		],
	];

	public $class = [
		'class_name' => 'required|min_length[3]|max_length[100]',
		'price' => 'required|min_length[4]|max_length[7]',
		'img' => 'uploaded[img]|mime_in[img,image/jpg,image/jpeg,image/gif,image/png]|max_size[img,4096]',
		'duration' => 'required',
		'detail' => 'required',
	];

	public $class_errors = [
		'class_name' => [
			'required' => 'wajib diisi',
			'min_length' => 'minimal 3 karakter',
			'max_length' => 'maksimal 100 karakter',
		],
		'price' => [
			'required' => 'wajib diisi',
			'min_length' => 'minimal 4 karakter',
			'max_length' => 'maksimal 7 karakter',
		],
		'img' => [
			'uploaded' => 'upload',
			'mime_in' => 'tidak valid',
			'max_size' => 'melebihi batas'
		],
		'duration' => [
			'required' => 'wajib diisi'
		],
		'detail' => [
			'required' => 'wajib diisi',
		],
	];

	
	public $edit_class = [
		'class_name' => 'required|min_length[3]|max_length[100]',
		'price' => 'required|min_length[4]|max_length[7]',
		'duration' => 'required',
		'detail' => 'required',
	];

	public $edit_class_errors = [
		'class_name' => [
			'required' => 'wajib diisi',
			'min_length' => 'minimal 3 karakter',
			'max_length' => 'maksimal 100 karakter',
		],
		'price' => [
			'required' => 'wajib diisi',
			'min_length' => 'minimal 4 karakter',
			'max_length' => 'maksimal 7 karakter',
		],
		'duration' => [
			'required' => 'wajib diisi'
		],
		'detail' => [
			'required' => 'wajib diisi',
		],
	];

	public $topic = [
		'class_id' => 'required',
		'topic_name' => 'required|min_length[3]|max_length[255]',
		'number' => 'required|is_natural_no_zero',
		'content' => 'required',
	];

	public $topic_errors = [
		'class_id' => [
			'required' => 'wajib diisi',
		],
		'topic_name' => [
			'required' => 'wajib diisi',
			'min_length' => 'Minimal 3 karakter',
			'max_length' => 'Maksimal 255 karakter',
		],
		'number' => [
			'required' => 'wajib diisi',
			'is_natural_no_zero' => 'hanya angka: 1,2,3, dst',
		],
		'content' => [
			'required' => 'wajib diisi',
		],
	];

	public $package = [
		'package_name' => 'required|min_length[5]|max_length[100]',
		'class_id' => 'required',
		'price' => 'required',
		'detail' => 'required',
		'img' => 'uploaded[img]|mime_in[img,image/jpg,image/jpeg,image/gif,image/png]|max_size[img,4096]',
		'duration' => 'required'
	];

	public $package_errors = [
		'package_name' => [
			'required' => 'wajib diisi',
			'min_length' => 'Minimal 5 karakter',
			'max_length' => 'Maksimal 100 karakter',
		],
		'class_id' => [
			'required' => 'wajib diisi',
		],
		'price' => [
			'required' => 'wajib diisi',
		],
		'detail' => [
			'required' => 'wajib diisi',
		],
		'img' => [
			'uploaded' => 'upload',
			'mime_in' => 'tidak valid',
			'max_size' => 'melebihi batas'
		],
		'duration' => [
			'required' => 'wajib diisi'
		]
	];

	public $edit_package = [
		'package_name' => 'required|min_length[5]|max_length[100]',
		'class_id' => 'required',
		'price' => 'required',
		'duration' => 'required'
	];

	public $edit_package_errors = [
		'package_name' => [
			'required' => 'wajib diisi',
			'min_length' => 'Minimal 5 karakter',
			'max_length' => 'Maksimal 100 karakter',
		],
		'class_id' => [
			'required' => 'wajib diisi',
		],
		'price' => [
			'required' => 'wajib diisi',
		],
		'duration' => [
			'required' => 'wajib diisi'
		]
	];

	public $promo = [
		'promo_code' => 'required|max_length[15]',
		'discount' => 'required',
		'from' => 'required|valid_date',
		'to' => 'required|valid_date'
	];

	public $promo_errors = [
		'promo_code' => [
			'required' => 'wajib diisi',
			'max_length' => 'Maksimal 15 karakter',
		],
		'discount' => [
			'required' => 'wajib diisi',
		],
		'from' => [
			'required' => 'wajib diisi',
			'valid_date' => 'tanggal tidak valid'
		],
		'to' => [
			'required' => 'wajib diisi',
			'valid_date' => 'tanggal tidak valid'
		]
	];

	public $invoice = [
		'invoice_id' => 'required|min_length[12]|max_length[12]'
	];

	public $invoice_errors = [
		'invoice_id' => [
			'required' => 'wajib diisi',
			'min_length' => 'Id invoice harus 12 digit tanpa tanda pagar (#)',
			'max_length' => 'Id invoice harus 12 digit tanpa tanda pagar (#)',
		]
	];
}
